<?php
namespace App\Services;

use Validator;

class ReceiptService{
    protected $CommonService;
    protected $validStatus = ["terbuat", "disetujui ka", "disetujui bm", "terkirim", "lunas"];

    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    /**
     * Fungsi yang berfungsi untuk memvalidasi data receipt yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @return String string yang berisi pesan error
     */
    public function validateReceipt($request){
        $rules = [
            // "receipt_number" => ["bail", "required", "string"],
            "grand_total" => ["bail", "required", "numeric", "gte:0"],
            "receipt_date" => ["bail", "required", "date"],
            "receipt_send_date" => ["bail", "nullable", "date", "after_or_equal:receipt_date"],
            "tenant_id" => ["bail", "required", "numeric"],
            "invoice_id" => ["bail", "required", "numeric"],
            "status" => ["bail", "required", "string"],
            "check_number" => ["bail", "nullable", "string"],
            "bank_id" => ["bail", "nullable", "numeric"],
            "paid" => ["bail", "required", "numeric", "gte:0"],
            "remaining" => ["bail", "required", "numeric"],
            "grand_total_spelled" => ["bail", "required", "string"],
            "note" => ["bail", "nullable", "string"],
            "signature_date" => ["bail", "nullable", "date"],
            "signature_image" => ["bail", "nullable", "string"],
            "signature_name" => ["bail", "nullable", "string"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
            "numeric" => "Field :attribute harus diisi dengan angka",
            "gte" => "Field :attribute harus lebih besar dari sama dengan 0",
            "date" => "Field :attribute harus diisi dengan tanggal",
            "receipt_send_date.after_or_equal" => "Field :attribute harus lebih besar dari atau sama dengan receipt date",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        if($message == ""){
            $getTenant = $this->CommonService->getDataById("App\Models\Tenant", $request->input("tenant_id"));
            $getInvoice = $this->CommonService->getDataById("App\Models\Invoice", $request->input("invoice_id"));

            if (is_null($getTenant)) $message = "Tenant tidak ditemukan";
            else if(is_null($getInvoice)) $message = "Invoice tidak ditemukan";
        }

        if($message == ""){
            $status = strtolower($request->input("status"));

            if(!in_array($status, $this->validStatus)) $message = "Status tidak valid";
        }

        if($message == "" && !is_null($request->input("bank_id"))){
            $getBank = $this->CommonService->getDataById("App\Models\Bank", $request->input("bank_id"));
            if(is_null($getBank)) $message = "Bank tidak ditemukan";
        }

        return $message;
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
