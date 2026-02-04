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
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td class="pe-4">Nama</td>
                                            <td>:</td>
                                            <td class="fw-medium name"></td>
                                        </tr>
                                        <tr>
                                            <td class="pe-4">Pajak</td>
                                            <td>:</td>
                                            <td class="rate"></td>
                                        </tr>
                                        <tr style=" vertical-align: top">
                                            <td class="pe-4">Keterangan</td>
                                            <td>:</td>
                                            <td class="description"></td>
                                        </tr>
                                    </tbody>
                                </table>
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

    let data = JSON.parse(localStorage.getItem("tax"));
    $(document).ready(function() {
        console.log(data);
        $(".name").text(data.name);
        $(".rate").text(data.rate);
        $(".description").text(data.description);
    });

    $(document).on('click', '#save', function(event) {
        event.preventDefault();
        $.ajax({
            url: baseUrl + "api/tax/",
            type: "POST",
            data: JSON.stringify(data),
            contentType: "application/json; charset=utf-8",
            dataType: "json",

            success: function(response) {
                $('.indicator-progress').show();
                $('.indicator-label').hide();

                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil menambahkan Tax',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });

                localStorage.removeItem('tax');
                window.location.href = "/settings/tax-rates"

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