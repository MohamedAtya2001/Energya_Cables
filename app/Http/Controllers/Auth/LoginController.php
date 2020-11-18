<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\Password;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
        $this->middleware('guest:admin');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function currentShift()
    {
        date_default_timezone_set('Africa/Cairo');
        $timeHours = (int) date('H');
        $timeMin = (int) date('i') / 60;
        $time = $timeHours + $timeMin;
        //To Check About Time To Know The Shift 
        if ($time >= 7.5 && $time <= 15.5) {
            $currentShift = 1;
        } else if ($time > 15.5 && $time <= 23) {
            $currentShift = 2;
        } else {
            $currentShift = 3;
        }

        return $currentShift;
    }

    public function login(Request $request)
    {


        $validator = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', new Password]
        ]);

        $credentails = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::guard('web')->attempt($credentails)) {


            $currentShift = $this->currentShift();

            $employeeShift = Auth::user()->shift;
            // To Make Sure is the Curent Shift is the Same Of that Employee who try To make Login 
            if ($currentShift == $employeeShift) {
                DB::table('users')->where('id', Auth::guard('web')->user()->id)->update([
                    'online' => true,
                    'logout' => false
                ]);
                return redirect('employee/home');
            } else {
                Auth::logout();
                return back()->with('invalidShift', 'This is not your shift');
            }
        } else {
            return back()->with('invalid', ' Invalid Account');
        }
    }

    public function logout()
    {
        DB::table('users')->where('id', Auth::guard('web')->user()->id)->update([
            'online' => false
        ]);
        Auth::guard('web')->logout();
        return redirect('employee/login');
    }
}
