<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

	protected $table = "students";
      protected $foreign_key="student";
    protected $fillable = [
    	'hash_id',
    	'first_name',
    	'last_name',
    	'gender',
    	'date_of_birth',
    	'father_name',
    	'image',
    	'address',
        'mobile_number',
        'home_number',
        'profession',
        "cnic",
        "room_id",
        "floor_id",
        "father_cell_no",
        "father_accupation",
        "relation_with_guardian",
        "uni_company_name",
        "uni_company_id",
        "semester",
        "admission_date",
        "security_fee",
        "admission_fee",
        "monthely_fee",
        "email",
        "department_faculty",
        "city",
        "nationality",
        "email"
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'gender'            => $request->gender,
            'date_of_birth'     => $request->date_of_birth,
            'father_name'       => $request->father_name,
            'address'           => $request->address,
            'mobile_number'     => $request->mobile_number,
            'home_number'       => $request->home_number,
            'profession'        => $request->profession,
            'cnic'              => $request->cnic,
            'floor_id'          => $request->floor,
            'room_id'           => $request->room,
            "father_cell_no"    => $request->father_cell_no,
            "father_accupation" => $request->father_accupation,
            "relation_with_guardian" => $request->relation_with_guardian,
            "uni_company_name" => $request->uni_company_name,
            "uni_company_id"   => $request->uni_company_id,
            "semester"         => $request->semester,
            "admission_date"   => $request->admission_date,
            "security_fee"       => $request->security_fee,
            "admission_fee"      => $request->admission_fee,
            "monthely_fee"       => $request->monthely_fee,
            "email"              => $request->email,
            "department_faculty" => $request->department_faculty,
            "city"               => $request->city,
            "nationality"        => $request->nationality
        ];

    }

    public static function storeData($request){

        $common_fields = self::get_common_fields($request);
        $create_student = self::firstOrNew( $common_fields );
        if(!empty($create_student)){
            $create_student->hash_id =  generateHashId();
            $create_student->save();
            if($request->file('image')){
                 $create_student->update(['image' => imageSaveDirectory($request->title, $request->file('image'), 'student', $create_student->id)]);
            }
            return $create_student;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = self::get_common_fields($request);

        $student = self::where('hash_id', $hash_id)->first();

        $student->update( $common_fields );

        if($request->get('remove_image')){

            if($student->image != null){
                removeImageDirectory('student', $student->image);
                $student->update(['image' => NULL]);

            }
        }
        if($request->file('image')){
            if($student->image != null){
                removeImageDirectory('student',$student->image);
            }
            $student->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'student',$student->id)]);
        }
        return $student;


    }

    public static function deleteData($hash_id){

        $student = self::where('hash_id', $hash_id)->first();
        if($student->image != null){
            removeImageDirectory('student', $student->image);
        }
        return $student->delete();

    }

    public function room(){

      return $this->hasOne('App\Models\Room','id','room_id');

    }

    public function floor(){

      return $this->hasOne('App\Models\Floor','id','floor_id');

    }
     public function fee(){

      return $this->hasMany('App\Models\Fee','student','id');

    }


}