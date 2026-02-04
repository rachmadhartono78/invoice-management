@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Purchase Order')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}">
@endsection

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Purchase Order /</span> List
</h4>

<!-- Invoice List Widget -->

<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
               
                <div class="col-sm-6 col-lg-6">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_purchase_order">0</h3>
                            <p class="mb-0">Purchasing Order (Bulan ini)</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice List Table -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="purchase-order-table table" width="100%">
        </table>
    </div>
</div>


@endsection

@section('page-script')
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    "use strict";
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    let account = {!! json_encode(session('data')) !!}
    let levelId = account.level.id;
    let buttonAdd = [];
    
    if(levelId == '10'){
        buttonAdd =[{
            text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Purchasing Order</span>',
            className: "btn btn-primary",
            action: function(a, e, t, s) {
                window.location = baseUrl + "request/purchase-order/add"
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
            url: "{{ env('BASE_URL_API')}}" +'/api/purchase-order/report',
            type: "GET",
            dataType: "json",
            success: function(res) {
                $('.count_vendor').html(res.count_vendor);
                $('.count_purchase_order').html(res.count_purchase_order);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    $((function() {
        var a = $(".purchase-order-table");
        var e = a.DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: "{{ route('data-purchase-order') }}",
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".purchase-order-table").DataTable().page.info().page + 1;
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
            }, {
                data: "id",
                name: "Action",
                title: "Action",
                render: function(data, type, row) {
                    let editRow = '';
                    let sendMailRow = '';
                    if (row.status == 'Disetujui BM' && account.level.id == 10) {
                        sendMailRow = `<a href="#" data-bs-toggle="tooltip" class="text-body send-email-po" data-id="${data}" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>`;
                    }
                    let previewRow = '<a href="{{ url("request/purchase-order/show")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Invoice"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    return `<div class="d-flex align-items-center">
                            `+ sendMailRow +`
                            `  + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="{{ url("request/purchase-order/print")}}/` + data + `" class="dropdown-item">Download</a><a href="{{ url("request/purchase-order/edit")}}/` + data + `" class="dropdown-item">Edit</a>
                            <div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>`
                }
            }],
            order: [
                [1, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Invoice"
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
                            return "" !== a.title ? '<tr data-dt-row="' + a.rowIndex + '" data-dt-column="' + a.columnIndex + '"><td>' + a.title + ":</td> <td>" + a.data + "</td></tr>" : ""
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
                            var optionsHtml =   '<option value="Terbuat">Terbuat</option>' +
                                                '<option value="disetujui ka">Disetujui KA</option>' +
                                                '<option value="disetujui bm">Disetujui BM</option>' +
                                                '<option value="terkirim">Terkirim</option>'+
                                                '<option value="di upload vendor">Diupload Vendor</option>'+
                                                '<option value="Diverifikasi Admin">Diverifikasi Admin</option>' +
                                                '<option value="selesai">Selesai</option>';
                            e.append(optionsHtml);
                }))
            }
        });
        a.on("draw.dt", (function() {
            [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map((function(a) {
                return new bootstrap.Tooltip(a, {
                    boundary: document.body
                })
            }))
        })), $(".purchase-order-table tbody").on("click", ".delete-record", (function() {
            e.row($(this).parents("tr")).remove().draw()
        })), setTimeout((() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(".dataTables_length .form-select").removeClass("form-select-sm")
        }), 300)
        $(document).on('change', '#status', function(x) {
            x.stopPropagation();
            e.ajax.url("{{ route('data-purchase-order') }}"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
        });
        $(document).on('click', '.send-email-po', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Kirim!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.value) {
                    let id = $(this).data('id');
                    let datas = {}
                    datas.status = 'Terkirim';
                    Swal.fire({
                        title: 'Memeriksa...',
                        text: "Harap menunggu",
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" + '/api/purchase-order/update-status/'+id,
                        type: "PATCH",
                        data: JSON.stringify(datas),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Mengirim Purchase Order',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                $(".purchase-order-table").DataTable().ajax.reload();
                            });
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
                }
            });
        });
    }));
</script>

@endsection