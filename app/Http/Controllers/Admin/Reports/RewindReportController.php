<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Rewind;
use App\RewindTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewindReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function RewindReport()
    {
        return view('Admin.Reports.Rewind_Report');
    }

    public function getDataRewind(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('rewind')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                    ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                    ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                    ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                    ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                    ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfReportsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('rewind')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                    ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                    ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                    ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                    ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                    ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                $dataTime = DB::table('rewindtimes')->whereIn('rewind_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfReportsRows);
            } else {
                $data = DB::table('rewind')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                    ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                    ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                    ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                    ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                    ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%']
                ]);

                $countOfReportsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('rewind')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                    ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                    ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                    ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                    ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                    ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                $dataTime = DB::table('rewindtimes')->whereIn('rewind_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfReportsRows);
            }
        }
    }

    public function getRowToEditDataRewind(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('rewind')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('rewindtimes')->where('rewind_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editDataRewind(Request $request)
    {
        if ($request->ajax()) {

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            $rowDataRewind = Rewind::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputLength[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputLength[0],
                    'reasonOfRewind' => $request->reasonOfRewind[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataRewindTime = RewindTime::where('rewind_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputLength[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputLength[1],
                    'reasonOfRewind_time' => $request->reasonOfRewind[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rewindReport = DB::table('rewind')->where('id', $request->id)->first();
            $rewindTimeReport = DB::table('rewindtimes')->where('rewind_id', $request->id)->first();

            return array($rewindReport, $rewindTimeReport);
        }
    }

    public function deleteDataRewind(Request $request)
    {
        if ($request->ajax()) {

            $deleteRewindTimeRow = DB::table('rewindtimes')->where('rewind_id', $request->rowId)->delete();
            $deleteRewindRow = DB::table('rewind')->where('id', $request->rowId)->delete();
        }
    }

    public function printData(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataRewind($request);
        }
    }
}
