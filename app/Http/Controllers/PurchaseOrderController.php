<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchaseOrderSignature;
use App\Models\Tenant;
use App\Models\Vendor;
use App\Services\CommonService;
use App\Services\PurchaseOrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDF;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderController extends Controller
{
    protected $CommonService;
    protected $PurchaseOrderService;

    public function __construct(CommonService $CommonService, PurchaseOrderService $PurchaseOrderService)
    {
        $this->CommonService = $CommonService;
        $this->PurchaseOrderService = $PurchaseOrderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            [
                "perPage" => $perPage,
                "page" => $page,
                "order" => $order,
                "sort" => $sort,
                "status" => $status,
                "start" => $start,
                "end" => $end,
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $purchaseOrderQuery = PurchaseOrder::with("vendor")->where("deleted_at", null);
            if ($value) {
                $purchaseOrderQuery->where(function ($query) use ($value) {
                    $query->whereHas('vendor', function ($vendorQuery) use ($value) {
                        $vendorQuery->where('name', 'like', '%' . $value . '%');
                    })
                        ->orWhere('purchase_order_number', 'like', '%' . $value . '%')
                        ->orWhere('about', 'like', '%' . $value . '%')
                        ->orWhere('grand_total', 'like', '%' . $value . '%')
                        ->orWhere('purchase_order_date', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%');
                });
            }
            if ($status) {
                $purchaseOrderQuery->where('status', 'like', '%' . $status . '%');
            }
            if(!is_null($start) && !is_null($end)) $purchaseOrderQuery = $purchaseOrderQuery->whereBetween("purchase_order_date", [$start, $end]);
            $getPurchaseOrder = $purchaseOrderQuery
                ->orderBy($order, $sort)
                ->paginate($perPage);
            $totalCount = $getPurchaseOrder->total();

            $purchaseOrderArr = $this->CommonService->toArray($getPurchaseOrder);

            return [
                "data" => $purchaseOrderArr,
                "per_page" => $perPage,
                "page" => $page,
                "size" => $totalCount,
                "pages" => ceil($totalCount / $perPage)
            ];
        } catch (\Exception $e) {
            dd($e);
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
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
        try {
            $validatePurchaseOrder = $this->PurchaseOrderService->validatePurchaseOrder($request);
            if ($validatePurchaseOrder != "") throw new CustomException($validatePurchaseOrder, 400);

            $purchaseOrder = PurchaseOrder::create($request->all());

            foreach ($request->input("details") as $detail) {
                PurchaseOrderDetail::create([
                    "purchase_order_id" => $purchaseOrder->id,
                    "number" => $detail["number"],
                    "name" => $detail["name"],
                    "specification" => $detail["specification"],
                    "quantity" => $detail["quantity"],
                    "units" => $detail["units"],
                    "price" => $detail["price"],
                    "tax_id" => $detail["tax"],
                    "total_price" => $detail["total_price"],
                ]);
            }

            DB::commit();

            $getPurchaseOrder = PurchaseOrder::with("purchaseOrderDetails")->with("vendor")->where("id", $purchaseOrder->id)->where("deleted_at", null)->first();

            return ["data" => $getPurchaseOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;
            DB::rollBack();

            if (is_a($e, CustomException::class)) {
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
        try {
            $id = (int) $id;
            $getPurchaseOPurchaseOrder = PurchaseOrder::with("purchaseOrderDetails")->with("vendor")->with("vendorAttachment")->where("id", $id)->where("deleted_at", null)->first();
            if (is_null($getPurchaseOPurchaseOrder)) throw new CustomException("Purchase order tidak ditemukan", 404);

            return ["data" => $getPurchaseOPurchaseOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
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

        try {
            $id = (int) $id;
            $purchaseOrderExist = $this->CommonService->getDataById("App\Models\PurchaseOrder", $id);
            if (is_null($purchaseOrderExist)) throw new CustomException("Purchase order tidak ditemukan", 404);

            $validatePurchaseOrder = $this->PurchaseOrderService->validatePurchaseOrder($request);
            if ($validatePurchaseOrder != "") throw new CustomException($validatePurchaseOrder, 400);

            PurchaseOrder::findOrFail($id)->update($request->all());
            PurchaseOrderDetail::where("purchase_order_id", $id)->where("deleted_at", null)->delete();

            foreach ($request->input("details") as $detail) {
                PurchaseOrderDetail::create([
                    "purchase_order_id" => $id,
                    "number" => $detail["number"],
                    "name" => $detail["name"],
                    "specification" => $detail["specification"],
                    "quantity" => $detail["quantity"],
                    "units" => $detail["units"],
                    "price" => $detail["price"],
                    "tax_id" => $detail["tax"],
                    "total_price" => $detail["total_price"],
                ]);
            }

            DB::commit();

            $getPurchaseOrder = PurchaseOrder::with("purchaseOrderDetails")->with("vendor")->where("id", $id)->where("deleted_at", null)->first();

            return ["data" => $getPurchaseOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if (is_a($e, CustomException::class)) {
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

        try {
            $id = (int) $id;
            $purchaseOrderExist = $this->CommonService->getDataById("App\Models\PurchaseOrder", $id);
            if (is_null($purchaseOrderExist)) throw new CustomException("Purchase order tidak ditemukan", 404);

            PurchaseOrder::findOrFail($id)->delete();
            PurchaseOrderDetail::where("purchase_order_id", $id)->where("deleted_at", null)->delete();

            DB::commit();

            return response()->json(['message' => 'Purchase order berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function select(Request $request)
    {
        try {
            [
                "page" => $page,
                "value" => $value
            ] = $this->CommonService->getQuery($request);
            $field = $request->input("field");
            $perPage = 10;
            $status = strtolower($request->input("status", ""));
            $statusArray = explode(",", $status);

            if (is_null($field)) $field = "id";

            $purchaseOrderQuery = PurchaseOrder::where("deleted_at", null)->where($field, 'like', '%' . $value . '%');
            if ($status != "") {
                $purchaseOrderQuery->where(function ($query) use ($statusArray) {
                    $length = count($statusArray);

                    for ($i = 0; $i < $length; $i++) {
                        $statusFromArray = trim($statusArray[$i]);
                        $query->orWhere('status', 'like', '%' . $statusFromArray . '%');
                    }
                });
            }
            $getPurchaseOrder = $purchaseOrderQuery->select("id", $field)->paginate($perPage);
            $totalCount = $getPurchaseOrder->total();

            $dataArr = [];
            foreach ($getPurchaseOrder as $purchaseOrder) {
                $dataObj = [
                    "id" => $purchaseOrder->id,
                    "text" => $purchaseOrder->$field,
                ];
                array_push($dataArr, $dataObj);
            }

            $pagination = ["more" => false];
            if ($totalCount > ($perPage * $page)) {
                $pagination = ["more" => true];
            }

            return [
                "data" => $dataArr,
                "pagination" => $pagination,
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function report(Request $request)
    {
        try {
            [
                "start" => $start,
                "end" => $end,
            ] = $this->CommonService->getQuery($request);

            if (is_null($start)) $start = Carbon::now()->firstOfMonth();
            if (is_null($end)) {
                $end = Carbon::now()->lastOfMonth();
                $end->setTime(23, 59, 59);
            }

            $countTenant = Tenant::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();
            $countPurchaseOrder = PurchaseOrder::where("deleted_at", null)->whereBetween("purchase_order_date", [$start, $end])->count();
            $countPurchaseOrderPaid = PurchaseOrder::where("deleted_at", null)->whereBetween("purchase_order_date", [$start, $end])->where('status', 'Selesai')->sum('grand_total');

            return [
                "count_vendor" => $countTenant,
                "count_purchase_order" => $countPurchaseOrder,
                "count_purchase_order_paid" => $countPurchaseOrderPaid,
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function update_status(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $id = (int) $id;
            $getPurchaseOrder = $this->CommonService->getDataById("App\Models\PurchaseOrder", $id);
            if (is_null($getPurchaseOrder)) throw new CustomException("Purchase Order tidak ditemukan", 404);

            $validatePurchaseOrder = $this->PurchaseOrderService->validateStatus($request);
            if ($validatePurchaseOrder != "") throw new CustomException($validatePurchaseOrder, 400);

            $dataPayload = ["status" => $request->input("status")];

            PurchaseOrder::findOrFail($id)->update($dataPayload);

            DB::commit();

            if ($request->input("status") == 'Terkirim') {
                $purchaseOrder = PurchaseOrder::with('purchaseOrderDetails', 'vendor')->where('id', $id)->first();
                $hariIni = \Carbon\Carbon::now()->locale('id');
                $bulan = $hariIni->monthName;
                $tahun = $hariIni->format('Y');
                $dataEmail["vendorName"] = $purchaseOrder->vendor->name ?? '';
                $dataEmail["month"] = $bulan;
                $dataEmail["year"] = $tahun;
                $dataEmail["about"] = $purchaseOrder->about;
                $dataEmail["grand_total"] = $purchaseOrder->grand_total;
                $dataEmail["terbilang"] = $purchaseOrder->grand_total_spelled;
                $dataEmail["po_number"] = $purchaseOrder->purchase_order_number;

                $apiRequest = Http::get(env('BASE_URL_API') . '/api/purchase-order/' . $id);
                $response = json_decode($apiRequest->getBody());
                $data = $response->data;

                $pdf = PDF::loadView('content.pages.purchase-order.download', ['data' => $data]);
                $to = $purchaseOrder->vendor->email ?? '';

                Mail::send('emails.email-template-purchase-order', ['data' => $dataEmail], function ($message) use ($to, $pdf, $dataEmail) {
                    $name = "Purchase Order ".$dataEmail['po_number'].".pdf";
                    $message->to($to)
                        ->subject('Tanda Terima Pembayaran No Invoice : ' . $dataEmail['po_number'])
                        ->attachData($pdf->output(), $name);
                });
            }
            $getPurchaseOrder =  PurchaseOrder::with("purchaseOrderDetails")->with("vendor")->with("tenant")->where("id", $id)->where("deleted_at", null)->first();

            return ["data" => $getPurchaseOrder];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;
            DB::rollBack();

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function vendor(Request $request, $id)
    {
        try {
            [
                "perPage" => $perPage,
                "page" => $page,
                "order" => $order,
                "sort" => $sort,
                "status" => $status,
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $purchaseOrderQuery = PurchaseOrder::with("vendor")->where("vendor_id", $id)->where("deleted_at", null)->where(function ($query) {
                $query->where('status', 'like', "%Terkirim%")
                      ->orWhere('status', 'like', "%Diupload Vendor%")
                      ->orWhere('status', 'like', "%Diverifikasi Admin%")
                      ->orWhere('status', 'like', "%Selesai%");
            });

            if($status){
                $purchaseOrderQuery->where('status', 'like', "%".$status."%");
            }

            if ($value) {
                $purchaseOrderQuery->where(function ($query) use ($value) {
                    $query->whereHas('vendor', function ($vendorQuery) use ($value) {
                        $vendorQuery->where('name', 'like', '%' . $value . '%');
                    })
                        ->orWhere('purchase_order_number', 'like', '%' . $value . '%')
                        ->orWhere('about', 'like', '%' . $value . '%')
                        ->orWhere('grand_total', 'like', '%' . $value . '%')
                        ->orWhere('purchase_order_date', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%');
                });
            }
            $getPurchaseOrder = $purchaseOrderQuery
                ->select("id", "purchase_order_number", "vendor_id", "about", "grand_total", "purchase_order_date", "status")
                ->orderBy($order, $sort)
                ->paginate($perPage);
            $totalCount = $getPurchaseOrder->total();

            $purchaseOrderArr = $this->CommonService->toArray($getPurchaseOrder);

            return [
                "data" => $purchaseOrderArr,
                "per_page" => $perPage,
                "page" => $page,
                "size" => $totalCount,
                "pages" => ceil($totalCount / $perPage)
            ];
        } catch (\Exception $e) {
            dd($e);
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }
}
