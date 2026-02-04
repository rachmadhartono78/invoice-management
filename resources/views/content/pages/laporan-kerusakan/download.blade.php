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

        .main-table,
        .main-table th,
        .main-table td {
            border: 0.5px solid;
        }


        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: #fff;

        }

        .table-1 td {
            border: 1px solid black;
            border-collapse: collapse;
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
        <div class="row" style="float: right;">
            <div class="p-2" style="width: 200px; border: 1px solid black;">No:{{ $data->id }}/Dept-Service/{{ date('Y', strtotime($data->created_at)) . '/' . date('m', strtotime($data->created_at)) . '/' . date('d', strtotime($data->created_at)) }}</div>
        </div>
        <div style="clear: both;"></div>

        <div class="row" style="margin-top: 25px;">
            <h1>
                <center><b>FORM LAPORAN KERUSAKAN</b></center>
            </h1><br>
        </div>
        @php
            $hariInggris = date('D', strtotime($data->created_at));
            $hariIndonesia = [
                'Sun' => 'Minggu',
                'Mon' => 'Senin',
                'Tue' => 'Selasa',
                'Wed' => 'Rabu',
                'Thu' => 'Kamis',
                'Fri' => 'Jumat',
                'Sat' => 'Sabtu'
            ];
        @endphp
        <div class="row mt-1">
            <table class="table" style="width:100%;">
                <tbody>
                    <tr>
                        <td style="width: 8%;padding: 5px; border-top: 0.5px solid black;border-left: 0.5px solid black;border-bottom: 0.5px solid black;">Hari
                        </td>
                        <td style="width:3%; padding: 5px; border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                            <center>:</center>
                        </td>
                        <td style="padding: 5px;width: 40%; border-top: 0.5px solid black;border-bottom: 0.5px solid black;;border-right: 0.5px solid black;">{{ $hariIndonesia[$hariInggris] }}</td>
                        </td>
                        <td></td>
                        <td style="width:40%;" rowspan="3">
                            <b>Kepada Yth: <br></b>
                            <b>Departement. Service BM <br></b>
                            <b>PPKP GRAHA SURVEYOR INDONESIA<br></b>
                            <b>JAKARTA<br></b>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 8%;padding: 5px; border-top: 0.5px solid black;border-left: 0.5px solid black;border-bottom: 0.5px solid black;">Tanggal
                        </td>
                        <td style="width:3%; padding: 5px; border-top: 0.5px solid black;border-bottom: 0.5px solid black;">
                            <center>:</center>
                        </td>
                        <td style="padding: 5px;width: 40%; border-top: 0.5px solid black;border-bottom: 0.5px solid black;;border-right: 0.5px solid black;">{{ date('d F Y', strtotime($data->created_at))}}</td>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">NO</td>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">JENIS MASALAH KERUSAKAN</td>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">LOKASI</td>
                        <td style="border: 0.5px solid black; text-align:center; padding:10px">JUMLAH</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->damage_report_details as $key => $item)
                    <tr>
                        <td style="border: 0.5px solid black; padding-left:10px;" class="text-center">{{ $key+1 }}</td>
                        <td style="border: 0.5px solid black; padding-left:10px;" class="text-center">{{ $item->category }}</td>
                        <td style="border: 0.5px solid black;padding-left:10px;" class="text-center">{{ $item->location }}</td>
                        <td style="border: 0.5px solid black;padding-left:10px;" class="text-center">{{ $item->total }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <table>
                <tr>
                    <td>
                        <center>
                            <p>Dilaporkan</p>
                            @if(isset($data->damage_report_signatures[0]->signature))
                            <div style="margin : auto;
                                        background-image : url({{$data->damage_report_signatures[0]->signature}});
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
                            <br>
                            @endif
                            <p class="text-center">
                                <span>{{ $data->damage_report_signatures[0]->name ?? '' }}</span>
                            </p>
                            <p class="text-center">
                                <span>Leader Cleaning</span>
                            </p>
                        </center>
                    </td>
                    <td>
                        <center>
                            <p>Diterima</p>
                            @if(isset($data->damage_report_signatures[1]->signature))
                            <div style="margin : auto;
                                        background-image : url({{$data->damage_report_signatures[1]->signature}});
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
                            <br>
                            @endif
                            <p class="text-center">
                                <span>{{ $data->damage_report_signatures[1]->name ?? '' }}</span>
                            </p>
                            <p class="text-center">
                                <span>Koordinator Teknik</span>
                            </p>
                        </center>
                    </td>
                    <td>
                        <center>
                            <p>Mengetahui</p>
                            @if(isset($data->damage_report_signatures[2]->signature))
                            <div style="margin : auto;
                                        background-image : url({{$data->damage_report_signatures[2]->signature}});
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
                            <br>
                            @endif
                            <p class="text-center">
                                <span>{{ $data->damage_report_signatures[2]->name ?? '' }}</span>
                            </p>
                            <p class="text-center">
                                <span>Kepala Unit Pelayanan</span>
                            </p>
                        </center>
                    </td>
                   
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