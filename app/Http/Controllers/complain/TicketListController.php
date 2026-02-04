<?php

namespace App\Http\Controllers\complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DataTables;

class TicketListController extends Controller
{
    public function index()
    {
        return view('complain.ticket.list-ticket');
    }

    public function add()
    {
        return view('complain.ticket.add-ticket');
    }

    public function preview()
    {
        return view('complain.ticket.preview-ticket');
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

        $apiRequest = Http::get(env('BASE_URL_API') . '/api/ticket', [
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

    public function edit(string $id)
    {
        return view('complain.ticket.edit');
    }

    public function show(string $id)
    {
        return view('complain.ticket.show');
    }
 
    public function editPreview(string $id)
    {
        return view('complain.ticket.edit-preview');
    }
}
