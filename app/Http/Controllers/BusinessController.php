<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\BusinessType;
use Session;
use Storage;

class BusinessController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
         $business =  Business::with('Type')->get();
        return view('backend.admin.business.index')->with('business',$business);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $business_type =  BusinessType::where('status',1)->orderBy('display_order','ASC')->get();
        return view('backend.admin.business.add_edit_form')->with('business_type', $business_type)->render();
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

       $business_type =  BusinessType::where('status',1)->orderBy('display_order','ASC')->get();
        $business_details = Business::where('hash_id', $hash_id)->first();
        return view('backend.admin.business.add_edit_form')->with('business_details', $business_details)->with('business_type',$business_type)->render();

    }

    /**
     * @Description
     * Store a newly created banner in banners table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $stored = Business::storeData($request);
        if($stored){
        
            Session::flash('success','Business added successfully');  
            return response()->success('Business updated successfully!');
            
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

    public function update(Request $request, $hash_id)
    {

        $updated = Business::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Business updated successfully'); 
            return response()->success('Business updated successfully!');

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
        $deleted = Banner::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Banner deleted successfully'); 
            return response()->success('Banner deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }


    /******************************************/
    /******** Start => Custom Functions *******/


    public function updateStatus(Request $request){
       
        $updateStatus = Banner::where('hash_id',$request->hash_id)->update(['status' => $request->status]);
        if($updateStatus){
            Session::flash('success','Status updated successfully'); 
            return "succces";
        }else{
            Session::flash('error','Status not updated successfully'); 
            return "error";
        }

    }

    public function displayOrderUpdate(Request $request){

        $updateStatus = Banner::where('hash_id', $request->hash_id)->update(['display_order' => $request->display_order]);

        if($updateStatus){

            Session::flash('success','Display order updated successfully'); 
            return response()->success('Display order updated successfully');

        } else {

            Session::flash('success','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');
        }
    }

    public function testing(){
        dd('wajid');
    }
    

    /******** End => Custom Functions *******/
    /****************************************/
    
}
