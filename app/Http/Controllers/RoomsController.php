<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomRequest;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $rooms = Room::get();
        return view('backend.admin.rooms.index')
                    ->with('rooms',$rooms);

    }
    //total seats
    public function totalSeats()
    {
         $rooms = Room::get();
         $total_seats= Room::get()->sum('capacity');

        
         return view('backend.admin.total_seat.index',compact('rooms','total_seats'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $floors = Floor::get();
        return view('backend.admin.rooms.add_edit_form')->with('floors',$floors)->render();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoomRequest $request)
    {

        $stored = Room::storeData($request);

        if($stored){

            Session::flash('success','Room added successfully');
            return response()->success('Room added successfully!');

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

        $room_details = Room::where('hash_id', $hash_id)->first();
        $floors = Floor::get();

        return view('backend.admin.rooms.add_edit_form')->with('floors', $floors)->with('room_details',$room_details)->render();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoomRequest $request, $hash_id)
    {

        $updated = Room::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Room updated successfully');
            return response()->success('Room updated successfully!');

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
        $deleted = Room::deleteData($hash_id);
        if(!empty($deleted)){

            Session::flash('success','Room deleted successfully');
            return response()->success('Room deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }


    /******************************************/
    /******** Start => Custom Functions *******/


    /******** End => Custom Functions *******/
    /****************************************/
}