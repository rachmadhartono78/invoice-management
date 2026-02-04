@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Work Order')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-wo" class="create-wo" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card" id="addWorkOrder">
                    <div class="card-body">
                        <div class="row m-sm-4 m-0">
                            <div class="col-md-7 mb-md-0 mb-4 ps-0">
                                <h1 class="fw-700" style="margin: 0;"><b>PPPGSI</b></h1>
                                <h4><b>Building Management</b></h4>
                            </div>
                            <div class="col-md-5">
                                <span class="fs-2"><b>Work Order</b></span>
                                <span class="d-block" id="no-wo"> :</span>
                            </div>
                        </div>
                        <hr class="my-3 mx-n4">

                        <div class="row py-3 px-3">
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">No Lap Kerusakan </label>
                                    <select class="form-select select-lk item-details mb-3" id="select-lk" readonly>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Date </label>
                                    <input type="text" class="form-control date" id="work_order_date" name="work_order_date" placeholder="Date" readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Action Plan </label>
                                    <input type="text" class="form-control date" id="action_plan_date" name="action_plan_date" placeholder="Action Plan" readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Finish Plan </label>
                                    <input type="text" class="form-control date" id="finish_plan" name="finish_plan" placeholder="Finish Plan" readonly />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="scope" class="form-label fw-medium">Scope</label>
                                    <input type="text" class="form-control" name="" id="scope" readonly>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="classification" class="form-label fw-medium">Classification</label>
                                    <input type="text" class="form-control" name="" id="classification" readonly>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Job deskription:</label>
                                    <textarea class="form-control add" rows="5" id="job_description" name="job_description" placeholder="Job deskription" readonly></textarea>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 px-3">
                            <div class="card academy-content shadow-none border p-3">
                                <div class="">
                                    <div class="">
                                        <div class="" id="details">

                                        </div>
                                    </div>
                                </div>

                                <div class="row py-3">
                                    <div class="col-12">
                                        <label for="note" class="form-label fw-medium">Klasifikasi</label>
                                        <div class="">
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="closed" id="closed" readonly>
                                                <label class="form-check-label" for="closed">Closed
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="cancelled" id="cancelled" readonly>
                                                <label class="form-check-label" for="cancelled">Cancelled</label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="explanation" id="explanation" readonly>
                                                <label class="form-check-label" for="explanation">Explanation</label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="others" id="others" readonly>
                                                <label class="form-check-label" for="others">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 mt-3 signatures">
                                </div>
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
                        <button type="button" id="edit" class="btn btn-primary d-grid w-100 mb-2">Edit</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
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
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}">
</script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}">
</script>
<script>
    "use strict";
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    var id;
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('show') + 1;
    id = urlSegments[idIndex];

    $(document).ready(function() {
        getDataWorkOrder(id);
    });

    $(document).on('click', '#edit', function(event) {
        event.preventDefault();
        window.location.href = "/complain/work-order/edit/" + id;
    });

    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        window.location.href = "/complain/work-order"
    });

    function getDataWorkOrder(id) {
        $.ajax({
            url: "{{env('BASE_URL_API')}}" + '/api/work-order/' + id,
            // url: "{{url('api/work-order')}}/" + id,
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
                var data = res.data;
                console.log(data);
                id = data.id;
                getLaporanKerusakan(data.damage_report_id);
                $("#no-wo").text('Nomor Work Order : ' + data.work_order_number);
                $("#action_plan_date").val(data.action_plan_date);
                $("#damage_report_id").val(data.damage_report_id);
                $("#finish_plan").val(data.finish_plan);
                $("#job_description").val(data.job_description);
                $("#work_order_date").val(data.work_order_date);
                getDetails(data.work_order_details);
                getScope(data.scope);
                getClassification(data.classification);
                $('#' + data.klasifikasi).prop('checked', true);
                getSignatures(data.work_order_signatures);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    function getClassification(data) {
        var data = data.split(',');
        var classificationSelect = $('#classification');
        var temp = '';
        for (var i = 0; i < data.length; i++) {
            if (i + 1 == data.length) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('api/classification/')}}/" + data[i],
                }).then(function(data) {
                    temp += data.data.name;
                    temp.substring(0, temp.length - 1)
                    classificationSelect.val(temp);
                });
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{url('api/classification/')}}/" + data[i],
                }).then(function(data) {
                    temp += data.data.name+',';
                    // create the option and append to Select2
                    temp.substring(0, temp.length - 1)
                    classificationSelect.val(temp);
                });
            }

        }
    }
    function getScope(data) {
        var data = data.split(',');
        var scopeSelect = $('#scope');
        var temp = '';
        for (var i = 0; i < data.length; i++) {
            if (i + 1 == data.length) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('api/scope/')}}/" + data[i],
                }).then(function(data) {
                    temp += data.data.name;
                    // create the option and append to Select2
                    console.log(temp);
                    temp.substring(0, temp.length - 1)
                    scopeSelect.val(temp);
                });
            } else {
                $.ajax({
                    type: 'GET',
                    url: "{{url('api/scope/')}}/" + data[i],
                }).then(function(data) {
                    temp += data.data.name+',';
                    // create the option and append to Select2
                    console.log(temp);
                    temp.substring(0, temp.length - 1)
                    scopeSelect.val(temp);
                });
            }

        }
    }


    function getSignatures(details) {
        let append = '';
        let appendTechnician = '';
        let appendChief = '';
        let appendWarehouse = '';
        let appendKepala = '';
        for (let i = 0; i < details.length; i++) {
            if (details[i].position == "Technician") {
                appendTechnician = `
                    <div class="col-3">
                        <div class="mb-3 text-center">
                            <span class="">Technician</span>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="technician_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail"> <img id="technician-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="technician_date" name="date[]" value="${moment(details[i].date).format('DD-MM-YYYY')}" readonly>
                        </div>
                    </div>`;
            } else if (details[i].position == "Chief Engineering") {
                appendChief = `
                    <div class="col-md-3">
                        <div class="mb-3 text-center">
                            <span class="">Chief Engineering</span>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="chief_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail"> <img id="engineering-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="chief_date" name="date[]" value="${moment(details[i].date).format('DD-MM-YYYY')}" readonly>
                        </div>
                    </div>`;
            } else if (details[i].position == "Warehouse") {
                appendWarehouse = `
                    <div class="col-md-3">
                        <div class="mb-3 text-center">
                            <span class="">Warehouse</span>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="warehouse_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail"> <img id="warehouse-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="warehouse_date" name="date[]" value="${moment(details[i].date).format('DD-MM-YYYY')}" readonly>
                        </div>
                    </div>`;
            } else if (details[i].position == "Kepala BM") {
                appendKepala = `
                    <div class="col-md-3">
                        <div class="mb-3 text-center">
                            <span class="">Kepala BM</span>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="kepala_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail"> <img id="kepala-bm-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="kepala_date" name="date[]" value="${moment(details[i].date).format('DD-MM-YYYY')}" readonly>
                        </div>
                    </div>`;
            }
            $('.signatures').html(appendTechnician + appendChief + appendWarehouse + appendKepala);
        }

    }


    function getLaporanKerusakan(id) {
        $.ajax({
            url: "{{url('api/damage-report')}}/" + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                let tem = `<option value="` + data.id + `" selected>` + data.damage_report_number + `</option>`;
                $('#select-lk').prepend(tem);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }



    function getDetails(data) {
        let getDetail = '';
        let temp = '';

        if (data) {
            let details = data;
            for (let i = 0; i < details.length; i++) {
                temp = `
                <div class="mb-3 row-mg">
                    <div class="row mb-3  d-flex align-items-end">
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Location</label>
                            <input type="text" class="form-control" id="location" name="location[]" placeholder="Location" readonly value="` + details[i].location + `" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Material Request</label>
                            <input type="text" class="form-control" id="material-req" name="material-req[]" placeholder="Material Request" readonly value="` + details[i].material_request + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Type /Made In</label>
                            <input type="text" class="form-control" id="type" name="type[]" placeholder="Type /Made In" readonly value="` + details[i].type + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3 mb-1-custom"">
                            <label for="note" class="form-label fw-medium">Quantity</label>
                            <input type="number" class="form-control row-input" id="qty" name="qty[]" placeholder="Quantity" readonly value="` + details[i].quantity + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                    </div>
                </div>
                `;
                getDetail = getDetail + temp;
            }
            $('#details').prepend(getDetail);
        } else {
            temp = `            
            <div class="mb-3 row-mg">
                <div class="row mb-3  d-flex align-items-end">
                     <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Location</label>
                        <input type="text" class="form-control row-input" id="location" name="location[]" placeholder="Location" readonly />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Material Request</label>
                        <input type="text" class="form-control row-input" id="material-req" name="material-req[]" placeholder="Material Request" readonly />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Type /Made In</label>
                        <input type="text" class="form-control row-input" id="type" name="type[]" placeholder="Type /Made In" readonly />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3 mb-1-custom"">
                        <label for="note" class="form-label fw-medium">Quantity</label>
                        <input type="text" class="form-control row-input" id="qty" name="qty[]" placeholder="Quantity" readonly />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                </div>
            </div>
            `;
            $('#details').prepend(temp);
        }
    }
</script>
@endsection