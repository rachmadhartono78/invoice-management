<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Tenant;
use App\Services\CommonService;
use App\Services\PaperIdService;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    protected $CommonService;
    protected $TenantService;
    protected $PaperIdService;

    public function __construct(CommonService $CommonService, TenantService $tenantService, PaperIdService $paperIdService)
    {
        $this->CommonService = $CommonService;
        $this->TenantService = $tenantService;
        $this->PaperIdService = $paperIdService;
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
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $tenantQuery = Tenant::where("deleted_at", null);
            if($value){
                $tenantQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhere('phone', 'like', '%' . $value . '%')
                        ->orWhere('company', 'like', '%' . $value . '%')
                        ->orWhere('floor', 'like', '%' . $value . '%');
                });
            }
            $getTenants = $tenantQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getTenants->total();

            $tenantArr = $this->CommonService->toArray($getTenants);

            return [
                "data" => $tenantArr,
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
            $validateTenant = $this->TenantService->validateTenant($request);
            if($validateTenant != "") throw new CustomException($validateTenant, 400);

            $tenant = Tenant::create($request->all());
            $partner = $this->PaperIdService->createOrUpdatePartner($tenant->id, $tenant->name, $tenant->phone, "", true);

            if (isset($partner['data']) && isset($partner['data']['id'])){
              $dataId = $partner["data"]["id"];
              Tenant::findOrFail($tenant->id)->update(["paper_id" => $dataId]);
              $tenant->paper_id = $dataId;
            }

            DB::commit();

            return response()->json($tenant, 201);
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
            $getTenant = $this->CommonService->getDataById("App\Models\Tenant", $id);
            if (is_null($getTenant)) throw new CustomException("Tenant tidak ditemukan", 404);

            return ["data" => $getTenant];
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
            $getTenant = $this->CommonService->getDataById("App\Models\Tenant", $id);
            if (is_null($getTenant)) throw new CustomException("Tenant tidak ditemukan", 404);

            $validateTenant = $this->TenantService->validateTenant($request);
            if($validateTenant != "") throw new CustomException($validateTenant, 400);

            $update = Tenant::findOrFail($id)->update($request->all());
            $partner = $this->PaperIdService->createOrUpdatePartner($id, $request->input("name"), $request->input("phone"), $getTenant["paper_id"], false);

            DB::commit();

            $tenant = Tenant::where("id", $id)->first();

            return response()->json($tenant, 200);
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
            $getTenant = $this->CommonService->getDataById("App\Models\Tenant", $id);
            if (is_null($getTenant)) throw new CustomException("Tenant tidak ditemukan", 404);

            $deleteTenant = Tenant::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Tenant berhasil dihapus'], 200);
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

            if(is_null($field)) $field = "name";

            $getTenant = Tenant::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getTenant->total();

            $dataArr = [];
            foreach($getTenant as $tenantObj){
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

            $countTenant = Tenant::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();

            return [
                "count_tenant" => $countTenant,
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
}
