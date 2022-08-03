<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeeRequest;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Student;
use App\Models\Room;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Session;
use Storage;

class StudentFeeController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {
        
        $list_fee = Fee::orderBy('id','desc')->with('roomlist')->get();
        return view('backend.admin.studentfee.index')->with('list_fee',$list_fee);

    }

    public function studentProfile($id){

        $students = Student::where('id',$id)->first();
        return view('backend.admin.fee.student_profile')->with('student',$students);
        PDF::SetTitle('Receipt');
        PDF::SetFont('times', '', 10);
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::Output('receipt.pdf');
        return;

    }

    public function create()
    {
        $room = Room::all();
        return view('backend.admin.studentfee.add_edit_form')->with('rooms',$room)->render();
    }

    public function getStudent(Request $request){

        $students = Student::where('room_id',$request->id)->where('status',1)->get();
        return view('backend.admin.studentfee.student')->with('students',$students)->render();

    }

    public function getStudentBalanace(Request $request){

        $get_balance = Fee::where('student',$request->id)->orderBy('id','desc')->first();
        $amount = 0;
        if($get_balance){
            $amount = $get_balance->remaining_amount;
        }
        return $amount;

    }

     /**
     * @Description
     * Store a newly created banner in banners table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FeeRequest $request)
    {

        $stored = Fee::storeData($request);
        if($stored){
            Session::flash('success','Fee added successfully');  
            return $stored->hash_id;
            return response()->success('Fee updated successfully!');
            
        }else{

            Session::flash('success','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($hash_id)
    {

        $edit_details = Fee::where('hash_id', $hash_id)->first();
        $students     = Student::where('room_id',$edit_details->room)->where('status',1)->get();
        $room         = Room::all();
        $get_balance  = Fee::where('student',$edit_details->student)->where('id','!=',$edit_details->id)->orderBy('id','desc')->first();
        $amount       = 0;
        if($get_balance){
            $amount   = $get_balance->remaining_amount;
        }
        return view('backend.admin.studentfee.add_edit_form')->with('edit_details', $edit_details)->with('rooms',$room)->with('students',$students)->with('amount',$amount)->render();

    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(FeeRequest $request, $hash_id)
    {
       
        $updated = Fee::updateData($request, $hash_id);
        if($updated){
            Session::flash('success','Fee updated successfully'); 
            return $updated->hash_id;
            return response()->success('Fee updated successfully!');
        } else {
            Session::flash('error','Oops! Somethings went wrong, please try again later.'); 
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

    public function feeDetailPrint($hash_id){

        $fee_details = Fee::with('Student')->where('hash_id',$hash_id)->first();
        $get_balance = Fee::where('student',$fee_details->student)->where('id','!=',$fee_details->id)->orderBy('id','desc')->first();
        $amount = 0;
        if($get_balance){
            $amount = $get_balance->remaining_amount;
        }
        $html_content    = view('backend.admin.fee.update_fee')->with('amount',$amount)->with('fee_details',$fee_details)->render();
        PDF::SetTitle('Receipt');
        PDF::SetFont('times', '', 10);
        PDF::SetAutoPageBreak(false);
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::Output('receipt.pdf');
        return;


    }

    public function feeStudentDetailPrint($id){

        $students = Student::where('id',$id)->first();
        $fee_details = Fee::where('student',$id)->get();
        $html_content    = view('backend.admin.fee.print_receipt_all')->with('students',$students)->with('fee_details',$fee_details)->render();
        PDF::SetTitle('Receipt');
        PDF::SetFont('times', '', 10);
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');
        PDF::Output('receipt.pdf');
        return;


    }

  
    
}
