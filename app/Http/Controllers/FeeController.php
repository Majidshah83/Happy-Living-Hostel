<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeeRequest;
use App\Models\Fee;
use App\Models\FeeType;
use App\Models\Student;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Session;
use Storage;
use Carbon\Carbon;

class FeeController extends Controller
{
  

    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index($id)
    {

        $data = Fee::where('student_id',$id)->get();
        return view('backend.admin.fee.index')->with('data',$data)->with('id',$id);

    }

     public function getAllCollectAmount()
   {

        $list_all= Student::with('room')->where('status',1)->orderBy('id','desc')->get();
        $monthly_fee  = Student::whereMonth('created_at', Carbon::now()->month)->where('status',1)->sum('monthely_fee');
        //  $security_fee  = Student::whereMonth('created_at', Carbon::now()->month)->where('status',1)->sum('security_fee');
        // $admission_fee  = Student::whereMonth('created_at', Carbon::now()->month)->where('status',1)->sum('admission_fee');

        return view('backend.admin.collectAmount.index',compact('list_all','monthly_fee'));


   }
// dd($total_collection_amount);

   public function getAllCollectionAmount()
   {
   $year = date('y');
  $month = date('m');
    $listing=Student::whereHas('fee',function($q) use ($month,$year){
	return $q->where('fee.month_fee',$month)->where('fee.year_fee',$year);
})->get();


     return view('backend.admin.collectionReport.index');
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {

        $fee_type = FeeType::all();
        $student= Student::where('id', $request->id)->first();
        return view('backend.admin.fee.add_edit_form')->with('fee_type',$fee_type)->with('student',$student)->render();
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

    public function edit($hash_id,Request $request)
    {

        $fee_details = Fee::where('hash_id', $hash_id)->with('FeeType')->first();
        $student= Student::where('id', $request->id)->first();
        $fee_type = FeeType::all();
        return view('backend.admin.fee.add_edit_form')->with('student',$student)->with('fee_type',$fee_type)->with('student_fee_details', $fee_details)->render();

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
            return response()->success('Fee updated successfully!');

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

    public function update(FeeRequest $request, $hash_id)
    {

        $updated = Fee::updateData($request, $hash_id);
        if($updated){

            Session::flash('success','Fee updated successfully');
            return response()->success('Fee updated successfully!');

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

        $deleted = Fee::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Fee deleted successfully');
            return response()->success('Fee deleted successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

    public function getStudentFee(Request $request){

        $month = $admission_fee = $security_fee = $fine = 0;
        $student = Student::where('id',$request->id)->first();
        if(!empty($student->monthely_fee)){
           $month = $student->monthely_fee;
        }
        $fee = Fee::where('student',$request->id)->get()->count();
        if($fee >= 1){
            $c_date =  date('d');
            if($c_date > 5){
                $d_date = $c_date - 5;
                $fine = $d_date * 200;
            }
        }
        $current_date         = date('Y-m-d');
        $student_created_date = date('Y-m-d',strtotime($student->created_at));
        if($current_date == $student_created_date){
            if(!empty($student->admission_fee)){
              $admission_fee = $student->admission_fee;
            }
            if(!empty($student->security_fee)){
               $security_fee = $student->security_fee;
            }
        }
        return ['month_fee' => $month,'admission_fee' => $admission_fee,'security_fee' => $security_fee, 'fine' => $fine];

    }

    public function studentFeeReceipt($id){

        $data = [];
        if (!empty($id)) {
            $order = Fee::with('FeeType')->where('id',$id)->first();
            if ($order) {
                $student = Student::where('id',$order->student_id)->first();
                $data['student'] = $student;
                $data['order']   = $order;
                $html_content    = view('backend.admin.fee.print_receipt', compact('data'))->render();
                PDF::SetTitle('Receipt');
                PDF::SetFont('times', '', 10);
                PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                PDF::AddPage();
                PDF::writeHTML($html_content, true, false, true, false, '');
                PDF::Output('receipt.pdf');
                return;

            } else {

                abort(404);

            }

        } else {
            abort(404);
        }


    }

    public function studentDownloadFeeReceipt(Request $request){

            $data = [];
            $order = Fee::with('FeeType')->where('date','>=',$request->start_date)->where('date','<=',$request->end_date)->where('student_id',$request->student_id)->get();
            if (count($order) > 0) {
                $student = Student::where('id',$request->student_id)->first();
                $data['student']    = $student;
                $data['start_date'] = $request->start_date;
                $data['end_date']   = $request->end_date;
                $data['order']      = $order;
                $html_content       = view('backend.admin.fee.print_download_receipt', compact('data'))->render();
                PDF::SetTitle('Receipt');
                PDF::SetFont('times', '', 10);
                PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                PDF::AddPage();
                PDF::writeHTML($html_content, true, false, true, false, '');
                PDF::Output('receipt.pdf');
                return;

            } else {

                return redirect()->back()->with('error','Not Found Date.');

            }


    }


}