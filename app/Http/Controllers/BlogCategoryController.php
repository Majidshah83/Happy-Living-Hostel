<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Session;
use Storage;

class BlogCategoryController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {

        $categories = BlogCategory::orderBy('display_order', 'ASC')->get();
        return view('backend.admin.category.index')->with('categories',$categories);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.category.add_edit_form')->render();
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

       $category_details = BlogCategory::where('hash_id', $hash_id)->first();
        return view('backend.admin.category.add_edit_form')->with('category_details', $category_details)->render();

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

        $stored = BlogCategory::storeData($request);
        if($stored){
        
            Session::flash('success','categories added successfully');  
            return response()->success('categories updated successfully!');
            
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

        $category = BlogCategory::where('hash_id',$hash_id)->first();
        if($category->image == null){
            $this->validate($request, [
                    'image'          => 'required','image','mimes:jpg,jpeg,png,bmp,tiff','max:5120',
                   ]);
        }
        $updated = BlogCategory::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Category updated successfully'); 
            return response()->success('Category updated successfully!');

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
        $deleted = BlogCategory::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Category deleted successfully'); 
            return response()->success('Category deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

}
