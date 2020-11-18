<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\Http\Controllers\Controller;
use App\TapsStandard;
use App\TapsStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowTapsStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardTaps()
    {
        return view('Admin.ShowData.Standard.show_standard_taps');
    }

    public function getStandardTaps(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('tapsstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['tapeWeightStandard', 'LIKE', '%' . $request->filter['tapeWeightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('tapsstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['tapeWeightStandard', 'LIKE', '%' . $request->filter['tapeWeightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('tapsstandardstimes')->whereIn('tapsstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('tapsstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['tapeWeightStandard', 'LIKE', '%' . $request->filter['tapeWeightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('tapsstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['tapeWeightStandard', 'LIKE', '%' . $request->filter['tapeWeightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('tapsstandardstimes')->whereIn('tapsstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardTaps(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('tapsstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('tapsstandardstimes')->where('tapsstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardTaps(Request $request)
    {
        if ($request->ajax()) {
          
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('tapsstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('tapsactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('tapsactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataTaps = TapsStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'cableSize' => $request->cableSize[0],
                    'volt' => $request->volt[0],
                    'overLapStandard' => $request->overLapStandard[0],
                    'tapeDimentionStandard' => $request->tapeDimentionStandard[0],
                    'outerDiameter' => $request->outerDiameter[0],
                    'tapeWeightStandard' => $request->tapeWeightStandard[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataTapsTime = TapsStandardsTimes::where('tapsstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'cableSize_time' => $request->cableSize[1],
                    'volt_time' => $request->volt[1],
                    'overLapStandard_time' => $request->overLapStandard[1],
                    'tapeDimentionStandard_time' => $request->tapeDimentionStandard[1],
                    'outerDiameter_time' => $request->outerDiameter[1],
                    'tapeWeightStandard_time' => $request->tapeWeightStandard[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $tapsStandard = DB::table('tapsstandards')->where('id', $request->id)->first();
            $tapsStandardTime = DB::table('tapsstandardstimes')->where('tapsstandards_id', $request->id)->first();

            return array($tapsStandard, $tapsStandardTime);
        }
    }
}
