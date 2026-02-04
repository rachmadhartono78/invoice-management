@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Purchase Request')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-pr" class="create-pr" novalidate>
        <div class="row purchase-req-add" id="addPurchaseRequest">
            <!-- purchase req Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card purchase-req-preview-card">
                    <div class="card-body">
                        <div class="row m-sm-4 m-0">
                            <div class="col-md-12 mb-md-0 mb-4 ps-0">
                                <h1 class="fw-700 text-center" style="margin: 0;"><b>PURCHASE REQUEST</b></h1>
                            </div>
                        </div>
                        <hr class="my-3 mx-n4">

                        <div class="row">
                            {{-- Form Kiri --}}
                            <div class="col-md-5 py-3 px-3">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Yang Meminta </label>
                                        <input type="text" class="form-control add" placeholder="Yang Meminta" id="requester" name="requester" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Departemen </label>
                                        <select class="form-control w-px-200 select2 " id="department_id" name="department_id" required>
                                        </select>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Jumlah Anggaran </label>
                                        <input type="text" class="form-control" id="total_budget" name="total_budget" placeholder="Jumlah Anggaran" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Usulan Permintaan </label>
                                        <input type="text" class="form-control" id="proposed_purchase_price" name="proposed_purchase_price" placeholder="Usulan Permintaan" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Sisa Anggaran </label>
                                        <input type="text" class="form-control" id="remaining_budget" name="remaining_budget" placeholder="Sisa Anggaran" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Kanan --}}
                            <div class="d-flex flex-wrap justify-content-between col-md-7 py-3 px-3">
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Nomor PR </label>
                                        <input type="text" class="form-control" placeholder="Nomor PR" id="purchase_request_number" name="purchase_request_number" disabled />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Tanggal PR </label>
                                        <input type="text" class="form-control add date" id="request_date" name="request_date" placeholder="Tanggal PR" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="nomor_mr" class="form-label fw-medium">Nomor MR </label>
                                        <select class="form-control w-px-200 select2 " id="material_request_id" name="material_request_id" required>
                                        </select>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Tanggal MR</label>
                                        <input type="text" class="form-control" id="tanggal_mr" name="tanggal_mr" placeholder="Tanggal MR" disabled />
                                        <div class="invalid-feedback" style="display: none">Tidak boleh kosong</div>
                                    </div>
                                </div> -->
                                <div class="col-md-12 mt-2">
                                    <div class="mb-1">
                                        <textarea class="form-control add" rows="7" style="padding: 15px" id="additional_note" name="additional_note" placeholder="Termin pembayaran, garansi dll" required></textarea>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Radio Button --}}
                        <div class="row py-3 px-3">
                            <div class="col-12">
                                <div class="">
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="Sesuai Budget" id="sesuai-budget">
                                        <label class="form-check-label" for="sesuai_budget">Sesuai Budget</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="Diluar Budget" id="diluar-budget">
                                        <label class="form-check-label" for="diluar_budget">Diluar Budget</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="penting" id="penting">
                                        <label class="form-check-label" for="penting">Penting</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="1 Minggu" id="1-minggu">
                                        <label class="form-check-label" for="1_minggu">1 Minggu</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="1 Bulan" id="1-bulan">
                                        <label class="form-check-label" for="1_bulan">1 Bulan</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="py-3 px-3">
                            <div class="card academy-content shadow-none border p-3">
                                {{-- Tambah Baris --}}
                                <div class="table-responsive">
                                    <div class="" id="details">
                                    </div>

                                    <div class="row pb-4">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-add-row-mg mt-2">Tambah Baris</button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="row py-3 px-3">
                                    <hr class="my-3 mx-auto">
                                </div>

                                {{-- Tanda tangan --}}

                                <div class="row mb-3 mt-3 text-center signatures">

                                </div>

                                <div class="row ttd">
                                    <div class="col-2">
                                        <p>
                                            Lembar
                                        </p>
                                    </div>
                                    <div class="col-6 row flex-wrap">
                                        <div class="col-6 order-1">1. Accounting (Putih)</div>
                                        <div class="col-6 order-3">2. Gudang (Merah)</div>

                                        <!-- Force next columns to break to new line -->
                                        <div class="w-100"></div>

                                        <div class="col-6 order-2">3. Purchasing (Hijau)</div>
                                        <div class="col-6 order-4">4. Pemohon (Biru)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /purchase req Add-->

            <!-- purchase req Actions -->
            <div class="col-lg-3 col-12 purchase-req-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Update</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
                    </div>
                </div>
            </div>
            <!-- /purchase req Actions -->
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
    var lastIndex = null;

    let ttdFile1, ttdFile2, ttdFile3;

    function format(e) {
        var nStr = e + '';
        nStr = nStr.replace(/\,/g, "");
        let x = nStr.split('.');
        let x1 = x[0];
        let x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }



    function getSignaturePrepared(value) {
        let disablePrepared = 'disabled';
        let dropzonePrepared = '';
        let imagePrepared = '';
        let datePreparedAttr = '';
        let namePrepared = '';
        let datePrepared = '';
        if (account.level.id == '10') {
            namePrepared = value?.name ? value.name : '';
            datePrepared = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
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
        } else {
            //sudah ttd
            if (value) {
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
            } else { //belum ttd
                datePreparedAttr = 'disabled';
                imagePrepared = `
                    <div action="/upload" class="dropzone needsclick ${datePreparedAttr} dd" id="ttd1">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }
        let appendPrepared = `
                <div class="col-md-4">
                    <label for="note" class="form-label fw-medium mb-3">Diproses by :</label>
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="admin-name" name="name[]" value="${namePrepared ? namePrepared : ''}" ${datePreparedAttr} />
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="admin-jabatan" name="jabatan[]" value="Admin" disabled />
                    </div>
                    <div class="mb-3">
                        ${imagePrepared}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="admin-date" name="name[]" value="${datePrepared ? datePrepared : ''}" ${datePreparedAttr}/>
                    </div>
                </div>
            `;
        return appendPrepared;
    }

    function getSignatureCheked(value) {
        let disableChecked = 'disabled';
        let dropzoneChecked = '';
        let imageChecked = '';
        let dateCheckedAttr = '';
        let nameChecked = '';
        let dateChecked = '';
        if (account.level.id == '2') {
            nameChecked = value?.name ? value.name : '';
            dateChecked = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
            dropzoneChecked = 'dz-clickable';
            nameChecked = account.name;
            ttdFile2 = value?.signature ? value.signature : '';
            imageChecked = `
            <div action="/upload" class="dropzone needsclick ${dropzoneChecked} dd" id="ttd2">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        } else {
            //sudah ttd
            if (value) {
                nameChecked = value.name;
                dateCheckedAttr = 'disabled';
                dateChecked = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
                ttdFile2 = value.signature;
                imageChecked = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else { //belum ttd
                dateCheckedAttr = 'disabled';
                imageChecked = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneChecked} dd" id="ttd2">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }

        let appendChecked = `
                <div class="col-md-4">
                    <label for="note" class="form-label fw-medium mb-3">Diperiksa by :</label>
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="unit-name" name="name[]" value="${nameChecked ? nameChecked : ''}" ${dateCheckedAttr} />
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="unit-jabatan" name="jabatan[]" value="Kepala Unit" disabled />
                    </div>
                    <div class="mb-3">
                        ${imageChecked}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="unit-date" name="name[]" value="${dateChecked ? dateChecked : ''}" ${dateCheckedAttr}/>
                    </div>
                </div>
            `;
        return appendChecked;
    }

    function getSignatureKnown(value) {
        let disableKnown = 'disabled';
        let dropzoneKnown = '';
        let imageKnown = '';
        let dateKnownAttr = '';
        let nameKnown = '';
        let dateKnown = '';
        if (account.level.id == '1') {
            nameKnown = value?.name ? value.name : '';
            dateKnown = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
            dropzoneKnown = 'dz-clickable';
            nameKnown = account.name;
            ttdFile3 = value?.signature ? value.signature : '';;
            imageKnown = `
            <div action="/upload" class="dropzone needsclick ${dropzoneKnown} dd" id="ttd3">
                <div class="dz-message needsclick">
                    <span class="note needsclick">Unggah Tanda Tangan</span>
                </div>
            </div>
            `;
        } else {
            //sudah ttd
            if (value) {
                nameKnown = value.name;
                dateKnown = 'disabled';
                dateKnown = value.date ? moment(value.date).format('DD-MM-YYYY') : '';
                ttdFile3 = value.signature;
                imageKnown = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
            } else { //belum ttd
                dateKnownAttr = 'disabled';
                imageKnown = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneKnown} dd" id="ttd3">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            }
        }
        let appendKnown = `
                <div class="col-md-4">
                    <label for="note" class="form-label fw-medium mb-3">Diketahui by :</label>
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="bm-name" name="name[]" value="${nameKnown ? nameKnown : ''}" ${dateKnownAttr} />
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="bm-jabatan" name="jabatan[]" value="Kepala BM" disabled />
                    </div>
                    <div class="mb-3">
                        ${imageKnown}
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="bm-date" name="name[]" value="${dateKnown ? dateKnown : ''}" ${dateKnownAttr}/>
                    </div>
                </div>`;
        return appendKnown;
    }

    function getDepartemen(id) {
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/department/' + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#department_id").empty().append("<option value=" + data.id + ">" + data.name + "</option>").val(data.id).trigger("change");
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }
  
    function getMaterial(id) {
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/material-request/' + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#material_request_id").empty().append("<option value=" + data.id + ">" + data.material_request_number + "</option>").val(data.id).trigger("change");
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function getDataPurchaseRequest(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{env('BASE_URL_API')}}" + '/api/purchase-request/' + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                var data = res.data;
                if((data.status !='Terbuat' &&  account.level.id == 10)){
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.form-control').attr('readonly', 'readonly');
                    $('.form-check-input').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#save").addClass('d-none');
                    $(".tanda-tangan").prop("disabled", true);
                }
                let details = data.purchase_request_signatures;
                $("#additional_note").val(data.additional_note);
                $("#budget_status").val(data.budget_status);
                getDepartemen(data.department_id);
                getMaterial(data.material_request_id);
                $("#proposed_purchase_price").val(format(data.proposed_purchase_price));
                $("#purchase_request_number").val(data.purchase_request_number);
                $("#remaining_budget").val(format(data.remaining_budget));
                $("#request_date").val(data.request_date);
                $("#requester").val(data.requester);
                $("#material_request_id").val(data.material_request.material_request_number);
                $("#total_budget").val(format(data.total_budget));
                $('#' + data.budget_status.toLowerCase()).prop('checked', true);
                getDetails(data.purchase_request_details);

                let signatureKepalaBm, signatureKepalaUnit, signatureAdmin;
                for (let i = 0; i < details.length; i++) {
                    if (details[i].type == 'Prepared By') {
                        signatureAdmin = details[i];
                    } else if (details[i].type == 'Checked By') {
                        signatureKepalaUnit = details[i];
                    } else if (details[i].type == "Known By") {
                        signatureKepalaBm = details[i];
                    }
                }

                let htmlGetSignatureAdmin = getSignaturePrepared(signatureAdmin);
                let htmlGetSignatureKepalaUnit = getSignatureCheked(signatureKepalaUnit);
                let htmlGetSignatureKepalaBm = getSignatureKnown(signatureKepalaBm);
                $('.signatures').html(htmlGetSignatureAdmin + htmlGetSignatureKepalaUnit + htmlGetSignatureKepalaBm);

                account.level.id == 10 ? dropzoneValue(signatureAdmin, '#ttd1') : '';
                account.level.id == 2 ? dropzoneValue(signatureKepalaUnit, '#ttd2') : '';
                account.level.id == 1 ? dropzoneValue(signatureKepalaBm, '#ttd3') : '';
                setDate();
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });


    }

    function getDetails(details) {
        let tem = '';
        for (let i = 0; i < details.length; i++) {
            tem += `
                <tr>
                    <td>
                        <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]"  value="` + details[i].number + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" value="` + details[i].part_number + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="text" class="date form-control row-input" placeholder="Tanggal" name="last_buy_date[]" value="` + details[i].last_buy_date + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" value="` + details[i].last_buy_quantity + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="number" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" value="` + details[i].last_buy_stock + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;">` + details[i].description + `</textarea>
                    </td>
                    <td>
                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" value="` + details[i].quantity + `" readonly style="width: 200px;" />
                    </td>
                 </tr>`;
        }
        let getDetail = `
                <table class="table">
                        <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Part Number</th>
                                        <th colspan="3" class="text-center">Pembelian Terakhir</th>
                                        <th>Keterangan</th>
                                        <th>Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tem}
                                </tbody>
                            </table>`;
        $('#details').prepend(getDetail);
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

        getDataPurchaseRequest(id);

        $(document).on('keydown', '#total_budget', function(event) {
            var key = event.which;
            if ((key < 48 || key > 57) && key != 8) event.preventDefault();
        });

        $(document).on('input', '#total_budget', function(event) {
            var nStr = event.currentTarget.value + '';
            nStr = nStr.replace(/\,/g, "");
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            event.currentTarget.value = x1 + x2;
            // Hapus baris yang ditekan tombol hapus
            let total = parseFloat($(this).val().replaceAll(',', ''));

            let proposed_purchase_price = isNaN(parseFloat($(`#proposed_purchase_price`).val().replaceAll(',', ''))) ? 0 : parseFloat($(`#proposed_purchase_price`).val().replaceAll(',', ''));

            let remaining_budget = total - proposed_purchase_price;

            $('#remaining_budget').val(format(isNaN(remaining_budget) ? 0 : remaining_budget));

        });

        $(document).on('input', '#proposed_purchase_price', function(event) {
            var nStr = event.currentTarget.value + '';
            nStr = nStr.replace(/\,/g, "");
            var x = nStr.split('.');
            var x1 = x[0];
            var x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            event.currentTarget.value = x1 + x2;
            // Hapus baris yang ditekan tombol hapus
            let proposed_purchase_price = parseFloat($(this).val().replaceAll(',', ''));
            let total = isNaN(parseFloat($(`#total_budget`).val().replaceAll(',', ''))) ? 0 : parseFloat($(`#total_budget`).val().replaceAll(',', ''));

            let remaining_budget = total - proposed_purchase_price;

            $('#remaining_budget').val(format(isNaN(remaining_budget) ? 0 : remaining_budget));

        });

        $(document).on('click', '.btn-remove-mg', function() {
            // Hapus baris yang ditekan tombol hapus
            $(this).closest('.row-mg').remove();
        });


        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            window.location.href = "/request/list-purchase-request"
        });


        $(document).on('click', '.btn-add-row-mg', function() {
            // Clone baris terakhir

            var $details = $('#details');
            var $newRow = `
                            <table class="table row-mg">
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="text" class="date form-control row-input" placeholder="Tanggal" name="last_buy_date[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <a role="button" class="btn btn-danger text-center btn-remove-mg text-white ms-4" disabled>
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
            `;
            $details.append($newRow);
            $('.date').flatpickr({
                dateFormat: 'd-m-Y'
            });
        });







        // Save, Insert and Create
        var savepr = $('#create-pr');

        Array.prototype.slice.call(savepr).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        event.preventDefault();
                        Swal.fire({
                            title: '<h2>Loading...</h2>',
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });

                        let department_id = $("#department_id").val();
                        let proposed_purchase_price = parseFloat($("#proposed_purchase_price").val().replaceAll(',', ''));
                        let budget_status = $('.checkbox-check:checked').attr('id');;
                        let request_date = moment($("#request_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let requester = $("#requester").val();
                        let total_budget = $("#total_budget").val().replaceAll(',', '');
                        let remaining_budget = parseFloat($("#remaining_budget").val().replaceAll(',', ''));
                        let material_request_id = parseFloat($("#material_request_id").val());
                        let additional_note = $("#additional_note").val();
                        let datas = {};

                        var detail = [];
                        $('.row-input').each(function(index) {
                            var input_name = $(this).attr('name');
                            var input_value = $(this).val();
                            var input_index = Math.floor(index / 7); // Membagi setiap 5 input menjadi satu objek pada array
                            if (index % 7 == 0) {
                                detail[input_index] = {
                                    number: input_value
                                };
                            } else if (index % 7 == 1) {
                                detail[input_index].part_number = input_value;
                            } else if (index % 7 == 2) {
                                detail[input_index].last_buy_date = moment(input_value, 'DD-MM-YYYY').format('YYYY-MM-DD');
                            } else if (index % 7 == 3) {
                                detail[input_index].last_buy_quantity = parseFloat(input_value);
                            } else if (index % 7 == 4) {
                                detail[input_index].last_buy_stock = parseFloat(input_value);
                            } else if (index % 7 == 5) {
                                detail[input_index].description = input_value;
                            } else if (index % 7 == 6) {
                                detail[input_index].quantity = parseFloat(input_value);
                            }
                        });


                        let signature = [];
                        if (account.level.id == '1') {
                            datas.status = 'Disetujui BM';
                        } else if (account.level.id == '2' || account.level.id == '9') {
                            datas.status = 'Disetujui KA';
                        } else if (account.level.id == '10') {
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

                        let signature1 = {};
                        if (ttdFile1 != undefined) {
                            signature1.type = 'Prepared By';
                            signature1.name = $('#admin-name').val();
                            signature1.date = moment($('#admin-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature1.signature = ttdFile1;
                        }

                        let signature2 = {};
                        if (ttdFile2 != undefined) {
                            signature2.type = 'Checked By';
                            signature2.name = $('#unit-name').val();
                            signature2.date = moment($('#unit-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature2.signature = ttdFile2;
                        }

                        let signature3 = {};
                        if (ttdFile3 != undefined) {
                            signature3.type = 'Known By';
                            signature3.name = $('#bm-name').val();
                            signature3.date = moment($('#bm-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            signature3.signature = ttdFile3;
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

                        function isEmptyObject(obj) {
                            return Object.keys(obj).length === 0;
                        }

                        datas.details = detail;
                        datas.department_id = department_id;
                        datas.proposed_purchase_price = proposed_purchase_price;
                        datas.budget_status = budget_status;
                        datas.request_date = request_date;
                        datas.requester = requester;
                        datas.total_budget = total_budget;
                        datas.remaining_budget = remaining_budget;
                        datas.material_request_id = material_request_id;
                        datas.additional_note = additional_note;
                        datas.signatures = signature;
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" + "/api/purchase-request/" + id,
                            type: "PATCH",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",

                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil Memperbaharui Purchase Request',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    window.location.href = "/request/list-purchase-request"
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: xhr.responseJSON.message,
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

        $("#material_request_id").select2({
            placeholder: 'Select Material Request',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/material-request/select',
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

        $("#department_id").select2({
            placeholder: 'Select Department',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/department/select',
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

        // Mengambil data tanggal untuk material request
        $(".select-mr").on('change', function() {
            var id = $(this).val();

            $.ajax({
                url: "{{ env('BASE_URL_API')}}" + '/api/material-request/' + id,
                method: 'GET',
                success: function(res) {
                    let response = res.data;
                    $("#tanggal_mr").val(moment(response.request_date).format(
                        'DD-MM-YYYY'));
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });

        // Cancel
        $(document).on('click', '.btn-cancel', function(event) {
            event.preventDefault();
            localStorage.removeItem('purchase-request');
            window.location.href = "/request/list-purchase-request"
        });

        // Check checkbox classification2
        $(".checkbox").on('change', function() {
            validateCheckboxClassification2();
        })

        function validateCheckboxClassification2() {
            var atLeastOneChecked = $('.checkbox input[type="checkbox"]:checked').length > 0;

            if (!atLeastOneChecked) {
                event.preventDefault();
                event.stopPropagation();
                $('.checkbox .form-check-input').prop("required", true);
            } else {
                $('.checkbox .form-check-input').prop("required", false);
            }
        }

        // Classification 2
        $('.checkbox-check').change(function() {
            if ($(this).is(":checked")) {
                // Menonaktifkan semua checkbox dengan class 'checkbox-check' kecuali yang sedang dipilih
                $('.checkbox-check').not(this).prop('disabled', true);
            } else {
                // Mengaktifkan kembali semua checkbox dengan class 'checkbox-check'
                $('.checkbox-check').prop('disabled', false);
            }
        });

        // Keyup input qty
        $(document).on('input', '.qty', function() {
            var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(sanitizedValue);
        });

        // Keyup input price
        $(document).on('input', '.price', function() {
            var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            var numericValue = parseFloat(sanitizedValue, 10);

            if (!isNaN(numericValue)) {
                var formattedValue = numericValue.toLocaleString('en-US');

                $(this).val(formattedValue);
            }
        });

    });
</script>
@endsection