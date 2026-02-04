<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class ReportTandaTerimaExport implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings
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
         return [
             $this->i++,
             $data->receipt_number,
             $data->tenant != null ? $data->tenant->name : "",
             "Rp " . substr(number_format($data->paid, 2, ',', '.'), 0, -3),
             Carbon::parse($data->receipt_date)->format('d F Y'),
             Carbon::parse($data->receipt_send_date)->format('d F Y'),
             $data->status
         ];
     }
 
     public function headings(): array
     {
         return [
             "No",
             "No Tanda Terima",
             "Tenant",
             "Total",
             "Tanggal Tanda Terima",
             "Tanggal Kirim",
             "Status",
         ];
     }
}
