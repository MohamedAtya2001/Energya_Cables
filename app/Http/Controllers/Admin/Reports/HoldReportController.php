<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HoldReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function HoldReport()
    {
        return view('Admin.Reports.Hold_Report');
    }

    public function getDataHold(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != '' && $to != '') {
                $data = DB::table('hold')->where([
                    ['released', ($request->filter['released'] == 'released') ? true : false],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                ])->whereBetween('created_at', [$from, $to]);

                $countOfReportsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('hold')->select('id')->where([
                    ['released', ($request->filter['released'] == 'released') ? true : false],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('holdtimes')->whereIn('hold_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfReportsRows);
            } else {
                $data = DB::table('hold')->where([
                    ['released', ($request->filter['released'] == 'released') ? true : false],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                ]);

                $countOfReportsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('hold')->select('id')->where([
                    ['released', ($request->filter['released'] == 'released') ? true : false],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('holdtimes')->whereIn('hold_id', $dataIdAsArray)->get();

                $Hold = DB::table('hold')->get(); 
                return array($dataLimit, $dataTime, $countOfReportsRows, $Hold);
            }
        }
    }

    public function getRowToEditDataHold(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('hold')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('holdtimes')->where('hold_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editDataHold(Request $request)
    {
        if ($request->ajax()) {
          
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            $rowDataHold = Hold::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => ($request->jopOrderNumber[0] == null)? '' : $request->jopOrderNumber[0],
                    'drumNumber' => ($request->drumNumber[0] == null)? '' : $request->drumNumber[0],
                    'cableSize' => ($request->cableSize[0] == null)? '' : $request->cableSize[0],
                    'length' => ($request->length[0] == null)? '' : $request->length[0],
                    'description' => ($request->description[0] == null)? '' : $request->description[0],
                    'machine' => ($request->machine[0] == null)? '' : $request->machine[0],
                    'reasonOfHold' => ($request->reasonOfHold[0] == null)? '' : $request->reasonOfHold[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataHoldTime = HoldTime::where('hold_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => ($request->jopOrderNumber[1] == null)? '' : $request->jopOrderNumber[1],
                    'drumNumber_time' => ($request->drumNumber[1] == null)? '' : $request->drumNumber[1],
                    'cableSize_time' => ($request->cableSize[1] == null)? '' : $request->cableSize[1],
                    'length_time' => ($request->length[1] == null)? '' : $request->length[1],
                    'description_time' => ($request->description[1] == null)? '' : $request->description[1],
                    'machine_time' => ($request->machine[1] == null)? '' : $request->machine[1],
                    'reasonOfHold_time' => ($request->reasonOfHold[1] == null)? '' : $request->reasonOfHold[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $holdReport = DB::table('hold')->where('id', $request->id)->first();
            $holdTimeReport = DB::table('holdtimes')->where('hold_id', $request->id)->first();

            return array($holdReport, $holdTimeReport);
        }
    }

    public function deleteDataHold(Request $request)
    {
        if ($request->ajax()) {

            $deleteHoldTimeRow = DB::table('holdtimes')->where('hold_id', $request->rowId)->delete();
            $deleteHoldRow = DB::table('hold')->where('id', $request->rowId)->delete();
        }
    }

    public function printData(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataHold($request);
        }
    }

    public function releaseHold(Request $request)
    {
        date_default_timezone_set('Africa/Cairo');

        $releasedHold = DB::table('hold')->where('id', $request->rowId)->update([
            'released' => true,
            'released_by' => Auth::guard('admin')->user()->name
        ]);

        $releasedHoldTime = DB::table('holdtimes')->where('id', $request->rowId)->update([
            'released_time' => date('Y-m-d, h:m:s A')
        ]);
    }
}
