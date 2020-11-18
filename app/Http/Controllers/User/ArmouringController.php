<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\ArmouringActual;
use App\ArmouringActualsTimes;
use App\ArmouringStandard;
use App\ArmouringStandardsTimes;
use App\Events\WatchingEmployee;
use App\Hold;
use App\HoldTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArmouringController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
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

    // Function checkEmployeeShift return true if the curentShift Equal EmployeeShift
    public function checkEmployeeShift()
    {
        $currentShift = $this->currentShift();
        if (Auth::user()->logout == false && Auth::user()->shift == $currentShift) {
            return true;
        } else {
            DB::table('users')->where('id', Auth::user()->id)->update([
                'online' => false
            ]);
            Auth::logout();
            return false;
        }
    }

    public $request;

    public function insertArmouring(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('armouringstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();
                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;

                if (!$checkJopOrderNumber) {

                    //To Add New ArmouringStansard
                    $armouringStandard = new ArmouringStandard();
                    $armouringStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $armouringStandard->cableSize = $request->cableSize[0];
                    $armouringStandard->volt = $request->volt[0];
                    $armouringStandard->outerDiameter = $request->outerDiameter[0];
                    $armouringStandard->overGapStandard = $request->overGapStandard[0];
                    $armouringStandard->ovalityStandard = $request->ovalityStandard[0];
                    $armouringStandard->tapeDimention = $request->tapeDimention[0];
                    $armouringStandard->numberOfWire_wireDim = $request->numberOfWire_wireDim[0];
                    $armouringStandard->added_by = $name;
                    $armouringStandard->shift = $shift;
                    $armouringStandard->save();

                    $jopOrderNumber_id = DB::table('armouringstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New ArmouringStansardTimes
                    $armouringStandardTime = new ArmouringStandardsTimes();
                    $armouringStandardTime->armouringstandards_id = $jopOrderNumber_id;
                    $armouringStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $armouringStandardTime->cableSize_time = $request->cableSize[1];
                    $armouringStandardTime->volt_time = $request->volt[1];
                    $armouringStandardTime->outerDiameter_time = $request->outerDiameter[1];
                    $armouringStandardTime->overGapStandard_time = $request->overGapStandard[1];
                    $armouringStandardTime->ovalityStandard_time = $request->ovalityStandard[1];
                    $armouringStandardTime->tapeDimention_time = $request->tapeDimention[1];
                    $armouringStandardTime->numberOfWire_wireDim_time = $request->numberOfWire_wireDim[1];
                    $armouringStandardTime->added_by = $name;
                    $armouringStandardTime->shift = $shift;
                    $armouringStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('armouringstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

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

                //To Add New ArmouringActual
                $armouringActual = new ArmouringActual();
                $armouringActual->jopOrderNumber_id = $jopOrderNumber_id;
                $armouringActual->jopOrderNumber = $request->jopOrderNumber[0];
                $armouringActual->machine = $request->machine[0];
                $armouringActual->inputDrum = $request->inputDrum[0];
                $armouringActual->inputCard = $request->inputCard[0];
                $armouringActual->inputLength = $request->inputLength[0];
                $armouringActual->outputDrum = $request->outputDrum[0];
                $armouringActual->outputCard = $request->outputCard[0];
                $armouringActual->outputLength = $request->outputLength[0];
                $armouringActual->dimAfterStartMin = $request->dimAfterStartMin[0];
                $armouringActual->dimAfterStartNom = $request->dimAfterStartNom[0];
                $armouringActual->dimAfterStartMax = $request->dimAfterStartMax[0];
                $armouringActual->dimAfterEndMin = $request->dimAfterEndMin[0];
                $armouringActual->dimAfterEndNom = $request->dimAfterEndNom[0];
                $armouringActual->dimAfterEndMax = $request->dimAfterEndMax[0];
                $armouringActual->ovalityActual = $request->ovalityActual[0];
                $armouringActual->wire_tape = $request->wire_tape[0];
                $armouringActual->overGapActual = $request->overGapActual[0];
                $armouringActual->direction = $request->direction[0];
                $armouringActual->status = $request->status[0];
                $armouringActual->productionOperator = $request->productionOperator[0];
                $armouringActual->notes = $request->notes[0];
                $armouringActual->added_by = $name;
                $armouringActual->shift = $shift;
                $armouringActual->save();

                //To  Add New ArmouringActualTimes
                $armouringActualTime = new ArmouringActualsTimes();
                $armouringActualTime->armouringactuals_id = $armouringActual->id;
                $armouringActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $armouringActualTime->machine_time = $request->machine[1];
                $armouringActualTime->inputDrum_time = $request->inputDrum[1];
                $armouringActualTime->inputCard_time = $request->inputCard[1];
                $armouringActualTime->inputLength_time = $request->inputLength[1];
                $armouringActualTime->outputDrum_time = $request->outputDrum[1];
                $armouringActualTime->outputCard_time = $request->outputCard[1];
                $armouringActualTime->outputLength_time = $request->outputLength[1];
                $armouringActualTime->dimAfterStartMin_time = $request->dimAfterStartMin[1];
                $armouringActualTime->dimAfterStartNom_time = $request->dimAfterStartNom[1];
                $armouringActualTime->dimAfterStartMax_time = $request->dimAfterStartMax[1];
                $armouringActualTime->dimAfterEndMin_time = $request->dimAfterEndMin[1];
                $armouringActualTime->dimAfterEndNom_time = $request->dimAfterEndNom[1];
                $armouringActualTime->dimAfterEndMax_time = $request->dimAfterEndMax[1];
                $armouringActualTime->ovalityActual_time = $request->ovalityActual[1];
                $armouringActualTime->wire_tape_time = $request->wire_tape[1];
                $armouringActualTime->overGapActual_time = $request->overGapActual[1];
                $armouringActualTime->direction_time = $request->direction[1];
                $armouringActualTime->status_time = $request->status[1];
                $armouringActualTime->productionOperator_time = $request->productionOperator[1];
                $armouringActualTime->notes_time = $request->notes[1];
                $armouringActualTime->added_by = $name;
                $armouringActualTime->shift = $shift;
                $armouringActualTime->save();

                // Traceability
                if (!empty($request->inputCard[0]) && !empty($request->outputCard[0])) {
                    $traceability = DB::table("traceability")->where([
                        ['jopOrderNumber', $request->jopOrderNumber[0]],
                        ['outputCard', $request->inputCard[0]]
                    ]);

                    $chain = unserialize($traceability->value('chain'));
                    array_push($chain, $request->outputCard[0]);

                    $traceability->update([
                        "outputCard" => $request->outputCard[0],
                        "armouring_id" => $armouringActual->id,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $armouringActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->cableSize[0] == null) ? '' : $request->cableSize[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = '';
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Armouring";
                    $hold->added_by = $name;
                    $hold->shift = $shift;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = ($request->jopOrderNumber[1] == null) ? '' : $request->jopOrderNumber[1];
                    $holdTime->drumNumber_time = ($request->outputDrum[1] == null) ? '' : $request->outputDrum[1];
                    $holdTime->cableSize_time = ($request->cableSize[1] == null) ? '' : $request->cableSize[1];
                    $holdTime->length_time = ($request->outputLength[1] == null) ? '' : $request->outputLength[1];
                    $holdTime->description_time = '';
                    $holdTime->machine_time = ($request->machine[1] == null) ? '' : $request->machine[1];
                    $holdTime->reasonOfHold_time = ($request->notes[1] == null) ? '' : $request->notes[1];
                    $holdTime->added_by = $name;
                    $holdTime->shift = $shift;
                    $holdTime->save();
                }

                //To save change That Happend in Armouring Table
                $armouring = DB::table('armourings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'volt' => '',
                    'outerDiameter' => '',
                    'overGapStandard' => '',
                    'ovalityStandard' => '',
                    'tapeDimention' => '',
                    'numberOfWire_wireDim' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'dimAfterStartMin' => '',
                    'dimAfterStartNom' => '',
                    'dimAfterStartMax' => '',
                    'dimAfterEndMin' => '',
                    'dimAfterEndNom' => '',
                    'dimAfterEndMax' => '',
                    'ovalityActual' => '',
                    'wire_tape' => '',
                    'overGapActual' => '',
                    'direction' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'outerDiameter',
                    'overGapStandard',
                    'ovalityStandard',
                    'tapeDimention',
                    'numberOfWire_wireDim',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'dimAfterStartMin',
                    'dimAfterStartNom',
                    'dimAfterStartMax',
                    'dimAfterEndMin',
                    'dimAfterEndNom',
                    'dimAfterEndMax',
                    'ovalityActual',
                    'wire_tape',
                    'overGapActual',
                    'direction',
                    'status',
                    'productionOperator',
                    'notes'
                );
                $values = array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('armouring', $request->data_form_item, $attributes, $values));
            } else {

                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('armouringactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('armouringactuals')->find($request->id_update)->shift;

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

                $rowDataArmouringActual = DB::table('armouringactuals')
                    ->where('id', '=', $request->id_update)
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
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);
                $rowDataArmouringActualTime = DB::table('armouringactualstimes')
                    ->where('armouringactuals_id', '=', $request->id_update)
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
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $checkTraceability = DB::table("traceability")->where('armouring_id', $request->id_update)->exists();

                // Traceability
                if (!$checkTraceability) {
                    $traceability = DB::table("traceability")->where([
                        ['jopOrderNumber', $request->jopOrderNumber[0]],
                        ['outputCard', $request->inputCard[0]]
                    ]);

                    $chain = unserialize($traceability->value('chain'));
                    array_push($chain, $request->outputCard[0]);

                    $traceability->update([
                        "outputCard" => $request->outputCard[0],
                        "armouring_id" => $request->id_update,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Armouring'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = $request->outputDrum[0];
                        $hold->cableSize = $request->cableSize[0];
                        $hold->length = $request->outputLength[0];
                        $hold->description = '';
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Armouring";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeInsert;
                        $hold->save();

                        // To Add New HoldTime
                        $holdTime = new HoldTime();
                        $holdTime->hold_id = $hold->id;
                        $holdTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                        $holdTime->drumNumber_time = $request->outputDrum[1];
                        $holdTime->cableSize_time = $request->cableSize[1];
                        $holdTime->length_time = $request->outputLength[1];
                        $holdTime->description_time = '';
                        $holdTime->machine_time = $request->machine[1];
                        $holdTime->reasonOfHold_time = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Armouring'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Armouring'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->cableSize[0],
                                'length' => $request->outputLength[0],
                                'description' => '',
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Armouring",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[1],
                                'drumNumber_time' => $request->outputDrum[1],
                                'cableSize_time' => $request->cableSize[1],
                                'length_time' => $request->outputLength[1],
                                'description_time' => '',
                                'machine_time' => $request->machine[1],
                                'reasonOfHold_time' =>  $request->notes[1],
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);
                    }
                }

                //To save change That Happend in Armouring Table
                $armouring = DB::table('armourings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $nameOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'volt' => '',
                    'outerDiameter' => '',
                    'overGapStandard' => '',
                    'ovalityStandard' => '',
                    'tapeDimention' => '',
                    'numberOfWire_wireDim' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'dimAfterStartMin' => '',
                    'dimAfterStartNom' => '',
                    'dimAfterStartMax' => '',
                    'dimAfterEndMin' => '',
                    'dimAfterEndNom' => '',
                    'dimAfterEndMax' => '',
                    'ovalityActual' => '',
                    'wire_tape' => '',
                    'overGapActual' => '',
                    'direction' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'outerDiameter',
                    'overGapStandard',
                    'ovalityStandard',
                    'tapeDimention',
                    'numberOfWire_wireDim',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'dimAfterStartMin',
                    'dimAfterStartNom',
                    'dimAfterStartMax',
                    'dimAfterEndMin',
                    'dimAfterEndNom',
                    'dimAfterEndMax',
                    'ovalityActual',
                    'wire_tape',
                    'overGapActual',
                    'direction',
                    'status',
                    'productionOperator',
                    'notes'
                );
                $values = array(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('armouring', $request->data_form_item, $attributes, $values));

                return "Updated";
            }
        }
    }

    public function findJopOrderNumber(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            $checkJopOrderNumber = DB::table('armouringstandards')->where('jopOrderNumber', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $armouringStandard = DB::table('armouringstandards')->where('jopOrderNumber', $request->jopOrderNumber)->first();

                //To save change That Happend in Armouring Table
                $armouring = DB::table('armourings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $armouringStandard->jopOrderNumber,
                    'cableSize' => $armouringStandard->cableSize,
                    'volt' => $armouringStandard->volt,
                    'outerDiameter' => $armouringStandard->outerDiameter,
                    'overGapStandard' => $armouringStandard->overGapStandard,
                    'ovalityStandard' => $armouringStandard->ovalityStandard,
                    'tapeDimention' => $armouringStandard->tapeDimention,
                    'numberOfWire_wireDim' => $armouringStandard->numberOfWire_wireDim,
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'outerDiameter',
                    'overGapStandard',
                    'ovalityStandard',
                    'tapeDimention',
                    'numberOfWire_wireDim'
                );
                $values = array(
                    $armouringStandard->jopOrderNumber,
                    $armouringStandard->cableSize,
                    $armouringStandard->volt,
                    $armouringStandard->outerDiameter,
                    $armouringStandard->overGapStandard,
                    $armouringStandard->ovalityStandard,
                    $armouringStandard->tapeDimention,
                    $armouringStandard->numberOfWire_wireDim
                );
                event(new WatchingEmployee('armouring', $request->data_form_item, $attributes, $values));

                return (array) $armouringStandard;
            } else {

                //To save change That Happend in Armouring Table
                $armouring = DB::table('armourings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'cableSize' => '',
                    'volt' => '',
                    'outerDiameter' => '',
                    'overGapStandard' => '',
                    'ovalityStandard' => '',
                    'tapeDimention' => '',
                    'numberOfWire_wireDim' => '',
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'outerDiameter',
                    'overGapStandard',
                    'ovalityStandard',
                    'tapeDimention',
                    'numberOfWire_wireDim'
                );
                $values = array(
                    $request->jopOrderNumber,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('armouring', $request->data_form_item, $attributes, $values));

                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            $alertIsExist = DB::table('armouringactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataArmouringActual = DB::table('armouringactuals')->where('id', $request->id)->first();
            $rowDataArmouringStandard = DB::table('armouringstandards')->where('id', $rowDataArmouringActual->jopOrderNumber_id)->first();
            $rowDataArmouringActualTime = DB::table('armouringactualstimes')->where('id', $request->id)->first();
            $rowDataArmouringStandardTime = DB::table('armouringstandardstimes')->where('id', $rowDataArmouringActual->jopOrderNumber_id)->first();

            //To save change That Happend in Armouring Table
            $armouring = DB::table('armourings')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataArmouringStandard->jopOrderNumber == null) ? '' : $rowDataArmouringStandard->jopOrderNumber,
                'cableSize' => ($rowDataArmouringStandard->cableSize == null) ? '' : $rowDataArmouringStandard->cableSize,
                'volt' => ($rowDataArmouringStandard->volt == null) ? '' : $rowDataArmouringStandard->volt,
                'outerDiameter' => ($rowDataArmouringStandard->outerDiameter == null) ? '' : $rowDataArmouringStandard->outerDiameter,
                'overGapStandard' => ($rowDataArmouringStandard->overGapStandard == null) ? '' : $rowDataArmouringStandard->overGapStandard,
                'ovalityStandard' => ($rowDataArmouringStandard->ovalityStandard == null) ? '' : $rowDataArmouringStandard->ovalityStandard,
                'tapeDimention' => ($rowDataArmouringStandard->tapeDimention == null) ? '' : $rowDataArmouringStandard->tapeDimention,
                'numberOfWire_wireDim' => ($rowDataArmouringStandard->numberOfWire_wireDim == null) ? '' : $rowDataArmouringStandard->numberOfWire_wireDim,
                'machine' => ($rowDataArmouringActual->machine == null) ? '' : $rowDataArmouringActual->machine,
                'inputDrum' => ($rowDataArmouringActual->inputDrum == null) ? '' : $rowDataArmouringActual->inputDrum,
                'inputCard' => ($rowDataArmouringActual->inputCard == null) ? '' : $rowDataArmouringActual->inputCard,
                'inputLength' => ($rowDataArmouringActual->inputLength == null) ? '' : $rowDataArmouringActual->inputLength,
                'outputDrum' => ($rowDataArmouringActual->outputDrum == null) ? '' : $rowDataArmouringActual->outputDrum,
                'outputCard' => ($rowDataArmouringActual->outputCard == null) ? '' : $rowDataArmouringActual->outputCard,
                'outputLength' => ($rowDataArmouringActual->outputLength == null) ? '' : $rowDataArmouringActual->outputLength,
                'dimAfterStartMin' => ($rowDataArmouringActual->dimAfterStartMin == null) ? '' : $rowDataArmouringActual->dimAfterStartMin,
                'dimAfterStartNom' => ($rowDataArmouringActual->dimAfterStartNom == null) ? '' : $rowDataArmouringActual->dimAfterStartNom,
                'dimAfterStartMax' => ($rowDataArmouringActual->dimAfterStartMax == null) ? '' : $rowDataArmouringActual->dimAfterStartMax,
                'dimAfterEndMin' => ($rowDataArmouringActual->dimAfterEndMin == null) ? '' : $rowDataArmouringActual->dimAfterEndMin,
                'dimAfterEndNom' => ($rowDataArmouringActual->dimAfterEndNom == null) ? '' : $rowDataArmouringActual->dimAfterEndNom,
                'dimAfterEndMax' => ($rowDataArmouringActual->dimAfterEndMax == null) ? '' : $rowDataArmouringActual->dimAfterEndMax,
                'ovalityActual' => ($rowDataArmouringActual->ovalityActual == null) ? '' : $rowDataArmouringActual->ovalityActual,
                'wire_tape' => ($rowDataArmouringActual->wire_tape == null) ? '' : $rowDataArmouringActual->wire_tape,
                'overGapActual' => ($rowDataArmouringActual->overGapActual == null) ? '' : $rowDataArmouringActual->overGapActual,
                'direction' => ($rowDataArmouringActual->direction == null) ? '' : $rowDataArmouringActual->direction,
                'status' => ($rowDataArmouringActual->status == null) ? '' : $rowDataArmouringActual->status,
                'productionOperator' => ($rowDataArmouringActual->productionOperator == null) ? '' : $rowDataArmouringActual->productionOperator,
                'notes' => ($rowDataArmouringActual->notes == null) ? '' : $rowDataArmouringActual->notes
            ]);

            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'cableSize',
                'volt',
                'outerDiameter',
                'overGapStandard',
                'ovalityStandard',
                'tapeDimention',
                'numberOfWire_wireDim',
                'machine',
                'inputDrum',
                'inputCard',
                'inputLength',
                'outputDrum',
                'outputCard',
                'outputLength',
                'dimAfterStartMin',
                'dimAfterStartNom',
                'dimAfterStartMax',
                'dimAfterEndMin',
                'dimAfterEndNom',
                'dimAfterEndMax',
                'ovalityActual',
                'wire_tape',
                'overGapActual',
                'direction',
                'status',
                'productionOperator',
                'notes'
            );
            $values = array(
                $rowDataArmouringStandard->jopOrderNumber,
                $rowDataArmouringStandard->cableSize,
                $rowDataArmouringStandard->volt,
                $rowDataArmouringStandard->outerDiameter,
                $rowDataArmouringStandard->overGapStandard,
                $rowDataArmouringStandard->ovalityStandard,
                $rowDataArmouringStandard->tapeDimention,
                $rowDataArmouringStandard->numberOfWire_wireDim,
                $rowDataArmouringActual->machine,
                $rowDataArmouringActual->inputDrum,
                $rowDataArmouringActual->inputCard,
                $rowDataArmouringActual->inputLength,
                $rowDataArmouringActual->outputDrum,
                $rowDataArmouringActual->outputCard,
                $rowDataArmouringActual->outputLength,
                $rowDataArmouringActual->dimAfterStartMin,
                $rowDataArmouringActual->dimAfterStartNom,
                $rowDataArmouringActual->dimAfterStartMax,
                $rowDataArmouringActual->dimAfterEndMin,
                $rowDataArmouringActual->dimAfterEndNom,
                $rowDataArmouringActual->dimAfterEndMax,
                $rowDataArmouringActual->ovalityActual,
                $rowDataArmouringActual->wire_tape,
                $rowDataArmouringActual->overGapActual,
                $rowDataArmouringActual->direction,
                $rowDataArmouringActual->status,
                $rowDataArmouringActual->productionOperator,
                $rowDataArmouringActual->notes
            );
            event(new WatchingEmployee('armouring', $request->data_form_item, $attributes, $values));

            return array(
                $rowDataArmouringStandard,
                $rowDataArmouringActual,
                $rowDataArmouringActualTime,
                $rowDataArmouringStandardTime
            );
        }
    }

    public function checkRow(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            //To Check About "who did make insert ?"
            $name = Auth::user()->name;

            $rowUpdateData = DB::table('armourings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('armouring', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if (false) {
                $dataRow = DB::table('armourings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();

                if (false) {

                    $message = ['employee' => $name, 'Sheet' => 'Screen', 'errors' => 'wireDimActual'];

                    $alert = new Alert();
                    $alert->message = json_encode($message);
                    $alert->save();

                    return "Close Sheet";
                } else {
                    return 0;
                }
            }
        }
    }
}
