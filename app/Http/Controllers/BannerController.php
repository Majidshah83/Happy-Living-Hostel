<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use Session;
use Storage;

class BannerController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {

        $banners = Banner::orderBy('display_order', 'ASC')->get();
        return view('backend.admin.banners.index')->with('banners',$banners);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.banners.add_edit_form')->render();
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

        $banner_details = Banner::where('hash_id', $hash_id)->first();
        return view('backend.admin.banners.add_edit_form')->with('banner_details', $banner_details)->render();

    }

    /**
     * @Description
     * Store a newly created banner in banners table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(BannerRequest $request)
    {

        $stored = Banner::storeData($request);
        if($stored){
        
            Session::flash('success','Banner added successfully');  
            return response()->success('Banner updated successfully!');
            
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

    public function update(BannerRequest $request, $hash_id)
    {

        $banner = Banner::where('hash_id',$hash_id)->first();
        if($banner->image == null){
            $this->validate($request, [
                    'image'          => 'required','image','mimes:jpg,jpeg,png,bmp,tiff','max:5120',
                   ]);
        }
        $updated = Banner::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Banner updated successfully'); 
            return response()->success('Banner updated successfully!');

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
        $deleted = Banner::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Banner deleted successfully'); 
            return response()->success('Banner deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

  
    
}
