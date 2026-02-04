@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Purchase Request')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css')}}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css')}}">
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
                                        <input type="text" class="form-control add" placeholder="Yang Meminta" id="requester" name="requester" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Departemen </label>
                                        <select class="form-control w-px-200 select2 " id="department_id" name="department_id" required>
                                        </select>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Jumlah Anggaran </label>
                                        <input type="text" class="form-control" id="total_budget" name="total_budget" placeholder="Jumlah Anggaran" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Usulan Permintaan </label>
                                        <input type="text" class="form-control" id="proposed_purchase_price" name="proposed_purchase_price" placeholder="Usulan Permintaan" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Sisa Anggaran </label>
                                        <input type="text" class="form-control" id="remaining_budget" name="remaining_budget" placeholder="Sisa Anggaran" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Kanan --}}
                            <div class="d-flex flex-wrap justify-content-between col-md-7 py-3 px-3">
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Nomor PR </label>
                                        <input type="text" class="form-control" placeholder="Nomor PR" id="purchase_request_number" name="purchase_request_number" disabled />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Tanggal PR </label>
                                        <input type="text" class="form-control add date" id="request_date" name="request_date" placeholder="Tanggal PR" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="nomor_mr" class="form-label fw-medium">Nomor MR </label>
                                        <select class="form-control w-px-200 select2 " id="material_request_id" name="material_request_id" required>
                                        </select>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="mb-1">
                                        <textarea class="form-control add" rows="7" style="padding: 15px" id="additional_note" name="additional_note" placeholder="Catatan Tambahan" required></textarea>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Radio Button --}}
                        <div class="row py-3 px-3">
                            <div class="col-12">
                                <div class="">
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="Sesuai Budget" id="sesuai-budget" required>
                                        <label class="form-check-label" for="sesuai_budget">Sesuai Budget</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="Diluar Budget" id="diluar-budget" required>
                                        <label class="form-check-label" for="diluar_budget">Diluar Budget</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="penting" id="penting" required>
                                        <label class="form-check-label" for="penting">Penting</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="1 Minggu" id="1-minggu" required>
                                        <label class="form-check-label" for="1_minggu">1 Minggu</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" name="1 Bulan" id="1-bulan" required>
                                        <label class="form-check-label" for="1_bulan">1 Bulan</label>
                                    </div>
                                </div>
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

                                {{-- Tanda tangan --}}
                                <div class="row  text-center mb-5 ttd">
                                    <div class="col-4 signatures">
                                        <label for="note" class="form-label fw-medium">Diproses Oleh :</label>
                                        <input type="text" value="Checked By" id="type1" name="type" class="form-control d-none">
                                        <div class="mb-3">
                                            <input type="text" id="warehouse_name" class="form-control" placeholder="Nama" style="text-align:center;" id="name1" name="name" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control  " placeholder="Jabatan" style="text-align:center;" id="jabatan1" name="jabatan1" value="Admin" disabled/>
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-center align-items-center">
                                            <div action="/upload" class="dropzone needsclick dz-clickable dd" id="dropzone-1">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" id="warehouse_date" class="form-control date" placeholder="Tanggal" style="text-align:center;" id="date1" name="date" />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-4 signatures">
                                        <label for="note" class="form-label fw-medium">Diperiksa Oleh :</label>
                                        <input type="text" value="Checked By" id="type2" name="type" class="form-control d-none" disabled>
                                        <div class="mb-3">
                                            <input type="text" class="form-control  " placeholder="Nama" style="text-align:center;" id="name2" name="name" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control  " placeholder="Jabatan" style="text-align:center;" id="jabatan2" name="name" value="Kepala Unit" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick disabled dd" id="dropzone-4">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control  date" placeholder="Tanggal" style="text-align:center;" id="date2" name="date" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                    <div class="col-4 signatures">
                                        <label for="note" class="form-label fw-medium">Diketahui Oleh :</label>
                                        <input type="text" value="Known By" id="type3" name="type" class="form-control d-none">
                                        <div class="mb-3">
                                            <input type="text" class="form-control  " placeholder="Nama" style="text-align:center;" id="name3" name="name" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control  " placeholder="Jabatan" style="text-align:center;" id="jabatan3" name="name" value="Kepala BM" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                        <div class="mb-3">
                                            <div action="/upload" class="dropzone needsclick disabled dd" id="dropzone-4">
                                                <div class="dz-message needsclick">
                                                    <span class="note needsclick">Unggah Tanda Tangan</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" class="form-control  date" placeholder="Tanggal" style="text-align:center;" id="date3" name="date" disabled />
                                            <div class="invalid-feedback">Tidak boleh kosong</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ttd">
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
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Simpan</button>
                        <!-- <button class="btn btn-label-secondary d-grid w-100 mb-2 btn-preview">Preview</button> -->
                        <button type="button" class="btn btn-label-secondary btn-cancel d-grid w-100">Kembali</button>
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
<script src="{{ asset('assets/vendor/libs/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script src="{{ asset('assets/js/forms-file-upload.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jquery-repeater/jquery-repeater.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js')}}">
</script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js')}}">
</script>
<script>
    let account = {!! json_encode(session('data')) !!}
    let dataLocal = JSON.parse(localStorage.getItem("purchase-request"));
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    var lastIndex = null;

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
        // Date
        $('#warehouse_name').val(account.name);
        getDetails();
        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });

        $("#material_request_id").select2({
            placeholder: 'Select Material Request',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/material-request/select?status=Disetujui Kepala BM',
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

        $('#material_request_id').on("change", (async function(e) {
            var rekomendasi = $("#material_request_id").select2('data');
            var data = rekomendasi[0].id;
            console.log(data);
            $('#material_request_id').val(data);

        }));

        $(document).on('keydown', '#total_budget', function(event) {
            var key = event.which;
            if ((key < 48 || key > 57) && key != 8) event.preventDefault();
        });

        $(document).on('input', '#total_budget', function(event) {
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
            let total = parseInt($(this).val().replaceAll(',', ''));

            let proposed_purchase_price = isNaN(parseInt($(`#proposed_purchase_price`).val().replaceAll(',', ''))) ? 0 : parseInt($(`#proposed_purchase_price`).val().replaceAll(',', ''));

            let remaining_budget = total - proposed_purchase_price;

            $('#remaining_budget').val(format(isNaN(remaining_budget) ? 0 : remaining_budget));

        });

        $(document).on('input', '#proposed_purchase_price', function(event) {
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
            let proposed_purchase_price = parseInt($(this).val().replaceAll(',', ''));
            let total = isNaN(parseInt($(`#total_budget`).val().replaceAll(',', ''))) ? 0 : parseInt($(`#total_budget`).val().replaceAll(',', ''));

            let remaining_budget = total - proposed_purchase_price;

            $('#remaining_budget').val(format(isNaN(remaining_budget) ? 0 : remaining_budget));

        });

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
                                            <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="text" class="date form-control row-input" placeholder="Tanggal" name="last_buy_date[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;" />
                                        </td>
                                        <td>
                                            <a role="button" class="btn btn-danger text-center btn-remove-mg text-white ms-4" disabled>
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
            `;
            $details.append($newRow);
            $('.date').flatpickr({
                dateFormat: 'd-m-Y'
            });
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
                                                    <th colspan="3">Pembelian Terakhir</th>
                                                    <th>Keterangan</th>
                                                    <th>Kuantitas</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control row-input" placeholder="Tanggal" name="last_buy_date[]" required style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" required style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" required style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white ms-4" disabled>
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
                                    <th colspan="3" class="text-center">Pembelian Terakhir</th>
                                    <th>Keterangan</th>
                                    <th>Kuantitas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 200px;" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 200px;" />
                                    </td>
                                    <td>
                                        <input type="text" class="date form-control row-input" placeholder="Tanggal" name="last_buy_date[]" required style="width: 200px;" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" required style="width: 200px;" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" required style="width: 200px;" />
                                    </td>
                                    <td>
                                        <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 200px;" />
                                    </td>
                                    <td>
                                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white ms-4" disabled>
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                `;
                $('#details').prepend(temp);
            }
        };

        // Save, Insert and Create
        var savepr = $('#create-pr');

        Array.prototype.slice.call(savepr).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        event.preventDefault();
                        Swal.fire({
                            title: '<h2>Loading...</h2>',
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });

                        
                        let department_id = $("#department_id").val();
                        let proposed_purchase_price = parseInt($("#proposed_purchase_price").val().replaceAll(',', ''));
                        let budget_status = $('.checkbox-check:checked').attr('id');;
                        let request_date = moment($("#request_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let requester = $("#requester").val();
                        let total_budget = $("#total_budget").val().replaceAll(',', '');
                        let remaining_budget = parseInt($("#remaining_budget").val().replaceAll(',', ''));
                        let material_request_id = parseInt($("#material_request_id").val());
                        let additional_note = $("#additional_note").val();

                        let datas = {};
                        let signatures1 = {}
                        signatures1.type = "Prepared By";
                        signatures1.name = $('#warehouse_name').val();
                        signatures1.date = moment($('#warehouse_date').val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        signatures1.signature = ttdFile1.dataURL;

                        var detail = [];
                        $('.row-input').each(function(index) {
                            var input_name = $(this).attr('name');
                            var input_value = $(this).val();
                            var input_index = Math.floor(index / 7); // Membagi setiap 5 input menjadi satu objek pada array
                            if (index % 7 == 0) {
                                detail[input_index] = {
                                    number: input_value
                                };
                            } else if (index % 7 == 1) {
                                detail[input_index].part_number = input_value;
                            } else if (index % 7 == 2) {
                                detail[input_index].last_buy_date = input_value;
                            } else if (index % 7 == 3) {
                                detail[input_index].last_buy_quantity = parseInt(input_value);
                            } else if (index % 7 == 4) {
                                detail[input_index].last_buy_stock = parseInt(input_value);
                            } else if (index % 7 == 5) {
                                detail[input_index].description = input_value;
                            } else if (index % 7 == 6) {
                                detail[input_index].quantity = parseInt(input_value);
                            }
                        });


                        datas.details = detail;
                        datas.department_id = department_id;
                        datas.proposed_purchase_price = proposed_purchase_price;
                        datas.budget_status = budget_status;
                        datas.request_date = request_date;
                        datas.requester = requester;
                        datas.total_budget = total_budget;
                        datas.remaining_budget = remaining_budget;
                        datas.material_request_id = material_request_id;
                        datas.additional_note = additional_note;
                        datas.status = 'Terbuat';
                        datas.signatures = [signatures1];
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" + "/api/purchase-request",
                            type: "POST",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",

                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan Purchase Request',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    window.location.href = "/request/list-purchase-request"
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

        // Mengambil value tanda tangan
        let ttdFile1 = null;
        const myDropzone1 = new Dropzone('#dropzone-1', {
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
                    ttdFile1 = file;
                });
            }
        });

        $("#department_id").select2({
            placeholder: 'Select Department',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/department/select',
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

        $(".select-mr").select2({
            placeholder: 'Select Material Request',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/material-request/select',
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
                url: "{{ env('BASE_URL_API')}}" + '/api/material-request/' + id,
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

        // Cancel
        $(document).on('click', '.btn-cancel', function(event) {
            event.preventDefault();
            localStorage.removeItem('purchase-request');
            window.location.href = "/request/list-purchase-request"
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