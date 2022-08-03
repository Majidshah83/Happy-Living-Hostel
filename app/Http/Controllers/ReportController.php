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

class ReportController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {

      $list_fee = Fee::with('Student')->with('roomlist')->orderBy('created_at','desc')->get();


        return view('backend.admin.reports.index')->with('list_fee',$list_fee);

    }




    public function getAllReports(Request $request) {

        $limit = 10;
        $month = date('m');
        $year = date('Y');

        if ($request->status == 'all') {
            $status = 'all';
        } else {
            $status = '';
        }

        if($request->has('month') &&  !empty($request->month)){
            $month = $request->month;
        }
        if($request->has('year') &&  !empty($request->year)){
            $year = $request->year;
        }

        if($request->has('cdt_per_page') &&  !empty($request->cdt_per_page)){
            $limit = $request->get('cdt_per_page');
            $limit = $limit ? (int) $limit : 10 ;
        }

        $search = '';
        if($request->has('cdt_search') &&  !empty($request->cdt_search)){
            $search = $request->cdt_search;
        }

        $recent_orders = Fee::with('Student')->with('roomlist')

            ->leftjoin("students",function($join) {
                $join->on("students.id","=","fee.student");
            })
            ->when(empty($status) && ($status != 'all'),
                function($q) use ($month,$year, $status){
                    $q->where('fee.month_fee','=',$month);
                    $q->where('fee.year_fee','=',$year);
                    return $q;
            })
            ->where(function ($query) use ($search) {
                $query->when(!empty($search),
                function($q) use ($search){
                    $q->where('students.first_name', 'LIKE', '%' . $search . '%');
                    $q->orWhere('students.last_name', 'LIKE', '%' . $search . '%');
                    return $q;
                });
            })

            ->orderBy('fee.created_at','desc')
            ->paginate($limit);
//            ->toSql();

//        return $banner_type;

        $json_data = view('backend.admin.reports.cdt_so', ['post_arr' => $request->all(), 'list_all' => $recent_orders])->render();

        return response()->json([
            'html_data' => $json_data
        ]);

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

    public function studentDownloadFeeReceipt(Request $request){

            $data  = [];
            if ($request->status == 'all') {
                $order = Fee::with('Student')
                    ->orderBy('created_at','desc')
                    ->get();
            } else {
                $order = Fee::with('Student')
                    ->where('month_fee','=',$request->month)
                    ->where('year_fee','=',$request->year)
                    ->orderBy('created_at','desc')
                    ->get();
            }
            if (count($order) > 0) {
                $data['start_date'] = $request->start_date;
                $data['end_date']   = $request->end_date;
                $data['order']      = $order;
                $html_content       = view('backend.admin.reports.print_receipt', compact('data'))->with('month_fee',$request->month)->with('year_fee',$request->year)->render();
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