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
                <div class="card invoice-preview-card" id="editLaporanKerusakan">
                    <div class="card-body">
                        <div class="row m-sm-4 m-0">
                            <div class="col-md-7 mb-md-0 mb-4 ps-0">
                                <h1 class="fw-700" style="margin: 0;"><b>PPPGSI</b></h1>
                                <h4><b>Building Management</b></h4>
                            </div>
                            <div class="col-md-5">
                                <span class="fs-4 d-block text-center mx-auto"><b>LAPORAN KERUSAKAN</b></span>
                                <span class="d-block text-center mx-auto">Nomor Lk :</span>
                                <input type="text" class="form-control mx-auto" id="edit_damage_report_number" name="damage_report_number" placeholder="Nomor LK" required />
                                <div class="invalid-feedback mx-auto w-px-250">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <hr class="my-3 mx-n4">

                        <div class="row py-3 px-3">
                            <div class="col-md-4 mb-md-0 mb-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">No Tiket </label>
                                    <select class="form-select select2 w-px-250 select-ticket item-details mb-3" required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-md-0 mb-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Date</label>
                                    <input type="text" class="form-control date data-input" id="edit_damage_report_date" name="damage_report_date" placeholder="Tanggal" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-md-0 mb-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Scope</label>
                                    <select class="form-select add w-px-250 select2 select-scope" id="scope" name="scope" multiple required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Classification</label>
                                    <select id="classification" name="classification" class="mb-3 select-classification add form-control" required multiple>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Action Plan Date</label>
                                    <input type="text" class="form-control date data-input" id="edit_action_plan_date" name="action_plan_date" placeholder="Action Plan Date" required />
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


                                <hr class="my-3">
                                <div class="row  text-center mt-4 signatures" id="ttd">
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
                        <button type="submit" id="edit" class="btn btn-primary d-grid w-100 mb-2">Update</button>
                        <button type="button" class="btn btn-label-secondary btn-cancel d-grid w-100">Kembali</button>
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
    $(document).ready(function() {
        $('.repeater').repeater({

        })
        var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;

        let account = {!! json_encode(session('data')) !!};
        var levelId = account.level_id;
        var department = account.department.name;
        var nameUser = account.name;
        let ttdFile1, ttdFile2, ttdFile3;
        //  fungsi untuk money format
        $(document).on("keyup", ".qty", function(e) {
            $(this).val(format($(this).val()));
        });
        var format = function(num) {
            var str = num.toString().replace("", ""),
                parts = false,
                output = [],
                i = 1,
                formatted = null;
            if (str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for (var j = 0, len = str.length; j < len; j++) {
                if (str[j] != ",") {
                    output.push(str[j]);
                    if (i % 3 == 0 && j < (len - 1)) {
                        output.push(",");
                    }
                    i++;
                }
            }
            formatted = output.reverse().join("");
            return ("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
        };

        // Mendapatkan id dengan cara mengambil dari URL
        var urlSegments = window.location.pathname.split('/');
        var idIndex = urlSegments.indexOf('edit') + 1;
        var id = urlSegments[idIndex];

        getDataLaporanKerusakan(id)

        $("#classification").select2({
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

        $("#scope").select2({
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
        // Get data from API
        function getDataLaporanKerusakan(id) {
            Swal.fire({
                title: '<h2>Loading...</h2>',
                html: sweet_loader + '<h5>Please Wait</h5>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            })
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" + '/api/damage-report/' + id,
                // url: "{{ url('/api/damage-report/')}}/" + id,
                type: "GET",
                dataType: "json",
                success: function(res) {
                    let response = res.data;
                   
                    getScope(response.scope);
                    getClassification(response.classification);
                    let details= response.damage_report_signatures;
                    $('#editLaporanKerusakan').find('.form-control').each(function() {
                        $("#" + $(this).attr('id')).val(response[$(this).attr(
                            "name")]);
                    });
                    $('#edit_damage_report_date').val(moment(response.damage_report_date,
                        'YYYY-MM-DD').format('DD-MM-YYYY'));
                    $('#edit_action_plan_date').val(moment(response.action_plan_date, 'YYYY-MM-DD')
                        .format('DD-MM-YYYY'));
                    $(".select-ticket").empty().append('<option value="' + response.ticket_id +
                            '">' + response.ticket_id + '</option>').val(response.ticket_id)
                        .trigger("change");
                    localStorage.setItem('status', response.status);
                    var firstRow = $('.repeater-wrapper').first();
                    for (var i = 0; i < response.damage_report_details.length; i++) {
                        var rowValues = response.damage_report_details[i];

                        if (i === 0) {
                            firstRow.find('#edit_category').val(rowValues.category);
                            firstRow.find('#edit_location').val(rowValues.location);
                            firstRow.find('#edit_total').val(rowValues.total);
                        } else {
                            var newRow = firstRow.clone();
                            newRow.find('#edit_category').val(rowValues.category);
                            newRow.find('#edit_location').val(rowValues.location);
                            newRow.find('#edit_total').val(rowValues.total);

                            $('.repeater [data-repeater-list="group-a"]').append(newRow);
                        }
                    }

                    $('.repeater').repeater();

                    let signatureKepalaUnitPelayanan, signatureKoordinatorTeknik, signatureLeaderCleaing;

                    for (let i = 0; i < response.damage_report_signatures.length; i++) {
                        if (details[i].type == 'Dilaporkan') {
                            signatureLeaderCleaing = details[i];
                        } else if (details[i].type == 'Diterima') {
                            signatureKoordinatorTeknik = details[i];
                        } else if (details[i].type == 'Mengetahui') {
                            signatureKepalaUnitPelayanan = details[i];
                        }
                    }

                    let htmlGetSignatureLeaderCleaning = getSignatureLeaderCleaning(signatureLeaderCleaing);
                    let htmlGetSignatureKoordinatorTeknik = getSignatureKoordinatorTeknik(signatureKoordinatorTeknik);
                    let htmlGignatureKepalaUnitPelayanan = getSignatureKepalaUnitPelayanan(signatureKepalaUnitPelayanan);

                    $('.signatures').html(htmlGetSignatureLeaderCleaning + htmlGetSignatureKoordinatorTeknik + htmlGignatureKepalaUnitPelayanan);
                    account.level.id == 4 ? dropzoneValue(signatureLeaderCleaing, '#ttd1') : '';
                    account.level.id == 3 ? dropzoneValue(signatureKoordinatorTeknik, '#ttd2') : '';
                    account.level.id == 2 ? dropzoneValue(signatureKepalaUnitPelayanan, '#ttd3') : '';
                    if (account.level.id != 10) {
                        $('.edit-admin').addClass('d-none');
                    }

                    // Set value ke form signature
                    for (let i = 1; i < response.damage_report_signatures.length + 1; i++) {
                        $("#edit_type-" + i).val(response.damage_report_signatures[i - 1].type);
                        $("#edit_name-" + i).val(response.damage_report_signatures[i - 1].name);
                        if (response.damage_report_signatures[i - 1].signature != '') {
                            $('.prev-img-' + i).attr('src', response.damage_report_signatures[i - 1]
                                .signature);
                        } else {
                            $('.dz-nopreview').css('display', 'block');
                        }
                        $('#edit_date-' + i).val(moment(response.damage_report_signatures[i - 1]
                            .date, 'YYYY-MM-DD').format('DD-MM-YYYY'));
                    }
                    getDetails(response.damage_report_details);
                    
                    setDate();
                    if(account.level.id != 10){
                        $('.btn-remove-mg').remove();
                        $('.btn-add-row-mg').remove();
                        $('.data-input, .select-classification, .row-input').attr('disabled', 'disabled');
                        $('.select2').attr('disabled', 'disabled');
                    }
                    if(response.status !='Terbuat' && account.level.id == 10){
                            $('.form-control').attr('readonly', 'readonly');
                            $('.btn-remove-mg').remove();
                            $('.btn-add-row-mg').remove();
                            $('.data-input, .select-classification, .row-input').attr('disabled', 'disabled');
                            $('.select2').attr('disabled', 'disabled');
                            $("#edit").addClass('d-none');
                        }
                    Swal.close();
                },
                error: function(errors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errors.responseJSON
                            .message,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    })
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
                            dataURL: value?.signature
                        };
                        this.options.addedfile.call(this, mockFile);
                        this.options.thumbnail.call(this, mockFile, value?.signature);
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

        function getSignatureLeaderCleaning(value) {
            let disablePrepared = 'disabled';
            let dropzonePrepared = '';
            let imagePrepared = '';
            let datePreparedAttr = '';
            let namePrepared = '';
            let datePrepared = '';
            if (account.level.id == '4') {
                namePrepared = value?.name ? value.name : '';
                datePrepared = value?.date ? moment(value.date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                dropzonePrepared = 'dz-clickable';
                namePrepared = account.name;
                ttdFile1 = value?.signature;
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
                    datePrepared = value.date ? moment(value.date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                    ttdFile1 = value?.signature;
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
                        <div action="/upload" class="dropzone needsclick ${dropzonePrepared} dd" id="ttd1">
                            <div class="dz-message needsclick">
                                <span class="note needsclick">Unggah Tanda Tangan</span>
                            </div>
                        </div>
                        `;
                }
            }
            let appendPrepared = `
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium mb-3">Dilaporkan :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="lc-name" name="name[]" value="${namePrepared ? namePrepared : ''}" ${datePreparedAttr} />
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="lc-jabatan" name="jabatan[]" value="Leader Cleaning" disabled />
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            ${imagePrepared}
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="lc-date" name="name[]" value="${datePrepared ? datePrepared : ''}" ${datePreparedAttr}/>
                        </div>
                    </div>
                `;
            return appendPrepared;
        }

        function getSignatureKoordinatorTeknik(value) {
            let disableReviewed = 'disabled';
            let dropzoneReviewed = '';
            let imageReviewed = '';
            let dateReviewedAttr = '';
            let nameReviewed = '';
            let dateReviewed = '';
            if (account.level.id == '3') {
                nameReviewed = value?.name ? value.name : '';
                dateReviewed = value?.date ? moment(value.date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                dropzoneReviewed = 'dz-clickable';
                nameReviewed = account.name;
                ttdFile2 = value?.signature;
                imageReviewed = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneReviewed} dd" id="ttd2">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
                //tanda tangannya ada maka tampoilkan seperti edit kepala bm invoice
            } else {
                //sudah ttd
                if (value) {
                    nameReviewed = value.name;
                    dateReviewedAttr = 'disabled';
                    ttdFile2 = value?.signature;
                    dateReviewed = value?.date ? moment(value.date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                    imageReviewed = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
                } else { //belum ttd
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
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium mb-3">Diterima :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="kt-name" name="name[]" value="${nameReviewed ? nameReviewed : ''}" ${dateReviewedAttr} />
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="kt-jabatan" name="jabatan[]" value="Koordinator Teknik" disabled />
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            ${imageReviewed}
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="kt-date" name="name[]" value="${dateReviewed ? dateReviewed : ''}" ${dateReviewedAttr}/>
                        </div>
                    </div>
                `;
            return appendReviewed;
        }

        function getSignatureKepalaUnitPelayanan(value) {
            let disableAknowledge = 'disabled';
            let dropzoneAknowledge = '';
            let imageAknowledge = '';
            let dateAknowledgeAttr = '';
            let nameAknowledge = '';
            let dateAknowledge = '';
            if (account.level.id == '2') {
                nameAknowledge = value?.name ? value.name : '';
                dateAknowledge = value?.date ? moment(value.date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                dropzoneAknowledge = 'dz-clickable';
                nameAknowledge = account.name;
                ttdFile3 = value?.signature;
                imageAknowledge = `
                    <div action="/upload" class="dropzone needsclick ${dropzoneAknowledge} dd" id="ttd3">
                        <div class="dz-message needsclick">
                            <span class="note needsclick">Unggah Tanda Tangan</span>
                        </div>
                    </div>
                    `;
            } else {
                //sudah ttd
                if (value) {
                    nameAknowledge = value.name;
                    dateAknowledgeAttr = 'disabled';
                    dateAknowledge = value.date ? moment(value.date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '';
                    ttdFile3 = value?.signature;
                    nameAknowledge = account.name;
                    imageAknowledge = `<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete" style="width:96%">
                        <div class="dz-details">
                            <div class="dz-thumbnail" style="width:88%"> <img class="prev-img-3" alt="" src="${value?.signature}">
                                <span class="dz-nopreview">No preview</span>
                            </div>
                        </div>
                    </div>`;
                } else { //belum ttd
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
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium mb-3">Mengetahui :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Nama" style="text-align:center;" id="ka-name" name="name[]" value="${nameAknowledge ? nameAknowledge : ''}" ${dateAknowledgeAttr} />
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row tanda-tangan" placeholder="Jabatan" style="text-align:center;" id="ka-jabatan" name="jabatan[]" value="Kepala Unit Pelayanan" disabled />
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            ${imageAknowledge}
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row tanda-tangan" placeholder="Tanggal" style="text-align:center;" id="ka-date" name="name[]" value="${dateAknowledge ? dateAknowledge : ''}" ${dateAknowledgeAttr}/>
                        </div>
                    </div>
                `;
            return appendAknowledge;
        }

        // Date
        setDate();

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

       

       
        // Create, Save, dan Insert
        var editlk = $('.edit-lk');

        Array.prototype.slice.call(editlk).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        let damageReportNumber = $("#damage_report_number").val();
                        let ticketNumber = $(".select-ticket").val();
                        let receiptDate = $("#damage_report_date").val();
                        let actionDate = moment($("#action_plan_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let scope = $("#scope").val();
                        let classification = $("#classification").val();
                        

                        if (!ticketNumber) {
                            $(".select-ticket").addClass("invalid");
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
                        try {
                            let ticket = $('.select-ticket').val();
                            let datas = {};
                            let signatures = [];
                            var detail = [];
                            let scope = $("#scope").val();
                            let classification = $("#classification").val();
                            let signature = [];
                            let ticketNumber = $(".select-ticket").val();
                            let receiptDate = moment($("#edit_damage_report_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            let actionDate = moment($("#edit_action_plan_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                            var damage_report_date = moment($("#edit_damage_report_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');


                            $('.row-input').each(function(index) {
                                var input_name = $(this).attr('name');
                                var input_value = $(this).val();
                                var input_index = Math.floor(index / 3); // Membagi setiap 5 input menjadi satu objek pada array
                                if (index % 3 == 0) {
                                    detail[input_index] = {
                                        category: input_value
                                    };
                                } else if (index % 3 == 1) {
                                    detail[input_index].location = input_value;
                                } else if (index % 3 == 2) {
                                    detail[input_index].total = parseInt(input_value);
                                }
                            });


                            if (account.level.id == '4') {
                                datas.status = 'Disetujui LC';
                            } else if (account.level.id == '3') {
                                datas.status = 'Disetujui KT';
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
                                signature1.type = 'Dilaporkan';
                                signature1.name = $('#lc-name').val();
                                signature1.date = moment($('#lc-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                                signature1.signature = ttdFile1;
                            }

                            let signature2 = {};
                            if (ttdFile2 != undefined) {
                                signature2.type = 'Diterima';
                                signature2.name = $('#kt-name').val();
                                signature2.date = moment($('#kt-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                                signature2.signature = ttdFile2;
                            }

                            let signature3 = {};
                            if (ttdFile3 != undefined) {
                                signature3.type = 'Mengetahui';
                                signature3.name = $('#ka-name').val();
                                signature3.date = moment($('#ka-date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
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
                            datas.ticket_id = ticket;
                            datas.scope = scope.toString();
                            datas.classification = classification.toString();
                            datas.details = detail;
                            datas.action_plan_date = actionDate;
                            datas.damage_report_date = damage_report_date;
                            datas.details = detail;
                            datas.signatures = signature;
                            console.log(datas);
                            $.ajax({
                                url: "{{ env('BASE_URL_API')}}" + '/api/damage-report/' + id,
                                type: "PATCH",
                                data: JSON.stringify(datas),
                                contentType: "application/json; charset=utf-8",
                                dataType: "json",

                                success: function(response) {
                                    $('.indicator-progress').show();
                                    $('.indicator-label').hide();

                                    Swal.fire({
                                        title: 'Berhasil',
                                        text: 'Berhasil Memperbarui Laporan Kerusakan.',
                                        icon: 'success',
                                        customClass: {
                                            confirmButton: 'btn btn-primary'
                                        },
                                        buttonsStyling: false
                                    }).then(function() {
                                        window.location.href = "/complain/laporan-kerusakan"
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
                        } catch (error) {
                            // Code to handle the error
                            console.error("An error occurred:", error.message);
                        }
                    }

                    form.classList.add("was-validated");
                },
                false
            );
        });

        // Cancel
        $(".btn-cancel").on("click", function() {
            window.location.href = "/complain/laporan-kerusakan"
        })

        // Select2
        $(".select-ticket").select2({
            placeholder: 'Select Ticket',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/ticket/select',
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

        $('.select-ticket').on("change", (async function(e) {
            $(this).removeClass("is-invalid");
        }));

        $(document).on('click', '.btn-add-row-mg', function() {
            var details = $('#details');
            var newRow = `
            <div class="row-mg">
                <div class="row mb-1 row-mg">
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium">Jenis Masalah Kerusakan</label>
                        <input type="text" class="form-control  row-input" id="category" name="category[]" placeholder="Jenis Masalah Kerusakan" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium">Lokasi</label>
                        <input type="text" class="form-control  row-input" id="location" name="location[]" placeholder="Lokasi" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Jumlah</label>
                        <input type="text" class="form-control qty price row-input" id="total" name="total[]" placeholder="Jumlah" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-1  px-1-custom">
                        <a class="btn-remove-mg mb-3 mx-2 mt-4 btn btn-primary text-white" style="width: 10px; height: 38px" role="button" data-repeater-delete>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;

            details.append(newRow);
            
        });

        function getDetails(data) {
            let getDetail = '';
            let temp = '';

            if (data) {
                let details = data;
                console.log(details.length);

                for (let i = 0; i < details.length; i++) {
                    temp = `             
                <div class="row-mg">
                    <div class="row mb-1 row-mg">
                        <div class="col-md-4">
                            <label for="note" class="form-label fw-medium">Jenis Masalah Kerusakan</label>
                            <input type="text" class="form-control  row-input" id="category" name="category[]" placeholder="Jenis Masalah Kerusakan" value="`+details[i].category+`" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-4">
                            <label for="note" class="form-label fw-medium">Lokasi</label>
                            <input type="text" class="form-control  row-input" id="location" name="location[]" placeholder="Lokasi" value="`+details[i].location+`" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Jumlah</label>
                            <input type="text" class="form-control qty price row-input" id="total" name="total[]" value="`+details[i].total+`" placeholder="Jumlah" required />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-1  px-1-custom">
                            <a class="btn-remove-mg mb-3 mx-2 mt-4 btn btn-primary text-white" style="width: 10px; height: 38px" role="button" data-repeater-delete>
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
                `;
                    getDetail = getDetail + temp;
                }

            } else {
                temp = `             
            <div class="row-mg">
                <div class="row mb-1 row-mg">
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium">Jenis Masalah Kerusakan</label>
                        <input type="text" class="form-control  row-input" id="category" name="category[]" placeholder="Jenis Masalah Kerusakan" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium">Lokasi</label>
                        <input type="text" class="form-control  row-input" id="location" name="location[]" placeholder="Lokasi" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium">Jumlah</label>
                        <input type="text" class="form-control qty price row-input" id="total" name="total[]" placeholder="Jumlah" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-1  px-1-custom">
                        <a class="btn-remove-mg mb-3 mx-2 mt-4 btn btn-primary text-white" style="width: 10px; height: 38px" role="button" data-repeater-delete>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;
            }
            $('#details').prepend(temp);

        }
    });
</script>
@endsection