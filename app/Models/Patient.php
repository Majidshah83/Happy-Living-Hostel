<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Patient extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_patients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'first_name',
        'last_name',
        'dob',
        'country_id',
        'mobile_number',
        'gender',
        'nsh_no',
        'address',
        'address_1',
        'address_2',
        'address_3',
        'email',
        'password',
        'town_city',
        'postcode',
        'mobile_no',
        'status',
        'is_verified',
        'passport_number',
        'reason'
    ];


    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [ 
            'first_name'      => $request->first_name,
            'last_name'       => $request->last_name,
            'gender'          => $request->gender,
            'nsh_no'          => $request->nsh_no,
            'country_id'      => $request->country_id,
            'address'          => $request->address,
            'town_city'       => $request->town_city,
            'postcode'        => $request->postcode,
            'mobile_number'   => $request->mobile_number,
            'is_verified'     => $request->has('is_verified') ? $request->is_verified :0,
            'reason'          => $request->reason,
            'status'          => $request->status,
            'passport_number' => $request->passport_number
        ];

    }

    public static function storeData($request){

        $common_fields = Patient::get_common_fields($request);
        $common_fields['email'] = trimEmail($request->email);
        $common_fields['dob'] = $request->year. "-" .$request->month. "-" .$request->day;
        $create_patient = self::firstOrNew( $common_fields );
        if(!empty($create_patient)){
           $create_patient->hash_id = generateHashId();
           $create_patient->save();
           return $create_patient;
        }
    }

    public static function updateData($request, $hash_id){

        $common_fields = Patient::get_common_fields($request);
        $patient = self::where('hash_id', $hash_id)->first();
        if (trimEmail($request->email) != trimEmail($patient->email)) {
            if (Patient::where('email', '=', trimEmail($request->get('email')))->exists()) {
                throw ValidationException::withMessages(['email' => 'This email is already been taken, try another']);
            } else {
                $common_fields['email'] = trimEmail($request->email);
            }
        }
        if (!$request->get('is_verified')) {
            $common_fields['reason'] = '';
        }
        $common_fields['dob'] = $request->year. "-" .$request->month. "-" .$request->day;
        $patient->update( $common_fields );
        return $patient;

    }

    public function country()
    {
        return $this->belongsTo(Countries::class);
    }

}
