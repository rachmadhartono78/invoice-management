<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Pesan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <style>
        body {
            font-size: 12px;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: #fff;
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

        .ta td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <div class="container" id="printContent">
        <header>
            <img src="{{ public_path('assets/img/header 1.png') }}" alt="kop surat" width="100%">
        </header>

        <div class="row mt-3">
            <table class="table" style="width:100%;">
                <tr>
                    <td style="width: 60px;">No</td>
                    <td>:</td>
                    <td>{{ $data->purchase_order_number }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ $data->purchase_order_date }}</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>:</td>
                    <td>{{ $data->about }}</td>
                </tr>
            </table>
        </div>

        <div class="row mt-3">
            <table class="table" style="width:100%;">
                <tr>
                    <td>Kepada Yth :</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">{{ $data->vendor->name}}</td>
                </tr>
                <tr>
                    <td>{!! nl2br(e($data->vendor->address)) !!} </td>
                </tr>
                <tr>
                    <td>{{ $data->vendor->phone }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">Up Ibu/Bpk {{ $data->vendor->pic }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Dengan Hormat,</td>
                </tr>
                <tr>
                    <td>Sehubungan dengan hasil negosiasi perihal pengadaan {{ $data->about }}, maka dengan ini kami mengajukan nama barang sbb :</td>
                </tr>
            </table>
        </div>

        <div class="row mt-3">
            <table class="ta " style="width: 100%;">
                <thead>
                    <tr>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">No</td>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">NAMA BARANG</td>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">SPESIFIKASI</td>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">QTY</td>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">SAT</td>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">HARGA / SAT Rp.</td>
                        <td style="text-align:center; padding:10px;border: 1px solid black;">JUMLAH Rp.</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid black;" class="text-center"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    @foreach ($data->purchase_order_details as $item)
                    <tr>
                        <td style="border: 1px solid black; text-align:center; padding:10px;" class="text-center">{{$item->number}}</td>
                        <td style="border: 1px solid black; text-align:center;">{{$item->name}}</td>
                        <td style="border: 1px solid black; text-align:center;">{{$item->specification}}</td>
                        <td style="border: 1px solid black; text-align:center;">{{$item->quantity}}</td>
                        <td style="border: 1px solid black; text-align:center;">{{$item->units}}</td>
                        <td style="border: 1px solid black; text-align:center;">Rp. {{ number_format($item->price)}}</td>
                        <td style="border: 1px solid black; text-align:center;">Rp. {{ number_format($item->price * $item->quantity )}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6" style="border: 1px solid black; padding:10px;" class="text-center">Total PPN</td>
                        <td style="border: 1px solid black; padding:10px;text-align:right" class="text-center">Rp. {{ number_format($data->total_tax) }}</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td style="border: 1px solid black;" colspan="6" class="text-center"></td>
                        <td style="border: 1px solid black;"></td>
                    </tr>
                    <tr>
                        <td colspan="6" style="border: 1px solid black; padding:10px; font-weight:bold;">Jumlah Net</td>
                        <td style="border: 1px solid black; padding:10px;text-align:right" class="text-center">Rp. {{  number_format($data->grand_total) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" style="border: 1px solid black; padding:10px; font-weight:bold;"><i>Terbilang : {{ $data->grand_total_spelled }}</i></td>
                        <td style="border: 1px solid black; padding:10px;" class="text-center"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row mt-3">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 200px">Delivery
                    </td>
                    <td>
                        : 1 (Satu) minggu hari kerja setelah PO diterima
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px">Cara Pembayaran
                    </td>
                    <td>
                        : 100% setelah material diantar dengan baik dan benar.
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px">Kelengkapan tagihan
                    </td>
                    <td>
                        : Kwitansi + materai, BA dan copy PO
                    </td>
                </tr>
                <tr>
                    <td style="width: 200px">Alamat Pengiriman
                    </td>
                    <td>
                        : Graha Surveyor Indonesia Lt. B2 Jl. Jend Gatot Subroto Kav.56 Jakarta
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>Demikian surat pemesanan (PO) ini kami sampaikan, atas perhatian dan kerjasamanya diucapkan terimakasih.</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>Hormat Kami</td>
                </tr>
                <tr>
                    <td>PPP Graha Surveyor Indonesia</td>
                </tr>
            </table>
            <table style="border: none">
                <tr>
                    <td>
                        @if(isset($data->signature))
                        <div style="
                                    background-image : url({{$data->signature}});
                                    height: 150px;
                                    width: 150px;
                                    background-position: left;
                                    background-size: contain;
                                    background-repeat: no-repeat;">
                        </div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>{{ $data->signature_name }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>