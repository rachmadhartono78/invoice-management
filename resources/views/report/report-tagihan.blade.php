@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tagihan Vendor')
@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Tagihan Vendor</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">List</a>
        </li>
    </ol>
</nav>

{{-- Card --}}
<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_purchase_order">0</h3>
                            <p class="mb-0">Purchase Order</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1 purchase_order_paid">Rp. 0</h3>
                            <p class="mb-0">Terbayarkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Datatables --}}
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="list-tagihan-table table">
        </table>
    </div>
</div>

@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status"><span class="sr-only">Loading...</span></div>`;

    let account = {!! json_encode(session('data')) !!}
    let buttonAdd = [];
    setHeader();
    function setHeader() {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/purchase-order/report',
            type: "GET",
            dataType: "json",
            success: function(res) {
                console.log(res);
                $('.count_vendor').html(res.count_vendor);
                $('.count_purchase_order').html(res.count_purchase_order);
                $('.purchase_order_paid').html('Rp. ' + parseInt(res.count_purchase_order_paid).toLocaleString('en-US'));
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    const startDefault = moment().startOf('month').format('YYYY-MM-DD');
    const endDefault = moment().endOf('month').format('YYYY-MM-DD');
    let queryParamsDefault = [];
    queryParamsDefault.push('start_date=' + startDefault);
    queryParamsDefault.push('end_date=' + endDefault);
    let baseUrlDefault = "{{ url('request/purchase-order/data-purchase-order') }}";
    let fullUrlDefault = baseUrlDefault + '?' + queryParamsDefault.join('&');
    table(fullUrlDefault);
    function table(param){
        let url = '';
        if(param){
            url =  {
                url: param,
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".list-tagihan-table").DataTable().page.info().page + 1;
                }
            }
        }else{
            url =  {
                url: "{{ url('request/purchase-order/data-purchase-order') }}",
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".list-tagihan-table").DataTable().page.info().page + 1;
                }
            }
        }
        let opt = {
            ajax: url,
            serverSide: true,
        }

        var el = $(".list-tagihan-table");
        var e = el.DataTable(Object.assign(opt,{
            responsive: true,
            bDestroy: true,
            processing: true,
            deferRender: true,
            columns: [{
                name: "No. PO",
                data: "purchase_order_number",
                title: "No. PO",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, {
                name: "Vendor",
                data: "vendor",
                title: "Vendor",
                className: 'text-center',
                render: function(data, type, row) {
                    return data.name ? data.name : '';
                }
            }, {
                name: "Perihal",
                data: "about",
                title: "Perihal",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, {
                name: "Total",
                data: "grand_total",
                title: "Total",
                className: 'text-center',
                render: function(data, type, row) {
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(data)
                }
            }, {
                name: "Tanggal PO",
                data: "purchase_order_date",
                title: "Tanggal PO",
                className: 'text-center',
                render: function(data, type, full, meta) {
                    var tanggalAwal = data;

                    var bagianTanggal = tanggalAwal.split('-');
                    var tahun = bagianTanggal[0];
                    var bulan = bagianTanggal[1];
                    var hari = bagianTanggal[2];

                    var tanggalHasil = hari + '/' + bulan + '/' + tahun;

                    return tanggalHasil;
                }
            }, {
                class: "text-center",
                data: "status",
                name: "status",
                title: "Status",
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 'Terbuat') {
                        return '<span class="badge w-100" style="background-color : #BFBFBF; " text-capitalized> Terbuat </span>';
                    } else if (data == 'Disetujui KA') {
                        return '<span class="badge w-100" style="background-color : #4EC0D9; " text-capitalized> Disetujui KA </span>';
                    } else if (data == 'Lunas') {
                        return '<span class="badge w-100" style="background-color : #74D94E; " text-capitalized> Lunas </span>';
                    } else if (data == 'Terkirim') {
                        return '<span class="badge w-100" style="background-color : #FF87A7; " text-capitalized> Terkirim </span>';
                    } else if (data == 'Disetujui BM') {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " text-capitalized> Disetujui BM </span>';
                    }else if (data == 'Selesai') {
                        return '<span class="badge w-100 bg-info" text-capitalized> Selesai </span>'
                    } else if (data == 'Diupload Vendor') {
                        return '<span class="badge w-100 bg-primary" text-capitalized> Diupload Vendor </span>'
                    }
                }
            }],
            order: [
                [0, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end  flex-md-row pe-3 gap-md-3"f<"invoice_status d-flex mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><" col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Purchase Order",
            },
            buttons: buttonAdd,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(a) {
                            return "Detail"
                        }
                    }),
                    type: "column",
                    renderer: function(a, e, t) {

                        var s = $.map(t, (function(a, e) {
                            return "" !== a.title ? '<tr data-dt-row="' + a
                                .rowIndex + '" data-dt-column="' + a
                                .columnIndex + '"><td>' + a.title +
                                ":</td> <td>" + a.data + "</td></tr>" : ""
                        })).join("");
                        return !!s && $('<table class="table"/><tbody />').append(s)
                    }
                }
            },
            initComplete: function() {
                this.api().columns(5).every((function() {
                    var a = this,
                        lsp = $(
                            '<select id="UserRole" class="form-select" style="width: 180px"><option value=""> Semua Status </option><option value="Terbuat">Terbuat</option><option value="disetujui ka">Disetujui KA</option><option value="disetujui bm">Disetujui BM</option><option value="terkirim">Terkirim</option>+<option value="di upload vendor">Diupload Vendor</option>+<option value="Diverifikasi Admin">Diverifikasi Admin</option><option value="selesai">Selesai</option></select>'
                        ).appendTo(".invoice_status").on("change", (
                            function() {
                                let value = $('input[type="search"]').val();
                                let status = $(this).val();
                                let date_range = $('#date_select').val();
                                let dates = date_range.split(' - ');
                                let start = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
                                let end = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');
                                let queryParams = [];
                                if (status) {
                                    queryParams.push('status=' + encodeURIComponent(status));
                                }
                                if (value) {
                                    queryParams.push('value=' + encodeURIComponent(value));
                                }
                                queryParams.push('start_date=' + start);
                                queryParams.push('end_date=' + end);
                                let baseUrl = "{{ url('request/purchase-order/data-purchase-order') }}";
                                let fullUrl = baseUrl + '?' + queryParams.join('&');
                                table(fullUrl);
                            })
                        ),
                        f =  $(
                            '<input class="form-select ms-2" type="text" id="date_select" value="Select Date" style="width: 240px"></input>'
                        ).appendTo(".invoice_status")

                        $(document).on('click', '.applyBtn', function(e) {
                            e.stopPropagation();
                            let value = $('input[type="search"]').val();
                            let status = $('#UserRole').val();
                            let date_range = $('#date_select').val();
                            let dates = date_range.split(' - ');
                            let start = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
                            let end = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');
                            let queryParams = [];
                            if (status) {
                                queryParams.push('status=' + encodeURIComponent(status));
                            }
                            if (value) {
                                queryParams.push('value=' + encodeURIComponent(value));
                            }
                            queryParams.push('start_date=' + start);
                            queryParams.push('end_date=' + end);
                            let baseUrl = "{{ url('request/purchase-order/data-purchase-order') }}";
                            let fullUrl = baseUrl + '?' + queryParams.join('&');
                            table(fullUrl);
                        })

                    
                        let gcr =  $(
                           `<button class="btn btn-sm btn-primary ms-2 w-100"><span class="d-md-inline-block d-none">Download .XLSX</span></button>`
                        ).appendTo(".invoice_status").on("click", () => {
                            let value = $('input[type="search"]').val();
                            let status = $('#UserRole').val();
                            let date_range = $('#date_select').val();
                            let dates = date_range.split(' - ');
                            let start_date = moment(dates[0], 'DD/MM/YYYY');
                            let end_date = moment(dates[1], 'DD/MM/YYYY');
                            let diffDays = end_date.diff(start_date, 'days');
                            if (diffDays > 31) {
                                return Swal.fire({
                                    title: 'Oops',
                                    text: 'Maximum download report 30 hari',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(async function(res) {
                                    Swal.close();
                                });
                            }
                            let queryParams = [];
                            if (status) {
                                queryParams.push('status=' + encodeURIComponent(status));
                            }
                            if (value) {
                                queryParams.push('value=' + encodeURIComponent(value));
                            }
                            let start = moment(dates[0], 'DD/MM/YYYY').format('YYYY-MM-DD');
                            let end = moment(dates[1], 'DD/MM/YYYY').format('YYYY-MM-DD');
                            queryParams.push('start=' + encodeURIComponent(start));
                            queryParams.push('end=' + encodeURIComponent(end));
                            let baseUrl = "{{ url('report/report-tagihan/file-export') }}";
                            let fullUrl = baseUrl + '?' + queryParams.join('&');
                            window.location.href = fullUrl;
                           
                        })
                        let urlParams = '';
                        let status = '';
                        let start_date = '';
                        let end_date = '';
                        if(param != null) {
                            urlParams = new URLSearchParams(param.split('?')[1]);
                            status = urlParams.get('status');
                            start_date = urlParams.get('start_date');
                            end_date = urlParams.get('end_date');
                        }
                        $('#UserRole').val(status);
                        if (start_date != '') {
                            $('#date_select').daterangepicker({
                                startDate: moment(start_date, 'YYYY-MM-DD').format('DD/MM/YYYY'),
                                endDate: moment(end_date, 'YYYY-MM-DD').format('DD/MM/YYYY'),
                                opens: 'left',
                                locale: {
                                    format: 'DD/MM/YYYY'
                                }
                            });
                        }else{
                            $('#date_select').daterangepicker({
                                startDate: moment().startOf('month'),
                                endDate: moment().endOf('month'),
                                opens: 'left',
                                locale: {
                                    format: 'DD/MM/YYYY'
                                }
                            });
                        }
                }))
            }
        }));
    }
</script>
{{-- <script>
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let account = {!! json_encode(session('data')) !!}
    let table = '';
    var getDaysBetweenDates = function(startDate, endDate) {
        var now = startDate.clone(), dates = [];
  
        while (now.isSameOrBefore(endDate)) {
            var numb = now.format('YYYY-MM-DD')
            dates.push(numb);
            now.add(1, 'days');
        }
        return dates;
    };
    table = "{{ url('vendor/data-tagihan-vendor') }}";
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    $((function() {
        let buttonAdd = [];
        var a = $(".list-vendor-table");
        if (a.length) var e = a.DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: table,
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".list-vendor-table").DataTable().page.info().page + 1;
                }
            },
            columns: [{
                name: "No. PO",
                data: "purchase_order_number",
                title: "No. PO",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, 
            {
                name: "Tanggal PO",
                data: "purchase_order_date",
                title: "Tanggal PO",
                className: 'tgl_po',
                render: function(data, type, full, meta) {
                    var tanggalAwal = data;
                    var bagianTanggal = tanggalAwal.split('-');
                    var tahun = bagianTanggal[0];
                    var bulan = bagianTanggal[1];
                    var hari = bagianTanggal[2];

                    var tanggalHasil = hari + '/' + bulan + '/' + tahun;

                    return tanggalHasil;
                }
            }, 
            {
                name: "vendor_name",
                data: "vendor",
                title: "Perusahaan",
                className: 'text-center',
                render: function(data, type, row) {
                    return data.name ? data.name : '';
                }
            }, {
                name: "Perihal",
                data: "about",
                title: "Perihal",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, {
                name: "grand_total",
                data: "grand_total",
                title: "Total Tagihan",
                className: 'text-center',
                render: function(data, type, row) {
                    return new Intl.NumberFormat("id-ID", {
                        style: "currency",
                        currency: "IDR"
                    }).format(data)
                }
            },
        ],
            order: [
                [0, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end  flex-md-row pe-3 gap-md-3"f<"invoice_status d-flex mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><" col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Invoice",
            },
            buttons: buttonAdd,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(a) {
                            return "Detail"
                        }
                    }),
                    type: "column",
                    renderer: function(a, e, t) {

                        var s = $.map(t, (function(a, e) {
                            return "" !== a.title ? '<tr data-dt-row="' + a
                                .rowIndex + '" data-dt-column="' + a
                                .columnIndex + '"><td>' + a.title +
                                ":</td> <td>" + a.data + "</td></tr>" : ""
                        })).join("");
                        return !!s && $('<table class="table"/><tbody />').append(s)
                    }
                }
            },
            initComplete: function() {
                this.api().columns(5).every((function() {
                    var a = this,
                        e = $(
                            '<select id="status" class="form-select" style="width:180px"><option value=""> Select Status </option></select>'
                        ).appendTo(".invoice_status").on("change");
                            var optionsHtml =   '<option value="Terbuat">Terbuat</option>' +
                                                '<option value="disetujui ka">Disetujui KA</option>' +
                                                '<option value="disetujui bm">Disetujui BM</option>' +
                                                '<option value="terkirim">Terkirim</option>'+
                                                '<option value="di upload vendor">Diupload Vendor</option>'+
                                                '<option value="Diverifikasi Admin">Diverifikasi Admin</option>' +
                                                '<option value="selesai">Selesai</option>';
                            e.append(optionsHtml);
                        let f =  $(
                            '<input class="form-select ms-2" type="text" id="date_select" value="Select Date" style="width: 240px"></input>'
                        ).appendTo(".invoice_status")

                        $(document).on('click', '.applyBtn', function(e) {
                            e.stopPropagation();
                            let value = $('input[type="search"]').val();
                            let status = $('#UserRole').val();
                            let date_range = $('#date_select').val();
                            let dates = date_range.split(' - ');
                            let start = moment(dates[0], 'MM/DD/YYYY').format('YYYY-MM-DD');
                            let end = moment(dates[1], 'MM/DD/YYYY').format('YYYY-MM-DD');
                            let queryParams = [];
                            if (status) {
                                queryParams.push('status=' + encodeURIComponent(status));
                            }
                            if (value) {
                                queryParams.push('value=' + encodeURIComponent(value));
                            }
                            queryParams.push('start=' + start);
                            queryParams.push('end=' + end);
                            let baseUrl = "{{ url('invoice/data-invoice') }}";
                            let fullUrl = baseUrl + '?' + queryParams.join('&');
                            load_table(fullUrl);
                        })

                    
                        let gcr =  $(
                           `<button class="btn btn-sm btn-primary ms-2 w-100"><span class="d-md-inline-block d-none">Download .XLSX</span></button>`
                        ).appendTo(".invoice_status").on("click", () => {
                            let value = $('input[type="search"]').val();
                            let status = $('#UserRole').val();
                            let date_range = $('#date_select').val();
                            let dates = date_range.split(' - ');
                            let start = moment(dates[0], 'MM/DD/YYYY').format('YYYY-MM-DD');
                            let end = moment(dates[1], 'MM/DD/YYYY').format('YYYY-MM-DD');
                            let queryParams = [];
                            if (status) {
                                queryParams.push('status=' + encodeURIComponent(status));
                            }
                            if (value) {
                                queryParams.push('value=' + encodeURIComponent(value));
                            }
                            queryParams.push('start=' + encodeURIComponent(start));
                            queryParams.push('end=' + encodeURIComponent(end));
                            let baseUrl = "{{ url('report/report-invoice/file-export') }}";
                            let fullUrl = baseUrl + '?' + queryParams.join('&');
                            window.location.href = fullUrl;
                           
                        })
                        $('#date_select').daterangepicker({
                            startDate: moment().startOf('month'),
                            endDate: moment().endOf('month'),
                            opens: 'left',
                            locale: {
                                format: 'DD/MM/YYYY'
                            }
                        });
                }))
            }
        });
        a.on("draw.dt", (function() {
            [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map((
                function(a) {
                    return new bootstrap.Tooltip(a, {
                        boundary: document.body
                    })
                }))
        })), $(".list-vendor-table tbody").on("click", ".delete-record", (function() {
            e.row($(this).parents("tr")).remove().draw()
        })), setTimeout((() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                ".dataTables_length .form-select").removeClass("form-select-sm")
        }), 300)
    }));
</script> --}}

@endsection