<?php

namespace App\Http\Controllers;

use App\Http\Requests\PageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('id', 'DESC')->get();
        return view('backend.admin.pages.index')->with('pages',$pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.pages.add_edit_form')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $stored = Page::storeData($request);
        if($stored){

            Session::flash('success','Page added successfully');
            return response()->success('Page updated successfully!');

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
        $page_details = Page::where('hash_id', $hash_id)->first();
        return view('backend.admin.pages.add_edit_form')->with('page_details', $page_details)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PageRequest $request, $hash_id)
    {

        $getPage = Page::where('hash_id',$hash_id)->first();
        if($getPage->url_slug != $request->url_slug){
           $checkSlug = Page::where('url_slug',$request->url_slug)->exists();
           if($checkSlug){
              return response()->failed('Page slug must be unique.');
           }
        } 

        $updated = Page::updateData($request, $hash_id);
        if($updated){
            Session::flash('success','Page updated successfully');
            return response()->success('Page updated successfully!');
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
        $deleted = Page::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Page deleted successfully');
            return response()->success('Page deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }

    /******************************************/
    /******** Start => Custom Functions *******/

    public function updateStatus(Request $request){

        $updateStatus = Page::where('hash_id',$request->hash_id)->update(['status' => $request->status]);
        if($updateStatus){
            Session::flash('success','Status updated successfully');
            return "succces";
        }else{
            Session::flash('error','Status not updated successfully');
            return "error";
        }

    }
}
