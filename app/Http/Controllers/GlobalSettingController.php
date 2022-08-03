<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalSetting;
use App\Http\Requests\GlobalSettingRequest;
use Storage;
use Session;
class GlobalSettingController extends Controller
{

    /**
     * @Description
     * Display a listing of the all banners.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $GlobalSetting = GlobalSetting::orderBy('id', 'DESC')->get();
        return view('backend.admin.globalsettings.INDEX')->with('global_settings',$GlobalSetting);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.globalsettings.add_edit_form')->render();
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

        $global_settings_details = GlobalSetting::where('hash_id', $hash_id)->first();
        return view('backend.admin.globalsettings.add_edit_form')->with('global_settings_details', $global_settings_details)->render();

    }



    /**
     * @Description
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(GlobalSettingRequest $request)
    {

        $stored = GlobalSetting::storeData($request);
        if($stored){
       
            Session::flash('success','Global Setting added successfully');  
            return response()->success('Global Setting updated successfully!');
       
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

    public function update(GlobalSettingRequest $request, $hash_id)
    {
      
        if($request->setting_key != $request->setting_key_old){
            if (GlobalSetting::where('setting_key', '=',$request->setting_key)->exists()) {
               return response()->failed('This key is already exists, key must be unique.');
            }
        }
        $updated = GlobalSetting::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Global Setting updated successfully'); 
            return response()->success('Global Setting updated successfully!');

        } else {
            
            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

   

}
