<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DeliveryMethodRequest;
use App\Models\DeliveryMethods;
use App\Models\FreeDelivery;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Storage;

class DeliveryMethodController extends Controller
{

    /**
     * Profile listing
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index() {

        $delivery_methods = DeliveryMethods::orderBy('display_order','ASC')->get();
        $countries        = DB::table('kod_countries')->get();
        return view('backend.admin.deliverymethods.index')->with('delivery_methods',$delivery_methods)->with('countries',$countries);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

        $countries        = DB::table('kod_countries')->get();
        return view('backend.admin.deliverymethods.add_edit_form')->with('countries',$countries)->render();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($hash_id)
    {

        $delivery_method_details = DeliveryMethods::where('hash_id', $hash_id)->first();
        $countries        = DB::table('kod_countries')->get();
        return view('backend.admin.deliverymethods.add_edit_form')->with('delivery_method_details', $delivery_method_details)->with('countries',$countries)->render();

    }

    /**
     * @Description
     * Store a newly  Delivery methods.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(DeliveryMethodRequest $request)
    {

        $stored = DeliveryMethods::storeData($request);
        if($stored){
            Session::flash('success','Delivery Methods added successfully');
            return response()->success('Delivery Methods updated successfully!');
        }else{
            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');
        }

    }

    /*
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(DeliveryMethodRequest $request, $hash_id){

        $updated = DeliveryMethods::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Delivery methods updated successfully');
            return response()->success('Delivery methods updated successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }


}
