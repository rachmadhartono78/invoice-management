<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Tax;
use App\Services\CommonService;
use App\Services\PaperIdService;
use App\Services\TaxService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    protected $CommonService;
    protected $TaxService;
    protected $PaperIdService;

    public function __construct(CommonService $CommonService, TaxService $TaxService, PaperIdService $PaperIdService)
    {
        $this->CommonService = $CommonService;
        $this->TaxService = $TaxService;
        $this->PaperIdService = $PaperIdService;
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

            $taxQuery = Tax::where("deleted_at", null);
            if($value){
                $taxQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                    ->orWhere('rate', 'like', '%' . $value . '%')
                    ->orWhere('description', 'like', '%' . $value . '%');
                });
            }
            $getTaxs = $taxQuery
            ->select("id","name", "rate", "description")
            ->orderBy($order, $sort)
            ->paginate($perPage);
            $totalCount = $getTaxs->total();

            $taxArr = $this->CommonService->toArray($getTaxs);
            $taxArr = $this->TaxService->addRatePercentage($taxArr);

            return [
                "data" => $taxArr,
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
            $validateTax = $this->TaxService->validateTax($request);
            if($validateTax != "") throw new CustomException($validateTax, 400);

            $saveTax = Tax::create($request->all());
            $saveTax = $this->TaxService->addRatePercentage([$saveTax])[0];

            DB::commit();

            return ["data" => $saveTax];
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
            $getTax = $this->CommonService->getDataById("App\Models\Tax", $id);
            if (is_null($getTax)) throw new CustomException("Tax rate tidak ditemukan", 404);

            $getTax = $this->TaxService->addRatePercentage([$getTax])[0];
            return ["data" => $getTax];
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
            $taxExist = $this->CommonService->getDataById("App\Models\Tax", $id);
            if (is_null($taxExist)) throw new CustomException("Tax rate tidak ditemukan", 404);

            $validateTax = $this->TaxService->validateTax($request);
            if($validateTax != "") throw new CustomException($validateTax, 400);

            Tax::findOrFail($id)->update($request->all());

            $getTax = $this->CommonService->getDataById("App\Models\Tax", $id);
            $getTax = $this->TaxService->addRatePercentage([$getTax])[0];

            DB::commit();

            return ["data" => $getTax];
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
            $taxExist = $this->CommonService->getDataById("App\Models\Tax", $id);
            if (is_null($taxExist)) throw new CustomException("Tax rate tidak ditemukan", 404);

            Tax::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Tax rate berhasil dihapus'], 200);
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

            $getTax = Tax::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getTax->total();

            $dataArr = [];
            foreach($getTax as $taxObj){
                $dataObj = [
                    "id" => $taxObj->id,
                    "text" => $taxObj->$field,
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

    public function selectPaperId()
    {
        try{
            $taxArr = [];
            $listTax = $this->PaperIdService->listAlltax();

            if(
                $listTax &&
                isset($listTax["data"])
            ){
                if(isset($listTax["data"]["default_tax"])) $taxArr = array_merge($taxArr, $listTax["data"]["default_tax"]);
                if(isset($listTax["data"]["custom_taz"])) $taxArr = array_merge($taxArr, $listTax["data"]["custom_tax"]);
            }

            $dataArr = [];
            foreach($taxArr as $taxObj){
                if(!$taxObj["exclusive"]) continue;

                $dataObj = [
                    "id" => $taxObj["uuid"],
                    "text" => $taxObj["name"],
                ];
                array_push($dataArr, $dataObj);
            }

            return [
                "data" => $dataArr,
                "pagination" => ["more" => false],
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

    public function getPaperId($id)
    {
        try{
            $taxArr = [];
            $listTax = $this->PaperIdService->listAlltax();

            if(
                $listTax &&
                isset($listTax["data"])
            ){
                if(isset($listTax["data"]["default_tax"])) $taxArr = array_merge($taxArr, $listTax["data"]["default_tax"]);
                if(isset($listTax["data"]["custom_taz"])) $taxArr = array_merge($taxArr, $listTax["data"]["custom_tax"]);
            }

            $taxData = null;
            foreach($taxArr as $taxObj){
                if($id == $taxObj["uuid"]){
                    $taxData = $taxObj;
                    break;
                }
            }

            if(!$taxData) throw new CustomException("Tax not found", 404);

            return [
                "data" => $taxData,
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
