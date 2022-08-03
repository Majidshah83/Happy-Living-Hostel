<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEditPatientRequest;
use App\Http\Requests\UpdatePatientPasswordRequest;
use App\Http\Requests\UpdateVerifyStatusRequest;
use App\Mail\NewPatientForgotPasswordLinkMail;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $patients = Patient::with('country')->orderBy('id', 'DESC')->get();
        return view('backend.admin.patients.index')
            ->with('patients', $patients);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countries  = DB::table('kod_countries')->get();
        return view('backend.admin.patients.add_edit_form')->with('countries', $countries)->render();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddEditPatientRequest $request)
    {

        $stored = Patient::storeData($request);
        if($stored){
            Session::flash('success','Patient added successfully');
            return response()->success('Patient updated successfully!');
        }else{
            Session::flash('error','Oops! Somethings went wrong, please try again later.');
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
        $patient_details = Patient::where('hash_id', $hash_id)->first();
        $countries  = DB::table('kod_countries')->get();
        return view('backend.admin.patients.add_edit_form')
            ->with('countries', $countries)
            ->with('patient_details', $patient_details)->render();;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddEditPatientRequest $request, $hash_id)
    {
        $updated = Patient::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Patient updated successfully');
            return response()->success('Patient updated successfully!');

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

    public function updatePatientPassword(UpdatePatientPasswordRequest $request) {

        $patient = Patient::where('hash_id', $request->get('hash_id'))->update([
            "password" => Hash::make($request->get('password'))
        ]);
        if($patient){
            Session::flash('success','Password updated successfully');
            return response()->json(['error'=> false, 'msg' => 'Password updated successfully']);
        }else{
            Session::flash('error','Some thing went wrong, please try again');
            return response()->json(['error'=> true, 'msg' => 'Some thing went wrong, please try again']);
        }

    }

    public function updateVerificationStatus(UpdateVerifyStatusRequest $request) {

        $patient = Patient::where('hash_id', $request->get('hash_id'))->update([
            "is_verified" => $request->get('is_verified_in'),
            "reason" => $request->get('is_verified_in') ? $request->get('reason_in') : ''
        ]);
        if($patient){
            Session::flash('success','Verified status updated successfully');
            return response()->json(['error'=> false, 'msg' => 'Verified successfully']);
        }else{
            Session::flash('error','Verified status cant updated successfully');
            return response()->json(['error'=> true, 'msg' => 'Some thing went wrong, please try again']);
        }

    }
}
