<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\CCVInsulationActual;
use App\CCVInsulationActualsTimes;
use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowCCVInsulationActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataCCVInsulation()
    {
        return view('Admin.ShowData.Actual.show_actual_CCVInsulation');
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

    public $request;

    public function getDataCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $checkJopOrderNumber = DB::table('ccvinsulationstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('ccvinsulationstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('ccvinsulationactuals')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessISCStartMin', '!=', null],
                            ['thicknessINSStartMin', '!=', null],
                            ['thicknessOSCStartMin', '!=', null],
                            ['thicknessISCEndMin', '!=', null],
                            ['thicknessINSEndMin', '!=', null],
                            ['thicknessOSCEndMin', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null]
                        ])->where(function ($query) {
                            if ($this->request->filter['notes'] == 'true') {
                                $query->where('notes', '!=', '');
                            }
                        })->where(function ($query) {
                            if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                $query->where('status', 'hold');
                            } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'pass');
                            } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'hold')
                                    ->orWhere('status', 'pass');
                            }
                        })->whereBetween('created_at', [$from, $to]);

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('ccvinsulationactuals')->select('id')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessISCStartMin', '!=', null],
                            ['thicknessINSStartMin', '!=', null],
                            ['thicknessOSCStartMin', '!=', null],
                            ['thicknessISCEndMin', '!=', null],
                            ['thicknessINSEndMin', '!=', null],
                            ['thicknessOSCEndMin', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null]
                        ])->where(function ($query) {
                            if ($this->request->filter['notes'] == 'true') {
                                $query->where('notes', '!=', '');
                            }
                        })->where(function ($query) {
                            if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                $query->where('status', 'hold');
                            } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'pass');
                            } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'hold')
                                    ->orWhere('status', 'pass');
                            }
                        })->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('ccvinsulationactualstimes')->whereIn('ccvinsulationactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('ccvinsulationstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('ccvinsulationactuals')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessISCStartMin', '!=', null],
                            ['thicknessINSStartMin', '!=', null],
                            ['thicknessOSCStartMin', '!=', null],
                            ['thicknessISCEndMin', '!=', null],
                            ['thicknessINSEndMin', '!=', null],
                            ['thicknessOSCEndMin', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null]
                        ])->where(function ($query) {
                            if ($this->request->filter['notes'] == 'true') {
                                $query->where('notes', '!=', '');
                            }
                        })->where(function ($query) {
                            if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                $query->where('status', 'hold');
                            } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'pass');
                            } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'hold')
                                    ->orWhere('status', 'pass');
                            }
                        });

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('ccvinsulationactuals')->select('id')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessISCStartMin', '!=', null],
                            ['thicknessINSStartMin', '!=', null],
                            ['thicknessOSCStartMin', '!=', null],
                            ['thicknessISCEndMin', '!=', null],
                            ['thicknessINSEndMin', '!=', null],
                            ['thicknessOSCEndMin', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null]
                        ])->where(function ($query) {
                            if ($this->request->filter['notes'] == 'true') {
                                $query->where('notes', '!=', '');
                            }
                        })->where(function ($query) {
                            if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                $query->where('status', 'hold');
                            } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'pass');
                            } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                $query->where('status', 'hold')
                                    ->orWhere('status', 'pass');
                            }
                        })->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('ccvinsulationactualstimes')->whereIn('ccvinsulationactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('ccvinsulationstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();

                    $actualRows = DB::table('ccvinsulationactuals')->where('jopOrderNumber', $request->filter['jopOrderNumber'])
                        ->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('thicknessISCStartMin', null)
                        ->orWhere('thicknessINSStartMin', null)
                        ->orWhere('thicknessOSCStartMin', null)
                        ->orWhere('thicknessISCEndMin', null)
                        ->orWhere('thicknessINSEndMin', null)
                        ->orWhere('thicknessOSCEndMin', null)
                        ->orWhere('dimBefore1', null)
                        ->orWhere('dimAfterStartMin', null)
                        ->orWhere('dimAfterEndMin', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('ccvinsulationactuals')->select('id')->where('jopOrderNumber', $request->filter['jopOrderNumber'])
                        ->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('thicknessISCStartMin', null)
                        ->orWhere('thicknessINSStartMin', null)
                        ->orWhere('thicknessOSCStartMin', null)
                        ->orWhere('thicknessISCEndMin', null)
                        ->orWhere('thicknessINSEndMin', null)
                        ->orWhere('thicknessOSCEndMin', null)
                        ->orWhere('dimBefore1', null)
                        ->orWhere('dimAfterStartMin', null)
                        ->orWhere('dimAfterEndMin', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                    $actualTimeRows = DB::table('ccvinsulationactualstimes')->whereIn('ccvinsulationactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            $actualRow = DB::table('ccvinsulationactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('ccvinsulationactualstimes')->where('ccvinsulationactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            if (
                (empty($request->thicknessISCStartMin[0]) || empty($request->thicknessISCStartNom[0]) || empty($request->thicknessISCStartMax[0])) &&
                (!empty($request->thicknessISCStartMin[0]) || !empty($request->thicknessISCStartNom[0]) || !empty($request->thicknessISCStartMax[0]))
            ) {
                return 'Error-thicknessISCStart';
            }

            if (
                (empty($request->thicknessINSStartMin[0]) || empty($request->thicknessINSStartNom[0]) || empty($request->thicknessINSStartMax[0])) &&
                (!empty($request->thicknessINSStartMin[0]) || !empty($request->thicknessINSStartNom[0]) || !empty($request->thicknessINSStartMax[0]))
            ) {
                return 'Error-thicknessINSStart';
            }

            if (
                (empty($request->thicknessOSCStartMin[0]) || empty($request->thicknessOSCStartNom[0]) || empty($request->thicknessOSCStartMax[0])) &&
                (!empty($request->thicknessOSCStartMin[0]) || !empty($request->thicknessOSCStartNom[0]) || !empty($request->thicknessOSCStartMax[0]))
            ) {
                return 'Error-thicknessOSCStart';
            }

            if (
                (empty($request->thicknessISCEndMin[0]) || empty($request->thicknessISCEndNom[0]) || empty($request->thicknessISCEndMax[0])) &&
                (!empty($request->thicknessISCEndMin[0]) || !empty($request->thicknessISCEndNom[0]) || !empty($request->thicknessISCEndMax[0]))
            ) {
                return 'Error-thicknessISCEnd';
            }

            if (
                (empty($request->thicknessINSEndMin[0]) || empty($request->thicknessINSEndNom[0]) || empty($request->thicknessINSEndMax[0])) &&
                (!empty($request->thicknessINSEndMin[0]) || !empty($request->thicknessINSEndNom[0]) || !empty($request->thicknessINSEndMax[0]))
            ) {
                return 'Error-thicknessINSEnd';
            }

            if (
                (empty($request->thicknessOSCEndMin[0]) || empty($request->thicknessOSCEndNom[0]) || empty($request->thicknessOSCEndMax[0])) &&
                (!empty($request->thicknessOSCEndMin[0]) || !empty($request->thicknessOSCEndNom[0]) || !empty($request->thicknessOSCEndMax[0]))
            ) {
                return 'Error-thicknessOSCEnd';
            }

            if (
                (empty($request->dimAfterStartMin[0]) || empty($request->dimAfterStartNom[0]) || empty($request->dimAfterStartMax[0])) &&
                (!empty($request->dimAfterStartMin[0]) || !empty($request->dimAfterStartNom[0]) || !empty($request->dimAfterStartMax[0]))
            ) {
                return 'Error-dimAfterStart';
            }

            if (
                (empty($request->dimAfterEndMin[0]) || empty($request->dimAfterEndNom[0]) || empty($request->dimAfterEndMax[0])) &&
                (!empty($request->dimAfterEndMin[0]) || !empty($request->dimAfterEndNom[0]) || !empty($request->dimAfterEndMax[0]))
            ) {
                return 'Error-dimAfterEnd';
            }

            //To Return Error-notes is Required if Status is Hold
            if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                return 'Error-notes';
            }


            $rowDataCCVInsulationActual = CCVInsulationActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputLength[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputLength[0],
                    'thicknessISCStartMin' => $request->thicknessISCStartMin[0],
                    'thicknessISCStartNom' => $request->thicknessISCStartNom[0],
                    'thicknessISCStartMax' => $request->thicknessISCStartMax[0],
                    'thicknessINSStartMin' => $request->thicknessINSStartMin[0],
                    'thicknessINSStartNom' => $request->thicknessINSStartNom[0],
                    'thicknessINSStartMax' => $request->thicknessINSStartMax[0],
                    'thicknessOSCStartMin' => $request->thicknessOSCStartMin[0],
                    'thicknessOSCStartNom' => $request->thicknessOSCStartNom[0],
                    'thicknessOSCStartMax' => $request->thicknessOSCStartMax[0],
                    'thicknessISCEndMin' => $request->thicknessISCEndMin[0],
                    'thicknessISCEndNom' => $request->thicknessISCEndNom[0],
                    'thicknessISCEndMax' => $request->thicknessISCEndMax[0],
                    'thicknessINSEndMin' => $request->thicknessINSEndMin[0],
                    'thicknessINSEndNom' => $request->thicknessINSEndNom[0],
                    'thicknessINSEndMax' => $request->thicknessINSEndMax[0],
                    'thicknessOSCEndMin' => $request->thicknessOSCEndMin[0],
                    'thicknessOSCEndNom' => $request->thicknessOSCEndNom[0],
                    'thicknessOSCEndMax' => $request->thicknessOSCEndMax[0],
                    'dimBefore1' => $request->dimBefore1[0],
                    'dimBefore2' => $request->dimBefore2[0],
                    'dimAfterStartMin' => $request->dimAfterStartMin[0],
                    'dimAfterStartNom' => $request->dimAfterStartNom[0],
                    'dimAfterStartMax' => $request->dimAfterStartMax[0],
                    'dimAfterEndMin' => $request->dimAfterEndMin[0],
                    'dimAfterEndNom' => $request->dimAfterEndNom[0],
                    'dimAfterEndMax' => $request->dimAfterEndMax[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataCCVInsulationActualTime = CCVInsulationActualsTimes::where('ccvinsulationactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputLength[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputLength[1],
                    'thicknessISCStartMin_time' => $request->thicknessISCStartMin[1],
                    'thicknessISCStartNom_time' => $request->thicknessISCStartNom[1],
                    'thicknessISCStartMax_time' => $request->thicknessISCStartMax[1],
                    'thicknessINSStartMin_time' => $request->thicknessINSStartMin[1],
                    'thicknessINSStartNom_time' => $request->thicknessINSStartNom[1],
                    'thicknessINSStartMax_time' => $request->thicknessINSStartMax[1],
                    'thicknessOSCStartMin_time' => $request->thicknessOSCStartMin[1],
                    'thicknessOSCStartNom_time' => $request->thicknessOSCStartNom[1],
                    'thicknessOSCStartMax_time' => $request->thicknessOSCStartMax[1],
                    'thicknessISCEndMin_time' => $request->thicknessISCEndMin[1],
                    'thicknessISCEndNom_time' => $request->thicknessISCEndNom[1],
                    'thicknessISCEndMax_time' => $request->thicknessISCEndMax[1],
                    'thicknessINSEndMin_time' => $request->thicknessINSEndMin[1],
                    'thicknessINSEndNom_time' => $request->thicknessINSEndNom[1],
                    'thicknessINSEndMax_time' => $request->thicknessINSEndMax[1],
                    'thicknessOSCEndMin_time' => $request->thicknessOSCEndMin[1],
                    'thicknessOSCEndNom_time' => $request->thicknessOSCEndNom[1],
                    'thicknessOSCEndMax_time' => $request->thicknessOSCEndMax[1],
                    'dimBefore1_time' => $request->dimBefore1[1],
                    'dimBefore2_time' => $request->dimBefore2[1],
                    'dimAfterStartMin_time' => $request->dimAfterStartMin[1],
                    'dimAfterStartNom_time' => $request->dimAfterStartNom[1],
                    'dimAfterStartMax_time' => $request->dimAfterStartMax[1],
                    'dimAfterEndMin_time' => $request->dimAfterEndMin[1],
                    'dimAfterEndNom_time' => $request->dimAfterEndNom[1],
                    'dimAfterEndMax_time' => $request->dimAfterEndMax[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);


            //GET Standard To Create Hold
            $ccvinsulationActual = DB::table('ccvinsulationactuals')->where('id', '=', $request->id)->first();
            $ccvinsulationActualTime = DB::table('ccvinsulationactualstimes')->where('ccvinsulationactuals_id', '=', $request->id)->first();
            $ccvinsulationStandard = DB::table('ccvinsulationstandards')->where('id', $ccvinsulationActual->jopOrderNumber_id)->first();
            $ccvinsulationStandardTime = DB::table('ccvinsulationstandardstimes')->where('ccvinsulationstandards_id', $ccvinsulationActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'CCVInsulation'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $ccvinsulationStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $ccvinsulationStandard->size;
                    $hold->length = $request->outputLength[0];
                    $hold->description = $ccvinsulationStandard->description;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "CCVInsulation";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $ccvinsulationStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $ccvinsulationStandardTime->size_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = $ccvinsulationStandardTime->description_time;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'CCVInsulation'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'CCVInsulation'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "CCVInsulation",
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);

                    $holdTime = DB::table('holdtimes')
                        ->where('hold_id', $dataOfHold->id)
                        ->update([
                            'drumNumber_time' => $request->outputDrum[1],
                            'length_time' => $request->outputLength[1],
                            'machine_time' => $request->machine[1],
                            'reasonOfHold_time' =>  $request->notes[1],
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);
                }
            }

            return array($ccvinsulationActual, $ccvinsulationActualTime);
        }
    }

    public function deleteDataCCVInsulation(Request $request)
    {
        if ($request->ajax()) {

            $deleteActualTimeRow = DB::table('ccvinsulationactualstimes')->where('ccvinsulationactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('ccvinsulationactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'CCVInsulation')->exists();

            if (!$chickISO) {
                $ccvinsulationISO = new ISO();
                $ccvinsulationISO->sheet = "CCVInsulation";
                $ccvinsulationISO->save();
            }


            $ccvinsulationISO = DB::table('iso')->where('sheet', 'CCVInsulation')->get();
            return $ccvinsulationISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'CCVInsulation')->exists();

            if (!$chickISO) {

                $ccvinsulationISO = new ISO();
                $ccvinsulationISO->sheet = "CCVInsulation";
                $ccvinsulationISO->issueNumber = $request->issueNumber;
                $ccvinsulationISO->issueDate = $request->issueDate;
                $ccvinsulationISO->modifiedDate = $request->modifiedDate;
                $ccvinsulationISO->durationOfPreservation     = $request->durationOfPreservation;
                $ccvinsulationISO->material = $request->material;
                $ccvinsulationISO->save();
            } else {
                $ccvinsulationISO = DB::table('iso')->where('sheet', 'CCVInsulation')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $ccvinsulationISO = DB::table('iso')->where('sheet', 'CCVInsulation')->get();


            $result = $this->getDataCCVInsulation($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $ccvinsulationISO);

            return $result;
        }
    }
}
