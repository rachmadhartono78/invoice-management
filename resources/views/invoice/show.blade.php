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
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-invoice" class="create-invoice" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card">
                    <div class="card-body">
                        <div style="background-image: url('{{ asset('assets/img/header.png') }}'); height : 150px; background-size: contain; background-repeat: no-repeat;" class="set-back">
                        </div>

                        <div class="row px-4">
                            <div class="col-md-6">
                                <label for="select2Primary" class="form-label">Kepada Yth, </label>
                                <br>
                                <div class="form-label">
                                    <span id="company"></span><br>
                                    <span id="floor"></span><br><br>
                                    <span id="name_tenant"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row d-flex justify-content-end">
                                    <div class="col-md-6 mb-3">
                                        <label for="note" class="form-label fw-medium">No. Invoice</label>
                                        <input type="text" class="form-control" id="invoice_number" placeholder="" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="note" class="form-label fw-medium">Tgl. Invoice</label>
                                        <input type="text" class="form-control date" name="invoice_date" id="invoice_date" placeholder="" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-3 form-label">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Deskripsi</th>
                                            <th>Kuantitas</th>
                                            <th>Harga</th>
                                            <th>Diskon(%)</th>
                                            <th>Pajak</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0" id="details">
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="fw-bold">Subtotal:</p>
                                            </td>
                                            <td colspan="2" style="text-align: right;">
                                                <p id="sub_total" class="fw-bold"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="fw-bold">Total Diskon:</p>
                                            </td>
                                            <td colspan="2" style="text-align: right;">
                                                <p id="discount" class="fw-bold"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="fw-bold">Total Pajak:</p>
                                            </td>
                                            <td colspan="2" style="text-align: right;">
                                                <p id="tax" class="fw-bold"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="fw-bold">Total:</p>
                                            </td>
                                            <td colspan="2" style="text-align: right;">
                                                <p id="grand_total" class="fw-bold"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7"><span>Terbilang : </span> <span id="invoice_terbilang" class="fw-bold"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <span>Jatuh Tempo Tanggal : </span> <span id="invoice_due_date" class="fw-bold"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" id="grand_total_spelled" style="font-weight:bold; font-size:14px"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row m-sm-2 m-0 ">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3">
                                    <label for="note" class="form-label me-2">Catatan</label>
                                    <br>
                                    <div class="form-label fw-bold" id="notes">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3">
                                    <label for="note" class="form-label me-2">Syarat dan Ketentuan</label>
                                    <br>
                                    <div class="form-label fw-bold" id="term_and_conditions">
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
                        <button class="btn btn-primary d-grid w-100 mb-2 kirim-invoice d-none" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Kirim Invoice</span>
                        </button>
                        <a type="button" class="btn btn-primary d-grid w-100 mb-2 disetujui d-none" style="color : #fff;"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-check ti-xs me-2"></i>Disetujui</span></a>
                        <a target="_blank" href="{{url('invoice/print/')}}/{{$id}}" id="preview" class="btn btn-info d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-download ti-xs me-2"></i>Download</span></a>
                        <a target="_blank" href="{{url('invoice/edit/')}}/{{$id}}" id="edit" class="btn btn-primary d-grid w-100 mb-2 edit d-none"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-pencil ti-xs me-2"></i>Edit</span></a>
                        <button class="btn btn-primary d-grid w-100 mb-2 add-pay add-payment d-none">
                            <span class="d-flex align-items-center justify-content-center text-nowrap">Add Payment</span>
                        </button>
                        <a href="{{ url('invoice/list-invoice')}}" id="back" class="btn btn-secondary d-grid w-100 mb-2">Kembali</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
<script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
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

    $(document).ready(function() {
        var urlSegments = window.location.pathname.split('/');
        var idIndex = urlSegments.indexOf('show') + 1;
        id = urlSegments[idIndex];
        getDataInvoice(id);

        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            window.location.href = "/invoice/list-invoice"
        });

        $(document).on('click', '.kirim-invoice', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Kirim!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.value) {
                    let datas = {}
                    datas.status = 'Terkirim';
                    Swal.fire({
                        title: 'Memeriksa...',
                        text: "Harap menunggu",
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: "{{env('BASE_URL_API')}}" +'/api/invoice/update-status/' + id,
                        type: "PATCH",
                        data: JSON.stringify(datas),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            $('.indicator-progress').show();
                            $('.indicator-label').hide();

                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Mengirim Invoice',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                localStorage.removeItem('invoice');
                                window.location.href = "/invoice/list-invoice";
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

        $(document).on('click', '.disetujui', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Setuju!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.value) {
                    let datas = {}
                    if(account.level.id == 1){
                        datas.status = 'Disetujui BM';
                    }else if(account.level.id == 9){
                        datas.status = 'Disetujui KA';
                    }
                    Swal.fire({
                        title: 'Memeriksa...',
                        text: "Harap menunggu",
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: "{{env('BASE_URL_API')}}" +'/api/invoice/update-status/' + id,
                        type: "PATCH",
                        data: JSON.stringify(datas),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            $('.indicator-progress').show();
                            $('.indicator-label').hide();
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Menyetujui Invoice',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                localStorage.removeItem('invoice');
                                window.location.href = "/invoice/list-invoice";
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Materai Habis',
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
    });

    function getDataInvoice(id) {
        $.ajax({

            // url: "http://127.0.0.1:8000/api/invoice/" + id,
            url: "{{env('BASE_URL_API')}}" +'/api/invoice/' + id,
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
                getTenant(data.tenant_id)
                getBank(data.bank_id)
                nomorInvoice = data.invoice_number;
                $("#invoice_number").val(data.invoice_number);
                $("#invoice_date").val(data.invoice_date);
                $("#contract_number").val(data.contract_number);
                $("#contract_date").val(data.contract_date);
                $("#addendum_number").val(data.addendum_number);
                $("#addendum_date").val(data.addendum_date);
                $("#grand_total_spelled").text(data.grand_total_spelled);
                $("#invoice_terbilang").text(terbilang(data.grand_total));
                $("#grand_total").text('Rp. '+format(data.grand_total));
                $("#invoice_due_date").text(moment(data.invoice_due_date).format('D MMMM YYYY'));
                $("#term_and_conditions").html(data.term_and_condition);
                $("#notes").html(data.notes);
                if (data.materai_name != null || account.level.id == 1) {
                    $('.data-material').removeClass('d-none');
                }
                $("#materai_date").text(moment(data.materai_date).format('D MMMM YYYY'));
                $("#materai_name").text(data.materai_name);
                getDetails(data.invoice_details);
                if (data.materai_image) {
                    $("#materai-image").css('background-img', 'black');
                    $("#materai-image").css("background-image", `url('` + data.materai_image + `')`);
                    $("#materai-image").css("height", `200px`);
                    $("#materai-image").css("width", `200px`);
                    $("#materai-image").css("background-position", `center`);
                    $("#materai-image").css("background-size", `cover`);
                    $("#materai-image").css("background-repeat", `no-repeat`);
                }
                if ((data.status == 'Terkirim' || data.status == 'Kurang Bayar') && account.level.id == 10) {
                    $('.add-payment').removeClass('d-none');
                }
                if (data.status == 'Disetujui BM' && account.level.id == 10) {
                    $('.kirim-invoice').removeClass('d-none');
                }
                if ((account.level.id == '9' && data.status == 'Terbuat') || (data.status == 'Disetujui KA' && account.level.id == '1')) {
                    $('.disetujui').removeClass('d-none');
                }
                if (account.level.id == '10' && data.status == 'Terbuat') {
                    $('.edit').removeClass('d-none');
                }
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    $(document).on('click', '.add-pay', function(event) {
        event.preventDefault();
        window.location.href = "/invoice/tanda-terima/add?id-invoice=" + id
    });

    function getTenant(id) {
        $.ajax({
            url: "{{env('BASE_URL_API')}}" +'/api/tenant/' + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#company").text(data.company);
                $("#floor").text(data.floor);
                $("#name_tenant").text(data.name);
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
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

    function getBank(id) {
        $.ajax({
            url: "{{env('BASE_URL_API')}}" +'/api/bank/' + id,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#account-name").text(data.account_name);
                $("#account-number").text(data.account_number)
                $("#branch-name").text(data.branch_name)
                $("#bank-name").text(data.name)
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
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

    function getDetails(detailItems) {
        let details = detailItems;
        let getDetail = '';
        let tem = '';
        let subtotal = 0;
        let totalTax = 0;
        let totalDiskon = 0;
        for (let i = 0; i < details.length; i++) {
            let tax = getTax(details[i].tax_id);
            let tax_name = '';
            let countTax = 0;
            if(tax != undefined){
                tax_name = tax.name;
                countTax = tax.value / 100;
            }
            
            tem = `<tr>
                        <td>` + details[i].item + `</td>
                        <td>` + details[i].description + `</td>
                        <td>` + details[i].quantity + `</td>
                        <td>` + format(details[i].price) + `</td>
                        <td>` + details[i].discount + `</td>
                        <td>` +  tax_name + `</td>
                        <td style="text-align:right;">Rp. ` + format(details[i].total_price) + `</td>
                    </tr>
            `;
            let discount = details[i].discount / 100;
            totalTax += (details[i].quantity * details[i].price) * countTax;
            totalDiskon += (details[i].quantity * details[i].price) * discount;
            subtotal += details[i].total_price;
            getDetail = getDetail + tem;
        }
        $('#tax').text('Rp. '+format(totalTax));
        $('#discount').text('Rp. '+format(totalDiskon));
        $('#sub_total').text('Rp. '+format(subtotal));
        $('#details').prepend(getDetail);
    }
</script>
@endsection