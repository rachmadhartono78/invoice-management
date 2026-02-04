@php
$configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')


@section('page-style')
<link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/swiper/swiper.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/cards-advance.css')}}">
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/app-logistics-dashboard.css')}}" />
<link rel="stylesheet" href="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.css')}}">
@endsection

@section('content')

<div class="container-xxl flex-grow-1">
    <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="#">Home</a>
                </li>
            </ol>
        </nav>

        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#filter-form">Filter</button>
    </div>

    <div class="row mb-4">
        <span class="fs-3 mb-3"><span id="start_date_label"></span> - <span id="end_date_label"></span></span>
        <!-- Earning Reports -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header pb-0 d-flex justify-content-between mb-lg-n4">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Laporan Pendapatan</h5>
                        <small class="text-muted">Ringkasan Bulanan</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="earningReportsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsId">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 d-flex flex-column align-self-end">
                            <div class="d-flex gap-2 align-items-center mb-2 pb-1 flex-wrap">
                                <span class="mb-0 fs-5" id="sum_invoice_per_month">0</span>
                            </div>
                            <small>Pendapatan bulan ini</small>
                        </div>
                        <div class="col-12 col-md-8">
                            <div id="weeklyEarningReports"></div>
                        </div>
                    </div>
                    <div class="border rounded p-3 mt-4">
                        <div class="row gap-4 gap-sm-0">
                            <div class="col-12 col-sm-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="badge rounded bg-label-primary p-1"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                    <h6 class="mb-0">Total Tagihan Invoice</h6>
                                </div>
                                <h4 class="my-2 pt-1" id="count_invoices">0</h4>
                                <div class="progress w-75" style="height:4px">
                                    <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                                    <h6 class="mb-4">Total Invoice Dibayarkan <br></h6>
                                </div>
                                <h4 class="my-2 pt-1" id="count_invoices_not_paid">0</h4>
                                <div class="progress w-75" style="height:4px">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="badge rounded bg-label-danger p-1"><i class="ti ti-brand-paypal ti-sm"></i></div>
                                    <h6 class="mb-0">Total Invoice Belum Dibayarkan</h6>
                                </div>
                                <h4 class="my-2 pt-1" id="count_invoices_not_paid">0</h4>
                                <div class="progress w-75" style="height:4px">
                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Earning Reports -->

        <!-- Support Tracker -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="mb-0">Ticket Complain</h5>
                        <small class="text-muted">30 Hari Terakhir</small>
                    </div>
                    <!-- <div class="dropdown">
                        <button class="btn p-0" type="button" id="supportTrackerMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti ti-dots-vertical ti-sm text-muted"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="supportTrackerMenu">
                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                        </div>
                    </div> -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-4 col-md-12 col-lg-4">
                            <div class="mt-lg-4 mt-lg-2 mb-lg-4 mb-2 pt-1">
                                <h1 class="mb-0" id="count_tickets"></h1>
                                <p class="mb-0">Total Ticket</p>
                            </div>
                            <ul class="p-0 m-0">
                                <li class="d-flex gap-3 align-items-center mb-lg-3 pb-1">
                                    <div class="badge rounded bg-label-info p-1"><i class="ti ti-circle-check ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Ticket Selesai</h6>
                                        <small class="text-muted" id="count_completed_tickets">0</small>
                                    </div>
                                </li>
                                <li class="d-flex gap-3 align-items-center pb-1">
                                    <div class="badge rounded bg-label-warning p-1"><i class="ti ti-clock ti-sm"></i></div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Ticket On Proses</h6>
                                        <small class="text-muted" id="count_tickets_waiting_for_response">0</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-sm-8 col-md-12 col-lg-8">
                            <div id="supportTracker"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Support Tracker -->
        <!-- Statistics -->
        <div class="col-xl-12 mb-4 col-lg-12 col-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between mb-3">
                        <h5 class="card-title mb-0">Statistics</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0" id="count_work_orders">0</h5>
                                    <small>Work Order</small>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0" id="count_material_requests">0</h5>
                                    <small>Material Request</small>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0" id="count_purchase_requests">0</h5>
                                    <small>Purchase Request</small>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0" id="count_purchase_orders">0</h5>
                                    <small>Purchase Order</small>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-secondary me-3 p-2"><i class="ti ti-credit-card ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0" id="count_vendor_invoice">0</h5>
                                    <small>Tag Vendor</small>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-warning me-3 p-2"><i class="ti ti-browser-check ti-sm"></i></div>
                                <div class="card-info">
                                    <h5 class="mb-0" id="remaining_stamp">0</h5>
                                    <small>Materai</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Statistics -->

        <!-- View sales -->

    </div>

    <div class="modal fade" id="filter-form" data-bs-backdrop="static">
        <div class="modal-dialog">
            <form class="modal-content filter-submit" id=" filter-submit" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="backDropModalTitle">Filter Option</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="mb-3">
                            <label for="nameBackdrop" class="form-label">Tanggal Awal</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ date('Y-m-01')}}">
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                        <div class="mb-3">
                            <label for="nameBackdrop" class="form-label">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ date('Y-m-t') }}">
                            <div class="invalid-feedback">Tidak boleh kosong</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal" id="modal_bank_cancel">Reset</button>
                    <button type="submit" class="btn btn-primary apply">
                        Apply
                    </button>

                </div>
            </form>
        </div>
    </div>
    @endsection

    @section('page-script')
    <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/swiper/swiper.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/sweetalert2/sweetalert2.js')}}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Theme JS-->
    <script>
        var sweet_loader = `<div class="spinner-border mb-8 text-primary" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>`;
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let params_date = `?start=${start_date}&end=${end_date}`;
        let completeTicket = 0;
        let chart = null;
        load(params_date);


        function load(params_date) {
            Swal.fire({
                title: '<h2>Loading...</h2>',
                html: sweet_loader + '<h5>Please Wait</h5>',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });
            $.ajax({
                url: "{{ env('BASE_URL_API')}}" + '/api/report/dashboard' + params_date,
                // url: "http://127.0.0.1:8000" + '/api/report/dashboard' + params_date,
                type: "get",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function(response) {
                    console.log(response.income_report);
                    let income_report = response.income_report;
                    let remaining_stamp = response.remaining_stamp;
                    let statistic = response.statistic;
                    let ticket_complain = response.ticket_complain;
                    let sum_invoice_per_month = 0;
                    if(response.income_report.sum_invoice_per_month.length > 0){
                        sum_invoice_per_month = response.income_report.sum_invoice_per_month[0].total_amount;
                    }

                    $('#count_invoices').text(income_report.count_invoices);
                    $('#count_invoices_not_paid').text(income_report.count_invoices_not_paid);
                    $('#count_invoices_paid').text(income_report.count_invoices_paid);
                    $('#sum_invoice_per_month').text(formatRupiah(sum_invoice_per_month, 'Rp. '));

                    $('#count_material_requests').text(statistic.count_material_requests);
                    $('#count_purchase_orders').text(statistic.count_purchase_orders);
                    $('#count_purchase_requests').text(statistic.count_purchase_requests);
                    $('#count_vendor_invoice').text(statistic.count_vendor_invoice);
                    $('#count_work_orders').text(statistic.count_work_orders);
                    $('#remaining_stamp').text(remaining_stamp);

                    $('#count_completed_tickets').text(ticket_complain.count_completed_tickets);
                    $('#count_tickets').text(ticket_complain.count_tickets);
                    $('#count_tickets_waiting_for_response').text(ticket_complain.count_tickets_waiting_for_response);

                    let start_date_label = new Date(start_date);
                    let end_date_label = new Date(end_date);
                    $('#start_date_label').text(start_date_label.toLocaleDateString('id-ID'));
                    $('#end_date_label').text(end_date_label.toLocaleDateString('id-ID'));
                    completeTicket = isNaN(parseInt(ticket_complain.count_completed_tickets) / parseInt(ticket_complain.count_tickets) * 100) ? 0 : parseInt(ticket_complain.count_completed_tickets) / parseInt(ticket_complain.count_tickets) * 100;
                    weeklyEarningReports(response.diagramInvoice);
                    supportTracker(completeTicket);
                    $("#filter-form").modal('hide');
                    Swal.close();
                }
            });


        };

        function formatRupiah(angka, prefix) {
            if(angka === 0){
                return 'Rp. 0';
            }
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $(document).on('click', '.apply', function(e) {
            e.preventDefault();
            let start = $('#start_date').val();
            let end = $('#end_date').val();
            let params = `?start=${start}&end=${end}`;
            if (start === '' || end === '') {
                // Tampilkan pesan validasi Bootstrap jika tanggal kosong
                if (start === '') {
                    $("#start_date").addClass("is-invalid");
                } else {
                    $("#start_date").removeClass("is-invalid");
                }

                if (end === '') {
                    $("#end_date").addClass("is-invalid");
                } else {
                    $("#end_date").removeClass("is-invalid");
                }
            } else {
                $("#start_date").removeClass("is-invalid");
                $("#end_date").removeClass("is-invalid");
                load(params)
            }

        });

        function weeklyEarningReports(data) {
            let a = config.colors.textMuted;
            var options = {
                chart: {
                    height: 202,
                    parentHeightOffset: 0,
                    type: "bar",
                    toolbar: {
                        show: !1
                    }
                },
                plotOptions: {
                    bar: {
                        barHeight: "60%",
                        columnWidth: "38%",
                        startingShape: "rounded",
                        endingShape: "rounded",
                        borderRadius: 4,
                        distributed: !0
                    }
                },
                grid: {
                    show: !1,
                    padding: {
                        top: -30,
                        bottom: 0,
                        left: -10,
                        right: -10
                    }
                },
                colors: [config.colors_label.primary, config.colors_label.primary, config.colors_label.primary, config.colors_label.primary, config.colors.primary, config.colors_label.primary, config.colors_label.primary],
                dataLabels: {
                    enabled: !1
                },
                series: [{
                    data: [data[0].data, data[1].data, data[2].data, data[3].data, data[4].data, data[5].data, data[6].data]
                }],
                legend: {
                    show: !1
                },
                xaxis: {
                    categories: [data[0].day, data[1].day, data[2].day, data[3].day, data[4].day, data[5].day, data[6].day],
                    axisBorder: {
                        show: !1
                    },
                    axisTicks: {
                        show: !1
                    },
                    labels: {
                        style: {
                            colors: a,
                            fontSize: "13px",
                            fontFamily: "Public Sans"
                        }
                    }
                },
                yaxis: {
                    labels: {
                        show: !1
                    }
                },
                tooltip: {
                    enabled: !1
                },
                responsive: [{
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 199
                        }
                    }
                }]
            }

            var chart = new ApexCharts(document.querySelector("#weeklyEarningReports"), options);
            chart.render();
        }

        function supportTracker(val) {
            $('#supportTracker').html('');
            let e = config.colors.cardColor;
            let a = config.colors.textMuted;
            let t = config.colors.headingColor;
            var options = {
                series: [val],
                labels: ["Completed Task"],
                chart: {
                    height: 360,
                    type: "radialBar"
                },
                plotOptions: {
                    radialBar: {
                        offsetY: 10,
                        startAngle: -140,
                        endAngle: 130,
                        hollow: {
                            size: "65%"
                        },
                        track: {
                            background: e,
                            strokeWidth: "100%"
                        },
                        dataLabels: {
                            name: {
                                offsetY: -20,
                                color: a,
                                fontSize: "13px",
                                fontWeight: "400",
                                fontFamily: "Public Sans"
                            },
                            value: {
                                offsetY: 10,
                                color: t,
                                fontSize: "38px",
                                fontWeight: "500",
                                fontFamily: "Public Sans"
                            }
                        }
                    }
                },
                colors: [config.colors.primary],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        shadeIntensity: .5,
                        gradientToColors: [config.colors.primary],
                        inverseColors: !0,
                        opacityFrom: 1,
                        opacityTo: .6,
                        stops: [30, 70, 100]
                    }
                },
                stroke: {
                    dashArray: 10
                },
                grid: {
                    padding: {
                        top: -20,
                        bottom: 5
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: "none"
                        }
                    },
                    active: {
                        filter: {
                            type: "none"
                        }
                    }
                },
                responsive: [{
                    breakpoint: 1025,
                    options: {
                        chart: {
                            height: 330
                        }
                    }
                }, {
                    breakpoint: 769,
                    options: {
                        chart: {
                            height: 280
                        }
                    }
                }]
            }
            chart = new ApexCharts(document.querySelector("#supportTracker"), options);
            chart.render();
        }

        function supportTrackerApply(val) {
            chart.updateSeries([val]);
        }
    
    </script>


    @endsection