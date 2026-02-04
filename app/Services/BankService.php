<?php
namespace App\Services;

use Validator;
use App\Models\Bank;

class BankService{
    /**
     * Fungsi yang berfungsi untuk memvalidasi data bank yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @param Boolean $isCreate Diisi true jika fungsi ini dipanggil pada saat bank dibuat, selain itu false
     * @param Integer $id Integer yang berisi id dari data yang diupdate, hanya diisi jika `$isCreate` diisi false
     * @return String string yang berisi pesan error
     */
    public function validateBank($request, $isCreate = true, $id = "", ){
        $rules = [
            "name" => ["bail", "required", "string"],
            'account_name' => ["bail", "required", "string"],
            'account_number' => ["bail", "required", "string"],
            'branch_name' => ["bail", "required", "string"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        if($message == ""){
            $bankExist = Bank::where("name", $request->name)->where("deleted_at", null);
            if(!$isCreate) $bankExist = $bankExist->where("id", "!=", $id);
            $bankExist = $bankExist->first();
            if (!is_null($bankExist)) $message = "Bank exist";
        }

        return $message;
    }
}
