<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Models\Order;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

  
}
