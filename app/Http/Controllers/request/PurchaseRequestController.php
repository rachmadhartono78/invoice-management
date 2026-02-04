<?php

namespace App\Http\Controllers\request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;
use PDF;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        return view('request.list-purchase');
    }

    public function add()
    {
        return view('request.add-purchase');
    }

    public function edit()
    {
        return view('request.edit-purchase');
    }

    public function show()
    {
        return view('request.show');
    }

    public function preview(string $id)
    {
        return view('request.preview');
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
        $apiRequest = Http::get(env('BASE_URL_API') . '/api/purchase-request', [
            'per_page' => $request->length,
            'page' => $request->page,
            'order' => 'id',
            'sort' => 'desc',
            'status' => $request->status,
            'value' => $request->search['value'],
        ]);
        $response = json_decode($apiRequest->getBody());
        $data = [];
        if ($response->data) {
            foreach ($response->data as $key => $value) {
                $data[$key] = $value;
                $data[$key]->department = $value->department->name;
            }
        }
        return DataTables::of($data)
            ->setFilteredRecords($response->size)
            ->setTotalRecords($response->size)
            ->make(true);

    }

    public function print($id){
        $apiRequest = Http::get(env('BASE_URL_API') .'/api/purchase-request/'.$id);
        $response = json_decode($apiRequest->getBody());
        $data = $response->data;
    	$pdf = PDF::loadview('request.download',['data'=>$data]);
    	return $pdf->stream('purchase-request.pdf');
        // return view('content.pages.material-request.download',['data'=>$data]);
    }
}
