<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\Http\Controllers\Controller;
use App\ScreenStandard;
use App\ScreenStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowScreenStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardScreen()
    {
        return view('Admin.ShowData.Standard.show_standard_screen');
    }

    public function getStandardScreen(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('screenstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size_type', 'LIKE', '%' . $request->filter['size_type'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('screenstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size_type', 'LIKE', '%' . $request->filter['size_type'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('screenstandardstimes')->whereIn('screenstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('screenstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size_type', 'LIKE', '%' . $request->filter['size_type'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('screenstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size_type', 'LIKE', '%' . $request->filter['size_type'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('screenstandardstimes')->whereIn('screenstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardScreen(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('screenstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('screenstandardstimes')->where('screenstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardScreen(Request $request)
    {
        if ($request->ajax()) {
            
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('screenstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('screenactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('screenactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataScreen = ScreenStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'size_type' => $request->size_type[0],
                    'volt' => $request->volt[0],
                    'overLapStandard' => $request->overLapStandard[0],
                    'outerDiameter' => $request->outerDiameter[0],
                    'numberOfWire_wireDim' => $request->numberOfWire_wireDim[0],
                    'tape_wire_weight' => $request->tape_wire_weight[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataScreenTime = ScreenStandardsTimes::where('screenstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'size_type_time' => $request->size_type[1],
                    'volt_time' => $request->volt[1],
                    'overLapStandard_time' => $request->overLapStandard[1],
                    'outerDiameter_time' => $request->outerDiameter[1],
                    'numberOfWire_wireDim_time' => $request->numberOfWire_wireDim[1],
                    'tape_wire_weight_time' => $request->tape_wire_weight[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $screenStandard = DB::table('screenstandards')->where('id', $request->id)->first();
            $screenStandardTime = DB::table('screenstandardstimes')->where('screenstandards_id', $request->id)->first();

            return array($screenStandard, $screenStandardTime);
        }
    }
}
