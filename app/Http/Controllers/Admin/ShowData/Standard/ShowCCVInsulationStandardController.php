<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\CCVInsulationStandard;
use App\CCVInsulationStandardsTimes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowCCVInsulationStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardCCVInsulation()
    {
        return view('Admin.ShowData.Standard.show_standard_CCVInsulation');
    }

    public function getStandardCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('ccvinsulationstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('ccvinsulationstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('ccvinsulationstandardstimes')->whereIn('ccvinsulationstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('ccvinsulationstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('ccvinsulationstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('ccvinsulationstandardstimes')->whereIn('ccvinsulationstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('ccvinsulationstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('ccvinsulationstandardstimes')->where('ccvinsulationstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('ccvinsulationstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('ccvinsulationactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('ccvinsulationactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataCCVInsulation = CCVInsulationStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'size' => $request->size[0],
                    'description' => $request->description[0],
                    'thicknessMinISC' => $request->thicknessMinISC[0],
                    'thicknessMinINS' => $request->thicknessMinINS[0],
                    'thicknessMinOSC' => $request->thicknessMinOSC[0],
                    'thicknessNomISC' => $request->thicknessNomISC[0],
                    'thicknessNomINS' => $request->thicknessNomINS[0],
                    'thicknessNomOSC' => $request->thicknessNomOSC[0],
                    'dimAfter' => $request->dimAfter[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataCCVInsulationTime = CCVInsulationStandardsTimes::where('ccvinsulationstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'size_time' => $request->size[1],
                    'description_time' => $request->description[1],
                    'thicknessMinISC_time' => $request->thicknessMinISC[1],
                    'thicknessMinINS_time' => $request->thicknessMinINS[1],
                    'thicknessMinOSC_time' => $request->thicknessMinOSC[1],
                    'thicknessNomISC_time' => $request->thicknessNomISC[1],
                    'thicknessNomINS_time' => $request->thicknessNomINS[1],
                    'thicknessNomOSC_time' => $request->thicknessNomOSC[1],
                    'dimAfter_time' => $request->dimAfter[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $ccvInsulationStandard = DB::table('ccvinsulationstandards')->where('id', $request->id)->first();
            $ccvInsulationStandardTime = DB::table('ccvinsulationstandardstimes')->where('ccvinsulationstandards_id', $request->id)->first();

            return array($ccvInsulationStandard, $ccvInsulationStandardTime);
        }
    }
}
