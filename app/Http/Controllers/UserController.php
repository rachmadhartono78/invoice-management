<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\User;
use App\Services\CommonService;
use App\Services\UserService;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $CommonService;
    protected $UserService;

    public function __construct(CommonService $CommonService, UserService $UserService)
    {
        $this->CommonService = $CommonService;
        $this->UserService = $UserService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            $validateUser = $this->UserService->validateUser($request, true, "");
            if($validateUser != "") throw new CustomException($validateUser, 400);

            $userPayload = $request->all();
            $userPayload["password"] = Hash::make($request->input("password"));
            $userPayload["username"] = $this->UserService->createUsername($request->input("email"));

            $saveUser = User::create($userPayload);

            DB::commit();

            return ["data" => $saveUser];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if(is_a($e, CustomException::class)){
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function login(Request $request)
    {
        try{
            $validateLogin = $this->UserService->validatLoginData($request, true, "");
            if($validateLogin != "") throw new CustomException($validateLogin, 400);

            $getUser = User::with("department")
              ->with("level")
              ->where("email", $request->input("email"))
              ->where("deleted_at", null)
              ->first();
            if(is_null($getUser)) throw new CustomException("Email atau password tidak ditemukan", 404);

            $validatePassword = Hash::check($request->input("password"), $getUser['password']);
            if(!$validatePassword) throw new CustomException("Email atau password tidak ditemukan", 404);

            $secretKey = env("TOKEN_SECRET_KEY");
            $tokenPayload = [
                "id" => $getUser["id"],
                "name" => $getUser["name"],
            ];

            $token = JWT::encode($tokenPayload, $secretKey, 'HS256');

            return [
                "token" => $token,
                "data" => $getUser
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            [
                "perPage" => $perPage,
                "page" => $page,
                "order" => $order,
                "sort" => $sort,
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $userQuery = User::with("department")->with("level")->where("deleted_at", null);
            if($value){
                $userQuery->where(function ($query) use ($value) {
                    $query->where('name', 'like', '%' . $value . '%')
                        ->orWhere('email', 'like', '%' . $value . '%')
                        ->orWhere('department_id', 'like', '%' . $value . '%')
                        ->orWhere('level_id', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%');
                });
            }
            $getUsers = $userQuery
            ->select("id","name", "email", "department_id", "level_id", "status")
            ->orderBy($order, $sort)
            ->paginate($perPage);
            $totalCount = $getUsers->total();

            $userArr = $this->CommonService->toArray($getUsers);

            return [
                "data" => $userArr,
                "per_page" => $perPage,
                "page" => $page,
                "size" => $totalCount,
                "pages" => ceil($totalCount/$perPage)
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

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $id = (int) $id;
            $getUser = User::with("department")
              ->with("level")
              ->where("id", $id)
              ->where("deleted_at", null)
              ->first();
            if (is_null($getUser)) throw new CustomException("User tidak ditemukan", 404);

            return ["data" => $getUser];
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $id = (int) $id;
            $userExist = $this->CommonService->getDataById("App\Models\User", $id);
            if (is_null($userExist)) throw new CustomException("User tidak ditemukan", 404);

            $validateUser = $this->UserService->validateUser($request, false, $id);
            if($validateUser != "") throw new CustomException($validateUser, 400);

            $userPayload = $request->all();
            $userPayload["password"] = Hash::make($request->input("password"));
            // if(isset($userPayload["username"])) unset($userPayload["username"]);

            User::findOrFail($id)->update($userPayload);
            DB::commit();

            $getUser = $this->CommonService->getDataById("App\Models\User", $id);

            return ["data" => $getUser];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if(is_a($e, CustomException::class)){
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

        try{
            $id = (int) $id;
            $userExist = $this->CommonService->getDataById("App\Models\User", $id);
            if (is_null($userExist)) throw new CustomException("User tidak ditemukan", 404);

            User::findOrFail($id)->delete();

            DB::commit();

            return response()->json(['message' => 'User berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            DB::rollBack();

            if(is_a($e, CustomException::class)){
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

            $countUser = User::where("deleted_at", null)->count();

            return [
                "count_user" => $countUser,
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
