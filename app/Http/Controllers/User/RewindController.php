<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Rewind;
use App\RewindTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewindController extends Controller
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

    public function insertRewind(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            $shift = 'shift ' . $this->currentShift();

            //To Check About "who did make insert ?"
            $name = Auth::guard('web')->user()->name;

            // To Add New Rewind
            $rewind = new Rewind();
            $rewind->jopOrderNumber = $request->jopOrderNumber[0];
            $rewind->inputDrum = $request->inputDrum[0];
            $rewind->inputCard = $request->inputCard[0];
            $rewind->inputLength = $request->inputLength[0];
            $rewind->outputDrum = $request->outputDrum[0];
            $rewind->outputCard = $request->outputCard[0];
            $rewind->outputLength = $request->outputLength[0];
            $rewind->reasonOfRewind = $request->reasonOfRewind[0];
            $rewind->added_by = $name;
            $rewind->shift = $shift;
            $rewind->save();

            // To Add New RewindTime
            $rewindTime = new RewindTime();
            $rewindTime->rewind_id = $rewind->id;
            $rewindTime->jopOrderNumber_time = $request->jopOrderNumber[1];
            $rewindTime->inputDrum_time = $request->inputDrum[1];
            $rewindTime->inputCard_time = $request->inputCard[1];
            $rewindTime->inputLength_time = $request->inputLength[1];
            $rewindTime->outputDrum_time = $request->outputDrum[1];
            $rewindTime->outputCard_time = $request->outputCard[1];
            $rewindTime->outputLength_time = $request->outputLength[1];
            $rewindTime->reasonOfRewind_time = $request->reasonOfRewind[1];
            $rewindTime->added_by = $name;
            $rewindTime->shift = $shift;
            $rewindTime->save();



            // return $request;

        }
    }
}
