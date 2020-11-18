<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\BeddingActual;
use App\BeddingActualsTimes;
use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowBeddingActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataBedding()
    {
        return view('Admin.ShowData.Actual.show_actual_bedding');
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

    public function getDataBedding(Request $request)
    {
        if ($request->ajax()) {

            $checkJopOrderNumber = DB::table('beddingstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                $this->request = $request;

                $from = $request->filter['periodOfTime']['start'];
                $to = $request->filter['periodOfTime']['end'];

                if ($request->filter['sheetsType'] == 'complete') {

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('beddingstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('beddingactuals')->where([
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
                            ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['eccentricityActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null],
                            ['ovalityActual1', '!=', null],
                            ['sparkActual', '!=', null]
                        ])
                            ->where(function ($query) {
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
                            })
                            ->where(function ($query) {
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

                        $actualIdAsArray = DB::table('beddingactuals')->select('id')->where([
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
                            ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['eccentricityActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null],
                            ['ovalityActual1', '!=', null],
                            ['sparkActual', '!=', null]
                        ])
                            ->where(function ($query) {
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
                            })
                            ->where(function ($query) {
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
                        $actualTimeRows = DB::table('beddingactualstimes')->whereIn('beddingactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('beddingstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('beddingactuals')->where([
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
                            ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['eccentricityActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null],
                            ['ovalityActual1', '!=', null],
                            ['sparkActual', '!=', null]
                        ])
                            ->where(function ($query) {
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

                        $actualIdAsArray = DB::table('beddingactuals')->select('id')->where([
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
                            ['colorActual', 'LIKE', '%' . $request->filter['colorActual'] . '%'],
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['materialActual', 'LIKE', '%' . $request->filter['materialActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['eccentricityActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndMin', '!=', null],
                            ['ovalityActual1', '!=', null],
                            ['sparkActual', '!=', null]
                        ])
                            ->where(function ($query) {
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
                        $actualTimeRows = DB::table('beddingactualstimes')->whereIn('beddingactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('beddingstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                    $actualRows = DB::table('beddingactuals')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('colorActual', null)
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

                    $actualIdAsArray = DB::table('beddingactuals')->select('id')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('colorActual', null)
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
                    $actualTimeRows = DB::table('beddingactualstimes')->whereIn('beddingactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataBedding(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('beddingactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('beddingactualstimes')->where('beddingactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataBedding(Request $request)
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

            if (empty($request->dimBefore1[0]) && !empty($request->dimBefore2[0])) {
                return 'Error-dimBefore1';
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

            if (empty($request->ovalityActual1[0]) && !empty($request->ovalityActual2[0])) {
                return 'Error-ovalityActual1';
            }

            //To Return Error-notes is Required if Status is Hold
            if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                return 'Error-notes';
            }


            $rowDataBeddingActual = BeddingActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputLength[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputLength[0],
                    'colorActual' => $request->colorActual[0],
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
                    'sparkActual' => $request->sparkActual[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataBeddingActualTime = BeddingActualsTimes::where('beddingactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputLength[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputLength[1],
                    'colorActual_time' => $request->colorActual[1],
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
                    'sparkActual_time' => $request->sparkActual[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $beddingActual = DB::table('beddingactuals')->where('id', '=', $request->id)->first();
            $beddingActualTime = DB::table('beddingactualstimes')->where('beddingactuals_id', '=', $request->id)->first();
            $beddingStandard = DB::table('beddingstandards')->where('id', $beddingActual->jopOrderNumber_id)->first();
            $beddingStandardTime = DB::table('beddingstandardstimes')->where('beddingstandards_id', $beddingActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Bedding'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $beddingStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $beddingStandard->cableSize;
                    $hold->length = $request->outputLength[0];
                    $hold->description = $beddingStandard->cableDescription;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Bedding";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $beddingStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $beddingStandardTime->cableSize_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = $beddingStandardTime->cableDescription_time;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Bedding'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Bedding'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Bedding",
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

            return array($beddingActual, $beddingActualTime);
        }
    }

    public function deleteDataBedding(Request $request)
    {
        if ($request->ajax()) {

            $actual = DB::table('beddingactuals')->where('id', $request->rowId)->first();

            $traceability = DB::table("traceability")->where([
                ['jopOrderNumber', $actual->jopOrderNumber],
                ['outputCard', $actual->outputCard]
            ]);

            if ($traceability->exists()) {
                $chain = unserialize($traceability->first()->chain);
                array_pop($chain);

                $traceability->update([
                    "outputCard" => $chain[count($chain) - 1],
                    "chain" => serialize($chain),
                    "bedding_id" => null
                ]);
            } else {
                return "Error";
            }

            $deleteActualTimeRow = DB::table('beddingactualstimes')->where('beddingactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('beddingactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Bedding')->exists();

            if (!$chickISO) {
                $beddingISO = new ISO();
                $beddingISO->sheet = "Bedding";
                $beddingISO->save();
            }


            $beddingISO = DB::table('iso')->where('sheet', 'Bedding')->get();
            return $beddingISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Bedding')->exists();

            if (!$chickISO) {

                $beddingISO = new ISO();
                $beddingISO->sheet = "Bedding";
                $beddingISO->issueNumber = $request->issueNumber;
                $beddingISO->issueDate = $request->issueDate;
                $beddingISO->modifiedDate = $request->modifiedDate;
                $beddingISO->durationOfPreservation     = $request->durationOfPreservation;
                $beddingISO->material = $request->material;
                $beddingISO->save();
            } else {
                $beddingISO = DB::table('iso')->where('sheet', 'Bedding')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $beddingISO = DB::table('iso')->where('sheet', 'Bedding')->get();


            $result = $this->getDataBedding($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $beddingISO);

            return $result;
        }
    }
}
