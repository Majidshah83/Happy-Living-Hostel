<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FaqCategoryRequest;
use App\Models\FaqCategory;
use Session;
use Storage;


class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqcategory = FaqCategory::orderBy('id', 'DESC')->get();
        return view('backend.admin.faqcategory.index')->with('FaqCategory',$faqcategory);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.faqcategory.add_edit_form')->render();
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

        $faq_category_details = FaqCategory::where('hash_id', $hash_id)->first();
        return view('backend.admin.faqcategory.add_edit_form')->with('faq_category_details', $faq_category_details)->render();

    }

    /**
     * @Description
     * Store a newly created banner in banners table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FaqCategoryRequest $request)
    {

        $stored = FaqCategory::storeData($request);
        if($stored){
        
            Session::flash('success','Faq Category added successfully');  
            return response()->success('Faq Category updated successfully!');
            
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

    public function update(FaqCategoryRequest $request, $hash_id)
    {
       
        $updated = FaqCategory::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Faq category updated successfully'); 
            return response()->success('Faq Category updated successfully!');

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
        $deleted = FaqCategory::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Faq Category deleted successfully'); 
            return response()->success('Faq Category deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

}
