<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{

	protected $table = "fee";
    protected $foreign_key="student";

    protected $fillable = [
    	'hash_id',
        "room",
        "student",
        "admission_fee",
        "hostel_fee",
        "security_fee",
        "ac_fee",
        "gayser_fee",
        "late_fee_fine",
        "miscellaneous_fee",
        "electricty_fee",
        "per_units",
        "current_units",
        "month_fee",
        "year_fee",
        "total_amount",
        "due_fee",
        "remaining_amount",
        'payment_type',
        'payment_company',
        'transaction_id'
    ];


    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [
            "room"  => $request->room,
            "student"  => $request->student,
            "admission_fee"  => $request->admission_fee,
            "hostel_fee"  => $request->hostel_fee,
            "security_fee"  => $request->security_fee,
            "ac_fee"  => $request->ac_fee,
            "gayser_fee"  => $request->gayser_fee,
            "late_fee_fine"  => $request->late_fee_fine,
            "miscellaneous_fee"  => $request->miscellaneous_fee,
            "electricty_fee"  => $request->electricty_fee,
            "per_units"  => $request->per_units,
            "current_units"  => $request->current_units,
            "month_fee"  => $request->month_fee,
            "year_fee"  => $request->year_fee,
            "total_amount"  => $request->total_amount,
            "due_fee"  => $request->due_fee,
            "remaining_amount"  => $request->total_amount - $request->due_fee,
        ];


    }

    public static function storeData($request){

        $common_fields = self::get_common_fields($request);
        $common_fields['hash_id'] =  generateHashId();
        $common_fields['payment_type'] = $request->payment_type;
        if($request->payment_type == 'online'){
            $common_fields['payment_company'] = $request->payment_company;
            $common_fields['transaction_id'] = $request->transaction_id;
        }
        $create_data = self::create($common_fields);
        return $create_data;

    }

    public static function updateData($request, $hash_id){

        $common_fields = self::get_common_fields($request);
        $common_fields['payment_type'] = $request->payment_type;
        if($request->payment_type == 'online'){
            $common_fields['payment_company'] = $request->payment_company;
            $common_fields['transaction_id'] = $request->transaction_id;
        }else{
            $common_fields['payment_company'] = null;
            $common_fields['transaction_id'] = null;
        }
        $update_data   = self::where('hash_id', $hash_id)->first();
        $update_data->update( $common_fields );
        return $update_data;

    }

    public static function deleteData($hash_id){

        $delete_data = self::where('hash_id', $hash_id)->first();
        return $delete_data->delete();

    }

    public function FeeType(){

      return $this->hasOne('App\Models\FeeType','id','fee_type_id');

    }

    public function roomlist(){

      return $this->hasOne('App\Models\Room','id','room');

    }

    public function Student(){

      return $this->hasOne('App\Models\Student','id','student');

    }




}