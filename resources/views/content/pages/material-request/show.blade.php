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

                        <div class="row py-3 px-3">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Requester</label>
                                    <input type="text" readonly class="form-control" placeholder="Requester" name="requester" id="requester" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Departement </label>
                                    <input type="text" readonly class="form-control" placeholder="Departement" name="department" id="department" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Stock </label>
                                    <input type="number" readonly class="form-control" placeholder="Stock" id="stock" name="stock" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Purchase </label>
                                    <input type="text" readonly class="form-control" placeholder="Purchase" name="purchase" id="purchase" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Tanggal</label>
                                    <input type="text" readonly class="form-control date" placeholder="Tanggal" name="request_date" id="request_date" required />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <textarea readonly class="form-control" rows="6" id="note" name="note" placeholder="Catatan" required></textarea>
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
                                </div>

                                <div class="row mb-3 mt-3 signatures">

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
                        <button type="button" id="edit" class="btn btn-primary d-grid w-100 mb-2">Edit</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
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

    let data = JSON.parse(localStorage.getItem("material-request"));
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('show') + 1;
    id = urlSegments[idIndex];

    getDataMaterialRequest(id);

    function getDataMaterialRequest(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{env('BASE_URL_API')}}" +'/api/material-request/' + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                let data = res.data;
                $("#requester").val(data.requester);
                $("#department").val(data.department);
                $("#request_date").val(data.request_date);
                $("#stock").val(data.stock);
                $("#purchase").val(data.purchase);
                $("#note").val(data.note);
                getDetails(data.material_request_details);
                getSignatures(data.material_request_signatures);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    function getDetails(details) {
        let tem = '';
        for (let i = 0; i < details.length; i++) {
            tem += `
                <tr>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Nomor" name="number[]" required style="width: 150px;" value="` + details[i].number + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="No. Suku Cadang" name="part_number[]" required style="width: 150px;" value="` + details[i].part_number + `"/>
                    </td>
                    <td>
                        <textarea readonly class="form-control row-input" placeholder="Deskripsi" name="description[]" style="width: 150px;">`+ details[i].description +`</textarea>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Kuantitas" name="quantity[]" required style="width: 150px;" value="` + details[i].quantity + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Stock" name="stock[]" required style="width: 150px;" value="` + details[i].stock + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Stock Out" name="stock_out[]" required style="width: 150px;" value="` + details[i].stock_out + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="End Stock" name="end_stock[]" required style="width: 150px;" value="` + details[i].end_stock + `"/>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control row-input" placeholder="Min Stock" name="min_stock" [] required style="width: 150px;" value="` + details[i].min_stock + `"/>
                    </td>
                </tr>
            `;
        }
        let getDetail = `
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
                ${tem}
            </tbody>
        </table>
        `;
        $('#details').prepend(getDetail);
    }

    function getSignatures(details){
        let append = '';
        let appendPrepared = '';
        let appendReviewed = '';
        let appendAknowledge = '';
        let appendApproved = '';
        for (let i = 0; i < details.length; i++) {
            if(details[i].type == 'Prepared By'){
                appendPrepared = `
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="warehouse_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="warehouse_jabatan" name="jabatan[]" readonly value="Warehouse">
                        </div>
                        <div class="mb-3 prev-3 d-flex align-items-center justify-content">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="warehouse-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="warehouse_date" name="date[]" value="${details[i].date}" readonly>
                        </div>
                    </div>`;
            }else if(details[i].type == 'Reviewed By'){
                appendReviewed = `
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="departement_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="departement_jabatan" name="jabatan[]" readonly value="Chief Department">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="chief-departement-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="departement_date" name="date[]" value="${details[i].date}" readonly>
                        </div>
                    </div>`;
            }else if(details[i].type == 'Aknowledge By'){
                appendAknowledge = `
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="finance_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="finance_jabatan" name="jabatan[]" readonly value="Chief Finance & Akunting">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="finance-image" alt="" src="${details[i].signature}">
                                        <span class="dz-nopreview">No preview</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control date ttd-row" placeholder="Tanggal" style="text-align:center;" id="finance_date" name="date[]" value="${details[i].date}" readonly>
                        </div>
                    </div>`;
            }else if(details[i].type == 'Approved By'){
                appendApproved = `
                    <div class="col-md-3">
                        <label for="note" class="form-label fw-medium mb-3">Prepared by :</label>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row userName" placeholder="Nama" style="text-align:center;" id="approved_name" name="name[]" readonly value="${details[i].name}">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control ttd-row department" placeholder="Jabatan" style="text-align:center;" id="approved_jabatan" name="jabatan[]" readonly value="Kepala BM">
                        </div>
                        <div class="mb-3 prev-3">
                            <div>
                                <div class="dz-details">
                                    <div class="dz-thumbnail" style="max-width:10rem"> <img id="kepala-bm-image" alt="" src="${details[i].signature}">
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
            $('.signatures').html(appendPrepared+appendReviewed+appendAknowledge+appendApproved);
        }

    }


    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        localStorage.removeItem('material-request');
        window.location.href = "/request/material-request"
    });

    $(document).on('click', '#edit', function(event) {
        event.preventDefault();
        localStorage.removeItem('material-request');
        window.location.href = "/request/material-request/edit/"+id;
    });

    $(document).on('click', '#save', function(event) {
        event.preventDefault();
        $.ajax({
            url: baseUrl + "api/material-request/",
            type: "POST",
            data: JSON.stringify(data),
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
                });

                // localStorage.removeItem('invoice');
                // window.location.href = "/invoice/list-invoice"

            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Semua field harus diisi',
                    icon: 'error',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                })
            }
        });
        // window.location.href = "/invoice/list-invoice"
    });
</script>
@endsection