@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Laporan Kerusakan')

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
                                <span class="d-block text-center mx-auto">Nomor WO :</span>
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
                                    <select class="form-select add w-px-250 select2 select-scope" id="scope" name="scope" multiple required>
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
                                </div>

                                <div class="row py-3">
                                    <div class="col-12">
                                        <label for="note" class="form-label fw-medium">Klasifikasi</label>
                                        <div class="">
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="closed" id="closed" required>
                                                <label class="form-check-label" for="closed">Closed
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="cancelled" id="cancelled" required>
                                                <label class="form-check-label" for="cancelled">Cancelled</label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="explanation" id="explanation" required>
                                                <label class="form-check-label" for="explanation">Explanation</label>
                                            </div>
                                            <div class="form-check form-check-inline classif2">
                                                <input class="form-check-input classif2-checkbox" type="checkbox" name="others" id="others" required>
                                                <label class="form-check-label" for="others">Others</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="note" class="form-label fw-medium text-left ttd">Technician</label>
                                <div class="row  text-center ttd">
                                    <div class="col-md-3 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Technician" id="technician1" name="name" style="text-align:center;" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable dd" id="dropzone-1" style="padding: 5px;">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date" placeholder="Tanggal" name="date" id="date1" style="text-align:center;" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Technician" id="technician2" name="name" style="text-align:center;" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>

                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable dd" id="dropzone-2" style="padding: 5px;">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date" placeholder="Tanggal" id="date2" name="date" style="text-align:center;" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Technician" id="technician3" name="name" style="text-align:center;" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable dd" id="dropzone-3" style="padding: 5px;">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date" placeholder="Tanggal" id="date3" name="date" style="text-align:center;" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control" placeholder="Technician" id="technician4" name="name" style="text-align:center;" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable dd" id="dropzone-4" style="padding: 5px;">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date" placeholder="Tanggal" id="date4" name="date" style="text-align:center;" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
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
                    <a href="/complain/work-order/add" id="preview" class="btn btn-label-secondary d-grid w-100 mb-2">Kembali</a>
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
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
</script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js')}}">
</script>
<script>
    "use strict";
    let dataLocal = JSON.parse(localStorage.getItem("work-order"));
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    $(document).ready(function() {
        let account = {!! json_encode(session('data')) !!};
        var levelId = account.level_id;
        if (levelId == 10) {
            $('.ttd').hide();
        } else {
            $('.ttd').show();
        }

        $("#scope").select2({
            placeholder: 'Select Scope',
            allowClear: true,
            multiple: true,
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

        $('#scope').select2({
            disabled: 'readonly'
        });

        if (dataLocal.scope) {
            var data = dataLocal.scope.split(',');
            console.log(data);
            var scopeSelect = $('#scope');
            for (var i = 0; i < data.length; i++) {
                $.ajax({
                    type: 'GET',
                    url: "{{ env('BASE_URL_API')}}" + '/api/scope/' + data[i],
                }).then(function(data) {
                    console.log(data);
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

        $('#classification').select2({
            disabled: 'readonly'
        });

        if (dataLocal.classification) {
            var data = dataLocal.classification.split(',');
            console.log(data);
            var classificationSelect = $('#classification');
            for (var i = 0; i < data.length; i++) {
                $.ajax({
                    type: 'GET',
                    url: "{{ env('BASE_URL_API')}}" + '/api/classification/' + data[i],
                }).then(function(data) {
                    console.log(data);
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


        $('.classif2-checkbox').each(function() {
            var checkboxName = $(this).attr('name').toLowerCase();

            if (dataLocal.klasifikasi) {
                if ((dataLocal.klasifikasi).toLowerCase() === checkboxName) {
                    $('.classif2-checkbox').not(this).prop('disabled', true);
                    $(this).prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                }
            }
        });


        $('.date').flatpickr({
            dateFormat: 'Y-m-d'
        });

        const flatPickrEL = $(".date");
        if (flatPickrEL.length) {
            flatPickrEL.flatpickr({
                allowInput: true,
                monthSelectorType: "static",
                dateFormat: 'Y-m-d'
            });
        }

        if (dataLocal) {
            load(dataLocal);
        }

        getDetails();

        // Mengambil value tanda tangan
        let ttdFile1 = null;
        const myDropzone1 = new Dropzone('#dropzone-1', {
            parallelUploads: 1,
            maxFilesize: 2,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png",
            autoQueue: false,
            init: function() {
                if (dataLocal) {
                    // Add a preloaded file to the dropzone with a preview
                    var mockFile = dataLocal.signatures[0].signature;
                    if (mockFile) {
                        this.options.addedfile.call(this, mockFile);
                        this.options.thumbnail.call(this, mockFile, mockFile.dataURL);

                        $('.dz-image').last().find('img').attr('width', '100%');


                        // Optional: Handle the removal of the file
                        mockFile.previewElement.querySelector(".dz-remove").addEventListener("click", function() {
                            // Handle removal logic here
                        });
                    }
                }
                this.on('addedfile', function(file) {
                    while (this.files.length > this.options.maxFiles) this.removeFile(this
                        .files[0]);
                    ttdFile1 = file;
                });
            }
        });

        let ttdFile2 = null;
        const myDropzone2 = new Dropzone('#dropzone-2', {
            clickable: false,
            parallelUploads: 1,
            maxFilesize: 2,
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png",
            autoQueue: false,
            init: function() {
                this.on('addedfile', function(file) {
                    while (this.files.length > this.options.maxFiles) this.removeFile(this
                        .files[0]);
                    ttdFile2 = file;
                });
            }
        });

        let ttdFile3 = null;
        const myDropzone3 = new Dropzone('#dropzone-3', {
            clickable: false,
            parallelUploads: 1,
            maxFilesize: 2,
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png",
            autoQueue: false,
            init: function() {
                this.on('addedfile', function(file) {
                    while (this.files.length > this.options.maxFiles) this.removeFile(this
                        .files[0]);
                    ttdFile3 = file;
                });
            }
        });

        let ttdFile4 = null;
        const myDropzone4 = new Dropzone('#dropzone-4', {
            parallelUploads: 1,
            maxFilesize: 2,
            addRemoveLinks: true,
            maxFiles: 1,
            clickable: false,
            acceptedFiles: ".jpeg,.jpg,.png",
            autoQueue: false,
            init: function() {
                this.on('addedfile', function(file) {
                    while (this.files.length > this.options.maxFiles) this.removeFile(this
                        .files[0]);
                    ttdFile4 = file;
                });
            }
        });

        // Cancel
        $(".btn-cancel").on("click", function(event) {
            event.preventDefault();
            localStorage.removeItem('work-order');
            window.location.href = "/complain/work-order"
        })





        // Validasi untuk checkbox hanya bisa pilih satu
        // Scope
        $('.scope-checkbox').change(function() {
            if ($(this).is(":checked")) {
                // Menonaktifkan semua checkbox dengan class 'scope-checkbox' kecuali yang sedang dipilih
                $('.scope-checkbox').not(this).prop('disabled', true);
            } else {
                // Mengaktifkan kembali semua checkbox dengan class 'scope-checkbox'
                $('.scope-checkbox').prop('disabled', false);
            }
        });

        // Select3



        $('.select-scope').on("change", (async function(e) {
            $(this).removeClass("is-invalid");
        }));

        // Select3


        $('.select-classification').on("change", (async function(e) {
            $(this).removeClass("is-invalid");
        }));

        // Classification
        $('.classif-checkbox').change(function() {
            if ($(this).is(":checked")) {
                // Menonaktifkan semua checkbox dengan class 'classif-checkbox' kecuali yang sedang dipilih
                $('.classif-checkbox').not(this).prop('disabled', true);
            } else {
                // Mengaktifkan kembali semua checkbox dengan class 'classif-checkbox'
                $('.classif-checkbox').prop('disabled', false);
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
    });

    function load(dataLocale) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });

        $("#action_plan_date").val(dataLocal.action_plan_date);
        $("#damage_report_id").val(dataLocal.damage_report_id);
        $("#finish_plan").val(dataLocal.finish_plan);
        $("#job_description").val(dataLocal.job_description);
        $("#technician1").val(dataLocal.signatures[0].name);
        $("#work_order_date").val(dataLocal.work_order_date);
        $("#date1").val(dataLocal.signatures[0].date);



        if (dataLocal.damage_report_id) {
            getLaporanKerusakan();
        }
        // if (dataLocal.scope) {
        //     getScope();
        // }



        Swal.close();
    }


    function getLaporanKerusakan() {
        let id = dataLocal.damage_report_id;
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



    function getDetails() {
        let data = dataLocal;
        let getDetail = '';
        let temp = '';

        if (data) {
            let details = dataLocal.details;
            console.log(details);
            for (let i = 0; i < details.length; i++) {
                temp = `
                <div class="mb-3 row-mg">
                    <div class="row mb-3  d-flex align-items-end">
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Location</label>
                            <input type="text" class="form-control" id="location" name="location[]" placeholder="Location" required value="` + details[i].location + `" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Material Request</label>
                            <input type="text" class="form-control" id="material-req" name="material-req[]" placeholder="Material Request" required value="` + details[i].material_request + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3">
                            <label for="note" class="form-label fw-medium">Type /Made In</label>
                            <input type="text" class="form-control" id="type" name="type[]" placeholder="Type /Made In" required value="` + details[i].type + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="col-md-3 mb-1-custom"">
                            <label for="note" class="form-label fw-medium">Quantity</label>
                            <input type="number" class="form-control row-input" id="qty" name="qty[]" placeholder="Quantity" required value="` + details[i].quantity + `"/>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                    </div>
                </div>
                `;
                getDetail = getDetail + temp;
            }
            $('#details').prepend(getDetail);
        } else {
            console.log();
            temp = `            
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
                    <div class="col-md-3 mb-1-custom"">
                        <label for="note" class="form-label fw-medium">Quantity</label>
                        <input type="text" class="form-control row-input" id="qty" name="qty[]" placeholder="Quantity" required />
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