<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\DamageReport;
use App\Models\Receipt;
use App\Models\Tenant;
use App\Models\WorkOrder;
use App\Models\WorkOrderDetail;
use App\Models\WorkOrderSignature;
use App\Services\CommonService;
use App\Services\WorkOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    protected $CommonService;
    protected $WorkOrderService;

    public function __construct(CommonService $CommonService, WorkOrderService $WorkOrderService)
    {
        $this->CommonService = $CommonService;
        $this->WorkOrderService = $WorkOrderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            [
                "perPage" => $perPage,
                "page" => $page,
                "order" => $order,
                "sort" => $sort,
                "status" => $status,
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $workOrderQuery = WorkOrder::where("deleted_at", null);
            if($value){
                $workOrderQuery->where(function ($query) use ($value) {
                    $query->where('work_order_number', 'like', '%' . $value . '%')
                    ->orWhere('scope', 'like', '%' . $value . '%')
                    ->orWhere('classification', 'like', '%' . $value . '%')
                    ->orWhere('work_order_date', 'like', '%' . $value . '%')
                    ->orWhere('action_plan_date', 'like', '%' . $value . '%')
                    ->orWhere('status', 'like', '%' . $value . '%');
                });
            }
            if($status){
                $workOrderQuery->where('status', 'like', '%' . $status . '%');
            }
            $getTickets = $workOrderQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getTickets->total();

            $workOrderArr = $this->CommonService->toArray($getTickets);
            foreach($workOrderArr as $workOrderObj){
              $workOrderObj["classification"] = $this->CommonService->getClassificationOrScope($workOrderObj["classification"], "classification");
              $workOrderObj["scope"] = $this->CommonService->getClassificationOrScope($workOrderObj["scope"], "scope");
            }

            return [
                "data" => $workOrderArr,
                "per_page" => $perPage,
                "page" => $page,
                "size" => $totalCount,
                "pages" => ceil($totalCount/$perPage)
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            $validateWorkOrder = $this->WorkOrderService->validateWorkOrder($request);
            if($validateWorkOrder != "") throw new CustomException($validateWorkOrder, 400);

            $workOrder = WorkOrder::create($request->all());

            foreach($request->input("details") as $detail){
                WorkOrderDetail::create([
                    "work_order_id" => $workOrder->id,
                    "location" => $detail["location"],
                    "material_request" => $detail["material_request"],
                    "type" => $detail["type"],
                    "quantity" => $detail["quantity"],
                ]);
            }

            if(!is_null($request->input("signatures"))){
                foreach($request->input("signatures") as $signature){
                    WorkOrderSignature::create([
                        'work_order_id' => $workOrder->id,
                        'name' => $signature['name'],
                        'position' => $signature['position'],
                        'signature' => $signature['signature'],
                        'date' => $signature['date'],
                    ]);
                }
            }

            $dataPayload = [ "status" => "Selesai" ];
            DamageReport::findOrFail($request->input("damage_report_id"))->update($dataPayload);

            DB::commit();

            $getWorkOrder = WorkOrder::with("workOrderDetails")->
                with("workOrderSignatures")->
                where("id", $workOrder->id)->
                where("deleted_at", null)->
                first();

            $getWorkOrder["classification"] = $this->CommonService->getClassificationOrScope($getWorkOrder["classification"], "classification");
            $getWorkOrder["scope"] = $this->CommonService->getClassificationOrScope($getWorkOrder["scope"], "scope");

            return ["data" => $getWorkOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $id = (int) $id;
            $getWorkOrder = WorkOrder::with("workOrderDetails")->
                with("workOrderSignatures")->
                where("id", $id)->
                where("deleted_at", null)->
                first();
            if (is_null($getWorkOrder)) throw new CustomException("Work order tidak ditemukan", 404);

            // $getWorkOrder["classification"] = $this->CommonService->getClassificationOrScope($getWorkOrder["classification"], "classification");
            // $getWorkOrder["scope"] = $this->CommonService->getClassificationOrScope($getWorkOrder["scope"], "scope");

            return ["data" => $getWorkOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $id = (int) $id;
            $workOrderExist = $this->CommonService->getDataById("App\Models\WorkOrder", $id);
            if (is_null($workOrderExist)) throw new CustomException("Work order tidak ditemukan", 404);

            $validateWorkOrder = $this->WorkOrderService->validateWorkOrder($request);
            if($validateWorkOrder != "") throw new CustomException($validateWorkOrder, 400);

            WorkOrder::findOrFail($id)->update($request->all());
            WorkOrderDetail::where("work_order_id", $id)->where("deleted_at", null)->delete();
            WorkOrderSignature::where("work_order_id", $id)->where("deleted_at", null)->delete();

            foreach($request->input("details") as $detail){
                WorkOrderDetail::create([
                    "work_order_id" => $id,
                    "location" => $detail["location"],
                    "material_request" => $detail["material_request"],
                    "type" => $detail["type"],
                    "quantity" => $detail["quantity"],
                ]);
            }

            if(!is_null($request->input("signatures"))){
                foreach($request->input("signatures") as $signature){
                    WorkOrderSignature::create([
                        'work_order_id' => $id,
                        'name' => $signature['name'],
                        'position' => $signature['position'],
                        'signature' => $signature['signature'],
                        'date' => $signature['date'],
                    ]);
                }
            }

            DB::commit();

            $getWorkOrder = WorkOrder::with("workOrderDetails")->
                with("workOrderSignatures")->
                where("id", $id)->
                where("deleted_at", null)->
                first();

            $getWorkOrder["classification"] = $this->CommonService->getClassificationOrScope($getWorkOrder["classification"], "classification");
            $getWorkOrder["scope"] = $this->CommonService->getClassificationOrScope($getWorkOrder["scope"], "scope");

            return ["data" => $getWorkOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try{
            $id = (int) $id;
            $workOrderExist = $this->CommonService->getDataById("App\Models\WorkOrder", $id);
            if (is_null($workOrderExist)) throw new CustomException("Work order tidak ditemukan", 404);

            WorkOrder::findOrFail($id)->delete();
            WorkOrderDetail::where("work_order_id", $id)->where("deleted_at", null)->delete();
            WorkOrderSignature::where("work_order_id", $id)->where("deleted_at", null)->delete();

            DB::commit();

            return response()->json(['message' => 'Work order berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function select(Request $request)
    {
        try{
            [
                "page" => $page,
                "value" => $value
            ] = $this->CommonService->getQuery($request);
            $field = $request->input("field");
            $perPage = 10;
            $status = strtolower($request->input("status", ""));
            $statusArray = explode(",", $status);

            if(is_null($field)) $field = "id";

            $workOrderQuery = WorkOrder::where("deleted_at", null)->where($field, 'like', '%' . $value . '%');
            if($status != ""){
                $workOrderQuery->where(function ($query) use ($statusArray) {
                    $length = count($statusArray);

                    for($i = 0; $i < $length; $i++){
                        $statusFromArray = trim($statusArray[$i]);
                        $query->orWhere('status', 'like', '%' . $statusFromArray . '%');
                    }
                });
            }
            $getWorkOrder = $workOrderQuery->select("id", $field)->paginate($perPage);
            $totalCount = $getWorkOrder->total();

            $dataArr = [];
            foreach($getWorkOrder as $workOrderObj){
                $dataObj = [
                    "id" => $workOrderObj->id,
                    "text" => $workOrderObj->$field,
                ];
                array_push($dataArr, $dataObj);
            }

            $pagination = ["more" => false];
            if($totalCount > ($perPage * $page)) {
                $pagination = ["more" => true];
            }

            return [
                "data" => $dataArr,
                "pagination" => $pagination,
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function report(Request $request)
    {
        try{
            [
                "start" => $start,
                "end" => $end,
            ] = $this->CommonService->getQuery($request);

            if(is_null($start)) $start = Carbon::now()->firstOfMonth();
            if(is_null($end)){
                $end = Carbon::now()->lastOfMonth();
                $end->setTime(23, 59, 59);
            }

            $countTenant = Tenant::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();
            $countReceipt = Receipt::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();
            $countReceiptPaid = Receipt::where("deleted_at", null)->
                whereBetween("created_at", [$start, $end])->
                where("status", "like", "%Lunas%")->
                sum("grand_total");

            return [
                "count_tenant" => $countTenant,
                "count_receipt" => $countReceipt,
                "count_receipt_paid" => $countReceiptPaid,
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function update_status(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $id = (int) $id;
            $getWorkOrder = $this->CommonService->getDataById("App\Models\WorkOrder", $id);
            if (is_null($getWorkOrder)) throw new CustomException("Work Order tidak ditemukan", 404);

            $validateWorkOrder = $this->WorkOrderService->validateStatus($request);
            if($validateWorkOrder != "") throw new CustomException($validateWorkOrder, 400);

            $dataPayload = [ "status" => $request->input("status") ];

            WorkOrder::findOrFail($id)->update($dataPayload);

            DB::commit();
            $getWorkOrder =  WorkOrder::with("workOrderDetails")->
                with("workOrderSignatures")->
                where("id", $id)->
                where("deleted_at", null)->
                first();

            $getWorkOrder["classification"] = $this->CommonService->getClassificationOrScope($getWorkOrder["classification"], "classification");
            $getWorkOrder["scope"] = $this->CommonService->getClassificationOrScope($getWorkOrder["scope"], "scope");

            return ["data" => $getWorkOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;
            DB::rollBack();

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }
}
