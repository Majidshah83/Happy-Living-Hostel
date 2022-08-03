<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Models\PharmacyMenuStaticPage;
// use App\Models\PharmacyMenuPosition;
// use App\Models\PharmacyMenu;

use Illuminate\Support\Str;

use CommonCustomHelper;
use CommonEloHelper;

use App\Models\PharmacyMenu;

// Custom Validation Rules
// use App\Rules\ValidateTitlesRule;

use Session;

use Illuminate\Support\Facades\Schema;
use App\Models\CommonModel;

class BookingSlotsController extends Controller{

    public function __construct(){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Start => public function booking_slots()
    public function booking_slots(){

        // Week day numbers array
        $week_day_numbers = array('1', '2', '3', '4', '5', '6', '7');

        ////////////// Get all week slots by days //////////////
        
        $week_day_slots = array();
        foreach($week_day_numbers as $day_number){

            $table = 'mc_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots = $common_obj->set_config($table, $fillable);

            $week_day_slots[$day_number] = $real_obj_service_booking_slots->where('slot_day_number', $day_number)->get()->toArray();
            
        } // foreach($week_day_numbers as $day_number)

        ////////////// Get all week slots On/Off status by days //////////////

        $week_day_on_off_status = array();
        foreach($week_day_numbers as $day_number){

            $table = 'mc_booking_slots_off_days';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots_off_days = $common_obj->set_config($table, $fillable);

            $week_day_on_off_status[$day_number] = $real_obj_service_booking_slots_off_days->where('slot_day_number', $day_number)->get()->toArray();

        } // foreach($week_day_numbers as $day_number)

        // return $week_day_on_off_status;

        return view('backend.admin.booking_slots.booking_slots', ['week_day_on_off_status' => $week_day_on_off_status, 'week_day_slots' => $week_day_slots]);

    } // End => public function booking_slots()

    // Start => public function day_on_off(Request $request)
    public function day_on_off(Request $request){

        // return $request;

        $table = 'mc_booking_slots_off_days';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $elo_obj = $common_obj->set_config($table, $fillable);

        $elo_obj->where('slot_day_number', $request->day_number)->delete();
        
        if($request->day_is_off == 'Y'){

            $elo_obj->slot_day_number = $request->day_number;
            $elo_obj->day_is_off = $request->day_is_off;

            $elo_obj->save();

        } // if($request->day_is_off == 'Y')

        Session::flash('success','Day on/off status successfully updated.');  
        return response()->success('Day on/off status successfully updated.');

    } // End => public function day_on_off(Request $request)

    // Start => public function settings()
    public function settings(){

        // [ 1 ] => Get mc_booking_slots_settings

        $table = 'mc_booking_slots_settings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_settings = $common_obj->set_config($table, $fillable);

        $settings = $real_obj_booking_slots_settings->where('service_id', NULL)->get()->first();
        
        // [ 2 ] => Get mc_booking_slots_off_dates
        $table = 'mc_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

        $off_dates = $real_obj_booking_slots_off_dates->where('service_id', NULL)->get()->toArray();

        $comma_saperated_off_arr = array();

        if(!empty($off_dates)){

            $off_date_arr = array_column($off_dates, 'off_date');

            if(!empty($off_date_arr)){
                foreach($off_date_arr as $date){

                    $comma_saperated_off_arr[] = date('d/m/Y', strtotime($date));

                } // foreach($off_date_arr as $date)

            } // if(!empty($off_date_arr))

        }

        $comma_saperated_off_dates = implode(',', $comma_saperated_off_arr);

        // [ 3 ] => Get mc_booking_slots_on_dates
        $table = 'mc_booking_slots_on_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_on_dates = $common_obj->set_config($table, $fillable);

        $on_dates = $real_obj_booking_slots_on_dates->where('service_id', NULL)->get()->toArray();

        $comma_saperated_on_arr = array();

        if(!empty($on_dates)){

            $on_date_arr = array_column($on_dates, 'on_date');

            if(!empty($on_date_arr)){
                foreach($on_date_arr as $date){

                    $comma_saperated_on_arr[] = date('d/m/Y', strtotime($date));

                } // foreach($on_date_arr as $date)

            } // if(!empty($on_date_arr))

        }

        $comma_saperated_on_dates = implode(',', $comma_saperated_on_arr);

        return view('backend.admin.booking_slots.settings', [

            'settings' => $settings,
            'comma_saperated_off_dates' => $comma_saperated_off_dates,
            'comma_saperated_on_dates' => $comma_saperated_on_dates

        ]);

    } // End => public function settings()

    // Start => public function day_slots(Request $request)
    public function day_slots(Request $request){

        /*
        day_number: "4"
        */

        $day_number = $request->day_number;

        $week_day_names = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');

        // echo '<pre>'; print_r($week_day_names[$day_number-1]); exit;

        $week_day_name = $week_day_names[$day_number-1];

        // [ 1 ] => Get day slots FROM booking_slots
        $table = 'mc_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

        if(!$real_obj_booking_slots) return 'Common model config not set.';

        $week_day_slots = $real_obj_booking_slots->where('slot_day_number', $day_number)->get()->toArray();

        // [ 2 ] => Get day on / off status FROM booking_slots_off_days
        $table = 'mc_booking_slots_off_days';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_off_days = $common_obj->set_config($table, $fillable);

        if(!$real_obj_booking_slots_off_days) return 'Common model config not set.';

        $week_day_on_off_status = $real_obj_booking_slots_off_days->where('slot_day_number', $day_number)->get()->toArray();
 
        return view(

            'backend.admin.booking_slots.day_slots',

            [

                'day_number' => $day_number,
                'week_day_name' => $week_day_name,
                'week_day_slots' => $week_day_slots,
                'week_day_on_off_status' => $week_day_on_off_status

            ]

        );

    } // End => public function day_slots(Request $request)

    // Start => public function
    public function date_slots(Request $request){

        /*
        slot_date: "2021-07-01"
        */

        $slot_date = $request->slot_date;

        $slot_day_number = date('N', strtotime($slot_date));

        // [ 1 ] => Get day slots FROM booking_slots
        $table = 'mc_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

        $week_day_slots = $real_obj_booking_slots->where('slot_day_number', $slot_day_number)->get()->toArray();

        // Get array column arr of time slots in Master
        $week_day_slots_arr_column = array();
        if(!empty($week_day_slots)){

            $week_day_slots_arr_column = array_column($week_day_slots, 'slot_start_time');

        } // if(!empty($week_day_slots))

        // [ 1.1 ] => Get day slots FROM booking_slots_local
        $table = 'mc_booking_slots_local';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

        $week_date_slots = $real_obj_booking_slots->where('slot_date', $slot_date)->get()->toArray();

        // Get array column arr of time slots in Local
        $week_date_slots_arr_column = array();
        if(!empty($week_date_slots)){

            $week_date_slots_arr_column = array_column($week_date_slots, 'slot_start_time');

        } // if(!empty($week_date_slots))

        // [ 2 ] => Get day on / off status FROM booking_slots_off_dates
        $table = 'mc_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

        if(!$real_obj_booking_slots_off_dates) return 'Common model config not set.';

        $week_date_on_off_status = $real_obj_booking_slots_off_dates->where('off_date', $slot_date)->get()->toArray();
 
        return view(

            'backend.admin.booking_slots.date_slots',

            [

                'slot_date' => $slot_date,
                'week_day_slots' => $week_day_slots,
                'week_date_slots' => $week_date_slots,
                'week_date_on_off_status' => $week_date_on_off_status,

                'week_day_slots_arr_column' => $week_day_slots_arr_column,
                'week_date_slots_arr_column' => $week_date_slots_arr_column,

            ]

        );

    } // End => public function

    // Start => public function settings_process(Request $request)
    public function settings_process(Request $request){

        /*
        calendar_is_off: Y
        booking_start_date: "09/06/2021"
        off_dates: "22/06/2021,24/06/2021"
        on_dates: "23/06/2021,24/06/2021,19/06/2021"
        */

        ///////////////// START DATE PROCESS ///////////

        $table = 'mc_booking_slots_settings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_settings = $common_obj->set_config($table, $fillable);

        // Remove old dates
        $real_obj_booking_slots_settings->where('service_id', NULL)->delete();
        
        $booking_start_date_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $request->booking_start_date) ));

        $table = 'mc_booking_slots_settings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $ins_real_obj_booking_slots_settings = $common_obj->set_config($table, $fillable);

        if( !empty($request->booking_start_date) ){

            $ins_real_obj_booking_slots_settings->booking_start_date = $booking_start_date_mysql_format;
            $ins_real_obj_booking_slots_settings->save();

        } // if( !empty($request->booking_start_date) )

        if(!empty($request->calendar_is_off) && $request->calendar_is_off == 'N'){

            $ins_real_obj_booking_slots_settings->calendar_is_off = $request->calendar_is_off;
            $ins_real_obj_booking_slots_settings->save();

        } else {

            $ins_real_obj_booking_slots_settings->calendar_is_off = 'Y';
            $ins_real_obj_booking_slots_settings->save();

        } // if(!empty($request->calendar_is_off) && $request->calendar_is_off == 'Y')

        ///////////// OFF DATES PROCESS //////////////

        $table = 'mc_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

        // Remove old dates
        $real_obj_booking_slots_off_dates->where('service_id', NULL)->delete();

        // return $request->off_dates;

        // Insert new dates
        if( !empty($request->off_dates) ){

            $off_dates_arr = explode(',', $request->off_dates);

            foreach($off_dates_arr as $off_date){

                $slot_date_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $off_date) ));

                $table = 'mc_booking_slots_off_dates';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $ins_real_obj_booking_slots_off_dates = $common_obj->set_config($table, $fillable);

                $ins_real_obj_booking_slots_off_dates->off_date = $slot_date_mysql_format;

                $ins_real_obj_booking_slots_off_dates->save();

            } // foreach($off_dates_arr as $day_number)

        } // if( !empty($request->off_dates) )

        ///////////////// ON DATES PROCESS ///////////

        $table = 'mc_booking_slots_on_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots_on_dates = $common_obj->set_config($table, $fillable);

        // Remove old dates
        $real_obj_booking_slots_on_dates->where('service_id', NULL)->delete();

        // Insert new dates
        if( !empty($request->on_dates) ){

            $on_dates_arr = explode(',', $request->on_dates);

            foreach($on_dates_arr as $on_date){

                $slot_date_mysql_format = date('Y-m-d', strtotime( str_replace('/', '-', $on_date) ));

                $table = 'mc_booking_slots_on_dates';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $ins_real_obj_booking_slots_on_dates = $common_obj->set_config($table, $fillable);

                $ins_real_obj_booking_slots_on_dates->on_date = $slot_date_mysql_format;

                $ins_real_obj_booking_slots_on_dates->save();

            } // foreach($on_dates_arr as $day_number)

        } // if( !empty($request->on_dates) )

        Session::flash('success','Settings successfully updated.');  
        return response()->success('Settings successfully updated.');
        
    } // End => public function settings_process(Request $request)

    // Start => public function add_slots_process(Request $request)
    public function add_slots_process(Request $request){

        /*
        day_number: 5
        start_time: "8:24 AM"
        end_time: "11:24 AM"
        time_interval: "5"
        */

        $start_time = date('H:i:s', strtotime($request->start_time));
        $end_time = date('H:i:s', strtotime($request->end_time));
        $interval = $request->time_interval;

        $new_slots_arr = $this->generate_time_slot($start_time, $end_time, $interval);

        if( count($new_slots_arr) > 1 ){

            $last_index = count($new_slots_arr) - 1;
            unset( $new_slots_arr[$last_index] );

        } // if( count($new_slots_arr) > 1 )

        if( !empty($new_slots_arr) ){
            foreach($new_slots_arr as $slot){

                $table = 'mc_booking_slots';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

                $real_obj_booking_slots->slot_day_number = $request->day_number;
                $real_obj_booking_slots->slot_start_time = $slot;
                $real_obj_booking_slots->allowed_bookings = '1';
                $real_obj_booking_slots->slot_status = 'ACTIVE';

                $real_obj_booking_slots->save();

            } // foreach($new_slots_arr as $slot)
        } // if( !empty($new_slots_arr) )

        Session::flash('success','Slots successfully updated.');  
        return response()->success('Slots successfully updated.');
        
    } // End => public function add_slots_process(Request $request)

    // Start => public function generate_time_slot($start_time, $end_time, $interval)
    public function generate_time_slot($StartTime, $EndTime, $Duration){

        $ReturnArray = array ();// Define output
        $StartTime    = strtotime ($StartTime); //Get Timestamp
        $EndTime      = strtotime ($EndTime); //Get Timestamp

        $AddMins  = $Duration * 60;

        while ($StartTime <= $EndTime) //Run loop
        {
            $ReturnArray[] = date ("G:i", $StartTime);
            $StartTime += $AddMins; //Endtime check
        }
        return $ReturnArray;

    } // End => public function generate_time_slot($start_time, $end_time, $interval)

    // Start => public function change_slot_status(Request $request)
    public function change_slot_status(Request $request){

        /*
        item_id: "1"
        value: "RESERVED"
        */

        $table = 'mc_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

        $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

        $item_details->slot_status = $request->value;

        $item_details->save();

        Session::flash('success','Slot status successfully updated.');  
        return response()->success('Slot status successfully updated.');

    } // End => public function change_slot_status(Request $request)

    // Start => public function date_change_slot_status(Request $request)
    public function date_change_slot_status(Request $request){

        /*
        is_master_slot: "1"
        item_id: "15"
        slot_date: "2021-07-02"
        value: "RESERVED"
        */

        // return $request;

        if(!empty($request->is_master_slot) && $request->is_master_slot == '1'){

            // Master slot

            // Get master slot row from mc_booking_slots
            $table = 'mc_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

            $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

            if(!empty($item_details)){

                // Verify is already made the copy

                // Make a local copy from master for the requested time slot row by item_id
                $table = 'mc_booking_slots_local';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_exist = $common_obj->set_config($table, $fillable);

                $already_exist_in_local = $real_obj_exist->where('slot_date', $request->slot_date)->where('slot_start_time', $item_details->slot_start_time)->get()->first();

                // Make a local copy from master for the requested time slot row by item_id
                $table = 'mc_booking_slots_local';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_booking_slots_local = $common_obj->set_config($table, $fillable);

                if(!empty($already_exist_in_local)){

                    // Update Existing

                    $already_exist_in_local->slot_status = $request->value;
                    $already_exist_in_local->save();

                } else {

                    // Create New

                    $real_obj_booking_slots_local->is_master_clone = 'Y';

                    $real_obj_booking_slots_local->slot_date = $request->slot_date;
                    $real_obj_booking_slots_local->slot_start_time = $item_details->slot_start_time;
                    $real_obj_booking_slots_local->allowed_bookings = $item_details->allowed_bookings;
                    $real_obj_booking_slots_local->slot_status = $request->value;

                    $real_obj_booking_slots_local->save();

                } // if(!empty($already_exist_in_local))

            } // if(!empty($item_details))

        } else {

            // Local slot

            $table = 'mc_booking_slots_local';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

            $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

            $item_details->slot_status = $request->value;

            $item_details->save();

        } // if(!empty($request->is_master_slot) && $request->is_master_slot == '1')

        Session::flash('success','Slot status successfully updated.');  
        return response()->success('Slot status successfully updated.');

    } // End => public function date_change_slot_status(Request $request)

    public function remove_slots(Request $request){

        /*
        item_id: "17"
        */

        // return $request;

        $table = 'mc_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

        $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

        $item_details->delete();

        Session::flash('success','Slot successfully removed.');  
        return response()->success('Slot successfully removed.');

    } // End => public function

    public function date_remove_slots(Request $request){

        /*
        item_id: "20"
        is_master_slot: "1"
        slot_date: "2021-07-02"
        */

        if(!empty($request->is_master_slot) && $request->is_master_slot == '1'){

            // Is Master => save in local with is_deleted = 1
            // Check if already exist as cloned then update the local row

            // Get item details from global slots table
            $table = 'mc_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

            $global_item_details = $real_obj_booking_slots->where('id', $request->item_id)->get()->first();

            if(!empty($global_item_details)){

                // Get item details from local slots table
                $table = 'mc_booking_slots_local';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_booking_slots_local = $common_obj->set_config($table, $fillable);

                $local_item_details = $real_obj_booking_slots_local->where('is_master_clone', 'Y')->where('slot_date', $request->slot_date)->where('slot_start_time', $global_item_details->slot_start_time)->get()->first();

                if(!empty($local_item_details)){

                    // Already clone done => update
                    $local_item_details->is_deleted = 'Y';
                    $local_item_details->save();

                } else {

                    // Make clone => insert

                    // Get item details from local slots table
                    $table = 'mc_booking_slots_local';
                    $fillable =  Schema::getColumnListing($table);
                    $common_obj = new CommonModel();
                    $real_obj_booking_slots_local_insert = $common_obj->set_config($table, $fillable);

                    $real_obj_booking_slots_local_insert->is_master_clone = 'Y';
                    $real_obj_booking_slots_local_insert->slot_date = $request->slot_date;
                    $real_obj_booking_slots_local_insert->slot_start_time = $global_item_details->slot_start_time;
                    $real_obj_booking_slots_local_insert->allowed_bookings = $global_item_details->allowed_bookings;
                    $real_obj_booking_slots_local_insert->slot_status = $global_item_details->slot_status;
                    $real_obj_booking_slots_local_insert->is_deleted = 'Y';

                    $real_obj_booking_slots_local_insert->save();

                } // if(!empty($local_item_details))

            } // if(!empty($global_item_details))

            // return 'is master slot';

        } else {

            // Is Local

            // Get item details from local slots table
            $table = 'mc_booking_slots_local';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

            $item_details = $real_obj_booking_slots->where('id', $request->item_id)->get()->first();

            if(!empty($item_details)){

                if($item_details->is_master_clone == 'Y'){

                    // Is Master Cloned
                    // ...

                    // return 'is master cloned';

                    $item_details->is_deleted = 'Y';

                    $item_details->save();

                } else if($item_details->is_master_clone == 'N'){

                    // Is Localy Added

                    // return 'is local slot';

                    $item_details->delete();

                } // if($item_details->is_master_clone == 'Y')

            } // if(!empty($item_details))

        } // if(!empty($request->is_master_slot) && $request->is_master_slot == '1')

        Session::flash('success','Slot successfully removed.');  
        return response()->success('Slot successfully removed.');

    } // End => public function

    public function day_off_process(){

        // $pharmacy_menus = CommonEloHelper::get_table_result_where_arr('kod_menus', array(), array('display_order' => 'ASC'));
        // CommonCustomHelper::print_this_arr($pharmacy_menus); return '';
        return response()->json(['foo' => 'bar']);

    } // End => public function

    // Start => public function allowed_quantity(Request $request)
    public function allowed_quantity(Request $request){

        /*
        item_id: "31"
        value: "2"
        */

        // return $request;

        $table = 'mc_booking_slots';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

        $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

        $item_details->allowed_bookings = $request->value;

        $item_details->save();

        Session::flash('success','Slot allowed bookings successfully updated.');  
        return response()->success('Slot allowed bookings successfully updated.');

    } // End => public function allowed_quantity(Request $request)

    // Start => public function date_allowed_quantity(Request $request)
    public function date_allowed_quantity(Request $request){

        /*
        is_master_slot: "1"
        item_id: "15"
        slot_date: "2021-07-02"
        value: "3"
        */

        // return $request;

        if(!empty($request->is_master_slot) && $request->is_master_slot == '1'){

            // Master slot

            // Get master slot row from mc_booking_slots
            $table = 'mc_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

            $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

            if(!empty($item_details)){

                // Verify is already made the copy

                // Make a local copy from master for the requested time slot row by item_id
                $table = 'mc_booking_slots_local';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_exist = $common_obj->set_config($table, $fillable);

                $already_exist_in_local = $real_obj_exist->where('slot_date', $request->slot_date)->where('slot_start_time', $item_details->slot_start_time)->get()->first();

                // Make a local copy from master for the requested time slot row by item_id
                $table = 'mc_booking_slots_local';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_booking_slots_local = $common_obj->set_config($table, $fillable);

                if(!empty($already_exist_in_local)){

                    // Update Existing

                    $already_exist_in_local->allowed_bookings = $request->value;
                    $already_exist_in_local->save();

                } else {

                    // Create New

                    $real_obj_booking_slots_local->is_master_clone = 'Y';

                    $real_obj_booking_slots_local->slot_date = $request->slot_date;
                    $real_obj_booking_slots_local->slot_start_time = $item_details->slot_start_time;
                    $real_obj_booking_slots_local->allowed_bookings = $request->value;
                    $real_obj_booking_slots_local->slot_status = $item_details->slot_status;

                    $real_obj_booking_slots_local->save();

                } // if(!empty($already_exist_in_local))

            } // if(!empty($item_details))

        } else {

            // Local slot

            $table = 'mc_booking_slots_local';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

            $item_details = $real_obj_booking_slots->findOrFail($request->item_id);

            $item_details->allowed_bookings = $request->value;

            $item_details->save();

        } // if(!empty($request->is_master_slot) && $request->is_master_slot == '1')

        Session::flash('success','Slot allowed bookings successfully updated.');  
        return response()->success('Slot allowed bookings successfully updated.');

    } // End => public function date_allowed_quantity(Request $request)

    //////////// Weekly Functions //////////

    // Start => public function weekly()
    public function weekly(){

        return view(

                'backend.admin.booking_slots.weekly',

                [

                    'foo' => 'bar'

                ]

            );

    } // End => public function weekly()

    // Start => public function next_prev_weekly()
    public function next_prev_weekly(Request $request){
        
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

        ////////// Get week off days by each week day //////////
        $week_off_days = array();
        foreach($week_list as $week_day){

            $day_number = date('N', strtotime($week_day));

            $table = 'mc_booking_slots_off_days';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_week_off_days = $common_obj->set_config($table, $fillable);

            $week_off_days[$week_day] = $real_obj_week_off_days->where('slot_day_number', $day_number)->first();

            if(!empty($week_off_days[$week_day])){
                $week_off_days[$week_day] = $week_off_days[$week_day]->toArray();
            } // if(!empty($week_off_days[$week_day]))
            
        } // foreach($week_list as $week_day)

        ////////// Get week off dates by each week day //////////
        $week_off_dates = array();
        foreach($week_list as $week_day){

            // $day_number = date('N', strtotime($week_day));

            $table = 'mc_booking_slots_off_dates';
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

            $table = 'mc_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_week_day_slots = $common_obj->set_config($table, $fillable);

            $week_day_available_slots[$week_day] = $real_obj_week_day_slots->where('slot_day_number', $day_number)->get()->toArray();
            
        } // foreach($week_list as $week_day)

        $data['week_off_days'] = $week_off_days;
        $data['week_off_dates'] = $week_off_dates;

        $data['week_day_available_slots'] = $week_day_available_slots;

        /*
        echo '<pre>';
        print_r($week_day_available_slots);
        exit;
        */

        // Week day numbers array
        $week_day_numbers = array('1', '2', '3', '4', '5', '6', '7');

        ////////////// Get all week slots On/Off status by days //////////////

        $week_day_on_off_status = array();
        foreach($week_day_numbers as $day_number){

            $table = 'mc_booking_slots_off_days';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots_off_days = $common_obj->set_config($table, $fillable);

            $week_day_on_off_status[$day_number] = $real_obj_service_booking_slots_off_days->where('slot_day_number', $day_number)->get()->toArray();

        } // foreach($week_day_numbers as $day_number)

        ////////////// Get all week slots by days //////////////
        
        $week_day_slots = array();
        $week_day_slots_arr_column = array();
        foreach($week_day_numbers as $day_number){

            $table = 'mc_booking_slots';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots = $common_obj->set_config($table, $fillable);

            $week_day_slots[$day_number] = $real_obj_service_booking_slots->where('slot_day_number', $day_number)->get()->toArray();

            // Get array column arr of time slots in Master            
            if(!empty($week_day_slots[$day_number])){

                $week_day_slots_arr_column[$day_number] = array_column($week_day_slots[$day_number], 'slot_start_time');

            } else {

                $week_day_slots_arr_column[$day_number] = array();

            } // if(!empty($week_day_slots[$day_number]))

        } // foreach($week_day_numbers as $day_number)

        //////////// Get week date slots ///////////

        $week_date_slots = array();
        $week_date_slots_arr_column = array();
        foreach($week_list as $week_day){

            $table = 'mc_booking_slots_local';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $real_obj_service_booking_slots = $common_obj->set_config($table, $fillable);

            $week_date_slots[$week_day] = $real_obj_service_booking_slots->where('slot_date', $week_day)->get()->toArray();

            // Get array column arr of time slots in Local
            if(!empty($week_date_slots[$week_day])){

                $week_date_slots_arr_column[$week_day] = array_column($week_date_slots[$week_day], 'slot_start_time');

            } else {

                $week_date_slots_arr_column[$week_day] = array();

            } // if(!empty($week_date_slots[$week_day]))

        } // foreach($week_list as $week_day)

        // return $week_date_slots_arr_column;

        // echo '<pre>'; print_r($week_date_slots_arr_column); return '';

        return view(

                'backend.admin.booking_slots.next_prev_weekly', [

                    'data_arr' => $data,
                    'week_day_on_off_status' => $week_day_on_off_status,
                    'week_day_slots' => $week_day_slots,
                    'week_date_slots' => $week_date_slots,

                    'week_day_slots_arr_column' => $week_day_slots_arr_column,
                    'week_date_slots_arr_column' => $week_date_slots_arr_column

                ]


            );

    } // End => public function next_prev_weekly()

    // Start => public function date_on_off(Request $request)
    public function date_on_off(Request $request){

        /*
        day_is_off: "Y"
        off_date: "2021-06-30"
        */

        // return $request;

        $table = 'mc_booking_slots_off_dates';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $elo_obj = $common_obj->set_config($table, $fillable);

        $elo_obj->where('off_date', $request->off_date)->delete();
        
        if($request->day_is_off == 'Y'){

            $elo_obj->off_date = $request->off_date;
            
            $elo_obj->save();

            // Delete from forcely on

            $table = 'mc_booking_slots_on_dates';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $elo_obj = $common_obj->set_config($table, $fillable);

            $elo_obj->where('on_date', $request->off_date)->delete();

        } else {

            $table = 'mc_booking_slots_on_dates';
            $fillable =  Schema::getColumnListing($table);
            $common_obj = new CommonModel();
            $elo_obj = $common_obj->set_config($table, $fillable);

            $elo_obj->on_date = $request->off_date;
            
            $elo_obj->save();

        } // if($request->day_is_off == 'Y')

        Session::flash('success','Date on/off status successfully updated.');  
        return response()->success('Date on/off status successfully updated.');

    } // End => public function date_on_off(Request $request)

    // Start => public function date_add_slots_process(Request $request)
    public function date_add_slots_process(Request $request){

        /*
        slot_date: "2021-06-30"
        start_time: "1:04 PM"
        end_time: "1:04 PM"
        time_interval: "5"
        */

        // return $request;

        $start_time = date('H:i:s', strtotime($request->start_time));
        $end_time = date('H:i:s', strtotime($request->end_time));
        $interval = $request->time_interval;

        $new_slots_arr = $this->generate_time_slot($start_time, $end_time, $interval);

        if( count($new_slots_arr) > 1 ){

            $last_index = count($new_slots_arr) - 1;
            unset( $new_slots_arr[$last_index] );

        } // if( count($new_slots_arr) > 1 )

        if( !empty($new_slots_arr) ){
            foreach($new_slots_arr as $slot){

                $table = 'mc_booking_slots_local';
                $fillable =  Schema::getColumnListing($table);
                $common_obj = new CommonModel();
                $real_obj_booking_slots = $common_obj->set_config($table, $fillable);

                $real_obj_booking_slots->slot_date = $request->slot_date;
                $real_obj_booking_slots->slot_start_time = $slot;
                $real_obj_booking_slots->allowed_bookings = '1';
                $real_obj_booking_slots->slot_status = 'ACTIVE';

                $real_obj_booking_slots->save();

            } // foreach($new_slots_arr as $slot)
        } // if( !empty($new_slots_arr) )

        Session::flash('success','Slots successfully updated.');  
        return response()->success('Slots successfully updated.');
        
    } // End => public function date_add_slots_process(Request $request)

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

}
