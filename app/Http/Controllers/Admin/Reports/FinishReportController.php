<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Finish;
use App\FinishTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinishReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function FinishReport()
    {
        return view('Admin.Reports.Finish_Report');
    }

    public $request;

    public function getDataFinish(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('finish')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                    ['length', 'LIKE', '%' . $request->filter['length'] . '%']
                ])->where(function ($query) {
                    if ($this->request->filter['notes'] == 'true') {
                        $query->where('notes', '!=', '');
                    }
                })->whereBetween('created_at', [$from, $to]);

                $countOfReportsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('finish')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                    ['length', 'LIKE', '%' . $request->filter['length'] . '%']
                ])->where(function ($query) {
                    if ($this->request->filter['notes'] == 'true') {
                        $query->where('notes', '!=', '');
                    }
                })->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                $dataTime = DB::table('finishtimes')->whereIn('finish_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfReportsRows);
            } else {
                $data = DB::table('finish')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                    ['length', 'LIKE', '%' . $request->filter['length'] . '%']
                ])->where(function ($query) {
                    if ($this->request->filter['notes'] == 'true') {
                        $query->where('notes', '!=', '');
                    }
                });

                $countOfReportsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('finish')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                    ['length', 'LIKE', '%' . $request->filter['length'] . '%']
                ])->where(function ($query) {
                    if ($this->request->filter['notes'] == 'true') {
                        $query->where('notes', '!=', '');
                    }
                })->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                $dataTime = DB::table('finishtimes')->whereIn('finish_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfReportsRows);
            }
        }
    }

    public function getRowToEditDataFinish(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('finish')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('finishtimes')->where('finish_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editDataFinish(Request $request)
    {
        if ($request->ajax()) {
           
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            $rowDataFinish = Finish::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'drumNumber' => $request->drumNumber[0],
                    'length' => $request->length[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataFinishTime = FinishTime::where('finish_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'drumNumber_time' => $request->drumNumber[1],
                    'length_time' => $request->length[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $finishReport = DB::table('finish')->where('id', $request->id)->first();
            $finishTimeReport = DB::table('finishtimes')->where('finish_id', $request->id)->first();

            return array($finishReport, $finishTimeReport);
        }
    }

    public function deleteDataFinish(Request $request)
    {
        if ($request->ajax()) {

            $deleteFinishTimeRow = DB::table('finishtimes')->where('finish_id', $request->rowId)->delete();
            $deleteFinishRow = DB::table('finish')->where('id', $request->rowId)->delete();
        }
    }

    public function printData(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataFinish($request);
        }
    }
}
