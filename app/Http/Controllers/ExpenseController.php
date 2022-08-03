<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeeRequest;
use App\Models\Expense;
use App\Models\FeeType;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Room;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Session;
use Storage;

class ExpenseController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */


    public function index()
    {


        $list_fee = Expense::orderBy('id','desc')->get();
        return view('backend.admin.expense.index')->with('list_fee',$list_fee);

    }
    //sum of total amount
    public function getSumAmount(Request $request)
    {

        $result=Expense::where(['month_fee' => $request->month,'year_fee' => $request->year])->first();
        return response()->json($result);

        //    return response()->json($result);

    }

      // get all current month expense
     public function getAllExpense($month)
     {

         $list_fee = Expense::where('month_fee',$month)->orderBy('id','desc')->get();
         return view('backend.admin.expense.index')->with('list_fee',$list_fee);

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

        return view('backend.admin.expense.add_edit_form')->render();

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

    public function store(Request $request)
    {

        $stored = Expense::storeData($request);
        if($stored){

            Session::flash('success','Expense added successfully');
            return response()->success('Expense updated successfully!');

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

        $edit_details = Expense::where('hash_id', $hash_id)->first();

        return view('backend.admin.expense.add_edit_form')->with('edit_details', $edit_details)->render();

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

        $updated = Expense::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Expense updated successfully');
            return response()->success('Expense updated successfully!');



        } else {
            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

    public function feeDetailPrint($hash_id){

        $fee_details = Expense::where('hash_id',$hash_id)->first();
        $html_content    = view('backend.admin.fee.print_receipt_expense')->with('fee_details',$fee_details)->render();
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