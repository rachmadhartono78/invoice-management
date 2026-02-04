@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Complain')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row ticket-add">
        <!-- Ticket Preview-->
        <div class="col-lg-9 col-12 mb-lg-0 mb-3">
            <div class="card ticket-preview-card">
                <div class="card-body">
                    <h2 class="mx-auto"><b>Form Aduan dan Complain</b></h2>
                    {{-- Divider --}}
                    <hr class="my-3 mx-n4">

                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-between col-3">
                            <label for="salesperson" class="form-label fw-bold fs-5">Nama Pelapor</label>
                            <span>:</span>
                        </div>
                        <div class="col-8 fw-bold fs-5">
                            <div id="reporter_name"></div>
                        </div>
                    </div>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-between col-3">
                            <label for="salesperson" class="form-label fw-bold fs-5">Nomor Telepon</label>
                            <span>:</span>
                        </div>
                        <div class="col-8 fw-bold fs-5">
                            <div id="reporter_phone"></div>
                        </div>
                    </div>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-between col-3">
                            <label for="salesperson" class="form-label fw-bold fs-5">Nama Perusahaan</label>
                            <span>:</span>
                        </div>
                        <div class="col-8 fw-bold fs-5">
                            <div id="tenant_id" class="fw-bold fs-5"></div>
                        </div>
                    </div>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-between col-3">
                            <label for="salesperson" class="form-label fw-bold fs-5">Judul Laporan</label>
                            <span>:</span>
                        </div>
                        <div class="col-8 fw-bold fs-5">
                            <div id="ticket_title"></div>
                        </div>
                    </div>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="d-flex align-items-center justify-content-between col-3">
                            <label for="salesperson" class="form-label fw-bold fs-5">Isi laporan</label>
                            <span>:</span>
                        </div>
                        <div class="col-8 fw-bold fs-5">
                            <div id="ticket_body"></div>
                        </div>
                    </div>
                    <div class="row px-3 mb-3">
                        <div class="d-flex align-items-center justify-content-between col-3">
                            <label for="salesperson" class="form-label fw-bold fs-5">Lampiran</label>
                            <span>:</span>
                        </div>
                        <div></div>
                    </div>
                    <div class="d-flex flex-wrap px-3 fw-bold fs-5 mb-3 gallery">

                    </div>
                    <div class="px-3">
                        <button type="button" class="btn btn-primary waves-effect waves-light">Download Semua Lampiran</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Ticket Preview-->

        <!-- Ticket Actions -->
        <!-- Ticket Actions -->
        <div class="col-lg-3 col-12 invoice-actions">
            <div class="card mb-4">
                <div class="card-body">
                    <button type="button" id="back" class="btn btn-label-secondary d-grid w-100 mb-2">Kembali</button>
                </div>
            </div>
        </div>
        <!-- /Ticket Actions -->
        <!-- /Ticket Actions -->
    </div>

</div>

@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;

    let data = JSON.parse(localStorage.getItem("edit-ticket"));
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('preview-edit-ticket') + 1;
    var id = urlSegments[idIndex];

    $(document).ready(function() {
        $("#reporter_name").text(data.reporter_name);
        $("#reporter_phone").text(data.reporter_phone);
        $("#reporter_company").text(data.reporter_company);
        $("#ticket_title").text(data.ticket_title);
        $("#ticket_body").text(data.ticket_body);
        getImage(data.attachment);
        getTenant(data.tenant_id);
    });

    $(document).on('click', '#back', function(event) {
        event.preventDefault();
        window.location.href = "{{url('complain/edit-ticket')}}/" + id
    });


    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        localStorage.removeItem('edit-invoice');
        window.location.href = "/complain/list-ticket"
    });

    $(document).on('click', '#save', function(event) {
        event.preventDefault();

        $.ajax({
            url: baseUrl + "api/ticket/" + id,
            type: "PATCH",
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            success: function(response) {
                $('.indicator-progress').show();
                $('.indicator-label').hide();

                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil Update Ticket',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });

                localStorage.removeItem('edit-ticket');
                window.location.href = "/complain/list-ticket"
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Semua field harus diisi',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
            }
        });
        // window.location.href = "/invoice/list-invoice"
    });

    function getImage(images) {
        console.log(images.length);
        let temp = '';
        for (let i = 0; i < images.length; i++) {
            temp += `<img class="mx-2 my-2 object-fit-cover" style="width: 250px; height: 250px;" src="${images[i]}" alt="">`
        }
        $('.gallery').append(temp);
    }

    function getTenant(id) {
        $.ajax({
            url: "{{url('api/tenant')}}/" + id,
            type: "GET",
            success: function(response) {
                console.log(response);
                let data = response.data.name;
                $('#tenant_id').text(data);

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
</script>
@endsection