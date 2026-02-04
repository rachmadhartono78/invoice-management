@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Complain')
@section('page-style')
{{-- Page Css files --}}
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">

<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="#">Ticket</a>
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
                
                <div class="col-sm-6 col-lg-12">
                    <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                        <div class="text-center">
                            <h3 class="mb-1 count_ticket">0</h3>
                            <p class="mb-0">Total Ticket (Bulan Ini)</p>
                        </div>
                    </div>
                    <hr class="d-none d-sm-block d-lg-none">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Datatables --}}
<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <table class="ticket-list-table table">
        </table>
    </div>
</div>

@endsection

@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    "use strict";
    $((function() {
        var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>`;
        let account = {!! json_encode(session('data')) !!}

        let buttonAdd = [];
        if (account.level.id == '10') {
            buttonAdd =[{
                text: '<i class="ti ti-plus me-md-1"></i><span class="d-md-inline-block d-none">Buat Ticket</span>',
                className: "btn btn-primary",
                action: function(a, e, t, s) {
                    window.location = "{{url('complain/add-ticket')}}"
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
                url: "{{ env('BASE_URL_API')}}" +'/api/ticket/report',
                type: "GET",
                dataType: "json",
                success: function(res) {
                    $('.count_tenant').html(res.count_tenant);
                    $('.count_ticket').html(res.count_ticket);
                    Swal.close();
                },
                error: function(errors) {
                    console.log(errors);
                }
            });
        }
        var a = $(".ticket-list-table");
        
        var e = a.DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: {
                url: "{{ url('complain/data-ticket') }}",
                "data": function(d) {
                    d.start = 0;
                    d.page = $(".ticket-list-table").DataTable().page.info().page + 1;
                }
            },
            columns: [{
                name: "ticket_number",
                data: "ticket_number",
                title: "No. Ticket",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            },
            {
                name: "tenant",
                data: "tenant",
                title: "Perusahaan",
                className: 'text-center',
                render: function(data, type, row) {
                    if(data != null){
                        return data?.company;
                    }else{
                        return '';
                    }
                }
            },
            {
                name: "reporter_name",
                data: "reporter_name",
                title: "Nama Pelapor",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, {
                name: "ticket_title",
                data: "ticket_title",
                title: "Judul Laporan",
                className: 'text-center',
                render: function(data, type, row) {
                    return data;
                }
            }, 
            {
                name: "status",
                data: "status",
                title: "Status",
                className: 'text-center',
                render: function(data, type, row) {
                    if (data == 'Wait a response') {
                        return '<span class="w-100 badge" style="background-color : #BFBFBF; " text-capitalized> Wait a response </span>';
                    } else if (data == 'On progress') {
                        return '<span class="w-100 badge" style="background-color : #4EC0D9; " text-capitalized> On progress </span>';
                    } else if (data == 'Selesai') {
                        return '<span class="w-100 badge" style="background-color : #74D94E; " text-capitalized> Selesai </span>';
                    } else if (data == 'Terkirim') {
                        return '<span class="w-100 badge" style="background-color : #FF87A7; " text-capitalized> Terkirim </span>';
                    } else if (data == 'Disetujui BM') {
                        return '<span class="badge w-100" style="background-color : #4E6DD9; " text-capitalized> Disetujui BM </span>';
                    }
                }
            },
            {
                data: "id",
                name: "tanggapan",
                title: "Action",
                render: function(data, type, row) {
                    let editAndDelete = '';
                    let previewRow = '<a href="{{ url("complain/show-ticket")}}/' + data + '" data-bs-toggle="tooltip" class="text-body" data-bs-placement="top" title="Preview Ticket"><i class="ti ti-eye mx-2 ti-sm"></i></a>';
                    if(account.level.id == 10){
                        editAndDelete = `<a href="javascript:;" class="btn dropdown-toggle hide-arrow text-body p-0" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm"></i></a><div class="dropdown-menu dropdown-menu-end"><a href="{{ url("complain/edit-ticket")}}/` + data + `" class="dropdown-item">Edit</a>
                        <div class="dropdown-divider"></div><a href="#" data-id="`+data+`" class="dropdown-item delete-record text-danger">Delete</a></div></div>`;
                    }
                    return `<div class="d-flex align-items-center">
                            ` + previewRow + `
                            <div class="dropdown">` + editAndDelete +`</div>`;
                }
            }],
            order: [
                [0, "0"]
            ],
            dom: '<"row mx-1"<"col-12 col-md-6 d-flex align-items-center justify-content-center justify-content-md-start gap-2"l<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start mt-md-0 mt-3"B>><"col-12 col-md-6 d-flex align-items-center justify-content-end flex-column flex-md-row pe-3 gap-md-3"f<"invoice_status mb-3 mb-md-0">>>t<"row mx-2"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            language: {
                sLengthMenu: "Show _MENU_",
                search: "",
                searchPlaceholder: "Search Ticket"
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
                this.api().columns(1).every((function() {
                    var a = this,
                        e = $(
                            '<select id="status" class="form-select"><option value=""> Select Status </option></select>'
                        ).appendTo(".invoice_status").on("change");
                            var optionsHtml =   '<option value="on progress">On Progress</option>' +
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
        })), $(".invoice-list-table tbody").on("click", ".delete-record", (function() {
            e.row($(this).parents("tr")).remove().draw()
        })), setTimeout((() => {
            $(".dataTables_filter .form-control").removeClass("form-control-sm"), $(
                ".dataTables_length .form-select").removeClass("form-select-sm")
        }), 300)

        $(document).on('change', '#status', function(x) {
            x.stopPropagation();
            e.ajax.url("{{ url('complain/data-ticket') }}"+"?status="+$(this).val()).load(); // Memuat ulang data DataTable
        });

        $(document).on("click", ".delete-record", function(e) {
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
                    Swal.fire({
                        title: 'Memeriksa...',
                        text: "Harap menunggu",
                        html: sweet_loader + '<h5>Please Wait</h5>',
                        showConfirmButton: false,
                        allowOutsideClick: false
                    });
                    $.ajax({
                        url: "{{ env('BASE_URL_API')}}" + '/api/ticket/'+id,
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
                                $('.ticket-list-table').DataTable().ajax.reload();
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