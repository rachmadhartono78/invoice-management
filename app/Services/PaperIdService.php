<?php
namespace App\Services;

use App\Models\InvoiceDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Validator;

class PaperIdService{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;
    protected $headers;

    public function __construct() {
        $this->baseUrl = env("PAPER_ID_PROD_URL");
        $this->clientId = env("PAPER_ID_PROD_CLIENT_ID");
        $this->clientSecret = env("PAPER_ID_PROD_CLIENT_SECRET");
        $this->headers = [
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret,
        ];
    }

    /**
     * Fungsi untuk memanggil API Create Partner atau API Update Partner
     *
     * @param String $id Id dari tenant
     * @param String $name Nama dari tenant
     * @param String $phone No Hp tenant
     * @param String $partnerId Id dari partner yang akan di update
     * @param Boolean $isCreate Diisi true jika fungsi ini dipanggil untuk create partner, selain itu false
     * @return Array Associative array yang berisi output dari API
     */
    public function createOrUpdatePartner($id, $name, $phone, $partnerId, $isCreate = true){
        $payload = [
            "name" => $name,
            "phone" => $phone,
            "number" => strval($id),
            "email" => "",
            "type" => "client",
            "business_type" => "",
            "mobile_phone" => "",
            "address" => [
                "address_line_1" => "",
                "address_line_2" => "",
                "state" => "",
                "city" => "",
                "postal_code" => "",
                "country" => ""
            ],
            "notes" => "",
            "virtual_account" => "",
            "bank_accounts" => [],
            "contacts" => [],
            "payment_method" => [
                "credit_card" => true,
                "bank_transfer" => true,
                "ewallet" => true,
                "digital_payment_partner" => true,
                "qris" => true,
            ]
        ];

        if($isCreate){
            $url = $this->baseUrl . "/api/v2/partners";
            $callApi = Http::withHeaders($this->headers)->post($url, $payload);
        } else{
            $url = $this->baseUrl . "/api/v2/partners/" . $partnerId;
            $callApi = Http::withHeaders($this->headers)->put($url, $payload);
        }

        if($callApi->successful()) $callApiJson = $callApi->json();
        else $callApiJson = [];

        return $callApiJson;
    }

    /**
     * Fungsi untuk memanggil API Create Sales Invoice
     *
     * @param \App\Models\Invoice $invoice Object yang berisi data invoice yang akan dibuatkan sales invoicenya
     * @param \App\Models\InvoiceDetail $invoiceDetail Object yang berisi data detail invoice dari `$invoice`
     * @param \App\Models\Tenant $tenant Object yang berisi data tenatn yang memiliki `$invoice`
     * @return Array Associative array yang berisi output dari API
     */
    public function createSalesInvoice($invoice, $invoiceDetail, $tenant){
        $invoiceItem = [];
        foreach($invoiceDetail as $invoiceDetailObj){
            $itemObj = [
                "name" => $invoiceDetailObj["item"],
                "description" => $invoiceDetailObj["description"],
                "quantity" => $invoiceDetailObj["quantity"],
                "price" => $invoiceDetailObj["price"],
                "discount" => $invoiceDetailObj["discount"],
            ];
            if(isset($invoiceDetailObj["tax_id"])) $itemObj["tax_id"] = $invoiceDetailObj["tax_id"];

            array_push($invoiceItem, $itemObj);
        }

        $invoiceDate = Carbon::parse($invoice["invoice_date"])->timezone("UTC")->format("d-m-Y");
        $invoiceDueDate = Carbon::parse($invoice["invoice_due_date"])->timezone("UTC")->format("d-m-Y");

        $payload = [
            "total" => $invoice["grand_total"],
            "invoice_date" => $invoiceDate,
            "due_date" => $invoiceDueDate,
            "number" => $invoice["invoice_number"],
            "customer" => [
                "id" => (string) $tenant["id"],
                "name" => $tenant["name"] ,
                "email" => $tenant["email"] ?? "mail@gmail.com",
                "phone" => $tenant["phone"]
            ],
            "items" => $invoiceItem,
            "signature_text_header" => Carbon::now()->format('d F, Y'),
            "signature_text_footer" => "Yen Ardhiean",
            "terms_condition" => $invoice["term_and_condition"],
            "notes" => $invoice["notes"],
            "send" => [
                "email" => false,
                "whatsapp" => false,
                "sms" => false
            ],
        ];

        $url = $this->baseUrl . "/api/v1/store-invoice";
        $callApi = Http::withHeaders($this->headers)->post($url, $payload);
// dd($callApi->json());
     //   if($callApi->successful()) $callApiJson = $callApi->json();
       //  else $callApiJson = [];
        $callApiJson = $callApi->json();
        return $callApiJson;
    }

    /**
     * Fungsi untuk memanggil API Get Sales Invoice By Id
     *
     * @param String $salesInvoiceId Id sales invoice yg akan diambil datanya
     * @return Array Associative array yang berisi output dari API
     */
    public function getSalesInvoiceById($salesInvoiceId){
        $url = $this->baseUrl . "/api/v1/sales-invoices/" . $salesInvoiceId;
        $callApi = Http::withHeaders($this->headers)->get($url);

        if($callApi->successful()) $callApiJson = $callApi->json();
        else $callApiJson = [];

        return $callApiJson;
    }

    /**
     * Fungsi untuk memanggil API Stamp Sales Invoice
     *
     * @param String $invoiceNumber Nomor unik invoice yang akan di stamp
     * @return Array Associative array yang berisi output dari API
     */
    public function stampSalesInvoice($invoiceNumber){
        $url = $this->baseUrl . "/api/v1/sales-invoice/stamps";
        $payload = [
            "invoice_number" => $invoiceNumber,
            "send" => [
                "email" => false,
                "whatsapp" => false,
                "sms" => false
            ],
        ];

        $callApi = Http::withHeaders($this->headers)->post($url, $payload);

        if($callApi->successful()) $callApiJson = $callApi->json();
        else $callApiJson = [];

        return $callApiJson;
    }

    /**
     * Fungsi untuk memanggil API Cehck Remaining Stamp
     *
     * @return Array Associative array yang berisi output dari API
     */
    public function checkRemainingStamp(){
        $url = $this->baseUrl . "/api/v1/stamps/check-balance";
        $callApi = Http::withHeaders($this->headers)->post($url);

        if($callApi->successful()) $callApiJson = $callApi->json();
        else $callApiJson = [];

        return $callApiJson;
    }

    /**
     * Fungsi untuk memanggil API List All Tax
     *
     * @return Array Associative array yang berisi output dari API
     */
    public function listAlltax(){
        $url = $this->baseUrl . "/api/v1/tax/list";
        $callApi = Http::withHeaders($this->headers)->get($url);

        if($callApi->successful()) $callApiJson = $callApi->json();
        else $callApiJson = [];

        return $callApiJson;
    }
}
