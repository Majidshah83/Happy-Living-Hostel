<?php

namespace App\Http\Controllers;

use App\Http\Requests\FloorRequest;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class FloorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $floors = Floor::orderBy('id', 'DESC')->get();
        return view('backend.admin.floor.index')->with('floors',$floors);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        return view('backend.admin.floor.add_edit_form')->render();
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

        $floor_details = Floor::where('hash_id', $hash_id)->first();
        return view('backend.admin.floor.add_edit_form')->with('floor_details', $floor_details)->render();

    }

    /**
     * @Description
     * Store a newly created banner in banners table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FloorRequest $request)
    {

        $stored = Floor::storeData($request);
        if($stored){

            Session::flash('success','Floor added successfully');
            return response()->success('Floor updated successfully!');

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

    public function update(FloorRequest $request, $hash_id)
    {

        $updated = Floor::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Floor updated successfully');
            return response()->success('Floor updated successfully!');

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
        $deleted = Floor::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Floor deleted successfully');
            return response()->success('Floor deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

}
