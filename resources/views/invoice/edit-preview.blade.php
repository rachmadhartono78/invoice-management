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
<style type="text/css">
    .select2-container {
        width: 200px !important;
    }
</style>
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
                                    <!-- <div class="col-md-6 mb-3">
                                        <label for="term" class="form-label fw-medium">Terms</label>
                                        <select name="term" id="term" class="form-control" required>
                                            <option value=""></option>
                                            <option value="Net 7 Days">Net 7 Days</option>
                                            <option value="Net 14 Days">Net 14 Days</option>
                                            <option value="Net 30 Days">Net 30 Days</option>
                                            <option value="Net 45 Days">Net 45 Days</option>
                                            <option value="Net 60 Days">Net 60 Days</option>
                                        </select>
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contract_date" class="form-label fw-medium">Salesperson</label>
                                        <input type="text" class="form-control" name="contract_date" id="contract_date" placeholder="" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div> -->
                                    <!-- <div class="col-md-6 mb-3">
                                        <label for="addendum_number" class="form-label fw-medium">No. Addendum</label>
                                        <input type="text" class="form-control" name="addendum_number" id="addendum_number" placeholder="" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="addendum_date" class="form-label fw-medium">Tanggal</label>
                                        <input type="text" class="form-control date" id="addendum_date" name="addendum_date" placeholder="" required />
                                        <div class="invalid-feedback">Tidak boleh kosong</div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

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
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="details">
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3">
                                    <label for="note" class="form-label me-2">Catatan</label>
                                    <br>
                                    <div class="form-label" id="note">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Syarat dan ketentuan</label>
                                    <br>
                                    <div class="form-label" id="term_and_conditions">
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
                        <button type="button" id="back" class="btn btn-label-secondary d-grid w-100 mb-2">Kembali</button>
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
    var urlSegments = window.location.pathname.split('/');
    var idIndex = urlSegments.indexOf('preview-invoice-edit') + 1;
    var id = urlSegments[idIndex];
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;

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


    let data = JSON.parse(localStorage.getItem("edit-invoice"));
    $(document).ready(function() {
        $("#invoice_number").val(data.invoice_number);
        $("#invoice_date").val(data.invoice_date);
        $("#contract_number").val(data.contract_number);
        $("#contract_date").val(data.contract_date);
        $("#addendum_number").val(data.addendum_number);
        $("#addendum_date").val(data.addendum_date);
        $("#grand_total_spelled").text(data.grand_total_spelled);
        $("#grand_total").text('Rp. ' + format(data.grand_total));
        $("#invoice_due_date").text(data.invoice_due_date);
        $("#term_and_conditions").html(data.term_and_condition);
        $("#note").html(data.notes);
        $("#materai_date").text(data.materai_date);
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

    function getDetails(detailItems) {
        let details = data.details;
        let getDetail = '';
        let temp = '';

        if (details) {
            console.log(details);
            for (let i = 0; i < details.length; i++) {
                temp = `             
                <tr class="row-mg">
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input" placeholder="Nama Produk" name="item[]" value="${details[i].item}" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <textarea name="description[]" class="form-control row-input" rows="1" placeholder="Deskripsi Produk" style="width: 200px;">${details[i].description}</textarea>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input quantity" placeholder="Kuantitas" name="quantity[]"  value="${details[i].quantity}" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input price" placeholder="Harga" name="price[]" value="${format(details[i].price)}" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input discount" placeholder="" name="discount[]" style="width: 100px;"  value="${details[i].discount}"/>
                        <input type="hidden" class="form-control total_subdiskon" placeholder="" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <select name="tax[]" id="tax-${i}" class="form-select row-input tax"></select>
                        <input type="hidden" class="form-control total_pajak" placeholder="" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input total_price" placeholder="" name="total_price[]" disabled style="width : 200px" value="${details[i].total_price}"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white" disabled>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                `;
                $.ajax({
                    url: "{{url('api/tax/get-paper')}}/" + details[i].tax_id,
                    type: "GET",
                    success: function(response) {
                        let data = response.data;
                        let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                        $('#tax-' + i).prepend(tem);
                        data = response.data.value;
                        let exlusice = response.data.exclusive;
                        console.log(response.data);
                        let totalPajak = 0;
                        let totalDiskon = 0;
                        let price = parseInt($(`.price:eq(` + i + `)`).val().replaceAll(',', ''));
                        let quantity = parseInt($(`.quantity:eq(` + i + `)`).val());
                        let tax = parseInt(data);
                        let discount = parseInt($(`.discount:eq(` + i + `)`).val());
                        tax = tax / 100;
                        let totalPrice = price * tax + price;
                        totalPajak = (price * quantity) * tax;
                        let disVal = discount / 100;
                        let disTotal = (price * quantity) * disVal;
                        $(`.total_subdiskon:eq(` + i + `)`).val(isNaN(price) ? 0 : format(disTotal));
                        // console.log(format(totalPrice));
                        if (exlusice == 0) {
                            $(`.total_pajak:eq(` + i + `)`).val(0);
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        } else {
                            $(`.total_pajak:eq(` + i + `)`).val(isNaN(totalPajak) ? 0 : format(totalPajak));
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
                getDetail = getDetail + temp;
            }
            $('#details').prepend(getDetail);
            for (let i = 0; i < details.length; i++) {
                $("#tax-" + i).select2({
                    width: '100px',
                    placeholder: 'Pilih Pajak',
                    allowClear: true,
                    ajax: {
                        url: "{{url('api/tax/select-paper')}}",
                        // url: "{{ env('BASE_URL_API')}}" + '/api/tax/select',
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
            }
        }
    }


    $(document).on('click', '#back', function(event) {
        event.preventDefault();
        window.location.href = "/invoice/edit/" + id
    });

    $(document).on('click', '#save', function(event) {
        event.preventDefault();
        const newData = {
            ...data,
            materai_image: data.materai_image.dataURL
        }
        $.ajax({
            url: baseUrl + "api/invoice/" + id,
            type: "PATCH",
            data: JSON.stringify(newData),
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            success: function(response) {
                $('.indicator-progress').show();
                $('.indicator-label').hide();

                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil Update Invoice',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });

                localStorage.removeItem('edit-invoice');
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