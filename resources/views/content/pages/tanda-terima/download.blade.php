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
    <title>Tanda Terima</title>
    <link href="{{ public_path('assets/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    {{-- <script src="{{ public_path('assets/js/html2pdf.bundle.js') }}"></script> --}}


    <style>
        body {
            font-size: 15px;

        }

        .main-table,
        .main-table th,
        .main-table td {
            border: 0.5px solid;
        }


        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: #fff;
            padding: 1cm;

        }

        /* A4 Styles */
        @media print {
            body {
                font-size: 10px;
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

        <div class="row" style="float: right;">
            <div class="p-2" style="width: 100px; border: 1px solid black;">No . {{$data->receipt_number}}</div>
        </div>
        <div style="clear: both;"></div>

        <div class="row">
            <center><b>TANDA TERIMA PEMBAYARAN</b></center><br>
        </div>

        <p style="margin: 0px;">Telah terima Pembayaran tunai/Cek/Giro</p>
        <div class="row">
            <table class="table mt-2" style="width:100%; border-collapse:separate; border-spacing: 0 3px;">
                <tbody class="mt-2" style=" text-align: left;">
                    <tr>
                        <td style="width: 20%;">No. Cek/Giro</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 25%;">{{$data->check_number}}</td>
                        <td style="width: 17%;">Nama</td>
                        <td style="width: 5%;">:</td>
                        <td class="width: 25%;">{{$data->tenant->name ?? ''}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td> {{ $data->tenant->company ?? '' }} {{ $data->tenant->floor ?? '' }} {{ $data->tenant->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>{{rupiah($data->grand_total)}}</td>
                        <td>Telepon</td>
                        <td>:</td>
                        <td>{{$data->tenant->phone ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td colspan="4"> {{$data->grand_total_spelled}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- <div class="row">
            <div class="col-6">
                <div class="row">
                    <div>No. Cek/Giro</div>
                    <div>{{$data->check_number}}</div>
                </div>
            </div>
            <div class="col-6">
                <div class="row">
                    <div class="">Nama</div>
                    <div class="">:</div>
                    <div class=""></div>
                </div>
            </div>
        </div> -->

        <div class="row" style="margin-top:30px">
            <table style="vertical-align: top; border-color: white;">
                <tr>
                    <td>
                        <div style="border: 1px solid black; height : 155px; padding:10px; width:350px">
                            <p class="line-height: 2;">
                                Inv. No. : {{ $data->invoice->invoice_number }}
                            </p>

                        </div>
                        <p>
                        <br>
                            Apabila dibayar dengan cek/Biyet giro, Pembayaran baru
                            dianggap sah apabila telah dapat dicairkan di Bank kami.
                        </p>
                    </td>
                    <td>
                        <div class="ttd" style="width: 250px; float: right;margin-top:10px">
                            <p style="display: block; text-align: center; padding: 0; margin: 0;">Jakarta,
                                {{ $data->signature_date ? date('d F Y', strtotime($data->signature_date)) : '' }}<br><br>
                                <img src="{{ $data->signature_image }}" width="100px">
                            <p class="text-center" style="text-align:center;">
                                <u>{{ $data->signature_name }}</u></b><br><span>Building Manager</span>
                            </p>
                            </p>

                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>