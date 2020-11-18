<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\Http\Controllers\Controller;
use App\InsulationActual;
use App\InsulationStandard;
use App\InsulationStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowInsulationStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardInsulation()
    {
        return view('Admin.ShowData.Standard.show_standard_insulation');
    }

    public function getStandardInsulation(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('insulationstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['materialStandard', 'LIKE', '%' . $request->filter['materialStandard'] . '%'],
                    ['colorStandard', 'LIKE', '%' . $request->filter['colorStandard'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['masterPatch', 'LIKE', '%' . $request->filter['masterPatch'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('insulationstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['materialStandard', 'LIKE', '%' . $request->filter['materialStandard'] . '%'],
                    ['colorStandard', 'LIKE', '%' . $request->filter['colorStandard'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['masterPatch', 'LIKE', '%' . $request->filter['masterPatch'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('insulationstandardstimes')->whereIn('insulationstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('insulationstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['materialStandard', 'LIKE', '%' . $request->filter['materialStandard'] . '%'],
                    ['colorStandard', 'LIKE', '%' . $request->filter['colorStandard'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['masterPatch', 'LIKE', '%' . $request->filter['masterPatch'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('insulationstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['materialStandard', 'LIKE', '%' . $request->filter['materialStandard'] . '%'],
                    ['colorStandard', 'LIKE', '%' . $request->filter['colorStandard'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['masterPatch', 'LIKE', '%' . $request->filter['masterPatch'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('insulationstandardstimes')->whereIn('insulationstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardInsulation(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('insulationstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('insulationstandardstimes')->where('insulationstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardInsulation(Request $request)
    {
        if ($request->ajax()) {
            
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;
           
            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('insulationstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('insulationactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('insulationactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataInsulation = InsulationStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'cableSize' => $request->cableSize[0],
                    'cableDescription' => $request->cableDescription[0],
                    'volt' => $request->volt[0],
                    'thicknessMinStandard' => $request->thicknessMinStandard[0],
                    'thicknessNomStandard' => $request->thicknessNomStandard[0],
                    'thicknessMaxStandard' => $request->thicknessMaxStandard[0],
                    'eccentricityStandard' => $request->eccentricityStandard[0],
                    'outerDim' => $request->outerDim[0],
                    'ovalityStandard' => $request->ovalityStandard[0],
                    'materialStandard' => $request->materialStandard[0],
                    'colorStandard' => $request->colorStandard[0],
                    'sparkStandard' => $request->sparkStandard[0],
                    'weightStandard' => $request->weightStandard[0],
                    'masterPatch' => $request->masterPatch[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataInsulationTime = InsulationStandardsTimes::where('insulationstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'cableSize_time' => $request->cableSize[1],
                    'cableDescription_time' => $request->cableDescription[1],
                    'volt_time' => $request->volt[1],
                    'thicknessMinStandard_time' => $request->thicknessMinStandard[1],
                    'thicknessNomStandard_time' => $request->thicknessNomStandard[1],
                    'thicknessMaxStandard_time' => $request->thicknessMaxStandard[1],
                    'eccentricityStandard_time' => $request->eccentricityStandard[1],
                    'outerDim_time' => $request->outerDim[1],
                    'ovalityStandard_time' => $request->ovalityStandard[1],
                    'materialStandard_time' => $request->materialStandard[1],
                    'colorStandard_time' => $request->colorStandard[1],
                    'sparkStandard_time' => $request->sparkStandard[1],
                    'weightStandard_time' => $request->weightStandard[1],
                    'masterPatch_time' => $request->masterPatch[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $insulationStandard = DB::table('insulationstandards')->where('id', $request->id)->first();
            $insulationStandardTime = DB::table('insulationstandardstimes')->where('insulationstandards_id', $request->id)->first();

            return array($insulationStandard, $insulationStandardTime);
        }
    }
}
