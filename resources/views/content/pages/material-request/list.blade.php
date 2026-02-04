@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Material Request')

@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Material Request</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">List</a>
        </li>
    </ol>
</nav>

{{-- Card --}}
<div class="card mb-4">
    <div class="card-widget-separator-wrapper">
        <div class="card-body card-widget-separator">
            <div class="row gy-4 gy-sm-1">
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_material_request">0</h3>
                            <p class="mb-0">Material Request  (bulan ini)</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none me-4">
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                        <div>
                            <h3 class="mb-1 count_material_request_ongoing">0</h3>
                            <p class="mb-0">Sedang Berjalan  (bulan ini)</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                        <div>
                            <h3 class="mb-1 count_material_request_done">0</h3>
                            <p class="mb-0">Selesai (bulan ini)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Datatables --}}
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="invoice-list-table table">
            <thead>
            </thead>
        </table>
    </div>
</div>

@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    "use strict";
    var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`;
    $((function() {
        let account = {!! json_encode(session('data')) !!}
        let levelId = account.level.id;
     
        let buttonAdd = [];
        
        if(levelId == '7'){
            buttonAdd = [{
                            text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Material Request</span>',
                            className: "btn btn-primary",
                            action: function(a, e, t, s) {
                                window.location = "{{url('request/material-request/add')}}";
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
                url: "{{ env('BASE_URL_API')}}" +'/api/material-request/report',
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('.count_material_request').html(res.count_material_request);
                    $('.count_material_request_done').html(res.count_material_request_done);
                    $('.count_material_request_ongoing').html(res.count_material_request_ongoing);
                    Swal.close();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }

        var a = $(".invoice-list-table");
        var e = a.DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: "{{ url('request/material-request/data-material-request') }}",
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".invoice-list-table").DataTable().page.info().page + 1;
                }
            },
            columns: [{
                    name: "material_request_number",
                    data: "material_request_number",
                    title: "No. Material Request",
                    className: 'text-center'
                },
                {
                    name: "requester",
                    data: "requester",
                    title: "Requester",
                    className: 'text-center'
                },
                {
                    name: "department",
                    data: "department",
                    title: "Department",
                    className: 'text-center'
                },
                {
                    name: "request_date",
                    data: "request_date",
                    title: "Tgl Request",
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
                },
                {
                    class: "text-center",
                    data: "status",
                    name: "status",
                    title: "Status",
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (data == 'Terbuat') {
                            return '<span class="badge w-100" style="background-color : #BFBFBF; " text-capitalized> Terbuat </span>';
                        } else if (data == 'disetujui chief departement') {
                            return '<span class="badge w-100" style="background-color : #4EC0D9; " text-capitalized>Disetujui Chief Departement </span>';
                        } else if (data == 'disetujui chief finance') {
                            return '<span class="badge w-100" style="background-color : #74D94E; " text-capitalized> Disetujui Chief Finance & Accounting </span>';
                        } else if (data == 'Disetujui KA') {
                            return '<span class="badge w-100" style="background-color : #FF87A7; " text-capitalized> Disetujui Kepala KA </span>';
                        } else if (data == 'Disetujui BM' || data == 'disetujui kepala bm') {
                            return '<span class="badge w-100" style="background-color : #4E6DD9; " text-capitalized> Disetujui BM </span>';
                        } else if (data == 'Selesai' || data == 'selesai') {
                            return '<span class="badge w-100" style="background-color : #74D94E; " text-capitalized> Selesai </span>';
                        }
                    }
                }, {
                    data: "id",
                    name: "tanggapan",
                    title: "Action",
                    render: function(data, type, row) {
                        let editRow = '';
                        let sendMailRow = '<a href="javascript:;" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Send Mail"><i class="ti ti-mail mx-2 ti-sm"></i></a>';
                        let previewRow = '<a href="{{ url("request/material-request/show")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Material Request"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                        return `<div class="d-flex align-items-center">
                            `  + previewRow + `
                            <div class="dropdown"><a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a target="_blank" href="{{ url("request/material-request/print")}}/` + data + `"" class="dropdown-item">Download</a><a href="{{ url("request/material-request/edit")}}/` + data + `" class="dropdown-item">Edit</a>
                            <div class="dropdown-divider"></div><a href="#" data-id="${data}" class="dropdown-item delete-record text-danger">Delete</a></div></div></div>`
                    }
                }
            ],
            order: [
                [0, "desc"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Invoice"
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
                this.api().columns(4).every((function() {
                    var a = this,
                        e = $(
                            '<select id="status" class="form-select"><option value=""> Select Status </option></select>'
                        ).appendTo(".invoice_status").on("change");
                            var optionsHtml =   '<option value="terbuat">Terbuat</option>' +
                                                '<option value="disetujui chief departement">Disetujui Chief Departement</option>' +
                                                '<option value="disetujui chief finance">Disetujui Chief Finance & Accounting</option>' +
                                                '<option value="disetujui ka">Disetujui KA</option>' +
                                                '<option value="disetujui bm">Disetujui BM</option>' +
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
        })), setTimeout((() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                ".dataTables_length .form-select").removeClass("form-select-sm")
        }), 300)

        $(document).on('change', '#status', function(x) {
            x.stopPropagation();
            e.ajax.url("{{ url('request/material-request/data-material-request') }}"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
        });

        $(document).on('click', '.delete-record', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.value) {
                    let id = $(this).data('id');
                    let datas = {}
                    datas.status = 'Terkirim';
                    Swal.fire({
                        title: '<h2>Loading...</h2>',
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" + '/api/material-request/'+id,
                        type: "DELETE",
                        data: JSON.stringify(datas),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil Menghapus Invoice',
                                icon: 'success',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            }).then((result) => {
                                $('.invoice-list-table').DataTable().ajax.reload();
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
            });
        });
    }));
</script>



@endsection