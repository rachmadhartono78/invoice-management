@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Complain')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <form action="/upload" id="create-ticket" class="create-ticket" novalidate>
        <div class="row ticket-add">
            <!-- Ticket Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card ticket-preview-card">
                    <div class="card-body">
                        <h2 class="mx-auto"><b>Form Aduan dan Complain</b></h2>
                        {{-- Divider --}}
                        <hr class="my-3 mx-n4">

                        <div class="col-md-12 mb-md-0 mb-3">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Nama Pelapor</label>
                                <input type="text" class="form-control" name="reporter_name" id="reporter_name" placeholder="Nama Pelapor" required />
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Nomor Telepon</label>
                                <input type="text" class="form-control" name="reporter_phone" id="reporter_phone" placeholder="Nomor Telepon" required />
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Nama Perusahaan</label>
                                <select name="tenant_id" id="tenant_id" class="mb-3 form-control" required></select>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Judul Laporan</label>
                                <input type="text" class="form-control" name="ticket_title" id="ticket_title" placeholder="Judul Laporan" required />
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Isi laporan</label>
                                <textarea class="form-control" rows="11" id="ticket_body" name="ticket_body" placeholder="Isi laporan" required></textarea>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label fw-bold">Upload Lampiran</label>
                                <input class="form-control" type="file" name="attachment" id="attachment" accept="image/png, image/gif, image/jpeg" placeholder="Pilih Berkas" alt="Pilih Berkas" multiple required>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Ticket Add-->

            <!-- Ticket Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- <a href="#" class="btn btn-primary d-grid w-100 mb-2">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">Buat Laporan Kerusakan</span>
                        </a> -->
                        <button type="submit" id="save" class="btn btn-primary btn-label-secondary d-grid w-100 mb-2">Simpan</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
                    </div>
                </div>
            </div>
            <!-- /Ticket Actions -->
        </div>
    </form>


</div>

@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
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
    let dataLocal = JSON.parse(localStorage.getItem("ticket"));
    $(document).ready(function() {
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance !== "undefined" && window.performance.getEntriesByType("navigation")[0].type === "back_forward");
            if (historyTraversal) {
                location.reload(); // Reload the page
            }
        });

        var files = [];

        if (dataLocal) {
            $("#reporter_name").val(dataLocal.reporter_name);
            $("#reporter_phone").val(dataLocal.reporter_phone);
            $("#reporter_company").val(dataLocal.reporter_company);
            $("#ticket_title").val(dataLocal.ticket_title);
            $("#ticket_body").val(dataLocal.ticket_body);
            files = dataLocal.attachment;
            getTenant();
            if (files) {
                $('#attachment').removeAttr("required");
            }
        }

        $(document).on('change', '#attachment', function(e) {
            // Get a reference to the file
            const file = e.target.files[0];

            // Encode the file using the FileReader API
            const reader = new FileReader();
            reader.onloadend = () => {
                // Use a regex to remove data url part
                const base64String = reader.result
                    .replace('data:', '')
                    .replace(/^.+,/, '');

                files.push(`data:${(file.type)};base64,${base64String}`);
                // Logs wL2dvYWwgbW9yZ...
            };
            reader.readAsDataURL(file);
        });

        $("#tenant_id").select2({
            placeholder: 'Select Tenant',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" +'/api/tenant/select?field=company',
                dataType: 'json',
                cache: true,
                data: function(params) {
                    return {
                        value: params.term || '',
                        page: params.page || 1
                    }
                },
                processResults: function(data, params) {
                    var more = data.pagination.more;
                    if (more === false) {
                        params.page = 1;
                        params.abort = true;
                    }

                    return {
                        results: data.data,
                        pagination: {
                            more: more
                        }
                    };
                }
            }

        });


        var saveTicket = $('.create-ticket');

        Array.prototype.slice.call(saveTicket).forEach(function(form) {
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
                        event.stopPropagation();

                        let datas = {};
                        $('.create-ticket').find('.form-control').each(function() {
                            var inputId = $(this).attr('id');
                            var inputValue = $("#" + inputId).val();
                            datas[$("#" + inputId).attr("name")] = inputValue;
                        });

                        datas.attachment = files;
                        datas.status = "On progress"

                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/ticket',
                            type: "POST",
                            data: JSON.stringify(datas),
                            processData: false,
                            contentType: false,
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            beforeSend: function() {
                                Swal.fire({
                                    title: '<h2>Loading...</h2>',
                                    html: sweet_loader + '<h5>Please Wait</h5>',
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                });
                            },
                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan Ticket',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    localStorage.removeItem('ticket');
                                    window.location.href = "/complain/list-ticket"
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

        $(document).on('click', '#preview', function(event) {
            event.preventDefault();

            let datas = {};
            $('.create-ticket').find('.form-control').each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $("#" + inputId).val();
                datas[$("#" + inputId).attr("name")] = inputValue;
            });
            datas.attachment = files;
            datas.status = "Wait a response"

            localStorage.setItem("ticket", JSON.stringify(datas));
            window.location.href = "/complain/preview-ticket"
        });

        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            localStorage.removeItem('ticket');
            window.location.href = "/complain/list-ticket"
        });
    });


    function getTenant() {
        let idTenant = dataLocal.tenant_id;
        $.ajax({
            url: "{{url('api/tenant')}}/" + idTenant,
            type: "GET",
            success: function(response) {
                console.log(response);
                let data = response.data;

                let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                $('#tenant_id').prepend(tem);

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>
@endsection