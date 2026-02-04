<?php
namespace App\Services;

use Validator;
use App\Models\Bank;

class TaxService{
    /**
     * Fungsi yang berfungsi untuk memvalidasi data tax yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @return String string yang berisi pesan error
     */
    public function validateTax($request){
        $rules = [
            "name" => ["bail", "required", "string"],
            "rate" => ["bail", "required", "numeric", "gte:0"],
            "description" => ["bail", "required", "string"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
            "numeric" => "Field :attribute harus diisi dengan angka",
            "gte" => "Field :attribute harus lebih besar atau sama dengan 0",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        return $message;
    }

    /**
     * Fungsi yang digunakan untuk menmabahkan field `rate_percentage`
     *
     * @param Array $taxArr Array yang berisi object tax yang akan ditambahkan field `rate_percentage`
     * @return Array Array yang sudah ditambahkan field `rate_percentage`
     */
    public function addRatePercentage($taxArr){
        foreach($taxArr as $taxObj){
            $taxObj["rate_percentage"] = "{$taxObj['rate']}%";
        }

        return $taxArr;
    }
}
