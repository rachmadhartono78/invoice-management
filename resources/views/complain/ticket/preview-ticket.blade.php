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
                    <div class="table-responsive">
                        <table style="width: 100%;">
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fw-bold fs-5">Nama Pelapor</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <span id="reporter_name" class="fw-bold fs-5"></span>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fw-bold fs-5">Nomor Telepon</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="reporter_phone" class="fw-bold fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fw-bold fs-5 ">Nama Perusahaan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="tenant_id" class="fw-bold fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fw-bold fs-5">Judul Laporan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="ticket_title" class="fw-bold fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fw-bold fs-5">Isi laporan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="ticket_body" class="fw-bold fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fw-bold fs-5">Laporan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row d-flex  align-items-center fw-bold fs-5 mb-3 gallery">
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
                    <a href="/complain/add-ticket" class="btn btn-label-secondary d-grid w-100 mb-2">Kembali</a>
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

    let data = JSON.parse(localStorage.getItem("ticket"));
    $(document).ready(function() {
        load(data);

    });

    function load(data) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $("#reporter_name").text(data.reporter_name);
        $("#reporter_phone").text(data.reporter_phone);
        $("#reporter_company").text(data.reporter_company);
        $("#ticket_title").text(data.ticket_title);
        $("#ticket_body").text(data.ticket_body);
        getImage(data.attachment);
        getTenant();
        Swal.close();
    }

    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        localStorage.removeItem('ticket');
        window.location.href = "/complain/list-ticket"
    });

    $(document).on('click', '#save', function(event) {
        event.preventDefault();
        $.ajax({
            url: baseUrl + "api/ticket/",
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8",
            dataType: "json",

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
                });

                localStorage.removeItem('ticket');
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
    });

    function getImage(images) {
        console.log(images.length);
        let temp = '';
        for (let i = 0; i < images.length; i++) {
            temp += `
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light">
                    <img src="${images[i]}" class="w-100"/>
                </div>
            </div>
            `
        }
        $('.gallery').append(temp);
    }

    function getTenant() {
        let idTenant = data.tenant_id;
        $.ajax({
            url: "{{url('api/tenant')}}/" + idTenant,
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