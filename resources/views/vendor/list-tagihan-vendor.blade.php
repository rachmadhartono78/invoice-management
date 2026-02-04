@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tagihan Vendor')

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
                            <p class="mb-0" id="total_tagihan">Total Tagihan</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1 count_purchase_order_paid">Rp. 0</h3>
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
        <table class="list-vendor-table table">
        </table>
    </div>
</div>

@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script>
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let account = {!! json_encode(session('data')) !!}
    let table = '';
    var buttonAdd = []
    if(account.level_id == '11'){
        let vendor = getVendorId(account.email);
        table = "{{ url('vendor/data-vendor/') }}/"+vendor.id;
    } else {
        table = "{{ url('vendor/data-tagihan-vendor') }}";
    }
    
    function getVendorId(email) {
        let result;
        let datas = {}
        datas.email = email;
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/vendor/email',
            type: "POST",
            data: JSON.stringify(datas),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            async: false,
            success: function(response) {
                result = response.data;
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text:  xhr?.responseJSON?.message,
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
            }
        });
        return result;
    }
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    $((function() {
        var a = $(".list-vendor-table");
        var e = a.DataTable({
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
            }, {
                name: "Vendor",
                data: "vendor",
                title: "Vendor",
                className: 'text-center',
                render: function(data, type, row) {;
                    return data == null ? '' : data.name;
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
                        if(account.level_id == '11'){
                            return '<span class="badge w-100 bg-info" text-capitalized> Purchase Order Baru </span>';
                        }else{
                            return '<span class="badge w-100" style="background-color : #FF87A7; " text-capitalized> Terkirim </span>';
                        }
                    } else if (data == 'Diupload Vendor') {
                        return '<span class="badge w-100 bg-primary" text-capitalized> Diupload Vendor </span>'
                    }else if (data == 'Diverifikasi Admin') {
                        return '<span class="badge w-100 bg-primary" text-capitalized> Diverifikasi Admin </span>'
                    }else if (data == 'Selesai') {
                        return '<span class="badge w-100 bg-info" text-capitalized> Selesai </span>'
                    }else if (data == 'Disetujui BM') {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " text-capitalized> Disetujui BM </span>';
                    }
                }
            }, {
                data: "id",
                name: "id",
                title: "Action",
                render: function(data, type, row) {
                    let editRow = '';
                    let deleteRow = '<div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>';
                    let previewRow = '<a href="{{ url("vendor/show-tagihan-vendor")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Tagihan Vendor"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    if(account.level_id == '11'){
                        editRow = `<a href="{{ url("vendor/edit-tagihan-vendor")}}/` + data + `" class="dropdown-item">Edit</a>`;
                        deleteRow = '';
                    }
                    return `<div class="d-flex align-items-center">
                            ` + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="/request/purchase-order/print/`+data+`" target="_blank" class="dropdown-item">Download</a>
                                `+editRow+`
                                `+deleteRow+``
                }
            }],
            order: [
                [0, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"tagihan_status d-flex mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Tanda Terima"
            },
            buttons: buttonAdd,
            responsive: {
                details: {
                    
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(a) {
                            return "Details of " + a.data().full_name
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
                this.api().columns(0).every((function() {
                    var a = this,
                        e = $(
                            '<select id="status" class="form-select"><option value=""> Select Status </option></select>'
                        ).appendTo(".tagihan_status").on("change");
                            let optionsHtml =   '<option value="Terbuat">Terbuat</option>' +
                                                '<option value="disetujui ka">Disetujui KA</option>' +
                                                '<option value="disetujui bm">Disetujui BM</option>' +
                                                '<option value="terkirim">Terkirim</option>'+
                                                '<option value="di upload vendor">Diupload Vendor</option>'+
                                                '<option value="Diverifikasi Admin">Diverifikasi Admin</option>' +
                                                '<option value="selesai">Selesai</option>';
                            if(account.level_id == '11'){
                                optionsHtml =   '<option value="terkirim">Purchase Order Baru</option>'+
                                                '<option value="di upload vendor">Diupload Vendor</option>'+
                                                '<option value="Diverifikasi Admin">Diverifikasi Admin</option>' +
                                                '<option value="selesai">Selesai</option>';
                            }
                            e.append(optionsHtml);
                }))
            }
        });

        $(document).on('change', '#status', function(x) {
            x.stopPropagation();
            if(account.level_id == '11'){
                let vendor = getVendorId(account.email);
                e.ajax.url("{{ url('vendor/data-vendor') }}/"+vendor.id+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
            }
            else if(account.level_id == '10'){
                table = "{{ url('vendor/data-tagihan-vendor') }}";
                e.ajax.url("{{ url('vendor/data-tagihan-vendor') }}/"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
                $("#tenant").html("Total Vendor")
                $("#tt").html("Total Tagihan")
            }
            else {
                e.ajax.url("{{ url('vendor/data-tagihan-vendor') }}/"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
            }
        });

        setHeader();

        function setHeader() {
            Swal.fire({
                title: '<h2>Loading...</h2>',
                html: sweet_loader + '<h5>Please Wait</h5>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            let param = '';
            if(account.level_id == 11){
                let dataVendorId = getVendorId(account.email);
                param = '?vendor_id='+dataVendorId.id;
            }
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" +'/api/vendor-invoice/report'+param,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('.count_purchase_order').html(res.count_purchase_order);
                    $('.count_purchase_order_paid').html('Rp. '+parseFloat(res.count_purchase_order_paid).toLocaleString('en-US'));
                    Swal.close();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }

        function getVendorId(email) {
            let result;
            let datas = {}
            datas.email = email;
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" + '/api/vendor/email',
                type: "POST",
                data: JSON.stringify(datas),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                async: false,
                success: function(response) {
                    result = response.data;
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text:  xhr?.responseJSON?.message,
                        icon: 'error',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    })
                }
            });
            return result;
        }

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
</script>

@endsection