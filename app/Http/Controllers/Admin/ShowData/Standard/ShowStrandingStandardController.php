<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\Http\Controllers\Controller;
use App\StrandingStandard;
use App\StrandingStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowStrandingStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardStranding()
    {
        return view('Admin.ShowData.Standard.show_standard_stranding');
    }

    public function getStandardStranding(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('strandingstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['type', 'LIKE', '%' . $request->filter['type'] . '%'],
                    ['conductorWeightStandard', 'LIKE', '%' . $request->filter['conductorWeightStandard'] . '%'],
                    ['constructionStandard', 'LIKE', '%' . $request->filter['constructionStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('strandingstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['type', 'LIKE', '%' . $request->filter['type'] . '%'],
                    ['conductorWeightStandard', 'LIKE', '%' . $request->filter['conductorWeightStandard'] . '%'],
                    ['constructionStandard', 'LIKE', '%' . $request->filter['constructionStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('strandingstandardstimes')->whereIn('strandingstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('strandingstandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['type', 'LIKE', '%' . $request->filter['type'] . '%'],
                    ['conductorWeightStandard', 'LIKE', '%' . $request->filter['conductorWeightStandard'] . '%'],
                    ['constructionStandard', 'LIKE', '%' . $request->filter['constructionStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('strandingstandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['type', 'LIKE', '%' . $request->filter['type'] . '%'],
                    ['conductorWeightStandard', 'LIKE', '%' . $request->filter['conductorWeightStandard'] . '%'],
                    ['constructionStandard', 'LIKE', '%' . $request->filter['constructionStandard'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('strandingstandardstimes')->whereIn('strandingstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardStranding(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('strandingstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('strandingstandardstimes')->where('strandingstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardStranding(Request $request)
    {
        if ($request->ajax()) {
          
            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('strandingstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('strandingactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('strandingactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataStranding = StrandingStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'size' => $request->size[0],
                    'type' => $request->type[0],
                    'volt' => $request->volt[0],
                    'conductorDimStandard' => $request->conductorDimStandard[0],
                    'preformingLayStandard' => $request->preformingLayStandard[0],
                    'waterBlockingTapStandard' => $request->waterBlockingTapStandard[0],
                    'TDS_number' => $request->TDS_number[0],
                    'conductorWeightStandard' => $request->conductorWeightStandard[0],
                    'resistance' => $request->resistance[0],
                    'constructionStandard' => $request->constructionStandard[0],
                    'layLengthStandard' => $request->layLengthStandard[0],
                    'powder_grease_weightStandard' => $request->powder_grease_weightStandard[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataStrandingTime = StrandingStandardsTimes::where('strandingstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'size_time' => $request->size[1],
                    'type_time' => $request->type[1],
                    'volt_time' => $request->volt[1],
                    'conductorDimStandard_time' => $request->conductorDimStandard[1],
                    'preformingLayStandard_time' => $request->preformingLayStandard[1],
                    'waterBlockingTapStandard_time' => $request->waterBlockingTapStandard[1],
                    'TDS_number_time' => $request->TDS_number[1],
                    'conductorWeightStandard_time' => $request->conductorWeightStandard[1],
                    'resistance_time' => $request->resistance[1],
                    'constructionStandard_time' => $request->constructionStandard[1],
                    'layLengthStandard_time' => $request->layLengthStandard[1],
                    'powder_grease_weightStandard_time' => $request->powder_grease_weightStandard[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $strandingStandard = DB::table('strandingstandards')->where('id', $request->id)->first();
            $strandingStandardTime = DB::table('strandingstandardstimes')->where('strandingstandards_id', $request->id)->first();

            return array($strandingStandard, $strandingStandardTime);
        }
    }
}
