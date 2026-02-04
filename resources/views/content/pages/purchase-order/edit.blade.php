@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Invoice')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}">
<style type="text/css">
    .select2-container {
        width: 200px !important;
    }
</style>
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y" style="overflow-x: hidden;">
    <form id="create-purchase-order" class="create-purchase-order" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div style="background-image: url('{{asset('assets/img/header.png')}}'); height : 150px; background-size: contain; background-repeat: no-repeat;">
                        </div>

                        <h2 class="mx-auto text-center"><b>PURCHASE ORDER</b></h2>
                        <div class="row  m-0 px-3">
                            <div class="col-md-6 mb-md-0 ps-0">
                                <dl class="row mb-2 d-flex align-items-center">
                                    <dt class="col-sm-4">
                                        <span class="fw-normal">Nomor PO</span>
                                    </dt>
                                    <dd class="col-sm-8 ">
                                        <div class="input-group input-group-merge">
                                            <input type="text" class="form-control date" placeholder="Nomor" id="purchase_order_number" disabled>
                                        </div>
                                    </dd>
                                </dl>
                                <dl class="row mb-2 d-flex align-items-center">
                                    <dt class="col-sm-4">
                                        <span class="fw-normal">Tanggal </span>
                                    </dt>
                                    <dd class="col-sm-8 ">
                                        <input type="text" class="form-control date" placeholder="Tanggal" id="purchase_order_date" name="purchase_order_date" required>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </dd>
                                </dl>
                                <dl class="row mb-2 d-flex align-items-center">
                                    <dt class="col-sm-4">
                                        <span class="fw-normal">Perihal</span>
                                    </dt>
                                    <dd class="col-sm-8 ">
                                        <input type="text" class="form-control " placeholder="Perihal" id="about" name="about" required>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </dd>
                                </dl>
                                <div class="mb-3">
                                    <label for="invoice-message" class="form-label">Nama Vendor</label>
                                    <br>
                                    <select name="vendor" id="vendor_id" name="vendor_id" class="mb-3" required>
                                    </select>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-12">
                                <textarea class="form-control" name="note" id="note" cols="3" rows="8" placeholder="Penjelasan untuk permintaan ISI PURCHASING ORDER" required></textarea>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
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

                                <div class="row p-0 p-sm-4">
                                    <div class="col-md-6 mb-md-0 mb-3">

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="w-px-100">Total</span>
                                                    <span class="fw-medium grand_total"></span>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-12 mb-2">
                                        <label for="note" class="form-label fw-medium">Terbilang</label>
                                        <input type="text" class="form-control terbilang" id="grand_total_spelled" name="grand_total_spelled" placeholder="Terbilang" disabled />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-md-0 mb-3">
                                        <div class="mb-3">
                                            <label for="note" class="form-label fw-medium me-2">Syarat & Ketentuan</label>
                                            <textarea class="form-control" rows="11" id="term_and_conditions" name="term_and_conditions" placeholder="Termin pembayaran, garansi dll" required></textarea>
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center data-materai">
                                        <div class="mb-3">
                                            <label for="note" class="form-label fw-medium">Tanda Tangan</label>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick dz-clickable w-px-250" id="dropzone-basic">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control w-px-250 " id="signature_name" placeholder="Nama & Jabatan" name="signature_name" style="text-align: center" />
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

            <!-- purchase req Actions -->
            <div class="col-lg-3 col-12 purchase-req-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Simpan</button>
                        <!-- <button class="btn btn-label-secondary d-grid w-100 mb-2 btn-preview">Preview</button> -->
                        <button type="button" id="batal" class="btn btn-label-secondary btn-cancel d-grid w-100">Kembali</button>
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
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
<script>
    let account = {!! json_encode(session('data')) !!}
    let ttdFile = null;
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    var lastIndex = null;

    var id;
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('edit') + 1;
    id = urlSegments[idIndex];

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
    $(document).ready(function() {
        getDataPurchaseOrder(id);
    });

    function getVendor(id) {
        $.ajax({
            url: "{{url('api/vendor')}}/" + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#vendor_id").empty().append("<option value=" + data.id + ">" + data.name + "</option>").val(data.id).trigger("change");
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function getDataPurchaseOrder(id) {
        $.ajax({
            url: "{{env('BASE_URL_API')}}" + '/api/purchase-order/' + id,
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
                id = data.id;
                nomorInvoice = data.invoice_number;
                const myDropzone = new Dropzone('#dropzone-basic', {
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
                        this.on('addedfile', function(file) {
                            $('.dz-image').last().find('img').attr('width', '100%');
                            while (this.files.length > this.options.maxFiles) this.removeFile(this.files[0]);
                            ttdFile = file;
                        })
                    }
                });
                if (data.status != 'Terbuat') {
                    $('.form-control').attr('readonly', 'readonly');
                    if (data.status == "Disetujui KA"){
                        $('#signature_name').removeAttr('readonly');
                    }
                }
                
                $("#purchase_order_number").val(data.purchase_order_number);
                $("#purchase_order_date").val(data.purchase_order_date);
                $("#about").val(data.about);
                $("#note").val(data.note);
                $(".grand_total").text(format(data.grand_total));
                $("#grand_total_spelled").val(data.grand_total_spelled);
                $("#term_and_conditions").val(data.term_and_conditions);
                if(account.level.id == 1){
                    $("#signature_name").val(account.name);
                }else{
                    $("#signature_name").val(data.signature_name);
                }
                getVendor(data.vendor_id);
                getDetails(data.purchase_order_details);
                if (account.level.id != '1') {
                    $('.data-materai').attr('style', 'display:none !important');
                }
                if (account.level.id == '1') {
                    $('.btn-remove-mg').addClass('d-none');
                    $('.btn-add-row-mg').addClass('d-none');
                    $(".btn-update span").html('<i class="ti ti-check ti-xs me-2"></i>Disetujui Kepala BM');
                    $('#materai_name').attr('readonly', true);
                }
                setDate();
                if((data.status !='Terbuat' &&  account.level.id == 10)){
                    $('.btn-remove-mg').remove();
                    $('.btn-add-row-mg').remove();
                    $('.form-control').attr('readonly', 'readonly');
                    $('.form-check-input').attr('disabled', 'disabled');
                    $('.date').removeClass('date');
                    $("#vendor_id").prop("disabled", true);
                    $("#save").addClass('d-none');
                    $(".tanda-tangan").prop("disabled", true);
                }
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        window.location.href = "/request/purchase-order";
    });


    $(document).on('input', '.price', function(event) {
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
        let index = $('.price').index(this);
        let total = 0;
        let price = parseFloat($(this).val().replaceAll(',', ''));
        let id = isNaN(parseFloat($(`.tax:eq(` + index + `)`).val())) ? 0 : parseFloat($(`.tax:eq(` + index + `)`).val().replaceAll(',', ''));
        if (id == 0) {
            $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(price));
            getTotal();
        } else {
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" + '/api/tax/get-paper/' + id,
                type: "get",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    let data = response.data.rate;
                    let total = 0;
                    let tax = parseFloat(data);
                    tax = tax / 100;
                    let totalPrice = price * tax + price;
                    $(`.total_price:eq(` + index + `)`).val(isNaN(totalPrice) ? 0 : format(totalPrice));
                    getTotal();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }

    });


    $(document).on('input', '.price', function(event) {
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
        let index = $('.price').index(this);
        let total = 0;
        let price = parseFloat($(this).val().replaceAll(',', ''));
        let id = isNaN(parseFloat($(`.tax:eq(` + index + `)`).val())) ? 0 : parseFloat($(`.tax:eq(` + index + `)`).val().replaceAll(',', ''));
        if (id == 0) {
            $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(price));
            getTotal();
        } else {
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" + '/api/tax/get-paper/' + id,
                type: "get",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    let data = response.data.rate;
                    let total = 0;
                    let tax = parseFloat(data);
                    tax = tax / 100;
                    let totalPrice = price * tax + price;
                    $(`.total_price:eq(` + index + `)`).val(isNaN(totalPrice) ? 0 : format(totalPrice));
                    getTotal();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }

    });


    var savePurchaseOrder = $('.create-purchase-order');

    Array.prototype.slice.call(savePurchaseOrder).forEach(function(form) {
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
                    let tenant = $("#tenant").val();
                    let purchaseOrderDate = moment($("#purchase_order_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                    let about = $("#about").val();
                    let vendorId = $("#vendor_id").val();
                    let note = $("#note").val();
                    let grandTotalSpelled = $("#grand_total_spelled").val();
                    let grandTotal = parseFloat($(".grand_total").text().replaceAll(',', ''));
                    let termAndConditions = $("#term_and_conditions").val();
                    let signature = ttdFile.dataURL;
                    let signatureName = $('#signature_name').val();
                    var detail = [];
                    $('.row-input').each(function(index) {
                        var input_name = $(this).attr('name');
                        var input_value = $(this).val();
                        var input_index = Math.floor(index / 8); // Membagi setiap 5 input menjadi satu objek pada array
                        if (index % 8 == 0) {
                            detail[input_index] = {
                                number: parseFloat(input_value)
                            };
                        } else if (index % 8 == 1) {
                            detail[input_index].name = input_value;
                        } else if (index % 8 == 2) {
                            detail[input_index].specification = input_value;
                        } else if (index % 8 == 3) {
                            detail[input_index].quantity = parseFloat(input_value);
                        } else if (index % 8 == 4) {
                            detail[input_index].units = input_value;
                        } else if (index % 8 == 5) {
                            detail[input_index].price = parseFloat(input_value.replaceAll(',', ''));
                        } else if (index % 8 == 6) {
                            detail[input_index].tax = input_value;
                        } else if (index % 8 == 7) {
                            detail[input_index].total_price = parseFloat(input_value.replaceAll(',', ''));
                        }
                    });

                    let datas = {};
                    datas.details = detail;
                    datas.vendor_id = parseFloat(vendorId);
                    if (account.level.id == '1') {
                        datas.status = "Disetujui BM";
                    } else {
                        datas.status = "Terbuat";
                    }
                    datas.about = about;
                    datas.grand_total = parseFloat(grandTotal);
                    datas.purchase_order_date = purchaseOrderDate;
                    datas.grand_total_spelled = grandTotalSpelled;
                    datas.term_and_conditions = termAndConditions;
                    datas.note = note;
                    datas.signature = signature;
                    datas.signature_name = signatureName;
                    $.ajax({
                        url: "{{env('BASE_URL_API')}}" + '/api/purchase-order/' + id,
                        type: "PATCH",
                        data: JSON.stringify(datas),
                        processData: false,
                        contentType: false,
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            $('.indicator-progress').show();
                            $('.indicator-label').hide();

                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Memperbarui Purchase Order',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then(function() {
                                window.location.href = "/request/purchase-order";
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
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


    $(document).on('input', '.tax', function(event) {
        let id = event.currentTarget.value;
        let index = $('.tax').index(this);
        let data = 0;
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/tax/get-paper/' + id,
            type: "get",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(response) {
                let data = response.data.value;
                let exlusice = response.data.exclusive;
                let total = 0;
                let price = parseFloat($(`.price:eq(` + index + `)`).val().replaceAll(',', ''));
                let tax = parseFloat(data);
                tax = tax / 100;
                let totalPrice = price * tax + price;
                // console.log(format(totalPrice));
                $(`.total_price:eq(` + index + `)`).val(isNaN(totalPrice) ? 0 : format(totalPrice));
                getTotal();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    });

    function getTotal() {
        let totalArr = [];
        let tempTotal = document.getElementsByClassName('total_price');
        for (let i = 0; i < tempTotal.length; i++) {
            var slipOdd = parseFloat(tempTotal[i].value.replaceAll(',', ''));
            totalArr.push(Number(slipOdd));
        }

        let sum = 0;
        for (let i = 0; i < totalArr.length; i++) {
            sum += totalArr[i];
        }
        $('.grand_total').text(format(sum));
        $('.terbilang').val(terbilang(sum));

    }

    function terbilang(bilangan) {
        bilangan = String(bilangan);
        let angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
        let kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
        let tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');

        let panjang_bilangan = bilangan.length;
        let kalimat = "";
        let subkalimat = "";
        let kata1 = "";
        let kata2 = "";
        let kata3 = "";
        let i = 0;
        let j = 0;

        /* pengujian panjang bilangan */
        if (panjang_bilangan > 15) {
            kalimat = "Diluar Batas";
            return kalimat;
        }

        /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
        for (i = 1; i <= panjang_bilangan; i++) {
            angka[i] = bilangan.substr(-(i), 1);
        }

        i = 1;
        j = 0;
        kalimat = "";

        /* mulai proses iterasi terhadap array angka */
        while (i <= panjang_bilangan) {

            subkalimat = "";
            kata1 = "";
            kata2 = "";
            kata3 = "";

            /* untuk Ratusan */
            if (angka[i + 2] != "0") {
                if (angka[i + 2] == "1") {
                    kata1 = "Seratus";
                } else {
                    kata1 = kata[angka[i + 2]] + " Ratus";
                }
            }

            /* untuk Puluhan atau Belasan */
            if (angka[i + 1] != "0") {
                if (angka[i + 1] == "1") {
                    if (angka[i] == "0") {
                        kata2 = "Sepuluh";
                    } else if (angka[i] == "1") {
                        kata2 = "Sebelas";
                    } else {
                        kata2 = kata[angka[i]] + " Belas";
                    }
                } else {
                    kata2 = kata[angka[i + 1]] + " Puluh";
                }
            }

            /* untuk Satuan */
            if (angka[i] != "0") {
                if (angka[i + 1] != "1") {
                    kata3 = kata[angka[i]];
                }
            }

            /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
            if ((angka[i] != "0") || (angka[i + 1] != "0") || (angka[i + 2] != "0")) {
                subkalimat = kata1 + " " + kata2 + " " + kata3 + " " + tingkat[j] + " ";
            }

            /* gabungkan variabe sub kalimat (untuk Satu blok 3 angka) ke variabel kalimat */
            kalimat = subkalimat + kalimat;
            i = i + 3;
            j = j + 1;

        }

        /* mengganti Satu Ribu jadi Seribu jika diperlukan */
        if ((angka[5] == "0") && (angka[6] == "0")) {
            kalimat = kalimat.replace("Satu Ribu", "Seribu");
        }

        return (kalimat.trim().replace(/\s{2,}/g, ' ')) + " Rupiah";
    }

    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }


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
        var index = lastIndex ? lastIndex + 1 : $('.tax').length;
        lastIndex = index;
        var $details = $('#details');
        var $newRow = `
            <table class="table row-mg">
                <tbody>
                    <tr>
                        <td>
                            <input type="number" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input" placeholder="Nama Barang" name="name[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input" placeholder="Spesifikasi" name="specification[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="number" class="form-control row-input" placeholder="Quantity" name="quantity[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input" placeholder="Satuan" name="units[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input price" placeholder="Harga Satuan" name="price[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <select class="form-control row-input tax" placeholder="" name="tax[]" id="tax-${index}" required></select>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" disabled class="form-control row-input total_price" placeholder="Jumlah" name="total_price[]" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <a role="button" class="btn btn-primary text-center btn-remove-mg text-white ms-4" disabled>
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>`;
        $details.append($newRow);
        $("#tax-" + index).select2({
            placeholder: 'Pilih',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/tax/select-paper',
                dataType: 'json',
                cache: true,
                data: function(params) {
                    return {
                        value: params.term || '',
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
    });

    function getDetails(details) {
        let tem = "";
        for (let i = 0; i < details.length; i++) {
            let specification = details[i].specification ? details[i].specification : '';
            let pajak = getTax(details[i].tax_id);
            tem += `
                    <tr class="row-mg">
                        <td>
                            <input type="number" class="form-control row-input" placeholder="Nomor" name="number[]"  value="` + details[i].number + `"  required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input" placeholder="Nama Barang" name="name[]"  value="` + details[i].name + `" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input" placeholder="Spesifikasi" name="specification[]" value="` + specification + `" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="number" class="form-control row-input" placeholder="Quantity" name="quantity[]" value="` + details[i].quantity + `" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input" placeholder="Satuan" name="units[]" value="` + details[i].units + `" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" class="form-control row-input price" placeholder="Harga Satuan" name="price[]" value="` + details[i].price?.toLocaleString() + `" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <select class="form-control row-input tax" placeholder="Pajak" name="tax[]" id="tax-${i}">`+`<option value="` + pajak.uuid + `" selected>` + pajak.name + `</option>`+`</select>
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <input type="text" disabled class="form-control row-input total_price" placeholder="Jumlah" name="total_price[]"  value="` + details[i].total_price?.toLocaleString() + `" required style="width: 200px;" />
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </td>
                        <td>
                            <a role="button" class="btn btn-primary text-center btn-remove-mg text-white ms-4" disabled>
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>`;

            // let optionTax = `<option value="` + pajak.uuid + `" selected>` + pajak.name + `</option>`;

            // console.log(optionTax);
            // console.log('#tax-' + i);
            // $('#tax-' + i).prepend(optionTax);
            // $('#tax-' + i).prepend(optionTax);

            // $.ajax({
            //     url: "{{ env('BASE_URL_API')}}" + '/api/tax/' + details[i].tax_id,
            //     type: "GET",
            //     success: function(response) {

            //         let data = response.data;
            //         let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
            //         $('#tax-' + i).prepend(tem);
            //         console.log();
            //     },
            //     error: function(xhr, status, error) {
            //         console.log(error);
            //     }
            // });
        }

        function getTax(id) {
            let dataTax;
            if(id != null){
                $.ajax({
                    url: "{{url('api/tax/get-paper')}}/" + id,
                    type: "get",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    async:false,
                    success: function(response) {
                        dataTax = response.data;
                    },
                    error: function(errors) {
                        console.log(errors);
                    }
                });
            }
            return dataTax;
        }
        let getDetail = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Barang</th>
                            <th>Spesifikasi</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Pajak</th>
                            <th>Jumlah</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tem}
                    </tbody>
                </table>`;
        $('#details').prepend(getDetail);
        for (let i = 0; i < details.length; i++) {
            $("#tax-" + i).select2({
                width: '100px',
                placeholder: 'Pilh Pajak',
                allowClear: true,
                ajax: {
                    url: "{{ env('BASE_URL_API')}}" + '/api/tax/select-paper',
                    dataType: 'json',
                    cache: true,
                    data: function(params) {
                        return {
                            value: params.term || '',
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


    $("#vendor_id").select2({
        placeholder: 'Select Vendor',
        allowClear: true,
        ajax: {
            url: "{{ env('BASE_URL_API')}}" + '/api/vendor/select',
            dataType: 'json',
            cache: true,
            data: function(params) {
                return {
                    value: params.term || '',
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
</script>
@endsection