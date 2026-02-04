<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Tenant;
use App\Services\CommonService;
use App\Services\PaperIdService;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected $CommonService;
    protected $PaperIdService;

    public function __construct(CommonService $CommonService, PaperIdService $PaperIdService)
    {
        $this->CommonService = $CommonService;
        $this->PaperIdService = $PaperIdService;
    }

    /**
     * Display a listing of the resource.
     */
    public function dashboard(Request $request)
    {
        try {
            [
                "start" => $start,
                "end" => $end,
            ] = $this->CommonService->getQuery($request);

            if (is_null($start)) $start = Carbon::now()->firstOfMonth();
            if (is_null($end)) {
                $end = Carbon::now()->lastOfMonth();
                $end->setTime(23, 59, 59);
            }

            $sumInvoicePerMonth = Invoice::select(
                DB::raw('MONTH(created_at) AS month'),
                DB::raw('YEAR(created_at) AS year'),
                DB::raw('SUM(grand_total) AS total_amount')
            )
                ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                ->where(DB::raw('YEAR(created_at)'), "like", Carbon::now()->year)
                ->get();

            $sumInvoicePerDay = Invoice::select(
                DB::raw('DAY(created_at) AS day'),
            )
                ->groupBy(DB::raw('DAY(created_at)'))
                ->whereBetween('created_at', [$start, $end])
                ->get();

            $incomeReportQuery = "
                SELECT
                    (SELECT sum(grand_total) FROM invoices WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end' AND status LIKE '%Lunas%') AS sum_invoices,
                    (SELECT COUNT(*) FROM invoices WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end') AS count_invoices,
                    (SELECT COUNT(*) FROM invoices WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end' AND status LIKE '%Lunas%') AS count_invoices_paid,
                    (SELECT COUNT(*) FROM invoices WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end' AND status != 'Lunas') AS count_invoices_not_paid
            ";
            $incomeReport = DB::select($incomeReportQuery)[0];
            $incomeReport->sum_invoice_per_month = $sumInvoicePerMonth;

            $ticketComplainQuery = "
                SELECT
                    (SELECT COUNT(*) FROM tickets WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end') AS count_tickets,
                    (SELECT COUNT(*) FROM tickets WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end' AND status LIKE '%On progress%') AS count_tickets_waiting_for_response,
                    (SELECT COUNT(*) FROM tickets WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end' AND status LIKE '%selesai%') AS count_completed_tickets
            ";
            $ticketComplain = DB::select($ticketComplainQuery)[0];

            $tableArr = ["work_orders", "material_requests", "purchase_requests", "purchase_orders"];
            $countDataQueryString = "SELECT ";

            foreach ($tableArr as $tableName) {
                $countQuery = "(SELECT COUNT(*) FROM $tableName WHERE deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end') AS count_$tableName, ";

                $countDataQueryString = $countDataQueryString . $countQuery;
            }

            $countDataQueryString = $countDataQueryString . "(SELECT COUNT(*) FROM purchase_orders WHERE status LIKE '%disetujui bm%' AND deleted_at IS NULL AND created_at BETWEEN '$start' AND '$end') AS count_vendor_invoice";

            $countData = DB::select($countDataQueryString)[0];

            $checkStamp = $this->PaperIdService->checkRemainingStamp();
            $remainingStamp = 0;
            if (
                $checkStamp &&
                isset($checkStamp["data"]) &&
                isset($checkStamp["data"]["quota"])
            ) $remainingStamp = $checkStamp["data"]["quota"];

            $diagramInvoice = [];
            $start_day = Carbon::now();
            $start_day->adddays(2);
            $stop_date = date('Y-m-d', strtotime($start_day . ' -1 day'));
            $end_day = clone $start_day;
            $end_day->subdays(7);


            $daterange = new DatePeriod($end_day, new DateInterval('P1D'), $start_day);
            iterator_count($daterange);
            $arr = '';
            $i = 0;
            foreach ($daterange as $date) {
                $newformat = $date->format('Y-m-d');
                $timestamp = strtotime($newformat);
                $arr = $arr . $newformat;
                if ($newformat == $stop_date) {
                    $sumInvoicePerDay = "SELECT sum(grand_total)  AS total FROM invoices WHERE deleted_at IS NULL AND created_at  LIKE '%" . $newformat . "%'";
                    $countTotal = DB::select($sumInvoicePerDay)[0];
                    $total = $countTotal->total;
                    $diagramInvoice[$i] = [
                        "day" => date('D', $timestamp),
                        "data" => (isset($total)) ? $total : "0",
                    ];
                    $i++;
                } else {
                    $sumInvoicePerDay = "SELECT sum(grand_total) AS total FROM invoices WHERE deleted_at IS NULL AND created_at  LIKE '%" . $newformat . "%'";
                    $countTotal = DB::select($sumInvoicePerDay)[0];
                    $total = $countTotal->total;
                    $diagramInvoice[$i] = [
                        "day" => date('D', $timestamp),
                        "data" => (isset($total)) ? $total : "0",
                    ];
                    $i++;
                }
            }

            return [
                "remaining_stamp" => $remainingStamp,
                "income_report" => $incomeReport,
                "ticket_complain" => $ticketComplain,
                "statistic" => $countData,
                "diagramInvoice" => $diagramInvoice
            ];
        } catch (\Exception $e) {
            dd($e);
            $errorMessage = "Internal server error";
            $errorStatusCode = 500;

            if (is_a($e, CustomException::class)) {
                $errorMessage = $e->getMessage();
                $errorStatusCode = $e->getStatusCode();
            }

            return response()->json(['message' => $errorMessage], $errorStatusCode);
        }
    }
}
