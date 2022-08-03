<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use App\Models\Orders;

class OrderExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */  
    // use Exportable;

    public $id;

     public function __construct($id){
        $this->id = $id;
    }

    public function headings(): array
    {
        
 
        return [
        	"Arrival Date",
            "First Name",
            "Sur Name",
            "Date Of Birth",
            "Gender",
            "Ethnicity",
            "Vaccination Status",
            "NHS number",
            "Document ID/Passport No",
            "Delivery Address",
            "Delivery Postcode",
            "Delivery City",
            "Date Of Departure",
            "Country Travelled From",
            "City Travelled From",
            "Type of Transport",
            "Flight / Train / Coach Number",
            "Please list the countries you have note",
            "Email Address",
            "Phone Number",
            "Billing Address",
            "Billing Postcode",
            "Billing City",
            "Order ID",
            "Package Name"
        ];

    }

    /**
    * @return IlluminateSupportCollection
    */

    public function collection()
    {
        return collect(Orders::getOrder($this->id));
    }

}