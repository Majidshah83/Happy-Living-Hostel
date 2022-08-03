<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;

use App\Models\Service;
use App\Models\Countries;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ServiceController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $services = Service::orderBy('display_order', 'ASC')->get();
        return view('backend.admin.services.index')->with('services',$services);
    }

    public function get_service_countries($hash_id)
    {

        $service_details = Service::where('hash_id', $hash_id)->first();

        $countries = Countries::where('status', '1')->orderBy('title', 'ASC')->get();

        return view('backend.admin.services.service_countries', [

            'service_details' => $service_details,
            'countries' => $countries,
            
        ])->render();
    }

    public function update_service_countries(Request $request){

        /*
        
        "hash_id" : "wGD1Sk1626173047",

        "country_ids" : ["2","4","6","7"]

        */

        // return $request;

        $country_ids_str = !empty($request->country_ids) ? implode(',', $request->country_ids) : '' ;

        $service_details = Service::where('hash_id',$request->hash_id)->first();

        $service_details->country_ids = $country_ids_str;

        $service_details->save();

        Session::flash('success','Service country list successfully updated.');
        return redirect()->to(url('/services'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.services.add_edit_form')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ServiceRequest $request)
    {
        
        $slug = makeSlug($request->title);
        $checkSlug = Service::where('slug',$slug)->exists();
        if($checkSlug){
            return response()->failed('Title is already exists.');
        }
        $stored = Service::storeData($request);
        if($stored){

            Session::flash('success','Service added successfully');
            return response()->success('Service added successfully!');

        }else{

            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
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
    public function edit($hash_id)
    {
        $service_details = Service::where('hash_id', $hash_id)->first();
        return view('backend.admin.services.add_edit_form')->with('service_details', $service_details)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $hash_id)
    {

        $getPage = Service::where('hash_id',$hash_id)->first();
        if($getPage->slug != $request->slug){
           $checkSlug = Service::where('slug',$request->slug)->exists();
           if($checkSlug){
              return response()->failed('Service slug must be unique.');
           }
        } 

        $updated = Service::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Service updated successfully');
            return response()->success('Service updated successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($hash_id)
    {
        $deleted = Service::deleteData($hash_id);
        if(!empty($deleted)){

            Session::flash('success','Service deleted successfully');
            return response()->success('Service deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }
}
