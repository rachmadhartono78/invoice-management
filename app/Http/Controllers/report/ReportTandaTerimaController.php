<?php

namespace App\Http\Controllers\report;

use App\Exports\ReportTandaTerimaExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class ReportTandaTerimaController extends Controller
{
    public function index()
    {
        return view("report.report-tanda-terima");
    }

    public function datatable(Request $request)
    {
        $searchColumn = array();
        foreach ($request->columns as $column) {
            if ($column['data'] != 'null' && $column['data'] != 'Actions') {
                $searchColumn[] = array(
                    $column['data'] => $column['search']['value']
                );
            }
        }
        $dataSearchColumn = array();
        foreach ($searchColumn as $value) {
            foreach ($value as $k => $val) {
                if ($val != null || $val != '') {
                    $dataSearchColumn[$k] = $val;
                }
            }
        }

        $orderBy = '';
        $sortBy = '';
        if ($request->order[0]['column'] != 0) {
            $sortBy = $request->order[0]['dir'];
            // $orderBy = $request->columns[$request->order[0]['column']]['data']; harusnya kodenya ini, tapi di harcode dulu sampai diperbaiki apinya.
            $orderBy = 'id';
        }
        if ($request->page == null) {
            $request->page = 1;
        }
        $apiRequest = Http::get(env('BASE_URL_API') . '/api/receipt', [
            'per_page' => $request->length,
            'page' => $request->page,
            'order' => 'id',
            'sort' => 'desc',
            'value' => $request->search['value'],
        ]);
        $response = json_decode($apiRequest->getBody());
        $data = [];
        $status ='';
        if ($response->data) {
            foreach ($response->data as $key => $value) {
                if($value->status != 'Terkirim'){
                    $status = 'Belum Terkirim';
                }else{
                    $status = 'Yes';
                }
                $data[$key] = $value;
                $data[$key]->tenant_name = $value->tenant->company ?? '';
                $data[$key]->total_invoice = $value->invoice->grand_total ?? '';
                $data[$key]->status = $status;
            }
        }
        return DataTables::of($data)
            ->setFilteredRecords($response->size)
            ->setTotalRecords($response->size)
            ->make(true);
    }

    public function fileExport(Request $request)
    {
        $apiRequest = Http::get(env('BASE_URL_API') . '/api/receipt', [
            'value' => $request->value,
            'status' => $request->status,
            'start' => $request->start,
            'end' => $request->end,
        ]);
        $response = json_decode($apiRequest->getBody());
        $data = $response->data;
        return Excel::download(new ReportTandaTerimaExport($data), 'report-tanda-terima.xlsx');
    }
}
