<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Fee;

class Expense extends Model
{

	protected $table = "expense";

    protected $fillable = [
    	'hash_id',
        "salary",
        "electricty_bill",
        "net_bill",
        "gas_bill",
        "rent",
        "sabzi",
        "daily_expense",
        "misc",
        "month_fee",
        "year_fee",
        "total_amount",
        "total_rent",
        "remaining_amount"
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        $fee = Fee::where('month_fee','=',$request->month_fee)->where('year_fee','=',$request->year_fee)->get()->sum('total_amount');

        return [
            "room"  => $request->room,
            "salary"  => $request->salary,
            "electricty_bill"  => $request->electricty_bill,
            "net_bill"  => $request->net_bill,
            "gas_bill"  => $request->gas_bill,
            "rent"  => $request->rent,
            "sabzi"  => $request->sabzi,
            "daily_expense"  => $request->daily_expense,
            "misc"  => $request->misc,
            "month_fee"  => $request->month_fee,
            "year_fee"  => $request->year_fee,
            "total_amount"  => $request->total_amount,
            "total_rent"  => $fee,
            "remaining_amount"  => $request->total_amount - $fee,
        ];


    }

    public static function storeData($request){

        $common_fields = self::get_common_fields($request);
        $common_fields['hash_id'] =  generateHashId();
        $create_data = self::create($common_fields);
        return $create_data;

    }

    public static function updateData($request, $hash_id){

        $common_fields = self::get_common_fields($request);
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
