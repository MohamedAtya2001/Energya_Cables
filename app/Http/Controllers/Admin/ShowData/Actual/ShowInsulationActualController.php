<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\InsulationActual;
use App\InsulationActualsTimes;
use App\ISO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowInsulationActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataInsulation()
    {
        return view('Admin.ShowData.Actual.show_actual_insulation');
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

    public function getDataInsulation(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $checkJopOrderNumber = DB::table('insulationstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('insulationstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                        $actualRows = DB::table('insulationactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                                ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                                ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                                ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                                ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                                ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                                ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['apperanceOfDrum', '!=', null],
                                ['message', '!=', null],
                                ['thicknessStartMinActual', '!=', null],
                                ['thicknessEndMinActual', '!=', null],
                                ['eccentricityActual', '!=', null],
                                ['dimBefore1', '!=', null],
                                ['dimAfterStartMin', '!=', null],
                                ['dimAfterEndMin', '!=', null],
                                ['ovalityActual1', '!=', null],
                                ['sparkActual', '!=', null]
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

                        $actualIdAsArray = DB::table('insulationactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                                ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                                ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                                ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                                ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                                ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                                ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['apperanceOfDrum', '!=', null],
                                ['message', '!=', null],
                                ['thicknessStartMinActual', '!=', null],
                                ['thicknessEndMinActual', '!=', null],
                                ['eccentricityActual', '!=', null],
                                ['dimBefore1', '!=', null],
                                ['dimAfterStartMin', '!=', null],
                                ['dimAfterEndMin', '!=', null],
                                ['ovalityActual1', '!=', null],
                                ['sparkActual', '!=', null]
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
                        $actualTimeRows = DB::table('insulationactualstimes')->whereIn('insulationactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('insulationstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                        $actualRows = DB::table('insulationactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                                ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                                ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                                ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                                ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                                ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                                ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['apperanceOfDrum', '!=', null],
                                ['message', '!=', null],
                                ['thicknessStartMinActual', '!=', null],
                                ['thicknessEndMinActual', '!=', null],
                                ['eccentricityActual', '!=', null],
                                ['dimBefore1', '!=', null],
                                ['dimAfterStartMin', '!=', null],
                                ['dimAfterEndMin', '!=', null],
                                ['ovalityActual1', '!=', null],
                                ['sparkActual', '!=', null]
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

                        $actualIdAsArray = DB::table('insulationactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                                ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                                ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                                ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                                ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                                ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                                ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['apperanceOfDrum', '!=', null],
                                ['message', '!=', null],
                                ['thicknessStartMinActual', '!=', null],
                                ['thicknessEndMinActual', '!=', null],
                                ['eccentricityActual', '!=', null],
                                ['dimBefore1', '!=', null],
                                ['dimAfterStartMin', '!=', null],
                                ['dimAfterEndMin', '!=', null],
                                ['ovalityActual1', '!=', null],
                                ['sparkActual', '!=', null]
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

                        $actualTimeRows = DB::table('insulationactualstimes')->whereIn('insulationactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('insulationstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                    $actualRows = DB::table('insulationactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                        ->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('apperanceOfDrum', null)
                        ->orWhere('colorActual', null)
                        ->orWhere('message', null)
                        ->orWhere('thicknessStartMinActual', null)
                        ->orWhere('thicknessEndMinActual', null)
                        ->orWhere('eccentricityActual', null)
                        ->orWhere('dimBefore1', null)
                        ->orWhere('dimAfterStartMin', null)
                        ->orWhere('dimAfterEndMin', null)
                        ->orWhere('weightActual', null)
                        ->orWhere('materialActual', null)
                        ->orWhere('ovalityActual1', null)
                        ->orWhere('sparkActual', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('insulationactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                        ->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('apperanceOfDrum', null)
                        ->orWhere('colorActual', null)
                        ->orWhere('message', null)
                        ->orWhere('thicknessStartMinActual', null)
                        ->orWhere('thicknessEndMinActual', null)
                        ->orWhere('eccentricityActual', null)
                        ->orWhere('dimBefore1', null)
                        ->orWhere('dimAfterStartMin', null)
                        ->orWhere('dimAfterEndMin', null)
                        ->orWhere('weightActual', null)
                        ->orWhere('materialActual', null)
                        ->orWhere('ovalityActual1', null)
                        ->orWhere('sparkActual', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                    $actualTimeRows = DB::table('insulationactualstimes')->whereIn('insulationactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataInsulation(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('insulationactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('insulationactualstimes')->where('insulationactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataInsulation(Request $request)
    {
        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            if (
                (empty($request->thicknessStartMinActual[0]) || empty($request->thicknessStartNomActual[0]) || empty($request->thicknessStartMaxActual[0])) &&
                (!empty($request->thicknessStartMinActual[0]) || !empty($request->thicknessStartNomActual[0]) || !empty($request->thicknessStartMaxActual[0]))
            ) {
                return 'Error-thicknessStartActual';
            }

            if (
                (empty($request->thicknessEndMinActual[0]) || empty($request->thicknessEndNomActual[0]) || empty($request->thicknessEndMaxActual[0])) &&
                (!empty($request->thicknessEndMinActual[0]) || !empty($request->thicknessEndNomActual[0]) || !empty($request->thicknessEndMaxActual[0]))
            ) {
                return 'Error-thicknessEndActual';
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

            $rowDataInsulationActual = InsulationActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputLength[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputLength[0],
                    'apperanceOfDrum' => $request->apperanceOfDrum[0],
                    'colorActual' => $request->colorActual[0],
                    'message' => $request->message[0],
                    'thicknessStartMinActual' => $request->thicknessStartMinActual[0],
                    'thicknessStartNomActual' => $request->thicknessStartNomActual[0],
                    'thicknessStartMaxActual' => $request->thicknessStartMaxActual[0],
                    'thicknessEndMinActual' => $request->thicknessEndMinActual[0],
                    'thicknessEndNomActual' => $request->thicknessEndNomActual[0],
                    'thicknessEndMaxActual' => $request->thicknessEndMaxActual[0],
                    'eccentricityActual' => $request->eccentricityActual[0],
                    'dimBefore1' => $request->dimBefore1[0],
                    'dimBefore2' => $request->dimBefore2[0],
                    'dimAfterStartMin' => $request->dimAfterStartMin[0],
                    'dimAfterStartNom' => $request->dimAfterStartNom[0],
                    'dimAfterStartMax' => $request->dimAfterStartMax[0],
                    'dimAfterEndMin' => $request->dimAfterEndMin[0],
                    'dimAfterEndNom' => $request->dimAfterEndNom[0],
                    'dimAfterEndMax' => $request->dimAfterEndMax[0],
                    'weightActual' => $request->weightActual[0],
                    'materialActual' => $request->materialActual[0],
                    'ovalityActual1' => $request->ovalityActual1[0],
                    'ovalityActual2' => $request->ovalityActual2[0],
                    'meterMeasuring' => $request->meterMeasuring[0],
                    'sparkActual' => $request->sparkActual[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataInsulationActualTime = InsulationActualsTimes::where('insulationactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputLength[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputLength[1],
                    'apperanceOfDrum_time' => $request->apperanceOfDrum[1],
                    'colorActual_time' => $request->colorActual[1],
                    'message_time' => $request->message[1],
                    'thicknessStartMinActual_time' => $request->thicknessStartMinActual[1],
                    'thicknessStartNomActual_time' => $request->thicknessStartNomActual[1],
                    'thicknessStartMaxActual_time' => $request->thicknessStartMaxActual[1],
                    'thicknessEndMinActual_time' => $request->thicknessEndMinActual[1],
                    'thicknessEndNomActual_time' => $request->thicknessEndNomActual[1],
                    'thicknessEndMaxActual_time' => $request->thicknessEndMaxActual[1],
                    'eccentricityActual_time' => $request->eccentricityActual[1],
                    'dimBefore1_time' => $request->dimBefore1[1],
                    'dimBefore2_time' => $request->dimBefore2[1],
                    'dimAfterStartMin_time' => $request->dimAfterStartMin[1],
                    'dimAfterStartNom_time' => $request->dimAfterStartNom[1],
                    'dimAfterStartMax_time' => $request->dimAfterStartMax[1],
                    'dimAfterEndMin_time' => $request->dimAfterEndMin[1],
                    'dimAfterEndNom_time' => $request->dimAfterEndNom[1],
                    'dimAfterEndMax_time' => $request->dimAfterEndMax[1],
                    'weightActual_time' => $request->weightActual[1],
                    'materialActual_time' => $request->materialActual[1],
                    'ovalityActual1_time' => $request->ovalityActual1[1],
                    'ovalityActual2_time' => $request->ovalityActual2[1],
                    'meterMeasuring_time' => $request->meterMeasuring[1],
                    'sparkActual_time' => $request->sparkActual[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $insulationActual = DB::table('insulationactuals')->where('id', '=', $request->id)->first();
            $insulationActualTime = DB::table('insulationactualstimes')->where('insulationactuals_id', '=', $insulationActual->id)->first();
            $insulationStandard = DB::table('insulationstandards')->where('id', $insulationActual->jopOrderNumber_id)->first();
            $insulationStandardTime = DB::table('insulationstandardstimes')->where('insulationstandards_id', $insulationActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Insulation'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $insulationStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $insulationStandard->cableSize;
                    $hold->length = $request->outputLength[0];
                    $hold->description = $insulationStandard->cableDescription;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Insulation";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $insulationStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $insulationStandardTime->cableSize_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = $insulationStandardTime->cableDescription_time;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Insulation'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Insulation'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Insulation",
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

            return array($insulationActual, $insulationActualTime);
        }
    }

    public function deleteDataInsulation(Request $request)
    {
        if ($request->ajax()) {

            $actual = DB::table('insulationactuals')->where('id', $request->rowId)->first();

            $this->request = $request;


            $traceability = DB::table("traceability")->where(function ($query) {
                $query->where('insulation_id1', $this->request->rowId)
                    ->orWhere('insulation_id2', $this->request->rowId)
                    ->orWhere('insulation_id3', $this->request->rowId)
                    ->orWhere('insulation_id4', $this->request->rowId)
                    ->orWhere('insulation_id5', $this->request->rowId);
            })->first();

            return array($traceability);

            /*  $traceability = DB::table("traceability")->where('jopOrderNumber', $actual->jopOrderNumber)
                ->where(function ($query) {
                    $query->where("outputCardInsulation1", $this->actual->outputCard)
                        ->orWhere("outputCardInsulation2", $this->actual->outputCard)
                        ->orWhere("outputCardInsulation3", $this->actual->outputCard)
                        ->orWhere("outputCardInsulation4", $this->actual->outputCard)
                        ->orWhere("outputCardInsulation5", $this->actual->outputCard);
                }); */

            if ($traceability->outputCard == $actual->outputCard) {
                $chain = unserialize($traceability->first()->chain);
                $insulationChain = $chain[count($chain) - 1];
                $indexOfOutputCard = array_search($actual->outputCard, $chain);
                unset($insulationChain[$indexOfOutputCard]);
                $chain[count($chain) - 1] = $insulationChain;

                return $chain;

                $traceability->update([
                    "outputCard" => $chain[count($chain) - 1],
                    "chain" => serialize($chain),
                    "insulation_id" => null
                ]);
            } else {
                return "Error";
            }

            $deleteActualTimeRow = DB::table('insulationactualstimes')->where('insulationactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('insulationactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Insulation')->exists();

            if (!$chickISO) {
                $insulationISO = new ISO();
                $insulationISO->sheet = "Insulation";
                $insulationISO->save();
            }


            $insulationISO = DB::table('iso')->where('sheet', 'Insulation')->get();
            return $insulationISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Insulation')->exists();

            if (!$chickISO) {

                $insulationISO = new ISO();
                $insulationISO->sheet = "Insulation";
                $insulationISO->issueNumber = $request->issueNumber;
                $insulationISO->issueDate = $request->issueDate;
                $insulationISO->modifiedDate = $request->modifiedDate;
                $insulationISO->durationOfPreservation     = $request->durationOfPreservation;
                $insulationISO->material = $request->material;
                $insulationISO->save();
            } else {
                $insulationISO = DB::table('iso')->where('sheet', 'Insulation')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $insulationISO = DB::table('iso')->where('sheet', 'Insulation')->get();


            $result = $this->getDataInsulation($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $insulationISO);

            return $result;
        }
    }
}
