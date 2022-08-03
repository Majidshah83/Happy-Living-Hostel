<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PageSectionRequest;
use App\Models\PageSection;
use Session;
use Storage;


class PageSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pageSection = PageSection::orderBy('id', 'DESC')->get();
        return view('backend.admin.pagesection.index')->with('PageSections',$pageSection);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       return view('backend.admin.pagesection.add_edit_form')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageSectionRequest $request)
    {
        //

        $stored = PageSection::storeData($request);
        if($stored){
        
            Session::flash('success','Page Section added successfully');  
            return response()->success('Page Section updated successfully!');
      
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

        $page_section_details = PageSection::where('hash_id', $hash_id)->first();
        if(!empty($page_section_details)){
           return view('backend.admin.pagesection.add_edit_form')->with('page_section_details', $page_section_details)->render();
        }
        return response()->failed('Oops! Somethings went wrong, please try again later.');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageSectionRequest $request, $hash_id)
    {
        //

        $updated = PageSection::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Page section updated successfully'); 
            return response()->success('Page section updated successfully!');
            
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
    public function destroy($id)
    {
        //
    }


     /******************************************/
    /******** Start => Custom Functions *******/


    public function updateStatus(Request $request){
       
        $updateStatus = PageSection::where('hash_id',$request->hash_id)->update(['status' => $request->status]);
        if($updateStatus){
            Session::flash('success','Status updated successfully'); 
            return response()->success('Page section updated successfully!');
        }else{
            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');
        }

    }

  

    /******** End => Custom Functions *******/
    /****************************************/
}
