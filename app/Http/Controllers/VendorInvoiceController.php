<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\PurchaseOrder;
use App\Models\Receipt;
use App\Models\Tenant;
use App\Models\VendorAttachment;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;

class VendorInvoiceController extends Controller
{
    protected $CommonService;

    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
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
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $vendorId = $request->input("vendor_id", null);

            $purchaseOrderQuery = PurchaseOrder::with("vendor")->with("tenant")->where("deleted_at", null)->where('status', 'like', '%terkirim%');
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
            if (!is_null($vendorId)) {
                $purchaseOrderQuery = $purchaseOrderQuery->where("vendor_id", $vendorId);
            }
            $getPurchaseOrder = $purchaseOrderQuery
                ->select("purchase_order_number", "vendor_id", "about", "grand_total", "purchase_order_date", "status")
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
        } catch (\Throwable $e) {
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

    public function add_attachment(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $id = (int) $id;
            $purchaseOrderExist = $this->CommonService->getDataById("App\Models\PurchaseOrder", $id);
            if (is_null($purchaseOrderExist)) throw new CustomException("Purchase order tidak ditemukan", 404);

            foreach ($request->input("attachments") as $attachment) {
                VendorAttachment::create([
                    "purchase_order_id" => $id,
                    "attachment" => $attachment['attachment'],
                    "uraian" => $attachment['uraian'],

                ]);
            }

            DB::commit();
            $getPurchaseOrder = PurchaseOrder::with("purchaseOrderDetails")->with("vendor")->with("tenant")->with("vendorAttachment")->where("id", $id)->where("deleted_at", null)->first();
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

    public function deleteVendorAttachment($id){
        DB::beginTransaction();
        try {
            $id = (int) $id;
            $vendorAttachmentExist = VendorAttachment::find($id);
            if (is_null($vendorAttachmentExist)) throw new CustomException("Attachment tidak ditemukan", 404);

            $vendorAttachmentExist->delete();

            DB::commit();
            return response()->json(['message' => 'Attachment berhasil dihapus'], 200);
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

    public function vendorInvoiceReportExport(Request $request)
    {
        try {
            [
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $vendorId = $request->input("vendor_id", null);

            $purchaseOrderQuery = PurchaseOrder::with("vendor")->with("tenant")->where("deleted_at", null)->where('status', 'like', '%disetujui bm%');
            if ($value) {
                $purchaseOrderQuery->where(function ($query) use ($value) {
                    $query->whereHas('vendor', function ($vendorQuery) use ($value) {
                        $vendorQuery->where('name', 'like', '%' . $value . '%');
                    })
                        ->orWhere('purchase_order_number', 'like', '%' . $value . '%')
                        ->orWhere('about', 'like', '%' . $value . '%')
                        ->orWhere('grand_total', 'like', '%' . $value . '%')
                        ->orWhere('purchase_order_date', 'like', '%' . $value . '%');
                });
            }
            if (!is_null($vendorId)) {
                $purchaseOrderQuery = $purchaseOrderQuery->where("vendor_id", $vendorId);
            }
            $getPurchaseOrder = $purchaseOrderQuery
                ->select("purchase_order_number", "vendor_id", "about", "grand_total", "purchase_order_date", "status")
                ->get();

            $purchaseOrderArr = $this->CommonService->toArray($getPurchaseOrder);

            return [
                "data" => $purchaseOrderArr,
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

            $countVendorInvoice = 0;
            $countVendorInvoicePaid = 0;

            $countVendorInvoice = PurchaseOrder::where("deleted_at", null)->whereBetween("created_at", [$start, $end]);
            if(!is_null($request->vendor_id)){
                $countVendorInvoice = $countVendorInvoice->where("vendor_id", $request->vendor_id);
                $countVendorInvoice = $countVendorInvoice->where(function ($query) {
                    $query->where('status', 'like', "%Terkirim%")
                          ->orWhere('status', 'like', "%Diupload Vendor%")
                          ->orWhere('status', 'like', "%Diverifikasi Admin%")
                          ->orWhere('status', 'like', "%Selesai%");
                });
            }
            $countVendorInvoice = $countVendorInvoice->count();
            $countVendorInvoicePaid = PurchaseOrder::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->where('status', 'like', "%Selesai%");
            if(!is_null($request->vendor_id)){
                $countVendorInvoicePaid = $countVendorInvoicePaid->where("vendor_id", $request->vendor_id);
            }
            $countVendorInvoicePaid = $countVendorInvoicePaid->sum("grand_total");
            return [
                "count_purchase_order" => $countVendorInvoice,
                "count_purchase_order_paid" => $countVendorInvoicePaid,
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
