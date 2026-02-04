@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tax Rates')

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Tax Rates</a>
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
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1">300</h3>
                            <p class="mb-0">Tenant</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-4">
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1">50</h3>
                            <p class="mb-0">Tanda Terima</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1">Rp. 20.000.000</h3>
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
        <table class="tax-rates-table table">

        </table>
    </div>
</div>

<div class="modal fade" id="edit-tax-data" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content edit-tax" id="edit-tax" novalidate>
            <input type="hidden" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Edit Tax</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-md-0 mb-3">
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama" name="edit-name" id="edit-name" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Rates</label>
                            <input type="number" class="form-control" placeholder="Rates" name="edit-rate" id="edit-rate" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Keterangan</label>
                            <textarea class="form-control" rows="6" placeholder="Keterangan" name="edit-description" id="edit-description" required></textarea>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="modal_tax_cancel">Close</button>
                <button type="submit" class="btn btn-primary save-tax">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" id="preview-tax-data" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content edit-tax" id="edit-tax" novalidate>
            <input type="hidden" id="preview_id">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Preview Pajak</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-md-0 mb-3">
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Nama</label>
                            <input type="text" class="form-control" placeholder="Nama" name="preview-name" id="preview-name" readonly />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Rates</label>
                            <input type="number" class="form-control" placeholder="Rates" name="preview-rate" id="preview-rate" readonly />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Keterangan</label>
                            <textarea class="form-control" rows="6" placeholder="Keterangan" name="preview-description" id="preview-description" readonly></textarea>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="modal_tax_cancel">Close</button>
            </div>
        </form>
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

            var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
            $((function() {
                var a = $(".tax-rates-table ");
                if (a.length) var e = a.DataTable({
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    ajax: {
                        url: "{{ route('data-tax') }}",
                        "data": function(d) {
                            d.start = 0;
                            d.page = $(".tax-rates-table").DataTable().page.info().page + 1;
                        }
                    },
                    columns: [{
                            data: "name",
                            title: "Nama Pajak",
                            name: "name",
                            className: 'text-center',
                        },
                        {
                            title: "Pajak",
                            data: "rate",
                            name: "rate",
                            className: 'text-center',
                        },
                        {
                            data: "id",
                            name: "tanggapan",
                            title: "Action",
                            render: function(data, type, row) {
                                return `
                        <div class="d-flex align-items-center">
                        <a href="javascript:void(0)"  id="button-edit" data-bs-toggle="modal" data-id="` + data + `" class="text-body"><i class="ti ti-pencil mx-2 ti-sm"></i></a>
                        <a href="javascript:void(0)"  id="button-preview" data-bs-toggle="modal" data-id="` + data + `" class="text-body"><i class="ti ti-eye mx-2 ti-sm"></i></a>
                        <a href="javascript:void(0)"  id="button-delete"  data-id="` + data + `" class="text-body"><i class="ti ti-trash mx-2 ti-sm"></i></a>
                        </div>`;
                            }
                        },
                    ],
                    order: [
                        [1, "desc"]
                    ],
                    dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                    language: {
                        sLengthMenu: "Show _MENU_",
                        search: "",
                        searchPlaceholder: "Cari Pajak"
                    },
                    buttons: [{
                        text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Tax</span>',
                        className: "btn btn-primary",
                        action: function(a, e, t, s) {
                            window.location = "{{route('pages-create-tax-rates')}}"
                        }
                    }],
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
                        this.api().columns(1).every((function() {
                            var a = this,
                                e = $(
                                    '<select id="UserRole" class="form-select"><option value=""> Select Status </option></select>'
                                ).appendTo(".purchase_status").on("change", (
                                    function() {
                                        var e = $.fn.dataTable.util.escapeRegex($(
                                            this).val());
                                        a.search(e ? "^" + e + "$" : "", !0, !1)
                                            .draw()
                                    }));
                            a.data().unique().sort().each((function(a, t) {
                                e.append('<option value="' + a +
                                    '" class="text-capitalize">' + a +
                                    "</option>")
                            }))
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
                })), $(".tax-rates-table tbody").on("click", ".delete-record", (function() {
                    e.row($(this).parents("tr")).remove().draw()
                })), setTimeout((() => {
                    $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                        ".dataTables_length .form-select").removeClass("form-select-sm")
                }), 300)
            }));

            var editTax = $(".edit-tax");

            Array.prototype.slice.call(editTax).forEach(function(form) {
                form.addEventListener(
                    "submit",
                    function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // Submit your form
                            event.preventDefault();
                            let id = $('#edit_id').val();
                            let name = $('#edit-name').val();
                            let rate = $('#edit-rate').val();
                            let description = $('#edit-description').val();
                            let data = {};
                            data.name = name;
                            data.rate = rate;
                            data.description = description;

                            $.ajax({
                                url: baseUrl + "api/tax/" + id,
                                type: "PATCH",
                                data: data,
                                success: function(response) {
                                    Swal.fire({
                                        title: 'Berhasil',
                                        text: 'Berhasil Memperbarui Tax',
                                        icon: 'success',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        },
                                        buttonsStyling: false
                                    })

                                    $('#modal_tax_cancel').click();
                                    $('#edit-tax')[0].reset();
                                    $('#edit-tax-data').modal('hide');

                                    $(".tax-rates-table").DataTable().ajax.reload();
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

                        form.classList.add("was-validated");
                    },
                    false
                );
            });

            $(document).on('click', '#button-edit', function(event) {
                let id = $(this).data('id');
                $.ajax({
                    url: baseUrl + "api/tax/" + id,
                    type: "get",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        $('#edit_id').val(response.data.id);
                        $("#edit-name").val(response.data.name);
                        $("#edit-rate").val(response.data.rate);
                        $("#edit-description").val(response.data.description);
                        $('#edit-tax-data').modal('show')
                    },
                    error: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.responseJSON.message,
                        })
                    }
                });
            });

            $(document).on('click', '#button-preview', function(event) {
                let id = $(this).data('id');

                $.ajax({
                    url: baseUrl + "api/tax/" + id,
                    type: "get",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        $('#preview_id').val(response.data.id);
                        $('#preview-name').val(response.data.name);
                        $('#preview-rate').val(response.data.rate);
                        $('#preview-description').val(response.data.description);

                        $('#preview-tax-data').modal('show')
                    },
                    error: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.responseJSON.message,
                        })
                    }
                });
            });

            $(document).on('click', '#button-delete', function(event) {
                let id = $(this).data('id');
                event.stopPropagation();
                Swal.fire({
                    text: "Apakah Ingin menghapus Tax ini  ?",
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
                        hapusTax(id);
                        // window.location.href = "/pja";
                    }
                });
            });

            function hapusTax(id) {
                Swal.fire({
                    title: '<h2>Loading...</h2>',
                    html: sweet_loader + '<h5>Please Wait</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                })

                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" +'/api/tax/' + id,
                    type: "DELETE",
                    contentType: false,
                    processData: false,
                    async: true,
                    success: function(response, result) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Tax Bank',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then(async function(res) {
                            $(".tax-rates-table").DataTable().ajax.reload();
                        });
                        // resolve();
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
        </script>

        @endsection