<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Vendor;
use App\Services\CommonService;
use App\Services\VendorService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    protected $CommonService;
    protected $VendorService;

    public function __construct(CommonService $CommonService, VendorService $VendorService)
    {
        $this->CommonService = $CommonService;
        $this->VendorService = $VendorService;
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

            $vendorQuery = Vendor::where("deleted_at", null);
            if($value){
                $vendorQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%');
                });
            }
            $getVendors = $vendorQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getVendors->total();

            $vendorArr = $this->CommonService->toArray($getVendors);

            return [
                "data" => $vendorArr,
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
            $validateVendor = $this->VendorService->validateVendor($request, true, "");
            if($validateVendor != "") throw new CustomException($validateVendor, 400);

            DB::commit();
            $vendor = Vendor::create($request->all());

            return response()->json($vendor, 201);
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
            $getVendor = $this->CommonService->getDataById("App\Models\Vendor", $id);
            if (is_null($getVendor)) throw new CustomException("Vendor tidak ditemukan", 404);

            return ["data" => $getVendor];
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
            $getVendor = $this->CommonService->getDataById("App\Models\Vendor", $id);
            if (is_null($getVendor)) throw new CustomException("Vendor tidak ditemukan", 404);

            $validateVendor = $this->VendorService->validateVendor($request, false, $id);
            if($validateVendor != "") throw new CustomException($validateVendor, 400);

            Vendor::findOrFail($id)->update($request->all());
            DB::commit();

            $vendor = Vendor::where("id", $id)->first();

            return response()->json($vendor, 200);
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
            $getVendor = $this->CommonService->getDataById("App\Models\Vendor", $id);
            if (is_null($getVendor)) throw new CustomException("Vendor tidak ditemukan", 404);

            Vendor::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Vendor berhasil dihapus'], 200);
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

            $getVendor = Vendor::where("deleted_at", null)->
                where($field, 'like', '%' . $value . '%')->
                select("id", $field)->
                paginate($perPage);
            $totalCount = $getVendor->total();

            $dataArr = [];
            foreach($getVendor as $vendorObj){
                $dataObj = [
                    "id" => $vendorObj->id,
                    "text" => $vendorObj->$field,
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

            $countVendor = Vendor::where("deleted_at", null)->count();

            return [
                "count_vendor" => $countVendor,
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

    public function vendor(Request $request)
    {
        $getVendor = Vendor::where("email", $request->email)->first();
        if(is_null($getVendor)) throw new CustomException("Vendor tidak ditemukan", 404);

        return ["data" => $getVendor];
    }
}
