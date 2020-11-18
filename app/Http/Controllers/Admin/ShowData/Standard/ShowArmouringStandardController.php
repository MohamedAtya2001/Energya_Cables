<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\ArmouringStandard;
use App\ArmouringStandardsTimes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowArmouringStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardArmouring()
    {
        return view('Admin.ShowData.Standard.show_standard_armouring');
    }

    public function getStandardArmouring(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('armouringstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('armouringstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('armouringstandardstimes')->whereIn('armouringstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('armouringstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('armouringstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('armouringstandardstimes')->whereIn('armouringstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardArmouring(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('armouringstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('armouringstandardstimes')->where('armouringstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardArmouring(Request $request)
    {
        if ($request->ajax()) {
           
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('armouringstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('armouringactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('armouringactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataArmouring = ArmouringStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'cableSize' => $request->cableSize[0],
                    'volt' => $request->volt[0],
                    'outerDiameter' => $request->outerDiameter[0],
                    'overGapStandard' => $request->overGapStandard[0],
                    'ovalityStandard' => $request->ovalityStandard[0],
                    'tapeDimention' => $request->tapeDimention[0],
                    'numberOfWire_wireDim' => $request->numberOfWire_wireDim[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataArmouringTime = ArmouringStandardsTimes::where('armouringstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'cableSize_time' => $request->cableSize[1],
                    'volt_time' => $request->volt[1],
                    'outerDiameter_time' => $request->outerDiameter[1],
                    'overGapStandard_time' => $request->overGapStandard[1],
                    'ovalityStandard_time' => $request->ovalityStandard[1],
                    'tapeDimention_time' => $request->tapeDimention[1],
                    'numberOfWire_wireDim_time' => $request->numberOfWire_wireDim[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $armouringStandard = DB::table('armouringstandards')->where('id', $request->id)->first();
            $armouringStandardTime = DB::table('armouringstandardstimes')->where('armouringstandards_id', $request->id)->first();

            return array($armouringStandard, $armouringStandardTime);
        }
    }
}
