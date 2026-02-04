<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\MaterialRequest;
use App\Models\MaterialRequestDetail;
use App\Models\MaterialRequestSignature;
use App\Services\CommonService;
use App\Services\MaterialRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MaterialRequestController extends Controller
{
    protected $CommonService;
    protected $MaterialRequestService;

    public function __construct(CommonService $CommonService, MaterialRequestService $MaterialRequestService)
    {
        $this->CommonService = $CommonService;
        $this->MaterialRequestService = $MaterialRequestService;
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

            $materialRequestQuery = MaterialRequest::where("deleted_at", null);
            if($value){
                $materialRequestQuery->where(function ($query) use ($value) {
                    $query->where('material_request_number', 'like', '%' . $value . '%')
                    ->orWhere('requester', 'like', '%' . $value . '%')
                    ->orWhere('department', 'like', '%' . $value . '%')
                    ->orWhere('request_date', 'like', '%' . $value . '%')
                    ->orWhere('status', 'like', '%' . $value . '%');
                });
            }
            if($status){
                $materialRequestQuery->where('status', 'like', '%' . $status . '%');
            }
            $getMaterialRequest = $materialRequestQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getMaterialRequest->total();

            $materialRequestArr = $this->CommonService->toArray($getMaterialRequest);

            return [
                "data" => $materialRequestArr,
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
            $validateMaterialRequest = $this->MaterialRequestService->validateMaterialRequest($request);
            if($validateMaterialRequest != "") throw new CustomException($validateMaterialRequest, 400);

            $materialRequest = MaterialRequest::create($request->all());

            foreach($request->input("details") as $detail){
                MaterialRequestDetail::create([
                    "material_request_id" => $materialRequest->id,
                    "number" => $detail["number"],
                    "part_number" => $detail["part_number"],
                    "description" => $detail["description"],
                    "quantity" => $detail["quantity"],
                    "stock" => $detail["stock"],
                    "stock_out" => $detail["stock_out"],
                    "end_stock" => $detail["end_stock"],
                    "min_stock" => $detail["min_stock"],
                ]);
            }

            if(!is_null($request->input("signatures"))){
                foreach($request->input("signatures") as $signature){
                    MaterialRequestSignature::create([
                        'material_request_id' => $materialRequest->id,
                        'type' => $signature['type'],
                        'name' => $signature['name'],
                        'signature' => $signature['signature'],
                        'date' => $signature['date'],
                    ]);
                }
            }

            DB::commit();

            $getMaterialRequest = MaterialRequest::with("materialRequestDetails")->
                with("materialRequestSignatures")->
                where("id", $materialRequest->id)->
                where("deleted_at", null)->
                first();

            return ["data" => $getMaterialRequest];
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
            $getMaterialRequest = MaterialRequest::with("materialRequestDetails")->
                with("materialRequestSignatures")->
                where("id", $id)->
                where("deleted_at", null)->
                first();
            if (is_null($getMaterialRequest)) throw new CustomException("Material request tidak ditemukan", 404);

            return ["data" => $getMaterialRequest];
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
            $materialRequestExist = $this->CommonService->getDataById("App\Models\MaterialRequest", $id);
            if (is_null($materialRequestExist)) throw new CustomException("Material request tidak ditemukan", 404);

            $validateMaterialRequest = $this->MaterialRequestService->validateMaterialRequest($request);
            if($validateMaterialRequest != "") throw new CustomException($validateMaterialRequest, 400);

            MaterialRequest::findOrFail($id)->update($request->all());
            MaterialRequestDetail::where("material_request_id", $id)->where("deleted_at", null)->delete();
            MaterialRequestSignature::where("material_request_id", $id)->where("deleted_at", null)->delete();

            foreach($request->input("details") as $detail){
                MaterialRequestDetail::create([
                    "material_request_id" => $id,
                    "number" => $detail["number"],
                    "part_number" => $detail["part_number"],
                    "description" => $detail["description"],
                    "quantity" => $detail["quantity"],
                    "stock" => $detail["stock"],
                    "stock_out" => $detail["stock_out"],
                    "end_stock" => $detail["end_stock"],
                    "min_stock" => $detail["min_stock"],
                ]);
            }

            if(!is_null($request->input("signatures"))){
                foreach($request->input("signatures") as $signature){
                    MaterialRequestSignature::create([
                        'material_request_id' => $id,
                        'type' => $signature['type'],
                        'name' => $signature['name'],
                        'signature' => $signature['signature'],
                        'date' => $signature['date'],
                    ]);
                }
            }

            DB::commit();

            $getMaterialRequest = MaterialRequest::with("materialRequestDetails")->
                with("materialRequestSignatures")->
                where("id", $id)->
                where("deleted_at", null)->
                first();

            return ["data" => $getMaterialRequest];
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
            $materialRequestExist = $this->CommonService->getDataById("App\Models\MaterialRequest", $id);
            if (is_null($materialRequestExist)) throw new CustomException("Material request tidak ditemukan", 404);

            MaterialRequest::findOrFail($id)->delete();
            MaterialRequestDetail::where("material_request_id", $id)->where("deleted_at", null)->delete();
            MaterialRequestSignature::where("material_request_id", $id)->where("deleted_at", null)->delete();

            DB::commit();

            return response()->json(['message' => 'Material request berhasil dihapus'], 200);
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

            if(is_null($field)) $field = "material_request_number";

            $materialRequestQuery = MaterialRequest::where("deleted_at", null)->where($field, 'like', '%' . $value . '%');
            if($status != ""){
                $materialRequestQuery->where(function ($query) use ($statusArray) {
                    $length = count($statusArray);

                    for($i = 0; $i < $length; $i++){
                        $statusFromArray = trim($statusArray[$i]);
                        $query->orWhere('status', 'like', '%' . $statusFromArray . '%');
                    }
                });
            }
            $getMaterialRequest = $materialRequestQuery->select("id", $field)->paginate($perPage);
            $totalCount = $getMaterialRequest->total();

            $dataArr = [];
            foreach($getMaterialRequest as $tenantObj){
                $dataObj = [
                    "id" => $tenantObj->id,
                    "text" => $tenantObj->$field,
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

            $countMaterialRequest = MaterialRequest::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();
            $countMaterialRequestOngoing = MaterialRequest::where("deleted_at", null)->
                whereBetween("created_at", [$start, $end])->
                where("status", "!=", "Selesai")->
                count();
            $countMaterialRequestDone = MaterialRequest::where("deleted_at", null)->
                whereBetween("created_at", [$start, $end])->
                where("status", "like", "%Selesai%")->
                count();

            return [
                "count_material_request" => $countMaterialRequest,
                "count_material_request_ongoing" => $countMaterialRequestOngoing,
                "count_material_request_done" => $countMaterialRequestDone,
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
            $getMaterialRequest = $this->CommonService->getDataById("App\Models\MaterialRequest", $id);
            if (is_null($getMaterialRequest)) throw new CustomException("Material Request tidak ditemukan", 404);

            $validateMaterialRequest = $this->MaterialRequestService->validateStatus($request);
            if($validateMaterialRequest != "") throw new CustomException($validateMaterialRequest, 400);

            $dataPayload = [ "status" => $request->input("status") ];

            MaterialRequest::findOrFail($id)->update($dataPayload);

            DB::commit();
            $getMaterialRequest =  MaterialRequest::with("materialRequestDetails")->
                with("materialRequestSignatures")->
                where("id", $id)->
                where("deleted_at", null)->
                first();

            return ["data" => $getMaterialRequest];
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
