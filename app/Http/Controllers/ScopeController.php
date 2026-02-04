<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Scope;
use App\Services\CommonService;
use App\Services\ScopeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScopeController extends Controller
{
    protected $CommonService;
    protected $ScopeService;

    public function __construct(CommonService $CommonService, ScopeService $ScopeService)
    {
        $this->CommonService = $CommonService;
        $this->ScopeService = $ScopeService;
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

            $scopeQuery = Scope::where("deleted_at", null);
            if($value){
                $scopeQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            }
            $getScopes = $scopeQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getScopes->total();

            $scopeArr = $this->CommonService->toArray($getScopes);

            return [
                "data" => $scopeArr,
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
            $validateScope = $this->ScopeService->validateScope($request, true, "");
            if($validateScope != "") throw new CustomException($validateScope, 400);

            DB::commit();
            $classification = Scope::create($request->all());

            return response()->json($classification, 201);
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
            $getScope = $this->CommonService->getDataById("App\Models\Scope", $id);
            if (is_null($getScope)) throw new CustomException("Scope tidak ditemukan", 404);

            return ["data" => $getScope];
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
            $getScope = $this->CommonService->getDataById("App\Models\Scope", $id);
            if (is_null($getScope)) throw new CustomException("Scope tidak ditemukan", 404);

            $validateScope = $this->ScopeService->validateScope($request, false, $id);
            if($validateScope != "") throw new CustomException($validateScope, 400);

            Scope::findOrFail($id)->update($request->all());
            DB::commit();

            $department = Scope::where("id", $id)->first();

            return response()->json($department, 200);
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
            $getScope = $this->CommonService->getDataById("App\Models\Scope", $id);
            if (is_null($getScope)) throw new CustomException("Scope tidak ditemukan", 404);

            Scope::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Scope berhasil dihapus'], 200);
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

            $getScope = Scope::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getScope->total();

            $dataArr = [];
            foreach($getScope as $departmentObj){
                $dataObj = [
                    "id" => $departmentObj->id,
                    "text" => $departmentObj->$field,
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
}
