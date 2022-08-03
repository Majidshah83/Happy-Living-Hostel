<?php

namespace App\Http\Controllers;

use App\Http\Requests\PharmacyProfileRequest;
use App\Models\PharmacyInfo;
use App\Models\PharmacySettings;
use App\Models\PharmacyOpeningHour;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Rules\GoogleRecaptcha;
use Redirect;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\CommonModel;
use Illuminate\Support\Facades\Schema;
// use App\Services\SendMailService;

use App\User;

use CommonEloHelper;

use PDF;

class BookingController extends Controller{

    // protected $SendMailService;

    public function __construct(){

        // $this->SendMailService = new SendMailService();

    }

    /********** Start => Manage Booking Slots Functions **********/

    // Start => public function view_note()
    public function view_note(Request $request){

        $booking_details = CommonEloHelper::get_table_row('mc_service_bookings', $request->booking_id);

        return $booking_details['reason_for_visit'];

    } // End => public function view_note()

    // Start => public function booking_slots()
    public function booking_slots(){

        // Initialize the calendar_pharmacy_id veriable to drive the booking slots module
        $calendar_pharmacy_id = '';
        $can_edit = true;

        // Week day numbers array
        $week_day_numbers = array('1', '2', '3', '4', '5', '6', '7');

        ////////////// Get all week slots by days //////////////
        
        $week_day_slots = array();
        foreach($week_day_numbers as $day_number){

            $table = 'service_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots = $common_obj->set_config($table, $fillable);

            if(!$real_obj_service_booking_slots) return 'Common model config not set.';

            $week_day_slots[$day_number] = $real_obj_service_booking_slots->where('slot_day_number', $day_number)->get()->toArray();
            
        } // foreach($week_day_numbers as $day_number)

        ////////////// Get all week slots On/Off status by days //////////////

        $week_day_on_off_status = array();
        foreach($week_day_numbers as $day_number){

            $table = 'service_booking_slots_off_days';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots_off_days = $common_obj->set_config($table, $fillable);

            if(!$real_obj_service_booking_slots_off_days) return 'Common model config not set.';

            $week_day_on_off_status[$day_number] = $real_obj_service_booking_slots_off_days->where('slot_day_number', $day_number)->get()->toArray();
            
        } // foreach($week_day_numbers as $day_number)

        // echo '<pre>'; print_r($week_day_slots[5]); exit;

        return view(

                'bookings.booking_slots',

                [

                    'can_edit' => $can_edit,
                    'week_day_on_off_status' => $week_day_on_off_status,
                    'week_day_slots' => $week_day_slots

                ]

            );

    } // End => public function booking_slots()

    // Start => public function update_booking_slot_day_status(Request $request)
    public function update_booking_slot_day_status(Request $request){

        $table = 'service_booking_slots_off_days';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj = $common_obj->set_config($table, $fillable);

        if(!$real_obj) return 'Common model config not set.';

        // Remove old days
        $real_obj->where('slot_day_number', $request->slot_day_number)->delete();

        if($request->day_status == 'OFF'){

            $table = 'service_booking_slots_off_days';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $ins_real_obj = $common_obj->set_config($table, $fillable);

            if(!$ins_real_obj) return 'Common model config not set.';

            $ins_real_obj->slot_day_number = $request->slot_day_number;
            $ins_real_obj->day_is_off = 'Y';

            $ins_real_obj->save();

        } // if($request->day_status == 'OFF')

    } // End => public function update_booking_slot_day_status(Request $request)

    // Start => public function manage_day_slots($day_number=false)
    public function manage_day_slots($day_number=false){

        $week_day_names = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

        // echo '<pre>'; print_r($week_day_names[$day_number-1]); exit;

        $week_day_name = $week_day_names[$day_number-1];

        // [ 1 ] => Get day slots FROM service_booking_slots
        $table = 'service_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_service_booking_slots = $common_obj->set_config($table, $fillable);

        if(!$real_obj_service_booking_slots) return 'Common model config not set.';

        $week_day_slots = $real_obj_service_booking_slots->where('slot_day_number', $day_number)->get()->toArray();

        // [ 2 ] => Get day on / off status FROM service_booking_slots_off_days
        $table = 'service_booking_slots_off_days';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_service_booking_slots_off_days = $common_obj->set_config($table, $fillable);

        if(!$real_obj_service_booking_slots_off_days) return 'Common model config not set.';

        $week_day_on_off_status = $real_obj_service_booking_slots_off_days->where('slot_day_number', $day_number)->get()->toArray();

        return view(

                'bookings.manage_day_slots',

                [

                    'day_number' => $day_number,
                    'week_day_name' => $week_day_name,
                    'week_day_slots' => $week_day_slots,
                    'week_day_on_off_status' => $week_day_on_off_status

                ]

            );

    } // End => public function manage_day_slots($day_number=false)

    // Start => public function add_shift_interval_day_slots(Request $request)
    public function add_shift_interval_day_slots(Request $request){

        // return $request;

        // Validate the request
        if( !empty($request->shift_start_time) && !empty($request->shift_interval) && !empty($request->shift_total_slots) ){

            $new_slot_time = '';

            // Iterations upto the total slots to be added
            for($i=1; $i<= $request->shift_total_slots; $i++){

                // Check if the first iteration or dynamic latest

                if(!empty($new_slot_time)){

                    $new_slot_time = (!empty($new_slot_time)) ? $new_slot_time : $request->shift_start_time ;
                    $new_slot_time = date('H:i', strtotime("+".$request->shift_interval." minutes", strtotime($new_slot_time)) );

                } else {

                    $new_slot_time = (!empty($new_slot_time)) ? $new_slot_time : $request->shift_start_time ;
                
                } // if(!empty($new_slot_time))

                $new_slot_time = date('H:i:s', strtotime($new_slot_time));

                // Verify if not already added
                // Not exist before => Insert new
                $table = 'service_booking_slots';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj = $common_obj->set_config($table, $fillable);

                if(!$real_obj) return 'Common model config not set.';

                $exist = $real_obj->where('slot_day_number', $request->slot_day_number)->where('slot_start_time', $new_slot_time)->first();

                if(empty($exist)){

                    // Not exist before => Insert new
                    $table = 'service_booking_slots';
                    $fillable =  Schema::getColumnListing($table);
                    $common_obj = new CommonModel();
                    $ins_real_obj = $common_obj->set_config($table, $fillable);

                    if(!$ins_real_obj) return 'Common model config not set.';

                    $ins_real_obj->slot_day_number = $request->slot_day_number;
                    
                    $ins_real_obj->slot_start_time = $new_slot_time;

                    $ins_real_obj->slot_status = 'ACTIVE';
                    
                    $ins_real_obj->save();

                } // if(empty($exist))

            } // for($i=1; $i<= $request->shift_total_slots; $i++)

            $message = 'Booking slots has been added successfully';
            return $this->success(null, 200, $message);

        } else {

            return 'false';

        } // if( !empty($request->shift_start_time) && !empty($request->shift_interval) && !empty($request->shift_total_slots) )

    } // End => public function add_shift_interval_day_slots(Request $request)

    // Start => public function remove_booking_slot_process($item_id=false)
    public function remove_booking_slot_process($item_id=false){

        $table = 'service_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj = $common_obj->set_config($table, $fillable);

        if(!$real_obj) return 'Common model config not set.';

        // Remove old days
        $real_obj->where('id', $item_id)->delete();

        $message = 'Booking slots has been deleted successfully';
        return $this->success(null, 200, $message);

    } // End => public function remove_booking_slot_process($item_id=false)

    // Start => public function change_booking_slot_status_process(Request $request)
    public function change_booking_slot_status_process(Request $request){

        $table = 'service_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj = $common_obj->set_config($table, $fillable);

        if(!$real_obj) return 'Common model config not set.';

        // Remove old days
        $item_details = $real_obj->findOrFail($request->item_id);

        $item_details->slot_status = $request->new_status;

        $item_details->save();

        $message = 'Booking slots status has been updated successfully';
        return $this->success(null, 200, $message);

    } // End => public function change_booking_slot_status_process(Request $request)

    // Start => public function switch_off_dates()
    public function switch_off_dates(){

        // [ 3 ] => Get service_pharmacy_days_off_dates
        $table = 'service_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_service_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

        if(!$real_obj_service_booking_slots_off_dates) return 'Common model config not set.';

        $service_booking_slots_off_dates_arr = $real_obj_service_booking_slots_off_dates->get()->toArray();

        $service_booking_slots_off_dates_dmy_arr = array();
        $service_booking_slots_off_dates_str = '';

        if(!empty($service_booking_slots_off_dates_arr)){

            $service_booking_slots_off_dates_arr = array_column($service_booking_slots_off_dates_arr, 'off_date');
            // $service_booking_slots_off_dates_arr_imploded = implode(',', $service_booking_slots_off_dates_arr);

            if(!empty($service_booking_slots_off_dates_arr)){
                foreach($service_booking_slots_off_dates_arr as $each){

                    $service_booking_slots_off_dates_dmy_arr[] = date('d/m/Y', strtotime($each));

                } // foreach($service_booking_slots_off_dates_arr as $each)
            } // if(!empty($service_booking_slots_off_dates_arr))

        } // if(!empty($service_booking_slots_off_dates_arr))

        if(!empty($service_booking_slots_off_dates_dmy_arr)){

            $service_booking_slots_off_dates_str = implode(',', $service_booking_slots_off_dates_dmy_arr);

        } // if(!empty($service_booking_slots_off_dates_dmy_arr))

        // echo '<pre>'; print_r($service_booking_slots_off_dates_arr); exit;

        return view(

                'bookings.booking_slots_off_dates',

                [
                    'service_booking_slots_off_dates_str' => $service_booking_slots_off_dates_str
                ]

            );


    } // End => public function switch_off_dates()

    // Start => public function switch_off_dates_process(Request $request)
    public function switch_off_dates_process(Request $request){

        $table = 'service_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_service_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

        if(!$real_obj_service_booking_slots_off_dates) return 'Common model config not set.';

        // Remove old dates
        $real_obj_service_booking_slots_off_dates->delete();

        // Insert new dates
        if( !empty($request->off_dates) ){

            $off_dates_arr = explode(',', $request->off_dates);

            foreach($off_dates_arr as $off_date){

                $slot_date_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $off_date) ));

                $table = 'service_booking_slots_off_dates';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $ins_real_obj_service_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

                if(!$ins_real_obj_service_booking_slots_off_dates) return 'Common model config not set.';

                $ins_real_obj_service_booking_slots_off_dates->off_date = $slot_date_mysql_format;

                $ins_real_obj_service_booking_slots_off_dates->save();

            } // foreach($off_dates_arr as $day_number)

        } // if( !empty($request->off_dates) )
        
        $message='Switch off dates has been updated successfully';
        return $this->success(null, 200, $message);

    } // End => public function switch_off_dates_process(Request $request)

    /********** End => Manage Booking Slots Functions **********/

    /*---------------------------------------------------------*/

    /*********** Start => Booking Calendar Functions ***********/

    // Start => public function booking_calendar()
    public function booking_calendar(){

        return view(

                'bookings.calendar.booking_calendar',

                [

                    'foo' => 'bar'

                ]

            );

    } // End => public function booking_calendar()

    // Start => public function next_prev_booking_calendar()
    public function next_prev_booking_calendar(Request $request){
        
        $current = ($request->current) ? $request->current : date('Y-m-d');

        if($request->action == 'next_day_weekly')
            $new_current_date = date('Y-m-d', strtotime(str_replace('/','-',$request->current) . ' +7 day'));
        elseif($request->action == 'prev_day_weekly')
            $new_current_date = date('Y-m-d', strtotime(str_replace('/','-',$request->current) . ' -7 day'));
        else
            $new_current_date = date('Y-m-d', strtotime(str_replace('/','-',$request->current) . ' 0 day'));
        // if($request->action == 'next_day_weekly')

        ///////////////////////////////////////////////
        // Checks to verify Traversing between dates //
        
        $today = date('Y-m-d');

        /////////////////////
        // Minimum date check
        /*
        if($new_current_date < $today){
            $new_current_date = $today;
        } // if($new_current_date < $today)
        */
        
        /////////////////////
        // Maximum date check

        $calendar_months = '3';

        $max_allowed_date = date('Y-m-d', strtotime(str_replace('/','-',$today) . ' +'.$calendar_months.' month'));

        if($max_allowed_date < $new_current_date){
            $new_current_date = $max_allowed_date;
        } // if($new_current_date < $today)

        // echo $new_current_date;

        $data['today'] = $today;
        $data['max_allowed_date'] = $max_allowed_date;

        /////////// End Traversing Checks ///////////

        // Get booking calendar end date from global settings [ in months (i.e 6) ]
        $calendar_end_date = '3';
        
        $today_date = date('Y-m-d');
        $calendar_end_date = date('Y-m-d', strtotime($today_date . ' +'.$calendar_end_date.' months'));

        $data['new_current_date'] = $new_current_date;
        $week_list = $this->week_from_monday($new_current_date);
        $data['week_list'] = $week_list;

        if(in_array($calendar_end_date, $week_list)){
            $data['calendar_end_date'] = $calendar_end_date;
        } else {
            $data['calendar_end_date'] = false;
        } // if(in_array($calendar_end_date, $week_list))

        // Get total number of weeks in month
        $data['count_weeks'] = $this->weeks(date('m', strtotime($new_current_date)),date('Y', strtotime($week_list[0])));

        ///////////////// GET DYNAMIC CONTENTS BY WEEK DAY FOR ALL THE WEEK ////////////////

        $week_day_bookings = array();
        foreach($week_list as $week_day){

            // $day_number = date('w', strtotime($week_day));

            $table = 'service_bookings';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_week_day_bookings = $common_obj->set_config($table, $fillable);

            if(!$real_obj_week_day_bookings) return 'Common model config not set.';

            $week_day_bookings[$week_day] = $real_obj_week_day_bookings->where('slot_date', $week_day)->get()->toArray();
            
        } // foreach($week_list as $week_day)

        ////////// Get week off days by each week day //////////
        $week_off_days = array();
        foreach($week_list as $week_day){

            $day_number = date('N', strtotime($week_day));

            $table = 'service_booking_slots_off_days';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_week_off_days = $common_obj->set_config($table, $fillable);

            if(!$real_obj_week_off_days) return 'Common model config not set.';

            $week_off_days[$week_day] = $real_obj_week_off_days->where('slot_day_number', $day_number)->first();

            if(!empty($week_off_days[$week_day])){
                $week_off_days[$week_day] = $week_off_days[$week_day]->toArray();
            } // if(!empty($week_off_days[$week_day]))
            
        } // foreach($week_list as $week_day)

        ////////// Get week off dates by each week day //////////
        $week_off_dates = array();
        foreach($week_list as $week_day){

            // $day_number = date('N', strtotime($week_day));

            $table = 'service_booking_slots_off_dates';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_week_off_dates = $common_obj->set_config($table, $fillable);

            if(!$real_obj_week_off_dates) return 'Common model config not set.';

            $week_off_dates[$week_day] = $real_obj_week_off_dates->where('off_date', $week_day)->first();

            if(!empty($week_off_dates[$week_day])){
                $week_off_dates[$week_day] = $week_off_dates[$week_day]->toArray();
            } // if(!empty($week_off_dates[$week_day]))
            
        } // foreach($week_list as $week_day)

        ////////// Get pharmacy available slots [ ACTIVE ] //////////
        $week_day_available_slots = array();
        foreach($week_list as $week_day){

            $day_number = date('N', strtotime($week_day));

            $table = 'service_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_week_day_slots = $common_obj->set_config($table, $fillable);

            if(!$real_obj_week_day_slots) return 'Common model config not set.';

            $week_day_available_slots[$week_day] = $real_obj_week_day_slots->where('slot_day_number', $day_number)->where('slot_status', 'ACTIVE')->get()->toArray();
            
        } // foreach($week_list as $week_day)

        $data['week_day_bookings'] = $week_day_bookings;

        $data['week_off_days'] = $week_off_days;
        $data['week_off_dates'] = $week_off_dates;

        $data['week_day_available_slots'] = $week_day_available_slots;

        /*
        echo '<pre>';
        print_r($week_day_available_slots);
        exit;
        */
        
        return view(

                'bookings.calendar.next_prev_booking_calendar', ['data_arr' => $data]


            );

    } // End => public function next_prev_booking_calendar()

    // Start => public function add_new_inhouse_booking(Request $request)
    public function add_new_inhouse_booking(Request $request){

        /*
        
        calendar_pharmacy_id: "33"

        week_day: "2021-04-21"

        */

        $table_name = 'services';
        
        // $where_arr = array('pharmacy_id' => $request->calendar_pharmacy_id);
        $where_arr = array('status' => 'Y');

        $where_str = '';

        // Get all the services which are shared with the pharmacy and is bookable and available in pharmacy
        $shared_services_list = CommonEloHelper::get_table_result_where_arr($table_name, $where_arr, array('display_order' => 'asc'), array());

        // return $shared_services_list;

        $data['request_arr'] = $request->all();

        $data['shared_services_list'] = $shared_services_list;
        
        return view(

                'bookings.calendar.add_new_inhouse_booking', ['data_arr' => $data]

            );

    } // End => public function add_new_inhouse_booking(Request $request)

    // Start => public function add_new_inhouse_booking_process(Request $request)
    public function add_new_inhouse_booking_process(Request $request){

        /*
        booking_note: "1122"
        patient_id: "3"
        service_id: "28"
        slot_date: "20/04/2021"
        slot_start_time: "12:30:00"
        */

        $request->validate([

            // 'booking_note' => 'required',
            'patient_id' => 'required',
            'service_id' => 'required',
            'slot_date' => 'required',
            'slot_start_time' => 'required'

        ]);

        $slot_date_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $request->slot_date) ));

        $date_today = date('Y-m-d');
        if( strtotime($slot_date_mysql_format) < strtotime($date_today) ){

            $booking_status = 'COMPLETED';

        } else {

            $booking_status = 'PENDING';

        } // if( strtotime($slot_date_mysql_format) < strtotime($date_today) )

        $table = 'service_bookings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $ins_real_obj = $common_obj->set_config($table, $fillable);

        if(!$ins_real_obj) return 'Common model config not set.';

        $ins_real_obj->patient_id = $request->patient_id;
        $ins_real_obj->service_id = $request->service_id;
        $ins_real_obj->slot_date = $slot_date_mysql_format;
        $ins_real_obj->slot_start_time = $request->slot_start_time;
        $ins_real_obj->booking_date_time = date('Y-m-d H:i:s');
        $ins_real_obj->booking_status = $booking_status;
        $ins_real_obj->booking_type = 'INHOUSE';
        $ins_real_obj->booking_note = $request->booking_note;

        $ins_real_obj->save();

        /*
        ////////// Send Inhouse new booking email to customer //////////

        // Get service details
        $service_details = CommonEloHelper::get_table_row_where_arr('services', array('id' => $request->service_id) );

        // Get patient details
        $patient_details = CommonEloHelper::get_table_row('patients', $request->patient_id);

        $booking_date_time = date('M', strtotime( str_replace('/', '-', $request->slot_date) ));
        $booking_date_time .= ' '.date('d, Y', strtotime( str_replace('/', '-', $request->slot_date) ));
        $booking_date_time .= ' at '.date('g:i a', strtotime($request->slot_start_time));

        // Prepare pharmacy_signatures
        $pharmacy_signatures = '';
        
        ////////// SEND EMAIL TO ADMIN ////////////

        $email_template = CommonEloHelper::get_table_row_where_arr('pharmacy_email_templates', array('global_email_template_id' => '17') );

        if(!empty($email_template)){

            $to_email_address = $patient_details['email_address'];
            
            $reply_to_email_address = $pharmacy_contact_details['email_address_1'];
            
            $from_email_address = $pharmacy_contact_details['email_address_2'];
            
            $email_from_text = $pharmacy_details['pharmacy_name'];
            
            $email_subject = $email_template['email_subject'];
            
            $email_body = $email_template['email_body'];

            $search_arr = array(

                '[FIRST_NAME]',
                '[SERVICE_NAME]',
                '[PHARMACY_NAME]',
                '[BOOKING_DATE_TIME]',
                '[PHARMACY_SIGNATURES]'
            
            );

            $replace_arr = array(

                ucfirst($patient_details['first_name']),
                $service_details['title'],
                $pharmacy_details['pharmacy_name'],
                $booking_date_time,
                $pharmacy_signatures
        
            );

            $email_body = str_replace($search_arr, $replace_arr, $email_body);
           
            $attachment_arr = array();

            $this->SendMailService->send_email_ses(
                $to_email_address, 
                $from_email_address,
                $reply_to_email_address,
                $email_from_text, 
                $email_subject, 
                $email_body, 
                $attachment_arr
            
            );

        } // if(!empty($email_template))
        */

        $message='New booking successfully created.';
        
        Session::flash('success', $message);  
        return response()->success($message);

    } // End => public function add_new_inhouse_booking_process(Request $request)

    // Start => public function edit_booking(Request $request)
    public function edit_booking(Request $request){

        /*
        
        calendar_pharmacy_id: "33"

        week_day: "2021-04-21"

        booking_id: 34

        */

        // Get booking details
        $booking_details = CommonEloHelper::get_table_row('service_bookings', $request->booking_id);
        $data['booking_details'] = $booking_details;

        // $pharmacy_details = CommonEloHelper::get_table_row('pharmacies', $booking_details->pharmacy_id);
        // $data['pharmacy_details'] = $pharmacy_details;

        $patient_details = CommonEloHelper::get_table_row('patients', $booking_details->patient_id);
        $data['patient_details'] = $patient_details;

        $table_name = 'services';
        
        // $where_arr = array('pharmacy_id' => $booking_details->pharmacy_id);
        $where_arr = array();

        // Get all the services which are shared with the pharmacy and is bookable and available in pharmacy
        $shared_services_list = CommonEloHelper::get_table_result_where_arr($table_name, $where_arr, array(), array());

        // return $shared_services_list;

        $data['request_arr'] = $request->all();

        $data['shared_services_list'] = $shared_services_list;
        
        return view(

                'bookings.calendar.edit_booking', ['data_arr' => $data]

            );

    } // End => public function edit_booking(Request $request)

    // Start => public function edit_booking_process(Request $request)
    public function edit_booking_process(Request $request){

        // return $request;

        /*
        booking_id: "1"
        booking_note: "123"
        booking_status: "COMPLETED"
        calendar_pharmacy_id: "33"
        patient_id: "3"
        service_id: "28"
        slot_date: "19/04/2021"
        slot_start_time: "11:00:00"
        */

        $request->validate([

            // 'booking_note' => 'required',
            'patient_id' => 'required',
            // 'calendar_pharmacy_id' => 'required',
            'service_id' => 'required',
            'slot_date' => 'required',
            'slot_start_time' => 'required'

        ]);

        $slot_date_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $request->slot_date) ));

        $booking_details = CommonEloHelper::get_table_row('service_bookings', $request->booking_id);

        // $booking_details->pharmacy_id = $request->calendar_pharmacy_id;
        // $booking_details->patient_id = $request->patient_id;
        $booking_details->service_id = $request->service_id;
        $booking_details->slot_date = $slot_date_mysql_format;
        $booking_details->slot_start_time = $request->slot_start_time;
        $booking_details->booking_date_time = date('Y-m-d H:i:s');
        $booking_details->booking_status = $request->booking_status;
        // $booking_details->booking_type = 'INHOUSE';
        $booking_details->booking_note = $request->booking_note;

        $booking_details->save();

        /////////////////////// SENDING EMAIL ///////////////////////

        // Get service details
        $service_details = CommonEloHelper::get_table_row_where_arr('services', array('id' => $request->service_id) );

        // Get patient details
        $patient_details = CommonEloHelper::get_table_row('patients', $request->patient_id);

        $booking_date_time = date('M', strtotime( str_replace('/', '-', $request->slot_date) ));
        $booking_date_time .= ' '.date('d, Y', strtotime( str_replace('/', '-', $request->slot_date) ));
        $booking_date_time .= ' at '.date('g:i a', strtotime($request->slot_start_time));

        // Prepare pharmacy_signatures
        $pharmacy_signatures = '';

        // Check if status requested is Completed
        if($request->booking_status == 'PENDING'){

            ////////// Send pending booking notification email email to customer //////////

            $email_template = CommonEloHelper::get_table_row_where_arr('pharmacy_email_templates', array('pharmacy_id' => session()->get('pharmacy_id'), 'global_email_template_id' => '14') );

            if(!empty($email_template)){

                $to_email_address = $patient_details['email_address'];
                
                $reply_to_email_address = $pharmacy_contact_details['email_address_1'];
                
                $from_email_address = $pharmacy_contact_details['email_address_2'];
                
                $email_from_text = $pharmacy_details['pharmacy_name'];
                
                $email_subject = $email_template['email_subject'];
                
                $email_body = $email_template['email_body'];

                $search_arr = array(

                    '[FIRST_NAME]',
                    '[SERVICE_NAME]',
                    '[PHARMACY_NAME]',
                    '[BOOKING_DATE_TIME]',
                    '[PHARMACY_SIGNATURES]'
                
                );

                $replace_arr = array(

                    ucfirst($patient_details['first_name']),
                    $service_details['title'],
                    $pharmacy_details['pharmacy_name'],
                    $booking_date_time,
                    $pharmacy_signatures
            
                );

                $email_body = str_replace($search_arr, $replace_arr, $email_body);
               
                $attachment_arr = array();

                $this->SendMailService->send_email_ses(
                    $to_email_address, 
                    $from_email_address,
                    $reply_to_email_address,
                    $email_from_text, 
                    $email_subject, 
                    $email_body, 
                    $attachment_arr
                
                );

            } // if(!empty($email_template))

        } else if($request->booking_status == 'COMPLETED'){

            ////////// Send completed booking notification email email to customer //////////

            $email_template = CommonEloHelper::get_table_row_where_arr('pharmacy_email_templates', array('pharmacy_id' => session()->get('pharmacy_id'), 'global_email_template_id' => '16') );

            if(!empty($email_template)){

                $to_email_address = $patient_details['email_address'];
                
                $reply_to_email_address = $pharmacy_contact_details['email_address_1'];
                
                $from_email_address = $pharmacy_contact_details['email_address_2'];
                
                $email_from_text = $pharmacy_details['pharmacy_name'];
                
                $email_subject = $email_template['email_subject'];
                
                $email_body = $email_template['email_body'];

                $search_arr = array(

                    '[FIRST_NAME]',
                    '[SERVICE_NAME]',
                    '[PHARMACY_NAME]',
                    '[BOOKING_DATE_TIME]',
                    '[PHARMACY_SIGNATURES]'
                
                );

                $replace_arr = array(

                    ucfirst($patient_details['first_name']),
                    $service_details['title'],
                    $pharmacy_details['pharmacy_name'],
                    $booking_date_time,
                    $pharmacy_signatures
            
                );

                $email_body = str_replace($search_arr, $replace_arr, $email_body);
               
                $attachment_arr = array();

                $this->SendMailService->send_email_ses(
                    $to_email_address, 
                    $from_email_address,
                    $reply_to_email_address,
                    $email_from_text, 
                    $email_subject, 
                    $email_body, 
                    $attachment_arr
                
                );

            } // if(!empty($email_template))

        } else if($request->booking_status == 'CANCELLED'){

            ////////// Send cancelled booking notification email email to customer //////////

            $email_template = CommonEloHelper::get_table_row_where_arr('pharmacy_email_templates', array('pharmacy_id' => session()->get('pharmacy_id'), 'global_email_template_id' => '15') );

            if(!empty($email_template)){

                $to_email_address = $patient_details['email_address'];
                
                $reply_to_email_address = $pharmacy_contact_details['email_address_1'];
                
                $from_email_address = $pharmacy_contact_details['email_address_2'];
                
                $email_from_text = $pharmacy_details['pharmacy_name'];
                
                $email_subject = $email_template['email_subject'];
                
                $email_body = $email_template['email_body'];

                $search_arr = array(

                    '[FIRST_NAME]',
                    '[SERVICE_NAME]',
                    '[PHARMACY_NAME]',
                    '[BOOKING_DATE_TIME]',
                    '[PHARMACY_SIGNATURES]'
                
                );

                $replace_arr = array(

                    ucfirst($patient_details['first_name']),
                    $service_details['title'],
                    $pharmacy_details['pharmacy_name'],
                    $booking_date_time,
                    $pharmacy_signatures
            
                );

                $email_body = str_replace($search_arr, $replace_arr, $email_body);
               
                $attachment_arr = array();

                $this->SendMailService->send_email_ses(
                    $to_email_address, 
                    $from_email_address,
                    $reply_to_email_address,
                    $email_from_text, 
                    $email_subject, 
                    $email_body, 
                    $attachment_arr
                
                );

            } // if(!empty($email_template))

        } // if($request->booking_status == 'PENDING')

        $message='Booking successfully updated.';
        return $this->success($booking_details, 200, $message);

    } // End => public function edit_booking_process(Request $request)

    // Start => public function get_week_day_available_slots(Request $request)
    public function get_week_day_available_slots(Request $request){

        /*
        service_id: 28
        
        week_day: "22/04/2021"

        edit_slot_start_time: 12:12:00 [ optional ]
        edit_booking_id: 34 [ optional ]

        */

        $week_day_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $request->week_day) ));
        $data['week_day_mysql_format'] = $week_day_mysql_format;

        $service_start_date_error = '';
        if(!empty($request->service_id)){

            $service_details = CommonEloHelper::get_table_row('services', $request->service_id);

            if( strtotime($week_day_mysql_format) < strtotime( $service_details['service_start_date'] ) ){

                $service_start_date_error = 'Sorry! Service start date is '.date('d/m/Y', strtotime($service_details['service_start_date']));

            } // if( strtotime($week_day_mysql_format) < strtotime( $service_details['service_start_date'] ) )

        } // if(!empty($request->service_id))

        $data['service_start_date_error'] = $service_start_date_error;

        // Get booking slots for the day selected
        $day_number = date('N', strtotime($week_day_mysql_format));

        $table = 'service_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_week_day_slots = $common_obj->set_config($table, $fillable);

        if(!$real_obj_week_day_slots) return 'Common model config not set.';

        $week_day_available_slots = array();
        $week_day_available_slots = $real_obj_week_day_slots->where('slot_day_number', $day_number)->where('slot_status', 'ACTIVE')->get()->toArray();

        ////////////////// [ 1 ] - DAY / DATES => ON / OFF for booking slots //////////////////

        // Get day on off status
        $day_number = date('N', strtotime($week_day_mysql_format));

        $table = 'service_booking_slots_off_days';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_week_off_days = $common_obj->set_config($table, $fillable);

        if(!$real_obj_week_off_days) return 'Common model config not set.';

        $day_off = array();
        $day_off = $real_obj_week_off_days->where('slot_day_number', $day_number)->first();

        if(!empty($day_off)){
            $day_off = $day_off->toArray();
        } // if(!empty($day_off))

        // Get off dates for the date
        $table = 'service_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_week_off_dates = $common_obj->set_config($table, $fillable);

        if(!$real_obj_week_off_dates) return 'Common model config not set.';

        $date_off = array();
        $date_off = $real_obj_week_off_dates->where('off_date', $week_day_mysql_format)->first();

        if(!empty($date_off)){
            $date_off = $date_off->toArray();
        } // if(!empty($date_off))

        $data['day_off'] = $day_off;
        $data['date_off'] = $date_off;

        ////////////////// [ 2 ] - DAY / DATES => ON / OFF for services //////////////////

        // Get day on off status
        $day_number = date('N', strtotime($week_day_mysql_format));

        $table = 'service_off_days';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_service_off_days = $common_obj->set_config($table, $fillable);

        if(!$real_obj_service_off_days) return 'Common model config not set.';

        $service_day_off = array();
        $service_day_off = $real_obj_service_off_days->where('service_id', $request->service_id)->where('day_number', $day_number)->first();

        if(!empty($service_day_off)){
            $service_day_off = $service_day_off->toArray();
        } // if(!empty($service_day_off))

        // Get off dates for the date
        $table = 'service_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_service_off_dates = $common_obj->set_config($table, $fillable);

        if(!$real_obj_service_off_dates) return 'Common model config not set.';

        $service_date_off = array();
        $service_date_off = $real_obj_service_off_dates->where('service_id', $request->service_id)->where('off_date', $week_day_mysql_format)->first();

        if(!empty($service_date_off)){
            $service_date_off = $service_date_off->toArray();
        } // if(!empty($service_date_off))

        $data['service_day_off'] = $service_day_off;
        $data['service_date_off'] = $service_date_off;

        // Common load veriables into the blade
        $data['request_arr'] = $request->all();

        $data['week_day_available_slots'] = $week_day_available_slots;

        // Optional fields
        $data['edit_slot_start_time'] = (!empty($request->edit_slot_start_time)) ? $request->edit_slot_start_time : '' ;
        
        $data['edit_booking_id'] = (!empty($request->edit_booking_id)) ? $request->edit_booking_id : '' ;

        if(!empty($request->edit_booking_id)){

            $booking_details = CommonEloHelper::get_table_row('service_bookings', $request->edit_booking_id);

        } else {

            $booking_details = array();

        } // if(!empty($request->edit_booking_id))

        $data['booking_details'] = $booking_details;

        return view(

                'bookings.calendar.parts.booking_time_slots', ['data_arr' => $data]

            );

    } // End => public function get_week_day_available_slots(Request $request)

    // Start => public function weeks($month, $year)
    // Function to get total number of weeks in a month
    public function weeks($month, $year){

        $num_of_days = date("t", mktime(0,0,0,$month,1,$year)); 
        $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
        $no_of_weeks = 0; 
        $count_weeks = 0; 
        
        while($no_of_weeks < $lastday){ 
            $no_of_weeks += 7; 
            $count_weeks++; 
        }

        return $count_weeks;

    } // End => public function weeks($month, $year)

    public function week_from_monday($date){
        
        // Assuming $date is in format DD-MM-YYYY
        $exploded = explode("-", $date);

        $year = $exploded[0];
        $month = $exploded[1];
        $day = $exploded[2];
        
        // Get the weekday of the given date
        $wkday = date('l',mktime('0','0','0', $month, $day, $year));

        switch($wkday){
            case 'Monday': $numDaysToMon = 0; break;
            case 'Tuesday': $numDaysToMon = 1; break;
            case 'Wednesday': $numDaysToMon = 2; break;
            case 'Thursday': $numDaysToMon = 3; break;
            case 'Friday': $numDaysToMon = 4; break;
            case 'Saturday': $numDaysToMon = 5; break;
            case 'Sunday': $numDaysToMon = 6; break;
        }

        // Timestamp of the monday for that week
        $monday = mktime('0','0','0', $month, $day-$numDaysToMon, $year);

        $seconds_in_a_day = 86400;

        // Get date for 7 days from Monday (inclusive)
        for($i=0; $i<7; $i++)
        {
            $dates[$i] = date('Y-m-d',$monday+($seconds_in_a_day*$i));
        }

        return $dates;
    }

    //////// Note: Function to show process booking popup ////////

    // Start => public function booking_process(Request $request)
    public function booking_process(Request $request){

        // $pharmacy_details = Pharmacy::with('address','contact_details','general_details','social_media')->first();

        $pharmacyInfo          = PharmacyInfo::first();
        $pharmacy_settings     = PharmacySettings::first();
        $pharmacy_opening_hour = PharmacyOpeningHour::first();

        $booking_details = CommonEloHelper::get_table_row('mc_service_bookings', $request->booking_id);
        
        $patient_details = CommonEloHelper::get_table_row('kod_patients', $booking_details['patient_id']);
    
        $prescriber_details = array();

        if($booking_details['booking_status'] == 'PENDING'){

            // Loggedin
            $prescriber_details = Auth::user();

        } else if($booking_details['booking_status'] == 'COMPLETED'){

            // completed_by_id
            $prescriber_details = User::findOrFail( $booking_details['completed_by_id'] );

        } else if($booking_details['booking_status'] == 'CANCELLED'){

            if($booking_details['cancelled_by'] == 'PHARMACY'){

                // cancelled_by_id
                $prescriber_details = User::findOrFail( $booking_details['cancelled_by_id'] );

            } else if($booking_details['cancelled_by'] == 'PATIENT'){

                // Loggedin
                $prescriber_details = Auth::user();

            } // if($booking_details['cancelled_by'] == 'PHARMACY')

        } // if($booking_details['booking_status'] == 'PENDING')

        return view(

                'bookings.booking_process', ['booking_details' => $booking_details, 'pharmacy_details' => $pharmacyInfo, 'pharmacy_settings' => $pharmacy_settings, 'patient_details' => $patient_details, 'prescriber_details' => $prescriber_details]

            );

    } // End => public function booking_process(Request $request)

    // Start => public function save_print_booking_process(Request $request)
    public function save_print_booking_process(Request $request){

        /*
        action: "save_print"
        booking_id: "2"
        booking_status: "CANCELLED"
        igm: "Positive"
        pcr_test_date: "1234"
        */

        // return $request->all();

        $table = 'mc_service_bookings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj = $common_obj->set_config($table, $fillable);

        if(!$real_obj) return 'Common model config not set.';

        // Remove old days
        $item_details = $real_obj->findOrFail($request->booking_id);

        $item_details->booking_status = $request->booking_status;
        $item_details->igm_result = $request->igm;
        $item_details->pcr_test_date = $request->pcr_test_date;

        // Log completing or cancelling person and dates

        if($request->booking_status == 'COMPLETED'){

            $item_details->completed_by_id = auth()->user()->id;
            $item_details->completed_date_time = date('Y-m-d H:i:s');

        } else if($request->booking_status == 'CANCELLED'){

            $item_details->cancelled_by = 'PHARMACY';
            $item_details->cancelled_by_id = auth()->user()->id;
            $item_details->cancelled_date_time = date('Y-m-d H:i:s');

        } // if($request->booking_status == 'COMPLETED')

        $item_details->save();

        $message = 'Booking successfully updated';
        
        Session::flash('success', $message);
        return response()->success($message);

    } // End => public function save_print_booking_process(Request $request)

    // Start => public function print_booking($booking_id=false)
    public function print_booking($booking_id=false){

        // $pharmacy_details = Pharmacy::with('address','contact_details','general_details','social_media')->first();

        $pharmacy_info     = PharmacyInfo::first();
        $pharmacy_settings = PharmacySettings::first();

        $booking_details = CommonEloHelper::get_table_row('mc_service_bookings', $booking_id);
        
        $patient_details = CommonEloHelper::get_table_row('kod_patients', $booking_details['patient_id']);
    
        $prescriber_details = array();

        if($booking_details['booking_status'] == 'PENDING'){

            // Loggedin
            $prescriber_details = Auth::user();

        } else if($booking_details['booking_status'] == 'COMPLETED'){

            // completed_by_id
            $prescriber_details = User::findOrFail( $booking_details['completed_by_id'] );

        } else if($booking_details['booking_status'] == 'CANCELLED'){

            if($booking_details['cancelled_by'] == 'PHARMACY'){

                // cancelled_by_id
                $prescriber_details = User::findOrFail( $booking_details['cancelled_by_id'] );

            } else if($booking_details['cancelled_by'] == 'PATIENT'){

                // Loggedin
                $prescriber_details = Auth::user();

            } // if($booking_details['cancelled_by'] == 'PHARMACY')

        } // if($booking_details['booking_status'] == 'PENDING')

        // $pdf = PDF::loadView
        $pdf = PDF::loadView(

            'bookings.booking_pdf',

            ['booking_details' => $booking_details, 'patient_details' => $patient_details, 'pharmacy_info' => $pharmacy_info, 'pharmacy_settings' => $pharmacy_settings, 'prescriber_details' => $prescriber_details]

        );  
        
        return $pdf->download('booking.pdf');
        
    } // End => public function print_booking($booking_id=false)

    // Start => public function print_all_bookings(Request $request)
    public function print_all_bookings(Request $request){

        $date_filter = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_filter)));

        $pharmacy_info     = PharmacyInfo::first();
        $pharmacy_settings = PharmacySettings::first();

        // return $request;

        $all_bookings = CommonEloHelper::get_table_result_where_arr_str('mc_service_bookings', array('booking_status' => $request->status_filter), ' DATE(created_at) = "'.$date_filter.'"', array('id' => 'DESC'));
    
        $prescriber_details = array();

        if($request->status_filter == 'PENDING'){

            // Loggedin
            $prescriber_details = Auth::user();

            // $pdf = PDF::loadView
            $pdf = PDF::loadView(

                'bookings.all_bookings_pdf',

                ['is_pending' => '1', 'all_bookings' => $all_bookings, 'pharmacy_info' => $pharmacy_info, 'pharmacy_settings' => $pharmacy_settings, 'prescriber_details' => $prescriber_details]

            );  

        } else {

            // $pdf = PDF::loadView
            $pdf = PDF::loadView(

                'bookings.all_bookings_pdf',

                ['is_pending' => '']

            );  

        } // if($request->status_filter == 'PENDING')
        
        return $pdf->download('booking.pdf');
        
    } // End => public function print_all_bookings(Request $request)

    // Start => public function delete_booking_process(Request $request)
    public function delete_booking_process(Request $request){

        $booking_details = CommonEloHelper::get_table_row('mc_service_bookings', $request->booking_id);
        $booking_details->delete();
        
        Session::flash('success','Booking deleted successfully');  
        return response()->success('Booking deleted successfully');

    } // End => public function delete_booking_process(Request $request)

    /********** End => Booking Calendar Functions **********/

}