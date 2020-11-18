<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WatchingEmployeeControler extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('Admin.WtachingEmployee');
    }

    public function getData($id)
    {
       $employee = DB::table('users')->find($id);

       $drowings = DB::table('drowings')->where('employee_name', $employee->name)->get();
       $strandings = DB::table('strandings')->where('employee_name', $employee->name)->get();
       $insulations = DB::table('insulations')->where('employee_name', $employee->name)->get();
       $screens = DB::table('screens')->where('employee_name', $employee->name)->get();
       $assemblys = DB::table('assemblys')->where('employee_name', $employee->name)->get();
       $beddings = DB::table('beddings')->where('employee_name', $employee->name)->get();
       $armourings = DB::table('armourings')->where('employee_name', $employee->name)->get();
       $taps = DB::table('taps')->where('employee_name', $employee->name)->get();
       $sheathings = DB::table('sheathings')->where('employee_name', $employee->name)->get();
       $leads = DB::table('leads')->where('employee_name', $employee->name)->get();
       $CCVInsulations = DB::table('CCVInsulations')->where('employee_name', $employee->name)->get();

       return [
        'drowing' => $drowings,
        'stranding' => $strandings,
        'insulation' => $insulations,
        'screen' => $screens,
        'assembly' => $assemblys,
        'bedding' => $beddings,
        'armouring' => $armourings,
        'taps' => $taps,
        'sheathing' => $sheathings,
        'Lead' => $leads,
        'CCVInsulation' => $CCVInsulations,
       ];

    }
}
