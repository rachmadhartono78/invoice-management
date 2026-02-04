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

                        <div class="row py-3 px-3" >
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Requester</label>
                                    <input type="text" class="form-control" placeholder="Requester" name="requester" id="requester" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Departement </label>
                                    <input type="text" class="form-control" placeholder="Departement" name="department" id="department" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Stock </label>
                                    <input type="number" class="form-control" placeholder="Stock" id="stock" name="stock" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Purchase </label>
                                    <input type="text" class="form-control money-format" placeholder="Purchase" name="purchase" id="purchase" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Tanggal</label>
                                    <input type="text" class="form-control date" placeholder="Tanggal" name="request_date" id="request_date" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <textarea class="form-control" rows="6" id="note" name="note" placeholder="Catatan" required></textarea>
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
                                    <div class="row pb-4">
                                        <div class="col-12">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-add-row-mg mt-2">Tambah Baris</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3 ttd">
                                    <div class="col-md-3">
                                        <label for="note" class="form-label fw-medium mb-3">Prepered by :</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="warehouse_name" name="name[]" />
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="warehouse_jabatan" name="jabatan[]" readonly/>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable dd" id="ttd1">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="warehouse_date" name="date[]" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="note" class="form-label fw-medium mb-3">Reviewed by :</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row" placeholder="Nama" style="text-align:center;" id="name" name="name[]" disabled />
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row" placeholder="Jabatan" style="text-align:center;" id="jabatan" name="jabatan[]" value="Chief Department" disabled />
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dd" id="ttd2">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="date" name="name[]" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="note" class="form-label fw-medium mb-3">Aknowledge by :</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row" placeholder="Nama" style="text-align:center;" id="name" name="name[]" disabled/>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row" placeholder="Jabatan" style="text-align:center;" id="jabatan" name="jabatan[]" value="Chief Finance & Akunting" disabled />
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dd" id="ttd3">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="date" name="date[]" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="note" class="form-label fw-medium mb-3">Approved by :</label>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row" placeholder="Nama" style="text-align:center;" id="name" name="name[]" disabled />
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control ttd-row" placeholder="Jabatan" style="text-align:center;" id="jabatan" name="jabatan[]" value="Kepala BM" disabled/>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dd" id="ttd4">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="date" name="date[]" disabled/>
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
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Simpan</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>
    </form>


    <!-- Offcanvas -->
    <!-- Send Invoice Sidebar -->


</div>
<!-- / Content -->

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
    
        
       
    let dataLocal = JSON.parse(localStorage.getItem("material-request"));
    $(document).ready(function() {

        let account = {!! json_encode(session('data')) !!}
        var levelId = account.level_id;
        var department = account.department.name;
        var nameUser = account.name;

        
        $(".department").val("Warehouse");
        $(".userName").val(nameUser);
        

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

        let ttdFile1, ttdFile2, ttdFile3, ttdFile4 = null;

        const myDropzone1 = new Dropzone('#ttd1', {
            parallelUploads: 1,
            thumbnailWidth: "250",
            thumbnailHeight: "250",
            maxFilesize: 3,
            addRemoveLinks: true,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            autoQueue: false,
            url: "../uploads/logo1",
            init: function() {
                if (dataLocal) {
                    // Add a preloaded file to the dropzone with a preview
                    var mockFile = dataLocal.materai_image;
                    if (mockFile) {
                        this.options.addedfile.call(this, mockFile);
                        this.options.thumbnail.call(this, mockFile, dataLocal.materai_image.dataURL);
                        $('.dz-image').find('img').attr('width', '100%');
                        // Optional: Handle the removal of the file
                        mockFile.previewElement.querySelector(".dz-remove").addEventListener("click", function() {
                            // Handle removal logic here
                        });
                    }
                }
                this.on('addedfile', function(file) {
                    while (this.files.length > this.options.maxFiles) this.removeFile(this.files[0]);
                    $('.dz-image').find('img').attr('width', '100%');
                    ttdFile1 = file;
                })
            }
        });

        if (dataLocal) {
            $("#requester").val(dataLocal.requester);
            $("#department").val(dataLocal.department);
            $("#request_date").val(dataLocal.request_date);
            $("#stock").val(dataLocal.stock);
            $("#purchase").val(dataLocal.purchase);
            $("#note").val(dataLocal.note);
        }

        getDetails();

        $(document).on('click', '.btn-remove-mg', function() {
            // Hapus baris yang ditekan tombol hapus
            $(this).closest('.row-mg').remove();
        });

        $(document).on('click', '.btn-add-row-mg', function() {
            // Clone baris terakhir
            var $details = $('#details');
            var $newRow = `
           
                    <table class="table row-mg">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Stock" name="stock[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Stock Out" name="stock_out[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="End Stock" name="end_stock[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Min Stock" name="min_stock" [] required style="width: 200px;"/>
                                </td>
                                <td>
                                    <a role="button" class="btn btn-primary text-center btn-remove-mg text-white ms-4" disabled>
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                
            `;
            $details.append($newRow);
        });

        function getDetails() {
            let data = dataLocal;
            let getDetail = '';
            let temp = '';

            if (data) {
                let details = dataLocal.details;
                for (let i = 0; i < details.length; i++) {
                    temp = `
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
                            <tr>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;" value="` + details[i].number + `"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;" value="` + details[i].part_number + `"/>
                                </td>
                                <td>
                                    <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;">`+ details[i].description +`</textarea>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;" value="` + details[i].quantity + `"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Stock" name="stock[]" required style="width: 200px;" value="` + details[i].stpck + `"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Stock Out" name="stock_out[]" required style="width: 200px;" value="` + details[i].stock_out + `"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="End Stock" name="end_stock[]" required style="width: 200px;" value="` + details[i].end_stock + `"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Min Stock" name="min_stock" [] required style="width: 200px;" value="` + details[i].min_stock + `"/>
                                </td>
                                <td>
                                    <a role="button" class="btn btn-primary text-center btn-remove-mg text-white ms-4" disabled>
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    `;
                    getDetail = getDetail + temp;
                }
                $('#details').prepend(getDetail);
            } else {
                temp = `            
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
                            <tr>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Stock" name="stock[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Stock Out" name="stock_out[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="End Stock" name="end_stock[]" required style="width: 200px;"/>
                                </td>
                                <td>
                                    <input type="text" class="form-control row-input" placeholder="Min Stock" name="min_stock" [] required style="width: 200px;"/>
                                </td>
                                <td>
                                    <a role="button" class="btn btn-primary text-center btn-remove-mg text-white ms-4" disabled>
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                `;
                $('#details').prepend(temp);
            }
        }

        function reverseDateFormat(dateString) {
            var parts = dateString.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

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
                        // Submit your form
                        event.preventDefault();
                        Swal.fire({
                            title: '<h2>Loading...</h2>',
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                        let requester = $("#requester").val();
                        let department = $("#department").val();
                        let request_date = reverseDateFormat($("#request_date").val());
                        let stock = $("#stock").val();
                        let purchase = $("#purchase").val();
                        let note = $("#note").val();
                        let datas = {};
                        let signatures1 = {}
                        signatures1.type = "Prepared By";
                        signatures1.name = $('#warehouse_name').val();
                        signatures1.date = reverseDateFormat($('#warehouse_date').val());
                        if(ttdFile1 != undefined){
                            signatures1.signature = ttdFile1.dataURL;
                        }else{
                            return Swal.fire({
                                title: 'Error!',
                                text: 'Periksa Tanda Tangan',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            })
                        }

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
                        datas.status = 'Terbuat';
                        datas.signatures = [signatures1];
                        
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" + "/api/material-request",
                            type: "POST",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan Material Request',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    localStorage.removeItem('material-request');
                                    window.location.href = "/request/material-request"
                                });
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
    
        $(document).on('keyup', '.money-format', function(event) {
            // skip for arrow keys
            if (event.which >= 37 && event.which <= 40) return;
            // format number
            $(this).val(function(index, value) {
                return value
                    .replace(/\D/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });

        $(document).on('click', '#preview', function(event) {
            event.preventDefault();
            let requester = $("#requester").val();
            let department = $("#department").val();
            let request_date = $("#request_date").val();
            let stock = $("#stock").val();
            let purchase = $("#purchase").val();
            let note = $("#purchase").val();

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
            datas.status = 'Terbuat';
            localStorage.setItem("material-request", JSON.stringify(datas));
            window.location.href = "/request/material-request/preview"
        });

        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            localStorage.removeItem('invoice');
            window.location.href = "/request/material-request"
        });

    });

</script>
@endsection