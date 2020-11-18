<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\Password;
use App\Rules\SpacialUnique;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ShowEmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showEmployee()
    {
        $employees = DB::table('users')->get();
        return view('Admin.show_employee', compact('employees'));
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


    public function getEmployees(Request $request)
    {

        $shiftsThatNeed = array();
        if ($request->filter['shift']['shift_1'] == 'true') {
            array_push($shiftsThatNeed, '1');
        }
        if ($request->filter['shift']['shift_2'] == 'true') {
            array_push($shiftsThatNeed, '2');
        }
        if ($request->filter['shift']['shift_3'] == 'true') {
            array_push($shiftsThatNeed, '3');
        }
        $activationsThatNeed = array();
        if ($request->filter['activation']['online'] == 'true') {
            array_push($activationsThatNeed, 1);
        }
        if ($request->filter['activation']['offline'] == 'true') {
            array_push($activationsThatNeed, 0);
        }

        $employee = DB::table('users')->where([
            ['name', 'LIKE', '%' . $request->filter['name'] . '%'],
        ])->whereIn('shift', $shiftsThatNeed)
            ->whereIn('online', $activationsThatNeed);


        $countOfEmployree = $employee->get()->count();
        $employee = $employee->skip($request->filter['limit'] - 25)->take(25)->get();

        return array($employee, $countOfEmployree);
    }

    public function getDataOfEmployee(Request $request)
    {
        $employee = DB::table('users')->select('name', 'email')->where('id', $request->id)->get();
        return $employee;
    }

    public function changeEmployeeShift(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $changeEmployeeShift = User::where('id', $request->id)->update([
                'shift' => $request->shift
            ]);

            $currentShift = $this->currentShift();

            $employee = User::where('id', $request->id)->get()[0];

            // To Make Sure is the Curent Shift is the Same Of that Employee who try To make Login 
            if ($currentShift != $employee->shift && $employee->online == true) {
                User::where('id', $request->id)->update([
                    'online' => false,
                    'logout' => true
                ]);
                return "employeeLoggedOut";
            } else if ($currentShift == $employee->shift) {
                User::where('id', $request->id)->update([
                    'logout' => false
                ]);
            }
        }
    }

    public function logoutEmployee(Request $request)
    {
        if ($request->ajax()) {

            User::where('id', $request->id)->update([
                'online' => false,
                'logout' => true
            ]);

            return "employeeLoggedOut";
        }
    }

    public function editEmployee(Request $request)
    {
        if ($request->ajax()) {


            $employee = User::where('id', $request->id)->first();

            $validator = $request->validate([
                'name' => ['required', new SpacialUnique($request->id)],
                'email' => ['required', 'email', new SpacialUnique($request->id)],
                'password' => [new Password]
            ]);

            //If Name Of Employee Is Changed You Must change Employee_name From all Of Sheetes That used For whatching What he is doing
            if ($employee->name != $request->name) {
                $drowings = DB::table('drowings')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $strandings = DB::table('strandings')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $insulations = DB::table('insulations')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $screens = DB::table('screens')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $assemblys = DB::table('assemblys')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $beddings = DB::table('beddings')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $armourings = DB::table('armourings')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $taps = DB::table('taps')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
                $sheathings = DB::table('sheathings')->where('employee_name', $employee->name)->update(['employee_name' => $request->name]);
            }

            User::where('id', $request->id)->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);


            if ($request->password != null) {
                User::where('id', $request->id)->update([
                    'password' => Hash::make($request->password)
                ]);
            }

            $employee = DB::table('users')->where('id', $request->id)->first();

            return (array)$employee;
        }
    }

    public function deleteEmployee(Request $request)
    {
        if ($request->ajax()) {
            $deleteEmployee = DB::table('users')->where('id', $request->id)->delete();
            //After Delete Employee You Have TO Delete Sheetes Of This Employee That used For whatching What he is doing 
            $drowings = DB::table('drowings')->where('employee_name', $request->name)->delete();
            $strandings = DB::table('strandings')->where('employee_name', $request->name)->delete();
            $insulations = DB::table('insulations')->where('employee_name', $request->name)->delete();
            $screens = DB::table('screens')->where('employee_name', $request->name)->delete();
            $assemblys = DB::table('assemblys')->where('employee_name', $request->name)->delete();
            $beddings = DB::table('beddings')->where('employee_name', $request->name)->delete();
            $armourings = DB::table('armourings')->where('employee_name', $request->name)->delete();
            $taps = DB::table('taps')->where('employee_name', $request->name)->delete();
            $sheathings = DB::table('sheathings')->where('employee_name', $request->name)->delete();
        }
    }
}
