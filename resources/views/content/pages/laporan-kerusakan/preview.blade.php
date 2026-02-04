@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Laporan Kerusakan')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="edit-lk" class="edit-lk" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card" id="previewLaporanKerusakan">
                    <div class="card-body">
                        <div class="row m-sm-4 m-0">
                            <div class="col-md-7 mb-md-0 mb-4 ps-0">
                                <h1 class="fw-700" style="margin: 0;"><b>PPPGSI</b></h1>
                                <h4><b>Building Management</b></h4>
                            </div>
                            <div class="col-md-5">
                                <span class="fs-4 d-block text-center mx-auto"><b>LAPORAN KERUSAKAN</b></span>
                                <span class="d-block text-center mx-auto">Nomor Lk :</span>
                                <input type="text" class="form-control add w-px-250 mx-auto" id="damage_report_number" placeholder="Nomor LK" required readonly />
                                <div class="invalid-feedback mx-auto w-px-250">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <hr class="my-3 mx-n4">

                        <div class="row py-3 px-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-1 w-px-250">
                                    <label for="note" class="form-label fw-medium">No Tiket </label>
                                    <input type="text" class="form-control" id="ticket">
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Date</label>
                                    <input type="text" class="form-control add w-px-250" id="preview_damage_report_date" name="damage_report_date" placeholder="Tanggal" required readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Scope</label>
                                    <input type="text" class="form-control add w-px-250" id="preview_scope" name="scope" placeholder="Scope" required readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Classification</label>
                                    <input type="text" class="form-control add w-px-250" id="preview_classification" name="classification" placeholder="Classification" required readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Action Plan Date</label>
                                    <input type="text" class="form-control add w-px-250" id="preview_action_plan_date" name="action_plan_date" placeholder="Action Plan Date" required readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="div">
                                    Kepada Yth. <br>
                                    Dept. Service BM <br>
                                    PPKP GRAHA SURVEYOR INDONESIA <br>
                                    Jakarta
                                </div>
                            </div>
                        </div>

                        <div class="py-3">
                            <div class="card academy-content shadow-none border p-3">
                                <div class="repeater px-3">
                                    <div class="" id="details">
                                    </div>
                                </div>

                                <hr class="my-3">
                                <!-- <div class="row  text-center mt-4">
                                    <div class="col-md-4 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control add" placeholder="KA. Unit Pelayanan" style="text-align:center;" id="type" name="type" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add " placeholder="Nama & Jabatan" style="text-align:center;" id="name" name="name" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable w-px-270" id="dropzone-1">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add date" placeholder="Tanggal" style="text-align:center;" id="date1" name="date" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control add" placeholder="KA. Unit Pelayanan" style="text-align:center;" id="type" name="type" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add " placeholder="Nama & Jabatan" style="text-align:center;" id="name" name="name" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable w-px-270" id="dropzone-2">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add date" placeholder="Tanggal" style="text-align:center;" id="date2" name="date" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control add" placeholder="KA. Unit Pelayanan" style="text-align:center;" id="type" name="type" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add " placeholder="Nama & Jabatan" style="text-align:center;" id="name" name="name" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable w-px-270" id="dropzone-3">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add date" placeholder="Tanggal" style="text-align:center;" id="date3" name="date" required />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice Add-->

            <!-- Invoice Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        {{-- <button type="submit" id="edit"
                                class="btn btn-primary d-grid w-100 mb-2">Update</button> --}}
                        {{-- <a href="1/app/invoice/preview"
                                class="btn btn-label-secondary d-grid w-100 mb-2">Preview</a> --}}
                        <a href="/complain/laporan-kerusakan/add" class="btn btn-label-secondary btn-cancel d-grid w-100">Kembali</a>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </form>
</div>
<!-- / Content -->

@endsection

@section('page-script')
<script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
</script>
<script src="assets/vendor/libs/moment/moment.js">
</script>
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
    let data = JSON.parse(localStorage.getItem('damage-report'));

    // Mendapatkan id dengan cara mengambil dari URL
    $(document).ready(function() {
        $.ajax({
            url: baseUrl + "api/damage-report/nomor",
            type: "get",
            contentType: "application/json; charset=utf-8",
            success: function(response) {
                console.log(response);
                $('#damage_report_number').val(response);
            },
            error: function(errors) {
                console.log(errors.message);
            }
        });


        // Get data from API

        // Date
        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });

        $('#preview_damage_report_date').val(data.damage_report_date)
        $('#action_plan_date').val(data.action_plan_date);
        let ticketId = data.ticket_id;
        let scope = data.scope;
        let scopeArray = scope.split(',');
        let classification = data.classification;
        let classificationArray = classification.split(',');
        let details = data.details;
        console.log(details);
        if (ticketId) {
            getTicket(ticketId);
        }
        if (scope) {
            getScope(scopeArray);
        }
        if (classification) {
            getClassification(classificationArray);
        }
        if (details) {
            getDetails(details);

        }

    });

    function getBank() {
        let idBank = data.bank_id;
        $.ajax({
            url: "{{url('api/bank')}}/" + idBank,
            type: "GET",
            success: function(response) {
                let data = response.data;
                console.log(data);
                $("#bank-name").text(data.name)
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    $(".btn-cancel").on("click", function() {
        window.location.href = "/complain/laporan-kerusakan"
        localStorage.removeItem('damage-report');
    })

    function getTicket(id) {
        $.ajax({
            url: "{{url('api/ticket')}}/" + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                console.log(data);
                $("#ticket").val(data.ticket_number)
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }


    function getScope(scopes) {
        let tempValues = '';

        scopes.forEach(function(element, idx, array) {
            $.ajax({
                url: "{{url('api/scope')}}/" + element,
                type: "GET",
                success: function(response) {
                    let data = response.data;
                    console.log(data.name);
                    if (idx === array.length - 1) {
                        tempValues += data.name
                    } else {
                        tempValues += data.name + ',';

                    }
                    $('#preview_scope').val(tempValues);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });

        });
    }

    function getClassification(scopes) {
        let tempValues = '';

        scopes.forEach(function(element, idx, array) {
            $.ajax({
                url: "{{url('api/classification')}}/" + element,
                type: "GET",
                success: function(response) {
                    let data = response.data;
                    console.log(data.name);
                    if (idx === array.length - 1) {
                        tempValues += data.name
                    } else {
                        tempValues += data.name + ',';

                    }
                    console.log(tempValues);
                    $('#preview_classification').val(tempValues);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });

        });
    }

    function getDetails(details) {
        let tem = '';
        let tempDetails = '';
        for (let i = 0; i < details.length; i++) {
            tem = `
            <div class="row-mg">
                    <div class="row mb-1 row-mg">
                        <div class="col-md-4">
                            <label for="note" class="form-label fw-medium">Jenis Masalah Kerusakan</label>
                            <input type="text" class="form-control  row-input" id="category" name="category[]" placeholder="Jenis Masalah Kerusakan" value="` + details[i].category + `" readonly />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-4">
                            <label for="note" class="form-label fw-medium">Lokasi</label>
                            <input type="text" class="form-control  row-input" id="location" name="location[]" placeholder="Lokasi" value="` + details[i].location + `" readonly />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-4">
                            <label for="note" class="form-label fw-medium">Jumlah</label>
                            <input type="text" class="form-control qty  row-input" id="total" name="total[]" value="` + details[i].total + `" placeholder="Jumlah" readonly />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                    </div>
                </div>
            `;
            tempDetails = tempDetails + tem;
        }

        $('#details').prepend(tempDetails);
    }
</script>
@endsection