<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\Orders;

class OrderExportExcell implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;

    public $orders;

     public function __construct($orders){
        $this->orders = $orders;
    }

    public function headings(): array
    {
        
        return [
        	"PLF Code",
            "First Name",
            "Last Name",
            "Address1",
            "PostCode",
            "Package Type",
            "Status"
        ];

    }

    /**
    * @return IlluminateSupportCollection
    */

    public function collection()
    {
        return collect($this->orders);
    }

}