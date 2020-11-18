<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\ArmouringActual;
use App\ArmouringActualsTimes;
use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowArmouringActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataArmouring()
    {
        return view('Admin.ShowData.Actual.show_actual_armouring');
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

    public function getDataArmouring(Request $request)
    {
        if ($request->ajax()) {

            $checkJopOrderNumber = DB::table('armouringstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                $this->request = $request;

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('armouringstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('armouringactuals')->where([
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
                            ['ovalityActual', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndNom', '!=', null],
                            ['wire_tape', '!=', null],
                            ['overGapActual', '!=', null],
                            ['direction', '!=', null]
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
                            })->whereBetween('created_at', [$from, $to]);

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('armouringactuals')->select('id')->where([
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
                            ['ovalityActual', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndNom', '!=', null],
                            ['wire_tape', '!=', null],
                            ['overGapActual', '!=', null],
                            ['direction', '!=', null]
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
                            })->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('armouringactualstimes')->whereIn('armouringactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('armouringstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('armouringactuals')->where([
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
                            ['ovalityActual', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndNom', '!=', null],
                            ['wire_tape', '!=', null],
                            ['overGapActual', '!=', null],
                            ['direction', '!=', null]
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

                        $actualIdAsArray = DB::table('armouringactuals')->select('id')->where([
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
                            ['ovalityActual', '!=', null],
                            ['dimAfterStartMin', '!=', null],
                            ['dimAfterEndNom', '!=', null],
                            ['wire_tape', '!=', null],
                            ['overGapActual', '!=', null],
                            ['direction', '!=', null]
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
                        $actualTimeRows = DB::table('armouringactualstimes')->whereIn('armouringactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('armouringstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                    $actualRows = DB::table('armouringactuals')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('ovalityActual', null)
                        ->orWhere('dimAfterStartMin', null)
                        ->orWhere('dimAfterEndNom', null)
                        ->orWhere('wire_tape', null)
                        ->orWhere('overGapActual', null)
                        ->orWhere('direction', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('armouringactuals')->select('id')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('ovalityActual', null)
                        ->orWhere('dimAfterStartMin', null)
                        ->orWhere('dimAfterEndNom', null)
                        ->orWhere('wire_tape', null)
                        ->orWhere('overGapActual', null)
                        ->orWhere('direction', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                    $actualTimeRows = DB::table('armouringactualstimes')->whereIn('armouringactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataArmouring(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('armouringactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('armouringactualstimes')->where('armouringactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataArmouring(Request $request)
    {

        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

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

            $rowDataArmouringActual = ArmouringActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputCard[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputCard[0],
                    'dimAfterStartMin' => $request->dimAfterStartMin[0],
                    'dimAfterStartNom' => $request->dimAfterStartNom[0],
                    'dimAfterStartMax' => $request->dimAfterStartMax[0],
                    'dimAfterEndMin' => $request->dimAfterEndMin[0],
                    'dimAfterEndNom' => $request->dimAfterEndNom[0],
                    'dimAfterEndMax' => $request->dimAfterEndMax[0],
                    'ovalityActual' => $request->ovalityActual[0],
                    'wire_tape' => $request->wire_tape[0],
                    'overGapActual' => $request->overGapActual[0],
                    'direction' => $request->direction[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataArmouringActualTime = ArmouringActualsTimes::where('armouringactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputCard[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputCard[1],
                    'dimAfterStartMin_time' => $request->dimAfterStartMin[1],
                    'dimAfterStartNom_time' => $request->dimAfterStartNom[1],
                    'dimAfterStartMax_time' => $request->dimAfterStartMax[1],
                    'dimAfterEndMin_time' => $request->dimAfterEndMin[1],
                    'dimAfterEndNom_time' => $request->dimAfterEndNom[1],
                    'dimAfterEndMax_time' => $request->dimAfterEndMax[1],
                    'ovalityActual_time' => $request->ovalityActual[1],
                    'wire_tape_time' => $request->wire_tape[1],
                    'overGapActual_time' => $request->overGapActual[1],
                    'direction_time' => $request->direction[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $armouringActual = DB::table('armouringactuals')->where('id', '=', $request->id)->first();
            $armouringActualTime = DB::table('armouringactualstimes')->where('armouringactuals_id', '=', $request->id)->first();
            $armouringStandard = DB::table('armouringstandards')->where('id', $armouringActual->jopOrderNumber_id)->first();
            $armouringStandardTime = DB::table('armouringstandardstimes')->where('armouringstandards_id', $armouringActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Armouring'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $armouringStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $armouringStandard->cableSize;
                    $hold->length = $request->outputLength[0];
                    $hold->description = null;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Armouring";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $armouringStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $armouringStandardTime->cableSize_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = null;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Armouring'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Armouring'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Armouring",
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

            return array($armouringActual, $armouringActualTime);
        }
    }

    public function deleteDataArmouring(Request $request)
    {
        if ($request->ajax()) {

            $actual = DB::table('armouringactuals')->where('id', $request->rowId)->first();

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
                    "armouring_id" => null
                ]);
            } else {
                return "Error";
            }


            $deleteActualTimeRow = DB::table('armouringactualstimes')->where('armouringactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('armouringactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Armouring')->exists();

            if (!$chickISO) {
                $ArmouringISO = new ISO();
                $ArmouringISO->sheet = "Armouring";
                $ArmouringISO->save();
            }


            $ArmouringISO = DB::table('iso')->where('sheet', 'Armouring')->get();
            return $ArmouringISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Armouring')->exists();

            if (!$chickISO) {

                $ArmouringISO = new ISO();
                $ArmouringISO->sheet = "Armouring";
                $ArmouringISO->issueNumber = $request->issueNumber;
                $ArmouringISO->issueDate = $request->issueDate;
                $ArmouringISO->modifiedDate = $request->modifiedDate;
                $ArmouringISO->durationOfPreservation     = $request->durationOfPreservation;
                $ArmouringISO->material = $request->material;
                $ArmouringISO->save();
            } else {
                $ArmouringISO = DB::table('iso')->where('sheet', 'Armouring')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $ArmouringISO = DB::table('iso')->where('sheet', 'Armouring')->get();


            $result = $this->getDataArmouring($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $ArmouringISO);

            return $result;
        }
    }
}
