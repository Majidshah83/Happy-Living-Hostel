<?php

namespace App\Http\Controllers;

use App\Http\Requests\FaqsRequest;
use App\Models\Faqs;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaqsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $faqs = Faqs::orderBy('display_order', 'ASC')->get();
        return view('backend.admin.faqs.index')
                    ->with('faqs',$faqs);
                    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $faq_category = FaqCategory::where('status',1)->get();
        return view('backend.admin.faqs.add_edit_form')->with('faq_category',$faq_category)->render();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FaqsRequest $request)
    {

        $stored = Faqs::storeData($request);

        if($stored){

            Session::flash('success','Faqs added successfully');
            return response()->success('Faqs added successfully!');
       
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
    public function edit($hash_id){

        $faq_details = Faqs::where('hash_id', $hash_id)->first();
        $faqs = Faqs::orderBy('display_order', 'ASC')->get();
        $faq_category = FaqCategory::where('status',1)->get();
       
        return view('backend.admin.faqs.add_edit_form')->with('faq_details', $faq_details)->with('faq_category',$faq_category)->render();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FaqsRequest $request, $hash_id)
    {

        $updated = Faqs::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Faq updated successfully');
            return response()->success('Faq updated successfully!');

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
        $deleted = Faqs::deleteData($hash_id);
        if(!empty($deleted)){

            Session::flash('success','Faq deleted successfully');
            return response()->success('Faq deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }


    /******************************************/
    /******** Start => Custom Functions *******/

    public function updateStatus(Request $request){

        $updateStatus = Faqs::where('hash_id',$request->hash_id)->update(['status' => $request->status]);
        if($updateStatus){
            Session::flash('success','Status updated successfully');
            return "succces";
        }else{
            Session::flash('error','Status not updated successfully');
            return "error";
        }

    }

    public function displayOrderUpdate(Request $request){

        $updateStatus = Faqs::where('hash_id', $request->hash_id)->update(['display_order' => $request->display_order]);

        if($updateStatus){

            Session::flash('success','Display order updated successfully');
            return response()->success('Display order updated successfully');

        } else {

            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');
        }
    }

    /******** End => Custom Functions *******/
    /****************************************/
}
