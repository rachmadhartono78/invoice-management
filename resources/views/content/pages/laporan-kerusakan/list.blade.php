@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Laporan Kerusakan')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection

@section('content')

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Laporan Kerusakan /</span> List
</h4>

<!-- Invoice List Widget -->

<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                
                <div class="col-sm-4 col-lg-6">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_damage_report">0</h3>
                            <p class="mb-0">Laporan Kerusakan (Bulan Ini)</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-4 col-lg-6">
                    <div class="d-flex justify-content-between align-items-start pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1 count_damage_report_done">0</h3>
                            <p class="mb-0">Laporan Kerusakan Selesai (Bulan Ini)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Invoice List Table -->
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="damage-report-list-table table">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('page-script')
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
"use strict";
$(document).ready(function() {

    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`;

    let account = {!! json_encode(session('data')) !!}
    let levelId = account.level.id;
    let buttonAdd = [];
    
    if(levelId == '10'){
        buttonAdd =[{
            text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Laporan Kerusakan</span>',
            className: "btn btn-primary",
            action: function(a, e, t, s) {
                window.location = baseUrl + "complain/laporan-kerusakan/add"
            }
        }];
    }

    setHeader();

    function setHeader() {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        });
        $.ajax({
            url: "{{ env('BASE_URL_API')}}" +'/api/damage-report/report',
            type: "GET",
            dataType: "json",
            success: function(res) {
                $('.count_tenant').html(res.count_tenant);
                $('.count_damage_report').html(res.count_damage_report);
                $('.count_damage_report_done').html(res.count_damage_report_done);
                Swal.close();
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    }

    var a = $(".damage-report-list-table");
    var e = a.DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: {
            url: "{{ url('complain/laporan-kerusakan/data-damage') }}",
            "data": function(d) {
                d.start = 0;
                d.page = $(".damage-report-list-table").DataTable().page.info().page +
                    1;
            }
        },
        columns: [{
            data: "damage_report_number",
            name: "damage_report_number",
            title: "No LK",
            className: 'text-center'
        }, {
            data: "scope",
            name: "scope",
            title: "Scope",
            className: 'text-center'
        }, {
            data: "classification",
            name: "classification",
            title: "Classification",
            className: 'text-center'
        }, {
            data: "damage_report_date",
            name: "damage_report_date",
            title: "Date",
            className: 'text-center',
            render: function(data, type, full, meta) {
                var tanggalAwal = data;
                var bagianTanggal = tanggalAwal.split('-');
                var tahun = bagianTanggal[0];
                var bulan = bagianTanggal[1];
                var hari = bagianTanggal[2];
                var tanggalHasil = hari + '/' + bulan + '/' + tahun;
                return tanggalHasil;
            }
        }, {
            data: "action_plan_date",
            name: "action_plan_date",
            title: "Action Plan",
            className: 'text-center',
            render: function(data, type, full, meta) {
                var tanggalAwal = data;
                var bagianTanggal = tanggalAwal.split('-');
                var tahun = bagianTanggal[0];
                var bulan = bagianTanggal[1];
                var hari = bagianTanggal[2];
                var tanggalHasil = hari + '/' + bulan + '/' + tahun;
                return tanggalHasil;
            }
        }, {
            data: "status",
            name: "status",
            title: "Status",
            className: 'text-center',
            render: function(data, type, full, meta) {
                if (data == "Disetujui KA") {
                    return '<span class="badge w-100" style="background-color : #4EC0D9; " >' + data +
                        '</span>'
                } else if (data == "Disetujui BM") {
                    return '<span class="badge w-100" style="background-color : #4E6DD9; ">' + data +
                        '</span>'
                }  else if (data == "Disetujui LC") {
                    return '<span class="badge w-100" style="background-color : #4E6DD9; ">' + data +
                        '</span>'
                } else if (data == "Disetujui KT") {
                    return '<span class="badge w-100" style="background-color : #74D94E; ">' + data +
                        '</span>'
                } else if (data == "Terbuat") {
                    return '<span class="badge w-100" style="background-color : #BFBFBF; " >' + data +
                        '</span>'
                } else if (data == "Terkirim") {
                    return '<span class="badge w-100" style="background-color : #FF87A7; ">' + data +
                        '</span>'
                } else if (data == "Selesai") {
                    return '<span class="badge w-100" style="background-color : #74D94E; ">' + data +
                        '</span>'
                }
            }
        }, {
            data: null,
            title: "Action",
            render: function(data, type, row) {
                return '<div class="d-flex align-items-center"><a href="laporan-kerusakan/show/' +
                    data.id +
                    '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Laporan Kerusakan"><i class="ti ti-eye mx-2 ti-sm"></i></a><div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="/complain/laporan-kerusakan/print/' +
                    data.id + '" class="dropdown-item">Download</a><a href="laporan-kerusakan/edit/' +
                    data.id + '" class="dropdown-item btn-edit" data-id="' +
                    data.id +
                    '">Edit</a><div class="dropdown-divider"></div><a href="javascript:;" class="dropdown-item delete-record text-danger btn-delete" data-id="' +
                    data.id + '">Delete</a></div></div></div>'
            }
        }],
        order: [
            [0, "desc"]
        ],
        dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: {
            sLengthMenu: "Show _MENU_",
            search: "",
            searchPlaceholder: "Search LK"
        },
        buttons: buttonAdd,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(a) {
                        return "Details of " + a.data().full_name
                    }
                }),
                type: "column",
                renderer: function(a, e, t) {
                    var s = $.map(t, (function(a, e) {
                        return "" !== a.title ? '<tr data-dt-row="' + a
                            .rowIndex + '" data-dt-column="' + a
                            .columnIndex + '"><td>' + a.title +
                            ":</td> <td>" + a.data + "</td></tr>" : ""
                    })).join("");
                    return !!s && $('<table class="table"/><tbody />').append(s)
                }
            }
        },
        initComplete: function() {
            this.api().columns(5).every((function() {
                var a = this,
                    e = $(
                        '<select id="status" class="form-select"><option value=""> Select Status </option></select>'
                    ).appendTo(".invoice_status").on("change");
                        var optionsHtml =   '<option value="terbuat">Terbuat</option>' +
                                            '<option value="disetujui lc">Disetujui LC</option>' +
                                            '<option value="disetujui kt">Disetujui KT</option>' +
                                            '<option value="disetujui bm">Disetujui BM</option>' +
                                            '<option value="terkirim">Terkirim</option>' +
                                            '<option value="selesai">Selesai</option>';
                        e.append(optionsHtml);
            }))
        }
    });
    a.on("draw.dt", (function() {
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map((
            function(a) {
                return new bootstrap.Tooltip(a, {
                    boundary: document.body
                })
            }))
    })), $(".damage-report-list-table tbody").on("click", ".delete-record", (function() {
        e.row($(this).parents("tr")).remove().draw()
    })), setTimeout((() => {
        $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
            ".dataTables_length .form-select").removeClass("form-select-sm")
    }), 300)

    $(document).on('change', '#status', function(x) {
        x.stopPropagation();
        e.ajax.url("{{ url('complain/laporan-kerusakan/data-damage') }}"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
    });

    $(document).on('click', '.btn-delete', function(event) {
        let id = $(this).data('id');
        event.stopPropagation();
        Swal.fire({
            text: "Apakah Ingin menghapus Laporan Kerusakan ini  ?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Yes, send!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
                cancelButton: "btn fw-bold btn-active-light-primary"
            }
        }).then(async function(result) {
            if (result.value) {
                var formData = new FormData();
                hapusLaporanKerusakan(id);
            }
        });
    });

    function hapusLaporanKerusakan(id) {
        Swal.fire({
            title: '<h2>Loading...</h2>',
            html: sweet_loader + '<h5>Please Wait</h5>',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false
        })

        $.ajax({
            url: "{{ env('BASE_URL_API')}}" +'/api/damage-report/'+ id,
            type: "DELETE",
            contentType: false,
            processData: false,
            async: true,
            success: function(response, result) {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Berhasil Hapus Laporan Kerusakan',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                }).then(async function(res) {
                    $(".damage-report-list-table").DataTable().ajax.reload();
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: error,
                });
            }
        });
    }
});
</script>

@endsection