<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Session;

use App\Http\Requests\EmailTemplateRequest;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\Mail;

use DB;

use App\Models\PharmacyInfo;
use App\Models\PharmacySettings;
use App\Models\PharmacyOpeningHour;

class OrdersController extends Controller
{


    public function updatePLFCode(Request $request) {
        $this->validate($request,[
            'day_2_pin' => 'max:4',
            'day_8_pin' => 'max:4',
        ]);
        $order = Orders::where('hash_id', $request->order_hash_id)->first();
        if (!$order) {
            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');
        }
        if ($request->old_plfcode != $request->plfcode) {
            // Update
            $get_plf_order = Orders::where('plfcode', $request->plfcode)->first();
            if (empty($get_plf_order)) {
                $update = $order->update([
                    'plfcode' => trim($request->plfcode),
                    'day_2_barcode' => trim($request->day_2_barcode),
                    'day_2_pin' => trim($request->day_2_pin),
                    'day_8_barcode' => trim($request->day_8_barcode),
                    'day_8_pin' => trim($request->day_8_pin),
                ]);

                if ($update) {
                    Session::flash('success','Code updated successfully');
                    return response()->success('Code updated successfully!');
                }
            } else {
//                $this->updateCodes($order, $request);
//                Session::flash('error','Code must be unique');
                return response()->failed('Code must be unique');
            }
        } else {
            $this->updateCodes($order, $request);
            Session::flash('success','Code updated successfully');
            return response()->success('Code cant updated successfully!');
        }

    }

    private function updateCodes($order, $request) {

        $update = $order->update([
            'day_2_barcode' => trim($request->day_2_barcode),
            'day_2_pin' => trim($request->day_2_pin),
            'day_8_barcode' => trim($request->day_8_barcode),
            'day_8_pin' => trim($request->day_8_pin),
        ]);

    }

    public function send_email_2(Request $request, $hash_id=false){

        // hash_id is the order's hash id

        // return $hash_id;

        $orders = DB::table('kod_orders')->select('kod_orders.service_id', 'kod_orders.email2_sent_status','kod_orders.email2_sent_datetime','kod_orders.email2_sent_template_id', 'kod_orders.id as order_plain_id', 'kod_passengers.nhs_no as passengers_nhs_no','kod_orders.hash_id as order_hash_id','kod_orders.invoice_no as order_invoice_no','kod_orders.plfcode as order_plfcode','kod_orders.status as order_status','kod_orders.day_2_barcode as order_day_2_barcode','kod_orders.day_2_pin as order_day_2_pin','kod_orders.day_8_barcode as order_day_8_barcode','kod_orders.day_8_pin as order_day_8_pin','kod_orders.created_at as order_created_at','kod_passengers.first_name as passengers_first_name','kod_passengers.surname as passengers_surname','kod_passengers.email as passengers_email','kod_passengers.dob as passengers_dob','kod_passengers.gender as passengers_gender','kod_passengers.ethnicity as passengers_ethnicity','kod_passengers.vaccination_status as passengers_vaccination_status','kod_passengers.passport_no as passengers_passport_no','kod_passengers.phone_no as passengers_phone_no','kod_passenger_addresses.uk_address as passenger_addresses_uk_address','kod_passenger_addresses.uk_postcode as passenger_addresses_uk_postcode','kod_passenger_addresses.uk_city as passenger_addresses_uk_city','kod_travel_details.arrival_date as travel_details_arrival_date','kod_travel_details.date_of_departure as travel_details_date_of_departure','kod_travel_details.city_travelled_from as travel_details_city_travelled_from','kod_travel_details.type_of_transport as travel_details_type_of_transport','kod_travel_details.coach_no as travel_details_coach_no','kod_countries.title as countries_title','kod_services.title as services_title')

          ->join('kod_passengers','kod_passengers.id','=','kod_orders.passenger_id')
          ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
          ->join('kod_travel_details','kod_travel_details.passenger_id','=','kod_passengers.id')
          ->join('kod_services','kod_services.id','=','kod_orders.service_id')
          ->join('kod_countries','kod_countries.id','=','kod_travel_details.country_id')->where('kod_orders.hash_id', $hash_id)->get()->toArray();

        $order_details = array();
        if(!empty($orders)){

            $arr = json_decode(json_encode($orders), true);
            $order_details = $arr[0];

        } // if(!empty($orders))

        // return $order_details['order_hash_id'];

        $email_templates_list = EmailTemplate::orderBy('id', 'DESC')->where('status', '1')->get();

        return view('backend.admin.dashboard.send_email_2', [

            'order_details' => $order_details,
            'email_templates_list' => $email_templates_list

        ])->render();

    }

    public function get_email_template_fields(Request $request){

        /*
        email_template_id: "1"
        main_order_hash_id: "7kSpOG1626518970"
        */

        // return $request;

        // Get order details
        $orders = DB::table('kod_orders')->select('kod_orders.id as order_plain_id','kod_passengers.nhs_no as passengers_nhs_no','kod_orders.hash_id as order_hash_id','kod_orders.invoice_no as order_invoice_no','kod_orders.plfcode as order_plfcode','kod_orders.status as order_status','kod_orders.day_2_barcode as order_day_2_barcode','kod_orders.day_2_pin as order_day_2_pin','kod_orders.day_8_barcode as order_day_8_barcode','kod_orders.day_8_pin as order_day_8_pin','kod_orders.created_at as order_created_at','kod_passengers.first_name as passengers_first_name','kod_passengers.surname as passengers_surname','kod_passengers.email as passengers_email','kod_passengers.dob as passengers_dob','kod_passengers.gender as passengers_gender','kod_passengers.ethnicity as passengers_ethnicity','kod_passengers.vaccination_status as passengers_vaccination_status','kod_passengers.passport_no as passengers_passport_no','kod_passengers.phone_no as passengers_phone_no','kod_passenger_addresses.uk_address as passenger_addresses_uk_address','kod_passenger_addresses.uk_postcode as passenger_addresses_uk_postcode','kod_passenger_addresses.uk_city as passenger_addresses_uk_city','kod_travel_details.arrival_date as travel_details_arrival_date','kod_travel_details.date_of_departure as travel_details_date_of_departure','kod_travel_details.city_travelled_from as travel_details_city_travelled_from','kod_travel_details.type_of_transport as travel_details_type_of_transport','kod_travel_details.coach_no as travel_details_coach_no','kod_countries.title as countries_title','kod_services.title as services_title')

          ->join('kod_passengers','kod_passengers.id','=','kod_orders.passenger_id')
          ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
          ->join('kod_travel_details','kod_travel_details.passenger_id','=','kod_passengers.id')
          ->join('kod_services','kod_services.id','=','kod_orders.service_id')
          ->join('kod_countries','kod_countries.id','=','kod_travel_details.country_id')->where('kod_orders.hash_id', $request->main_order_hash_id)->get()->toArray();

        $order_details = array();
        if(!empty($orders)){

            $arr = json_decode(json_encode($orders), true);
            $order_details = $arr[0];

        } // if(!empty($orders))

        // return $order_details;

        $email_template_details = EmailTemplate::where('id', $request->email_template_id)->first();
        
        return view('backend.admin.dashboard.send_email_2_fields', [

            'order_details' => $order_details,

            'email_template_details' => $email_template_details

        ])->render();

    }

    public function send_email_2_process(Request $request){

        /*
        email_body: 123
        email_subject: "Order Confirmation"
        email_template_id: "1"
        main_order_hash_id: "7kSpOG1626518970"
        to_email_address: "kodiontechnologies@gmail.com"
        */

        // Get order details by main_order_hash_id
        $orders = DB::table('kod_orders')->select('kod_orders.id as order_plain_id','kod_passengers.nhs_no as passengers_nhs_no','kod_orders.hash_id as order_hash_id','kod_orders.invoice_no as order_invoice_no','kod_orders.plfcode as order_plfcode','kod_orders.status as order_status','kod_orders.day_2_barcode as order_day_2_barcode','kod_orders.day_2_pin as order_day_2_pin','kod_orders.day_8_barcode as order_day_8_barcode','kod_orders.day_8_pin as order_day_8_pin','kod_orders.created_at as order_created_at','kod_passengers.first_name as passengers_first_name','kod_passengers.surname as passengers_surname','kod_passengers.email as passengers_email','kod_passengers.dob as passengers_dob','kod_passengers.gender as passengers_gender','kod_passengers.ethnicity as passengers_ethnicity','kod_passengers.vaccination_status as passengers_vaccination_status','kod_passengers.passport_no as passengers_passport_no','kod_passengers.phone_no as passengers_phone_no','kod_passenger_addresses.uk_address as passenger_addresses_uk_address','kod_passenger_addresses.uk_postcode as passenger_addresses_uk_postcode','kod_passenger_addresses.uk_city as passenger_addresses_uk_city','kod_travel_details.arrival_date as travel_details_arrival_date','kod_travel_details.date_of_departure as travel_details_date_of_departure','kod_travel_details.city_travelled_from as travel_details_city_travelled_from','kod_travel_details.type_of_transport as travel_details_type_of_transport','kod_travel_details.coach_no as travel_details_coach_no','kod_countries.title as countries_title','kod_services.title as services_title')

          ->join('kod_passengers','kod_passengers.id','=','kod_orders.passenger_id')
          ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
          ->join('kod_travel_details','kod_travel_details.passenger_id','=','kod_passengers.id')
          ->join('kod_services','kod_services.id','=','kod_orders.service_id')
          ->join('kod_countries','kod_countries.id','=','kod_travel_details.country_id')->where('kod_orders.hash_id', $request->main_order_hash_id)->get()->toArray();

        $order = array();
        if(!empty($orders)){

            $arr = json_decode(json_encode($orders), true);
            $order = $arr[0];

        } // if(!empty($orders))

        // return $order;

        // Get pharmacy info
        $pharmacy_info = PharmacyInfo::first();

        // $from_email_address = "haseeb@ojltd.com";
        $from_email_address = $pharmacy_info->email_address_secondary; // "no-reply@pcrdirect.co.uk";

        $reply_to_email_address = "";

        $email_from_text = "PCR Direct";

        $email_subject = $request->email_subject; // "Order Confirmation";

        // $email_body = "<p>Thanks for your order.</p> <p> We will send you a second email with your Passenger Locator Form (PLF) number. </p> <br /><p>Your PLF code is <strong>".$order->plfcode."</strong> </p> <br /> <p> <strong> Regards </strong> <br /> Pcrdirect.co.uk </p>";

        /*
        $email_body = "<p> Thanks for your order. </p>

                        <p> Your PLF code is <strong>".$order->plfcode."</strong>. </p>

                        <p> You need your PLF code for your passenger locator form. </p>

                        <p> If you have any questions, please contact us by email. </p>

                        <br />

                        <p> <strong> Regards </strong> <br /> Pcrdirect.co.uk </p>
                        ";*/

        $search_arr = array(
            
            '[PLF_CODE]',
            '[DAY_2_BARCODE]',
            '[DAY_2_PIN]',
            '[DAY_8_BARCODE]',
            '[DAY_8_PIN]'

        );
        $replace_arr = array(

            $order['order_plfcode'],
            $order['order_day_2_barcode'],
            $order['order_day_2_pin'],
            $order['order_day_8_barcode'],
            $order['order_day_8_pin']

        );

        $email_body = $request->email_body;
        $email_body = str_replace($search_arr, $replace_arr, $email_body);

        $attachment_arr = array();

        $this->send_email_ses(
            $request->to_email_address,
            $from_email_address,
            $reply_to_email_address,
            $email_from_text,
            $email_subject,
            $email_body,
            $attachment_arr
        );
        
        // Update db that email has been sent
        $order_object = Orders::where('hash_id', $request->main_order_hash_id)->first();

        $order_object->email2_sent_status = '1';
        $order_object->email2_sent_datetime = date('Y-m-d H:i:s');
        $order_object->email2_sent_template_id = $request->email_template_id;

        $order_object->save();

        Session::flash('success','Email successfully sent.');
        return response()->success('Email successfully sent.');

    }

    public function send_email_ses($to_email_address=false, $from_email_address=false, $reply_to_email_address=false, $email_from_text=false, $email_subject=false, $email_body=false, $attachment_arr=array()){

        return Mail::send([], [], function ($message) use($to_email_address,$from_email_address,$reply_to_email_address,$email_from_text,$email_subject,$email_body,$attachment_arr){

            $message->to($to_email_address);
            if(!empty($email_subject)){
                $message->subject($email_subject);
            }

            if(!empty($reply_to_email_address)){
                $message->replyTo($reply_to_email_address);
            }

            if(!empty($from_email_address)){
                $message->from($from_email_address, $email_from_text);
            }


            if(!empty($email_body)){
                $message->setBody($email_body, 'text/html');
            }

            if(!empty($attachment_arr)){
                $message->attach($attachment_arr);
            }

        });

    }

}
