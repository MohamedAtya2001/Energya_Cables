<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Hold;
use App\HoldTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HoldController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
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

    // Function checkEmployeeShift return true if the curentShift Equal EmployeeShift
    public function checkEmployeeShift()
    {
        $currentShift = $this->currentShift();
        if (Auth::user()->logout == false && Auth::user()->shift == $currentShift) {
            return true;
        } else {
            DB::table('users')->where('id', Auth::user()->id)->update([
                'online' => false
            ]);
            Auth::logout();
            return false;
        }
    }

    public function insertHold(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            $shift = 'shift ' . $this->currentShift();

            //To Check About "who did make insert ?"
            $name = Auth::guard('web')->user()->name;

            // To Add New Hold
            $hold = new Hold();
            $hold->jopOrderNumber = $request->jopOrderNumber[0];
            $hold->drumNumber = $request->drumNumber[0];
            $hold->cableSize = $request->cableSize[0];
            $hold->length = $request->length[0];
            $hold->description = $request->description[0];
            $hold->machine = $request->machine[0];
            $hold->reasonOfHold = $request->reasonOfHold[0];
            $hold->fromSheet = '';
            $hold->added_by = $name;
            $hold->shift = $shift;
            $hold->save();

            // To Add New HoldTime
            $holdTime = new HoldTime();
            $holdTime->hold_id = $hold->id;
            $holdTime->jopOrderNumber_time = $request->jopOrderNumber[1];
            $holdTime->drumNumber_time = $request->drumNumber[1];
            $holdTime->cableSize_time = $request->cableSize[1];
            $holdTime->length_time = $request->length[1];
            $holdTime->description_time = $request->description[1];
            $holdTime->machine_time = $request->machine[1];
            $holdTime->reasonOfHold_time = $request->reasonOfHold[1];
            $holdTime->fromSheet_time = '';
            $holdTime->added_by = $name;
            $holdTime->shift = $shift;
            $holdTime->save();

            // return $request;

        }
    }
}
