<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\Password;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginAdminController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:user');
    }

    public function index()
    {
        return view('auth.admin-login');
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


        if (Auth::guard('admin')->attempt($credentails)) {
            DB::table('admins')->where('id', Auth::guard('admin')->user()->id)->update([
                'online' => true
            ]);
            return redirect('admin/home');
        } else {
            return redirect('admin/login')->with('invalid', ' Invalid Account');
        }
    }

    public function logout()
    {
        DB::table('admins')->where('id', Auth::guard('admin')->user()->id)->update([
            'online' => false
        ]);
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
