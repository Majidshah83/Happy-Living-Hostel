<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PharmacyProfileRequest;
use App\Models\PharmacyInfo;
use App\Models\PharmacySettings;
use App\Models\PharmacyOpeningHour;
use Storage;
use Session;
class PharmacyInfoController extends Controller
{

    public function index(){

        $pharmacyInfo          = PharmacyInfo::first();
        $pharmacy_settings     = PharmacySettings::first();
        $pharmacy_opening_hour = PharmacyOpeningHour::first();
        return view('backend.admin.pharmacyinfo.index')
                ->with('pharmacy_info',$pharmacyInfo)
                ->with('pharmacy_settings',$pharmacy_settings)
                ->with('pharmacy_opening_hour',$pharmacy_opening_hour);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(PharmacyProfileRequest $request)
    {

        $selected_tab = $request->selected_tab; 
        if($selected_tab == "pharmacy_settings" || $selected_tab == "upload_media"){
             $profile_update = PharmacySettings::storeData($request);            
        }else if($selected_tab == "opening_hours"){
             $profile_update = PharmacyOpeningHour::storeData($request);
        }else{
             $profile_update = PharmacyInfo::storeData($request);            
        }
        if($profile_update){
            Session::flash('selected_tab',$selected_tab); 
            return redirect()->back()->with('success', 'Record updated successfully.');
        }else{
            Session::flash('selected_tab',$selected_tab); 
            return redirect()->back()->with('error', 'Record not updated successfully.');
        }

    }

}
