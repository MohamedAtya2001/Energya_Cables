<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\AssemblyStandard;
use App\AssemblyStandardsTimes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowAssemblyStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardAssembly()
    {
        return view('Admin.ShowData.Standard.show_standard_assembly');
    }

    public function getStandardAssembly(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('assemblystandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('assemblystandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('assemblystandardstimes')->whereIn('assemblystandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('assemblystandards')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('assemblystandards')->select('id')->where([
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%']
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('assemblystandardstimes')->whereIn('assemblystandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardAssembly(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('assemblystandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('assemblystandardstimes')->where('assemblystandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardAssembly(Request $request)
    {
        if ($request->ajax()) {

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('assemblystandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('assemblyactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('assemblyactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }


            $rowDataAssembly = AssemblyStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'cableSize' => $request->cableSize[0],
                    'cableDescription' => $request->cableDescription[0],
                    'outerDimMinStandard' => $request->outerDimMinStandard[0],
                    'outerDimNomStandard' => $request->outerDimNomStandard[0],
                    'outerDimMaxStandard' => $request->outerDimMaxStandard[0],
                    'fillerStandard' => $request->fillerStandard[0],
                    'twistedStandard' => $request->twistedStandard[0],
                    'overLap' => $request->overLap[0],
                    'ovalityStandard' => $request->ovalityStandard[0],
                    'layLengthStandard' => $request->layLengthStandard[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataAssemblyTime = AssemblyStandardsTimes::where('assemblystandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'cableSize_time' => $request->cableSize[1],
                    'cableDescription_time' => $request->cableDescription[1],
                    'outerDimMinStandard_time' => $request->outerDimMinStandard[1],
                    'outerDimNomStandard_time' => $request->outerDimNomStandard[1],
                    'outerDimMaxStandard_time' => $request->outerDimMaxStandard[1],
                    'fillerStandard_time' => $request->fillerStandard[1],
                    'twistedStandard_time' => $request->twistedStandard[1],
                    'overLap_time' => $request->overLap[1],
                    'ovalityStandard_time' => $request->ovalityStandard[1],
                    'layLengthStandard_time' => $request->layLengthStandard[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $assemblyStandard = DB::table('assemblystandards')->where('id', $request->id)->first();
            $assemblyStandardTime = DB::table('assemblystandardstimes')->where('assemblystandards_id', $request->id)->first();

            return array($assemblyStandard, $assemblyStandardTime);
        }
    }
}
