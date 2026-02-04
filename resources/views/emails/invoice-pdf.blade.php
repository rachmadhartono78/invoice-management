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
    <link href="{{asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
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

        <div class="row mt-4">
            <table class="table">
                <tbody>
                    <tr>
                        <td rowspan="3" style="border: none; width: 100px;"><b>Kepada
                                Yth:
                            </b></td>
                        <td rowspan="3" style="border: 0.5px solid black;"><b>
                                {{ $data->tenant->company ?? '' }} <br>
                                {{ $data->tenant->floor ?? '' }} <br>
                                <br>
                                Up. {{ $data->tenant->name ?? ''}}</b></td>
                        <td style="width: 120px; border: none;"></td>
                        <td style="border: 0.5px solid black;">No. Invoice:
                            <br>{{ $data->invoice_number }}
                        </td>
                        <td style="border: 0.5px solid black;">Tanggal: <br>
                            {{ date('d F Y', strtotime($data->invoice_date)) }}
                        </td>
                    </tr>
                    <tr>

                        <td style="width: 120px; border: none;"></td>
                        <td style="border: 0.5px solid black;">No. Kontrak:
                            <br> {{ $data->contract_number }}
                        </td>
                        <td style="border: 0.5px solid black;">Tanggal: <br> {{ date('d F Y', strtotime($data->contract_date)) }}
                        </td>
                    </tr>
                    <tr>

                        <td style="width: 120px; border: none;"></td>
                        <td style="border: 0.5px solid black;">No. Addendum:
                            <br> {{ $data->addendum_number }}
                        </td>
                        <td style="border: 0.5px solid black;">Tanggal: <br>{{ date('d F Y', strtotime($data->addendum_date)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <table class="table main-table">
                <thead>
                    <tr>
                        <th>URAIAN</th>
                        <th>Keterangan</th>
                        <th>Dasar Pengenaan Pajak</th>
                        <th>Pajak</th>
                        <th>TOTAL (Rp.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->invoice_details as $p)
                    <tr>
                        <td>{{ $p->item }}</td>
                        <td>{{ $p->description }}</td>
                        <td>{{ rupiah($p->price) }}</td>
                        <td>{{ $p->tax->rate }}%</td>
                        <td>{{ rupiah($p->total_price) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="4"><b>Total :</b>
                        </td>
                        <td>{{ rupiah($data->grand_total) }}</td>
                    </tr>
                    <tr>
                        <td colspan="5"><b>Terbilang: {{ $data->grand_total_spelled }}</b></td>
                    </tr>
                </tfoot>
            </table>
            <p>Jatuh Tempo Tgl : {{ date('d F Y', strtotime($data->invoice_due_date)) }}</p><br>
            <p>Keterangan : {{ $data->term_and_conditions }}</p><br>
            <p></p>
        </div>
        <div class="row">
            <div class="col-4" style="border: 1px solid black;">
                Pembayaran dengan Cek/Bilyet/Transfer atas nama: <br />
                {{ $data->bank->account_name }} <br />
                {{ $data->bank->name }} <br />
                CABANG {{ $data->bank->branch_name }} <br />
                Account No. : {{ $data->bank->account_number }}
            </div>
            <div class="col-4"></div>
            <div class="col-4">
                <br>
                <br>
                <div class="ttd" style="width: max-content; float: right;">

                    <p style="display: block; text-align: center; padding: 0; margin: 0;">Jakarta,
                        {{ $data->materai_date ? date('d F Y', strtotime($data->materai_date)) : '' }}<br>
                        <img src="{{ $data->materai_image }}" alt="">
                    <p class="text-center">
                        <u>{{ $data->materai_name }}</u></b><br><span>Ka.
                            BM</span>
                    </p>
                    </p>

                </div>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div class="row mt-4 text-center" style="font-size: 12pt;">
            <center>
                <p>

                    <b><strong>GRAHA SURVEYOR INDONESIA</strong>, Basement
                        2,
                        Jl. Jenderal
                        Gatot
                        Subroto Kav. 56 Jakarta 12950 Indonesia
                        Telephone: (021) 5265388, 5265393, 5265114 Fax:
                        (021)
                        5265239</b>
                </p>
            </center>
        </div>
    </div>



</body>

</html>