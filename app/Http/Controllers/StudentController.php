<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use App\Models\Floor;
use App\Models\Room;
use Carbon\Carbon;
use Session;
use Storage;

class StudentController extends Controller
{


    /**
     * @Description
     * Display a listing of the all banners.
     * @return \Illuminate\Http\Response
    */

    public function index()
    {

        $student = Student::with(['room','floor'])->where('status',1)->orderBy('id','desc')->get();
        return view('backend.admin.student.index')->with('students',$student);

    }
    
    public function checkOutStudent(){

        $student = Student::with(['room','floor'])->where('status','0')->get();
        return view('backend.admin.collec')->with('students',$student);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $floor = Floor::all();
        return view('backend.admin.student.add_edit_form')->with('floors',$floor)->render();
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

        $student_details = Student::where('hash_id', $hash_id)->first();
        $floor = Floor::all();

        $rooms = Room::where('floor_id',$student_details->floor_id)->get();

        return view('backend.admin.student.add_edit_form')->with('floors',$floor)->with('student_details', $student_details)->with('rooms',$rooms)->render();

    }

    /**
     * @Description
     * Store a newly created banner in banners table.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StudentRequest $request)
    {

        $stored = Student::storeData($request);
        if($stored){
            return redirect('student/profile/'.$stored->id);
            Session::flash('success','Student added successfully');
            return response()->success('Student updated successfully!');

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

    public function update(StudentRequest $request, $hash_id)
    {

        $student = Student::where('hash_id',$hash_id)->first();
        // if($student->image == null){

        //     $this->validate($request, [
        //             'image'          => 'required','image','mimes:jpg,jpeg,png,bmp,tiff','max:5120',
        //            ]);

        // }
        $updated = Student::updateData($request, $hash_id);
        if($updated){
            Session::flash('success','student updated successfully');
            return response()->success('student updated successfully!');
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
        $deleted = Student::deleteData($hash_id);

        if(!empty($deleted)){

            Session::flash('success','Student Updated successfully');
            return response()->success('Student Updated successfully!');

        } else {

            Session::flash('error','Oops! Somethings went wrong, please try again later.');
            return response()->failed('Oops! Somethings went wrong, please try again later.');

        }

    }

    public function getRooms(Request $request){


      $rooms = Room::where('floor_id',$request->id)->get();
      return view('backend.admin.student.rooms')->with('rooms',$rooms)->render();



    }



}