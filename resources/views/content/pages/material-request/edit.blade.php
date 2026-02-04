@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Material Request')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-material-request" class="create-material-request" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div class="row m-sm-4 m-0">
                            <h1 class="text-center"><b>MATERIAL REQUEST</b></h1>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Requester</label>
                                    <input type="text" readonly class="form-control" placeholder="Requester" name="requester" id="requester" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Departement </label>
                                    <input type="text" readonly class="form-control" placeholder="Departement" name="department" id="department" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Stock </label>
                                    <input type="number" readonly class="form-control" placeholder="Stock" id="stock" name="stock" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Purchase </label>
                                    <input type="text" readonly class="form-control" placeholder="Purchase" name="purchase" id="purchase" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Tanggal</label>
                                    <input type="text" readonly class="form-control date" placeholder="Tanggal" name="request_date" id="request_date" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <textarea readonly class="form-control" rows="6" id="note" name="note" placeholder="Catatan" required></textarea>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 px-3">
                            <div class="card academy-content shadow-none border p-3">
                                <div class="">
                                    <div class="table-responsive">
                                        <div class="" id="details">

                                        </div>
                                    </div>
                                    <div class="row pb-4 add-row">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-add-row-mg mt-2">Tambah Baris</button>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}">
</script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}">
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let account = {!! json_encode(session('data')) !!}

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;

    let data = JSON.parse(localStorage.getItem("material-request"));
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('edit') + 1;
    id = urlSegments[idIndex];

    getDataMaterialRequest(id);

    let ttdFile1, ttdFile2, ttdFile3, ttdFile4;

    function getDataMaterialRequest(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{env('BASE_URL_API')}}" +'/api/material-request/' + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                let data = res.data;
               

                let details = data.material_request_signatures;
                $("#requester").val(data.requester);
                $("#department").val(data.department);
                $("#request_date").val(data.request_date);
                $("#stock").val(data.stock);
                $("#purchase").val(data.purchase);
                $("#note").val(data.note);
                getDetails(data.material_request_details);
                let signatureWarehouse, signatureChiefDepartment, signatureChiefFinance, signatureKepalaBm = null;

                for (let i = 0; i < details.length; i++) {
                    if(details[i].type == 'Prepared By'){
                        signatureWarehouse = details[i];
                    }else if(details[i].type == 'Reviewed By'){
                        signatureChiefDepartment = details[i];

                    }else if(details[i].type == 'Aknowledge By'){
                        signatureChiefFinance = details[i];
                    }else if(details[i].type == 'Approved By'){
                        signatureKepalaBm = details[i];
                    }
                }
                
                let htmlGetSignatureWarehouse = getSignatureWarehouse(signatureWarehouse);
                let htmlGetSignatureChiefDepartment = getSignatureChiefDepartment(signatureChiefDepartment);
                let htmlGetSignatureChiefFinance = getSignatureChiefFinance(signatureChiefFinance);
                let htmlGetSignatureKepalaBm = getSignatureKepalaBm(signatureKepalaBm);


                $('.signatures').html(htmlGetSignatureWarehouse+htmlGetSignatureChiefDepartment+htmlGetSignatureChiefFinance+htmlGetSignatureKepalaBm);
                account.level.id == 7 ? dropzoneValue(signatureWarehouse, '#ttd1'):'';
                account.level.id == 8 ? dropzoneValue(signatureChiefDepartment, '#ttd2'):'';
                account.level.id == 9 ? dropzoneValue(signatureChiefFinance, '#ttd3'):'';
                account.level.id == 1 ? dropzoneValue(signatureKepalaBm, '#ttd4'):'';
                account.level.id != '7' ? ($('.add-row').hide(), $('.button-delete').hide()) : ($('.add-row').show(), $('.button-delete').hide());
                setDate();
                if(data.status !='Terbuat' && account.level.id == 10){
                    $('.form-control').attr('readonly', 'readonly');
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.data-input, .select-classification, .row-input').attr('disabled', 'disabled');
                    $('.select2').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#save").addClass('d-none');
                }
                Swal.close();
            },
            error: function(errors) {
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
                    if(id == '#ttd1'){
                        ttdFile1 = file;
                    }else if(id == '#ttd2'){
                        ttdFile2 = file;
                    }else if(id == '#ttd3'){
                        ttdFile3 = file;
                    }else if(id == '#ttd4'){
                        ttdFile4 = file;
                    }
                })
            }
        });
    }

    function getDetails(details) {
        let tem = '';
        for (let i = 0; i < details.length; i++) {
            tem += `
                <tr>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 150px;" value="` + details[i].number + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 150px;" value="` + details[i].part_number + `"/>
                    </td>
                    <td>
                        <textarea readonly class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 150px;">`+ details[i].description +`</textarea>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 150px;" value="` + details[i].quantity + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Stock" name="stock[]" required style="width: 150px;" value="` + details[i].stock + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Stock Out" name="stock_out[]" required style="width: 150px;" value="` + details[i].stock_out + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="End Stock" name="end_stock[]" required style="width: 150px;" value="` + details[i].end_stock + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Min Stock" name="min_stock" [] required style="width: 150px;" value="` + details[i].min_stock + `"/>
                    </td>
                    <td class="button-delete">
                        <a role="button" class="btn btn-primary text-center btn-remove-mg text-white ms-4" disabled>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            `;
        }
        let getDetail = `
        <table class="table">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Part Number</th>
                    <th>Deskripsi</th>
                    <th>Quantity</th>
                    <th class="text-center" colspan="5">Filled Storekeeper Only</th>
                </tr>
            </thead>
            <tbody>
                ${tem}
            </tbody>
        </table>
        `;
        $('#details').prepend(getDetail);
    }

    function getSignatureWarehouse(value){
        let disablePrepared = 'disabled';
        let dropzonePrepared = '';
        let imagePrepared = '';
        let datePreparedAttr = '';
        let namePrepared = '';
        let datePrepared = '';
        if(account.level.id == '7'){
            namePrepared = value?.name ? value.name : '';
            datePrepared = value?.date ? moment(value.date).format('DD-MM-YYYY') : '';
            dropzonePrepared = 'dz-clickable';
            namePrepared = account.name;
            ttdFile1 = value.signature;
            imagePrepared = `
            <div action="/upload" class="dropzone needsclick ${dropzonePrepared} dd" id="ttd1">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        }else{
            //sudah ttd
            if(value){
                namePrepared = value.name;
                datePreparedAttr = 'disabled';
                datePrepared = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
                ttdFile1 = value.signature;
                imagePrepared = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else {
                datePreparedAttr = 'disabled';
                imagePrepared = `
                <div action="/upload" class="dropzone needsclick ${dropzonePrepared} dd" id="ttd1">
                    <div class="dz-message needsclick">
                        <span class="note needsclick">Unggah Tanda Tangan</span>
                    </div>
                </div>
                `;
            }
        }
        let appendPrepared = `
            <div class="col-md-3">
                <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="warehouse-name" name="name[]" value="${namePrepared ? namePrepared : ''}" ${datePreparedAttr} />
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="warehouse-jabatan" name="jabatan[]" value="Warehouse" disabled />
                </div>
                <div class="mb-3">
                    ${imagePrepared}
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="warehouse-date" name="name[]" value="${datePrepared ? datePrepared : ''}" ${datePreparedAttr}/>
                </div>
            </div>
        `;
        return appendPrepared;
    }

    function getSignatureChiefDepartment(value){
        let disableReviewed = 'disabled';
        let dropzoneReviewed = '';
        let imageReviewed = '';
        let dateReviewedAttr = '';
        let nameReviewed = '';

        let dateReviewed = '';
        if(account.level.id == '2' || account.level.id == '6' || account.level.id == '9' || account.level.id == '13'){
            nameReviewed = value?.name ? value.name : '';
            dateReviewed = value?.date ? moment(value.date).format('DD-MM-YYYY') : '';
            dropzoneReviewed = 'dz-clickable';
            nameReviewed = account.name;
            ttdFile2 = value != undefined ? value.signature : "";
            imageReviewed = `
            <div action="/upload" class="dropzone needsclick ${dropzoneReviewed} dd" id="ttd2">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
            //tanda tangannya ada maka tampoilkan seperti edit kepala bm invoice
        }else{
            //sudah ttd
            if(value){
                nameReviewed = value.name;
                dateReviewedAttr = 'disabled';
                ttdFile2 = value.signature;
                dateReviewed = value?.date ? moment(value.date).format('DD-MM-YYYY') : '';
                imageReviewed = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            }else{//belum ttd
                dateReviewedAttr = 'disabled';
                imageReviewed = `
                <div action="/upload" class="dropzone needsclick ${dropzoneReviewed} dd" id="ttd2">
                    <div class="dz-message needsclick">
                        <span class="note needsclick">Unggah Tanda Tangan</span>
                    </div>
                </div>
                `;
            }
        }
        let appendReviewed = `
            <div class="col-md-3">
                <label for="note" class="form-label fw-medium mb-3">Reviewed by :</label>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="departement-name" name="name[]" value="${nameReviewed ? nameReviewed : ''}" ${dateReviewedAttr} />
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="departement-jabatan" name="jabatan[]" value="${account.level.name}" disabled />
                </div>
                <div class="mb-3">
                    ${imageReviewed}
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="departement-date" name="name[]" value="${dateReviewed ? dateReviewed : ''}" ${dateReviewedAttr}/>
                </div>
            </div>
        `;
        return appendReviewed;
    }

    function getSignatureChiefFinance(value){
        let disableAknowledge = 'disabled';
        let dropzoneAknowledge = '';
        let imageAknowledge = '';
        let dateAknowledgeAttr = '';
        let nameAknowledge = '';
        let dateAknowledge = '';
        if(account.level.id == '9'){
            nameAknowledge = value?.name ? value.name : '';
            dateAknowledge = value?.date ? moment(value.date).format('DD-MM-YYYY') : '';
            dropzoneAknowledge = 'dz-clickable';
            nameAknowledge = account.name;
            if(value){
                ttdFile3 = value.signature;
            }
            imageAknowledge = `
            <div action="/upload" class="dropzone needsclick ${dropzoneAknowledge} dd" id="ttd3">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        }else{
            //sudah ttd
            if(value){
                nameAknowledge = value.name;
                dateAknowledgeAttr = 'disabled';
                dateAknowledge = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
                ttdFile3 = value.signature;
                nameAknowledge = account.name;
                imageAknowledge = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            }else{//belum ttd
                dateAknowledgeAttr = 'disabled';
                imageAknowledge = `
                <div action="/upload" class="dropzone needsclick ${dropzoneAknowledge} dd" id="ttd3">
                    <div class="dz-message needsclick">
                        <span class="note needsclick">Unggah Tanda Tangan</span>
                    </div>
                </div>
                `;
            }
        }

        let appendAknowledge = `
            <div class="col-md-3">
                <label for="note" class="form-label fw-medium mb-3">Aknowledge by :</label>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="finance-name" name="name[]" value="${nameAknowledge ? nameAknowledge : ''}" ${dateAknowledgeAttr} />
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="finance-jabatan" name="jabatan[]" value="Chief Finance & Akunting" disabled />
                </div>
                <div class="mb-3">
                    ${imageAknowledge}
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="finance-date" name="name[]" value="${dateAknowledge ? dateAknowledge : ''}" ${dateAknowledgeAttr}/>
                </div>
            </div>
        `;
        return appendAknowledge;
    }

    function getSignatureKepalaBm(value){
        let disableApproved = 'disabled';
        let dropzoneApproved = '';
        let imageApproved = '';
        let dateApprovedAttr = '';
        let nameApproved = '';
        let dateApproved = '';
        if(account.level.id == '1'){
            nameApproved = value?.name ? value.name : '';
            dateApproved = value?.date ? moment(value.date).format('DD-MM-YYYY') : '';
            dropzoneApproved = 'dz-clickable';
            nameApproved = account.name;
            if(value){
                ttdFile4= value.signature;
            }
            imageApproved = `
            <div action="/upload" class="dropzone needsclick ${dropzoneApproved} dd" id="ttd4">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        }else{
            //sudah ttd
            if(value){
                nameApproved = value.name;
                dateApprovedAttr = 'disabled';
                dateApproved = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
                ttdFile4= value.signature;
                imageApproved = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            }else{//belum ttd
                dateApprovedAttr = 'disabled';
                imageApproved = `
                <div action="/upload" class="dropzone needsclick ${dropzoneApproved} dd" id="ttd4">
                    <div class="dz-message needsclick">
                        <span class="note needsclick">Unggah Tanda Tangan</span>
                    </div>
                </div>
                `;
            }
        }
        let appendApproved = `
            <div class="col-md-3">
                <label for="note" class="form-label fw-medium mb-3">Approved by :</label>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="bm-name" name="name[]" value="${nameApproved ? nameApproved : ''}" ${dateApprovedAttr} />
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="bm-jabatan" name="jabatan[]" value="Kepala BM" disabled />
                </div>
                <div class="mb-3">
                    ${imageApproved}
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="bm-date" name="name[]" value="${dateApproved ? dateApproved : ''}" ${dateApprovedAttr}/>
                </div>
            </div>
        `;
        return appendApproved;
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


    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        localStorage.removeItem('material-request');
        window.location.href = "/request/material-request"
    });

    var saveMaterial = $('.create-material-request');

    Array.prototype.slice.call(saveMaterial).forEach(function(form) {
        $('.indicator-progress').hide();
        $('.indicator-label').show();
        form.addEventListener(
            "submit",
            function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    Swal.fire({
                        title: '<h2>Loading...</h2>',
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                    // Submit your form
                    event.preventDefault();
                    // let fileTtd = ttdFile.dataURL;
                    let requester = $("#requester").val();
                    let department = $("#department").val();
                    let request_date = moment($("#request_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                    let stock = $("#stock").val();
                    let purchase = $("#purchase").val();
                    let note = $("#note").val();

                    let datas = {};

                    var details = [];
                    $('.row-input').each(function(index) {
                        var input_name = $(this).attr('name');
                        var input_value = $(this).val();
                        var input_index = Math.floor(index / 8); // Membagi setiap 5 input menjadi satu objek pada array
                        if (index % 8 == 0) {
                            details[input_index] = {
                                number: input_value
                            };
                        } else if (index % 8 == 1) {
                            details[input_index].part_number = input_value;
                        } else if (index % 8 == 2) {
                            details[input_index].description = input_value;
                        } else if (index % 8 == 3) {
                            details[input_index].quantity = input_value;
                        } else if (index % 8 == 4) {
                            details[input_index].stock = input_value;
                        } else if (index % 8 == 5) {
                            details[input_index].stock_out = input_value;
                        } else if (index % 8 == 6) {
                            details[input_index].end_stock = input_value;
                        } else if (index % 8 == 7) {
                            details[input_index].min_stock = input_value;
                        }
                    });
                    datas.details = details;
                    datas.requester = requester;
                    datas.department = department;
                    datas.purchase = purchase;
                    datas.stock = stock;
                    datas.request_date = request_date;
                    datas.note = note;
                    let signature = [];
                    if(account.level.id == '8'){
                        datas.status = 'disetujui chief departement';
                    }else if(account.level.id == '9'){
                        datas.status = 'disetujui chief finance';
                    }else if(account.level.id == '1'){
                        datas.status = 'disetujui kepala bm';
                    }

                    if($.type(ttdFile1) == 'object'){
                        ttdFile1 = ttdFile1.dataURL;
                    }

                    if($.type(ttdFile2) == 'object'){
                        ttdFile2 = ttdFile2.dataURL;
                    }

                    if($.type(ttdFile3) == 'object'){
                        ttdFile3 = ttdFile3.dataURL;
                    }

                    if($.type(ttdFile4) == 'object'){
                        ttdFile4 = ttdFile4.dataURL;
                    }

                    let signature1 = {};
                    if(ttdFile1 != undefined){
                        signature1.type = 'Prepared By';
                        signature1.name = $('#warehouse-name').val();
                        signature1.date = moment($('#warehouse-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        signature1.signature = ttdFile1;
                    }

                    let signature2 = {};
                    if(ttdFile2 != undefined){
                        signature2.type = 'Reviewed By';
                        signature2.name = $('#departement-name').val();
                        signature2.date = moment($('#departement-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        signature2.signature = ttdFile2;
                    }

                    let signature3 = {};
                    if(ttdFile3 != undefined){
                        signature3.type = 'Aknowledge By';
                        signature3.name = $('#finance-name').val();
                        signature3.date = moment($('#finance-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        signature3.signature = ttdFile3;
                    }

                    let signature4 = {};
                    if(ttdFile4 != undefined){
                        signature4.type = 'Approved By';
                        signature4.name = $('#bm-name').val();
                        signature4.date = moment($('#bm-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        signature4.signature = ttdFile4;
                    }

                    if (!isEmptyObject(signature1)) {
                        signature.push(signature1);
                    }

                    // Validasi dan tambahkan data dari b ke signature
                    if (!isEmptyObject(signature2)) {
                        signature.push(signature2);
                    }

                    if (!isEmptyObject(signature3)) {
                        signature.push(signature3);
                    }

                    if (!isEmptyObject(signature4)) {
                        signature.push(signature4);
                    }

                    function isEmptyObject(obj) {
                        return Object.keys(obj).length === 0;
                    }
                    datas.signatures = signature;
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" + "/api/material-request/"+id,
                        type: "PATCH",
                        data: JSON.stringify(datas),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            $('.indicator-progress').show();
                            $('.indicator-label').hide();

                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Memperbaharui Material Request',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(function() {
                                localStorage.removeItem('material-request');
                                window.location.href = "/request/material-request"
                            })

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
</script>
@endsection