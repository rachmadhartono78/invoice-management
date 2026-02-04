<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Receipt;
use App\Models\Tenant;
use App\Services\CommonService;
use App\Services\InvoiceService;
use App\Services\ReceiptService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDF;
use Illuminate\Support\Facades\Mail;

class ReceiptController extends Controller
{
    protected $CommonService;
    protected $ReceiptService;
    protected $InvoiceService;

    public function __construct(CommonService $CommonService, ReceiptService $ReceiptService, InvoiceService $InvoiceService)
    {
        $this->CommonService = $CommonService;
        $this->ReceiptService = $ReceiptService;
        $this->InvoiceService = $InvoiceService;
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

            $receiptQuery = Receipt::with("invoice")->with("tenant")->with("bank")->where("deleted_at", null);
            if ($value) {
                $receiptQuery->where(function ($query) use ($value) {
                    $query->whereHas('tenant', function ($tenantQuery) use ($value) {
                        $tenantQuery->where('name', 'like', '%' . $value . '%')
                            ->orWhere('company', 'like', '%' . $value . '%');
                    })
                        ->orWhere('receipt_number', 'like', '%' . $value . '%')
                        ->orWhere('grand_total', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%')
                        ->orWhere('receipt_date', 'like', '%' . $value . '%')
                        ->orWhere('receipt_send_date', 'like', '%' . $value . '%');
                });
            }
            if($status){
                $receiptQuery->where('status', 'like', '%' . $status . '%');
            }
            if(!is_null($start) && !is_null($end)) $receiptQuery = $receiptQuery->whereBetween("receipt_date", [$start, $end]);
            $getReceipts = $receiptQuery
                ->select("id", "receipt_number", "tenant_id", "invoice_id", "bank_id", "grand_total", "receipt_date", "receipt_send_date", "status", "paid")
                ->orderBy($order, $sort)
                ->paginate($perPage);
            $totalCount = $getReceipts->total();

            $receiptArr = $this->CommonService->toArray($getReceipts);

            return [
                "data" => $receiptArr,
                "per_page" => $perPage,
                "page" => $page,
                "size" => $totalCount,
                "pages" => ceil($totalCount / $perPage)
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validateReceipt = $this->ReceiptService->validateReceipt($request);
            if ($validateReceipt != "") throw new CustomException($validateReceipt, 400);

            $receipt = Receipt::create($request->all());
            $this->InvoiceService->updateInvoiceStatus($request->input("invoice_id"));
            DB::commit();

            $getReceipt = Receipt::with("invoice")
                ->with("tenant")
                ->with("bank")
                ->where("id", $receipt->id)
                ->where("deleted_at", null)
                ->first();

            return ["data" => $getReceipt];
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
            $getReceipt = Receipt::with("invoice")->with("tenant")->with("bank")->where("id", $id)->where("deleted_at", null)->first();
            if (is_null($getReceipt)) throw new CustomException("Tanda terima tidak ditemukan", 404);

            return ["data" => $getReceipt];
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
            $receiptExist = $this->CommonService->getDataById("App\Models\Receipt", $id);
            if (is_null($receiptExist)) throw new CustomException("Tanda terima tidak ditemukan", 404);

            // $validateReceipt = $this->ReceiptService->validateReceipt($request);
            // if ($validateReceipt != "") throw new CustomException($validateReceipt, 400);

            Receipt::findOrFail($id)->update($request->all());
            $this->InvoiceService->updateInvoiceStatus($request->input("invoice_id"));
            DB::commit();

            $getReceipt = Receipt::with("invoice")
                ->with("tenant")
                ->with("bank")
                ->where("id", $id)
                ->where("deleted_at", null)
                ->first();

            return ["data" => $getReceipt];
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
            $receiptExist = $this->CommonService->getDataById("App\Models\Receipt", $id);
            if (is_null($receiptExist)) throw new CustomException("Tanda terima tidak ditemukan", 404);

            Receipt::findOrFail($id)->delete();
            DB::commit();

            return response()->json(['message' => 'Tanda terima berhasil dihapus'], 200);
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

            $receiptQuery = Receipt::where("deleted_at", null)->where($field, 'like', '%' . $value . '%');
            if ($status != "") {
                $receiptQuery->where(function ($query) use ($statusArray) {
                    $length = count($statusArray);

                    for ($i = 0; $i < $length; $i++) {
                        $statusFromArray = trim($statusArray[$i]);
                        $query->orWhere('status', 'like', '%' . $statusFromArray . '%');
                    }
                });
            }
            $getReceipt = $receiptQuery->select("id", $field)->paginate($perPage);
            $totalCount = $getReceipt->total();

            $dataArr = [];
            foreach ($getReceipt as $bankObj) {
                $dataObj = [
                    "id" => $bankObj->id,
                    "text" => $bankObj->$field,
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
            $countReceiptSent = Receipt::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->where("status", "like", "%Terkirim%")->count();
            $countReceiptNotSent = Receipt::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->where("status", "!=", "Terkirim")->count();

            return [
                "count_tenant" => $countTenant,
                "count_receipt_sent" => $countReceiptSent,
                "count_receipt_not_sent" => $countReceiptNotSent,
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
            $getReceipt = $this->CommonService->getDataById("App\Models\Receipt", $id);
            if (is_null($getReceipt)) throw new CustomException("Tanda terima tidak ditemukan", 404);

            $validateReceipt = $this->ReceiptService->validateStatus($request);
            if ($validateReceipt != "") throw new CustomException($validateReceipt, 400);

            $dataPayload = ["status" => $request->input("status")];
            if ($request->input("status") == 'Terkirim') {
                $dataPayload["receipt_send_date"] = Carbon::now();
            }

            Receipt::findOrFail($id)->update($dataPayload);

            DB::commit();

            if ($request->input("status") == 'Terkirim') {
                $receipt = Receipt::with('invoice', 'tenant')->where('id', $id)->first();
                $hariIni = \Carbon\Carbon::now()->locale('id');
                $bulan = $hariIni->monthName;
                $tahun = $hariIni->format('Y');
                $dataEmail["tenantName"] = $receipt->tenant->company ?? '';
                $dataEmail["month"] = $bulan;
                $dataEmail["year"] = $tahun;
                $dataEmail["paid"] = $receipt->paid;
                $dataEmail["terbilang"] = $receipt->grand_total_spelled;
                $dataEmail["invoice"] = $receipt->invoice->invoice_number;

                $apiRequest = Http::get(env('BASE_URL_API') . '/api/receipt/' . $id);
                $response = json_decode($apiRequest->getBody());
                $data = $response->data;

                $pdf = PDF::loadView('content.pages.tanda-terima.download', ['data' => $data]);
                $to = $receipt->tenant->email ?? '';

                Mail::send('emails.email-template-tandaterima', ['data' => $dataEmail], function ($message) use ($to, $pdf, $dataEmail) {
                    $name = "Tanda Terima ".$dataEmail['invoice'].".pdf";
                    $message->to($to)
                        ->subject('Tanda Terima Pembayaran No Invoice : ' . $dataEmail['invoice'])
                        ->attachData($pdf->output(), $name);
                });
            }
            $getReceipt = Receipt::with("invoice")
                ->with("tenant")
                ->with("bank")
                ->where("id", $id)
                ->where("deleted_at", null)
                ->first();

            return ["data" => $getReceipt];
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

    public function receiptReportExport(Request $request)
    {
        try {
            [
                // "perPage" => $perPage,
                // "page" => $page,
                // "order" => $order,
                // "sort" => $sort,
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $receiptQuery = Receipt::with("invoice")->with("tenant")->with("bank")->where("deleted_at", null);
            if ($value) {
                $receiptQuery->where(function ($query) use ($value) {
                    $query->whereHas('tenant', function ($tenantQuery) use ($value) {
                        $tenantQuery->where('name', 'like', '%' . $value . '%')
                            ->orWhere('company', 'like', '%' . $value . '%');
                    })
                        ->orWhere('receipt_number', 'like', '%' . $value . '%')
                        ->orWhere('grand_total', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%')
                        ->orWhere('receipt_date', 'like', '%' . $value . '%')
                        ->orWhere('receipt_send_date', 'like', '%' . $value . '%');
                });
            }
            $getReceipts = $receiptQuery
                ->select("id", "receipt_number", "tenant_id", "invoice_id", "bank_id", "grand_total", "receipt_date", "receipt_send_date", "status", "paid")
                ->get();
            // $totalCount = $getReceipts->total();

            $receiptArr = $this->CommonService->toArray($getReceipts);

            return [
                "data" => $receiptArr,
                // "per_page" => $perPage,
                // "page" => $page,
                // "size" => $totalCount,
                // "pages" => ceil($totalCount / $perPage)
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
}
