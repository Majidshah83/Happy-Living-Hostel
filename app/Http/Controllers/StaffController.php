<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEditStaffRequest;
use App\User;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Hash;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::select('*')
            ->where('id', '!=', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.admin.staffs.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_types = UserType::select('id', 'hash_id', 'title')
            ->where('status', 1)
            ->get();
        return view('backend.admin.staffs.add_edit_form')->with('user_types', $user_types)->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddEditStaffRequest $request)
    {
        $stored = User::storeData($request);
        if($stored){

            Session::flash('success','Staff added successfully');
            return response()->success('Staff updated successfully!');

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
        $user_types = UserType::select('id', 'hash_id', 'title')
            ->where('status', 1)
            ->get();
        $staff_details = User::where('hash_id', $hash_id)->first();
        if (!empty($staff_details->password)) {
            $staff_details->p =  true;
            unset($staff_details->password);
        }
        return view('backend.admin.staffs.add_edit_form')->with('staff_details', $staff_details)->with('user_types', $user_types)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddEditStaffRequest $request, $hash_id)
    {
        $updated = User::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Staff updated successfully');
            return response()->success('Staff updated successfully!');

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

    public function updateStaffPassword(Request $request) {

        $this->validate($request, [
          'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);
        $user = User::where('hash_id', $request->get('hash_id'))->update([
            "password" => Hash::make($request->get('password'))
        ]);
        if($user){
            Session::flash('success','Password updated successfully');
            return response()->json(['error'=> false, 'msg' => 'Password updated successfully']);
        }else{
            Session::flash('error','Some thing went wrong, please try again');
            return response()->json(['error'=> true, 'msg' => 'Some thing went wrong, please try again']);
        }

    }
}
