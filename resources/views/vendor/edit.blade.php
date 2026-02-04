@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tagihan Vendor')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-vendor" class="create-vendor" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div style="background-image: url('{{asset('assets/img/header.png')}}'); height : 150px; background-size: contain; background-repeat: no-repeat;" class="set-back">
                        </div>

                        <h2 class="mx-auto text-center"><b>PURCHASE ORDER</b></h2>
                        <div class="row  m-0 p-3">
                            <div class="col-md-6 mb-md-0 ps-0">
                                <dl class="row mb-2 d-flex">
                                    <dt class="col-sm-4">
                                        <span class="fw-normal">Nomor PO</span>
                                    </dt>
                                    <dt class="col-sm-8 ">
                                        <span class="fw-normal" id="purchase_order_number"></span>
                                    </dt>
                                </dl>
                                <dl class="row mb-2 d-flex">
                                    <dt class="col-sm-4">
                                        <span class="fw-normal">Tanggal</span>
                                    </dt>
                                    <dt class="col-sm-8 ">
                                        <span class="fw-normal" id="purchase_order_date"></span>
                                    </dt>
                                </dl>
                                <dl class="row mb-2 d-flex mb-4">
                                    <dt class="col-sm-4">
                                        <span class="fw-normal">Perihal</span>
                                    </dt>
                                    <dt class="col-sm-8 ">
                                        <span class="fw-normal" id="about"></span>
                                    </dt>
                                </dl>
                                <div class="mb-3">
                                    <div class="form-label">
                                        <span id="name_tenant"></span><br>
                                        <span id="address"></span><br><br>
                                        <span id="floor"></span><br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">

                            </div>
                        </div>
                        <div class="row px-3 mb-3">
                            <span class="form-label" id="note"></span>
                        </div>

                        <div class="row px-3 mb-3 ">
                            <div class="table-responsive border-top">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama barang</th>
                                            <th>Spesifikasi</th>
                                            <th>Quantity</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Pajak</th>
                                            <th>Total (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" id="details">
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="2">
                                                <p class="">Total</p>
                                            </td>
                                            <td colspan="2" style="text-align: right;">
                                                <p id="grand_total" class=""></p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row px-3">
                            <div class="col-12">
                                <label for="note" class="form-label fw-medium">Terbilang</label>
                                <br>
                                <span class="form-label" id="grand_total_spelled"></span>
                                <hr>
                            </div>
                        </div>

                        <div class="row px-3 mb-3">
                            <div class="col-6">
                                <label for="note" class="form-label fw-medium">Syarat & Ketentuan</label>
                                <br>
                                <span class="form-label" id="term_and_conditions"></span>
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Tanda Tangan</label>
                                    <div class="form-label" id="date">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div id="signatture"></div>
                                </div>
                                <div class="mb-3">
                                    <span class="form-label" id="signature_name">
                                    </span>
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
                        <button type="button" class="btn btn-label-secondary d-grid w-100">Batal</button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <p class="text-center">Kelengkapan Document</p>
                        <button type="button" class="btn  d-grid w-100 mb-2 add-doc" style="color : #fff;background-color : #4EC0D9;"><span class="d-flex align-items-center justify-content-center text-nowrap">+</span></button>
                        <div class="documents" id="documents">
                        </div>
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
<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
<script src="{{asset('assets/js/forms-file-upload.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script>
    let account = {!! json_encode(session('data')) !!}
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    var lastIndex = null;
    var nomorInvoice;
    var id;
    $(document).ready(function() {
        var urlSegments = window.location.pathname.split('/');
        var idIndex = urlSegments.indexOf('edit-tagihan-vendor') + 1;
        id = urlSegments[idIndex];
        getDataTagihanVendor(id);

        var saveVendor = $('.create-vendor');

        Array.prototype.slice.call(saveVendor).forEach(function(form) {
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

                        var attachments = [];
                        $('.row-input').each(function(index) {
                            var input_name = $(this).attr('name');
                            var input_value = $(this).val();
                            var input_index = Math.floor(index / 2); // Membagi setiap 5 input menjadi satu objek pada array
                            if (index % 2 == 0) {
                                attachments[input_index] = {
                                    uraian: input_value
                                };
                            } else if (index % 2 == 1) {
                                attachments[input_index].attachment = input_value;
                            }
                        });

                        let datas = {};
                        datas.attachments = attachments;
                        let datasPo = {};
                        if (account.level_id == '1') {
                            datasPo.status = "Disetujui BM";
                        }else if (account.level_id == '11') {
                            datasPo.status = "Diupload Vendor";
                        }else if (account.level_id == '10') {
                            datasPo.status = "Diverifikasi Admin";
                        }else if (account.level_id == '9') {
                            datasPo.status = "Selesai";
                        } else {
                            datasPo.status = "Terbuat";
                        }
                        $.ajax({
                            url: "{{env('BASE_URL_API')}}" +'/api/vendor-invoice/add-attachment/' + id,
                            type: "POST",
                            data: JSON.stringify(datas),
                            processData: false,
                            contentType: false,
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(response) {
                                $.ajax({
                                    url: "{{env('BASE_URL_API')}}" + '/api/purchase-order/update-status/' + id,
                                    type: "PATCH",
                                    data: JSON.stringify(datasPo),
                                    processData: false,
                                    contentType: false,
                                    contentType: "application/json; charset=utf-8",
                                    dataType: "json",
                                    success: function(response) {
                                        $('.indicator-progress').show();
                                        $('.indicator-label').hide();

                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: 'Berhasil memperbarui Tagihan Vendor',
                                            icon: 'success',
                                            customClass: {
                                                confirmButton: 'btn btn-primary'
                                            },
                                            buttonsStyling: false
                                        }).then(function() {
                                            window.location.href = "/vendor/list-tagihan-vendor";
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
    });

    function getVendor(id) {
        $.ajax({
            url: "{{url('api/vendor')}}/" + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#floor").text(data.floor);
                $("#address").text(data.address);
                $("#name_tenant").text(data.name);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function tglIndo(date) {
        // Parsing tanggal
        var tanggalObj = new Date(date);

        // Daftar nama bulan dalam bahasa Indonesia
        var namaBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        // Mendapatkan tahun, bulan, dan hari
        var tahun = tanggalObj.getFullYear();
        var bulan = namaBulan[tanggalObj.getMonth()];
        var hari = tanggalObj.getDate();

        // Format tanggal dalam "d MMMM yyyy" (contoh: 7 Januari 2024)
        var tanggalFormatted = hari + ' ' + bulan + ' ' + tahun;
        return tanggalFormatted;
    }

    function getDataTagihanVendor(id) {
        $.ajax({
            url: "{{env('BASE_URL_API')}}" +'/api/purchase-order/' + id,
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
                $("#purchase_order_number").text(data.purchase_order_number);
                $("#purchase_order_date").text(tglIndo(data.purchase_order_date));
                $("#about").text(data.about);
                $("#note").text(data.note);
                $("#grand_total").text('Rp. '+format(data.grand_total));
                $("#tax").text('Rp. '+format(data.tax));
                $("#grand_total_spelled").text(data.grand_total_spelled);
                $("#term_and_conditions").text(data.term_and_conditions);
                $("#signature_name").text(data.signature_name);
                getVendor(data.vendor_id);
                getDetails(data.purchase_order_details);
                getAttachments(data.vendor_attachment);
                if (data.signature) {
                    $("#signatture").css('background-img', 'black');
                    $("#signatture").css("background-image", `url('` + data.signature + `')`);
                    $("#signatture").css("height", `200px`);
                    $("#signatture").css("width", `200px`);
                    $("#signatture").css("background-position", `center`);
                    $("#signatture").css("background-size", `contain`);
                    $("#signatture").css("background-repeat", `no-repeat`);
                }
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    function format(e) {
        var nStr = e + '';

        nStr = nStr.replace(/\,/g, "");
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function selectElement(details) {    
        for (let i = 0; i < details.length; i++) {
            let element = $('#document-'+i);
            element.val(details[i].uraian);
        }
      
    }

    function openLink(details) {
        for (let i = 0; i < details.length; i++) {
            $('#file-attachment-'+i).click(function(e) {
                var pdfResult = details[i].attachment;
                let pdfWindow = window.open("");
                pdfWindow.document.write("<iframe width='100%' height='100%' src=' "+ pdfResult + "'></iframe>");
            });
        }
    }

    $(document).on('click', '.btn-remove-mg', function() {
         // Hapus baris yang ditekan tombol hapus
         $(this).closest('.document').remove();
        getTotal();
    });

    function getAttachments(attachments) {
        let data = attachments;
        let getDetail = '';
        let temp = '';
        let details = data;

        if (data.length > 0) {
            for (let i = 0; i < details.length; i++) {
                let btnTrash = '';
                let btnPdf = `<a target="_blank" href="" id="file-attachment-${i}" class="btn btn-primary btn-sm d-flex justify-content-center align-items-center w-100 h-2">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>`;
                if(account.level_id == 11){
                    btnTrash = `<a role="button" class="btn btn-danger text-center  text-white btn-remove-file" data-id="${details[i].id}" disabled>
                                            <i class="fas fa-trash"></i>
                                        </a>`;

                    btnPdf = `<a target="_blank" style="width:120px;" href="" id="file-attachment-${i}" class="btn btn-primary btn-sm d-flex justify-content-center align-items-center">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>`;
                }
                temp = `             
                <div class="document" id="row-document-${details[i].id}">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Pilih Document</label>
                                    <select name="document[]" id="document-${i}" class="form-control " disabled>
                                        <option value="">Pilih Document</option>
                                        <option value="Faktur Pembelian">Faktur Pembelian</option>
                                        <option value="Kuintasi/Invoice">Kuintasi/Invoice</option>
                                        <option value="Purchase Order">Purchase Order(PO)</option>
                                        <option value="Delivery Order">Delivery Order(DO)</option>
                                        <option value="Berita Acara Pembayaran">Berita Acara Pembayaran(BAP)</option>
                                        <option value="Berita Acara Kemajuan Pekerjaan">Berita Acara Kemajuan Pekerjaan(BAPK)</option>
                                        <option value="Berita Acara Serah Terima">Berita Acara Serah Terima</option>
                                        <option value="Progress Kerja">Progress Kerja</option>
                                        <option value="Surat Perintah Kerja (SPK) / Kontrak Kerja">Surat Perintah Kerja (SPK) / Kontrak Kerja</option>
                                        <option value="Faktur Pajak">Faktur Pajak</option>
                                        <option value="Bukti Pembayaran">Bukti Pembayaran</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex gap-4">
                                        ${btnPdf}
                                        ${btnTrash}
                                    </div>
                                    <input type="hidden" class="form-control" placeholder="Pilih Berkas" id="attachment-val-${id}" required name="attachment" value="${details[i].attachment}">
                                </div>
                            </div>`;
                getDetail = getDetail + temp;
            }
            $('#documents').prepend(getDetail);
            handleAttachments(details);
            selectElement(details);
            openLink(details);
        } else {
            temp = `             
            <div class="document">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Pilih Document</label>
                                    <select name="document[]" id="document-0" class="form-control" required>
                                        <option value="">Pilih Document</option>
                                        <option value="Faktur Pembelian">Faktur Pembelian</option>
                                        <option value="Kuintasi/Invoice">Kuintasi/Invoice</option>
                                        <option value="Purchase Order">Purchase Order(PO)</option>
                                        <option value="Delivery Order">Delivery Order(DO)</option>
                                        <option value="Berita Acara Pembayaran">Berita Acara Pembayaran(BAP)</option>
                                        <option value="Berita Acara Kemajuan Pekerjaan">Berita Acara Kemajuan Pekerjaan(BAPK)</option>
                                        <option value="Berita Acara Serah Terima">Berita Acara Serah Terima</option>
                                        <option value="Progress Kerja">Progress Kerja</option>
                                        <option value="Surat Perintah Kerja (SPK) / Kontrak Kerja">Surat Perintah Kerja (SPK) / Kontrak Kerja</option>
                                        <option value="Faktur Pajak">Faktur Pajak</option>
                                        <option value="Bukti Pembayaran">Bukti Pembayaran</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="file" class="form-control" placeholder="Pilih Berkas" id="attachment-0" name="attachment[]" required>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex gap-4">
                                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white" disabled>
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <input type="hidden" class="form-control" placeholder="Pilih Berkas" id="attachment-val-0" required name="attachment">
                                </div>
                            </div>`;
            $('#documents').prepend(temp);
            handleAttachments(details);
        }
    }

    function handleAttachments(details) {
        if (details.length > 0) {
            for (let i = 0; i < details.length; i++) {
                const fileInput = $("#attachment-"+i);
                const fileInputVal = $("#attachment-val-"+i);
                // Listen for the change event so we can capture the file
                fileInput.change(function(e) {
                    // Get a reference to the file
                    const file = e.target.files[0];

                    // Encode the file using the FileReader API
                    const reader = new FileReader();
                    reader.onloadend = () => {
                        fileInputVal.val(reader.result);
                        console.log(reader.result);
                        // Logs data:<type>;base64,wL2dvYWwgbW9yZ...
                    };
                    reader.readAsDataURL(file);
                });
            }
        } else {
            console.log('ah');
            const fileInput = $("#attachment-0");
            const fileInputVal = $("#attachment-val-0");
            // Listen for the change event so we can capture the file
            fileInput.change(function(e) {
                // Get a reference to the file
                const file = e.target.files[0];

                // Encode the file using the FileReader API
                const reader = new FileReader();
                reader.onloadend = () => {
                    fileInputVal.val(reader.result);
                    console.log(reader.result);
                    // Logs data:<type>;base64,wL2dvYWwgbW9yZ...
                };
                reader.readAsDataURL(file);
            });
        }
    }

    $(document).on('click', '.btn-remove-file', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.value) {
                    let id = $(this).data('id');
                    let datas = {}
                    Swal.fire({
                        title: 'Memeriksa...',
                        text: "Harap menunggu",
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });

                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" + '/api/vendor-invoice/add-attachment/'+id,
                        type: "DELETE",
                        data: JSON.stringify(datas),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Menghapus Attahment',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                $('#row-document-'+id).remove();
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
            });
        });

    $(document).on('click', '.add-doc', function() {
        var index = lastIndex ? lastIndex + 1 : $('.document').length;
        lastIndex = index;
        let documents = $('.documents');
        let newRow = `
                             <div class="document">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Pilih Document</label>
                                    <select name="document[]" id="document-${index}" class="form-control row-input" required>
                                        <option value="">Pilih Document</option>
                                        <option value="Faktur Pembelian">Faktur Pembelian</option>
                                        <option value="Kuintasi/Invoice">Kuintasi/Invoice</option>
                                        <option value="Purchase Order">Purchase Order(PO)</option>
                                        <option value="Delivery Order">Delivery Order(DO)</option>
                                        <option value="Berita Acara Pembayaran">Berita Acara Pembayaran(BAP)</option>
                                        <option value="Berita Acara Kemajuan Pekerjaan">Berita Acara Kemajuan Pekerjaan(BAPK)</option>
                                        <option value="Berita Acara Serah Terima">Berita Acara Serah Terima</option>
                                        <option value="Progress Kerja">Progress Kerja</option>
                                        <option value="Surat Perintah Kerja (SPK) / Kontrak Kerja">Surat Perintah Kerja (SPK) / Kontrak Kerja</option>
                                        <option value="Faktur Pajak">Faktur Pajak</option>
                                        <option value="Bukti Pembayaran">Bukti Pembayaran</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="file" class="form-control" placeholder="Pilih Berkas" id="attachment-${index}" name="attachment[]" required>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex gap-4">
                                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white" disabled>
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    <input type="hidden" class="form-control row-input" placeholder="Pilih Berkas" id="attachment-val-${index}" required name="attachment">
                                </div>
                            </div>`;
        documents.append(newRow);
        const fileInput = $("#attachment-" + index);
        const fileInputVal = $("#attachment-val-" + index);
        // Listen for the change event so we can capture the file
        fileInput.change(function(e) {
            // Get a reference to the file
            const file = e.target.files[0];

            // Encode the file using the FileReader API
            const reader = new FileReader();
            reader.onloadend = () => {
                fileInputVal.val(reader.result);
                console.log(reader.result);
                // Logs data:<type>;base64,wL2dvYWwgbW9yZ...
            };
            reader.readAsDataURL(file);
        });
    });

    function getDetails(detailItems) {
        let details = detailItems;
        let getDetail = '';
        let tem = '';
        for (let i = 0; i < details.length; i++) {
            let pajak = getTax(details[i].tax_id);
            tem = `<tr>
                        <td>` + details[i].number + `</td>
                        <td>` + details[i].name + `</td>
                        <td>` + details[i].specification + `</td>
                        <td>` + details[i].quantity + `</td>
                        <td>` + details[i].units + `</td>
                        <td>` + 'Rp. ' + format(details[i].price) + `</td>
                        <td>` + (pajak && pajak.name ? pajak.name : '') + `</td>
                        <td>` + 'Rp. ' + format(details[i].total_price) + `</td>
                    </tr>
            `;
            getDetail = getDetail + tem;
        }

        $('#details').prepend(getDetail);
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
</script>
@endsection