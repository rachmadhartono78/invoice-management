<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Bank;
use App\Services\BankService;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    protected $CommonService;
    protected $BankService;

    public function __construct(CommonService $CommonService, BankService $bankService)
    {
        $this->CommonService = $CommonService;
        $this->BankService = $bankService;
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

            $bankQuery = Bank::where("deleted_at", null);
            if($value){
                $bankQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            }
            $getBanks = $bankQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getBanks->total();

            $bankArr = $this->CommonService->toArray($getBanks);

            return [
                "data" => $bankArr,
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
            $validateBank = $this->BankService->validateBank($request, true, "");
            if($validateBank != "") throw new CustomException($validateBank, 400);

            DB::commit();
            $bank = Bank::create($request->all());

            return response()->json($bank, 201);
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
            $getBank = $this->CommonService->getDataById("App\Models\Bank", $id);
            if (is_null($getBank)) throw new CustomException("Bank tidak ditemukan", 404);

            return ["data" => $getBank];
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
            $getBank = $this->CommonService->getDataById("App\Models\Bank", $id);
            if (is_null($getBank)) throw new CustomException("Bank tidak ditemukan", 404);

            $validateBank = $this->BankService->validateBank($request, false, $id);
            if($validateBank != "") throw new CustomException($validateBank, 400);

            Bank::findOrFail($id)->update($request->all());
            DB::commit();

            $bank = Bank::where("id", $id)->first();

            return response()->json($bank, 200);
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
            $getBank = $this->CommonService->getDataById("App\Models\Bank", $id);
            if (is_null($getBank)) throw new CustomException("Bank tidak ditemukan", 404);

            Bank::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Bank berhasil dihapus'], 200);
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

            $getBank = Bank::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getBank->total();

            $dataArr = [];
            foreach($getBank as $bankObj){
                $dataObj = [
                    "id" => $bankObj->id,
                    "text" => $bankObj->$field,
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
