<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEditCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Session;
class CouponController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $coupons = Coupon::orderBy('id', 'DESC')->get();
        return view('backend.admin.coupons.index')->with('coupons', $coupons);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.coupons.add_edit_form')->render();
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

        $coupon_details = Coupon::where('hash_id', $hash_id)->first();
        return view('backend.admin.coupons.add_edit_form')->with('coupon_details', $coupon_details)->render();

    }



    public function store(AddEditCouponRequest $request){

        $stored = Coupon::storeData($request);
        if($stored){
        
            Session::flash('success','Coupon added successfully');  
            return response()->success('Coupon updated successfully!');
        }else{

            Session::flash('success','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }



     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(AddEditCouponRequest $request, $hash_id)
    {
      
        $updated = Coupon::updateData($request, $hash_id);
        if($updated){

            Session::flash('success',  'Coupon updated successfully'); 
            return response()->success('Coupon updated successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }


    /**
     * Delete the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($hash_id=false)
    {
      
        $deleted = Coupon::deleteData($hash_id);
        if(!empty($deleted)){

            Session::flash('success','Coupon deleted successfully'); 
            return response()->success('Coupon deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }


}
