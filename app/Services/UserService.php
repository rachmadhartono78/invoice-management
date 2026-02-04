<?php
namespace App\Services;

use App\Models\Department;
use App\Models\User;
use Validator;

class UserService{
    protected $CommonService;

    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    /**
     * Fungsi yang berfungsi untuk memvalidasi data user yang diinput oleh user
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi input dari user
     * @param Boolean $isCreate Diisi true jika fungsi ini dipanggil pada saat bank dibuat, selain itu false
     * @param Integer $id Integer yang berisi id dari data yang diupdate, hanya diisi jika `$isCreate` diisi false
     * @return String string yang berisi pesan error
     */
    public function validateUser($request, $isCreate = true, $id = ""){
        $rules = [
          'name' => ["bail", "required", "string"],
          'email' => ["bail", "required", "string", "email"],
          'username' => ["bail", "nullable", "string"],
          'password' => ["bail", "required", "string"],
          'department_id' => ["bail", "required", "numeric"],
          'level_id' => ["bail", "required", "numeric"],
          'status' => ["bail", "required", "string"],
          'image' => ["bail", "nullable", "string"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "string" => "Field :attribute harus diisi dengan string",
            "email" => "Field :attribute harus ditulis dengan format email yang valid",
            "numeric" => "Field :attribute harus diisi dengan angka"
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        if($message == ""){
            $emailExist = User::where("email", $request->input("email"))->where("deleted_at", null);
            if(!$isCreate) $emailExist = $emailExist->where("id", "!=", $id);
            $emailExist = $emailExist->first();

            if(!is_null($emailExist)) $message = "Email sudah digunakan";
        }

        if($message == "" && $request->input("username")){
            $usernameExist = User::where("username", $request->input("username"))->where("deleted_at", null);
            if(!$isCreate) $usernameExist = $usernameExist->where("id", "!=", $id);
            $usernameExist = $usernameExist->first();

            if(!is_null($usernameExist)) $message = "Username sudah digunakan";
        }

        if($message == ""){
            $departmentExist = $this->CommonService->getDataById("App\Models\Department", $request->input("department_id"));
            $levelExist = $this->CommonService->getDataById("App\Models\Level", $request->input("level_id"));

            if(is_null($departmentExist)) $message = "Department tidak ditemukan";
            else if(is_null($levelExist)) $message = "Level tidak ditemukan";
        }

        return $message;
    }

    /**
     * Fungsi untuk membuat username berdasarkan email user. Fungsi ini hanya dipanggil ketika register user
     *
     * @param String $email Email dari user
     */
    public function createUsername($email){
        $splitEmail = explode("@", $email)[0];
        $toLower = strtolower($splitEmail);
        $removePunc = preg_replace('/[[:punct:]]/', '_', $toLower);
        $username = $removePunc;

        $countUsername = User::where("username", $removePunc)->where("deleted_at", null)->paginate(1)->total();
        if($countUsername) $username = "{$username}{$countUsername}";
        return $username;
    }

    /**
     * Fungsi yang berfungsi untuk memvalidasi data login yang user isi
     *
     * @param \Illuminate\Http\Request $request Object Request yang berisi data login dari user
     * @return String string yang berisi pesan error
     */
    public function validatLoginData($request){
        $rules = [
          'email' => ["bail", "required", "email"],
          'password' => ["bail", "required"],
        ];
        $errorMessages = [
            "required" => "Field :attribute harus diisi",
            "email" => "Field :attribute harus ditulis dengan format email yang valid",
        ];

        $validator = Validator::make($request->all(), $rules, $errorMessages);

        $message = "";
        if ($validator->fails()) $message = implode(', ', $validator->errors()->all());

        return $message;
    }
}
