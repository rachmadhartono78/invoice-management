@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Complain')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">

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
                            <input type="text" class="form-control w-75 " placeholder="Nama" />
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Rates</label>
                            <input type="text" class="form-control w-75 " placeholder="Rates" />
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label fw-bold">Keterangan</label>
                            <textarea class="form-control w-75" rows="11" id="keterangan" placeholder="Keterangan"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Ticket Add-->

        <!-- Ticket Actions -->
        <div class="col-lg-3 col-12 ticket-actions">
            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-primary d-grid w-100 mb-2" data-bs-toggle="offcanvas" data-bs-target="#sendInvoiceOffcanvas">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">Simpan</span>
                    </button>
                    <a href="#" class="btn btn-label-secondary d-grid w-100 mb-2">Preview</a>
                    <button type="button" class="btn btn-label-secondary d-grid w-100">Kembali</button>
                </div>
            </div>
        </div>
        <!-- /Ticket Actions -->
    </div>

    <!-- Offcanvas -->
    <!-- Send Ticket Sidebar -->
    <div class="offcanvas offcanvas-end" id="sendTicketOffcanvas" aria-hidden="true">
        <div class="offcanvas-header my-1">
            <h5 class="offcanvas-title">Send Ticket</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pt-0 flex-grow-1">
            <form>
                <div class="mb-3">
                    <label for="ticket-from" class="form-label">From</label>
                    <input type="text" class="form-control" id="ticket-from" value="shelbyComapny@email.com" placeholder="company@email.com" />
                </div>
                <div class="mb-3">
                    <label for="ticket-to" class="form-label">To</label>
                    <input type="text" class="form-control" id="ticket-to" value="qConsolidated@email.com" placeholder="company@email.com" />
                </div>
                <div class="mb-3">
                    <label for="ticket-subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="ticket-subject" value="ticket of purchased Admin Templates" placeholder="ticket regarding goods" />
                </div>
                <div class="mb-3">
                    <label for="ticket-message" class="form-label">Message</label>
                    <textarea class="form-control" name="ticket-message" id="ticket-message" cols="3" rows="8">Dear Queen Consolidated,
          Thank you for your business, always a pleasure to work with you!
          We have generated a new ticket in the amount of $95.59
          We would appreciate payment of this ticket by 05/11/2021</textarea>
                </div>
                <div class="mb-4">
                    <span class="badge bg-label-primary">
                        <i class="ti ti-link ti-xs"></i>
                        <span class="align-middle">Ticket Attached</span>
                    </span>
                </div>
                <div class="mb-3 d-flex flex-wrap">
                    <button type="button" class="btn btn-primary me-3" data-bs-dismiss="offcanvas">Send</button>
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /Send Invoice Sidebar -->
    <!-- /Offcanvas -->

</div>

@endsection