<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Department;
use App\Services\CommonService;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    protected $CommonService;
    protected $DepartmentService;

    public function __construct(CommonService $CommonService, DepartmentService $DepartmentService)
    {
        $this->CommonService = $CommonService;
        $this->DepartmentService = $DepartmentService;
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

            $departmentQuery = Department::where("deleted_at", null);
            if($value){
                $departmentQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            }
            $getDepartments = $departmentQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getDepartments->total();

            $departmentArr = $this->CommonService->toArray($getDepartments);

            return [
                "data" => $departmentArr,
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
            $validateDepartment = $this->DepartmentService->validateDepartment($request, true, "");
            if($validateDepartment != "") throw new CustomException($validateDepartment, 400);

            DB::commit();
            $department = Department::create($request->all());

            return response()->json($department, 201);
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
            $getDepartment = $this->CommonService->getDataById("App\Models\Department", $id);
            if (is_null($getDepartment)) throw new CustomException("Department tidak ditemukan", 404);

            return ["data" => $getDepartment];
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
            $getDepartment = $this->CommonService->getDataById("App\Models\Department", $id);
            if (is_null($getDepartment)) throw new CustomException("Department tidak ditemukan", 404);

            $validateDepartment = $this->DepartmentService->validateDepartment($request, false, $id);
            if($validateDepartment != "") throw new CustomException($validateDepartment, 400);

            Department::findOrFail($id)->update($request->all());
            DB::commit();

            $department = Department::where("id", $id)->first();

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
            $getDepartment = $this->CommonService->getDataById("App\Models\Department", $id);
            if (is_null($getDepartment)) throw new CustomException("Department tidak ditemukan", 404);

            Department::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Department berhasil dihapus'], 200);
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

            $getDepartment = Department::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getDepartment->total();

            $dataArr = [];
            foreach($getDepartment as $departmentObj){
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
