<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyOpeningHour extends Model
{

    //
	protected $table   = "kod_pharmacy_opening_hours";

    protected $fillable = [

        "sat_open_time",
        "sat_close_time",
        "sun_open_time",
        "sun_close_time",
        "mon_open_time",
        "mon_close_time",
        "tue_open_time",
        "tue_close_time",
        "wed_open_time",
        "wed_close_time",
        "thu_open_time",
        "thu_close_time",
        "fri_open_time",
        "fri_close_time",
        "is_sat_closed",
        "is_sun_closed",
        "is_mon_closed",
        "is_tue_closed",
        "is_wed_closed",
        "is_thu_closed",
        "is_fri_closed",
        "created_by_ip",
        "modified_by_ip"

    ];

    /**
     * @Description Add record in banners table.
     */

    public static function storeData($request){

         $pharmcayInfo = [
                "sat_open_time"  => $request->sat_open_time,
                "sat_close_time" => $request->sat_close_time,
                "sun_open_time"  => $request->sun_open_time,
                "sun_close_time" => $request->sun_close_time,
                "mon_open_time"  => $request->mon_open_time,
                "mon_close_time" => $request->mon_close_time,
                "tue_open_time"  => $request->tue_open_time,
                "tue_close_time" => $request->tue_close_time,
                "wed_open_time"  => $request->wed_open_time,
                "wed_close_time" => $request->wed_close_time,
                "thu_open_time"  => $request->thu_open_time,
                "thu_close_time" => $request->thu_close_time,
                "fri_open_time"  => $request->fri_open_time,
                "fri_close_time" => $request->fri_close_time,
                "is_sat_closed"  => $request->is_sat_closed ? 1 : 0,
                "is_sun_closed"  => $request->is_sun_closed ? 1: 0,
                "is_mon_closed"  => $request->is_mon_closed ? 1 : 0,
                "is_tue_closed"  => $request->is_tue_closed ? 1 : 0,
                "is_wed_closed"  => $request->is_wed_closed ? 1 : 0,
                "is_thu_closed"  => $request->is_thu_closed ? 1 : 0,
                "is_fri_closed"  => $request->is_fri_closed ? 1 : 0,
                "created_by_ip"  => $request->ip(),
                "modified_by_ip" => $request->ip()
        ];

        $createUpdatePharmcayInfo = self::first();
        if($createUpdatePharmcayInfo){
           $createUpdatePharmcayInfo->update($pharmcayInfo);
        }else{
           $createUpdatePharmcayInfo = self::create($pharmcayInfo);
        }
        return $createUpdatePharmcayInfo;

    }



}
