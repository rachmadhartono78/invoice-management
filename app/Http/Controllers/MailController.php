<?php

namespace App\Http\Controllers;

use Validator;
use App\Exceptions\CustomException;
use App\Mail\EmailWithAttachment;
use App\Models\Invoice;
use App\Models\Receipt;
use App\Services\CommonService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    protected $CommonService;

    public function __construct(CommonService $CommonService)
    {
        $this->CommonService = $CommonService;
    }

    public function send(Request $request)
    {
        // try{
            $rules = [
                "data_id" => ["bail", "required", "numeric"],
                "data_type" => ["bail", "required", "string"],
            ];
            $errorMessages = [
                "required" => "Field :attribute harus diisi",
                "numeric" => "Field :attribute harus diisi dengan angka",
                "string" => "Field :attribute harus diisi dengan string",
            ];

            $validator = Validator::make($request->all(), $rules, $errorMessages);
            if ($validator->fails()) throw new CustomException( implode(', ', $validator->errors()->all()), 400);

            $dataId = $request->input("data_id");
            $dataType = strtolower($request->input("data_type"));

            $validDataType = ["invoice", "receipt"];
            if(!in_array($dataType, $validDataType)) throw new CustomException("Data type tidak ditemukan");

            $getData = [];
            $recipient = [];
            $filePath = "";
            $fileName = "";

            if($dataType == "invoice"){
                $getData = Invoice::with("invoiceDetails.tax")->
                    with("tenant")->
                    with("bank")->
                    where("id", $dataId)->
                    where("deleted_at", null)->first();

                $viewName = "emails.invoice-pdf";
            } else if($dataType == "receipt"){
                $getData = Receipt::with("invoice")->
                    with("tenant")->
                    with("bank")->
                    where("id", $dataId)->
                    where("deleted_at", null)->first();

                $viewName = "emails.tanda-terima-pdf";
            }

            if (is_null($getData)) throw new CustomException("Data dengan id ini tidak ditemukan");
            $dataJson = json_decode( json_encode($getData) );

            $recipient = $dataJson->tenant;
            $data = ["data" => $dataJson];
            $fileName = $dataType . "-" . $getData->id . ".pdf";

            $dataPdf = SnappyPdf::loadView($viewName, $data)->setOption('enable-javascript', true);
            $filePath = base_path("public/pdf/". $fileName);
            $dataPdf->save($filePath, true);

            Mail::to($recipient->email)->send(new EmailWithAttachment($recipient, $filePath, $fileName));

            return [
                "message" => "Email berhasil dikirim"
            ];
        // } catch (\Throwable $e) {
        //     $errorMessage = "Internal server error";
        //     $errorStatusCode = 500;

        //     if(is_a($e, CustomException::class)){
        //         $errorMessage = $e->getMessage();
        //         $errorStatusCode = $e->getStatusCode();
        //     }

        //     return response()->json(['message' => $errorMessage], $errorStatusCode);
        // }
    }
}
