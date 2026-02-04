<?php

namespace App\Exports;

use App\Models\Invoice;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;


class ReportInvoiceExport implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;
    private $i = 1;

    function __construct($data)
    {
        $this->data = $data;
    }

    
    public function collection()
    {
        return collect($this->data);
    }
    

    public function map($data): array
    {
       $invoiceDate = Carbon::createFromFormat('Y-m-d', $data->invoice_date);
       $previousMonthStart = $invoiceDate->subMonth()->startOfMonth()->format('d M Y');
       $previousMonthEnd = $invoiceDate->endOfMonth()->format('d M Y');

       $remaining = "Rp. 0";
       if(property_exists($data, "remaining")){
        $remaining = number_format($data->remaining, 0, ',', '.');
       }
        return [
            $this->i++,
            $data->invoice_number,
            date('d F Y', strtotime($data->invoice_date)),
            strip_tags($data->notes),
            $data->tenant == null ? "" :  $data->tenant->name,
            "Rp " . substr(number_format($data->grand_total, 2, ',', '.'), 0, -3),
            $remaining,
            $previousMonthStart . ' s/d ' . $previousMonthEnd

        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor Invoice',
            'Tanggal Faktur',
            'Uraian',
            'Nama Pelanggan',
            'Total Tagihan',
            'Sisa Tagihan',
            'Periode'
        ];
    }
}
