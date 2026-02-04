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
                                        <input type="text" class="form-control" id="invoice_number" placeholder="" disabled />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="invoice_date" class="form-label fw-medium">Tgl. Invoice</label>
                                        <input type="text" class="form-control date" name="invoice_date" id="invoice_date" placeholder="" required />
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

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="">Sub Total:</p>
                                            </td>
                                            <td colspan="2" style="text-align: right">
                                                <p id="sub_total"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="">Total Diskon</p>
                                            </td>
                                            <td colspan="2" style="text-align: right">
                                                <p id="total_diskon"></p>
                                            </td>
                                        </tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="">Total Pajak</p>
                                            </td>
                                            <td colspan="2" style="text-align: right">
                                                <p id="total_tax"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                <p class="">Total:</p>
                                            </td>
                                            <td colspan="2" style="text-align: right">
                                                <p id="grand_total"></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">Terbilang</td>
                                        </tr>
                                        <tr>
                                            <td colspan="7" id="grand_total_spelled"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="7">
                                                <span>Jatuh Tempo Tanggal : </span> <span id="invoice_due_date"></span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="row m-sm-2 m-0 ">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3">
                                    <label for="note" class="form-label me-2">Syarat & Ketentuan</label>
                                    <br>
                                    <div class="form-label" id="term_and_conditions">
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label for="note" class="form-label me-2">Note</label>
                                    <br>
                                    <div class="form-label" id="note">
                                    </div>

                                </div>
                                <!-- <div class="mb-3">
                                    <label for="note" class="form-label me-2">Transfer Bank :</label>
                                    <select name="bank" id="bank" name="bank" class="form-select w-px-250 item-details mb-3" hidden>
                                    </select>
                                    <br>
                                    <div class="form-label">
                                        <span class="fw-bold">PPPGSI</span><br>
                                        <span class="fw-bold" id="bank-name"></span><br>
                                    </div>
                                </div> -->
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Tanda Tangan & Meterai
                                        (Opsional)</label>
                                    <p class="form-label" id="materai_date"></p>
                                </div>
                                <div class="mb-3">
                                    <div id="materai-image"></div>
                                </div>
                                <div class="mb-3">
                                    <p class="form-label" id="materai_name"></p>
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
                        <a href="/invoice/add-invoice" id="preview" class="btn btn-label-secondary d-grid w-100 mb-2">Kembali</a>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;


    let data = JSON.parse(localStorage.getItem("invoice"));
    $(document).ready(function() {
        console.log(data);
        $("#invoice_number").val(data.invoice_number);
        $("#invoice_date").val(data.invoice_date);
        $("#contract_number").val(data.contract_number);
        $("#contract_date").val(data.contract_date);
        $("#addendum_number").val(data.addendum_number);
        $("#addendum_date").val(data.addendum_date);
        $("#grand_total_spelled").text(data.grand_total_spelled);
        $("#grand_total").text('Rp.' + data.grand_total.toLocaleString());
        $("#sub_total").text('Rp.' + data.sub_total.toLocaleString());
        $("#total_diskon").text('Rp.' + data.total_diskon.toLocaleString());
        $("#total_tax").text('Rp.' + data.total_tax.toLocaleString());
        $("#invoice_due_date").text(data.invoice_due_date);
        $("#term_and_conditions").html(data.term_and_conditions);
        $("#note").html(data.notes);
        $("#materai_date").text(data.materai_date ? moment(data.materai_date).format('D MMMM YYYY') : data.materai_date);
        $("#materai_name").text(data.materai_name);

        if (data.tenant_id) {
            getTenant();
        }
        if (data.bank_id) {
            getBank();
        }
        getDetails();

        if (data.materai_image) {
            $("#materai-image").css('background-img', 'black');
            $("#materai-image").css("background-image", `url('` + data.materai_image.dataURL + `')`);
            $("#materai-image").css("height", `200px`);
            $("#materai-image").css("width", `200px`);
            $("#materai-image").css("background-position", `center`);
            $("#materai-image").css("background-size", `cover`);
            $("#materai-image").css("background-repeat", `no-repeat`);
        }
    });

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

    function getTenant() {
        let idTenant = data.tenant_id;
        $.ajax({
            url: "{{url('api/tenant')}}/" + idTenant,
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

    function getBank() {
        let idBank = data.bank_id;
        $.ajax({
            url: "{{url('api/bank')}}/" + idBank,
            type: "GET",
            success: function(response) {
                let data = response.data;
                $("#bank-name").text(data.name)
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }



    function getDetails() {
        let details = data.details;
        let getDetail = '';
        let tem = '';
        let tax = '';

        for (let i = 0; i < details.length; i++) {
            $.ajax({
                // url: "{{ env('BASE_URL_API')}}" + '/api/tax/' + id,
                url: "{{url('api/tax/get-paper')}}/" + details[i].tax_id,
                type: "get",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    tax = response.data.name;
                    tem = `<tr>
                        <td class="text-nowrap">` + details[i].item + `</td>
                        <td class="text-nowrap">` + details[i].description + `</td>
                        <td class="text-nowrap">` + details[i].quantity + `</td>
                        <td>` + format(details[i].price) + `</td>
                        <td>` + details[i].discount + `</td>
                        <td>` + tax + `</td>
                        <td style="text-align: right">Rp. ` + format(details[i].total_price) + `</td>
                    </tr>`;
                    getDetail = getDetail + tem;
                    $('#details').append(tem);
                },
                error: function(errors) {
                    console.log(errors);
                }
            });

        }
    }


    $(document).on('click', '#batal', function(event) {
        event.preventDefault();
        localStorage.removeItem('invoice');
        window.location.href = "/invoice/list-invoice"
    });

    $(document).on('click', '#save', function(event) {
        event.preventDefault();
        const newData = {
            ...data,
            materai_image: data.materai_image.dataURL
        }
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/invoice',
            type: "POST",
            data: JSON.stringify(newData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            success: function(response) {
                $('.indicator-progress').show();
                $('.indicator-label').hide();

                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil menambahkan Invoice',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });

                localStorage.removeItem('invoice');
                window.location.href = "/invoice/list-invoice"

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