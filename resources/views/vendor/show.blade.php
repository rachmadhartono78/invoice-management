@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tagihan Vendor')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

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
                    <button type="button" id="disetujui" class="btn btn-primary d-grid w-100 mb-2">Disetujui</button>
                    <button type="button" id="edit" class="btn btn-primary d-grid w-100 mb-2">Edit</button>
                    <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <p class="text-center">Kelengkapan Document</p>
                    <ol class="documents" id="documents">

                    </ol>
                </div>
            </div>
        </div>
        <!-- /Invoice Actions -->
    </div>

</div>
<!-- / Content -->

@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}"></script>
<script src="{{asset('assets/js/forms-file-upload.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js')}}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
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
    var nomorInvoice;
    var id;
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('show-tagihan-vendor') + 1;
    id = urlSegments[idIndex];
    $(document).ready(function() {
        getDataTagihanVendor(id);
    });

    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        window.location.href = "/vendor/list-tagihan-vendor";
    });
    
    if(account.level_id == 11){
        $('#disetujui').addClass('d-none');
    }else if(account.level_id == 10){
        $('#edit').addClass('d-none');
    }else if(account.level_id == 9){
        $('#disetujui').addClass('d-none');
    }else{
        $('#edit').addClass('d-none');
        $('#disetujui').addClass('d-none');
    }

    $(document).on('click', '#edit', function(event) {
        event.preventDefault();
        window.location.href = "/vendor/edit-tagihan-vendor/" + id;
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
            // url: "{{url('api/purchase-order')}}/" + id,
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
                $("#note").text(data.notes);
                $("#grand_total").text('Rp. ' + format(data.grand_total));
                $("#tax").text('Rp .' + format(data.tax));
                $("#subtotal").text('Rp.' + format(data.subtotal));
                $("#grand_total_spelled").text(data.grand_total_spelled);
                $("#term_and_conditions").text(data.term_and_conditions);
                $("#signature_name").text(data.signature_name);
                $("#date").text(moment(data.purchase_order_date, 'YYYY-MM-DD').format('DD-MM-YYYY'));
                getVendor(data.vendor_id);
                getDetails(data.purchase_order_details);
                getAttachments(data.vendor_attachment);
                if(data.status == 'Selesai'){
                    $('#edit').addClass('d-none');
                }
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

    function getAttachments(attachments) {
        let data = attachments;
        let getDetail = '';
        let temp = '';
        let openTab = '';

        if (data.length > 0) {
            let details = data;
            for (let i = 0; i < details.length; i++) {
                temp = `<li class="mb-2"><a href="javascript:void(0)" class="btn btn-primary text-white d-flex justify-content-between align-items-center" id="attachment-${i}"> ${details[i].uraian} <i class="fas fa-download"></i></a></li>`;
                getDetail = getDetail + temp;
            }
            $('#documents').prepend(getDetail);
            openLink(details);
        } else {}

    }

    function openLink(details) {
        for (let i = 0; i < details.length; i++) {
            $('#attachment-'+i).click(function(e) {
                var pdfResult = details[i].attachment;
                let pdfWindow = window.open("");
                pdfWindow.document.write("<iframe width='100%' height='100%' src=' "+ pdfResult + "'></iframe>");
            });
        }
    }

    $(document).on('click', '#disetujui', function(e) {
        e.stopPropagation();
        Swal.fire({
            text: "Apakah ingin menyetujui tagihan ini  ?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, send!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(async function(result) {
            if (result.value) {
                let datas = {};
                if (account.level_id == 10) {
                    datas.status = "Diverifikasi Admin";
                }
                $.ajax({
                    url: "{{env('BASE_URL_API')}}" + '/api/purchase-order/update-status/' + id,
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
            }
        });
    });

    $(document).on('click', '.add-doc', function() {
        let documents = $('.documents');
        let newRow = `
        <div class="document">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium">Pilih Document</label>
                                <input type="text" name="document[]" id="" class="form-control">
                            </div>
                            <div class="mb-3">
                                <input type="file" class="form-control" placeholder="Pilih Berkas">
                            </div>
                        </div>
        `;
        documents.append(newRow);
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