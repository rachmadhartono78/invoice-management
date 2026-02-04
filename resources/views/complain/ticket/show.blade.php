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
                    <h2 class="mx-auto"><b>Detail Aduan dan Complain</b></h2>
                    {{-- Divider --}}
                    <hr class="my-3 mx-n4">
                    <div class="table-responsive">
                        <table style="width: 100%;">
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fs-5">Nama Pelapor</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <span id="reporter_name" class="fs-5"></span>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fs-5">Nomor Telepon</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="reporter_phone" class="fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fs-5">Nama Perusahaan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="tenant_id" class="fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fs-5">Judul Laporan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="ticket_title" class="fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fs-5">Isi laporan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                    <div id="ticket_body" class="fs-5"></div>
                                </td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td style="width: 20%;">
                                    <label for="salesperson" class="form-label fs-5">Laporan</label>
                                </td>
                                <td style="width: 5%;" class="mx-auto">
                                    <div class="">:</div>
                                </td>
                                <td style="width: 75%;">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="row d-flex  align-items-center fs-5 mb-3 gallery">
                    </div>
                    <div class="px-3">
                        <a href="" class="btn btn-primary waves-effect waves-light btn-download" download="Lampiran Ticket.jpg"><i class="ti ti-download"></i> &nbsp;Download Lampiran</a>
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
                    <a href="#" class="btn btn-primary btn-label-secondary d-grid w-100 mb-2 add-damage">Buat Laporan Kerusakan</a>
                    <a href="{{ url('complain/list-ticket')}}" id="back" class="btn btn-secondary d-grid w-100 mb-2">Kembali</a>
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

    $(document).ready(function() {
        var urlSegments = window.location.pathname.split('/');
        var idIndex = urlSegments.indexOf('show-ticket') + 1;
        var id = urlSegments[idIndex];
        getDataTicket(id);

        $(document).on('click', '.add-damage', function(event) {
            event.preventDefault();
            window.location.href = "/complain/laporan-kerusakan/add?id-ticket=" + id
        });
    });



    function getDataTicket(id) {
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" +'/api/ticket/'+id,
            type: "GET",
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
            success: function(res) {
                let data = res.data;
                console.log(data);
                $("#reporter_name").text(data.reporter_name);
                $("#reporter_phone").text(data.reporter_phone);
                $("#ticket_title").text(data.ticket_title);
                $("#ticket_body").text(data.ticket_body);
                $("#tenant_id").text(data.tenant.company);
                getImage(data.ticket_attachments);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    function getImage(images) {
        let temp = '';
        for (let i = 0; i < images.length; i++) {
            temp += `
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="bg-image hover-overlay ripple shadow-1-strong rounded" data-ripple-color="light">
                    <img src="${images[i].attachment}"  class="w-100"/>
                </div>
            </div>
            `
        }
        $('.btn-download').attr('href', images[0].attachment);
        $('.gallery').append(temp);
    }
</script>
@endsection