<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EmailTemplateRequest;
use App\Models\EmailTemplate;
use Session;
use Storage;
class EmailTemplateController extends Controller
{

    /**
     * @Description
     * Display a listing of the all banners.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        $email_template = EmailTemplate::orderBy('id', 'DESC')->get();
        return view('backend.admin.emailtemplate.index')->with('email_template',$email_template);

    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.emailtemplate.add_edit_form')->render();
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
     * @Description
     * Store data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(EmailTemplateRequest $request)
    {

        $store_banner = EmailTemplate::storeData($request);
        if($store_banner){
            
            Session::flash('success','Email tempalte added successfully');  
            return response()->success('Email tempalte added successfully!');

        }else{

            Session::flash('success','Email tempalte not added successfully.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($hash_id)
    {

        $email_template_details = EmailTemplate::where('hash_id', $hash_id)->first();
        return view('backend.admin.emailtemplate.add_edit_form')->with('email_template_details', $email_template_details)->render();

    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(EmailTemplateRequest $request, $hash_id)
    {

        $updated = EmailTemplate::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Email template updated successfully'); 
            return response()->success('Email template updated successfully!');

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

        $deleted = EmailTemplate::deleteData($hash_id);
        if(!empty($deleted)){
            Session::flash('success','Email template deleted successfully'); 
            return response()->success('Email template deleted successfully!');
        } else {
            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');
        }

    }


     /******************************************/
    /******** Start => Custom Functions *******/


    public function updateStatus(Request $request){
       
        $updateStatus = EmailTemplate::where('hash_id',$request->hash_id)->update(['status' => $request->status]);
        if($updateStatus){
            Session::flash('success','Status updated successfully'); 
            return "succces";
        }else{
            Session::flash('error','Status not updated successfully'); 
            return "error";
        }

    }

    /******** End => Custom Functions *******/
    /****************************************/
   
}
