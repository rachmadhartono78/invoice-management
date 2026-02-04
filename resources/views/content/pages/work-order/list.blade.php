@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Laporan Kerusakan')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Work Order</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">List</a>
        </li>
    </ol>
</nav>

<!-- Invoice List Widget -->

<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
               
                <div class="col-sm-4 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_receipt">0</h3>
                            <p class="mb-0">Tanda Terima (Bulan ini)</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-4 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1 count_receipt_paid">0</h3>
                            <p class="mb-0">Terbayarkan (Bulan ini)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice List Table -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="work-order-list-table table">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script>
    "use strict";
    $((function() {
        var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`;
        let account = {!! json_encode(session('data')) !!}
        let buttonAdd = [];
        if (account.level.id == '5') {
            buttonAdd = [{
                text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Work Order</span>',
                className: "btn btn-primary",
                action: function(a, e, t, s) {
                    window.location = "{{url('complain/work-order/add')}}" ;
                }
            }];
        }

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
                url: "{{ env('BASE_URL_API')}}" +'/api/work-order/report',
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('.count_tenant').html(res.count_tenant);
                    $('.count_receipt_paid').html(res.count_receipt_paid);
                    $('.count_receipt').html(res.count_receipt);
                    Swal.close();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }

        var a = $(".work-order-list-table");
        var e = a.DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: "{{ url('complain/work-order/data-work') }}",
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".work-order-list-table").DataTable().page.info().page + 1;
                }
            },
            columns: [{
                data: "work_order_number",
                name: "work_order_number",
                title: "No. Work Order"
            }, {
                data: "scope",
                name: "scope",
                title: "Scope"
            }, {
                data: "classification",
                name: "classification",
                title: "classification"
            }, {
                data: "work_order_date",
                name: "work_order_date",
                title: "Date",
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
                data: "action_plan_date",
                name: "action_plan_date",
                title: "Action Plan",
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
                data: "status",
                name: "status",
                title: "status",
                render: function(data, type, full, meta) {
                    if (data == "Disetujui KA") {
                        return '<span class="badge w-100" style="background-color : #4EC0D9; ">' + data +
                            '</span>'
                    } else if (data == "Disetujui BM") {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " >' + data +
                            '</span>'
                    } else if (data == "Terbuat") {
                        return '<span class="badge w-100" style="background-color : #BFBFBF; " >' + data +
                            '</span>'
                    } else if (data == "Terkirim") {
                        return '<span class="badge w-100" style="background-color : #FF87A7; ">' + data +
                            '</span>'
                    } else if (data == 'Selesai') {
                        return '<span class="w-100 badge" style="background-color : #74D94E; " text-capitalized> Selesai </span>';
                    } else if (data == "Disetujui Warehouse") {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " >' + data +
                            '</span>'
                    } else if (data == "Disetujui Building Manager") {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " >' + data +
                            '</span>'
                    
                    } else if (data == "Disetujui Chief Engineering") {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " >' + data +
                            '</span>'
                    } else if (data == "Disetujui Technician") {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " >' + data +
                            '</span>'
                    }
                }
            }, {
                data: "id",
                name: "tanggapan",
                title: "Action",
                render: function(data, type, row) {
                    return '<div class="d-flex align-items-center"><a href="work-order/show/' +
                        data +
                        '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="/complain/work-order/print/' +
                        data + '" class="dropdown-item">Download</a><a href="work-order/edit/' +
                        data + '" class="dropdown-item btn-edit" data-id="' +
                        data +
                        '">Edit</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>'
                }
            }],
            order: [
                [0, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Work Order"
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
                this.api().columns(5).every((function() {
                    var a = this,
                        e = $(
                            '<select id="status" class="form-select"><option value=""> Select Status </option></select>'
                        ).appendTo(".invoice_status").on("change");
                            var optionsHtml =   '<option value="terbuat">Terbuat</option>' +
                                                '<option value="disetujui chief engineering">Disetujui Chief Engineering</option>' +
                                                '<option value="disetujui ka">Disetujui KA</option>' +
                                                '<option value="disetujui bm">Disetujui BM</option>' +
                                                '<option value="terkirim">Terkirim</option>' +
                                                '<option value="selesai">Selesai</option>';
                            e.append(optionsHtml);
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
        })), $(".work-order-list-table tbody").on("click", ".delete-record", (function() {
            e.row($(this).parents("tr")).remove().draw()
        })), setTimeout((() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                ".dataTables_length .form-select").removeClass("form-select-sm")
        }), 300)
        $(document).on('change', '#status', function(x) {
            x.stopPropagation();
            e.ajax.url("{{ url('complain/work-order/data-work') }}"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
        });
    }));
</script>

@endsection