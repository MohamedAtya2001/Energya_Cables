<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Rules\Password;
use App\Rules\SpacialUnique;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShowAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showAdmin()
    {
        return view('Admin.show_admin');
    }

    public function getAdmins(Request $request)
    {
        $admin = DB::table('admins')->where('name', 'LIKE',  '%' . $request->filter['name'] . '%');

        $countOfAdmin = $admin->get()->count();
        $admin = $admin->skip($request->filter['limit'] - 25)->take(25)->get();

        return array($admin, $countOfAdmin);
    }

    public function getDataOfAdmin(Request $request)
    {
        $admin = DB::table('admins')->select('name', 'email')->where('id', $request->id)->get();

        return $admin;
    }

    public function editAdmin(Request $request)
    {
        if ($request->ajax()) {


            $admin = DB::table('admins')->where('id', $request->id)->first();

            $validator = $request->validate([
                'name' => ['required', new SpacialUnique($request->id)],
                'email' => ['required', 'email', new SpacialUnique($request->id)],
                'password' => [new Password]
            ]);

            Admin::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);


            if ($request->password != null) {
                Admin::where('id', $request->id)->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            $admin = DB::table('admins')->where('id', $request->id)->first();

            return (array) $admin;
        }
    }

    public function deleteAdmin(Request $request)
    {
        if ($request->ajax()) {
            $deleteAdmin = DB::table('admins')->where('id', $request->id)->delete();
        }
    }
}
