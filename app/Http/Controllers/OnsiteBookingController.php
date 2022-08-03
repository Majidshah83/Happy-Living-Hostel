<?php

namespace App\Http\Controllers;

use App\Models\OnsiteBooking;
use Illuminate\Http\Request;

use CommonEloHelper;

class OnsiteBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $onsite_bookings = OnsiteBooking::orderBy('id', 'DESC')->get();
        return view('backend.admin.onsite_bookings.index')->with('onsite_bookings',$onsite_bookings);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Start => public function get_cdt(Request $request)
    public function get_cdt(Request $request){

        $post_arr = $request->all();

        // $request->merge(['include' => array('category') ]);

        $list_all = CommonEloHelper::get_table_result_with_request(OnsiteBooking::class, array(), array('id' => 'DESC'), $request);
        // onsite_bookings

        return view('backend.admin.onsite_bookings.cdt', ['post_arr' => $post_arr, 'list_all' => $list_all]);

    }// End => public function get_cdt(Request $request)

}
