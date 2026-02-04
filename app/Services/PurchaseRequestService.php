<?php
namespace App\Services;

use Validator;

class PurchaseRequestService{
    protected $CommonService;
    protected $validStatus = ["terbuat", "disetujui ka", "disetujui bm", "terkirim", "selesai"];

    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    /**
     * Fungsi yang berfungsi untuk memvalidasi data purchase request yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @return String string yang berisi pesan error
     */
    public function validatePurchaseRequest($request){
        $rules = [
            "department_id" => ["bail", "required", "string"],
            "proposed_purchase_price" => ["bail", "required", "numeric", "gte:0"],
            "budget_status" => ["bail", "required", "string"],
            "request_date" => ["bail", "required", "date"],
            "status" => ["bail", "required", "string"],
            "requester" => ["bail", "required", "string"],
            "total_budget" => ["bail", "required", "numeric", "gte:0"],
            "remaining_budget" => ["bail", "required", "numeric"],
            "material_request_id" => ["bail", "required", "numeric"],
            "additional_note" => ["bail", "nullable", "string"],

            "details" => ["bail", "required", "array"],
            "details.*.number" => ["bail", "required", "numeric"],
            "details.*.part_number" => ["bail", "required", "string"],
            "details.*.last_buy_date" => ["bail", "required", "date"],
            "details.*.last_buy_quantity" => ["bail", "required", "numeric"],
            "details.*.last_buy_stock" => ["bail", "required", "numeric"],
            "details.*.description" => ["bail", "required", "string"],
            "details.*.quantity" => ["bail", "required", "numeric"],

            "signatures" => ["bail", "nullable", "array"],
            "signatures.*.type" => ["bail", "nullable", "string"],
            "signatures.*.name" => ["bail", "nullable", "string"],
            "signatures.*.signature" => ["bail", "nullable", "string"],
            "signatures.*.date" => ["bail", "nullable", "date"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
            "date" => "Field :attribute harus diisi dengan tanggal",
            "gte" => "Field :attribute harus lebih besar atau sama dengan 0",
            "numeric" => "Field :attribute harus diisi dengan angka",
            "array" => "Field :attribute harus diisi dengan array",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        if($message == ""){
            $validBudgetStatus = ["sesuai-budget", "penting", "1-bulan", "1-minggu", "diluar-budget"];

            $budgetStatus = strtolower($request->input("budget_status"));
            if(!in_array($budgetStatus, $validBudgetStatus)) $message = "Status budget tidak ditemukan";
        }

        if($message == ""){
            $materialRequestExist = $this->CommonService->getDataById("App\Models\MaterialRequest", $request->input("material_request_id"));
            $departmentExist = $this->CommonService->getDataById("App\Models\Department", $request->input("department_id"));

            if(is_null($materialRequestExist)) $message = "Material request tidak ditemukan";
            else if(is_null($departmentExist)) $message = "Department tidak ditemukan";
        }

        if($message == ""){
            $status = strtolower($request->input("status"));

            if(!in_array($status, $this->validStatus)) $message = "Status tidak valid";
        }

        if($message == "" && !is_null($request->input("signatures"))){
            $validType = ["checked by", "known by", "prepared by"];

            foreach($request->input("signatures") as $signature){
                $type = strtolower($signature['type']);
                if(!in_array($type, $validType)){
                    $message = "Signature type tidak ditemukan";
                    break;
                }
            }
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
