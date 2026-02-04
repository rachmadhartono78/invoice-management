<?php
namespace App\Services;

use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\Tax;
use Validator;

class InvoiceService{
    protected $CommonService;
    protected $validStatus = ["terbuat", "disetujui ca", "disetujui ka", "disetujui bm", "terkirim", "kurang bayar", "lunas"];

    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    /**
     * Fungsi yang berfungsi untuk memvalidasi data invoice yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @return String string yang berisi pesan error
     */
    public function validateInvoice($request){
        $rules = [
            "tenant_id" => ["bail", "required", "numeric"],
            "grand_total" => ["bail", "required", "numeric", "gte:0"],
            "invoice_date" => ["bail", "required", "date"],
            "invoice_due_date" => ["bail", "required", "date", "after_or_equal:invoice_date"],
            "status" => ["bail", "required", "string"],
            "notes" => ["bail", "nullable", "string"],
            "term_and_condition" => ["bail", "nullable", "string"],

            "details" => ["bail", "required", "array"],
            "details.*.item" => ["bail", "required", "string"],
            "details.*.description" => ["bail", "nullable", "string"],
            "details.*.quantity" => ["bail", "required", "numeric"],
            "details.*.price" => ["bail", "required", "numeric"],
            "details.*.tax_id" => ["bail", "nullable", "string"],
            "details.*.discount" => ["bail", "nullable", "numeric"],
            "details.*.total_price" => ["bail", "required", "numeric"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
            "numeric" => "Field :attribute harus diisi dengan angka",
            "grand_total.gte" => "Field :attribute harus lebih besar dari sama dengan 0",
            "invoice_due_date.after_or_equal" => "Field :attribute harus lebih besar dari atau sama dengan invoice date",
            "date" => "Field :attribute harus diisi dengan tanggal",
            "array" => "Field :attribute harus diisi dengan array",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        if($message == ""){
            $status = strtolower($request->input("status"));

            if(!in_array($status, $this->validStatus)) $message = "Status tidak valid";
        }

        if($message == ""){
            $getTenant = $this->CommonService->getDataById("App\Models\Tenant", $request->input("tenant_id"));

            if (is_null($getTenant)) $message = "Tenant tidak ditemukan";
        }

        return $message;
    }

    /**
     * Fungsi untuk mengupdate status invoice ke `Kurang Bayar` jika
     * invoice belum terbayar semuanya dan ke `Lunas` jika invoice
     * sudah terbayar
     *
     * @param Number $invoiceId id invoice yang akan diupdate statusnya
     * @return Boolean true
     */
    public function updateInvoiceStatus($invoiceId){
        $getReceipt = Receipt::select("invoice_id", "paid")->where("invoice_id", $invoiceId)->where("deleted_at", null)->get();
        $receiptArr = $this->CommonService->toArray($getReceipt);

        $getInvoice = $this->CommonService->getDataById("App\Models\Invoice", $invoiceId);

        $totalPaid = 0;
        foreach($receiptArr as $receiptObj){
            $totalPaid += $receiptObj->paid;
        }

        $invoiceStatus = "";
        if($totalPaid >= $getInvoice['grand_total']) $invoiceStatus = "Lunas";
        else $invoiceStatus = "Kurang Bayar";

        $updateObj = ["status" => $invoiceStatus];
        Invoice::findOrFail($invoiceId)->update($updateObj);

        return true;
    }

    /**
     * Fungsi yang berfungsi untuk memvalidasi data status yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @return String string yang berisi pesan error
     */
    public function validateStatus($request){
        $rules = [
            "status" => ["bail", "required", "string"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        if($message == ""){
            $status = strtolower($request->input("status"));

            if(!in_array($status, $this->validStatus)) $message = "Status tidak valid";
        }

        return $message;
    }
}
