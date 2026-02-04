<?php

namespace App\Http\Controllers\report;

use App\Exports\ReportTagihanVendor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportTagihanController extends Controller
{
    public function index()
    {
        return view("report.report-tagihan");
    }

    public function fileExport(Request $request)
    {
        $apiRequest = Http::get(env('BASE_URL_API') . '/api/purchase-order', [
            'value' => $request->value,
            'status' => $request->status,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        $response = json_decode($apiRequest->getBody());
        $data = $response->data;
        return Excel::download(new ReportTagihanVendor($data), 'report-tagihan.xlsx');
    }


}
