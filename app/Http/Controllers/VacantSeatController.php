<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Student;
class VacantSeatController extends Controller
{
    //
    public function index()
    {


         //Total seats
         $total_capicity = Room::get()->sum('capacity');
         //total student
         $total_vacant_seats  = Student::where('status',1)->get()->count();
         $rooms= Room::get();
        //  $total_vant=$total_capicity-$total_vacant_seats;
        // dd($total_vant);



return view('backend.admin.vacant_seats.index',compact('total_vacant_seats','rooms','total_capicity'
));
}
}
