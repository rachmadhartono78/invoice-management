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

                            <div class="row p-3">
                                <div class="col-md-3 px-3">
                                    <button type="button" class="btn btn-primary waves-effect waves-light w-px-150 btn-add-row-mg">Tambah
                                        Baris</button>
                                </div>
                            </div>
                        </div>

                        {{-- Divider --}}
                        <div class="px-5 ">
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
                                        <p>Total Pajak</p>
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

                        <div class="row mb-3">
                            <div class="col-md-12 mb-4">
                                <label for="note" class="form-label fw-medium">Terbilang</label>
                                <input type="text" class="form-control terbilang" id="grand_total_spelled" name="grand_total_spelled" placeholder="Terbilang" disabled />
                            </div>
                            <div class="col-md-8 d-flex align-items-center">
                                <label for="note" class="form-label fw-medium me-2">Tanggal Jatuh Tempo :</label>
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
                            @if (session('data')['level']['id'] == '1')
                            <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center">
                                <div class="mb-3">
                                    <label for="note" class="form-label fw-medium">Tanda Tangan & Meterai
                                        (Opsional)</label>
                                    <input type="text" class="form-control w-px-250 date" placeholder="Tanggal" id="materai_date" name="materai_date" />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                                <div class="mb-3">
                                    <div action="/upload" class="dropzone needsclick dz-clickable w-px-250" id="dropzone-basic">
                                        <div class="dz-message needsclick">
                                            <span class="note needsclick">Unggah Tanda Tangan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <a role="button" id="deleteTtd" class="btn btn-danger btn-sm text-center text-white" disabled>
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control w-px-250 " id="materai_name" placeholder="Nama & Jabatan" name="materai_name" />
                                    <div class="invalid-feedback">Tidak boleh kosong</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Invoice Add-->


            <!-- Invoice Actions -->
            <div class="col-lg-3 col-12 invoice-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="fa fa-save fa-xs me-2"></i>Simpan</span></button>
                        {{-- <button type="button" id="preview" class="btn btn-success d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-eye ti-xs me-2"></i>Preview</span></button> --}}
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

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
    var lastIndex = null;

    var note ='';
    var term_and_conditions ='';
     

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
    let dataLocal = JSON.parse(localStorage.getItem("invoice"));
    $(document).ready(function() {
        let ttdFile = dataLocal ? dataLocal.materai_image : null;
        if (account.level.id == '1') {
            const myDropzone = new Dropzone('#dropzone-basic', {
                parallelUploads: 1,
                thumbnailWidth: null,
                thumbnailHeight: null,
                maxFilesize: 3,
                addRemoveLinks: true,
                maxFiles: 1,
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                autoQueue: false,
                url: "../uploads/logo",
                init: function() {
                    if (dataLocal) {
                        // Add a preloaded file to the dropzone with a preview
                        var mockFile = dataLocal.materai_image;
                        if (mockFile) {
                            this.options.addedfile.call(this, mockFile);
                            this.options.thumbnail.call(this, mockFile, dataLocal.materai_image.dataURL);

                            $('.dz-image').last().find('img').attr('width', '100%');


                            // Optional: Handle the removal of the file
                            mockFile.previewElement.querySelector(".dz-remove").addEventListener("click", function() {
                                // Handle removal logic here
                            });
                        }
                    }
                    this.on('addedfile', function(file) {
                        $('.dz-image').last().find('img').attr('width', '100%');
                        while (this.files.length > this.options.maxFiles) this.removeFile(this.files[0]);
                        ttdFile = file;
                    })
                }
            });


            $(document).on('click', '#deleteTtd', function() {
                myDropzone.removeAllFiles();
            });
        }

        var setNote = dataLocal ? dataLocal.notes : '';

        ClassicEditor.create(document.querySelector('#notes'), {
            minHeight: '300px'
        })
        .then(editor => {
            editor.setData(setNote);
            note = editor;
        }).catch(error => {
            console.error(error);
        });
           

        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance !== "undefined" && window.performance.getEntriesByType("navigation")[0].type === "back_forward");
            if (historyTraversal) {
                location.reload(); // Reload the page
            }
        });

        var setTerm = dataLocal ? dataLocal.term_and_conditions : '';
        ClassicEditor.create(document.querySelector('#term_and_conditions'), {
                minHeight: '300px'
            })
            .then(editor => {
                editor.setData(setTerm);
                term_and_conditions = editor;
            }).catch(error => {
                console.error(error);
            });

        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance !== "undefined" && window.performance.getEntriesByType("navigation")[0].type === "back_forward");
            if (historyTraversal) {
                location.reload(); // Reload the page
            }
        });

        $('.date').flatpickr({
            dateFormat: 'Y-m-d'
        });

        const flatPickrEL = $(".date");
        if (flatPickrEL.length) {
            flatPickrEL.flatpickr({
                allowInput: true,
                monthSelectorType: "static",
                dateFormat: 'Y-m-d'
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



        // $('#tenant').next('.select2-container').find('.select2-selection').css('width', '250px');
        // $('#tenant').find('.select2-container').css('width', '100px');

        $("#bank").select2({
            placeholder: 'Select Bank',
            allowClear: true,
            ajax: {
                url: "{{ env('BASE_URL_API')}}" + '/api/bank/select',
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

        if (dataLocal) {
            load(dataLocal);
        }
        getDetails();

        $('#tenant').on("change", (async function(e) {
            $(this).removeClass("invalid");
            var rekomendasi = $("#tenant").select2('data');
            var data = rekomendasi[0].id;
            $('#tenant').val(data);
        }));

        $('#bank').on("change", (async function(e) {
            $(this).addClass("valid");
            var rekomendasi = $("#bank").select2('data');
            var data = rekomendasi[0].id;
            $('#bank').val(data);

        }));

        $(document).on('click', '.btn-add-row-mg', function() {
            // Clone baris terakhir
            var index = lastIndex ? lastIndex + 1 : $('.tax').length;
            lastIndex = index;
            var $details = $('#details');
            var temp = `             
            <tr class="row-mg">
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input"  placeholder="Nama Produk" name="item[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <textarea name="description[]" class="form-control row-input" rows="1" placeholder="Deskripsi Produk" style="width: 200px;"></textarea>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input quantity" placeholder="Kuantitas" name="item[]" required style="width: 200px;" data-quantity="${index}" id="quantity-${index}" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input price" placeholder="Harga" name="price[]" required style="width: 200px;" data-price="${index}" id="price-${index}"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input discount" placeholder="" name="discount[]" data-discount="${index}" style="width: 100px;"/>
                        <input type="hidden" class="form-control total_subdiskon" placeholder="" name="discount[]" id="total_subdiskon-${index}" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <select name="tax[]" id="tax-${index}" class="form-select row-input tax"></select>
                        <input type="hidden" class="form-control total_pajak" placeholder="" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input total_price" placeholder="" name="total_price[]" disabled style="width : 200px" data-total_price="${index}" id="total_price-${index}"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white" disabled>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>`;
            $details.append(temp);
            $("#tax-" + index).select2({
                width: '100px',
                placeholder: 'Pilih Pajak',
                allowClear: true,
                ajax: {
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

        $("#tax-0").select2({
            placeholder: 'Pilih Pajak',
            allowClear: true,
            ajax: {
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

        $(document).on('click', '.btn-remove-mg', function() {
            // Hapus baris yang ditekan tombol hapus
            $(this).closest('.row-mg').remove();
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
            let index = $(this).data('quantity');
            let total = 0;
            let quantity = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
            let discount =  parseFloat($(`#discount-`+index).val());
            let price = parseFloat($(`#price-`+index).val().replaceAll(',', '') || '0');;
            let disVal = discount / 100;
            let id = isNaN(parseFloat($(`#tax-`+index).val())) ? 0 : $(`.tax:eq(` + index + `)`).val();
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
                        if(exlusice == 0){
                            $(`.total_pajak:eq(` + index + `)`).val(0);
                        }else{
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
                        if(exlusice == 0){
                            $(`.total_pajak:eq(` + index + `)`).val(0);
                        }else{
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
            let id = $(this).data('discount');
            let total = 0;
            let discount = $(this).val();
            let price = $(`#price-`+id).val().replaceAll(',', '');
            let quantity = $(`#quantity-`+id).val();
            if(discount == ''){
                discount = 0;
            }
            let disVal = discount / 100;
            total = isNaN($(this).val()) ? 0 : (price * quantity) * disVal;
            $('#total_subdiskon-'+id).val(isNaN(price) ? 0 : format(total));
            getSubtotal();
            getDiskonTotal();
            getTotal();
        });

        $(document).on('change', '.tax', function(event) {
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
                $(`.total_pajak:eq(` + index + `)`).val(isNaN(total) ? 0 : format(total));
                getSubtotal();
                getDiskonTotal();
                getPajakTotal();
                getTotal();
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
                        let price = parseFloat($(`.price:eq(` + index + `)`).val().replaceAll(',', ''));
                        let quantity = parseFloat($(`.quantity:eq(` + index + `)`).val());
                        let tax = parseFloat(data);
                        tax = tax / 100;
                        let totalPrice = price * tax + price;
                        total = (price * quantity) * tax;
                        if(exlusice == 0){
                            $(`.total_pajak:eq(` + index + `)`).val(0);
                            getSubtotal();
                            getDiskonTotal();
                            getPajakTotal();
                            getTotal();
                        }else{
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
                var slipOdd = tempTotal[i].value.replaceAll(',', '');
                console.log(slipOdd);
                if(isNaN(slipOdd)) {
                    slipOdd = 0;
                }
                totalArr.push(Number(slipOdd));
            }

            let sum = 0;
            for (let i = 0; i < totalArr.length; i++) {
                console.log(totalArr[i]);
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
                var slipOdd = 0;
                if(tempTotal[i].value != ''){
                    slipOdd = parseFloat(tempTotal[i].value.replaceAll(',', ''));
                }
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

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }

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
                        let bank = $("#bank").val();
                        let tglKontrak = $("#contract_date").val();

                        if (!tenant) {
                            $("#tenant").addClass("invalid");
                        }
                        if (!bank) {
                            $("#bank").addClass("invalid");
                        }

                    } else {
                        Swal.fire({
                            title: '<h2>Loading...</h2>',
                            html: sweet_loader + '<h5>Please Wait</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                        // Submit your form
                        event.preventDefault();
                        let fileTtd = '';
                        if (account.level.id == '1') {
                            let fileTtd = ttdFile.dataURL;
                        }
                        let tenant = $("#tenant").val();
                        let noInvoice = $("#invoice_number").val();
                        let tglInvoice = $("#invoice_date").val();
                        let noKontrak = $("#contract_number").val();
                        let tglKontrak = $("#contract_date").val();
                        let noAddendum = $("#addendum_number").val();
                        let tglAddendum = $("#addendum_date").val();
                        let terbilang = $("#grand_total_spelled").val();
                        let grandTotal = parseFloat($(".grand_total").text().replaceAll(',', ''));
                        let tglJatuhTempo = $("#invoice_due_date").val();
                        let syaratDanKententuan = $("#term_and_conditions").val();
                        let bank = $("#bank").val();
                        let tglTtd = $("#materai_date").val();
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
                        datas.notes = note.getData();
                        datas.term_and_condition = term_and_conditions.getData();
                        delete datas['undefined'];
                        delete datas['grand_total_spelled'];
                        delete datas['note'];

                        $.ajax({
                            url: "{{ env('BASE_URL_API')}}" + '/api/invoice',
                            type: "POST",
                            data: JSON.stringify(datas),
                            processData: false,
                            contentType: false,
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
                                }).then(function() {
                                    localStorage.removeItem('invoice');
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
            let grandTotal = parseFloat($(".grand_total").text().replaceAll(',', ''));
            let sub_total = parseFloat($(".sub_total").text().replaceAll(',', ''));
            let total_diskon = parseFloat($(".total_diskon").text().replaceAll(',', ''));
            let total_tax = parseFloat($(".total_tax").text().replaceAll(',', ''));
            let tglJatuhTempo = $("#invoice_due_date").val();
            let syaratDanKententuan = $("#term_and_conditions").val();
            let bank = $("#bank").val();
            let tglTtd = $("#materai_date").val();
            let nameTtd = $("#materai_name").val();
            let fileTtd = ttdFile;


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
            delete datas['undefined'];
            localStorage.setItem("invoice", JSON.stringify(datas));
            window.location.href = "/invoice/preview-invoice"
        });

        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            localStorage.removeItem('invoice');
            window.location.href = "/invoice/list-invoice"
        });
    });

    function load(dataLocale) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $("#invoice_number").val(dataLocal.invoice_number);
        $("#contract_number").val(dataLocal.contract_number);
        $("#addendum_number").val(dataLocal.addendum_number);
        $("#grand_total_spelled").val(dataLocal.grand_total_spelled);
        $(".grand_total").text(format(dataLocal.grand_total));
        $(".sub_total").text(format(dataLocal.sub_total));
        $(".total_diskon").text(format(dataLocal.total_diskon));
        $(".total_tax").text(format(dataLocal.total_tax));
        $("#materai_name").val(dataLocal.materai_name);
       

        if (dataLocal.tenant_id) {
            getTenant();
        }
        if (dataLocal.bank_id) {
            getBank();
        }
        if (dataLocal.invoice_date) {
            getInvoiceDate();
        }
        if (dataLocal.contract_date) {
            getContractDate();
        }

        if (dataLocal.addendum_date) {
            getAddendumDate();
        }

        if (dataLocal.invoice_due_date) {
            getInvoiceDueDate();
        }

        if (dataLocal.materai_date) {
            getMateraiDate();
        }
        Swal.close();
    }

    function validasi_minus_qty(x){
        if((Number.parseFloat(x.value) < 1)){
             Swal.fire({
                icon: "error",
                title: "Kesalahan",
                showDenyButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                text: "Nilai dalam field tidak boleh berjumlah minus atau kosong",
            });
            x.value = 1
        }
    }
    function validasi_minus_diskon(x){
        if((Number.parseFloat(x.value) < 0)){
             Swal.fire({
                icon: "error",
                title: "Kesalahan",
                showDenyButton: false,
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                text: "Nilai dalam field tidak boleh berjumlah minus",
            });
            x.value = 1
        }
    }
    function getTenant() {
        let idTenant = dataLocal.tenant_id;
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + "/api/tenant/" + idTenant,
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

    function getBank() {
        let idBank = dataLocal.bank_id;
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" + '/api/bank/' + idBank,
            type: "GET",
            success: function(response) {
                let data = response.data;
                let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                $('#bank').prepend(tem);

            },
            error: function(xhr, status, error) {
                console.log(error);
            }
        });
    }

    function getInvoiceDate() {
        let invoiceDate = dataLocal.invoice_date;
        $('#invoice_date').val(invoiceDate);
    }

    function getContractDate() {
        let contractDate = dataLocal.contract_date;
        $('#contract_date').val(contractDate);
    }

    function getAddendumDate() {
        let addendumDate = dataLocal.addendum_date;
        $('#addendum_date').val(addendumDate);
    }

    function getInvoiceDueDate() {
        let invoiceDueDate = dataLocal.invoice_due_date;
        $('#invoice_due_date').val(invoiceDueDate);
    }

    function getMateraiDate() {
        let materailDate = dataLocal.materai_date;
        $('#materai_date').val(materailDate);
    }

    function getDetails() {
        let data = dataLocal;
        let getDetail = '';
        let temp = '';

        if (data) {
            let details = dataLocal.details;
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
                </tr>`;
                getDetail = getDetail + temp;
                $.ajax({
                    url: "{{url('api/tax/get-paper')}}/" + details[i].tax_id,
                    type: "GET",
                    success: function(response) {
                        let data = response.data;
                        let tem = `<option value="` + data.id + `" selected>` + data.name + `</option>`;
                        $('#tax-' + i).prepend(tem);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });

            }
            $('#details').prepend(getDetail);
            for (let i = 0; i < details.length; i++) {
                $("#tax-" + i).select2({
                    width: '100px',
                    placeholder: 'Pilih Pajak',
                    allowClear: true,
                    ajax: {
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
            }
        } else {
            temp = `             
            <tr class="row-mg">
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input" data-item="0" id="item-0" placeholder="Nama Produk" name="item[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <textarea name="description[]" class="form-control row-input" rows="1" data-description="0" id="description-0" placeholder="Deskripsi Produk" style="width: 200px;"></textarea>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input quantity" data-quantity="0" id="quantity-0"  placeholder="Kuantitas" onchange="validasi_minus_qty(this)" name="item[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input price" data-price="0" id="price-0" placeholder="Harga" name="price[]" required style="width: 200px;" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="number" class="form-control row-input discount" data-discount="0"  onchange="validasi_minus_diskon(this)" id="discount-0" placeholder="" name="discount[]" style="width: 100px;"/>
                        <input type="hidden" class="form-control total_subdiskon" data-total_subdiskon="0"  id="total_subdiskon-0" placeholder="" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <select name="tax[]" id="tax-0" class="form-select row-input tax" data-tax="0" id="tax-0"></select>
                        <input type="hidden" class="form-control total_pajak" placeholder="" data-total_pajak="0" id="total_pajak-0" name="discount[]" style="width: 100px;"/>
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <input type="text" class="form-control row-input total_price" placeholder="" data-total_price="0" id="total_price-0" name="total_price[]" disabled style="width : 200px" />
                        <div class="invalid-feedback">Tidak boleh kosong</div>
                    </td>
                    <td style="vertical-align: bottom">
                        <a role="button" class="btn btn-danger text-center btn-remove-mg text-white" disabled>
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>`;
            $('#details').prepend(temp);
           
        }
       
    }
</script>
@endsection