@php
function rupiah($angka)
{
$hasil_rupiah = 'Rp ' . number_format($angka, 2, ',', '.');
return $hasil_rupiah;
}
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Purchase Request</title>
    <link href="{{ public_path('assets/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    {{-- <script src="{{ public_path('assets/js/html2pdf.bundle.js') }}"></script> --}}

    <style>
        body {
            font-size: 12px;
            font-family: sans-serif;
        }

        .main-table,
        .main-table th,
        .main-table td {
            border: 1px solid;
        }


        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: #fff;
        }

        /* A4 Styles */
        @media print {
            body {
                font-size: 12px;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 21cm;
                min-height: 29.7cm;
                margin: auto;
                /* Center content on the page */
            }

            .ttd img {
                width: 130px;
            }

            .row img {
                width: 180px;
            }
        }
    </style>
</head>

<body>
    <div class="container" id="printContent">
        <header>
            <img src="{{ public_path('assets/img/header.png') }}" alt="kop surat" width="100%">
        </header>
        <div class="row">
            <h1 style="margin-bottom: -70px;"><center><b><u><h5>PURCHASE REQUEST</h5></u></b></center>
            </h1>
            <h1>
                <center><h6 style="line-height: 0.1;font-weight:100">PERMINTAAN PEMEBELIAN</h6></center>
            </h1>
        </div>

        <div class="row mt-1">
            <table style="width: 100%; border-collapse: collapse">
                <tr>
                    <td style="border: 1px solid black; padding:10px;">Yang Meminta : {{ $data->requester }}</td>
                    <td style="border: 1px solid black; padding:10px;">Nomor PR : {{$data->purchase_request_number}}</td>
                    <td style="border: 1px solid black; padding:10px;">Tanggal : {{ date('d F Y',strtotime($data->request_date)) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding:10px;">Departmen : {{ $data->department->name }}</td>
                    <td style="border: 1px solid black; padding:10px;">Nomor MR : {{$data->material_request->material_request_number}}</td>
                    <td style="border: 1px solid black; padding:10px;">Tanggal : {{ date('d F Y', strtotime($data->created_at))}}</td>
                </tr>
            </table>
        </div>
        <div class="row mt-3">
            <table style="width: 100%; border-collapse: collapse">
                <tr>
                    <td style="padding : 10px" class="py-1">
                        <div class="">
                            @if ($data->budget_status == 'sesuai-budget')
                            <input type="checkbox" style="margin-right: 10px;" id="sesuai_budget" name="sesuai_budget" value="Sesuai Budget" checked>
                            <label for="sesuai_budget">Sesuai Budget</label><br>
                            @else
                            <input type="checkbox" style="margin-right: 10px;" id="sesuai_budget" name="sesuai_budget" value="Sesuai Budget">
                            <label for="sesuai_budget">Sesuai Budget</label><br>
                            @endif
                        </div>
                    </td>
                    <td style="padding : 10px" class="py-1">
                        <div class="">
                            @if ($data->budget_status == 'diluar-budget')
                            <input type="checkbox" style="margin-right: 10px;" id="diluar-budget" name="diluar-budget" value="Diluar Budget" checked>
                            <label for="diluar-budget">Diluar Budget</label><br>
                            @else
                            <input type="checkbox" style="margin-right: 10px;" id="diluar-budget" name="diluar-budget" value="Diluar Budget">
                            <label for="diluar-budget">Diluar Budget</label><br>
                            @endif
                        </div>
                    </td>
                    <td style="padding : 10px" class="py-1">
                        <div class="">
                            @if ($data->budget_status == 'penting')
                            <input type="checkbox" style="margin-right: 10px;" id="penting" name="penting" value="Penting">
                            <label for="penting">Penting</label><br>
                            @else
                            <input type="checkbox" style="margin-right: 10px;" id="penting" name="penting" value="Penting">
                            <label for="penting">Penting</label><br>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="row">
            <table style="width: 100%; border-collapse: collapse">
                <tr>
                    <td style="width: 110px;border: 1px solid black; padding:10px;">Jumlah Anggaran :</td>
                    <td style="width: 110px;border: 1px solid black; padding:10px;">Rp. {{ number_format($data->total_budget)}}</td>
                    <td style="width: 10px;" rowspan="3"></td>
                    <td style="border: 1px solid black; padding:10px; vertical-align: top; width:300px" rowspan="3">{{ $data->additional_note }}</td>
                    <td style="width: 10px;" rowspan="3"></td>
                    <td rowspan="3">
                        <div class="">
                            @if ($data->budget_status == '1-minggu')
                            <input type="checkbox" style="margin-right: 5px;" id="satu_minggu" name="satu_minggu" value="Bike" checked>
                            <label for="satu_minggu">1 minggu</label><br>
                            @else
                            <input type="checkbox" style="margin-right: 5px;" id="satu_minggu" name="satu_minggu" value="Bike">
                            <label for="satu_minggu">1 minggu</label><br>
                            @endif
                        </div>
                        <div class="">
                            @if ($data->budget_status == '1-bulan')
                            <input type="checkbox" style="margin-right: 5px;" id="1-bulan" name="1-bulan" value="Bike" checked>
                            <label for="1-bulan">1 bulan</label><br>
                            @else
                            <input type="checkbox" style="margin-right: 5px;" id="1-bulan" name="1-bulan" value="Bike">
                            <label for="1-bulan">1 bulan</label><br>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="width: 110px;border: 1px solid black; padding:10px;">Usulan Pembelian :</td>
                    <td style="width: 110px;border: 1px solid black; padding:10px;">Rp. {{ number_format($data->proposed_purchase_price)}}</td>
                </tr>
                <tr>
                    <td style="width: 110px;border: 1px solid black; padding:10px;">Sisa Anggaran :</td>
                    <td style="width: 110px;border: 1px solid black; padding:10px;">Rp.{{ number_format($data->remaining_budget)}}</td>
                </tr>
            </table>
        </div>
        <div class="row mt-3" style="margin-top:15px">
            <table style="width: 100%; border-collapse: collapse">
                <thead>
                    <tr>
                        <td rowspan="2" style="border: 1px solid black; text-align:center; padding:10px;">
                            No
                        </td>
                        <td rowspan="2" style="border: 1px solid black; text-align:center; padding:10px">
                           Suku Cadang
                        </td>
                        <td colspan="3" style="border: 1px solid black; text-align:center; padding:10px">Pembelian Terakhir</td>
                        <td rowspan="2" style="border: 1px solid black; text-align:center; padding:10px">
                            Keterangan
                        </td>
                        <td rowspan="2" style="border: 1px solid black; text-align:center; padding:10px">
                            Kuantitas
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align:center; padding:10px">Tanggal</td>
                        <td style="border: 1px solid black; text-align:center; padding:10px">Kuantitas</td>
                        <td style="border: 1px solid black; text-align:center; padding:10px">Persediaan</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->purchase_request_details as $item)
                    <tr>
                        <td style="border: 1px solid black; padding:10px;" class="text-center">{{ $item->number }}</td>
                        <td style="border: 1px solid black; text-align:center">{{ $item->part_number }}</td>
                        <td style="border: 1px solid black; text-align:center">{{ date('d F Y', strtotime($item->last_buy_date)) }}</td>
                        <td style="border: 1px solid black; text-align:center">{{ $item->last_buy_quantity }}</td>
                        <td style="border: 1px solid black; text-align:center">{{ $item->last_buy_stock }}</td>
                        <td style="border: 1px solid black; text-align:center">{{ $item->description }}</td>
                        <td style="border: 1px solid black; text-align:center">{{ $item->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-3" style="margin-top: 15px">
            <table style="width: 100%; border-collapse: collapse">
                <tr>
                    <td style="border: 1px solid black; text-align:center">Diproses Oleh :</td>
                    <td style="border: 1px solid black; text-align:center">Diperiksa Oleh :</td>
                    <td style="border: 1px solid black; text-align:center">Diketahui Oleh :</td>
                </tr>
                <tr>
                    <td style=" border: 1px solid black;" class="">
                        <div style="margin : auto;
                                    background-image : url({{$data->purchase_request_signatures[0]->signature}});
                                    height: 150px;
                                    width: 150px;
                                    background-position: center center;
                                    background-size: contain;
                                    background-repeat: no-repeat;">
                        </div>
                    </td>
                    <td style=" border: 1px solid black;">
                        @if(isset($data->purchase_request_signatures[1]->signature))
                        <div style="margin : auto;
                                    background-image : url({{$data->purchase_request_signatures[1]->signature}});
                                    height: 150px;
                                    width: 150px;
                                    background-position: center center;
                                    background-size: contain;
                                    background-repeat: no-repeat;">
                        </div>
                        @else
                        <div style="margin : auto;
                                    background-image : url();
                                    height: 150px;
                                    width: 150px;
                                    background-position: center center;
                                    background-size: contain;
                                    background-repeat: no-repeat;">
                        </div>
                        @endif
                    </td>
                    <td style=" border: 1px solid black;">
                        @if(isset($data->purchase_request_signatures[2]->signature))
                        <div style="margin : auto;
                                    background-image : url({{$data->purchase_request_signatures[2]->signature}});
                                    height: 150px;
                                    width: 150px;
                                    background-position: center center;
                                    background-size: contain;
                                    background-repeat: no-repeat;">
                        </div>
                        @else
                        <div style="margin : auto;
                                    background-image : url();
                                    height: 150px;
                                    width: 150px;
                                    background-position: center center;
                                    background-size: contain;
                                    background-repeat: no-repeat;">
                        </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <div class="row mt-3">
            <table class="table">
                <tr>
                    <td style="width: 80px;">Lembar ke 1 : </td>
                    <td>Adminstrasi </td>
                </tr>
                <tr>
                    <td>Lembar ke 2 : </td>
                    <td>Gudang </td>
                </tr>
               
            </table>
        </div>
    </div>
</body>

</html>