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
                                        <input type="text" class="form-control add" placeholder="Yang Meminta" id="requester" name="requester" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Departemen </label>
                                        <input type="text" class="form-control" placeholder="Departement" name="department_id" id="department_id" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Jumlah Anggaran </label>
                                        <input type="text" class="form-control" id="total_budget" name="total_budget" placeholder="Jumlah Anggaran" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Usulan Permintaan </label>
                                        <input type="text" class="form-control" id="proposed_purchase_price" name="proposed_purchase_price" placeholder="Usulan Permintaan" readonly />
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
                                        <input type="text" class="form-control add date" id="request_date" name="request_date" placeholder="Tanggal PR" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="nomor_mr" class="form-label fw-medium">Nomor MR </label>
                                        <input type="text" class="form-control" id="material_request_id" name="material_request_id" placeholder="TNomor Material Request" readonly />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-5 mb-0">
                                    <div class="mb-1">
                                        <label for="note" class="form-label fw-medium">Tanggal MR</label>
                                        <input type="text" class="form-control" id="tanggal_mr" name="tanggal_mr" placeholder="Tanggal MR" disabled />
                                        <div class="invalid-feedback" style="display: none">Tidak boleh kosong</div>
                                    </div>
                                </div> -->
                                <div class="col-md-12 mt-2">
                                    <div class="mb-1">
                                        <textarea class="form-control add" rows="7" style="padding: 15px" id="additional_note" name="additional_note" placeholder="Termin pembayaran, garansi dll" readonly></textarea>
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
                                        <input class="form-check-input checkbox-check" type="checkbox" onclick="return false;" name="Sesuai Budget" id="sesuai budget" readonly>
                                        <label class="form-check-label" for="sesuai_budget">Sesuai Budget</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" onclick="return false;" name="Diluar Budget" id="diluar budget" readonly>
                                        <label class="form-check-label" for="diluar_budget">Diluar Budget</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" onclick="return false;" name="penting" id="penting" readonly>
                                        <label class="form-check-label" for="penting">Penting</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" onclick="return false;" name="1 Minggu" id="1 minggu" readonly>
                                        <label class="form-check-label" for="1_minggu">1 Minggu</label>
                                    </div>
                                    <div class="form-check form-check-inline checkbox budget_status">
                                        <input class="form-check-input checkbox-check" type="checkbox" onclick="return false;" name="1 Bulan" id="1 bulan" readonly>
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
                                </div>
                                <div class="row mb-3 mt-5    text-center signatures">
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
                        <button type="button" id="edit" class="btn btn-primary d-grid w-100 mb-2">Edit</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
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

    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('show') + 1;
    id = urlSegments[idIndex];

    $(document).ready(function() {

        getDataPurchaseRequest(id);
        $('.date').flatpickr({
            dateFormat: 'Y-m-d'
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
                                                        <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="date" class="form-control row-input" placeholder="Tanggal" name="last_buy_date[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" readonly style="width: 200px;" />
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
                                                        <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="date form-control row-input" placeholder="Tanggal" name="last_buy_date[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" readonly style="width: 200px;" />
                                                    </td>
                                                    <td>
                                                        <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;"></textarea>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" readonly style="width: 200px;" />
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

        // Cancel
        $(document).on('click', '.btn-cancel', function(event) {
            event.preventDefault();
            localStorage.removeItem('purchase-request');
            window.location.href = "/request/list-purchase-request"
        });
    });

    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        window.location.href = "/request/list-purchase-request"
    });

    $(document).on('click', '#edit', function(event) {
        event.preventDefault();
        window.location.href = "/request/edit/"+id;
    });

    function getDataPurchaseRequest(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{env('BASE_URL_API')}}" + '/api/purchase-request/' + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                var data = res.data;
                $("#additional_note").val(data.additional_note);
                $("#budget_status").val(data.budget_status);
                $("#department_id").val(data.department_id);
                $("#material_request_id").val(data.material_request_id);
                $("#proposed_purchase_price").val(format(data.proposed_purchase_price));
                $("#purchase_request_number").val(data.purchase_request_number);
                $("#remaining_budget").val(format(data.remaining_budget));
                $("#request_date").val(data.request_date);
                $("#requester").val(data.requester);
                $("#material_request_id").val(data.material_request.material_request_number);
                $("#total_budget").val(format(data.total_budget));
                $('#'+data.budget_status.toLowerCase()).prop('checked', true);
                getDetails(data.purchase_request_details);
                getSignatures(data.purchase_request_signatures);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });

        function getDetails(details) {
            let tem = '';
            for (let i = 0; i < details.length; i++) {
                tem += `
                <tr>
                    <td>
                        <input type="text" class="form-control row-input" placeholder="Nomor" name="number[]"  value="` + details[i].number + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="text" class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" value="` + details[i].part_number + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="text" class="date form-control row-input" placeholder="Tanggal" name="last_buy_date[]" value="` + details[i].last_buy_date + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="last_buy_quantity[]" value="` + details[i].last_buy_quantity + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <input type="number" class="form-control row-input" placeholder="Persediaan" name="last_buy_stock[]" value="` + details[i].last_buy_stock + `" readonly style="width: 200px;" />
                    </td>
                    <td>
                        <textarea class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 200px;">` + details[i].description + `</textarea>
                    </td>
                    <td>
                        <input type="number" class="form-control row-input" placeholder="Kuantitas" name="quantity[]" value="` + details[i].quantity + `" readonly style="width: 200px;" />
                    </td>
                 </tr>`;
            }
            let getDetail = `
                <table class="table">
                        <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Part Number</th>
                                        <th colspan="3" class="text-center">Pembelian Terakhir</th>
                                        <th>Keterangan</th>
                                        <th>Kuantitas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tem}
                                </tbody>
                            </table>`;
            $('#details').prepend(getDetail);
        }

        function getSignatures(details) {
            console.log(details);
            let append = '';
            let appendPrepared = '';
            let appendChecked = '';
            let appendKnown = '';
            let appendApproved = '';
            for (let i = 0; i < details.length; i++) {
                if (details[i].type == 'Prepared By') {
                    appendPrepared = `
                    <div class="col-md-4 text-center">
                        <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName"  placeholder="Nama" style="text-align:center;" id="warehouse_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="warehouse_jabatan" name="jabatan[]" readonly value="Admin">
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="warehouse-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="warehouse_date" name="date[]" value="${moment(details[i].date, "YYYY-MM-DD").format("D MMMM YYYY")}" readonly>
                        </div>
                    </div>`;
                } else if (details[i].type == 'Checked By') {
                    appendChecked = `
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium mb-3">Diperiksa Oleh :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="departement_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="departement_jabatan" name="jabatan[]" readonly value="Kepala Unit">
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="unit-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="departement_date" name="date[]" value="${details[i].date}" readonly>
                        </div>
                    </div>`;
                } else if (details[i].type == 'Known By') {
                    appendKnown = `
                    <div class="col-md-4">
                        <label for="note" class="form-label fw-medium mb-3">Diketahui Oleh :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="departement_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="departement_jabatan" name="jabatan[]" readonly value="Kepala BM">
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="departement-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="departement_date" name="date[]" value="${details[i].date}" readonly>
                        </div>
                    </div>`;
                } else if (details[i].type == 'Approved By') {
                    appendApproved = `
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="approved_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="approved_jabatan" name="jabatan[]" readonly value="Kepala BM">
                        </div>
                        <div class="mb-3 d-flex justify-content-center align-items-center">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:20rem"> <img id="approved-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="approved_date" name="date[]" value="${details[i].date}" readonly>
                        </div>
                    </div>`;
                }
                $('.signatures').html(appendPrepared + appendChecked + appendKnown + appendApproved);
            }

        }
    }
</script>
@endsection