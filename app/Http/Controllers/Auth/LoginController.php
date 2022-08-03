<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('backend.admin.login');
    }

    /**
     * Custom credentials to validate the status of user.
     */
    public function credentials(Request $request)
    {
        return [
            'email'     => $request->email,
            'password'  => $request->password,
            'status' => '1'
        ];
    }

    function authenticated(Request $request, $user)
    {
        $user->update([
            'first_logged_in' => Carbon::now()->toDateTimeString(),
            'last_logged_in' => Carbon::now()->toDateTimeString(),
            'created_by_ip' => $request->getClientIp()
        ]);
    }

    protected function validateLogin(Request $request)
    {
        // validateCaptcha($request->all())->validate();
        $user = User::where($this->username(), '=', $request->input($this->username()))->first();
        if ($user && ! $user->status) {
            throw ValidationException::withMessages([$this->username() => __('Your account has been disabled, please contact administrator.')]);
        }
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * After Login redirect
     * @return string
     */
    public function redirectTo()
    {
        // User role
        $role = Auth::user()->role;


        // Check user role
        switch ($role) {
            case 'Admin':
            case 'Employee':
                return '/dashboard';
                break;
            case 'Dispenser':
                return '/dashboard';
                break;
            case 'Manager':
                return '/dashboard';
                break;
            case 'Other':
                return '/dashboard';
                break;
            default:
                return 'admin/login';
                break;
        }

    }


        /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



}
