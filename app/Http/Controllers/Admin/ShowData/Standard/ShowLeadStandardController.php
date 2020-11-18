<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\Http\Controllers\Controller;
use App\LeadStandard;
use App\LeadStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowLeadStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardLead()
    {
        return view('Admin.ShowData.Standard.show_standard_lead');
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

    public function getStandardLead(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('leadstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('leadstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('leadstandardstimes')->whereIn('leadstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('leadstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('leadstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['weightStandard', 'LIKE', '%' . $request->filter['weightStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('leadstandardstimes')->whereIn('leadstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardLead(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('leadstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('leadstandardstimes')->where('leadstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardLead(Request $request)
    {
        if ($request->ajax()) {

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('leadstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('leadactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('leadactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataLead = LeadStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'size' => $request->size[0],
                    'description' => $request->description[0],
                    'volt' => $request->volt[0],
                    'thicknessMinStandard' => $request->thicknessMinStandard[0],
                    'thicknessNomStandard' => $request->thicknessNomStandard[0],
                    'thicknessMaxStandard' => $request->thicknessMaxStandard[0],
                    'dimAfter' => $request->dimAfter[0],
                    'weightStandard' => $request->weightStandard[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataLeadTime = LeadStandardsTimes::where('leadstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'size_time' => $request->size[1],
                    'description_time' => $request->description[1],
                    'volt_time' => $request->volt[1],
                    'thicknessMinStandard_time' => $request->thicknessMinStandard[1],
                    'thicknessNomStandard_time' => $request->thicknessNomStandard[1],
                    'thicknessMaxStandard_time' => $request->thicknessMaxStandard[1],
                    'dimAfter_time' => $request->dimAfter[1],
                    'weightStandard_time' => $request->weightStandard[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $leadStandard = DB::table('leadstandards')->where('id', $request->id)->first();
            $leadStandardTime = DB::table('leadstandardstimes')->where('leadstandards_id', $request->id)->first();

            return array($leadStandard, $leadStandardTime);
        }
    }
}
