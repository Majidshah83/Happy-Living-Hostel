<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;


class Orders extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'passenger_id',
        'service_id',
        'transaction_id',
        'invoice_no',
        'price_charged',
        'payment_method',
        'status',
        'plfcode',
        'emailsent',
        'day_2_barcode',
        'day_2_pin',
        'day_8_barcode',
        'day_8_pin'

    ];


    public static function getOrder($id){

          $orders = Orders::orderFilter($id);
          return $orders;

   }


    public static function downloadReportingExcell($date,$service,$order_status){

      $orders = DB::table('kod_orders')->select('kod_orders.plfcode as PLF Code','kod_passengers.first_name as First Name','kod_passengers.surname as Last Name','kod_passenger_addresses.uk_address as Address1','kod_passenger_addresses.uk_postcode as Postcode','kod_services.title as Package Type')
      ->join('kod_passengers','kod_passengers.id','=','kod_orders.passenger_id')
      ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
      ->join('kod_services','kod_services.id','=','kod_orders.service_id')->whereDate('kod_orders.created_at',$date)->orderBy('kod_passengers.first_name')->when($service != 'all',
                function($q) use ($service){
                    return $q->where('kod_orders.service_id',$service);
                })->when($order_status != 'all',
                function($q) use ($order_status){
                    return $q->where('kod_orders.status',$order_status);
                })->get()->toArray();
      return $orders;


   }


   public static  function orderFilter($id){


        $orders = DB::table('kod_orders')->select('kod_travel_details.arrival_date as Arrival Date','kod_passengers.first_name as First Name','kod_passengers.surname as Sur Name','kod_passengers.dob as Date Of Birth','kod_passengers.gender as Gender','kod_passengers.ethnicity as Ethnicity','kod_passengers.vaccination_status as Vaccination Status','kod_passengers.nhs_no as NHS number','kod_passengers.passport_no as Document ID/Passport No','kod_passengers.passport_no as Document ID/Passport No','kod_passenger_addresses.uk_address as Delivery Address','kod_passenger_addresses.uk_postcode as Delivery Postcode','kod_passenger_addresses.uk_city as Delivery City','kod_travel_details.date_of_departure as Date Of Departure','kod_countries.title as Country Travelled From','kod_travel_details.city_travelled_from as City Travelled From','kod_travel_details.type_of_transport as Type of Transport','kod_travel_details.coach_no as Flight / Train / Coach Number','kod_travel_details.list_countries as Please list the countries you have note',"kod_passengers.email as Email Address","kod_passengers.phone_no as Phone Number",'kod_passenger_addresses.b_address as Billing Address','kod_passenger_addresses.b_postcode as Billing Postcode','kod_passenger_addresses.b_city as Billing City','kod_orders.invoice_no as Order Id','kod_services.title as Package Name')
          ->join('kod_passengers','kod_passengers.id','=','kod_orders.passenger_id')
          ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
          ->join('kod_travel_details','kod_travel_details.passenger_id','=','kod_passengers.id')
          ->join('kod_services','kod_services.id','=','kod_orders.service_id')
          ->join('kod_countries','kod_countries.id','=','kod_travel_details.country_id')->when($id != null,
                function($q) use ($id){
                    return $q->where('kod_services.id',$id);
                })->get()->toArray();

          return $orders;

   }


}
