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
        var urlSegments = window.location.pathname.split('/');
        var idIndex = urlSegments.indexOf('show') + 1;
        var id = urlSegments[idIndex];
        getDataTax(id);
    });

    function getDataTax(id) {
        console.log(id);
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" +'/api/tax/' + id,
            type: "GET",
            dataType: "json",
            success: function(res) {
                let data = res.data;
                $(".name").text(data.name);
                $(".rate").text(data.rate);
                $(".description").text(data.description);

            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }
</script>
@endsection