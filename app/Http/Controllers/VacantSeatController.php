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
        $total_student  = Student::where('status',1)->get()->count();

        $rooms= $total_seats = Room::get();

        return view('backend.admin.vacant_seats.index',compact('total_student','rooms'));
    }
}