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
    <title>Invoice</title>

    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" media="">


    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <style>
        body {
            font-size: 10pt;
        }

        .main-table,
        .main-table th,
        .main-table td {
            border: 0.5px solid;
        }

        .main-table th {
            font-size: 12pt;
        }

        .container {
            margin-left: auto;
            margin-right: auto;
            width: 100%;
            padding-left: 15px;
            padding-right: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .p-2 {
            padding: 0.5rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .mt-2 {
            margin-top: 0.5rem !important;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
        }
    </style>
</head>

<body>
    <div class="container" id="printContent">
        <header>
            <img src="https://pppgsi.com/assets/img/header.png" alt="kop surat" width="100%">
        </header>

        <div class="row" style="float: right;">
            <div class="p-2" style="width: 100px; border: 1px solid black;">No. 00722</div>
        </div>
        <div style="clear: both;"></div>

        <div class="row text-center">
            <div class="col-12">
                <h4>TANDA TERIMA PEMBAYARAN</b><br>
            </div>

        </div>

        <p style="margin: 0px;">Telah terima Pembayaran tunai/Cek/Giro</p>
        <div class="row" style="width: 600px;">
            <table class="table mt-2" style="width:100%; border-collapse:separate; border-spacing: 0 3px;">
                <tbody class="mt-2" style=" text-align: left;">
                    <tr>
                        <td style="width: 20%;">No. Cek/Giro</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 25%;"></td>
                        <td style="width: 17%;">Nama</td>
                        <td style="width: 5%;">:</td>
                        <td class="width: 25%;">PT. ELV Engineering Indonesia</td>
                    </tr>
                    <tr>
                        <td>Bank</td>
                        <td>:</td>
                        <td></td>
                        <td>Alamat</td>
                        <td>:</td>
                        <td> Gd. Graha Surveyor Indonesia LL 12 J. Gatot Subroto Kar. 56
                            Jakarta Selatan</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>:</td>
                        <td>Rp 3.395.000,-</td>
                        <td>Telepon</td>
                        <td>:</td>
                        <td>0813434344</td>
                    </tr>
                </tbody>
            </table>
        </div>



        <div class="row">
            <div class="col-4">
                <div style="border: 1px solid black;" class="p-2">
                    Tiga juta tiga ratus sembilan puluh lima rupia
                </div>
                <p>
                    Apabila dibayar dengan cek/Biyet giro, Pembayaran baru
                    dianggap sah apabila telah dapat dicairkan di Bank kami.
                </p>

            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <br>
                <br>
                <div class="ttd" style="width: max-content; float: right;">

                    <p style="display: block; text-align: center; padding: 0; margin: 0;">Jakarta, 12 Januari 2024<br>
                        <img src="" alt="">
                    <p class="text-center">
                        <u></u></b><br><span>Building Manager</span>
                    </p>
                    </p>

                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>


</body>

</html>