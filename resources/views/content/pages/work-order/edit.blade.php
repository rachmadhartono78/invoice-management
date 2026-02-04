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
                                    <select id="select-lk" class="form-select select2 select-lk item-details mb-3" required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Date </label>
                                    <input type="text" class="form-control date" id="work_order_date" name="work_order_date" placeholder="Date" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Action Plan </label>
                                    <input type="text" class="form-control date" id="action_plan_date" name="action_plan_date" placeholder="Action Plan" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Finish Plan </label>
                                    <input type="text" class="form-control date" id="finish_plan" name="finish_plan" placeholder="Finish Plan" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="scope" class="form-label fw-medium">Scope</label>
                                    <select class="form-select add w-px-250 select2 select-scope form-control" id="scope" name="scope" multiple required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="classification" class="form-label fw-medium">Classification</label>
                                    <select id="classification" name="classification" class="mb-3 select-classification add form-control" required multiple>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Job deskription:</label>
                                    <textarea class="form-control add" rows="5" id="job_description" name="job_description" placeholder="Job deskription" required></textarea>
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

                                    <div class="row pb-4">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-add-row-mg">Tambah Baris</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row py-3">
                                    <div class="col-12">
                                        <label for="note" class="form-label fw-medium">Klasifikasi</label>
                                        <div class="">
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="closed" id="closed">
                                                <label class="form-check-label" for="closed">Closed
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="cancelled" id="cancelled">
                                                <label class="form-check-label" for="cancelled">Cancelled</label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="explanation" id="explanation">
                                                <label class="form-check-label" for="explanation">Explanation</label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="others" id="others">
                                                <label class="form-check-label" for="others">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="note" class="form-label fw-medium text-left ttd">Technician</label>
                                <div class="row mb-3 mt-3 text-center signatures">

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
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Update</button>
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
    let account = {!! json_encode(session('data')) !!}
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    let ttdFile1, ttdFile2, ttdFile3, ttdFile4;

    function getSignatureTechnician(value, status) {
        let disableTechnician = 'disabled';
        let dropzoneTechnician = '';
        let imageTechnician = '';
        let dateTechnicianAttr = '';
        let nameTechnician = '';
        let dateTechnician = '';
        if (account.level.id == '5') {
            nameTechnician = value?.name ? value.name : '';
            dateTechnician = value?.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
            dropzoneTechnician = 'dz-clickable';
            nameTechnician = account.name;
            ttdFile1 = value?.signature ? value.signature : '';
            if(status != 'Terbuat'){
                nameTechnician = value.name;
                dateTechnicianAttr = 'disabled';
                dateTechnician = value.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
                ttdFile1 = value.signature;
                imageTechnician = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            }else{
                imageTechnician = `
            <div action="/upload" class="dropzone needsclick ${dropzoneTechnician} dd" id="ttd1" style="padding: 5px;">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
            }
           
        } else {
            //sudah ttd
            if (value) {
                nameTechnician = value.name;
                dateTechnicianAttr = 'disabled';
                dateTechnician = value.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
                ttdFile1 = value.signature;
                imageTechnician = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else { //belum ttd
                dateTechnicianAttr = 'disabled';
                nameTechnician = account.name;
                imageTechnician = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneTechnician} dd" id="ttd1" style="padding: 5px;">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }

        let appendTechnician = `
                <div class="col-md-3">      
                    <div class="mb-3 text-center">
                        <span class="">Technician</span>
                    </div>              
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="technician-name" name="name[]" value="${nameTechnician ? nameTechnician : ''}" ${dateTechnicianAttr} />
                    </div>
                    <div class="mb-3">
                        ${imageTechnician}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="technician-date" name="name[]" value="${dateTechnician ? dateTechnician : ''}" ${dateTechnicianAttr}/>
                    </div>
                </div>
            `;
        return appendTechnician;
    }

    function getSignatureChief(value) {
        let disableChief = 'disabled';
        let dropzoneChief = '';
        let imageChief = '';
        let dateChiefAttr = '';
        let nameChief = '';
        let dateChief = '';
        if (account.level.id == '6') {
            nameChief = value?.name ? value.name : '';
            dateChief = value?.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
            dropzoneChief = 'dz-clickable';
            nameChief = account.name;
            ttdFile2 = value?.signature ? value.signature : '';
            imageChief = `
            <div action="/upload" class="dropzone needsclick ${dropzoneChief} dd" id="ttd2" style="padding: 5px;">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        } else {
            //sudah ttd
            if (value) {
                nameChief = value.name;
                dateChiefAttr = 'disabled';
                dateChief = value.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
                ttdFile2 = value.signature;
                imageChief = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else { //belum ttd
                dateChiefAttr = 'disabled';
                nameChief = account.name;
                imageChief = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneChief} dd" id="ttd2" style="padding: 5px;">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }

        let appendChief = `
                <div class="col-md-3">  
                    <div class="mb-3 text-center">
                        <span class="">Chief Engineering</span>
                    </div>                  
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="chief-name" name="name[]" value="${nameChief ? nameChief : ''}" ${dateChiefAttr} />
                    </div>
                    <div class="mb-3">
                        ${imageChief}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="chief-date" name="name[]" value="${dateChief ? dateChief : ''}" ${dateChiefAttr}/>
                    </div>
                </div>
            `;
        return appendChief;
    }

    function getSignatureWarehouse(value) {
        let disableWarehouse = 'disabled';
        let dropzoneWarehouse = '';
        let imageWarehouse = '';
        let dateWarehouseAttr = '';
        let nameWarehouse = '';
        let dateWarehouse = '';
        if (account.level.id == '7') {
            nameWarehouse = value?.name ? value.name : '';
            dateWarehouse = value?.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
            dropzoneWarehouse = 'dz-clickable';
            nameWarehouse = account.name;
            ttdFile3 = value?.signature ? value.signature : '';
            imageWarehouse = `
            <div action="/upload" class="dropzone needsclick ${dropzoneWarehouse} dd" id="ttd3" style="padding: 5px;">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        } else {
            //sudah ttd
            if (value) {
                nameWarehouse = value.name;
                dateWarehouseAttr = 'disabled';
                dateWarehouse = value.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
                ttdFile3 = value.signature;
                imageWarehouse = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else { //belum ttd
                dateWarehouseAttr = 'disabled';
                nameWarehouse = account.name;
                imageWarehouse = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneWarehouse} dd" id="ttd3" style="padding: 5px;">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }

        let appendWarehouse = `
                <div class="col-md-3">
                    <div class="mb-3 text-center">
                        <span class="">Warehouse</span>
                    </div>                    
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="warehouse-name" name="name[]" value="${nameWarehouse ? nameWarehouse : ''}" ${dateWarehouseAttr} />
                    </div>
                    <div class="mb-3">
                        ${imageWarehouse}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="warehouse-date" name="name[]" value="${dateWarehouse ? dateWarehouse : ''}" ${dateWarehouseAttr}/>
                    </div>
                </div>
            `;
        return appendWarehouse;
    }

    function getSignatureKepala(value) {
        let disableKepala = 'disabled';
        let dropzoneKepala = '';
        let imageKepala = '';
        let dateKepalaAttr = '';
        let nameKepala = '';
        let dateKepala = '';
        if (account.level.id == '1') {
            nameKepala = value?.name ? value.name : '';
            dateKepala = value?.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
            dropzoneKepala = 'dz-clickable';
            nameKepala = account.name;
            ttdFile4 = value?.signature ? value.signature : '';
            imageKepala = `
            <div action="/upload" class="dropzone needsclick ${dropzoneKepala} dd" id="ttd4" style="padding: 5px;">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        } else {
            //sudah ttd
            if (value) {
                nameKepala = value.name;
                dateKepalaAttr = 'disabled';
                dateKepala = value.date ? moment(value.date, 'Y-MM-DD').format('DD-MM-YYYY') : '';
                ttdFile4 = value.signature;
                imageKepala = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else { //belum ttd
                dateKepalaAttr = 'disabled';
                nameKepala = account.name;
                imageKepala = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneKepala} dd" id="ttd4" style="padding: 5px;">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }

        let appendKepala = `
                <div class="col-md-3">
                    <div class="mb-3 text-center">
                        <span class="">Kepala BM</span>
                    </div>                    
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="kepala-name" name="name[]" value="${nameKepala ? nameKepala : ''}" ${dateKepalaAttr} />
                    </div>
                    <div class="mb-3">
                        ${imageKepala}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="kepala-date" name="name[]" value="${dateKepala ? dateKepala : ''}" ${dateKepalaAttr}/>
                    </div>
                </div>
            `;
        return appendKepala;
    }

    function disabledFlatDate(id, value) {
        $("#" + id).val(value);
        $("#" + id).removeAttr('required');
        $("#" + id).attr('readonly', true);
    }

    function getDateValues(data) {
        if (account.level.id != 1) {
            $("#action_plan_date").val(data.action_plan_date);
            $("#work_order_date").val(data.work_order_date);
            $("#finish_plan").val(data.finish_plan);
            setDate();
        } else {
            disabledFlatDate("action_plan_date", data.action_plan_date);
            disabledFlatDate("work_order_date", data.work_order_date);
            disabledFlatDate("finish_plan", data.finish_plan);
        }
    }

    function date() {
        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });
    }

    function getDataWorkOrder(id) {
        $.ajax({
            url: "{{env('BASE_URL_API')}}" + '/api/work-order/' + id,
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
                let details = data.work_order_signatures;
                $("#no-wo").text('Nomor Work Order : ' + data.work_order_number);
                getLaporanKerusakan(data.damage_report_id);
                getDetails(data.work_order_details);
                getScope(data.scope);
                $("#job_description").val(data.job_description);
                getClassification(data.classification);
                $('#' + data.klasifikasi.toLowerCase()).prop('checked', true);
                let signatureTechnician, signatureChief, signatureKepala, signatureWarehouse;
                for (let i = 0; i < details.length; i++) {
                    if (details[i].position == 'Technician') {
                        signatureTechnician = details[i];
                    } else if (details[i].position == 'Chief Engineering') {
                        signatureChief = details[i];
                    } else if (details[i].position == "Warehouse") {
                        signatureWarehouse = details[i];
                    } else if (details[i].position == "Kepala BM") {
                        signatureKepala = details[i];
                    }
                }

                if(account.level.id == 7){
                    console.log('a');
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.form-control').attr('readonly', 'readonly');
                    $('.form-check-input').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#scope").prop("disabled", true);
                    $("#classification").prop("disabled", true);
                    $("#select-lk").prop("disabled", true);
                    // $("#save").addClass('d-none');
                    // $(".tanda-tangan").prop("disabled", true);
                }

                if(account.level.id == 10){
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.form-control').attr('readonly', 'readonly');
                    $('.form-check-input').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#scope").prop("disabled", true);
                    $("#classification").prop("disabled", true);
                    $("#select-lk").prop("disabled", true);
                    $("#save").addClass('d-none');
                    $(".tanda-tangan").prop("disabled", true);
                }
                
                if(account.level.id != 5){
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.form-control').attr('readonly', 'readonly');
                    $('.form-check-input').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#scope").prop("disabled", true);
                    $("#classification").prop("disabled", true);
                    $("#select-lk").prop("disabled", true);
                    // $("#save").addClass('d-none');
                    // $(".tanda-tangan").prop("disabled", true);
                }

                let htmlGetSignatureTechnician = getSignatureTechnician(signatureTechnician, data.status);
                let htmlGetSignatureChief = getSignatureChief(signatureChief);
                let htmlGetSignatureWarehouse = getSignatureWarehouse(signatureWarehouse);
                let htmlGetSignatureKepala = getSignatureKepala(signatureKepala);
                $('.signatures').html(htmlGetSignatureTechnician + htmlGetSignatureChief + htmlGetSignatureWarehouse + htmlGetSignatureKepala);
                account.level.id == 5 && data.status == 'Terbuat' ? dropzoneValue(signatureTechnician, '#ttd1') : '';
                account.level.id == 6 ? dropzoneValue(signatureChief, '#ttd2') : '';
                account.level.id == 7 ? dropzoneValue(signatureWarehouse, '#ttd3') : '';
                account.level.id == 1 ? dropzoneValue(signatureKepala, '#ttd4') : '';
                
             

                if(data.status !='Terbuat' &&  account.level.id == 5){
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.form-control').attr('readonly', 'readonly');
                    $('.form-check-input').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#scope").prop("disabled", true);
                    $("#classification").prop("disabled", true);
                    $("#select-lk").prop("disabled", true);
                    $("#save").addClass('d-none');
                    $(".tanda-tangan").prop("disabled", true);
                }
                getDateValues(data);
                date();
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    function getScope(data) {
        var data = data.split(',');
        var scopeSelect = $('#scope');
        for (var i = 0; i < data.length; i++) {
            $.ajax({
                type: 'GET',
                url: "{{url('api/scope/')}}/" + data[i],
            }).then(function(data) {
                // create the option and append to Select2
                var option = new Option(data.data.name, data.data.id, true, true);
                scopeSelect.append(option).trigger('change');

                // manually trigger the `select2:select` event
                scopeSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }
    }

    function getClassification(data) {
        var data = data.split(',');
        var classificationSelect = $('#classification');
        for (var i = 0; i < data.length; i++) {
            $.ajax({
                type: 'GET',
                url: "{{ url('api/classification')}}/" + data[i],
            }).then(function(data) {
                // create the option and append to Select2
                var option = new Option(data.data.name, data.data.id, true, true);
                classificationSelect.append(option).trigger('change');

                // manually trigger the `select2:select` event
                classificationSelect.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            });
        }

    }

    function getDetails(details) {
        let tem = '';
        for (let i = 0; i < details.length; i++) {
            tem += `
            <div class="mb-3 row-mg">
                    <div class="row mb-3  d-flex align-items-end">
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Location</label>
                            <input type="text" class="form-control row-input" id="location" name="location[]" placeholder="Location" value="` + details[i].location + `" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Material Request</label>
                            <input type="text" class="form-control row-input" id="material-req" name="material-req[]" placeholder="Material Request" value="` + details[i].material_request + `" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Type /Made In</label>
                            <input type="text" class="form-control row-input" id="type" name="type[]" placeholder="Type /Made In" required value="` + details[i].type + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-2 mb-1-custom"">
                            <label for="note" class="form-label fw-medium">Quantity</label>
                            <input type="number" class="form-control row-input" id="qty" name="qty[]" placeholder="Quantity" required value="` + details[i].quantity + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-1 px-1-custom mb-1-custom">
                            <a role="button" class="btn btn-danger text-center btn-remove-mg text-white"  disabled>
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>`;
        }
        $('#details').prepend(tem);
    }

    // Select2
    function selectLaporan() {
        $(".select-lk").select2({
            placeholder: 'Select Damage Report',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/damage-report/select',
                dataType: 'json',
                cache: true,
                data: function(params) {
                    return {
                        term: params.term || '',
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
    }

    function getLaporanKerusakan(id) {
        if (account.level.id != 1) {
            selectLaporan();
        }else{
            $('#select-lk').removeAttr('required');
            $('#select-lk').attr('disabled', true);
        }

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

    function dropzoneValue(value, id) {
        const myDropzone = new Dropzone(id, {
            parallelUploads: 1,
            maxFilesize: 3,
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            autoQueue: false,
            url: "../uploads/logo",
            thumbnailWidth: 250,
            thumbnailHeight: null,
            init: function() {
                if (value) {
                    let mockFile = {
                        dataURL: value.signature
                    };
                    this.options.addedfile.call(this, mockFile);
                    this.options.thumbnail.call(this, mockFile, value.signature);
                    $('.dz-image').last().find('img').attr('width', '100%');
                    // Optional: Handle the removal of the file
                    mockFile.previewElement.querySelector(".dz-remove").addEventListener("click", function() {
                        // Handle removal logic here
                    });
                }

                this.on('addedfile', function(file) {
                    $('.dz-image').last().find('img').attr('width', '100%');
                    while (this.files.length > this.options.maxFiles) this.removeFile(this.files[0]);
                    if (id == '#ttd1') {
                        ttdFile1 = file;
                    } else if (id == '#ttd2') {
                        ttdFile2 = file;
                    } else if (id == '#ttd3') {
                        ttdFile3 = file;
                    } else if (id == '#ttd4') {
                        ttdFile4 = file;
                    }
                })
            }
        });
    }

    function setDate() {
        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });

        const flatPickrEL = $(".date");
        if (flatPickrEL.length) {
            flatPickrEL.flatpickr({
                allowInput: true,
                monthSelectorType: "static",
                dateFormat: 'd-m-Y'
            });
        }
    }

    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('edit') + 1;
    id = urlSegments[idIndex];
    $(document).ready(function() {
        getDataWorkOrder(id);
        // Create, Insert, Save
        var savewo = $('.create-wo');

        Array.prototype.slice.call(savewo).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                        let laporanKerusakan = $('.select-lk').val();
                        if (!laporanKerusakan) {
                            $('.select-lk').addClass("invalid");
                        }
                    } else {
                        event.preventDefault();
                        Swal.fire({
                            title: '<h2>Loading...</h2>',
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                        let lk = $(".select-lk").val();
                        let datas = {}
                        let signatures = [];
                        let scope = $('#scope').val();
                        let classification = $('#classification').val();
                        let date = moment($('#work_order_date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let action_plan_date = moment($('#action_plan_date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let finish_plan = $('#finish_plan').val();
                        let job_description = $('#job_description').val();

                        datas.damage_report_id = lk;
                        datas.scope = scope.toString();
                        datas.classification = classification.toString();
                        datas.work_order_date = date;
                        datas.action_plan_date = action_plan_date;
                        datas.finish_plan = finish_plan;
                        datas.job_description = job_description;
                        datas.klasifikasi = $('.classif2-checkbox:checked').attr('name');

                        var detail = [];
                        $('.row-input').each(function(index) {
                            var input_name = $(this).attr('name');
                            var input_value = $(this).val();
                            var input_index = Math.floor(index / 4); // Membagi setiap 5 input menjadi satu objek pada array
                            if (index % 4 == 0) {
                                detail[input_index] = {
                                    location: input_value
                                };
                            } else if (index % 4 == 1) {
                                detail[input_index].material_request = input_value;
                            } else if (index % 4 == 2) {
                                detail[input_index].type = input_value;
                            } else if (index % 4 == 3) {
                                detail[input_index].quantity = parseInt(input_value);
                            }
                        });

                        datas.details = detail;
                        let signature = [];
                        if (account.level.id == '1') {
                            datas.status = 'Disetujui BM';
                        } else if (account.level.id == '7') {
                            datas.status = 'Disetujui Warehouse';
                        } else if (account.level.id == '6') {
                            datas.status = 'Disetujui Chief Engineering';
                        } else if (account.level.id == '5') {
                            datas.status = 'Terbuat';
                        }


                        if ($.type(ttdFile1) == 'object') {
                            ttdFile1 = ttdFile1.dataURL;
                        }

                        if ($.type(ttdFile2) == 'object') {
                            ttdFile2 = ttdFile2.dataURL;
                        }

                        if ($.type(ttdFile3) == 'object') {
                            ttdFile3 = ttdFile3.dataURL;
                        }

                        if ($.type(ttdFile4) == 'object') {
                            ttdFile4 = ttdFile4.dataURL;
                        }

                        let signature1 = {};
                        if (ttdFile1 != undefined) {
                            signature1.position = 'Technician';
                            signature1.name = $('#technician-name').val();
                            signature1.date = moment($('#technician-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature1.signature = ttdFile1;
                        }

                        let signature2 = {};
                        if (ttdFile2 != undefined) {
                            signature2.position = 'Chief Engineering';
                            signature2.name = $('#chief-name').val();
                            signature2.date = moment($('#chief-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature2.signature = ttdFile2;
                        }

                        let signature3 = {};
                        if (ttdFile3 != undefined) {
                            signature3.position = 'Warehouse';
                            signature3.name = $('#warehouse-name').val();
                            signature3.date = moment($('#warehouse-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature3.signature = ttdFile3;
                        }

                        let signature4 = {};
                        if (ttdFile4 != undefined) {
                            signature4.position = 'Kepala BM';
                            signature4.name = $('#kepala-name').val();
                            signature4.date = moment($('#kepala-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature4.signature = ttdFile4;
                        }

                        if (!isEmptyObject(signature1)) {
                            signature.push(signature1);
                        }

                        if (!isEmptyObject(signature2)) {
                            signature.push(signature2);
                        }

                        if (!isEmptyObject(signature3)) {
                            signature.push(signature3);
                        }

                        if (!isEmptyObject(signature4)) {
                            signature.push(signature4);
                        }

                        // Validasi dan tambahkan data dari b ke signature
                        // if (!isEmptyObject(signature2)) {
                        //     signature.push(signature2);
                        // }

                        // if (!isEmptyObject(signature3)) {
                        //     signature.push(signature3);
                        // }

                        function isEmptyObject(obj) {
                            return Object.keys(obj).length === 0;
                        }

                        datas.signatures = signature;


                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" + '/api/work-order/' + id,
                            // url: "{{ url('api/work-order')}}/"+id,
                            type: "PATCH",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",

                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil memperbarui Work Order',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    localStorage.removeItem('work-order');
                                    window.location.href = "/complain/work-order"
                                });

                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: errors.responseJSON.message,
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




        // Fungsi untuk mengambil value dari setiap baris
        $('.select-lk').on("change", (async function(e) {
            $(this).removeClass("invalid");
            var laporanKerusakan = $(".select-lk").select2('data');
            var data = laporanKerusakan[0].id;
            $('.select-lk').val(data);
        }));

        // Cancel
        $("#batal").on("click", function(event) {
            event.preventDefault();
            window.location.href = "/complain/work-order"
        })





        // Keyup input qty
        $(document).on('input', '.qty', function() {
            // Menghapus karakter yang bukan angka
            var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');

            // Menetapkan nilai bersih kembali ke input
            $(this).val(sanitizedValue);
        });


        // Select3
        $(".select-scope").select2({
            placeholder: 'Select Scope',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/scope/select',
                dataType: 'json',
                cache: true,
                data: function(params) {
                    return {
                        term: params.term || '',
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

        $('.select-scope').on("change", (async function(e) {
            $(this).removeClass("is-invalid");
        }));

        // Select3
        $(".select-classification").select2({
            placeholder: 'Select classification',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/classification/select',
                dataType: 'json',
                cache: true,
                data: function(params) {
                    return {
                        term: params.term || '',
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

        // Classification 2
        $('.classif2-checkbox').change(function() {
            if ($(this).is(":checked")) {
                // Menonaktifkan semua checkbox dengan class 'classif2-checkbox' kecuali yang sedang dipilih
                $('.classif2-checkbox').not(this).prop('disabled', true);
            } else {
                // Mengaktifkan kembali semua checkbox dengan class 'classif2-checkbox'
                $('.classif2-checkbox').prop('disabled', false);
            }
        });


        $(document).on('click', '.btn-remove-mg', function() {
            // Hapus baris yang ditekan tombol hapus
            $(this).closest('.row-mg').remove();
        });

        $(document).keypress(
            function(event){
                if (event.which == '13') {
                    event.preventDefault();
                }
            }
        );


        $(document).on('click', '.btn-add-row-mg', function() {
            // Clone baris terakhir
            var $details = $('#details');
            var $newRow = `
            <div class="mb-3 row-mg">
                <div class="row mb-3  d-flex align-items-end">
                     <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Location</label>
                        <input type="text" class="form-control row-input" id="location" name="location[]" placeholder="Location" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Material Request</label>
                        <input type="text" class="form-control row-input" id="material-req" name="material-req[]" placeholder="Material Request" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Type /Made In</label>
                        <input type="text" class="form-control row-input" id="type" name="type[]" placeholder="Type /Made In" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-2 mb-1-custom"">
                        <label for="note" class="form-label fw-medium">Quantity</label>
                        <input type="text" class="form-control qty row-input" id="qty" name="qty[]" placeholder="Quantity" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-1 px-1-custom mb-1-custom">
                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white"  disabled>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;
            $details.append($newRow);
        });
    });
</script>
@endsection