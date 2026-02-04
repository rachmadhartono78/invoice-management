@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'List Tenant')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="#">Tenant</a>
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
                                <h3 class="mb-1 count-tenant">0</h3>
                                <p class="mb-0">Tenant</p>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none me-4">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Datatables --}}
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="list-tenant-table table">
                <thead>
                </thead>
            </table>
        </div>
    </div>

    {{-- Card Add --}}
    <div class="modal fade" id="create-tenant-data" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content create-tenant" id="create-tenant" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Tambah Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body addTenant">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Nama PIC</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Masukan Nama Tenant" required>
                            <div class="invalid-feedback"> Please enter your name. </div>
                        </div>
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Masukan Email" required>
                            <div class="invalid-feedback"> Please enter your Email. </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Telepon</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                placeholder="Masukan Telepon" required>
                            <div class="invalid-feedback"> Please enter your phone. </div>
                        </div>
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Company</label>
                            <input type="text" id="company" name="company" class="form-control"
                                placeholder="Masukan Company" required>
                            <div class="invalid-feedback"> Please enter your Company. </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Floor</label>
                            <input type="text" id="floor" name="floor" class="form-control"
                                placeholder="Masukan Lantai" required>
                            <div class="invalid-feedback"> Please enter your floor. </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        id="modal_tenant_cancel">Close</button>
                    <button type="submit" class="btn btn-primary save-tenant        ">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">
                            Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>

                </div>
            </form>
        </div>
    </div>

    {{-- Card Edit --}}
    <div class="modal fade" id="edit-tenant-data" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content edit-tenant" id="edit-tenant" novalidate>
                <input type="hidden" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Edit Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body editTenant">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Nama PIC</label>
                                <input type="text" id="edit_name" name="name" class="form-control"
                                    placeholder="Masukan Nama Tenant" required>
                                <div class="invalid-feedback"> Please enter your name. </div>
                            </div>
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Email</label>
                                <input type="email" id="edit_email" name="email" class="form-control"
                                    placeholder="Masukan Email" required>
                                <div class="invalid-feedback"> Please enter your Email. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Telepon</label>
                                <input type="text" id="edit_phone" name="phone" class="form-control"
                                    placeholder="Masukan Telepon" required>
                                <div class="invalid-feedback"> Please enter your phone. </div>
                            </div>
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Company</label>
                                <input type="text" id="edit_company" name="company" class="form-control"
                                    placeholder="Masukan Company" required>
                                <div class="invalid-feedback"> Please enter your Company. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Floor</label>
                                <input type="text" id="edit_floor" name="floor" class="form-control"
                                    placeholder="Masukan Lantai" required>
                                <div class="invalid-feedback"> Please enter your floor. </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            id="modal_tenant_close">Close</button>
                        <button type="submit" class="btn btn-primary save-tenant">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">
                                Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
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
            var a = $(".list-tenant-table");
            if (a.length) var e = a.DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: {
                    url: "{{ url('client/list-tenant/data-tenant') }}",
                    "data": function(d) {
                        d.start = 0;
                        d.page = $(".list-tenant-table").DataTable().page.info().page + 1;
                    }
                },
                columns: [{
                    data: "id",
                    name: "id",
                    className: "d-none",
                },{
                    data: "company",
                    name: "company",
                    title: "Company"
                },{
                    data: "name",
                    name: "name",
                    title: "Nama PIC"
                }, {
                    data: "email",
                    name: "email",
                    title: "Email"
                }, {
                    data: "phone",
                    name: "phone",
                    title: "Phone"
                }, {
                    data: "floor",
                    name: "floor",
                    title: "Floor"
                },
                {
                    data: null,
                    title: "Action",
                    render: function(data, type, row) {
                        return `
                    <div class="d-flex align-items-center">
                    <a href="javascript:void(0)"  id="button-edit" data-bs-toggle="modal" data-id="` + data.id + `" class="text-body"><i class="ti ti-pencil mx-2 ti-sm"></i></a>
                    <a href="#"  id="button-delete-` + data.id + `"  data-id="` + data.id + `" class="text-body button-delete"><i class="ti ti-trash mx-2 ti-sm"></i></a>
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
                    searchPlaceholder: "Search Tenant"
                },
                buttons: [{
                    text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Tenant</span>',
                    className: "btn btn-primary",
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#create-tenant-data'
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
                    this.api().columns(5).every((function() {
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
            })), setTimeout((() => {
                $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                    ".dataTables_length .form-select").removeClass("form-select-sm")
            }), 300)
        }));

        var createTenant = $(".create-tenant");
        var editTenant = $(".edit-tenant");

        // Create, Add dan Save
        Array.prototype.slice.call(createTenant).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        // Submit your form
                        event.preventDefault();
                        Swal.fire({
                            title: '<h2>Loading...</h2>',
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        })
                        let formData = new FormData();

                        $('.addTenant').find('.form-control').each(function() {
                            var inputId = $(this).attr('id');
                            var inputValue = $("#" + inputId).val();

                            formData.append($("#" + inputId).attr("name"), inputValue);
                        });

                        formData.append('status', 'Active');

                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/tenant',
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                $('.indicator-progress').hide();
                                $('.indicator-label').show();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan tenant',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                })

                                $('#modal_tenant_cancel').click();
                                $('#create-tenant')[0].reset();
                                $(".list-tenant-table").DataTable().ajax.reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseText,
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

        // Edit dan Update
        Array.prototype.slice.call(editTenant).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        // Submit your form
                        event.preventDefault();
                        let id = $("#edit_id").val();
                        let formData = new FormData();
                        
                        var data = $('#edit-tenant').serialize()+ '&status=Active';
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/tenant/' + id,
                            type: "PATCH",
                            data: data,
                            success: function(response) {
                                $('.indicator-progress').hide();
                                $('.indicator-label').show();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil memperbarui tenant',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                })

                                $('#modal_tenant_close').click();
                                $('#edit-tenant')[0].reset();
                                $(".list-tenant-table").DataTable().ajax.reload();
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

        $(document).ready(function() {
            var dataOptions = [{
                    id: 'active',
                    text: 'Active'
                },
                {
                    id: 'non-active',
                    text: 'Non-active'
                },
            ];

            $("#edit_status").select2({
                data: dataOptions,
                cache: true,
                allowClear: true,
                placeholder: 'Select Status'
            });

            $(document).on('click', '#button-edit', function(event) {
                let id = $(this).data('id');

                Swal.fire({
                    title: '<h2>Loading...</h2>',
                    html: sweet_loader + '<h5>Please Wait</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                })

                $.ajax({
                    url: baseUrl + "api/tenant/" + id,
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        let result = response.data;
                        $('#edit_id').val(result.id);
                        $("#edit_status").empty().append('<option value="' + result.status +
                                '">' + result.status + '</option>').val(result.status)
                            .trigger("change");
                        $('#edit_name').val(result.name);
                        $('#edit_email').val(result.email);
                        $('#edit_phone').val(result.phone);
                        $('#edit_company').val(result.company);
                        $('#edit_floor').val(result.floor);
                        $('#edit-tenant-data').modal('show');
                        Swal.close();
                    },
                    error: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.responseJSON.message,
                        });
                    }
                });
            });

            $(document).on('click', '#button-preview', function(event) {
                let id = $(this).data('id');

                Swal.fire({
                    title: '<h2>Loading...</h2>',
                    html: sweet_loader + '<h5>Please Wait</h5>',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                })

                $.ajax({
                    url: baseUrl + "api/tenant/" + id,
                    type: "GET",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        let result = response.data;
                        $('#preview_id').val(result.id);
                        $("#preview_status").empty().append('<option value="' + result.status +
                                '">' + result.status + '</option>').val(result.status)
                            .trigger("change");
                        $('#preview_name').val(result.name);
                        $('#preview_email').val(result.email);
                        $('#preview_phone').val(result.phone);
                        $('#preview_company').val(result.company);
                        $('#preview_floor').val(result.floor);
                        $('#preview-tenant-data').modal('show');
                        Swal.close();
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

            $(document).on('click', '.delete-record', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Ya, Hapus!",
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
                            url: "{{ env('BASE_URL_API')}}" + '/api/invoice/'+id,
                            type: "DELETE",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil Menghapus Invoice',
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
        });

        $(document).on('click', '.button-delete', function(event) {
            let id = $(this).data('id');
            event.stopPropagation();
            Swal.fire({
                text: "Apakah Ingin menghapus Tenant ini  ?",
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
                    Swal.fire({
                        title: 'Memeriksa...',
                        text: "Harap menunggu",
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" +'/api/tenant/' + id,
                        type: "DELETE",
                        contentType: false,
                        processData: false,
                        async: true,
                        success: function(response, result) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Menghapus Tenant',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(async function(res) {
                                $(".list-tenant-table").DataTable().ajax.reload(); 
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
                    // window.location.href = "/pja";
                }
            });
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
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" +'/api/tenant/report',
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('.count-tenant').html(res.count_tenant);
                    Swal.close();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }
        
    </script>

@endsection
