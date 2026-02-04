@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Complain')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <form id="create-tax" class="create-tax" novalidate>
        <div class="row ticket-add">
            <!-- Ticket Add-->
            <div class="col-lg-9 col-12 mb-lg-0 mb-3">
                <div class="card ticket-preview-card">
                    <div class="card-body">
                        <h2 class="mx-auto"><b>Tambah Pajak</b></h2>
                        {{-- Divider --}}
                        <hr class="my-3 mx-n4">

                        <div class="col-md-12 mb-md-0 mb-3">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Nama</label>
                                <input type="text" class="form-control w-75" placeholder="Nama" name="name" id="name" required />
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Rates</label>
                                <input type="number" class="form-control w-75 " placeholder="Rates" name="rate" id="rate" required />
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-bold">Keterangan</label>
                                <textarea class="form-control w-75" rows="11" id="keterangan" placeholder="Keterangan" name="description" id="description" required></textarea>
                                <div class="invalid-feedback">Tidak boleh kosong</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Ticket Add-->

            <!-- Ticket Actions -->
            <div class="col-lg-3 col-12 tax-actions">
                <div class="card mb-4">
                    <div class="card-body">
                        <button type="submit" id="save" class="btn btn-primary d-grid w-100 mb-2">Simpan</button>
                        <button type="button" id="preview" class="btn btn-label-secondary d-grid w-100 mb-2">Preview</button>
                        <button type="button" id="batal" class="btn btn-label-secondary d-grid w-100">Kembali</button>
                    </div>
                </div>
            </div>
            <!-- /Ticket Actions -->
        </div>
    </form>
</div>

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
    let dataLocal = JSON.parse(localStorage.getItem("tax"));
    $(document).ready(function() {
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted || (typeof window.performance !== "undefined" && window.performance.getEntriesByType("navigation")[0].type === "back_forward");
            if (historyTraversal) {
                location.reload(); // Reload the page
            }
        });

        if (dataLocal) {
            $("#invoice_number").val(dataLocal.invoice_number);
            $("#contract_number").val(dataLocal.contract_number);
            $("#addendum_number").val(dataLocal.addendum_number);
            $("#grand_total_spelled").val(dataLocal.grand_total_spelled);
            $(".grand_total").text(dataLocal.grand_total);
            $("#materai_name").val(dataLocal.materai_name);
            $("#term_and_conditions").val(dataLocal.term_and_conditions);
        }

        var saveTax = $('.create-tax');

        Array.prototype.slice.call(saveTax).forEach(function(form) {
            $('.indicator-progress').hide();
            $('.indicator-label').show();
            form.addEventListener(
                "submit",
                function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        // Submit your form
                        event.preventDefault();
                        let datas = {};
                        $('.create-tax').find('.form-control').each(function() {
                            var inputId = $(this).attr('id');
                            var inputValue = $("#" + inputId).val();
                            datas[$("#" + inputId).attr("name")] = inputValue;
                        });

                        console.log(datas);

                        $.ajax({
                            url: baseUrl + "api/tax",
                            type: "POST",
                            data: JSON.stringify(datas),
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",

                            success: function(response) {
                                $('.indicator-progress').show();
                                $('.indicator-label').hide();

                                Swal.fire({
                                    title: 'Berhasil',
                                    text: 'Berhasil menambahkan Pajak',
                                    icon: 'success',
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    },
                                    buttonsStyling: false
                                })

                                localStorage.removeItem('tax');
                                window.location.href = "/settings/tax-rates"
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

            let datas = {};
            $('.create-tax').find('.form-control').each(function() {
                var inputId = $(this).attr('id');
                var inputValue = $("#" + inputId).val();
                datas[$("#" + inputId).attr("name")] = inputValue;
            });
            localStorage.setItem("tax", JSON.stringify(datas));
            window.location.href = "/settings/tax-rates/preview-tax"
        });

        $(document).on('click', '#batal', function(event) {
            event.preventDefault();
            localStorage.removeItem('tax');
            window.location.href = "/settings/tax-rates"
        });
    });
</script>
@endsection