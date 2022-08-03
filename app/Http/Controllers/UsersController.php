<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEditUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersController
{

    public function index()
    {

        $users = User::select('*')
            ->where('id', '!=', Auth::user()->id)
            ->orderBy('id', 'DESC')
            ->get();
        return view('backend.admin.users.index')
            ->with('users', $users);
    }


    public function create()
    {

        return view('backend.admin.users.add_edit_form')->render();
    }

    public function store(AddEditUserRequest $request)
    {
        $stored = User::storeData($request);
        if($stored){

            Session::flash('success','User added successfully');
            return response()->success('User updated successfully!');

        }else{

            Session::flash('success','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }

    public function edit($hash_id)
    {

        $staff_details = User::where('hash_id', $hash_id)->first();
        return view('backend.admin.users.add_edit_form')->with('staff_details', $staff_details)->render();
    }

    public function update(AddEditUserRequest $request, $hash_id)
    {
        $updated = User::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','User updated successfully');
            return response()->success('User updated successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }
    }

    public function getPasswordUpdateForm($hash_id) {

        if (!empty($hash_id)) {
            $row_detail = User::where('hash_id', $hash_id)->first();
            if ($row_detail) {
                return view('backend.admin.users.update_password_form')->with('row_detail', $row_detail)->render();
            }
        }
    }

    public function updatePassword(UpdateUserPasswordRequest $request) {

        $user = User::where('hash_id', $request->get('hash_id'))->update([
            "password" => Hash::make($request->get('password'))
        ]);
        if($user){
            Session::flash('success','Password updated successfully');
            return response()->success('Password updated successfully');
        }else{
            Session::flash('error','Some thing went wrong, please try again');
            return response()->failed('Some thing went wrong, please try again');
        }

    }

}
