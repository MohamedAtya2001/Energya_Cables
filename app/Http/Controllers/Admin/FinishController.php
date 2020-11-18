<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Finish;
use App\FinishTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
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

    public function insertFinish(Request $request)
    {

        if ($request->ajax()) {

            $shift = 'shift ' . $this->currentShift();

            $checkJopOrderNumber = DB::table('drowingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

            //To Check About "who did make insert ?"
            $name = Auth::guard('admin')->user()->name;

            // To Add New Finish
            $finish = new Finish();
            $finish->jopOrderNumber = $request->jopOrderNumber[0];
            $finish->drumNumber = $request->drumNumber[0];
            $finish->length = $request->length[0];
            $finish->notes = $request->notes[0];
            $finish->added_by = $name;
            $finish->shift = $shift;
            $finish->save();

            // To Add New FinishTime
            $finishTime = new FinishTime();
            $finishTime->finish_id = $finish->id;
            $finishTime->jopOrderNumber_time = $request->jopOrderNumber[1];
            $finishTime->drumNumber_time = $request->drumNumber[1];
            $finishTime->length_time = $request->length[1];
            $finishTime->notes_time = $request->notes[1];
            $finishTime->added_by = $name;
            $finishTime->shift = $shift;
            $finishTime->save();



            // return $request;

        }
    }
}
