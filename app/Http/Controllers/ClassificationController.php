<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Classification;
use App\Services\ClassificationService;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassificationController extends Controller
{
    protected $CommonService;
    protected $ClassificationService;

    public function __construct(CommonService $CommonService, ClassificationService $ClassificationService)
    {
        $this->CommonService = $CommonService;
        $this->ClassificationService = $ClassificationService;
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

            $classificationQuery = Classification::where("deleted_at", null);
            if($value){
                $classificationQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            }
            $getClassifications = $classificationQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getClassifications->total();

            $classificationArr = $this->CommonService->toArray($getClassifications);

            return [
                "data" => $classificationArr,
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
            $validateClassification = $this->ClassificationService->validateClassification($request, true, "");
            if($validateClassification != "") throw new CustomException($validateClassification, 400);

            DB::commit();
            $classification = Classification::create($request->all());

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
            $getClassification = $this->CommonService->getDataById("App\Models\Classification", $id);
            if (is_null($getClassification)) throw new CustomException("Classification tidak ditemukan", 404);

            return ["data" => $getClassification];
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
            $getClassification = $this->CommonService->getDataById("App\Models\Classification", $id);
            if (is_null($getClassification)) throw new CustomException("Classification tidak ditemukan", 404);

            $validateClassification = $this->ClassificationService->validateClassification($request, false, $id);
            if($validateClassification != "") throw new CustomException($validateClassification, 400);

            Classification::findOrFail($id)->update($request->all());
            DB::commit();

            $department = Classification::where("id", $id)->first();

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
            $getClassification = $this->CommonService->getDataById("App\Models\Classification", $id);
            if (is_null($getClassification)) throw new CustomException("Classification tidak ditemukan", 404);

            Classification::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Classification berhasil dihapus'], 200);
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

            $getClassification = Classification::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getClassification->total();

            $dataArr = [];
            foreach($getClassification as $departmentObj){
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
