<?php
namespace App\Services;

use Validator;
use App\Models\Bank;

class VendorService{
    /**
     * Fungsi yang berfungsi untuk memvalidasi data vendor yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @return String string yang berisi pesan error
     */
    public function validateVendor($request){
        $rules = [
            "name" => ["bail", "required", "string"],
            'email' => ["bail", "required", "email", "string"],
            'phone' => ["bail", "required", "numeric"],
            'address' => ["bail", "required", "string"],
            'floor' => ["bail", "required", "string"],
            'status' => ["bail", "required", "string"],
        ];
        $errorMessages = [
          "required" => "Field :attribute harus diisi",
          "string" => "Field :attribute harus diisi dengan string",
          "email" => "Field :attribute harus ditulis dengan format email yang valid",
          "numeric" => "Field :attribute harus diisi dengan angka",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        return $message;
    }
}
