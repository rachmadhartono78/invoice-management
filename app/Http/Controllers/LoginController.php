<?php

namespace App\Http\Controllers;

use App\Helpers\CallApiHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Exception\RequestException;

class LoginController extends Controller
{
    public function index()
    {
        if(session('data')){
            return redirect('/to-do-list');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {

        try {
            $data = [
                "url" => env('BASE_URL_API') . "/api/user/login",
                "method" => "POST"
            ];

            $params =  [
                'email' => $request->email,
                'password' => $request->password
            ];

            $records = CallApiHelpers::storeAPI($data, $params);
            if (isset($records['data'])) {
                $this->setUserSession($records);
                echo json_encode(array("message" => "SUCCESS_LOGIN", "credentials" => $records['data']));
            } else {
                echo json_encode(array("message" => $records['message'], "error" => true));
                return redirect('/')->with('alert-error', $records['message']);
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '401') {
                    return redirect('/')->with('alert-error', 'Password atau User Anda Salah');
                    return '401 Password atau User Anda Salah';
                }
                if ($e->getResponse()->getStatusCode() == '403') {
                    return redirect('/')->with('alert-error', 'Role Anda Belum Diatur.');
                    return '403 Role Anda Belum Diatur';
                }
                if ($e->getResponse()->getStatusCode() == '500') {
                    return redirect('/login1')->with('alert-error', 'Maaf Anda Tidak Bisa Login.');
                    return '500 Terjadi kesalahan sistem!';
                }
            }
        }
    }

    public function logout()
    {
        Session::forget('ACCESS_TOKEN');
        Session::flush();
        return redirect()->route('login');
    }

    protected function setUserSession($auth)
    {
        
        session([
            'ACCESS_TOKEN' => $auth['token'],
            'data' => $auth['data'],
        ]);
    }
}
