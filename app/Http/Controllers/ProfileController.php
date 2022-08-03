<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateInfoRequest;
use App\User;
use App\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Profile listing
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index() {
        return view('backend.admin.profile.index');
    }

    /**
     * Change auth password page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword() {
        return view('backend.admin.profile.change_password');
    }

    /**
     * Update auth password
     * @param PasswordUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(PasswordUpdateRequest $request) {

        $user = Auth::user()->update([
            "password" => Hash::make($request->get('password'))
        ]);
        if($user) {
            session()->flash('successEmail', 'Password updated successfully, please login.');
            Auth::logout();
            return redirect('login');
            //            session()->flash('success', 'Password updated successfully');
        } else {
            session()->flash('warn', 'Password can\'t updated successfully');
        }
        return Redirect::back();

    }

    /**
     * Method for auth user email update
     * @param EmailUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateEmail(Request $request) {

        if(Auth::user()->email == $request->email){
         return Redirect::back()->with('success', 'Email is not updated.');
        }
        $this->validate($request, [
          'email' => 'required|string|email|max:90|unique:kod_users,email'
        ]);
        $user = Auth::user()->update([
            "email" => strtolower(trim($request->get('email')))
        ]);
        if($user) {
            session()->flash('successEmail', 'Email updated successfully, please login.');
            Auth::logout();
            return redirect('login')->with('info', 'Email updated successfully, please login.');
        } else {
            session()->flash('warnEmail', 'Email can\'t updated successfully');
        }
        return Redirect::back();

    }

    public function editProfile() {
        $user_types = UserType::select('id', 'hash_id', 'title')
            ->where('status', 1)
            ->get();
        return view('backend.admin.profile.edit')->with('user_types', $user_types);
    }

    public function updateProfileInfo(ProfileUpdateInfoRequest $request) {

        $user = User::hashedUser(Auth::user()->hash_id);
        if ($user) {
            if($request->get('email') != Auth::User()->email){
                $user_email_check = User::where('email',$request->get('email'))->first();
                if(!empty($user_email_check)){
                    session()->flash('error', 'Email already taken');
                    return Redirect::back();
                }
            }
            $updated = $user->update([
                'first_name'      => $request->get('first_name'),
                'last_name'       => $request->get('last_name'),
                'email'           => $request->get('email'),
                'profile_image'    => $this->checkProfileImage($request, $user)
            ]);
            if($request->profile_check){
                removeImageDirectory('profile',$user->profile_image);
                $user->update(['profile_image' => null]);
            }
            if ($updated) {
                session()->flash('success', 'Profile updated successfully');
                return Redirect::back();
            } else {
                session()->flash('error', 'Profile cant updated successfully');
                return Redirect::back();
            }
        }

    }

    /**
     * Check profile image exists
     * @param $request
     * @return string
     */
    private function checkProfileImage($request, $user) {

        $filename = null;
        if($request->file('profile_image') != null){
            if($user->profile_image != null){
                removeImageDirectory('profile',$user->profile_image);
            }
            $fileName = imageSaveDirectory($request->get('first_name'),$request->file('profile_image'),'profile',$user->hash_id);
        } else {
            $fileName = $request->get('old_image');
        }
        return $fileName;

    }

    /**
     * Check profile image exists
     * @param $request
     * @return string
     */

    private function checkSignatureImage($request, $user) {
      
        $filename = null;
        if($request->file('signature') != null){
            if($user->signature != null){
                removeImageDirectory('signature',$user->signature);
            }
            $fileName = imageSaveDirectory($request->get('first_name'),$request->file('signature'),'signature',$user->hash_id);
        } else {
            $fileName = $request->get('old_image_signature');
        }
        return $fileName;

    }
}
