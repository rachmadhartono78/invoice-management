@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'List Vendor')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="#">Vendor</a>
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
                                <h3 class="mb-1 count-vendor">0</h3>
                                <p class="mb-0">Total Vendor</p>
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
            <table class="list-vendor-table table">
                <thead>
                </thead>
            </table>
        </div>
    </div>

    {{-- Card Add --}}
    <div class="modal fade " id="create-vendor-data" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg justify-content-center" style="width: 80vw;">
            <form class="modal-content create-vendor " id="create-vendor">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Tambah Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body addVendor" >
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Nama Perusahaan</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Nama Perusahaan" required>
                            <div class="invalid-feedback"> Masukan nama perusahaan. </div>
                        </div>
                        <div class="col mb-3">
                            <label for="nameBackdrop" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Masukan Email" required>
                            <div class="invalid-feedback"> Masukan Email. </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-6 mb-3">
                            <label for="nameBackdrop" class="form-label">Nama PIC</label>
                            <input type="text" id="pic" name="pic" class="form-control"
                                placeholder="Masukan Nama PIC" required>
                            <div class="invalid-feedback"> Masukan Nama PIC. </div>
                        </div>
                        <div class="col col-md-6 mb-3">
                            <label for="nameBackdrop" class="form-label">Telepon</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                placeholder="Masukan Nomor Telepon" required>
                            <div class="invalid-feedback"> Masukan Nomor Telepon. </div>
                        </div>
                        <div class="col mb-3" hidden>
                            <label for="nameBackdrop" class="form-label">Lantai</label>
                            <input type="text" id="floor" name="floor" class="form-control"
                                placeholder="Masukan Lantai" value="0">
                            <div class="invalid-feedback"> Masukan Lantai. </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-6 mb-3">
                            <label for="nameBackdrop" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Masukan Password" required>
                            <div class="invalid-feedback"> Masukan Password</div>
                        </div>
                        <div class="col col-md-6 mb-3">
                            <label for="nameBackdrop" class="form-label">Alamat</label>
                            <textarea name="address" id="address" class="form-control" cols="30" rows="3" required placeholder="Masukan Alamat"></textarea>
                            <div class="invalid-feedback"> Masukan Alamat. </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                        id="modal_vendor_add_close">Close</button>
                    <button type="submit" class="btn btn-primary save-vendor">
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
    <div class="modal fade" id="edit-vendor-data" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg ">
            <form class="modal-content edit-vendor" id="edit-vendor" novalidate>
                <input type="hidden" id="edit_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Edit Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body editVendor">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Nama Perusahaan</label>
                                <input type="text" id="edit_name" name="name" class="form-control"
                                    placeholder="Masukan Nama Vendor" required>
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
                                <label for="nameBackdrop" class="form-label">Nama PIC</label>
                                <input type="text" id="edit_pic" name="pic" class="form-control"
                                    placeholder="Masukan Nama PIC" required>
                                <div class="invalid-feedback"> Please enter your pic name. </div>
                            </div>
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Telepon</label>
                                <input type="text" id="edit_phone" name="phone" class="form-control"
                                    placeholder="Masukan Telepon" required>
                                <div class="invalid-feedback"> Please enter your phone. </div>
                            </div>
                           
                            <div class="col mb-3" hidden>
                                <label for="nameBackdrop" class="form-label">Lantai</label>
                                <input type="text" id="edit_floor" name="floor" class="form-control"
                                    placeholder="Masukan Lantai" required value="0">
                                <div class="invalid-feedback"> Please enter your floor. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nameBackdrop" class="form-label">Password</label>
                                <input type="text" id="edit_passord" name="password" class="form-control"
                                    placeholder="Masukan Password">
                                <div class="invalid-feedback"> Please enter your floor. </div>
                            </div>
                            <div class="col mb-3 col-md-6">
                                <label for="nameBackdrop" class="form-label">Alamat</label>
                                <textarea name="address" id="edit_address" cols="30" rows="3" class="form-control" required></textarea>
                                <div class="invalid-feedback"> Please enter your Address. </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            id="modal_vendor_edit_close">Close</button>
                        <button type="submit" class="btn btn-primary save-vendor">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Card Preview --}}
    <div class="modal fade" id="preview-vendor-data" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content preview-vendor" id="preview-vendor" novalidate>
                <input type="hidden" id="preview_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Preview Vendor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body previewVendor">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Nama Perusahaan</label>
                                <input type="text" id="preview_name" name="name" class="form-control"
                                    placeholder="Masukan Nama Vendor" required readonly>
                                <div class="invalid-feedback"> Masukan Nama Perusahaan. </div>
                            </div>
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Email</label>
                                <input type="email" id="preview_email" name="email" class="form-control"
                                    placeholder="Masukan Email" required readonly>
                                <div class="invalid-feedback"> Masukan Email. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Telepon</label>
                                <input type="text" id="preview_phone" name="phone" class="form-control"
                                    placeholder="Masukan Telepon" required readonly>
                                <div class="invalid-feedback"> Masukan Telepon. </div>
                            </div>
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Lantai</label>
                                <input type="text" id="preview_floor" name="floor" class="form-control"
                                    placeholder="Masukan Lantai" required readonly>
                                <div class="invalid-feedback"> Masukan Lantai. </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Alamat</label>
                                <textarea name="address" id="preview_address" cols="30" rows="3" class="form-control"></textarea>
                                <div class="invalid-feedback"> Masukan Alamat. </div>
                            </div>
                            <div class="col mb-3">
                                <label for="nameBackdrop" class="form-label">Status</label>
                                <select id="preview_status" class="form-select select2 item-details mb-3" disabled>
                                </select>
                                <div class="invalid-feedback"> Please enter your status. </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            id="modal_vendor_cancel">Close</button>
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
            var a = $(".list-vendor-table");
            if (a.length) var e = a.DataTable({
                processing: true,
                serverSide: true,
                deferRender: true,
                ajax: {
                    url: "{{ url('client/list-vendor/data-vendor') }}",
                    "data": function(d) {
                        d.start = 0;
                        d.page = $(".list-vendor-table").DataTable().page.info().page + 1;
                    }
                },
                columns: [{
                    data: "id",
                    name: "id",
                    className: "d-none",
                },
                {
                    name: "Nama Perusahaan",
                    data: "name",
                    title: "Nama Perusahaan",
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },
                {
                    name: "PIC",
                    data: "pic",
                    title: "PIC",
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                },{
                    name: "Email",
                    data: "email",
                    title: "Email",
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                }, {
                    name: "Telepon",
                    data: "phone",
                    title: "Telepon",
                    className: 'text-center',
                    render: function(data, type, row) {
                        return data;
                    }
                }, {
                    name: "Alamat",
                    data: "address",
                    title: "Alamat",
                    className: 'text-center',

                    render: function(data, type, row) {
                        return data;
                    }
                }, {
                    name: "Lantai",
                    data: "floor",
                    title: "Lantai",
                    visible: false,
                    className: 'text-center',
                    render: function(data, type, full, meta) {
                        return data;
                    }
                }, {
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
                    searchPlaceholder: "Search Vendor"
                },
                buttons: [{
                    text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Vendor</span>',
                    className: "btn btn-primary",
                    attr: {
                        'data-bs-toggle': 'modal',
                        'data-bs-target': '#create-vendor-data'
                    }
                }],
                responsive: {
                    details: {
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

        var createVendor = $(".create-vendor");
        var editVendor = $(".edit-vendor");

        // Create, Add dan Save
        Array.prototype.slice.call(createVendor).forEach(function(form) {
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

                        $('.addVendor').find('.form-control').each(function() {
                            var inputId = $(this).attr('id');
                            var inputValue = $("#" + inputId).val();

                            formData.append($("#" + inputId).attr("name"), inputValue);
                        });

                        formData.append('status', 'Active');

                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/vendor',
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                let datas = {}
                                datas.name = response.name;
                                datas.email = response.email;
                                datas.password = $('#password').val();
                                datas.department_id = 7;
                                datas.level_id = 11;
                                datas.status = 'Active';
                                datas.image = '';
                                $.ajax({
                                    url: "{{ env('BASE_URL_API')}}" +'/api/user',
                                    type: "POST",
                                    data: datas,
                                    success: function(response) {
                                        $('.indicator-progress').hide();
                                        $('.indicator-label').show();
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: 'Berhasil Menambahkan Vendor',
                                            icon: 'success',
                                            customClass: {
                                                confirmButton: 'btn btn-primary'
                                            },
                                            buttonsStyling: false
                                        })

                                        $('#create-vendor-data').modal('hide');
                                        $('#create-vendor').removeClass('was-validated');
                                        $(".list-vendor-table").DataTable().ajax.reload();
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

        // Edit dan Update
        Array.prototype.slice.call(editVendor).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        $('#edit-vendor-data').modal('hide');
                        Swal.fire({
                            title: 'Memeriksa...',
                            text: "Harap menunggu",
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        // Submit your form
                        event.preventDefault();
                        let id = $("#edit_id").val();
                        let formData = new FormData();
                        var data = $('#edit-vendor').serialize();
                        data += '&status=Active';
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/vendor/' + id,
                            type: "PATCH",
                            data: data,
                            success: function(response) {
                                if( $('#edit_password').val() != ''){
                                    let datas = {}
                                    datas.name = response.name;
                                    datas.email = response.email;
                                    datas.password = $('#password').val();
                                    datas.department_id = 7;
                                    datas.level_id = 11;
                                    datas.status = 'Active';
                                    datas.image = '';
                                    $.ajax({
                                        url: "{{ env('BASE_URL_API')}}" +'/api/user/'+ id,
                                        type: "PATCH",
                                        data: datas,
                                        success: function(response) {
                                            $('.indicator-progress').hide();
                                            $('.indicator-label').show();
                                            Swal.fire({
                                                title: 'Berhasil',
                                                text: 'Berhasil Update Vendor',
                                                icon: 'success',
                                                customClass: {
                                                    confirmButton: 'btn btn-primary'
                                                },
                                                buttonsStyling: false
                                            })
    
                                            $('#edit-vendor-data').modal('hide');
                                            $('#edit-vendor').removeClass('was-validated');
                                            $(".list-vendor-table").DataTable().ajax.reload();
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
                url: "{{ env('BASE_URL_API')}}" +'/api/vendor/report',
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('.count-vendor').html(res.count_vendor);
                    Swal.close();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }

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
                    url: "{{ env('BASE_URL_API')}}" + "/api/vendor/" + id,
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
                        $('#edit_pic').val(result.pic);
                        $('#edit_phone').val(result.phone);
                        $('#edit_company').val(result.company);
                        $('#edit_address').val(result.address);
                        $('#edit_floor').val(result.floor);
                        $('#edit-vendor-data').modal('show');
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
                    url: "{{ env('BASE_URL_API')}}" + "/api/vendor/" + id,
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
                        $('#preview_address').val(result.address);
                        $('#preview_floor').val(result.floor);
                        $('#preview-vendor-data').modal('show');
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
        });

        $(document).on('click', '.button-delete', function(e){
            e.stopPropagation();
            let id = $(this).data('id');
            event.stopPropagation();

            Swal.fire({
                text: "Apakah Ingin menghapus Vendor ini  ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, send",
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
                        url: "{{ env('BASE_URL_API')}}" +'/api/vendor/' + id,
                        type: "DELETE",
                        contentType: false,
                        processData: false,
                        async: true,
                        success: function(response, result) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Menghapus Vendor',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(async function(res) {
                                $(".list-vendor-table").DataTable().ajax.reload(); 
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
        });
    </script>

@endsection
