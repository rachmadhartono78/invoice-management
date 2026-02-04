@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'List Bank')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/animate-css/animate.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Bank</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">List</a>
        </li>
    </ol>
</nav>


{{-- Datatables --}}
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="list-bank-table table">
        </table>
    </div>
</div>

{{-- Card Add --}}
<div class="modal fade" id="create-bank-data" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content create-bank" id="create-bank" novalidate>
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Tambah Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Bank</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback"> Please enter your name. </div>
                    </div>
                    <div class="mb-3">
                        <label for="account_name" class="form-label">Nama Akun</label>
                        <input type="text" id="account_name" name="account_name" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="account_number" class="form-label">Nomor Akun</label>
                        <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="branch_name" class="form-label">Nama Cabang</label>
                        <input type="text" id="branch_name" name="branch_name" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="modal_bank_cancel">Close</button>
                <button type="submit" class="btn btn-primary save-bank">
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
<div class="modal fade" id="edit-bank-data" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content edit-bank" id="edit-bank" novalidate>
            <input type="hidden" id="edit_id">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Edit Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nama Bank</label>
                        <input type="text" id="edit_name" name="name" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback"> Please enter your name. </div>
                    </div>
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nama Akun</label>
                        <input type="text" id="edit_account_name" name="account_name" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nomor Akun</label>
                        <input type="text" id="edit_account_number" name="account_number" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nama Cabang</label>
                        <input type="text" id="edit_branch_name" name="branch_name" class="form-control" placeholder="Masukan Nama Bank" required>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="modal_bank_cancel">Close</button>
                <button type="submit" class="btn btn-primary save-bank">
                    Simpan
                </button>

            </div>
        </form>
    </div>
</div>

{{-- Card Preview --}}
<div class="modal fade" id="preview-bank-data" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content edit-bank" id="edit-bank" novalidate>
            <input type="hidden" id="preview_id">
            <div class="modal-header">
                <h5 class="modal-title" id="backDropModalTitle">Preview Bank</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nama Bank</label>
                        <input type="text" id="preview_name" name="name" class="form-control" placeholder="Masukan Nama Bank" readonly>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nama Akun</label>
                        <input type="text" id="preview_account_name" name="account_name" class="form-control" placeholder="Masukan Nama Bank" readonly>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nomor Akun</label>
                        <input type="text" id="preview_account_number" name="account_number" class="form-control" placeholder="Masukan Nama Bank" readonly>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="mb-3">
                        <label for="nameBackdrop" class="form-label">Nama Cabang</label>
                        <input type="text" id="preview_branch_name" name="branch_name" class="form-control" placeholder="Masukan Nama Bank" readonly>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="modal_bank_cancel">Close</button>
            </div>
        </form>
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

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;

    $((function() {
        var a = $(".list-bank-table");
        if (a.length) var e = a.DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: "{{ url('settings/data-bank') }}",
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".list-bank-table").DataTable().page.info().page + 1;
                }
            },
            columns: [{
                    data: "name",
                    name: "name",
                    title: "Nama Bank"
                },
                {
                    data: "account_name",
                    name: "account_name",
                    title: "Nama Akun",
                },
                {
                    data: "account_number",
                    name: "account_number",
                    title: "Nomor Akun",
                },
                {
                    data: "branch_name",
                    name: "branch_name",
                    title: "Nama Cabang",
                },
                {
                    title: "Tanggal Dibuat",
                    data: "created_at",
                    name: "created_at",
                    render: function(data, type, row) {
                        if (data != null) {
                            const date = new Date(data);
                            const year = date.getUTCFullYear();
                            const month = new Intl.DateTimeFormat('en-US', {
                                month: 'long'
                            }).format(date);
                            const day = date.getUTCDate();
                            const formattedDate = `${day} ${month} ${year}`;
                            return formattedDate;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: "id",
                    name: "tanggapan",
                    title: "Action",
                    render: function(data, type, row) {
                        return `
                        <div class="d-flex align-items-center">
                        <a href="javascript:void(0)"  id="button-edit" data-bs-toggle="modal" data-id="` + data + `" class="text-body"><i class="ti ti-pencil mx-2 ti-sm"></i></a>
                        <a href="javascript:void(0)"  id="button-delete"  data-id="` + data + `" class="text-body"><i class="ti ti-trash mx-2 ti-sm"></i></a>
                        </div>`;
                    }
                },
            ],
            order: [
                [4, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Bank"
            },
            buttons: [{
                text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat List Bank</span>',
                className: "btn btn-primary",
                attr: {
                    'data-bs-toggle': 'modal',
                    'data-bs-target': '#create-bank-data'
                }
            }],
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
                this.api().columns(3).every((function() {
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
        })), $(".list-bank-table tbody").on("click", ".delete-record", (function() {
            e.row($(this).parents("tr")).remove().draw()
        })), setTimeout((() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                ".dataTables_length .form-select").removeClass("form-select-sm")
        }), 300)
    }));

    var createBank = $(".create-bank");
    var editBank = $(".edit-bank");


    // Loop over them and prevent submission
    Array.prototype.slice.call(createBank).forEach(function(form) {
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
                    var formData = new FormData($('#create-bank')[0]);
                    $.ajax({
                        url: "{{url('api/bank')}}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $('.indicator-progress').show();
                            $('.indicator-label').hide();

                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil menambahkan Bank',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            })

                            $('#modal_bank_cancel').click();
                            $('#create-bank')[0].reset();
                            $(".list-bank-table").DataTable().ajax.reload();
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

    Array.prototype.slice.call(editBank).forEach(function(form) {
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
                    let id = $('#edit_id').val();
                    var data = $('#edit-bank').serialize();
                    $.ajax({
                        url: "{{url('api/bank')}}/"+ id,
                        type: "PATCH",
                        data: data,
                        success: function(response) {
                            $('.indicator-progress').show();
                            $('.indicator-label').hide();

                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Memperbarui Bank',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            })

                            $('#modal_bank_cancel').click();
                            $('#edit-bank')[0].reset();
                            $('#edit-bank-data').modal('hide');

                            $(".list-bank-table").DataTable().ajax.reload();
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
            url: "{{url('api/bank')}}/"+ id,
            type: "get",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                $('#edit_id').val(response.data.id);
                $('#edit_name').val(response.data.name)
                $('#edit_account_name').val(response.data.account_name)
                $('#edit_account_number').val(response.data.account_number)
                $('#edit_branch_name').val(response.data.branch_name)
                $('#edit-bank-data').modal('show')
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
            url: "{{url('api/bank')}}/"+ id,
            type: "get",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                console.log(response);
                $('#preview_id').val(response.data.id);
                $('#preview_name').val(response.data.name)
                $('#preview_account_name').val(response.data.account_name)
                $('#preview_account_number').val(response.data.account_number)
                $('#preview_branch_name').val(response.data.branch_name)
                $('#preview-bank-data').modal('show')
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
            text: "Apakah Ingin menghapus Bank ini  ?",
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
                hapusBank(id);
                // window.location.href = "/pja";
            }
        });
    });

    function hapusBank(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        })

        $.ajax({
            url: "{{url('api/bank')}}/"+ id,
            type: "DELETE",
            contentType: false,
            processData: false,
            async: true,
            success: function(response, result) {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil Hapus Bank',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                }).then(async function(res) {
                    $(".list-bank-table").DataTable().ajax.reload();
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