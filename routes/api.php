<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\DamageReportController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MaterialRequestController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScopeController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorInvoiceController;
use App\Http\Controllers\WorkOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tenant/select', [TenantController::class, "select"]);
Route::get('tenant/report', [TenantController::class, "report"]);
Route::resource('tenant', TenantController::class);

Route::get('bank/select', [BankController::class, "select"]);
Route::resource('bank', BankController::class);

Route::get("invoice/select", [InvoiceController::class, "select"]);
Route::get("invoice/report", [InvoiceController::class, "report"]);
Route::get("invoice/invoice-report-export", [InvoiceController::class, "invoiceReportExport"]);
Route::patch("invoice/update-status/{id}", [InvoiceController::class, "update_status"]);
Route::resource('invoice', InvoiceController::class);

Route::get("receipt/select", [ReceiptController::class, "select"]);
Route::get("receipt/report", [ReceiptController::class, "report"]);
Route::get("receipt/receipt-report-export", [ReceiptController::class, "receiptReportExport"]);
Route::patch("receipt/update-status/{id}", [ReceiptController::class, "update_status"]);
Route::resource('receipt', ReceiptController::class);

Route::post("ticket/add-attachment/{id}", [TicketController::class, "add_attachment"]);
Route::delete("ticket/delete-attachment/{id}", [TicketController::class, "delete_attachment"]);
Route::get("ticket/select", [TicketController::class, "select"]);
Route::get("ticket/report", [TicketController::class, "report"]);
Route::patch("ticket/update-status/{id}", [TicketController::class, "update_status"]);
Route::resource('ticket', TicketController::class);

Route::get("damage-report/select", [DamageReportController::class, "select"]);
Route::get("damage-report/report", [DamageReportController::class, "report"]);
Route::patch("damage-report/update-status/{id}", [DamageReportController::class, "update_status"]);
Route::resource('damage-report', DamageReportController::class);



Route::get("work-order/select", [WorkOrderController::class, "select"]);
Route::get("work-order/report", [WorkOrderController::class, "report"]);
Route::patch("work-order/update-status/{id}", [WorkOrderController::class, "update_status"]);
Route::resource('work-order', WorkOrderController::class);

Route::get("vendor/select", [VendorController::class, "select"]);
Route::get('vendor/report', [VendorController::class, "report"]);
Route::post('vendor/email', [VendorController::class, "vendor"]);
Route::resource('vendor', VendorController::class);

Route::get('material-request/select', [MaterialRequestController::class, "select"]);
Route::get("material-request/report", [MaterialRequestController::class, "report"]);
Route::patch("material-request/update-status/{id}", [MaterialRequestController::class, "update_status"]);
Route::resource('material-request', MaterialRequestController::class);

Route::get("purchase-request/select", [PurchaseRequestController::class, "select"]);
Route::get("purchase-request/report", [PurchaseRequestController::class, "report"]);
Route::patch("purchase-request/update-status/{id}", [PurchaseRequestController::class, "update_status"]);
Route::resource('purchase-request', PurchaseRequestController::class);

Route::get("purchase-order/select", [PurchaseOrderController::class, "select"]);
Route::get("purchase-order/report", [PurchaseOrderController::class, "report"]);
Route::get("purchase-order-vendor/{vendorId}", [PurchaseOrderController::class, "vendor"]);
Route::patch("purchase-order/update-status/{id}", [PurchaseOrderController::class, "update_status"]);
Route::resource('purchase-order', PurchaseOrderController::class);

Route::get("department/select", [DepartmentController::class, "select"]);
Route::resource('department', DepartmentController::class);

Route::get("level/select", [LevelController::class, "select"]);
Route::resource('level', LevelController::class);

Route::post('user/login', [UserController::class, "login"]);
Route::get('user/report', [UserController::class, "report"]);
Route::resource('user', UserController::class);

Route::get("tax/select", [TaxController::class, "select"]);
Route::get("tax/select-paper", [TaxController::class, "selectPaperId"]);
Route::get("tax/get-paper/{id}", [TaxController::class, "getPaperId"]);
Route::resource('tax', TaxController::class);

Route::post("mail/send-attachment", [MailController::class, "send"]);

Route::get("classification/select", [ClassificationController::class, "select"]);
Route::resource('classification', ClassificationController::class);

Route::get("scope/select", [ScopeController::class, "select"]);
Route::resource('scope', ScopeController::class);

Route::get("vendor-invoice/vendor-invoice-report-export", [VendorInvoiceController::class, "vendorInvoiceReportExport"]);
Route::delete("vendor-invoice/add-attachment/{id}", [VendorInvoiceController::class, "deleteVendorAttachment"]);
Route::get("vendor-invoice/report", [VendorInvoiceController::class, "report"]);
Route::post("vendor-invoice/add-attachment/{id}", [VendorInvoiceController::class, "add_attachment"]);
Route::get("vendor-invoice/", [VendorInvoiceController::class, "index"]);

Route::get("report/dashboard", [ReportController::class, "dashboard"]);
