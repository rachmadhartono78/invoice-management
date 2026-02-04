@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Purchase Request')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <form id="create-pr" class="create-pr" novalidate>
            <div class="row purchase-req-add" id="addPurchaseRequest">
                <!-- purchase req Add-->
                <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                    <div class="card purchase-req-preview-card">
                        <div class="card-body">
                            <div class="row m-sm-4 m-0">
                                <div class="col-md-12 mb-md-0 mb-4 ps-0">
                                    <h1 class="fw-700 text-center" style="margin: 0;"><b>PURCHASE REQUEST</b></h1>
                                </div>
                            </div>
                            <hr class="my-3 mx-n4">

                            <div class="row">
                                {{-- Form Kiri --}}
                                <div class="col-md-5 py-3 px-3">
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Yang Meminta </label>
                                            <input type="text" class="form-control add" placeholder="Yang Meminta"
                                                id="requester" name="requester" required readonly />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 pe-none">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Departemen </label>
                                            <select class="form-select select2 select-department item-details mb-3"
                                                required readonly>
                                            </select>
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Jumlah Anggaran </label>
                                            <input type="text" class="form-control add qty price" id="total_budget"
                                                name="total_budget" placeholder="Jumlah Anggaran" required readonly />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Usulan Permintaan </label>
                                            <input type="text" class="form-control add qty price"
                                                id="proposed_purchase_price" name="proposed_purchase_price"
                                                placeholder="Usulan Permintaan" required readonly />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Sisa Anggaran </label>
                                            <input type="text" class="form-control add qty price" id="remaining_budget"
                                                name="remaining_budget" placeholder="Sisa Anggaran" required readonly />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Form Kanan --}}
                                <div class="d-flex flex-wrap justify-content-between col-md-7 py-3 px-3">
                                    <div class="col-md-5 mb-0">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Nomor PR </label>
                                            <input type="text" class="form-control" placeholder="Nomor PR"
                                                id="purchase_request_number" name="purchase_request_number" required readonly
                                                disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-0">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Tanggal PR </label>
                                            <input type="text" class="form-control add date pe-none" id="request_date"
                                                name="request_date" placeholder="Tanggal PR" required readonly />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-0 pe-none">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Nomor MR </label>
                                            <select class="form-select select2 select-mr item-details mb-3"
                                                required readonly>
                                            </select>
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-0">
                                        <div class="mb-1">
                                            <label for="note" class="form-label fw-medium">Tanggal MR </label>
                                            <input type="text" class="form-control date pe-none" id="tanggal_mr"
                                                placeholder="Tanggal MR" required readonly />
                                            <div class="invalid-feedback" style="display: none">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <div class="mb-1">
                                            <textarea class="form-control add" rows="7" style="padding: 15px" id="additional_note" name="additional_note"
                                                placeholder="Termin pembayaran, garansi dll" required readonly></textarea>
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Radio Button --}}
                            <div class="row py-3 px-3">
                                <div class="col-12 pe-none">
                                    <div class="">
                                        <div class="form-check form-check-inline checkbox">
                                            <input class="form-check-input checkbox-check" type="checkbox"
                                                name="Sesuai Budget" id="sesuai_budget" required readonly>
                                            <label class="form-check-label" for="sesuai_budget">Sesuai Budget</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox">
                                            <input class="form-check-input checkbox-check" type="checkbox"
                                                name="Diluar Budget" id="diluar_budget" required readonly>
                                            <label class="form-check-label" for="diluar_budget">Diluar Budget</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox">
                                            <input class="form-check-input checkbox-check" type="checkbox" name="penting"
                                                id="penting" required readonly>
                                            <label class="form-check-label" for="penting">Penting</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox">
                                            <input class="form-check-input checkbox-check" type="checkbox"
                                                name="1 Minggu" id="1_minggu" required readonly>
                                            <label class="form-check-label" for="1_minggu">1 Minggu</label>
                                        </div>
                                        <div class="form-check form-check-inline checkbox">
                                            <input class="form-check-input checkbox-check" type="checkbox" name="1 Bulan"
                                                id="1_bulan" required readonly>
                                            <label class="form-check-label" for="1_bulan">1 Bulan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="py-3 px-3">
                                <div class="card academy-content shadow-none border p-3">
                                    {{-- Tambah Baris --}}
                                    <div class="repeater">
                                        <div class="" data-repeater-list="group-a">
                                            <div class="repeater-wrapper " data-repeater-item>
                                                <div class="row flex-wrap mb-3">
                                                    <div class="col-1">
                                                        <label for="note" class="form-label fw-medium">Nomor</label>
                                                        <input type="text" class="form-control" placeholder="Nomor"
                                                            id="number" required readonly />
                                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                                    </div>
                                                    <div class="col-2">
                                                        <label for="note" class="form-label fw-medium">Suku
                                                            Cadang</label>
                                                        <input type="text" class="form-control  " id="suku_cadang"
                                                            placeholder="Suku Cadang" required readonly />
                                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                                    </div>
                                                    <div class="col-5">
                                                        <label for="note" class="form-label fw-medium">Pembelian
                                                            Terakhir</label>
                                                        <div class="d-flex flex-wrap">
                                                            <input type="text" class="form-control date pe-none me-1"
                                                                id="tanggal_rep" style="width: 90px"
                                                                placeholder="Tanggal" required readonly />
                                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                                            <input type="text" class="form-control qty me-1"
                                                                id="kuantitas" style="width: 90px"
                                                                placeholder="Kuantitas" required readonly />
                                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                                            <input type="text" class="form-control qty"
                                                                id="persediaan" style="width: 90px"
                                                                placeholder="Persediaan" required readonly />
                                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <label for="note"
                                                            class="form-label fw-medium">Keterangan</label>
                                                        <input type="text" class="form-control " id="deskripsi"
                                                            placeholder="Deskripsi" required readonly />
                                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                                    </div>
                                                    <div class="col-1">
                                                        <label for="note"
                                                            class="form-label fw-medium">Quantity</label>
                                                        <input type="text" class="form-control qty" id="qty"
                                                            placeholder="Kuantitas" required readonly />
                                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                                    </div>
                                                    <a class="mb-3 mx-2 mt-4" style="width: 10px" role="button"
                                                        data-repeater-delete>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                            height="12" viewBox="0 0 12 12" fill="none">
                                                            <circle cx="6" cy="6" r="6" fill="#D9D9D9" />
                                                            <path
                                                                d="M6.70432 5.99276L8.85224 3.8544C8.9463 3.76053 8.99915 3.63323 8.99915 3.50049C8.99915 3.36775 8.9463 3.24045 8.85224 3.14659C8.75818 3.05273 8.63061 3 8.49759 3C8.36456 3 8.23699 3.05273 8.14293 3.14659L6 5.28994L3.85707 3.14659C3.76301 3.05273 3.63544 3 3.50241 3C3.36939 3 3.24182 3.05273 3.14776 3.14659C3.0537 3.24045 3.00085 3.36775 3.00085 3.50049C3.00085 3.63323 3.0537 3.76053 3.14776 3.8544L5.29568 5.99276L3.14776 8.13113C3.10094 8.17747 3.06378 8.23259 3.03842 8.29334C3.01306 8.35408 3 8.41923 3 8.48503C3 8.55083 3.01306 8.61598 3.03842 8.67672C3.06378 8.73746 3.10094 8.79259 3.14776 8.83893C3.19419 8.88565 3.24944 8.92273 3.31031 8.94804C3.37118 8.97335 3.43647 8.98637 3.50241 8.98637C3.56836 8.98637 3.63365 8.97335 3.69452 8.94804C3.75539 8.92273 3.81063 8.88565 3.85707 8.83893L6 6.69558L8.14293 8.83893C8.18937 8.88565 8.24461 8.92273 8.30548 8.94804C8.36635 8.97335 8.43164 8.98637 8.49759 8.98637C8.56353 8.98637 8.62882 8.97335 8.68969 8.94804C8.75056 8.92273 8.80581 8.88565 8.85224 8.83893C8.89906 8.79259 8.93622 8.73746 8.96158 8.67672C8.98694 8.61598 9 8.55083 9 8.48503C9 8.41923 8.98694 8.35408 8.96158 8.29334C8.93622 8.23259 8.89906 8.17747 8.85224 8.13113L6.70432 5.99276Z"
                                                                fill="#FF4747" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row pb-1">
                                            <div class="col-12">
                                                <button type="button" id="tambah-baris-btn"
                                                    class="btn btn-primary waves-effect waves-light">Tambah Baris</button>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Divider --}}
                                    <div class="row py-3 px-3">
                                        <hr class="my-3 mx-auto">
                                    </div>

                                    {{-- Tanda tangan --}}
                                    <div class="row  text-center mb-5">
                                        <div class="col-3 signatures">
                                            <label for="note" class="form-label fw-medium">Diperiksa Oleh :</label>
                                            <input type="text" value="Checked By" id="type1" name="type" class="form-control d-none">
                                            <div class="mb-3">
                                                <input type="text" class="form-control  " placeholder="Nama & Jabatan"
                                                    style="text-align:center;" id="name1" name="name" required readonly />
                                                <div class="invalid-feedback">Tidak boleh kosong</div>
                                            </div>
                                            <div class="mb-3">
                                                <div
                                                    class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                                    <div class="dz-details">
                                                        <div class="dz-thumbnail"> <img class="prev-img-1" alt=""
                                                                src="">
                                                            <span class="dz-nopreview">No preview</span>
                                                        </div>
                                                    </div>
                                                    {{-- <a class="dz-remove" id="3"
                                                        href="javascript:undefined;" data-dz-remove="">Remove
                                                        file</a> --}}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control pe-none date" placeholder="Tanggal"
                                                    style="text-align:center;" id="date1" name="date" required readonly />
                                                <div class="invalid-feedback">Tidak boleh kosong</div>
                                            </div>
                                        </div>
                                        <div class="col-3 signatures">
                                            <label for="note" class="form-label fw-medium">Diperiksa Oleh :</label>
                                            <input type="text" value="Checked By" id="type2" name="type" class="form-control d-none">
                                            <div class="mb-3">
                                                <input type="text" class="form-control  " placeholder="Nama & Jabatan"
                                                    style="text-align:center;" id="name2" name="name" required readonly />
                                                <div class="invalid-feedback">Tidak boleh kosong</div>
                                            </div>
                                            <div class="mb-3">
                                                <div
                                                    class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                                    <div class="dz-details">
                                                        <div class="dz-thumbnail"> <img class="prev-img-2" alt=""
                                                                src="">
                                                            <span class="dz-nopreview">No preview</span>
                                                        </div>
                                                    </div>
                                                    {{-- <a class="dz-remove" id="3"
                                                        href="javascript:undefined;" data-dz-remove="">Remove
                                                        file</a> --}}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control pe-none date" placeholder="Tanggal"
                                                    style="text-align:center;" id="date2" name="date" required readonly />
                                                <div class="invalid-feedback">Tidak boleh kosong</div>
                                            </div>
                                        </div>
                                        <div class="col-3 signatures">
                                            <label for="note" class="form-label fw-medium">Diketahui Oleh :</label>
                                            <input type="text" value="Known By" id="type3" name="type" class="form-control d-none">
                                            <div class="mb-3">
                                                <input type="text" class="form-control  " placeholder="Nama & Jabatan"
                                                    style="text-align:center;" id="name3" name="name" required readonly />
                                                <div class="invalid-feedback">Tidak boleh kosong</div>
                                            </div>
                                            <div class="mb-3">
                                                <div
                                                    class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                                                    <div class="dz-details">
                                                        <div class="dz-thumbnail"> <img class="prev-img-3" alt=""
                                                                src="">
                                                            <span class="dz-nopreview">No preview</span>
                                                        </div>
                                                    </div>
                                                    {{-- <a class="dz-remove" id="3"
                                                        href="javascript:undefined;" data-dz-remove="">Remove
                                                        file</a> --}}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="text" class="form-control pe-none date" placeholder="Tanggal"
                                                    style="text-align:center;" id="date3" name="date" required readonly />
                                                <div class="invalid-feedback">Tidak boleh kosong</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-2">
                                            <p>
                                                Lembar
                                            </p>
                                        </div>
                                        <div class="col-6 row flex-wrap">
                                            <div class="col-6 order-1">1. Accounting (Putih)</div>
                                            <div class="col-6 order-3">2. Gudang (Merah)</div>

                                            <!-- Force next columns to break to new line -->
                                            <div class="w-100"></div>

                                            <div class="col-6 order-2">3. Purchasing (Hijau)</div>
                                            <div class="col-6 order-4">4. Pemohon (Biru)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /purchase req Add-->

                <!-- purchase req Actions -->
                <div class="col-lg-3 col-12 purchase-req-actions">
                    <div class="card mb-4">
                        <div class="card-body">
                            <button type="button" class="btn btn-label-secondary btn-cancel d-grid w-100">Kembali</button>
                        </div>
                    </div>
                </div>
                <!-- /purchase req Actions -->
            </div>
        </form>

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
    <script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
    <script
        src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
    </script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js')}}">
    </script>
    <script>
        $(document).ready(function() {
            $('.repeater').repeater({

            })

            // Date
            $('.date').flatpickr({
                dateFormat: 'd-m-Y'
            });

            // Check date
            $("#tanggal_mr").on('change', function() {
                validateDate();
            })

            function validateDate() {
                var checkDate = $('#tanggal_mr').val();

                if (checkDate === null) {
                    event.preventDefault();
                    event.stopPropagation();
                    $('#tanggal_mr').addClass("invalid");
                } else {
                    $('#tanggal_mr').removeClass("invalid");
                }
            }

            $("#tanggal_pr").on('change', function() {
                validateDateTanggalPr();
            })

            function validateDateTanggalPr() {
                var checkDate = $('#tanggal_pr').val();

                if (checkDate === null) {
                    event.preventDefault();
                    event.stopPropagation();
                    $('#tanggal_pr').addClass("invalid");
                } else {
                    $('#tanggal_pr').removeClass("invalid");
                }
            }

            // Menambahkan event listener untuk tombol "Tambah Baris"
            $('#tambah-baris-btn').on('click', function() {
                var newRow = $('.repeater-wrapper:first').clone();

                newRow.find('input').val('');

                $('[data-repeater-list="group-a"]').append(newRow);

                newRow.find('.date').flatpickr({
                    dateFormat: 'd-m-Y'
                });
            });

            // Fungsi untuk mengambil value dari setiap baris
            function getRepeaterValues() {
                var values = [];

                $('.repeater-wrapper').each(function() {
                    var rowValues = {
                        number: $(this).find('#number').val(),
                        part_number: $(this).find('#suku_cadang').val(),
                        last_buy_date: moment($(this).find('#tanggal_rep').val(), 'D-M-YYYY')
                                    .format('YYYY-MM-DD'),
                        last_buy_quantity: parseInt($(this).find('#kuantitas').val()) || 0,
                        last_buy_stock: parseInt($(this).find('#persediaan').val()) || 0,
                        description: $(this).find('#deskripsi').val(),
                        quantity: parseInt($(this).find('#qty').val()) || 0
                    };

                    values.push(rowValues);
                });

                return values;
            }

            // Get Data
            var urlSegments = window.location.pathname.split('/');
            var idIndex = urlSegments.indexOf('preview') + 1;
            var id = urlSegments[idIndex];

            getDataPurchaseRequest(id);

            function getDataPurchaseRequest(id) {
                Swal.fire({
                    title: 'Loading...',
                    text: "Please wait",
                    customClass: {
                        confirmButton: 'd-none'
                    },
                    buttonsStyling: false
                });
                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" +'/api/purchase-request/' + id,
                    type: "GET",
                    dataType: "json",
                    success: function(res) {
                        let response = res.data;
                        $('#addPurchaseRequest').find('.form-control').each(function() {
                            var elementId = $(this).attr('id');
                            var elementName = $(this).attr('name');

                            if (elementId === 'request_date' || elementId ===
                                'action_plan_date' || elementId === 'finish_plan') {
                                // Format tanggal menggunakan moment.js
                                $("#" + elementId).val(moment(response[elementName],
                                    'YYYY-MM-DD').format('DD-MM-YYYY'));
                            } else if (elementId === 'total_budget' || elementId === 'proposed_purchase_price' || elementId === 'remaining_budget') {
                                $("#" + elementId).val(response[elementName].toLocaleString('en-US'));
                            } else {
                                $("#" + elementId).val(response[elementName]);
                            }
                        });

                        // Mengambil data department
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/department/' + response.department_id,
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(res) {
                                $(".select-department").empty().append('<option value="' + res.data
                                    .id + '">' + res.data.name +
                                    '</option>').val(
                                    res.data.id);
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

                        // Mengambil data material
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" +'/api/material-request/' + response.material_request_id,
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function(res) {
                                $(".select-mr").empty().append('<option value="' + res.data
                                    .id + '">' + res.data.id +
                                    '</option>').val(
                                    res.data.id);
                                $("#tanggal_mr").val(moment(res.data.request_date, 'YYYY-M-D').format('DD-MM-YYYY'));
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

                        // Set value ke repeater
                        var firstRow = $('.repeater-wrapper').first();

                        for (var i = 0; i < response.purchase_request_details.length; i++) {
                            var rowValues = response.purchase_request_details[i];

                            if (i === 0) {
                                firstRow.find('#number').val(rowValues.number);
                                firstRow.find('#suku_cadang').val(rowValues.part_number);
                                firstRow.find('#tanggal_rep').val(moment(rowValues.last_buy_date, 'YYYY-MM-DD').format('D-M-YYYY'));
                                firstRow.find('#kuantitas').val(rowValues.last_buy_quantity);
                                firstRow.find('#persediaan').val(rowValues.last_buy_stock);
                                firstRow.find('#deskripsi').val(rowValues.description);
                                firstRow.find('#qty').val(rowValues.quantity);
                            } else {
                                var newRow = firstRow.clone();
                                firstRow.find('#number').val(rowValues.number);
                                firstRow.find('#suku_cadang').val(rowValues.part_number);
                                firstRow.find('#tanggal_rep').val(moment(rowValues.last_buy_date, 'YYYY-MM-DD').format('D-M-YYYY'));
                                firstRow.find('#kuantitas').val(rowValues.last_buy_quantity);
                                firstRow.find('#persediaan').val(rowValues.last_buy_stock);
                                firstRow.find('#deskripsi').val(rowValues.description);
                                firstRow.find('#qty').val(rowValues.quantity);

                                $('.repeater [data-repeater-list="group-a"]').append(newRow);
                            }
                        }

                        $('.repeater').repeater();

                        $('.checkbox-check').each(function() {
                            var checkboxName = $(this).attr('name').toLowerCase();
                            if ((response.budget_status).toLowerCase() === checkboxName) {
                                $('.checkbox-check').not(this).prop('disabled', true);
                                $(this).prop('checked', true);
                            } else {
                                $(this).prop('checked', false);
                            }
                        });

                        // Set value ke form signature
                        for (let i = 1; i < response.purchase_request_signatures.length + 1; i++) {
                            $("#name" + i).val(response.purchase_request_signatures[i - 1].name);
                            if (response.purchase_request_signatures[i - 1].signature != '') {
                                $('.prev-img-' + i).attr('src', response.purchase_request_signatures[i - 1]
                                    .signature);
                            } else {
                                $('.dz-nopreview').css('display', 'block');
                            }
                            $('#date' + i).val(moment(response.purchase_request_signatures[i - 1]
                                .date, 'YYYY-MM-DD').format('DD-MM-YYYY'));
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

            // Cancel
            $(".btn-cancel").on("click", function() {
                window.location.href = "/request/list-purchase-request"
            })

            // Select2
            $(".select-department").select2({
                placeholder: 'Select Department',
                allowClear: true,
                ajax: {
                    url: "{{ env('BASE_URL_API')}}" +'/api/department/select',
                    dataType: 'json',
                    cache: true,
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            field: params.name || 'name'
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

            $(".select-mr").select2({
                placeholder: 'Select Material Request',
                allowClear: true,
                ajax: {
                    url: "{{ env('BASE_URL_API')}}" +'/api/material-request/select',
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

            // Mengambil data tanggal untuk material request
            $(".select-mr").on('change', function() {
                var id = $(this).val();

                $.ajax({
                    url: "{{ env('BASE_URL_API')}}" +'/api/material-request/' + id,
                    method: 'GET',
                    success: function(res) {
                        let response = res.data;
                        $("#tanggal_mr").val(moment(response.request_date).format(
                            'DD-MM-YYYY'));
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });

            // Check checkbox classification2
            $(".checkbox").on('change', function() {
                validateCheckboxClassification2();
            })

            function validateCheckboxClassification2() {
                var atLeastOneChecked = $('.checkbox input[type="checkbox"]:checked').length > 0;

                if (!atLeastOneChecked) {
                    event.preventDefault();
                    event.stopPropagation();
                    $('.checkbox .form-check-input').prop("required", true);
                } else {
                    $('.checkbox .form-check-input').prop("required", false);
                }
            }

            // Classification 2
            $('.checkbox-check').change(function() {
                if ($(this).is(":checked")) {
                    // Menonaktifkan semua checkbox dengan class 'checkbox-check' kecuali yang sedang dipilih
                    $('.checkbox-check').not(this).prop('disabled', true);
                } else {
                    // Mengaktifkan kembali semua checkbox dengan class 'checkbox-check'
                    $('.checkbox-check').prop('disabled', false);
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

        });
    </script>
@endsection
