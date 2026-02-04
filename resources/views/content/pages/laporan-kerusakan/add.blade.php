@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Laporan Kerusakan')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css') }}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css') }}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-lk" class="create-lk" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card" id="addLaporanKerusakan">
                    <div class="card-body">
                        <div class="row m-sm-4 m-0">
                            <div class="col-md-7 mb-md-0 mb-4 ps-0">
                                <h1 class="fw-700" style="margin: 0;"><b>PPPGSI</b></h1>
                                <h4><b>Building Management</b></h4>
                            </div>
                            <div class="col-md-5">
                                <span class="fs-4 d-block text-center mx-auto"><b>LAPORAN KERUSAKAN</b></span>
                                <span class="d-block text-center mx-auto">Nomor Lk :</span>
                                <input type="text" class="form-control add w-px-250 mx-auto" id="damage_report_number" name="damage_report_number" placeholder="Nomor LK" disabled />
                                <div class="invalid-feedback mx-auto w-px-250">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <hr class="my-3 mx-n4">

                        <div class="row py-3 px-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">No Tiket </label>
                                    <select class="form-select select2 w-px-250 select-ticket item-details mb-3" required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Date</label>
                                    <input type="text" class="form-control add date" id="damage_report_date" name="damage_report_date" placeholder="Tanggal" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>

                                <div class="mb-1">
                                    <label for="scope" class="form-label fw-medium">Scope</label>
                                    <select class="form-select add w-px-250 select2 select-scope" id="scope" name="scope[]" multiple required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>

                                <div class="mb-1">
                                    <label for="classification" class="form-label fw-medium">Classification</label>
                                    <select class="form-select add w-px-250 select2 select-classification" id="classification" name="classification" multiple required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>

                                <div class="mb-1">
                                    <label for="note" class="form-label fw-medium">Action Plan Date</label>
                                    <input type="text" class="form-control add date" id="action_plan_date" name="action_plan_date" placeholder="Action Plan Date" required />
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

                                    <div class="row pb-4">
                                        <div class="col-md-3 px-3">
                                            <button type="button" class="btn btn-primary waves-effect waves-light w-px-150 btn-add-row-mg">Tambah
                                                Baris</button>
                                        </div>
                                    </div>
                                </div>


                                <hr class="my-3">
                                <!-- <div class="row  text-center mt-4" id="ttd">
                                    <div class="col-4 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control add" placeholder="KA. Unit Pelayanan" style="text-align:center;" id="type" name="type" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add " placeholder="Nama & Jabatan" style="text-align:center;" id="name" name="name" />
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
                                            <input type="text" class="form-control add date" placeholder="Tanggal" style="text-align:center;" id="date1" name="date" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control add" placeholder="KA. Unit Pelayanan" style="text-align:center;" id="type" name="type" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add " placeholder="Nama & Jabatan" style="text-align:center;" id="name" name="name" />
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
                                            <input type="text" class="form-control add date" placeholder="Tanggal" style="text-align:center;" id="date2" name="date" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 signatures">
                                        <div class="mb-3">
                                            <input type="text" class="form-control add" placeholder="KA. Unit Pelayanan" style="text-align:center;" id="type" name="type" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control add " placeholder="Nama & Jabatan" style="text-align:center;" id="name" name="name" />
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
                                            <input type="text" class="form-control add date" placeholder="Tanggal" style="text-align:center;" id="date3" name="date" />
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
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Simpan</button>
                        {{-- <button type="button" class="btn btn-label-secondary d-grid w-100 mb-2 btn-preview">Preview</button> --}}
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
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
</script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}">
</script>


<script>
    "use strict";
    let dataLocal = JSON.parse(localStorage.getItem("laporan-kerusakan"));
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    $(document).ready(function() {
        let account = {!! json_encode(session('data')) !!};

        const idTicket = getParameterByName('id-ticket');

        if (idTicket) {
            getDataTicket(idTicket);
        }

        function getParameterByName(name) {
            var url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        var levelId = account.level_id;
        if (levelId == 10) {
            $('#ttd').hide();
        } 

        //  fungsi untuk money format
            $(document).on("keyup", ".qty", function(e){
                 $(this).val(format($(this).val()));
            });
            var format = function(num){
            var str = num.toString().replace("", ""), parts = false, output = [], i = 1, formatted = null;
            if(str.indexOf(".") > 0) {
                parts = str.split(".");
                str = parts[0];
            }
            str = str.split("").reverse();
            for(var j = 0, len = str.length; j < len; j++) {
                if(str[j] != ",") {
                output.push(str[j]);
                if(i%3 == 0 && j < (len - 1)) {
                    output.push(",");
                }
                i++;
                }
            }
            formatted = output.reverse().join("");
            return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
            };


        // Date
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

        // Mengambil value tanda tangan
        // let ttdFile1 = null;
        // const myDropzone1 = new Dropzone('#dropzone-1', {
        //     parallelUploads: 1,
        //     maxFilesize: 10,
        //     addRemoveLinks: true,
        //     maxFiles: 1,
        //     acceptedFiles: ".jpeg,.jpg,.png",
        //     autoQueue: false,
        //     init: function() {
        //         this.on('addedfile', function(file) {
        //             while (this.files.length > this.options.maxFiles) this.removeFile(this
        //                 .files[0]);
        //             ttdFile1 = file;
        //         });
        //     }
        // });

        // $(document).on('keyup', '.price', function(event) {
        //     // skip for arrow keys
        //     if (event.which >= 37 && event.which <= 40) return;
        //     // format number
        //     $(this).val(function(index, value) {
        //         return value
        //             .replace(/\D/g, "")
        //             .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        //     });
        // });

        // let ttdFile2 = null;
        // const myDropzone2 = new Dropzone('#dropzone-2', {
        //     parallelUploads: 1,
        //     maxFilesize: 10,
        //     addRemoveLinks: true,
        //     maxFiles: 1,
        //     acceptedFiles: ".jpeg,.jpg,.png",
        //     autoQueue: false,
        //     init: function() {
        //         this.on('addedfile', function(file) {
        //             while (this.files.length > this.options.maxFiles) this.removeFile(this
        //                 .files[0]);
        //             ttdFile2 = file;
        //         });
        //     }
        // });

        getDetails();

        // let ttdFile3 = null;
        // const myDropzone3 = new Dropzone('#dropzone-3', {
        //     parallelUploads: 1,
        //     maxFilesize: 10,
        //     addRemoveLinks: true,
        //     maxFiles: 1,
        //     acceptedFiles: ".jpeg,.jpg,.png",
        //     autoQueue: false,
        //     init: function() {
        //         this.on('addedfile', function(file) {
        //             while (this.files.length > this.options.maxFiles) this.removeFile(this
        //                 .files[0]);
        //             ttdFile3 = file;
        //         });
        //     }
        // });

        // Create, Insert, Save
        var savelk = $('.create-lk');

        Array.prototype.slice.call(savelk).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();


            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        let ticketNumber = $(".select-ticket").val();
                        let receiptDate = $("#damage_report_date").val();
                        let actionDate = $("#action_plan_date").val();



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
                        var damage_report_date = $("#damage_report_date").val();
                        var action_plan_date = $("#action_plan_date").val();
                        let ticket = $('.select-ticket').val();
                        let datas = {};
                        let signatures = [];
                        let detail = [];

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

                       
                        let scope = $("#scope").val();
                        let classification = $("#classification").val();
                        datas.ticket_id = ticket;
                        datas.signatures = signatures;
                        datas.status = "Terbuat";
                        datas.scope = scope.toString();
                        datas.details = detail;
                        datas.classification = classification.toString();;
                        datas.action_plan_date = action_plan_date;
                        datas.damage_report_date = damage_report_date;
                        console.log(datas);
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/damage-report',
                            // url: "{{url('/api/damage-report')}}",
                            type: "POST",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan Laporan Kerusakan.',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    localStorage.removeItem('damage-report');
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
                    }

                    form.classList.add("was-validated");
                },
                false
            );
        });

        // Preview before save
        

        // Cancel
        $(".btn-cancel").on("click", function() {
            window.location.href = "/complain/laporan-kerusakan"
        })

        // Select2
        $(".select-ticket").select2({
            placeholder: 'Select Ticket',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" +'/api/ticket/select?status=On progress',
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

        // Select3
        $(".select-scope").select2({
            placeholder: 'Select Scope',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" +'/api/scope/select',
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
                url: "{{ env('BASE_URL_API')}}" +'/api/classification/select',
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

        $('.select-classification').on("change", (async function(e) {
            $(this).removeClass("is-invalid");
        }));
        // Keyup input qty
        $(document).on('input', '.qty', function() {
            var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(sanitizedValue);
        });
    });

    function getDataTicket(id) {
        $.ajax({
            url: "{{url('api/damage-report')}}/" + id,
            type: "GET",
            success: function(response) {
                console.log(response);
                let data = response.data;
                let tem = `<option value="` + data.id + `" selected>` + data.damage_report_number + `</option>`;
                $('.select-ticket').prepend(tem);

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });

    }

    $(document).on('click', '.btn-add-row-mg', function() {
        // Clone baris terakhir
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
                        <input type="text" class="form-control qty  row-input" id="total" name="total[]" placeholder="Jumlah" required />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </div>
                    <div class="col-md-1  px-1-custom">
                        <a class="btn-remove-mg mb-3 mx-2 mt-4 btn btn-danger text-white" style="width: 10px; height: 38px" role="button" data-repeater-delete>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;
        details.append(newRow);
    });

    $(document).on('click', '.btn-remove-mg', function() {
        // Hapus baris yang ditekan tombol hapus
        $(this).closest('.row-mg').remove();
    });

    function getDetails() {
        let data = dataLocal;
        let getDetail = '';
        let temp = '';

        if (data) {
            let details = dataLocal.details;
            for (let i = 0; i < details.length; i++) {
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
                            <a class="btn-remove-mg mb-3 mx-2 mt-4 btn btn-danger text-white" style="width: 10px; height: 38px" role="button" data-repeater-delete>
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
                        <a class="btn-remove-mg mb-3 mx-2 mt-4 btn btn-danger text-white" style="width: 10px; height: 38px" role="button" data-repeater-delete>
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
            `;
        }
        $('#details').prepend(temp);

    }
</script>
@endsection