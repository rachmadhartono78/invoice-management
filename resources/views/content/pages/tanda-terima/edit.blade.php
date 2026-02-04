@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tanda Terima')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet"
        href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row invoice-add">
            <!-- Tanda Terima Edit-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card invoice-preview-card" id="editTandaTerima">
                    <div class="card-body">
                        <div
                            style="background-image: url('{{ asset('assets/img/header.png') }}'); height : 150px; background-size: contain; background-repeat: no-repeat;">
                        </div>

                        <div class="row m-sm-2 m-0 px-3">
                            <div class="col-md-7 mb-md-0 ps-0">

                            </div>
                            <div class="col-md-5">
                                <dl class="row mb-2">
                                    </dd>
                                    <dt class="col-sm-6 text-md-end ps-0">

                                    </dt>
                                    <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                                        <div class="mb-3">
                                            <label for="note" class="form-label fw-medium">No Tanda Terima:</label>
                                            <input type="text" class="form-control w-px-150 " id="receipt_number"
                                                name="receipt_number" placeholder="" />
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                        <h2 class="mx-auto text-center"><b>TANDA TERIMA PEMBAYARAN</b></h2>
                        <span class="mt-5 px-3" style="display: block">Telah terima Pembayaran Tunai / Cek / Giro</span>
                        <div class="row py-3 px-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3 w-px-250">
                                    <label for="note" class="form-label fw-medium">No Invoice</label>
                                    <select class="form-select select2 w-px-250 select-invoice item-details mb-3">
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">No. Cek/Giro</label>
                                    <input type="text" class="form-control w-px-250 " id="check_number"
                                        name="check_number" placeholder="Nomor" />
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Nama Tenant</label>
                                    <select class="form-select select2 w-px-250 select-tenant item-details mb-3">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Total Invoice</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="grand_total" name="grand_total"
                                    placeholder="Total Invoice" fdprocessedid="yombzp">
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Dibayarkan</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="paid" name="paid"
                                    placeholder="Dibayarkan" fdprocessedid="yombzp">
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Sisa Tagihan</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control qty price" id="remaining" name="remaining"
                                    placeholder="Sisa Tagihan" fdprocessedid="yombzp">
                            </div>
                        </div>
                        <div class="row px-3 d-flex align-items-center mb-3">
                            <div class="col-2">
                                <label for="salesperson" class="form-label  fw-medium">Terbilang</label>
                            </div>
                            <div class="col-10">
                                <input type="text" class="form-control " id="grand_total_spelled"
                                    name="grand_total_spelled" placeholder="Terbilang" fdprocessedid="yombzp">
                            </div>
                        </div>

                        <div class="row py-3 px-3">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <textarea class="form-control" rows="11" id="note" name="note" placeholder="Catatan"></textarea>
                                <br>
                                <br>
                                <span>
                                    Apabila dibayar dengan cek / Bilyet giro, Pembayaran baru dianggap sah apabila telah
                                    dapat dicairkan di Bank kami.
                                </span>
                            </div>

                            <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center data-materai">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Tanda Tangan & Materai</label>
                                    <input type="text" class="form-control w-px-250 date" id="signature_date"
                                        name="signature_date" placeholder="Tanggal" style="text-align: center" />
                                </div>
                                <div class="mb-3">
                                    <div action="/upload" class="dropzone needsclick dz-clickable w-px-250"
                                        id="dropzone-basic">
                                        <div class="dz-message needsclick">
                                            <span class="note needsclick">Unggah Tanda Tangan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control w-px-250 " id="signature_name" name="signature_name" placeholder="Nama" style="text-align: center" />
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
                        <button class="btn btn-primary d-grid w-100 mb-2 kirim-tanda-terima d-none" data-bs-toggle="offcanvas"
                            data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                    class="ti ti-send ti-xs me-2"></i>Kirim Tanda Terima</span>
                                </button>
                        <button type="button" class="btn btn-primary btn-update d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="fa fa-save fa-xs me-2"></i>Simpan</span></button>
                        {{-- <a href="" class="btn btn-success d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-eye ti-xs me-2"></i>Preview</span></a> --}}
                        <button type="button" class="btn btn-secondary btn-cancel d-grid w-100">Kembali</button>
                    </div>
                </div>
            </div>
            <!-- /Invoice Actions -->
        </div>

        <!-- Offcanvas -->
        <!-- Send Invoice Sidebar -->
        <div class="offcanvas offcanvas-end" id="sendInvoiceOffcanvas" aria-hidden="true">
            <div class="offcanvas-header my-1">
                <h5 class="offcanvas-title">Send Invoice</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-0 flex-grow-1">
                <form>
                    <div class="mb-3">
                        <label for="invoice-from" class="form-label">From</label>
                        <input type="text" class="form-control" id="invoice-from" value="shelbyComapny@email.com"
                            placeholder="company@email.com" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-to" class="form-label">To</label>
                        <input type="text" class="form-control" id="invoice-to" value="qConsolidated@email.com"
                            placeholder="company@email.com" />
                    </div>
                    <div class="mb-3">
                        <label for="invoice-subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="invoice-subject"
                            value="Invoice of purchased Admin Templates" placeholder="Invoice regarding goods" />
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
                        <button type="button" class="btn btn-label-secondary"
                            data-bs-dismiss="offcanvas">Cancel</button>
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
    <script
        src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
    </script>
    <script src="{{asset('assets/vendor/libs/moment/moment.js')}}">
    </script>
    <script>
        $(document).ready(function() {
            let account = {!! json_encode(session('data')) !!}
            var levelId = account.level_id;
            var department = account.department.name;
            var nameUser = account.name;

            // Date
            $('.date').flatpickr({
                dateFormat: 'd-m-Y'
            });

            Swal.fire({
                title: 'Loading...',
                text: "Please wait",
                customClass: {
                    confirmButton: 'd-none'
                },
                buttonsStyling: false
            });

           

            // Mendapatkan id dengan cara mengambil dari URL
            var urlSegments = window.location.pathname.split('/');
            var idIndex = urlSegments.indexOf('edit') + 1;
            var id = urlSegments[idIndex];

            getDataTandaTerima(id);

            function getDataTandaTerima(id) {
                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" +'/api/receipt/'+ id,
                    type: "GET",
                    dataType: "json",
                    success: function(res) {
                        let response = res.data;
                        $('#editTandaTerima').find('.form-control').each(function() {
                            let inputName = $(this).attr('name');
                            let inputValue = response[inputName];
                            if (inputName === 'grand_total' || inputName === 'paid' || inputName === 'remaining') {
                                let formattedValue = parseFloat(inputValue).toLocaleString('en-US');
                                $("#" + $(this).attr('id')).val(formattedValue);
                            } else if (inputName === 'jabatan') {
                                if (inputValue === undefined) {
                                    inputValue = 'Kepala BM';
                                }
                                $("#" + $(this).attr('id')).val(inputValue);
                            } else {
                                $("#" + $(this).attr('id')).val(inputValue);
                            }

                        });

                        if(response.status !='Terbuat'){
                            $('.form-control').attr('readonly', 'readonly');
                        }

                        $('#signature_date').val(response.signature_date ? moment(response.signature_date, 'YYYY-MM-DD').format('DD-MM-YYYY') : '');
                        $(".select-tenant").empty().append('<option value="' + response.tenant_id +'">' + response.tenant.name + '</option>').val(response.tenant_id).trigger("change");
                        $(".select-invoice").empty().append('<option value="' + response.invoice_id +'">' + response.invoice.invoice_number + '</option>').val(response.invoice_id).trigger("change");
                        if (response.signature_image != '') {
                            $('.prev-img').attr('src', response.signature_image);
                        } else {
                            $('.dz-nopreview').css('display', 'block');
                            $('.dz-success-mark').css('display', 'none');
                        }
                        if(response.status != 'Disetujui BM'){
                            $('.kirim-tanda-terima').attr('style','display:none !important');
                            $('.add-payment').attr('style','display:none !important');
                        }
                        if(account.level.id != '1'){
                            $('.data-materai').attr('style','display:none !important');
                        }
                        if(account.level.id != '1'){
                            $('.data-materai').attr('style','display:none !important');
                        }

                        if (account.level.id == 1) { // BM
                            let ttdFile = null;
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
                                        while (this.files.length > this.options.maxFiles) this.removeFile(this
                                            .files[0]);
                                        ttdFile = file;
                                    });
                                }
                            });
                            var inputValue = $("#signature_name").val();
                            $("#signature_name").val(nameUser);
                            $("#signature_name").prop('readonly', true);
                            $(".btn-update span").html('<i class="ti ti-check ti-xs me-2"></i>Disetujui Kepala BM');
                            $('#signature_date').prop('disabled', false);
                            $('#jabatan').prop('readonly', false);
                            $("#jabatan").val("Kepala BM");
                        
                        } else { // other
                            $('#signature_date').prop('disabled', true);
                            $('#signature_name').prop('readonly', true);
                            $('#jabatan').prop('readonly', true);
                        }

                        if(response.status !='Terbuat' && account.level.id == 10){
                            $('.form-control').attr('readonly', 'readonly');
                            $('.btn-remove-mg').remove();
                            $('.btn-add-row-mg').remove();
                            $('.data-input, .select-classification, .row-input').attr('disabled', 'disabled');
                            $('.select2').attr('disabled', 'disabled');
                            $(".btn-update").addClass('d-none');
                        }
                        Swal.close();
                    },
                    error: function(errors) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors.responseJSON.message,
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        })
                    }
                });
            }

            // Update, Insert, and Create
            $(".btn-update").on('click', function() {
                let invoice = $('.select-invoice').val();
                let tenant = $('.select-tenant').val();
                let date = $('.date').val();

                if (!$('.dz-thumbnail img[data-dz-thumbnail]').hasClass('prev-img')) {
                    console.log($('img[data-dz-thumbnail]').attr('src'));
                }

                let datas = {}

                $('#editTandaTerima').find('.form-control').each(function() {
                    var inputId = $(this).attr('id');
                    var inputValue = $("#" + inputId).val();

                    if (inputId === 'grand_total' || inputId === 'paid' || inputId ===
                        'remaining') {
                        var inputValueWithoutComma = inputValue.replaceAll(',', '');

                        datas[$("#" + inputId).attr("name")] = parseInt(
                            inputValueWithoutComma, 10);
                    } else if (inputId === 'receipt_date') {
                        datas[$("#" + inputId).attr("name")] = moment(inputValue, 'D-M-YYYY')
                            .format('YYYY-MM-DD');
                    } else {
                        datas[$("#" + inputId).attr("name")] = inputValue;
                    }
                });

                datas.invoice_id = parseInt(invoice);
                datas.tenant_id = parseInt(tenant);
                if(account.level.id == '1'){
                    datas.status = "Disetujui BM";
                }else{
                    datas.status = "Terbuat";
                }
                datas.receipt_date = moment().format('YYYY-MM-DD');
                if (!$('img[data-dz-thumbnail]').hasClass('prev-img')) {
                    datas.signature_image = $('img[data-dz-thumbnail]').attr('src');
                }
                datas.signature_date = date ? moment(date, 'D-M-YYYY').format('YYYY-MM-DD'): null;

                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" +'/api/receipt/'+ id,
                    type: "PATCH",
                    data: JSON.stringify(datas),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading...',
                            text: "Please wait",
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        });
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil update Tanda Terima',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href ='{{ url("invoice/tanda-terima") }}';
                            }
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
            });

            // Cancel
            $(".btn-cancel").on('click', function() {
                window.location.href = '{{ url("invoice/tanda-terima") }}';
            })

            $('#paid').on('keyup', function() {
                getTotal(); // Memanggil fungsi getTotal() setiap kali terjadi perubahan pada input
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

            $('.dz-remove').on('click', function() {
                // Find the <img> element
                var imgElement = $('.prev-img');

                // Check if the imgElement exists
                if (imgElement.length > 0) {
                    // Remove the 'src' attribute
                    imgElement.removeAttr('src');

                    // Add the desired class
                    $('.prev').hide();
                    $('.click').show();

                    imgElement.addClass('dropzone needsclick dz-clickable');
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

            $(".select-invoice").select2({
                placeholder: 'Select Invoice',
                allowClear: true,
                ajax: {
                    url: "{{ env('BASE_URL_API')}}" +'/api/invoice/select',
                    dataType: 'json',
                    cache: true,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            search: params.term,
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
    </script>

@endsection
