<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_coupons';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'title',
        'description',
        'coupon_code',
        'discount_price',
        'discount_percentage',
        'usage_limit',
        'usage_total',
        'coupon_type',
        'expiry_date_time',
        'has_expiry_date',
        'is_expired',
        'status',
        'created_ip'
    ];

    public static function get_common_fields($request){

           return [
                'title'          => $request->title,
                'description'    => $request->description,
                'coupon_code'    => $request->coupon_code,
                'usage_limit'    => $request->usage_limit,
                'coupon_type'    => $request->coupon_type,
                'discount_price' => $request->discount_price ?  $request->discount_price : 0,
                'discount_percentage' => $request->discount_percentage ? $request->discount_percentage : 0,
                'expiry_date_time' => $request->expiry_date_time ?  $request->expiry_date_time: null,
                'has_expiry_date' => $request->has_expiry_date,
                'is_expired' => $request->is_expired,
                'status'         => $request->status,
                'created_ip'     => $request->ip()
            ];
    }

    public static function storeData($request){

        $common_fields = Coupon::get_common_fields($request);
        $create_coupon = self::firstOrNew( $common_fields );
        if(!empty($create_coupon)){
            $create_coupon['hash_id'] = generateHashId();
            $create_coupon->save();
            return $create_coupon;
        }

    }


    public static function updateData($request, $hash_id){

        $common_fields = Coupon::get_common_fields($request);
        $coupon        = self::where('hash_id', $hash_id)->first();
        $coupon->update( $common_fields );
        return $coupon;

    }


    public static function deleteData($hash_id){

        $coupon = Coupon::where('hash_id', $hash_id)->first();
        return $coupon->delete();

    }




}
