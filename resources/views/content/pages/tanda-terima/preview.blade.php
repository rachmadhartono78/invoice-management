@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Tanda Terima')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{asset('assets/vendor/libs/dropzone/dropzone.css')}}">
@endsection

@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="row invoice-add">
        <!-- Invoice Add-->
        <div class="col-lg-9 col-12 mb-lg-0 mb-3">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div style="background-image: url('{{ asset('assets/img/header.png') }}'); height : 150px; background-size: contain; background-repeat: no-repeat;">
                    </div>

                    <div class="row m-sm-2 m-0 px-3">
                        <div class="col-md-7 mb-md-0 ps-0">

                        </div>
                        <div class="col-md-5">
                            <dl class="row mb-2">
                                </dd>
                                <dt class="col-sm-6 text-md-end ps-0">

                                </dt>
                                <dd class="col-sm-6 d-flex justify-content-md-end pe-0 ps-0 ps-sm-2">
                                    <div class="mb-3">
                                        <label for="note" class="form-label fw-medium">No Tanda Terima:</label>
                                        <input type="text" class="form-control w-px-150" id="receipt_number" name="receipt_number" disabled />
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <h2 class="mx-auto text-center"><b>TANDA TERIMA PEMBAYARAN</b></h2>
                    <span class="mt-5 px-3" style="display: block">Telah terima Pembayaran Tunai / Cek / Giro</span>
                    <div class="row py-3 px-3">
                        <div class="col-md-6 mb-md-0 mb-3">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium">No Invoice</label>
                                <div class="form-label" id="invoice" name="invoice"></div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium">No. Cek/Giro</label>
                                <div class="form-label" id="check_number" name="check_number"></div>
                            </div>
                        </div>
                        <div class="col-md-6 justify-content-end text-end">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium">Nama Tenant</label>
                                <div class="form-label" id="tenant" name="tenant"></div>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium">Tanggal Tanda Terima</label>
                                <div class="form-label" id="receipt_date" name="tenant"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-3 d-flex align-items-center">
                        <div class="col-2">
                            <label for="salesperson" class="form-label fw-medium">Total Invoice</label>
                        </div>
                        <div class="col-10">
                            Rp. <span id="grand_total" name="grand_total"></span>,-
                        </div>
                    </div>

                    <hr>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="col-2">
                            <label for="salesperson" class="form-label  fw-medium">Dibayarkan</label>
                        </div>
                        <div class="col-10">
                            Rp. <span id="paid" name="paid"></span>,-
                        </div>
                    </div>
                    <hr>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="col-2">
                            <label for="salesperson" class="form-label  fw-medium">Sisa Tagihan</label>
                        </div>
                        <div class="col-10">
                            Rp. <span id="remaining" name="remaining"></span>,-
                        </div>
                    </div>
                    <hr>
                    <div class="row px-3 d-flex align-items-center mb-3">
                        <div class="col-2">
                            <label for="salesperson" class="form-label  fw-medium">Terbilang</label>
                        </div>
                        <div class="col-10">
                            <div class="col-10">
                                <span id="grand_total_spelled" name="grand_total_spelled"></span>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <div class="row py-3 px-3">
                        <div class="col-md-6 mb-md-0 mb-3">
                            <textarea class="form-control" rows="11" id="note" name="note" placeholder="Catatan"></textarea>
                            <br>
                            <br>
                            <span>
                                Apabila dibayar dengan cek / Bilyet giro, Pembayaran baru dianggap sah apabila telah
                                dapat dicairkan di Bank kami.
                            </span>
                        </div>

                        <div class="col-md-6 mb-md-0 mb-3 d-flex flex-column align-items-center text-center data-material">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium"></label>
                                <div class="form-label" id="signature_date" name="signature_date">
                                </div>
                            </div>
                            <div class="mb-3">
                                <img class="prev-img" src="" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div class="mb-3">
                                <div class="form-label" id="signature_name" name="signature_name">
                                    
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
                    <button class="btn btn-primary d-grid w-100 mb-2 kirim-tanda-terima d-none" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-send ti-xs me-2"></i>Kirim Tanda Terima</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-status d-grid w-100 mb-2 disetujui d-none" style="color : #fff;"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-check ti-xs me-2"></i>Disetujui</span></button>
                    <a href="{{url('invoice/tanda-terima/edit')}}/{{$id}}" id="edit" class="btn btn-primary d-grid w-100 mb-2 edit d-none"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-pencil ti-xs me-2"></i>Edit</span></a>
                    <a target="_blank" href="{{url('invoice/tanda-terima/print/')}}/{{$id}}" id="preview" class="btn btn-info d-grid w-100 mb-2"><span class="d-flex align-items-center justify-content-center text-nowrap"><i class="ti ti-download ti-xs me-2"></i>Download</span></a>
                    <a href="{{ url('invoice/tanda-terima')}}" id="back" class="btn btn-secondary d-grid w-100 mb-2">Kembali</a>
                </div>
            </div>
        </div>
        <!-- /Invoice Actions -->
    </div>

</div>
<!-- / Content -->

@endsection

@section('page-script')
<script src="{{asset('assets/vendor/libs/dropzone/dropzone.js')}}">
</script>
<script src="{{asset('assets/js/forms-file-upload.js')}}">
</script>
<script src="{{asset('assets/vendor/libs/moment/moment.js')}}">
</script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    $(document).ready(function() {

        let account = {!! json_encode(session('data')) !!}
        var urlSegments = window.location.pathname.split('/');
        var idIndex = urlSegments.indexOf('show') + 1;
        var id = urlSegments[idIndex];

        var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`;

        // function pengambil data
        getDataPreview(id);

        function getDataPreview(id) {
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" +'/api/receipt/' + id,
                type: "GET",
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                        title: '<h2>Loading...</h2>',
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                },
                success: function(response) {
                    Swal.close();
                    let result = response.data;
                    console.log(result);

                    $("#receipt_number").val(result.receipt_number);
                    $('#invoice').text(result.invoice.invoice_number);
                    $('#check_number').text(result.check_number);
                    $('#tenant').text(result.tenant.company);
                    $('#grand_total').text(result.invoice?.grand_total.toLocaleString('en-EN'));
                    $('#paid').text(result.paid.toLocaleString('en-EN'));
                    $('#remaining').text(result.remaining.toLocaleString('en-EN'));
                    $('#grand_total_spelled').text(result.grand_total_spelled);
                    $('#note').text(result.note);
                    $('#note').text(result.note);
                    $('#receipt_date').text(moment(result.receipt_date).format('DD MMMM YYYY'));
                    $('.prev-img').attr('src', result.signature_image);
                    if(result.signature_name == null && account.level.id != 1){
                        $('.data-material').removeClass('d-none');
                    }
                    $('#signature_name').text(result.signature_name);
                    $('#signature_date').text(result.signature_date ? moment(result.signature_date).format('DD MMMM YYYY'): '');
                    if((account.level.id == '2' && result.status == 'Terbuat') || account.level.id == '9' && result.status == 'Terbuat'){
                        $('.disetujui').removeClass('d-none');
                    }
                    if((account.level.id == '1' && result.status == 'Disetujui KA') || account.level.id == '10'){
                        $('.edit').removeClass('d-none');
                    }

                    $('.btn-edit').attr('data-id', id);
                },
                error: function(errors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errors.responseJSON
                            .message,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    })
                }
            });
        }

        $(".btn-status").on("click", function() {
            let datas = {}
            datas.status = 'Disetujui KA';
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Kirim!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" +'/api/receipt/update-status/'+ id,
                        type: "PATCH",
                        contentType: "application/json; charset=utf-8",
                        data: JSON.stringify(datas),
                        beforeSend: function() {
                            Swal.fire({
                                title: '<h2>Loading...</h2>',
                                html: sweet_loader + '<h5>Please Wait</h5>',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            })
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Menyetujui Tanda Terima',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                window.location.href = "/invoice/tanda-terima";
                            });
                            
                        },
                        error: function(errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: errors.responseJSON
                                    .message,
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            })
                        }
                    });
                }
            });
        })

        $(".btn-edit").on('click', function() {
            // Mendapatkan nilai data-id dari button yang diklik
            var id = $(this).data('id');

            // Membentuk URL dengan nilai id
            var url = window.location.href.replace(/\/preview\/\d+$/, '/edit/' + id);

            // Menggantikan URL saat ini dengan URL yang sudah dibentuk
            window.location.replace(url);
        });

    })
</script>
@endsection