@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tanda Terima')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-tanda-terima" class="create-tanda-terima" novalidate>
        <div class="row invoice-add">
            <!-- Invoice Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card" id="addTandaTerima">
                    <div class="card-body">
                        <div style="background-image: url('{{ asset('assets/img/header.png') }}'); height : 150px; background-size: contain; background-repeat: no-repeat;">
                        </div>

                        <div class="row m-sm-2 m-0 px-3">
                            <div class="col-md-7 mb-md-0 ps-0">

                            </div>
                            <div class="col-md-5">
                                <dl class="row mb-2">
                                    </dd>
                                    <dt class="col-sm-6 text-md-end ps-0">

                                    </dt>
                                </dl>
                            </div>
                        </div>
                        <h2 class="mx-auto text-center"><b>TANDA TERIMA PEMBAYARAN</b></h2>
                        <span class="mt-5 px-3" style="display: block">Telah terima Pembayaran Tunai / Cek / Giro</span>
                        <div class="row py-3 px-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3 w-px-250">
                                    <label for="note" class="form-label fw-medium">No Invoice</label>
                                    <select class="form-select select2 w-px-250 select-invoice item-details mb-3" id="invoice_number" required>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">No. Cek/Giro</label>
                                    <input type="text" class="form-control w-px-250 " id="check_number" name="check_number" placeholder="Nomor" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                               
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Nama Tenant</label>
                                    <select id="tenant" class="form-select select2 w-px-250 select-tenant item-details mb-3" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Total Invoice</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="grand_total" name="grand_total" placeholder="Total Invoice" fdprocessedid="yombzp" required>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Sudah Dibayarkan</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="total_paid" name="total_paid" placeholder="Sudah Dibayarkan" fdprocessedid="yombzp" required readonly>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Dibayarkan</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="paid" name="paid" placeholder="Dibayarkan" fdprocessedid="yombzp" required>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Sisa Tagihan</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="remaining" name="remaining" placeholder="Sisa Tagihan" fdprocessedid="yombzp" required>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Terbilang</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control pe-none" id="grand_total_spelled" name="grand_total_spelled" placeholder="Terbilang" fdprocessedid="yombzp" required>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <textarea class="form-control" rows="11" id="note" name="note" placeholder="Catatan" required></textarea>
                                <br>
                                <br>
                                <span>
                                    Apabila dibayar dengan cek / Bilyet giro, Pembayaran baru dianggap sah apabila telah
                                    dapat dicairkan di Bank kami.
                                </span>
                            </div>

                            <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center">
                                <div class="mb-3 ttd">
                                    <label for="note" class="form-label fw-medium">Tanda Tangan</label>
                                    <input type="text" class="form-control w-px-250 date" id="receipt_date" name="receipt_date" placeholder="Tanggal" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
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
                        <button type="submit" class="btn btn-primary btn-save d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="fa fa-save fa-xs me-2"></i>Simpan</span></button>
                        {{-- <button class="btn btn-success d-grid w-100 mb-2 btn-preview"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-eye ti-xs me-2"></i>Preview</span></button> --}}
                        <button type="button" class="btn btn-secondary d-grid w-100 btn-cancel">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoice Actions -->
</div>
</form>
<!-- Offcanvas -->
<!-- Send Invoice Sidebar -->
<div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
    <div class="offcanvas-header my-1">
        <h5 class="offcanvas-title">Send Invoice</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0 flex-grow-1">
        <form>
            <div class="mb-3">
                <label for="invoice-from" class="form-label">From</label>
                <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com" placeholder="company@email.com" />
            </div>
            <div class="mb-3">
                <label for="invoice-to" class="form-label">To</label>
                <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com" placeholder="company@email.com" />
            </div>
            <div class="mb-3">
                <label for="invoice-subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="invoice-subject" value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
            </div>
            <div class="mb-3">
                <label for="invoice-message" class="form-label">Message</label>
                <textarea class="form-control" name="invoice-message" id="invoice-message" cols="3" rows="8">Dear Queen Consolidated,
          Thank you for your business, always a pleasure to work with you!
          We have generated a new invoice in the amount of $95.59
          We would appreciate payment of this invoice by 05/11/2021</textarea>
            </div>
            <div class="mb-4">
                <span class="badge bg-label-primary">
                    <i class="ti ti-link ti-xs"></i>
                    <span class="align-middle">Invoice Attached</span>
                </span>
            </div>
            <div class="mb-3 d-flex flex-wrap">
                <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            </div>
        </form>
    </div>
</div>
<!-- /Send Invoice Sidebar -->
<!-- /Offcanvas -->

</div>
<!-- / Content -->

@endsection

@section('page-script')
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
</script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}">
</script>
<script>
    let account = {!! json_encode(session('data')) !!}
    var levelId = account.level_id;
    if (levelId == 10) {
        $('.ttd').hide();
    }
</script>
<script>
    $(document).ready(function() {

        var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
        
        // Mendapatkan id dari invoice
        const idInvoice = getParameterByName('id-invoice');
        let dataLocal = JSON.parse(localStorage.getItem("receipt"));

        if (idInvoice) {
            getDataInvoice(idInvoice);
        }

        // Function to get URL parameter by name using jQuery
        function getParameterByName(name) {
            var url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Date
        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });

        if (dataLocal) {
            load(dataLocal);
        }

        function getTenant() {
            let idTenant = dataLocal.tenant_id;
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" +"/api/tenant/" + idTenant,
                type: "GET",
                success: function(response) {
                    let data = response.data;
                    let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                    $('#tenant').prepend(tem);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function getTenant() {
            let idTenant = dataLocal.tenant_id;
            console.log(idTenant);
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" +"/api/tenant/" + idTenant,
                type: "GET",
                success: function(response) {
                    let data = response.data;
                    let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                    $('#tenant').prepend(tem);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        function load(dataLocale) {
            Swal.fire({
                title: '<h2>Loading...</h2>',
                html: sweet_loader + '<h5>Please Wait</h5>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });

            $("#grand_total").val(dataLocal.grand_total?.toLocaleString());
            $("#total_paid").val(dataLocal.total_paid?.toLocaleString());
            $("#paid").val(dataLocal.paid?.toLocaleString());
            $("#remaining").val(dataLocal.remaining?.toLocaleString());
            $("#grand_total_spelled").val(dataLocal.grand_total_spelled);
            $("#note").val(dataLocal.note);
            $("#check_number").val(dataLocal.check_number);


            if (dataLocal.tenant_id) {
                getTenant();
            }
           
            if (dataLocal.invoice_id) {
                getInvoiceNumber();
            }
            Swal.close();
        }

        function getInvoiceNumber() {
            let idInvoice = dataLocal.invoice_id;
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" +'/api/invoice/' + idInvoice,
                type: "GET",
                success: function(response) {
                    let data = response.data;
                    console.log(data);
                    let tem = `<option value="` + data.id + `" selected>` + data.invoice_number + `</option>`;
                    $('#invoice_number').prepend(tem);

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        // Date
        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });

        // Dropzone
        let ttdFile = null;
        if (account.level.id == '1') {
            const myDropzone = new Dropzone('#dropzone-basic', {
                parallelUploads: 1,
                maxFilesize: 10,
                addRemoveLinks: true,
                maxFiles: 1,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                autoQueue: false,
                init: function() {
                    this.on('addedfile', function(file) {
                        while (this.files.length > this.options.maxFiles) this.removeFile(this
                            .files[0]);
                        ttdFile = file;
                    });
                }
            });
        }

        $(".select-invoice").on('change', function() {
            validateSelect(this);
        })
    
        $(".select-tenant").on('change', function() {
            validateSelect(this);
        })

        function validateSelect(params) {
            var checkDate = $(params).val();

            if (checkDate === null) {
                event.preventDefault();
                event.stopPropagation();
                $(params).addClass("invalid");
            } else {
                $(params).removeClass("invalid");
            }
        }


        // Save, Insert, and Create
        var saveTandaTerima = $('.create-tanda-terima');

        Array.prototype.slice.call(saveTandaTerima).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        let tenant = $('.select-tenant').val();
                        let invoice = $('.select-invoice').val();

                        if (!invoice) {
                            $(".select-invoice").addClass("invalid");
                        }
                        if (!tenant) {
                            $(".select-tenant").addClass("invalid");
                        }

                    } else {
                        // Submit your form
                        event.preventDefault();
                        Swal.fire({
                            title: 'Loading...',
                            text: "Please wait",
                            customClass: {
                                confirmButton: 'd-none'
                            },
                            buttonsStyling: false
                        });
                        let invoice = $('.select-invoice').val();
                        let tenant = $('.select-tenant').val();
                        let date = $('.date').val();

                        let datas = {}

                        $('#addTandaTerima').find('.form-control').each(function() {
                            var inputId = $(this).attr('id');
                            var inputValue = $("#" + inputId).val();

                            if (inputId === 'grand_total' || inputId === 'paid' ||
                                inputId ===
                                'remaining') {
                                var inputValueWithoutComma = inputValue.replaceAll(',', '');

                                datas[$("#" + inputId).attr("name")] = parseInt(
                                    inputValueWithoutComma);
                            } else if (inputId === 'receipt_date') {
                                datas[$("#" + inputId).attr("name")] = moment(inputValue,
                                        'D-M-YYYY')
                                    .format('YYYY-MM-DD');
                            } else {
                                datas[$("#" + inputId).attr("name")] = inputValue;
                            }
                        });
                        // datas.signature_image = ttdFile;
                        datas.invoice_id = parseInt(invoice);
                        datas.tenant_id = parseInt(tenant);
                        datas.status = 'Terbuat';
                        datas.receipt_date = moment().format('YYYY-MM-DD');
                        datas.signature_image = $('img[data-dz-thumbnail]').attr('src');
                        datas.signature_date = date ? moment(date, 'D-M-YYYY').format('YYYY-MM-DD') : null;
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/receipt',
                            type: "POST",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan Tanda Terima',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then((result) => {
                                    localStorage.removeItem('receipt');
                                    window.location.href = "{{ url('invoice/tanda-terima') }}";
                                });
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

                    form.classList.add("was-validated");
                },
                false
            );
        });

        // Preview before save
        $(".btn-preview").on('click', function() {
            let datas = {}

            let invoice = $('.select-invoice').val();
            let tenant = $('.select-tenant').val();
            let date = $('.date').val();

            $('#addTandaTerima').find('.form-control').each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $("#" + inputId).val();

                if (inputId === 'grand_total' || inputId === 'paid' || inputId ===
                    'remaining') {
                    var inputValueWithoutComma = inputValue.replaceAll(',', '');
                    datas[$("#" + inputId).attr("name")] = parseInt(inputValueWithoutComma);
                } else if (inputId === 'receipt_date') {
                    datas[$("#" + inputId).attr("name")] = moment(inputValue, 'D-M-YYYY')
                        .format('YYYY-MM-DD');
                } else {
                    datas[$("#" + inputId).attr("name")] = inputValue;
                }
            });
            datas.signature_image = ttdFile;
            datas.invoice_id = parseInt(invoice);
            datas.tenant_id = parseInt(tenant);
            datas.status = 'Terbuat';
            datas.receipt_date = moment().format('YYYY-MM-DD');
            datas.signature_image = $('img[data-dz-thumbnail]').attr('src');
            datas.signature_date = moment(date, 'D-M-YYYY').format('YYYY-MM-DD');

            localStorage.setItem('receipt', JSON.stringify(datas));
            window.location.href = "/invoice/tanda-terima/preview"
        })

        // Cancel
        $(document).on('click', '.btn-cancel', function(event) {
            event.preventDefault();
            localStorage.removeItem('receipt');
            window.location.href = "/invoice/tanda-terima"
        });

        // Keyup dibayarkan
        $('#paid').on('keyup', function() {
            var totalInvoice = $('#grand_total').val().replace(/,/g, '') || 0;
            var hasPaid = $('#total_paid').val().replace(/,/g, '') || 0;
            var paidAmount = $(this).val().replace(/,/g, '') || 0;
            var remainingAmount = totalInvoice - hasPaid - paidAmount;
            $('#remaining').val(remainingAmount.toLocaleString('en-US'));
            getTotal();
        });

        // Fungsi terbilang
        function getTotal() {
            let totalArr = [];
            let tempTotal = $("#paid").val().replace(/,/g, '');

            $('#grand_total_spelled').val(terbilang(tempTotal));

        }

        function terbilang(bilangan) {
            bilangan = String(bilangan);
            let angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
                '0');
            let kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan',
                'Sembilan');
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

        // Keyup input qty
        $(document).on('input', '.qty', function() {
            var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(sanitizedValue);
        });

        // Keyup input price
        $(document).on('input', '.price', function() {
            var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
            var numericValue = parseInt(sanitizedValue, 10);

            if (!isNaN(numericValue)) {
                var formattedValue = numericValue.toLocaleString('en-US');

                $(this).val(formattedValue);
            }
        });

        // Select 2 ajax function
        $(".select-tenant").select2({
            placeholder: 'Select Tenant',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" +'/api/tenant/select?field=company',
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

        $(".select-invoice").select2({
            placeholder: 'Select Invoice',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" +'/api/invoice/select?status=terkirim',
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
    })

    function getDataInvoice(id) {
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" +'/api/invoice/' + id,
            type: "GET",
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(res) {
                let total_paid = parseFloat(res.data.total_paid);
                let grand_total = parseFloat(res.data.grand_total);
                let tenant = res.data.tenant;
                $("#total_paid").val(total_paid.toLocaleString('en-US'));
                $("#grand_total").val(grand_total.toLocaleString('en-US'));
                $(".select-tenant").empty().append('<option value="' + tenant.id +
                    '">' + tenant.name + '</option>').val(tenant.id);
                $(".select-invoice").empty().append('<option value="' + res.data.id +
                    '">' + res.data.invoice_number + '</option>').val(res.data.id);
                Swal.close();
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

    function validateSelect(params) {
        var checkDate = $(params).val();

        if (checkDate === null) {
            event.preventDefault();
            event.stopPropagation();
            $(params).addClass("invalid");
        } else {
            $(params).removeClass("invalid");
        }
    }

    // Get invoice data
    $(".select-invoice").on("change", function() {
        Swal.fire({
            title: 'Loading...',
            text: "Please wait",
            customClass: {
                confirmButton: 'd-none'
            },
            buttonsStyling: false
        });
        let id = $(this).val();
        getDataInvoice(id);
    })

    // Cancel
    $(document).on('click', '.btn-cancel', function(event) {
        event.preventDefault();
        localStorage.removeItem('receipt');
        window.location.href = "/invoice/tanda-terima"
    });

    // Keyup dibayarkan
    $('#paid').on('keyup', function() {
        getTotal();
        var totalInvoice = $('#grand_total').val().replace(/,/g, '') || 0;
        var paidAmount = $(this).val().replace(/,/g, '') || 0;
        var remainingAmount = totalInvoice - paidAmount;
        $('#remaining').val(remainingAmount.toLocaleString('en-US'));
    });

    // Fungsi terbilang
    function getTotal() {
        let totalArr = [];
        let tempTotal = $("#paid").val().replace(/,/g, '');

        $('#grand_total_spelled').val(terbilang(tempTotal));

    }

    function terbilang(bilangan) {
        bilangan = String(bilangan);
        let angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0',
            '0');
        let kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan',
            'Sembilan');
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

    // Keyup input qty
    $(document).on('input', '.qty', function() {
        var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
        $(this).val(sanitizedValue);
    });

    // Keyup input price
    $(document).on('input', '.price', function() {
        var sanitizedValue = $(this).val().replace(/[^0-9]/g, '');
        var numericValue = parseInt(sanitizedValue, 10);

        if (!isNaN(numericValue)) {
            var formattedValue = numericValue.toLocaleString('en-US');

            $(this).val(formattedValue);
        }
    });

    // Select 2 ajax function
    $(".select-tenant").select2({
        placeholder: 'Select Tenant',
        allowClear: true,
        ajax: {
            url: "{{ env('BASE_URL_API')}}" +'/api/tenant/select?field=company',
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

    $(".select-invoice").select2({
        placeholder: 'Select Invoice',
        allowClear: true,
        ajax: {
            url: "{{ env('BASE_URL_API')}}" +'/api/invoice/select',
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