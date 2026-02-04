@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tanda Terima')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Tanda Terima</a>
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
                <div class="col-sm-4 col-lg-6">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_receipt_sent">0</h3>
                            <p class="mb-0">Tanda Terima Terkirim (Bulan ini)</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-6">
                    <div class="d-flex justify-content-between align-items-start pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1 count_receipt_not_sent">0</h3>
                            <p class="mb-0">Tanda Terima Belum Terkirim (Bulan ini)</p>
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
        <table class="invoice-list-table table">
            <thead>
            </thead>
        </table>
    </div>
</div>


@endsection

@section('page-script')
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    $(document).ready(function() {
    "use strict";
    let account = {!! json_encode(session('data')) !!}
    let buttonAdd = [];
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;

    if (account.level.id == '10') {
        buttonAdd = [{
            text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Tanda Terima</span>',
            className: "btn btn-primary",
            action: function(a, e, t, s) {
                window.location = baseUrl + "invoice/tanda-terima/add"
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
            url: "{{ env('BASE_URL_API')}}" +'/api/receipt/report',
            type: "GET",
            dataType: "json",
            success: function(res) {
                $('.count_receipt_sent').html(res.count_receipt_sent);
                $('.count_receipt_not_sent').html(res.count_receipt_not_sent);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    $(document).on('click', '.send-email', function(event) {
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
                    url: "{{ env('BASE_URL_API')}}" +'/api/receipt/update-status/'+ id,
                    type: "PATCH",
                    data: JSON.stringify(datas),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Mengirim Tanda Terima',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            $('.invoice-list-table').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr?.responseJSON?.message,
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

    var a = $(".invoice-list-table");
    var e = a.DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: "{{ url('invoice/tanda-terima/data-tanda-terima') }}",
            "data": function(d) {
                d.start = 0;
                d.page = $(".invoice-list-table").DataTable().page.info().page + 1;
            }
        },
        columns: [{
            class: "text-center",
            data: "receipt_number",
            name: "receipt_number",
            title: "No Tanda Terima",
            render: function(data, type, row) {
                return data;
            }
        }, {
            class: "text-center",
            data: "tenant_name",
            name: "tenant_name",
            title: "Tenant",
            render: function(data, type, row) {
                return data;
            }
        }, {
            class: "text-center",
            data: "total_invoice",
            name: "total_invoice",
            title: "Total",
            render: function(data, type, row) {
                // Check if it is of type 'display'
                if (type === 'display') {
                    return 'Rp. ' + parseFloat(data).toLocaleString('en-US') + ',-';
                }

                // For other types (sorting, filtering, etc.), return the original data
                return data;
            }
        }, {
            class: "text-center",
            data: "paid",
            name: "paid",
            title: "Dibayarkan",
            render: function(data, type, row) {
                // Check if it is of type 'display'
                if (type === 'display') {
                    return 'Rp. ' + parseFloat(data).toLocaleString('en-US') + ',-';
                }

                // For other types (sorting, filtering, etc.), return the original data
                return data;
            }
        }, {
            class: "text-center",
            data: "receipt_date",
            name: "receipt_date",
            title: "Tanggal Tanda Terima",
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
            render: function(data, type, full, meta) {
                if (data == "Disetujui KA") {
                    return '<span class="badge w-100" style="background-color : #4EC0D9; " text-capitalized>Disetujui CA</span>'
                } else if (data == "Disetujui BM") {
                    return '<span class="badge w-100" style="background-color : #4E6DD9; " text-capitalized>' + data +
                        '</span>'
                } else if (data == "Terbuat") {
                    return '<span class="badge w-100" style="background-color : #BFBFBF; " text-capitalized>' + data +
                        '</span>'
                } else if (data == "Terkirim") {
                    return '<span class="badge w-100" style="background-color : #FF87A7; " text-capitalized>' + data +
                        '</span>'
                }
                
            }
        }, {
            data: 'id',
            name : 'tanggapan',
            title: "Action",
            render: function(data, type, row) {
                let sendMailRow = '';
                let editButton = '';
                let deleteButton = '';
                if (row.status == 'Disetujui BM' && account.level.id == 10) {
                    sendMailRow = `<a href="#" data-bs-toggle="tooltip" class="text-body send-email" data-id="${data}" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>`;
                }
                if ((account.level.id == 10 && row.status == 'Terbuat') || (account.level.id == 1 && row.status == 'Disetujui KA')) {
                    editButton = `<a href="tanda-terima/edit/${data}" class="dropdown-item btn-edit" data-id="${data}">Edit</a>`;
                }
                if ((account.level.id == 10)) {
                    deleteButton = `<a href="javascript:;" class="dropdown-item delete-record text-danger btn-delete" data-id="${data}">Delete</a>`;
                }
                return `<div class="d-flex align-items-center">
                                ${sendMailRow}
                                <a href="tanda-terima/show/${data}" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Show Tanda Terima"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                                <div class="dropdown">
                                    <a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a target="_blank" href="{{url('invoice/tanda-terima/print')}}/` + data + `" class="dropdown-item">Download</a>
                                        ${editButton}
                                        ${deleteButton}
                                    </div>
                                </div>
                            </div>`;
            }
        }],
        order: [
            [0, "desc"]
        ],
        dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
            this.api().columns(5).every((function() {
                var a = this,
                    e = $(
                        '<select id="status" class="form-select"><option value=""> Select Status </option></select>'
                    ).appendTo(".invoice_status").on("change");
                        var optionsHtml =   '<option value="terbuat">Terbuat</option>' +
                                            '<option value="disetujui ka">Disetujui CA</option>' +
                                            '<option value="disetujui bm">Disetujui BM</option>' +
                                            '<option value="terkirim">Terkirim</option>';
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
    })), $(".invoice-list-table tbody").on("click", ".delete-record", (function() {
        e.row($(this).parents("tr")).remove().draw()
    })), setTimeout((() => {
        $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
            ".dataTables_length .form-select").removeClass("form-select-sm")
    }), 300)

    $(document).on('change', '#status', function(x) {
        x.stopPropagation();
        e.ajax.url("{{ url('invoice/tanda-terima/data-tanda-terima') }}"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
    });

    $(document).on('click', '.btn-delete', function(event) {
        let id = $(this).data('id');
        event.stopPropagation();
        Swal.fire({
            text: "Apakah Ingin menghapus Tanda Terima ini  ?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, send!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(async function(result) {
            if (result.value) {
                var formData = new FormData();
                hapusReceipt(id);
            }
        });
    });

    function hapusReceipt(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        })

        $.ajax({
            url: "{{ env('BASE_URL_API')}}" +'api/receipt/'+ id,
            type: "DELETE",
            contentType: false,
            processData: false,
            async: true,
            success: function(response, result) {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil Hapus Tanda Terima',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                }).then(async function(res) {
                    $(".invoice-list-table").DataTable().ajax.reload();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error,
                });
            }
        });
    }
});
</script>

@endsection