<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Session;
use Storage;

class BlogController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {

        $blogs = Blog::orderBy('display_order', 'ASC')->get();
        return view('backend.admin.blog.index')->with('blogs',$blogs);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $blog_category = BlogCategory::all();
        return view('backend.admin.blog.add_edit_form')->with('blog_category',$blog_category)->render();
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

        $blog = Blog::where('hash_id', $hash_id)->first();
        $blog_category = BlogCategory::all();
        return view('backend.admin.blog.add_edit_form')->with('blog_category',$blog_category)->with('blog', $blog)->render();

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

        $stored = Blog::storeData($request);
        if($stored){
        
            Session::flash('success','Blogs added successfully');  
            return response()->success('Blogs updated successfully!');
            
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

        $Blog = Blog::where('hash_id',$hash_id)->first();
        if($Blog->image == null){
      
            $this->validate($request, [
                    'image'          => 'required','image','mimes:jpg,jpeg,png,bmp,tiff','max:5120',
                   ]);

        }
        $updated = Blog::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Blog updated successfully'); 
            return response()->success('Blog updated successfully!');

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
        $deleted = Blog::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Blog deleted successfully'); 
            return response()->success('Blog deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

}
