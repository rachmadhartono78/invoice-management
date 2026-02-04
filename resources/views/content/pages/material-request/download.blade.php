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
    </style>
</head>

<body>
    <div class="container" id="printContent">
        <div style="clear: both;"></div>

        <div class="row" style="margin-top: 25px;">
            <h1>
                <center><b><u>
                            <h5>MATERIAL REQUEST</h5>
                        </u></b></center>
            </h1>
            <h1 style="">
                <center><b>
                        <h6 style="line-height: 0.1;">PERMINTAAN MATERIAL</h6>
                    </b></center>
            </h1>
            <br>
        </div>

        <div class="row mt-1">
            <table class="table" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="padding-left:5px; padding-top:5px; border-top: 0.5px solid black;border-left: 0.5px solid black;border-right: 0.5px solid black;"><b>REQUESTER : </b> <b>{{ $data->requester }}</b></td>
                        <td style="width:10%"></td>
                        <td style="padding-left:5px; padding-top:5px; border-top: 0.5px solid black;border-right: 0.5px solid black;border-left: 0.5px solid black;"><b>MR . No : </b> <b>{{ $data->material_request_number }}</b></td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px; padding-bottom:5px;border-bottom: 0.5px solid black;border-left: 0.5px solid black;border-right: 0.5px solid black;">Yang Meminta</td>
                        <td></td>
                        <td style="padding-left:5px; padding-bottom:border-bottom: 0.5px solid black;border-right: 0.5px solid black;border-left: 0.5px solid black;">Nomor MR</td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px; padding-top:5px; border-top: 0.5px solid black;border-left: 0.5px solid black;border-right: 0.5px solid black;"><b>DEPARTMENT : </b> {{ $data->department }}</td>
                        <td></td>
                        <td style="padding-left:5px; padding-top:5px; border-top: 0.5px solid black;border-right: 0.5px solid black;border-left: 0.5px solid black;"><b>DATE : </b> {{ date('d F Y', strtotime($data->request_date)) }}</td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px; padding-bottom:5px;border-bottom: 0.5px solid black;border-left: 0.5px solid black;border-right: 0.5px solid black;">Departmen</td>
                        <td></td>
                        <td style="padding-left:5px; padding-bottom:5px;border-bottom: 0.5px solid black;border-right: 0.5px solid black;border-left: 0.5px solid black;">Tanggal</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row mt-1">
            <table class="table" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="padding-left:80px"><b>Stock</b></td>
                        <td style="width:10%"></td>
                        <td style="width:60% ;padding-left:5px; padding-top:5px; border: 0.5px solid black;" rowspan="5">
                            <b>Remaks : </b> <b>{{ $data->note }}</b>
                            <br>
                            <span>Catatan</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px">Persediaan</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="py-1"></td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px"><b>Purchase</b></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left:80px">Dibeli</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <td rowspan="2" style="border: 0.5px solid black; text-align:center; padding:10px;">
                            <div class="">
                                <span style="font-weight: bold;">No.</span>
                                <br>
                                No.
                            </div>
                        </td>
                        <td rowspan="2" style="border: 0.5px solid black; text-align:center; padding:10px">
                            <b>PART No.</b>
                            <br>
                            No. Suku Cadang
                        </td>
                        <td rowspan="2" style="border: 0.5px solid black; text-align:center; padding:10px">
                            <b>DESCRIPTION</b>
                            <br>
                            Keterangan
                        </td>
                        <td rowspan="2" style="border: 0.5px solid black; text-align:center; padding:10px">
                            <b>QTY </b>
                            <br>
                            Kuantitas
                        </td>
                        <td colspan="4" style="border: 0.5px solid black; text-align:center; padding:10px"><b> FILLED STOREKEEPER ONLY</b></td>
                    </tr>
                    <tr>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">Stock</td>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">Stock Out</td>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">End Stock</td>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">Min Stock</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->material_request_details as $key => $item)
                    <tr>
                        <td style="border: 0.5px solid black; text-align:center;" class="text-center">{{ $item->number }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->part_number }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->description }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->quantity }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->stock }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->stock_out }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->end_stock }}</td>
                        <td style="border: 0.5px solid black; text-align:center;">{{ $item->min_stock }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-1">
            <table style="width: 100%;">
                <tr>
                    <td style="border: 0.5px solid black; padding-left:10px">{{ $data->material_request_signatures[0]->type ?? ''}} : <br> {{ $data->material_request_signatures[0]->name ?? ''}} </td>
                    @foreach ($data->material_request_signatures as $item)
                        <td style="border: 0.5px solid black; padding-left:10px">{{ $item->type }} : <br> {{ $item->name}} </td>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($data->material_request_signatures as $item)
                        <td style="border: 0.5px solid black; text-align:center"><img src="{{ $item->signature }}" width="100px"></td>
                    @endforeach
                </tr>
                <tr class="text-center">
                    <td style="border: 0.5px solid black;">Warehouse</td>
                    <td style="border: 0.5px solid black;">Chief Department</td>
                    <td style="border: 0.5px solid black;">Chief Finance & Akunting</td>
                    <td style="border: 0.5px solid black;">Kepala BM</td>
                </tr>
                <tr>
                    @foreach ($data->material_request_signatures as $item)
                    <td style="border: 0.5px solid black; text-align:center">Date : {{ date('d F Y', strtotime($item->date)) }}</td>
                    @endforeach
                </tr>
            </table>
        </div>

        <div class="row mt-3">
            <table>
                <tr>
                    <td rowspan="2" style="width:55px;vertical-align: top;">Lembar</td>
                    <td style="width: 15px;">1.</td>
                    <td style="width: 60px;">Acounting</td>
                    <td style="width: 50px;">(Putih)</td>
                    <td style="width: 15px;"></td>
                    <td style="width: 15px;">3.</td>
                    <td style="width: 60px;">Purchasing</td>
                    <td style="width: 50px;">(Hijau)</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Gudang</td>
                    <td>(Merah)</td>
                    <td></td>
                    <td>4.</td>
                    <td>Pemohon</td>
                    <td>(Biru)</td>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script>
        function downloadPDF(elementId) {
            var element = document.getElementById(elementId);

            var options = {
                margin: 0,
                filename: 'surat.pdf',
                image: {
                    type: 'jpeg',
                    quality: 2
                },
                html2canvas: {
                    scale: 3
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf(element, options);
        }
    </script>
</body>

</html>