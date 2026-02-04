<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\DamageReport;
use App\Models\DamageReportDetail;
use App\Models\DamageReportSignature;
use App\Models\Tenant;
use App\Models\Ticket;
use App\Services\CommonService;
use App\Services\DamageReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DamageReportController extends Controller
{
    protected $CommonService;
    protected $DamageReportService;

    public function __construct(CommonService $CommonService, DamageReportService $DamageReportService)
    {
        $this->CommonService = $CommonService;
        $this->DamageReportService = $DamageReportService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            [
                "perPage" => $perPage,
                "page" => $page,
                "order" => $order,
                "sort" => $sort,
                "value" => $value,
                "status" => $status
            ] = $this->CommonService->getQuery($request);

            $damageReportQuery = DamageReport::with("ticket")->where("deleted_at", null);
            if($value){
                $damageReportQuery->where(function ($query) use ($value) {
                    $query->where('damage_report_number', 'like', '%' . $value . '%')
                        ->orWhere('scope', 'like', '%' . $value . '%')
                        ->orWhere('classification', 'like', '%' . $value . '%')
                        ->orWhere('damage_report_date', 'like', '%' . $value . '%')
                        ->orWhere('action_plan_date', 'like', '%' . $value . '%')
                        ->orWhere('status', 'like', '%' . $value . '%');
                });
            }
            if($status){
                $damageReportQuery->where('status', 'like', '%' . $status . '%');
            }
            $getTickets = $damageReportQuery->orderBy($order, $sort)->paginate($perPage);
            $totalCount = $getTickets->total();

            $damageReportArr = $this->CommonService->toArray($getTickets);
            foreach($damageReportArr as $damageReportObj){
              $damageReportObj["classification"] = $this->CommonService->getClassificationOrScope($damageReportObj["classification"], "classification");
              $damageReportObj["scope"] = $this->CommonService->getClassificationOrScope($damageReportObj["scope"], "scope");
            }

            return [
                "data" => $damageReportArr,
                "per_page" => $perPage,
                "page" => $page,
                "size" => $totalCount,
                "pages" => ceil($totalCount / $perPage)
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validateDamageReport = $this->DamageReportService->validateDamageReport($request);
            if ($validateDamageReport != "") throw new CustomException($validateDamageReport, 400);

            $damageReport = DamageReport::create($request->all());
            if (!is_null($request->input("details"))) {
                foreach ($request->input('details') as $detail) {
                    DamageReportDetail::create([
                        'damage_report_id' => $damageReport->id,
                        'category' => $detail['category'],
                        'location' => $detail['location'],
                        'total' => $detail['total'],
                    ]);
                }
            }

            // if (!is_null($request->input("signatures"))) {
            //     foreach ($request->input('signatures') as $signature) {
            //         DamageReportSignature::create([
            //             'damage_report_id' => $damageReport->id,
            //             'type' => $signature['type'],
            //             'name' => $signature['name'],
            //             'signature' => $signature['signature'],
            //             'date' => $signature['date'],
            //         ]);
            //     }
            // }

            $dataPayload = [ "status" => "Selesai" ];
            Ticket::findOrFail($request->input("ticket_id"))->update($dataPayload);

            DB::commit();
            $getDamageReport = DamageReport::with("damageReportDetails")->with("damageReportSignatures")->with("ticket")->where("id", $damageReport->id)->where("deleted_at", null)->first();

            $getDamageReport["classification"] = $this->CommonService->getClassificationOrScope($getDamageReport["classification"], "classification");
            $getDamageReport["scope"] = $this->CommonService->getClassificationOrScope($getDamageReport["scope"], "scope");

            return ["data" => $getDamageReport];
        } catch (\Exception $e) {
            dd($e);
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;
            DB::rollBack();

            if (is_a($e, CustomException::class)) {
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
        try {
            $id = (int) $id;
            $getDamageReport = DamageReport::with("damageReportDetails")->with("damageReportSignatures")->with("ticket")->where("id", $id)->where("deleted_at", null)->first();
            if (is_null($getDamageReport)) throw new CustomException("Laporan kerusakan tidak ditemukan", 404);

            // $getDamageReport["classification"] = $this->CommonService->getClassificationOrScope($getDamageReport["classification"], "classification");
            // $getDamageReport["scope"] = $this->CommonService->getClassificationOrScope($getDamageReport["scope"], "scope");

            return ["data" => $getDamageReport];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
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

        try {
            $id = (int) $id;
            $damageReportExist = $this->CommonService->getDataById("App\Models\DamageReport", $id);
            if (is_null($damageReportExist)) throw new CustomException("Laporan kerusakan tidak ditemukan", 404);

            $validateDamageReport = $this->DamageReportService->validateDamageReport($request);
            if ($validateDamageReport != "") throw new CustomException($validateDamageReport, 400);

            DamageReport::findOrFail($id)->update($request->all());
            DamageReportDetail::where("damage_report_id", $id)->where("deleted_at", null)->delete();
            DamageReportSignature::where("damage_report_id", $id)->where("deleted_at", null)->delete();

            if (!is_null($request->input("details"))) {
                foreach ($request->input('details') as $detail) {
                    DamageReportDetail::create([
                        'damage_report_id' => $id,
                        'category' => $detail['category'],
                        'location' => $detail['location'],
                        'total' => $detail['total'],
                    ]);
                }
            }

            if (!is_null($request->input("signatures"))) {
                foreach ($request->input('signatures') as $signature) {
                    DamageReportSignature::create([
                        'damage_report_id' => $id,
                        'type' => $signature['type'],
                        'name' => $signature['name'],
                        'signature' => $signature['signature'],
                        'date' => $signature['date'],
                    ]);
                }
            }

            DB::commit();
            $getDamageReport = DamageReport::with("damageReportDetails")->with("damageReportSignatures")->with("ticket")->where("id", $id)->where("deleted_at", null)->first();

            $getDamageReport["classification"] = $this->CommonService->getClassificationOrScope($getDamageReport["classification"], "classification");
            $getDamageReport["scope"] = $this->CommonService->getClassificationOrScope($getDamageReport["scope"], "scope");

            return ["data" => $getDamageReport];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;
            DB::rollBack();

            if (is_a($e, CustomException::class)) {
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

        try {
            $id = (int) $id;
            $damageReportExist = $this->CommonService->getDataById("App\Models\DamageReport", $id);
            if (is_null($damageReportExist)) throw new CustomException("Laporan kerusakan tidak ditemukan", 404);

            DamageReport::findOrFail($id)->delete();
            DamageReportDetail::where("damage_report_id", $id)->where("deleted_at", null)->delete();
            DamageReportSignature::where("damage_report_id", $id)->where("deleted_at", null)->delete();

            DB::commit();
            return response()->json(['message' => 'Laporan kerusakan berhasil dihapus'], 200);
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;
            DB::rollBack();

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function select(Request $request)
    {
        try {
            [
                "page" => $page,
                "value" => $value
            ] = $this->CommonService->getQuery($request);

            $perPage = 10;
            $status = strtolower($request->input("status", ""));
            $statusArray = explode(",", $status);

            $damageReportQuery = DamageReport::where("deleted_at", null)->where('status','disetujui ka');
            if ($value) {
                $damageReportQuery->where('damage_report_number', 'like', '%' . $value . '%');
            }
            if($status != ""){
                $damageReportQuery->where(function ($query) use ($statusArray) {
                    $length = count($statusArray);

                    for($i = 0; $i < $length; $i++){
                        $statusFromArray = trim($statusArray[$i]);
                        $query->orWhere('status', 'like', '%' . $statusFromArray . '%');
                    }
                });
            }
            $getDamageReports = $damageReportQuery->select("id", "damage_report_number")->paginate($perPage);
            $totalCount = $getDamageReports->total();

            $dataArr = [];
            foreach ($getDamageReports as $damageReportObj) {
                $dataObj = [
                    "id" => $damageReportObj->id,
                    "text" => $damageReportObj->damage_report_number,
                ];
                array_push($dataArr, $dataObj);
            }

            $pagination = ["more" => false];
            if ($totalCount > ($perPage * $page)) {
                $pagination = ["more" => true];
            }

            return [
                "data" => $dataArr,
                "pagination" => $pagination,
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
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

            $countTenant = Tenant::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();
            $countDamageReport = DamageReport::where("deleted_at", null)->whereBetween("created_at", [$start, $end])->count();
            $countDamageReportDone = DamageReport::where("deleted_at", null)->
                whereBetween("created_at", [$start, $end])->
                where("status", "like", "%Selesai%")->
                count();

            return [
                "count_tenant" => $countTenant,
                "count_damage_report" => $countDamageReport,
                "count_damage_report_done" => $countDamageReportDone,
            ];
        } catch (\Throwable $e) {
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }

    public function update_status(Request $request, $id)
    {
        DB::beginTransaction();

        try{
            $id = (int) $id;
            $getDamageReport = $this->CommonService->getDataById("App\Models\DamageReport", $id);
            if (is_null($getDamageReport)) throw new CustomException("Damage Report tidak ditemukan", 404);

            $validateDamageReport = $this->DamageReportService->validateStatus($request);
            if($validateDamageReport != "") throw new CustomException($validateDamageReport, 400);

            $dataPayload = [ "status" => $request->input("status") ];

            DamageReport::findOrFail($id)->update($dataPayload);

            DB::commit();
            $getDamageReport =  DamageReport::with("damageReportDetails")->
                with("damageReportSignatures")->
                with("ticket")->
                where("id", $id)->
                where("deleted_at", null)->
                first();

            $getDamageReport["classification"] = $this->CommonService->getClassificationOrScope($getDamageReport["classification"], "classification");
            $getDamageReport["scope"] = $this->CommonService->getClassificationOrScope($getDamageReport["scope"], "scope");

            return ["data" => $getDamageReport];
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
}
