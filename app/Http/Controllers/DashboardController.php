<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Orders;
use App\Models\Expense;
use App\Models\Room;
use App\Models\Service;
use App\Models\Student;
use App\Models\Fee;
use App\Models\TravelDetails;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

use Illuminate\Http\Request;
use Session;

use Illuminate\Support\Facades\Schema;
use App\Models\CommonModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getAllOrdersPage() {

        // $services = Service::orderBy('id', 'DESC')->get();
        // $today = Carbon::today();
        // $tom = Carbon::today();
        // $to = Carbon::today();
        // $tom =  $tom->addDay()->format('Y/m/d');
        // if($today->dayOfWeek == Carbon::FRIDAY)
        //     $to = $to->addDays(2);

        // $from = $today->format('Y/m/d');
        // $to = $to->format('Y/m/d');
        // $todays_travel_details= TravelDetails::whereBetween('arrival_date', [$from, $to])->get();
        // $count_tom = TravelDetails::where('arrival_date', $tom)->count();
        // $data = [
        //     'today_count' => $todays_travel_details->count(),
        //     'tom_count' => $count_tom,
        // ];

        return view('backend.admin.dashboard_new');

    }
    public function getAllOrders(Request $request) {

        $limit = 50;

        if($request->has('cdt_per_page') &&  !empty($request->cdt_per_page)){
            $limit = $request->get('cdt_per_page');
            $limit = $limit ? (int) $limit : 50 ;
        }
        $search = '';
        if($request->has('cdt_search') &&  !empty($request->cdt_search)){
            $search = $request->cdt_search;
        }

        $today = Carbon::today();
        $tom = Carbon::today();
        $to = Carbon::today();
        $tom =  $tom->addDay()->format('Y/m/d');
        if($today->dayOfWeek == Carbon::FRIDAY)
            $to = $to->addDays(2);

        $from = $today->format('Y/m/d');
        $to = $to->format('Y/m/d');
        $to_tom = Carbon::today()->addDay()->format('Y/m/d');
//        $todays_travel_details= TravelDetails::whereBetween('arrival_date', [$from, $to_tom])->get();
//        $count_tom = TravelDetails::where('arrival_date', $tom)->count();
        $services = Service::orderBy('id', 'DESC')->get();
        $date =  false;
        $service =  false;
        $status = false;
        $all = false;
        $service_id = '';
        $fil_status = '';
        $fil_date = '';
        if ($request->has('package_id') && !empty($request->package_id)){
            $service = true;
            $service_id = Service::where('id', $request->package_id)->first()->id;
        }

        if ($request->has('today') && $request->today && $request->today == '1') {
            $date = true;
            $fil_date = $today->format('Y/m/d');
            $date = 'not';
        }

        if ($request->has('tom') && $request->tom && $request->tom == '1') {
            $date = true;
            $fil_date = $tom;
            $to = $tom;
            $date = 'not';
        }

        if ($request->has('order_status') && !empty($request->order_status) && $request->order_status != 'All'){
            $status = true;
            $fil_status = $request->order_status;
            if ($date) {
                $date = 'not';
            } else {
                $date = 'false';
            }
        }

        if ($request->has('order_status') && !empty($request->order_status) && $request->order_status == 'All') {
            $all = true;
            $fil_status = $request->order_status;
            if ($date) {
                $date = 'not';
            } else {
                $date = 'false';
            }
        }
//        return $fil_date."|".$to."|".$from;
        $recent_orders = DB::table('kod_orders')->select('kod_orders.email2_sent_status','kod_orders.email2_sent_datetime','kod_orders.email2_sent_template_id','kod_orders.id as order_plain_id','kod_passengers.nhs_no as passengers_nhs_no','kod_orders.hash_id as order_hash_id','kod_orders.invoice_no as order_invoice_no','kod_orders.plfcode as order_plfcode','kod_orders.status as order_status','kod_orders.day_2_barcode as order_day_2_barcode','kod_orders.day_2_pin as order_day_2_pin','kod_orders.day_8_barcode as order_day_8_barcode','kod_orders.day_8_pin as order_day_8_pin','kod_orders.created_at as order_created_at','kod_passengers.first_name as passengers_first_name','kod_passengers.surname as passengers_surname','kod_passengers.email as passengers_email','kod_passengers.dob as passengers_dob','kod_passengers.gender as passengers_gender','kod_passengers.ethnicity as passengers_ethnicity','kod_passengers.vaccination_status as passengers_vaccination_status','kod_passengers.passport_no as passengers_passport_no','kod_passengers.phone_no as passengers_phone_no','kod_passenger_addresses.uk_address as passenger_addresses_uk_address','kod_passenger_addresses.uk_postcode as passenger_addresses_uk_postcode','kod_passenger_addresses.uk_city as passenger_addresses_uk_city','kod_travel_details.arrival_date as travel_details_arrival_date','kod_travel_details.date_of_departure as travel_details_date_of_departure','kod_travel_details.city_travelled_from as travel_details_city_travelled_from','kod_travel_details.type_of_transport as travel_details_type_of_transport','kod_travel_details.coach_no as travel_details_coach_no','kod_countries.title as countries_title','kod_services.title as services_title')
            ->join("kod_passengers",function($join) use ($search){
                $join->on("kod_passengers.id","=","kod_orders.passenger_id");
                if (!empty($search)) {
                    $join->where ( 'kod_passengers.email', 'LIKE', '%' . $search . '%' );
                }
            })
            ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
            ->join("kod_travel_details",function($join) use ($search){
                $join->on("kod_travel_details.passenger_id","=","kod_passengers.id");
//                if (!empty($search)) {
//                    $join->where ( 'kod_travel_details.arrival_date', 'LIKE', '%' . $search . '%' )
//                        ->orWhere(function ($query) use ($search) {
//                            $query->where ( 'kod_travel_details.city_travelled_from', 'LIKE', '%' . $search . '%' );
//                        });
//                }

            })->when(($date == true && $date != 'false'),
                function($q) use ($fil_date, $to){
                    return $q->whereBetween('kod_travel_details.arrival_date', [$fil_date, $to]);
                })->when(($date == '' && $date != 'false'),
                function($q) use ($from, $to){
                    return $q->whereBetween('kod_travel_details.arrival_date', [$from, $to]);
                })
            ->join("kod_services",function($join){
                $join->on("kod_services.id","=","kod_orders.service_id");
            })->when($service == true,
                function($q) use ($service_id){
                    return $q->where('kod_services.id', '=', $service_id);
                })
            ->join('kod_countries','kod_countries.id','=','kod_travel_details.country_id')
            ->when(($status == true && $all == false), function($query) use ($fil_status){
                return $query->where('kod_orders.status', '=', $fil_status);
            })
            ->when(($status == false && $all == false), function($query) use ($fil_status){
                $query->where('kod_orders.status', '!=', 'C');
                $query->where('kod_orders.status', '!=', 'R');
                return $query;
            })
            ->when(($status == false && $all == true), function($query) use ($fil_status){
                return $query->whereIn('kod_orders.status', ['C','R','P','K','O','D']);
            })
            ->orderBy('kod_orders.id', 'DESC')
            ->paginate($limit);

        $for_tom_count = DB::table('kod_orders')->select('*')
            ->join('kod_passengers', 'kod_passengers.id', '=', 'kod_orders.passenger_id')
            ->join("kod_travel_details", function ($join) use ($to_tom) {
                $join->on("kod_travel_details.passenger_id", "=", "kod_passengers.id");
                $join->where('kod_travel_details.arrival_date', '=', $to_tom);
            })->get();
        $for_tod_count = DB::table('kod_orders')->select('*')
            ->join('kod_passengers', 'kod_passengers.id', '=', 'kod_orders.passenger_id')
            ->join("kod_travel_details", function ($join) use ($to_tom) {
                $join->on("kod_travel_details.passenger_id", "=", "kod_passengers.id");
                $join->where('kod_travel_details.arrival_date', '=', Carbon::today()->format('Y/m/d'));
            })->get();
//        return $for_tom_count->count();
//        $data['today_count'] = 0;
//        $data['tom_count'] = 0;
        $data = [
            'today_count' => $for_tod_count->count(),
            'tom_count' => $for_tom_count->count(),
            'service_id' => $service_id,
            'tom' => $request->has('tom') ? $request->tom : '',
            'tod' => $request->has('today') ? $request->today : '',
            'sel_order_status' => $fil_status
        ];

        foreach ($recent_orders as $key => $order) {
            if(!empty($order->travel_details_arrival_date)){
                $today_s = date('Y-m-d');
                $tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
                $arrival_date = date('Y-m-d', strtotime($order->travel_details_arrival_date));
//                if (strtotime($arrival_date) == strtotime($today_s)) {
//                    $data['today_count'] = $data['today_count'] + 1;
//                }
//                if (strtotime($arrival_date) == strtotime($tomorrow)) {
//                    $data['tom_count'] = $data['tom_count'] + 1;
//                }
            }
        }

//         return $data;
//        return response()->json($data);
        $json_data = view('backend.admin.cdt_dash', ['post_arr' => $request->all(), 'list_all' => $recent_orders, 'services' => $services])->render();
        return response()->json(['html_data' => $json_data, 'data' => $data]);


    }

    public function index() {

         $student = Student::whereMonth('created_at', Carbon::now()->month)->count();
         $expense = Expense::whereMonth('created_at', Carbon::now()->month)->get()->sum('total_amount');
         $rooms = Room::count();
         //Total seats
         $total_seats = Room::get()->sum('capacity');
         //total student
         $total_vacant_seats  = Student::where('status',1)->get()->count();
        //  dd('capity sum',$total_seats,'totalstudent',$total_vacant_seats);
        $total_collection_amount  = Student::whereMonth('created_at', Carbon::now()->month)->where('status',1)->get()->sum('monthely_fee');
        $floors_count        = Floor::count();
        $users = User::where('id', Auth::user()->id)->count();
        $floors = Floor::with('rooms')->get();
        $month  = date('m');
        $fee_collected = Fee::where('month_fee',$month)->get()->sum('hostel_fee');

        return view('backend.admin.dashboard_new',['total_collection_amount' => $total_collection_amount,'fee_collected' =>$fee_collected])
            ->with('floors_count', $floors_count)
            ->with('floors', $floors)
            ->with('users', $users)
            ->with('rooms', $rooms)
            ->with('student', $student)
            ->with('total_seats',$total_seats)
            ->with('expense',$expense)
            ->with('total_vacant_seats',$total_vacant_seats);

    }

    public function filterOrders(Request $request) {
        $today = Carbon::today();
        $tom = Carbon::today();
        $to = Carbon::today();
        $tom =  $tom->addDay()->format('Y/m/d');
        if($today->dayOfWeek == Carbon::FRIDAY)
            $to = $to->addDays(2);

        $from = $today->format('Y/m/d');
        $to = $to->format('Y/m/d');
        $todays_travel_details= TravelDetails::whereBetween('arrival_date', [$from, $to])->get();
        $count_tom = TravelDetails::where('arrival_date', $tom)->count();
        $services = Service::orderBy('id', 'DESC')->get();
        $date =  false;
        $service =  false;
        $status = false;
        $all = false;
        $service_id = '';
        $fil_status = '';
        $fil_date = '';
        if ($request->package_id){
            $service = true;
            $service_id = Service::where('id', $request->package_id)->first()->id;
        }

        if ($request->today && $request->today == '1') {
            $date = true;
            $fil_date = $today->format('Y/m/d');
        }

        if ($request->tom && $request->tom == '1') {
            $date = true;
            $fil_date = $tom;
            $to = $tom;
        }

        if ($request->order_status && $request->order_status != 'All'){
            $status = true;
            $fil_status = $request->order_status;
        }

        if ($request->order_status == 'All') {
            $all = true;
            $fil_status = $request->order_status;

        }
//        return $fil_date."|".$to;
        $recent_orders = DB::table('kod_orders')->select('kod_orders.id as order_plain_id','kod_passengers.nhs_no as passengers_nhs_no','kod_orders.hash_id as order_hash_id','kod_orders.invoice_no as order_invoice_no','kod_orders.plfcode as order_plfcode','kod_orders.status as order_status','kod_orders.day_2_barcode as order_day_2_barcode','kod_orders.day_2_pin as order_day_2_pin','kod_orders.day_8_barcode as order_day_8_barcode','kod_orders.day_8_pin as order_day_8_pin','kod_orders.created_at as order_created_at','kod_passengers.first_name as passengers_first_name','kod_passengers.surname as passengers_surname','kod_passengers.email as passengers_email','kod_passengers.dob as passengers_dob','kod_passengers.gender as passengers_gender','kod_passengers.ethnicity as passengers_ethnicity','kod_passengers.vaccination_status as passengers_vaccination_status','kod_passengers.passport_no as passengers_passport_no','kod_passengers.phone_no as passengers_phone_no','kod_passenger_addresses.uk_address as passenger_addresses_uk_address','kod_passenger_addresses.uk_postcode as passenger_addresses_uk_postcode','kod_passenger_addresses.uk_city as passenger_addresses_uk_city','kod_travel_details.arrival_date as travel_details_arrival_date','kod_travel_details.date_of_departure as travel_details_date_of_departure','kod_travel_details.city_travelled_from as travel_details_city_travelled_from','kod_travel_details.type_of_transport as travel_details_type_of_transport','kod_travel_details.coach_no as travel_details_coach_no','kod_countries.title as countries_title','kod_services.title as services_title')
            ->join('kod_passengers','kod_passengers.id','=','kod_orders.passenger_id')
            ->join('kod_passenger_addresses','kod_passenger_addresses.passenger_id','=','kod_passengers.id')
            ->join("kod_travel_details",function($join){
                $join->on("kod_travel_details.passenger_id","=","kod_passengers.id");
            })->when($date == true,
                function($q) use ($fil_date, $to){
                    return $q->whereBetween('kod_travel_details.arrival_date', [$fil_date, $to]);
                })
            ->join("kod_services",function($join){
                $join->on("kod_services.id","=","kod_orders.service_id");
            })->when($service == true,
                function($q) use ($service_id){
                    return $q->where('kod_services.id', '=', $service_id);
                })
            ->join('kod_countries','kod_countries.id','=','kod_travel_details.country_id')
            ->when(($status == true && $all == false), function($query) use ($fil_status){
                return $query->where('kod_orders.status', '=', $fil_status);
            })
            ->when(($status == false && $all == false), function($query) use ($fil_status){
                 $query->where('kod_orders.status', '!=', 'C');
                 $query->where('kod_orders.status', '!=', 'R');
                 return $query;
            })
            ->when($all == true, function($query) use ($fil_status){
                return $query->whereIn('kod_orders.status', ['C','R','P','K','O','D']);
            })
            ->orderBy('kod_orders.id', 'DESC')
            ->get();
            $data = [
                'today_count' => $todays_travel_details->count(),
                'tom_count' => $count_tom,
                'service_id' => $service_id,
                'tom' => $request->tom,
                'tod' => $request->today,
                'sel_order_status' => $fil_status
            ];
            $data['today_count'] = 0;
            $data['tom_count'] = 0;
            foreach ($recent_orders as $key => $order) {
                if(!empty($order->travel_details_arrival_date)){
                    $today_s = date('Y-m-d');
                    $tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));
                    $arrival_date = date('Y-m-d', strtotime($order->travel_details_arrival_date));
                    if (strtotime($arrival_date) == strtotime($today_s)) {
                        $data['today_count'] = $data['today_count'] + 1;
                    }
                    if (strtotime($arrival_date) == strtotime($tomorrow)) {
                        $data['tom_count'] = $data['tom_count'] + 1;
                    }
                }
            }
            return view('backend.admin.dashboard')
                ->with('data', $data)
                ->with('services', $services)
                ->with('recent_orders', $recent_orders);

    }

    public function index_old() {
        $today = Carbon::today();
        $tom = Carbon::today();
        $tom =  $tom->addDay()->format('Y/m/d');
        $todays_travel_details= TravelDetails::where('arrival_date', $today->format('Y/m/d'))->get();
        $count_tom = TravelDetails::where('arrival_date', $tom)->count();
        $services = Service::orderBy('id', 'DESC')->get();
        $recent_orders = Orders::where('status', '!=', 'C')
                            ->where('status', '!=', 'R')
                            ->orderBy('id', 'DESC')
                            ->latest()
                            ->get();
        $data = [
            'today_count' => $todays_travel_details->count(),
            'tom_count' => $count_tom,
        ];
        return view('backend.admin.dashboard')
                            ->with('data', $data)
                            ->with('services', $services)
                            ->with('recent_orders', $recent_orders);
    }










    public function indexOld()
    {
    	$user_auth = Auth::user()->first()->toArray();

        // echo '<pre>'; print_r($return); return '';

        $table = 'mc_service_bookings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_week_off_days = $common_obj->set_config($table, $fillable);

        if(!$real_obj_week_off_days) return 'Common model config not set.';

        $service_bookings = array();
        $service_bookings = $real_obj_week_off_days->where('booking_status', 'PENDING')->orderBy('id', 'desc')->get();

        return view('dashboard.index', ['user_auth' => $user_auth, 'service_bookings' => $service_bookings, 'status' => 'PENDING']);
    }

    public function filtered_bookings($status=false){

        // return $this->global_param;

        $user_auth = Auth::user()->first()->toArray();

        // echo '<pre>'; print_r($return); return '';

        $table = 'mc_service_bookings';
        $fillable =  Schema::getColumnListing($table);
        $common_obj = new CommonModel();
        $real_obj_week_off_days = $common_obj->set_config($table, $fillable);

        if(!$real_obj_week_off_days) return 'Common model config not set.';

        $service_bookings = array();
        $service_bookings = $real_obj_week_off_days->where('booking_status', $status)->orderBy('id', 'desc')->get();

        return view('dashboard.index', ['user_auth' => $user_auth, 'service_bookings' => $service_bookings, 'status' => $status]);

    } // End => public function index(Request $request)

}