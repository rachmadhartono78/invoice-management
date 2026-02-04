<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Work Order</title>
    <link href="{{ public_path('assets/css/bootstrap.min.css') }}" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* General Styles */
        body {
            font-size: 12px;
            font-family: sans-serif;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            background: #fff;
        }


        /* A4 Styles */
    </style>
</head>

<body>

    <div class="container" id="printContent">
        <table style="width: 100%; background-color: #C9C9CB; border: 1px solid black;">
            <tr class="text-center">
                <td style="text-align:center; width:25%; border-right: 0.5px solid black;"><span style="font-family: sans-serif; font-size : 24px;"><b>PPPGSI</b></span></th>
                <td rowspan="2" colspan="2" style="letter-spacing: 10px;  width:50%; text-align:center">
                    <h1>WORK ORDER
                        <br>(WO)
                    </h1>
                </td>
                <td rowspan="2" style="text-align:center; border: 0.5px solid black; width:25%"><b>No: {{ $data->work_order_number}} </b></th>
            </tr>
            <tr class="text-center">
                <td style="text-align:center; margin: auto;border-right: 0.5px solid black; border-top: 0.5px solid black;"><b>Building Management</b></th>
            </tr>
        </table>
        <table style="width: 100%;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td style="padding-left: 5px;" class="py-2">DATE :</td>
                <td> {{ $data->work_order_date }}</td>
                <td></td>
                <td>ACTION PLAN :</td>
                <td> {{ $data->action_plan_date }}</td>
                <td></td>
                <td>FINISH PLAN :</td>
                <td>{{ $data->finish_plan }}</td>

            </tr>
        </table>
        <table class="text-center" style="width: 100%;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td style="width: 18px; font-size: 14px;">1</td>
                <td style="font-size: 14px;">SCOPE</td>
                <td>
                    <table style="width: 100%;  border: 1px solid black;" class="text-center">
                        <tr>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 1))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">TELEKOMUNIKASI</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">TELEKOMUNIKASI</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 2))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">ELECTRIC</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">ELECTRIC</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 3))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">PLUMBING</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">PLUMBING</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 4))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">CIVIL</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">CIVIL</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 5))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">BAS</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">BAS</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 6))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">MDP</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">MDP</label><br>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 7))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">LIGHTING</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">LIGHTING</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 8))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">HVAC</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">HVAC</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 9))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">LIFT</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">LIFT</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 10))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">FIRE SYSTEM</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">FIRE SYSTEM</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 11))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">GENSET</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">GENSET</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->scope , 12))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1">OTHER</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1">OTHER</label><br>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 0px;"></td>
            </tr>
        </table>
        <table class="text-center" style="width: 100%;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td class="py-1" colspan="4"> </td>
            </tr>
            <tr>
                <td style="width: 20px; font-size: 14px;">2</td>
                <td style="font-size: 14px;">CLASIFICATION</td>
                <td>
                    <table style="width: 100%;  border: 1px solid black;" class="text-center">
                        <tr>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->classification , 1))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1" style="text-transform: uppercase;">Prev Maint. Routine</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1" style="text-transform: uppercase;">Prev Maint. Routine</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->classification , 2))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1" style="text-transform: uppercase;">Prev Maint. Non Routine</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1" style="text-transform: uppercase;">Prev Maint. Non Routine</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->classification , 3))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1" style="text-transform: uppercase;">Repair</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1" style="text-transform: uppercase;">Repair</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->classification , 4))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1" style="text-transform: uppercase;">Replacement</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1" style="text-transform: uppercase;">Replacement</label><br>
                                    @endif
                                </div>
                            </td>
                            <td style=" border: 1px solid black;" class="py-1">
                                <div class="">
                                    @if (str_contains($data->classification , 5))
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                    <label for="vehicle1" style="text-transform: uppercase;">Vendor</label><br>
                                    @else
                                    <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                    <label for="vehicle1" style="text-transform: uppercase;">Vendor</label><br>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 0px;"></td>
            </tr>
        </table>
        <table style="width: 100%;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td class="py-1" colspan="4"> </td>
            </tr>
            <tr style="vertical-align: top;">
                <td style="width: 15px; font-size: 14px; padding-left:7px">3</td>
                <td class="text-left" style="font-size: 14px; width: 130px">JOB DESCRIPTION</td>
                <td>{{$data->job_description}}</td>
                <td></td>
            </tr>
        </table>
        <table class="text-center" style="width: 100%;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td class="py-1" colspan="3"> </td>
            </tr>
            <tr style="vertical-align: top;">
                <td style="width: 20px; font-size: 14px;">4</td>
                <td style="padding-left: 10px;">
                    <table style="width: 100%;  border: 1px solid black;" class="text-center">
                        <thead>
                            <tr>
                                <td style=" border: 1px solid black;" class="py-1">LOCATION</td>
                                <td style=" border: 1px solid black;" class="py-1">5 MATERIAL REQUEST</td>
                                <td style=" border: 1px solid black;" class="py-1">TYPE/MADE IN</td>
                                <td style=" border: 1px solid black;" class="py-1">QUANTITY</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->work_order_details as $p)
                            <tr>
                                <td style=" border: 1px solid black;" class="py-1">{{ $p->location }}</td>
                                <td style=" border: 1px solid black;" class="py-1">{{ $p->material_request }}</td>
                                <td style=" border: 1px solid black;" class="py-1">{{ $p->type }}</td>
                                <td style=" border: 1px solid black;" class="py-1">{{ $p->quantity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                <td style="width: 0px;"></td>
            </tr>
        </table>
        <table class="text-center" style="width: 100%;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td style="width: 20px; font-size: 14px;">6</td>
                <td style="padding-left: 10px;">
                    <table style="width: 100%;  border: 1px solid black;" class="text-center">
                        <tbody>
                            <tr>
                                <td style=" border: 1px solid black;" class="py-1">
                                    <div class="">
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        <label for="vehicle1" style="text-transform: uppercase;">KLASIFIKASI</label><br>
                                    </div>
                                </td>
                                <td style=" border: 1px solid black;" class="py-1">
                                    <div class="">
                                        @if($data->klasifikasi == "closed")
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                        <label for="vehicle1" style="text-transform: uppercase;">ClOSED</label><br>
                                        @else
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        <label for="vehicle1" style="text-transform: uppercase;">ClOSED</label><br>
                                        @endif
                                    </div>
                                </td>
                                <td style=" border: 1px solid black;" class="py-1">
                                    <div class="">
                                        @if($data->klasifikasi == "cancelled")
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                        <label for="vehicle1" style="text-transform: uppercase;">CANCELED</label><br>
                                        @else
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        <label for="vehicle1" style="text-transform: uppercase;">CANCELED</label><br>
                                        @endif
                                    </div>
                                </td>
                                <td style=" border: 1px solid black;" class="py-1">
                                    <div class="">
                                        @if($data->klasifikasi == "explanation")
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                        <label for="vehicle1" style="text-transform: uppercase;">EXPLANATION</label><br>
                                        @else
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        <label for="vehicle1" style="text-transform: uppercase;">EXPLANATION</label><br>
                                        @endif
                                    </div>
                                </td>
                                <td style=" border: 1px solid black;" class="py-1">
                                    <div class="">
                                        @if($data->klasifikasi == "others")
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" checked>
                                        <label for="vehicle1" style="text-transform: uppercase;">OTHERS</label><br>
                                        @else
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
                                        <label for="vehicle1" style="text-transform: uppercase;">OTHERS</label><br>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 0px;"></td>
            </tr>
        </table>

        <table class="text-center" style="width: 100%; border-bottom: 1px solid black;  border-left: 1px solid black; border-right: 1px solid black;">
            <tr>
                <td class="py-1"> </td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%;  border: 1px solid black;" class="text-center">
                        <tr>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">TECHINICIAN</td>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">CHHIEF ENGINEERING</td>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">WARE HOUSE</td>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">BUILDING MANAGER</td>
                        </tr>
                        <tr>
                            <td style=" border: 1px solid black;" class="">
                                <div style="margin : auto;
                                            background-image : url({{$data->work_order_signatures[0]->signature}});
                                            height: 150px;
                                            width: 150px;
                                            background-position: center center;
                                            background-size: contain;
                                            background-repeat: no-repeat;">
                                </div>
                            </td>
                            <td style=" border: 1px solid black;">
                                @if(isset($data->work_order_signatures[1]->signature))
                                <div style="margin : auto;
                                            background-image : url({{$data->work_order_signatures[0]->signature}});
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
                                @if(isset($data->work_order_signatures[2]->signature))
                                <div style="margin : auto;
                                            background-image : url({{$data->work_order_signatures[2]->signature}});
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
                                @if(isset($data->work_order_signatures[3]->signature))
                                <div style="margin : auto;
                                            background-image : url({{$data->work_order_signatures[3]->signature}});
                                            height: 150px;
                                            width: 150px;
                                            background-position: center center;
                                            background-size: contain;
                                            background-repeat: no-repeat;">
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
                        <tr>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">
                            @if(isset($data->work_order_signatures[0]->name))
                            {{$data->work_order_signatures[0]->name}}
                            @endif
                            </td>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">
                                @if(isset($data->work_order_signatures[1]->name))
                                {{$data->work_order_signatures[1]->name}}
                                @endif
                            </td>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">
                                @if(isset($data->work_order_signatures[2]->name))
                                {{$data->work_order_signatures[2]->name}}
                                @endif
                            </td>
                            <td style=" border: 1px solid black; text-align:center" class="py-1">
                                @if(isset($data->work_order_signatures[3]->name))
                                {{$data->work_order_signatures[3]->name}}
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>