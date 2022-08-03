<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "kod_users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id', 'user_type_id', 'first_name', 'last_name', 'email', 'password', 'role', 'email_verified_at',
        'remember_token', 'contact_no', 'reg_no', 'professional_title', 'address_1', 'address_2',
        'address_3', 'city', 'town', 'fax_no', 'county', 'postcode', 'signature', 'status', 'first_logged_in', 'last_logged_in',
        'login_attempts', 'created_by_ip', 'modified_by_ip', 'profile_image', 'phone_no', 'qualification', 'mob_no', 'tele_no', 'county', 'biography'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $user_hash_id
     *
     * @return mixed
     * @description Return user instance
     */
    public static function hashedUser($user_hash_id)
    {
        return self::where('hash_id', '=', $user_hash_id)->first();
    }

    public static function get_common_fields($request){

        return [

            'user_type_id'             => $request->user_type_id,
            'first_name'          => $request->first_name,
            'last_name'          => $request->last_name,
            'role'       => $request->role,
            'phone_no'       => $request->phone_no,
            'reg_no'       => $request->reg_no,
            'professional_title'       => $request->professional_title,
            'address_1'       => $request->address_1,
            'address_2'       => $request->address_2,
            'address_3'       => $request->address_3,
            'county'       => $request->county,
            'city'       => $request->city,
            'postcode'       => $request->postcode,
            'fax_no'       => $request->fax_no
        ];

    }

    public static function storeData($request){

        $common_fields = User::get_common_fields($request);
        $common_fields['created_by_ip'] = $request->ip();

        $common_fields['email'] = trimEmail($request->email);
        $common_fields['status'] = '0';

        $create_staff = self::firstOrNew( $common_fields );

        if(!empty($create_staff)){
            $create_staff['hash_id'] = generateHashId();
            $create_staff->save();
            return $create_staff;
        }

    }


    public static function updateData($request, $hash_id){

        $common_fields = User::get_common_fields($request);

        $staff = self::where('hash_id', $hash_id)->first();
        $common_fields['modified_by_ip'] = $request->ip();
        if (trimEmail($request->email) != trimEmail($staff->email)) {
            if (User::where('email', '=', trimEmail($request->get('email')))->exists()) {
                throw ValidationException::withMessages(['email' => 'This email is already been taken, try another']);
            } else {
                $common_fields['email'] = trimEmail($request->email);
            }
        }

        $staff->update( $common_fields );

        if($request->get('remove_profile_image')){

            if($staff->profile_image != null){

                removeImageDirectory('profile', $staff->profile_image);
                $staff->update(['profile_image' => NULL]);

            }

        }
        if($request->get('remove_signature_image')){

            if($staff->signature != null){

                removeImageDirectory('signature', $staff->signature);
                $staff->update(['signature' => NULL]);

            }

        }

        if($request->file('profile_image')){

            if($staff->profile_image != null){
                removeImageDirectory('profile', $staff->profile_image);
            }

            $staff->update(['profile_image' => imageSaveDirectory($request->first_name,$request->file('profile_image'),'profile',$staff->id)]);

        }

        if($request->file('signature')){

            if($staff->signature != null){
                removeImageDirectory('signature', $staff->signature);
            }

            $staff->update(['signature' => imageSaveDirectory($request->first_name,$request->file('signature'),'signature',$staff->id)]);

        }

        return $staff;

    }


    /**
     * Get the user that owns the userType.
     */
    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

}
