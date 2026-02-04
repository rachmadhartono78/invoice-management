<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReportTagihanVendor implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings
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
             $data->purchase_order_number,
             $data->purchase_order_date,
             $data->vendor->name,
             $data->about,
             "Rp " . substr(number_format($data->grand_total, 2, ',', '.'), 0, -3),

         ];
     }
 
     public function headings(): array
     {
         return [
             'No',
             'No. PO',
             'Tanggal PO',
             'Perusahaan',
             'Perihal',
             'Total Tagihan',
         ];
     }
}
