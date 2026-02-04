<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\DataTables;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.pages.work-order.list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('content.pages.work-order.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('content.pages.work-order.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('content.pages.work-order.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function preview()
    {
        return view('content.pages.work-order.preview');
    }

    /**
     * Remove the specified resource from storage.
     */
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
        $apiRequest = Http::get(env('BASE_URL_API') . '/api/work-order', [
            'per_page' => $request->length,
            'page' => $request->page,
            'order' => 'id',
            'sort' => 'desc',
            'value' => $request->search['value'],
            'status' => $request->status,
        ]);
        $response = json_decode($apiRequest->getBody());
        $data = [];
        if ($response->data) {
            foreach ($response->data as $key => $value) {
                $data[$key] = $value;
            }
        }
        return DataTables::of($data)
            ->setFilteredRecords($response->size)
            ->setTotalRecords($response->size)
            ->make(true);

    }

    public function print($id){
        $apiRequest = Http::get(env('BASE_URL_API') .'/api/work-order/'.$id);
        $response = json_decode($apiRequest->getBody());
        $data = $response->data;
    	$pdf = PDF::loadview('content.pages.work-order.download',['data'=>$data]);
    	return $pdf->stream('work-order.pdf');
        // return view('content.pages.work-order.download',['data'=>$data]);
    }
}
