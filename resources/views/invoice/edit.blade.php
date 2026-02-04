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
                        <div style="background-image: url('{{ asset('assets/img/header.png') }}'); height : 150px; background-ze: contain; background-repeat: no-repeat;" class="set-back">
                        </div>

                        <div class="row  px-3">
                            <div class="col-md-6">
                                <label for="select2Primary" class="form-label">Kepada Yth, </label>
                                <br>
                                <div class="col-md-8 mb-3">
                                    <select name="tenant" id="tenant" name="tenant" class="mb-3" required>
                                    </select>
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

                        {{-- Repeater --}}
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

                            <div class="row pb-4">
                                <div class="col-md-3 px-3">
                                    <button type="button" class="btn btn-primary waves-effect waves-light w-px-150 btn-add-row-mg">Tambah
                                        Baris</button>
                                </div>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="px-5">
                            <hr class="my-3 mx-n5">
                        </div>

                        {{-- Total --}}
                        <div class="row d-flex px-3 mb-2">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Subtotal</p>
                                    </div>
                                    <div>
                                        <p class="sub_total">0</p>
                                    </div>
                                </div>
                                <div>
                                    <hr class="m-0 mx-n7">
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex px-3 mb-2">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Total Diskon</p>
                                    </div>
                                    <div>
                                        <p class="total_diskon">0</p>
                                    </div>
                                </div>
                                <div>
                                    <hr class="m-0 mx-n7">
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex px-3 mb-2">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Pajak</p>
                                    </div>
                                    <div>
                                        <p class="total_tax">0</p>
                                    </div>
                                </div>
                                <div>
                                    <hr class="m-0 mx-n7">
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex px-3 mb-2">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p>Total</p>
                                    </div>
                                    <div>
                                        <p class="grand_total">0</p>
                                    </div>
                                </div>
                                <div>
                                    <hr class="m-0 mx-n7">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-5">
                            <div class="col-md-12 mb-2">
                                <label for="note" class="form-label fw-medium">Terbilang</label>
                                <input type="text" class="form-control w-full terbilang" id="grand_total_spelled" name="grand_total_spelled" placeholder="Terbilang" disabled />
                            </div>
                            <div class="col-md-8 d-flex align-items-center">
                                <label for="note" class="form-label fw-medium me-2">Jatuh Tempo Tanggal :</label>
                                <input type="text" class="form-control w-px-250 date" placeholder="Jatuh Tanggal Tempo" id="invoice_due_date" name="invoice_due_date" required />
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium me-2">Catatan</label>
                                    <textarea class="form-control" rows="11" id="notes" name="notes"></textarea>
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-md-0 mb-3">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium me-2">Syarat & Ketentuan</label>
                                    <textarea class="form-control" rows="11" id="term_and_conditions" name="term_and_conditions"></textarea>
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
                        <button class="btn btn-primary d-grid w-100 mb-2 kirim-invoice d-none" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                            <span class="d-flex align-items-center justify-content-center text-nowrap d-none"><i class="ti ti-send ti-xs me-2"></i>Kirim Invoice</span>
                        </button>
                        <button type="submit" id="save" class="btn btn-primary btn-update d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="fa fa-save fa-xs me-2"></i>Simpan</span></button>
                        <button type="button" id="batal" class="btn btn-secondary d-grid w-100">Kembali</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
<script>
    "use strict";

    let account = {!! json_encode(session('data')) !!}

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let data;

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    var lastIndex = null;

    var note = '';
    var term_and_conditions = '';

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
    var idIndex = urlSegments.indexOf('edit') + 1;
    var id = urlSegments[idIndex];
    let dataLocal = JSON.parse(localStorage.getItem("edit-invoice"));
    let ttdFile = dataLocal ? dataLocal.materai_image : null;

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
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance !== "undefined" && window.performance.getEntriesByType("navigation")[0].type === "back_forward");
            if (historyTraversal) {
                location.reload(); // Reload the page
            }
        });

        $('.date').flatpickr({
            dateFormat: 'd-m-Y'
        });

        const flatPickrEL = $(".date");
        if (flatPickrEL.length) {
            flatPickrEL.flatpickr({
                allowInput: true,
                monthSelectorType: "static",
                dateFormat: 'd-m-Y'
            });
        }

        $("#tenant").select2({
            placeholder: 'Select Tenant',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/tenant/select?field=company',
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

        function getTenant(id) {
            $.ajax({
                url: "{{url('api/tenant')}}/" + id,
                type: "GET",
                success: function(response) {
                    let data = response.data;
                    $("#tenant").empty().append("<option value=" + data.id + ">" + data.name + "</option>").val(data.id).trigger("change");
                    if (account.level == 1) {
                        $('#materai_name').val(data.name);
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

       
        if (dataLocal) {
            $("#invoice_number").val(dataLocal.invoice_number);
            $("#invoice_date").val(dataLocal.invoice_date);
            $("#contract_number").val(dataLocal.contract_number);
            $("#contract_date").val(dataLocal.contract_date);
            $("#addendum_number").val(dataLocal.addendum_number);
            $("#addendum_date").val(dataLocal.addendum_date);
            $("#grand_total_spelled").val(dataLocal.grand_total_spelled);
            $(".grand_total").text(format(dataLocal.grand_total));
            $("#invoice_due_date").val(dataLocal.invoice_due_date);
            $("#materai_date").val(dataLocal.materai_date);
            $("#materai_name").val(dataLocal.materai_name);
            var setTerm = dataLocal.term_and_condition ? dataLocal.term_and_condition : '';
            ClassicEditor.create(document.querySelector('#term_and_conditions'), {
                    minHeight: '300px'
                })
                .then(editor => {
                    editor.setData(setTerm);
                    term_and_conditions = editor;
                }).catch(error => {
                    console.error(error);
                });

            var setNotes = dataLocal.notes ? dataLocal.notes : '';
            ClassicEditor.create(document.querySelector('#notes'), {
                    minHeight: '300px'
                })
                .then(editor => {
                    editor.setData(setNotes);
                    note = editor;
                }).catch(error => {
                    console.error(error);
                });



            if (dataLocal.tenant_id) {
                getTenant(dataLocal.tenant_id);
            }

            getDetails(dataLocal.details);

        } else {
            getDataInvoice(id);
        }

        $('#tenant').on("change", (async function(e) {
            $(this).removeClass("invalid");
            var rekomendasi = $("#tenant").select2('data');
            var data = rekomendasi[0].id;
            $('#tenant').val(data);
        }));

     

        $(document).on('click', '.btn-add-row-mg', function() {
            // Clone baris terakhir
            var index = lastIndex ? lastIndex + 1 : $('.tax').length;
            lastIndex = index;
            console.log(lastIndex);
            var $details = $('#details');
            var $newRow = `
            <tr class="row-mg">
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input" placeholder="Nama Produk" name="item[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <textarea name="description[]" class="form-control row-input" rows="1" placeholder="Deskripsi Produk" style="width: 200px;"></textarea>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input quantity" placeholder="Kuantitas" name="item[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input price" placeholder="Harga" name="price[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input discount" placeholder="" name="discount[]" style="width: 100px;"/>
                        <input type="hidden" class="form-control total_subdiskon" placeholder="" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <select name="tax[]" id="tax-${index}" class="form-select row-input tax"></select>
                        <input type="hidden" class="form-control total_pajak" placeholder="" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input total_price" placeholder="" name="total_price[]" disabled style="width : 200px" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white" disabled>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>`;
            $details.append($newRow);
            $("#tax-" + index).select2({
                width: '100px',
                placeholder: 'Pilih Pajak',
                allowClear: true,
                ajax: {
                    // url: "{{ env('BASE_URL_API')}}" + '/api/tax/select',
                    url: "{{url('api/tax/select-paper')}}",
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
        });

        function tenantTemplate(data) {
            return data;
        }


        $(document).on('click', '.btn-remove-mg', function() {
            // Hapus baris yang ditekan tombol hapus
            $(this).closest('.row-mg').remove();
            getTotal();
            getSubtotal();
            getDiskonTotal();
            getPajakTotal();
            getTotal();
        });

        $(document).on('keydown', '.price', function(event) {
            var key = event.which;
            if ((key < 48 || key > 57) && key != 8) event.preventDefault();
        });

        $(document).on('input', '.quantity', function(event) {
            // Hapus baris yang ditekan tombol hapus
            let index = $('.price').index(this);
            let total = 0;
            let quantity = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
            let discount = parseFloat($(`.discount:eq(` + index + `)`).val());
            let price = parseFloat($(`.price:eq(` + index + `)`).val().replaceAll(',', ''));
            let disVal = discount / 100;
            let id = isNaN(parseFloat($(`.tax:eq(` + index + `)`).val())) ? 0 : $(`.tax:eq(` + index + `)`).val();
            console.log(id);
            if (id == 0) {
                if (isNaN(discount)) {
                    total = price * quantity;
                    $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                    getSubtotal();
                    getTotal();
                } else {
                    let disTotal = (price * quantity) * disVal;
                    total = price * quantity;
                    $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                    $(`.total_subdiskon:eq(` + index + `)`).val(isNaN(price) ? 0 : format(disTotal));
                    getSubtotal();
                    getDiskonTotal();
                    getTotal();
                }

            } else {
                $.ajax({
                    url: "{{url('api/tax/get-paper')}}/" + id,
                    type: "get",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        let data = response.data.value;
                        let total = 0;
                        let tax = parseFloat(data);
                        tax = tax / 100;
                        total = (price * quantity) * tax;
                        let exlusice = response.data.exclusive;
                        if (exlusice == 0) {
                            $(`.total_pajak:eq(` + index + `)`).val(0);
                        } else {
                            $(`.total_pajak:eq(` + index + `)`).val(isNaN(total) ? 0 : format(total));
                        }
                        if (isNaN(discount)) {
                            total = price * quantity;
                            $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                            getSubtotal();
                            getPajakTotal();
                            getTotal();
                        } else {
                            let disTotal = (price * quantity) * disVal;
                            total = price * quantity;
                            $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                            $(`.total_subdiskon:eq(` + index + `)`).val(isNaN(price) ? 0 : format(disTotal));
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        }

                    },
                    error: function(errors) {
                        console.log(errors);
                    }
                });
            }

        });

        $(document).on('input', '.price', function(event) {
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
            let index = $('.price').index(this);
            let total = 0;
            let price = isNaN(parseFloat($(this).val().replaceAll(',', ''))) ? 0 : parseFloat($(this).val().replaceAll(',', ''));
            let discount = parseFloat($(`.discount:eq(` + index + `)`).val());
            let quantity = parseFloat($(`.quantity:eq(` + index + `)`).val());
            let disVal = discount / 100;
            let id = isNaN(parseFloat($(`.tax:eq(` + index + `)`).val())) ? 0 : $(`.tax:eq(` + index + `)`).val();
            console.log(id);
            if (id == 0) {
                if (isNaN(discount)) {
                    total = price * quantity;
                    $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                    getSubtotal();
                    getTotal();
                } else {
                    let disTotal = (price * quantity) * disVal;
                    total = price * quantity;
                    $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                    $(`.total_subdiskon:eq(` + index + `)`).val(isNaN(price) ? 0 : format(disTotal));
                    getSubtotal();
                    getDiskonTotal();
                    getTotal();
                }

            } else {
                $.ajax({
                    url: "{{url('api/tax/get-paper')}}/" + id,
                    type: "get",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        let data = response.data.value;
                        let exlusice = response.data.exclusive;
                        let total = 0;
                        let tax = parseFloat(data);
                        tax = tax / 100;
                        total = (price * quantity) * tax;
                        if (exlusice == 0) {
                            $(`.total_pajak:eq(` + index + `)`).val(0);
                        } else {
                            $(`.total_pajak:eq(` + index + `)`).val(isNaN(total) ? 0 : format(total));
                        }
                        if (isNaN(discount)) {
                            total = price * quantity;
                            $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                            getSubtotal();
                            getPajakTotal();
                            getTotal();
                        } else {
                            let disTotal = (price * quantity) * disVal;
                            total = price * quantity;
                            $(`.total_price:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
                            $(`.total_subdiskon:eq(` + index + `)`).val(isNaN(price) ? 0 : format(disTotal));
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        }

                    },
                    error: function(errors) {
                        console.log(errors);
                    }
                });
            }

        });

        $(document).on('input', '.discount', function(event) {

            // Hapus baris yang ditekan tombol hapus
            let index = $('.price').index(this);
            let total = 0;
            let discount = parseFloat($(this).val());
            let price = parseFloat($(`.price:eq(` + index + `)`).val().replaceAll(',', ''));
            let quantity = parseFloat($(`.quantity:eq(` + index + `)`).val());
            console.log(price);
            let disVal = discount / 100;
            total = isNaN($(this).val()) ? 0 : (price * quantity) * disVal;
            $(`.total_subdiskon:eq(` + index + `)`).val(isNaN(price) ? 0 : format(total));
            getSubtotal();
            getDiskonTotal();
            getTotal();


        });

        $(document).on('input', '.tax', function(event) {
            let id = event.currentTarget.value;
            let index = $('.tax').index(this);
            let data = 0;
            if (id == '') {
                let total = 0;
                let price = parseFloat($(`.price:eq(` + index + `)`).val().replaceAll(',', ''));
                let quantity = parseFloat($(`.quantity:eq(` + index + `)`).val());
                let tax = 0;
                tax = tax / 100;
                let totalPrice = price * tax + price;
                total = (price * quantity) * tax;
                // console.log(format(totalPrice));
                $(`.total_pajak:eq(` + index + `)`).val(isNaN(total) ? 0 : format(total));
                getSubtotal();
                getDiskonTotal();
                getPajakTotal();
                getTotal();
            } else {

                $.ajax({
                    // url: "{{ env('BASE_URL_API')}}" + '/api/tax/' + id,
                    url: "{{url('api/tax/get-paper')}}/" + id,
                    type: "get",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(response) {
                        let data = response.data.value;
                        let exlusice = response.data.exclusive;
                        let total = 0;
                        let price = parseFloat($(`.price:eq(` + index + `)`).val().replaceAll(',', ''));
                        let quantity = parseFloat($(`.quantity:eq(` + index + `)`).val());
                        let tax = parseFloat(data);
                        tax = tax / 100;
                        let totalPrice = price * tax + price;
                        total = (price * quantity) * tax;
                        // console.log(format(totalPrice));
                        if (exlusice == 0) {
                            $(`.total_pajak:eq(` + index + `)`).val(0);
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        } else {
                            $(`.total_pajak:eq(` + index + `)`).val(isNaN(total) ? 0 : format(total));
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        }

                    },
                    error: function(errors) {
                        console.log(errors);
                    }
                });
            }
        });

        var saveInvoice = $('.create-invoice');

        Array.prototype.slice.call(saveInvoice).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        let tenant = $("#tenant").val();
                        let tglKontrak = $("#contract_date").val();

                        if (!tenant) {
                            $("#tenant").addClass("invalid");
                        }
                      
                    } else {
                        // Submit your form
                        event.preventDefault();
                        let tenant = $("#tenant").val();
                        let noInvoice = $("#invoice_number").val();
                        let tglInvoice = moment($("#invoice_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let noKontrak = $("#contract_number").val();
                        let tglKontrak = moment($("#contract_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let noAddendum = $("#addendum_number").val();
                        let tglAddendum = moment($("#addendum_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let terbilang = $("#grand_total_spelled").val();
                        let grandTotal = $(".grand_total").text().replaceAll(',', '');
                        let tglJatuhTempo = moment($("#invoice_due_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let syaratDanKententuan = $("#term_and_conditions").val();
                        let tglTtd = moment($("#materai_date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD');
                        let nameTtd = $("#materai_name").val();

                        var detail = [];
                        $('.row-input').each(function(index) {
                            var input_name = $(this).attr('name');
                            var input_value = $(this).val();
                            var input_index = Math.floor(index / 7); // Membagi setiap 5 input menjadi satu objek pada array
                            if (index % 7 == 0) {
                                detail[input_index] = {
                                    item: input_value
                                };
                            } else if (index % 7 == 1) {
                                detail[input_index].description = input_value;
                            } else if (index % 7 == 2) {
                                detail[input_index].quantity = parseFloat(input_value);
                            } else if (index % 7 == 3) {
                                detail[input_index].price = parseFloat(input_value.replaceAll(',', ''));
                            } else if (index % 7 == 4) {
                                detail[input_index].discount = (input_value == '') ?  parseFloat(0) : parseFloat(input_value);
                            } else if (index % 7 == 5) {
                                detail[input_index].tax_id = input_value;
                            } else if (index % 7 == 6) {
                                detail[input_index].total_price = parseFloat(input_value.replaceAll(',', ''));
                            }
                        });


                        let datas = {};
                        $('.create-invoice').find('.form-control').each(function() {
                            var inputId = $(this).attr('id');
                            var inputValue = $("#" + inputId).val();
                            datas[$("#" + inputId).attr("name")] = inputValue;
                        });

                        datas.details = detail;
                        datas.tenant_id = parseFloat(tenant);
                        datas.status = "Terbuat";
                        datas.invoice_due_date = tglJatuhTempo;
                        datas.invoice_date = tglInvoice;
                        datas.grand_total = parseFloat(grandTotal);
                        datas.notes = note.getData();
                        datas.term_and_condition = term_and_conditions.getData();

                        if (account.level.id == '1') {
                            datas.status = "Disetujui BM";
                        } else {
                            datas.status = "Terbuat";
                        }
                        delete datas['undefined'];
                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" + '/api/invoice/' + id,
                            type: "PATCH",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
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
                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil Memperbaharui Invoice',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                }).then(function() {
                                    localStorage.removeItem('edit-invoice');
                                    window.location.href = "/invoice/list-invoice"
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

                    form.classList.add("was-validated");
                },
                false
            );
        });

        $(document).on('click', '#preview', function(event) {
            event.preventDefault();
            let tenant = $("#tenant").val();
            let noInvoice = $("#invoice_number").val();
            let tglInvoice = $("#invoice_date").val();
            let noKontrak = $("#contract_number").val();
            let tglKontrak = $("#contract_date").val();
            let noAddendum = $("#addendum_number").val();
            let tglAddendum = $("#addendum_date").val();
            let terbilang = $("#grand_total_spelled").val();
            let tglJatuhTempo = $("#invoice_due_date").val();
            let syaratDanKententuan = $("#term_and_conditions").val();
            let tglTtd = $("#materai_date").val();
            let nameTtd = $("#materai_name").val();
            let grandTotal = parseFloat($(".grand_total").text().replaceAll(',', ''));
            let sub_total = parseFloat($(".sub_total").text().replaceAll(',', ''));
            let total_diskon = parseFloat($(".total_diskon").text().replaceAll(',', ''));
            let total_tax = parseFloat($(".total_tax").text().replaceAll(',', ''));


            var detail = [];
            $('.row-input').each(function(index) {
                var input_name = $(this).attr('name');
                var input_value = $(this).val();
                var input_index = Math.floor(index / 7); // Membagi setiap 5 input menjadi satu objek pada array
                if (index % 7 == 0) {
                    detail[input_index] = {
                        item: input_value
                    };
                } else if (index % 7 == 1) {
                    detail[input_index].description = input_value;
                } else if (index % 7 == 2) {
                    detail[input_index].quantity = parseFloat(input_value);
                } else if (index % 7 == 3) {
                    detail[input_index].price = parseFloat(input_value.replaceAll(',', ''));
                } else if (index % 7 == 4) {
                    detail[input_index].discount = parseFloat(input_value);
                } else if (index % 7 == 5) {
                    detail[input_index].tax_id = input_value;
                } else if (index % 7 == 6) {
                    detail[input_index].total_price = parseFloat(input_value.replaceAll(',', ''));
                }
            });
            let datas = {};
            $('.create-invoice').find('.form-control').each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $("#" + inputId).val();
                datas[$("#" + inputId).attr("name")] = inputValue;
            });

            datas.details = detail;
            datas.tenant_id = parseFloat(tenant);
            datas.status = "Terbuat";
            datas.invoice_due_date = tglJatuhTempo;
            datas.invoice_date = tglInvoice;
            datas.grand_total = parseFloat(grandTotal);
            datas.sub_total = parseFloat(sub_total);
            datas.total_diskon = parseFloat(total_diskon);
            datas.total_tax = parseFloat(total_tax);
            datas.term_and_condition = term_and_conditions.getData();
            datas.notes = note.getData();
            localStorage.setItem("edit-invoice", JSON.stringify(datas));
            window.location.href = `/invoice/preview-invoice-edit/${id}`
        });

        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            localStorage.removeItem("edit-invoice");
            window.location.href = "/invoice/list-invoice"
        });
    });

    function getSubtotal() {
        let totalArr = [];
        let tempTotal = document.getElementsByClassName('total_price');
        for (let i = 0; i < tempTotal.length; i++) {
            var slipOdd = parseFloat(tempTotal[i].value.replaceAll(',', ''));
            totalArr.push(Number(slipOdd));
        }

        let sum = 0;
        for (let i = 0; i < totalArr.length; i++) {
            sum += totalArr[i];
        }
        if(isNaN(sum)){
            sum = 0;
        }
        $('.sub_total').text(format(sum));
    }

    function getDiskonTotal() {
        let totalArr = [];
        let tempTotal = document.getElementsByClassName('total_subdiskon');
        for (let i = 0; i < tempTotal.length; i++) {
            var slipOdd = parseFloat(tempTotal[i].value.replaceAll(',', ''));
            totalArr.push(Number(slipOdd));
        }

        let sum = 0;
        for (let i = 0; i < totalArr.length; i++) {
            sum += totalArr[i];
        }
        if(isNaN(sum)){
            sum = 0;
        }
        $('.total_diskon').text(format(sum));
    }

    function getPajakTotal() {
        let totalArr = [];
        let tempTotal = document.getElementsByClassName('total_pajak');
        for (let i = 0; i < tempTotal.length; i++) {
            var slipOdd = parseFloat(tempTotal[i].value.replaceAll(',', ''));
            totalArr.push(Number(slipOdd));
        }

        let sum = 0;
        for (let i = 0; i < totalArr.length; i++) {
            sum += totalArr[i];
        }
        if(isNaN(sum)){
            sum = 0;
        }
        $('.total_tax').text(format(sum));
    }

    function getTotal() {
        let subtotal = parseFloat($('.sub_total').text().replaceAll(',', ''));
        let diskon = parseFloat($('.total_diskon').text().replaceAll(',', ''));
        let tax = parseFloat($('.total_tax').text().replaceAll(',', ''));
        let total = subtotal - diskon + tax;
        if(isNaN(total)){
            total = 0;
        }
        $('.grand_total').text(format(total));
        $('.terbilang').val(terbilang(total));
    }

    function terbilang(bilangan) {
        bilangan = String(bilangan);
        let angka = new Array('0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
        let kata = new Array('', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan');
        let tingkat = new Array('', 'Ribu', 'Juta', 'Milyar', 'Triliun');

        let panjang_bilangan = bilangan.length;
        let kalimat, subkalimat, kata1, kata2, kata3 = "";
        let i, j = 0;

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

    const rupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(number);
    }

    function getDataInvoice(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/invoice/' + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                let data = res.data;
                if (data.status != 'Terbuat') {
                    $('.form-control').attr('readonly');
                }
                console.log(data);
                var setTerm = data.term_and_condition ? data.term_and_condition : '';
                $("#tenant").empty().append("<option value=" + data.tenant.id + ">" + data.tenant.name + "</option>").val(data.tenant.id).trigger("change");
                $("#invoice_number").val(data.invoice_number);
                $("#invoice_date").val(data.invoice_date);
                $("#contract_number").val(data.contract_number);
                $("#contract_date").val(data.contract_date);
                $("#addendum_number").val(data.addendum_number);
                $("#addendum_date").val(data.addendum_date);
                $("#grand_total_spelled").val(data.grand_total_spelled);
                $(".grand_total").text(format(data.grand_total));
                $("#invoice_due_date").val(data.invoice_due_date);
                $("#term_and_conditions").val(data.term_and_conditions);
                $("#materai_date").val(data.materai_date);
                $("#materai_name").val(data.materai_name);
                ClassicEditor.create(document.querySelector('#term_and_conditions'), {
                        minHeight: '300px'
                    })
                    .then(editor => {
                        editor.setData(setTerm);
                        term_and_conditions = editor;
                    }).catch(error => {
                        console.error(error);
                    });

                var setNotes = data.notes ? data.notes : '';
                ClassicEditor.create(document.querySelector('#notes'), {
                        minHeight: '300px'
                    })
                    .then(editor => {
                        editor.setData(setNotes);
                        note = editor;
                    }).catch(error => {
                        console.error(error);
                    });

                getDetails(data.invoice_details);
                if (data.status != 'Disetujui BM') {
                    $('.kirim-invoice').attr('style', 'display:none !important');
                    $('.add-payment').attr('style', 'display:none !important');
                }
                if (account.level.id != '1') {
                    $('.data-materai').attr('style', 'display:none !important');
                }
                if (account.level.id == '1') {
                    $('.btn-remove-mg').addClass('d-none');
                    $('.btn-add-row-mg').addClass('d-none');
                    $(".btn-update span").html('<i class="ti ti-check ti-xs me-2"></i>Disetujui Kepala BM');
                    $('#materai_name').removeAttr('readonly');
                }
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }


    function getDetails(detailItems) {
        let details = detailItems;
        let getDetail = '';
        let temp = '';

        if (details) {
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
                        <input type="text" class="form-control row-input total_price" placeholder="" name="total_price[]" disabled style="width : 200px" value="${details[i].total_price.toLocaleString('en-EN')}"/>
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
                        let totalPajak = 0;
                        let totalDiskon = 0;
                        let price = parseFloat($(`.price:eq(` + i + `)`).val().replaceAll(',', ''));
                        let quantity = parseFloat($(`.quantity:eq(` + i + `)`).val());
                        let tax = parseFloat(data);
                        let discount = parseFloat($(`.discount:eq(` + i + `)`).val());
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
</script>
@endsection