<?php

namespace App\Http\Controllers\Admin\ShowData\Standard;

use App\DrowingStandard;
use App\DrowingStandardsTimes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowDrowingStandardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showStandardDrowing()
    {
        return view('Admin.ShowData.Standard.show_standard_drowing');
    }

    public function getStandardDrowing(Request $request)
    {
        if ($request->ajax()) {

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {
                $data = DB::table('drowingstandards')->where([
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                ])->whereBetween('created_at', [$from, $to]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('drowingstandards')->select('id')->where([
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                ])->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('drowingstandardstimes')->whereIn('drowingstandards_id', $dataIdAsArray)->get();
                return array($dataLimit, $dataTime, $countOfStandardsRows);
            } else {
                $data = DB::table('drowingstandards')->where([
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                ]);

                $countOfStandardsRows = $data->get()->count();
                $dataLimit = $data->skip($request->filter['limit'] - 25)->take(25)->get();

                $dataIdAsArray = DB::table('drowingstandards')->select('id')->where([
                    ['jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                    ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                    ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                    ['size', 'LIKE', '%' . $request->filter['size'] . '%'],
                    ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                ])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                $dataTime = DB::table('drowingstandardstimes')->whereIn('drowingstandards_id', $dataIdAsArray)->get();

                return array($dataLimit, $dataTime, $countOfStandardsRows);
            }
        }
    }

    public function getRowToEditStandardDrowing(Request $request)
    {
        if ($request->ajax()) {

            $data = DB::table('drowingstandards')->where('id', $request->rowId)->get()[0];
            $dataTime = DB::table('drowingstandardstimes')->where('drowingstandards_id', $request->rowId)->get()[0];

            return array($data, $dataTime);
        }
    }

    public function editStandardDrowing(Request $request)
    {
        if ($request->ajax()) {

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //Before Change JopOrderNumber You Have To Change jopOrderNumber From Every Actual Linking With This Standard
            $currentJopOrderNumber = DB::table('drowingstandards')->where('id', '=', $request->id)->value('jopOrderNumber');
            if ($currentJopOrderNumber != $request->jopOrderNumber[0]) {
                //Get Actuals That Linking With This Standard And Update JopOrderNumber
                $actuals = DB::table('drowingactuals')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
                $actualstimes = DB::table('drowingactualstimes')->where('jopOrderNumber', $currentJopOrderNumber)->update(['jopOrderNumber' => $request->jopOrderNumber[0]]);
            }

            $rowDataDrowing = DrowingStandard::where('id', '=', $request->id)
                ->update([
                    'jopOrderNumber' => $request->jopOrderNumber[0],
                    'wireDimMinStandard' => $request->wireDimMinStandard[0],
                    'wireDimNomStandard' => $request->wireDimNomStandard[0],
                    'wireDimMaxStandard' => $request->wireDimMaxStandard[0],
                    'size' => $request->size[0],
                    'volt' => $request->volt[0],
                    'elongationStandard' => $request->elongationStandard[0],
                    'tensileStandard' => $request->tensileStandard[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataDrowingTime = DrowingStandardsTimes::where('drowingstandards_id', '=', $request->id)
                ->update([
                    'jopOrderNumber_time' => $request->jopOrderNumber[1],
                    'wireDimMinStandard_time' => $request->wireDimMinStandard[1],
                    'wireDimNomStandard_time' => $request->wireDimNomStandard[1],
                    'wireDimMaxStandard_time' => $request->wireDimMaxStandard[1],
                    'size_time' => $request->size[0],
                    'volt_time' => $request->volt[0],
                    'elongationStandard_time' => $request->elongationStandard[0],
                    'tensileStandard_time' => $request->tensileStandard[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $drowingStandard = DB::table('drowingstandards')->where('id', $request->id)->first();
            $drowingStandardTime = DB::table('drowingstandardstimes')->where('drowingstandards_id', $request->id)->first();

            return array($drowingStandard, $drowingStandardTime);
        }
    }
}
