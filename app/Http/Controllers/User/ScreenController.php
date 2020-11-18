<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Events\WatchingEmployee;
use App\Hold;
use App\HoldTime;
use App\ScreenActual;
use App\ScreenActualsTimes;
use App\ScreenStandard;
use App\ScreenStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScreenController extends Controller
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

    public function insertScreen(Request $request)
    {
        if ($request->ajax()) {
            $this->request = $request;
            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('screenstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;

                if (!$checkJopOrderNumber) {

                    //To Add New ScreenStansard
                    $screenStandard = new ScreenStandard();
                    $screenStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $screenStandard->size_type = $request->size_type[0];
                    $screenStandard->volt = $request->volt[0];
                    $screenStandard->overLapStandard = $request->overLapStandard[0];
                    $screenStandard->outerDiameter = $request->outerDiameter[0];
                    $screenStandard->numberOfWire_wireDim = $request->numberOfWire_wireDim[0];
                    $screenStandard->tape_wire_weight = $request->tape_wire_weight[0];
                    $screenStandard->added_by = $name;
                    $screenStandard->shift = $shift;
                    $screenStandard->save();

                    $jopOrderNumber_id = DB::table('screenstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New ScreenStansardTimes
                    $screenStandardTime = new ScreenStandardsTimes();
                    $screenStandardTime->screenstandards_id = $jopOrderNumber_id;
                    $screenStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $screenStandardTime->size_type_time = $request->size_type[1];
                    $screenStandardTime->volt_time = $request->volt[1];
                    $screenStandardTime->overLapStandard_time = $request->overLapStandard[1];
                    $screenStandardTime->outerDiameter_time = $request->outerDiameter[1];
                    $screenStandardTime->numberOfWire_wireDim_time = $request->numberOfWire_wireDim[1];
                    $screenStandardTime->tape_wire_weight_time = $request->tape_wire_weight[1];
                    $screenStandardTime->added_by = $name;
                    $screenStandardTime->shift = $shift;
                    $screenStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('screenstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                if (empty($request->overLapActual1[0]) && (!empty($request->overLapActual2[0]) || !empty($request->overLapActual3[0]) || !empty($request->overLapActual4[0]))) {
                    return 'Error-overLapActual1';
                }

                if (empty($request->dimAfter1[0]) && (!empty($request->dimAfter2[0]) || !empty($request->dimAfter3[0]) || !empty($request->dimAfter4[0]))) {
                    return 'Error-dimAfter1';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                //To Add New ScreenActual
                $screenActual = new ScreenActual();
                $screenActual->jopOrderNumber_id = $jopOrderNumber_id;
                $screenActual->jopOrderNumber = $request->jopOrderNumber[0];
                $screenActual->machine = $request->machine[0];
                $screenActual->inputDrum = $request->inputDrum[0];
                $screenActual->inputCard = $request->inputCard[0];
                $screenActual->inputLength = $request->inputLength[0];
                $screenActual->outputDrum = $request->outputDrum[0];
                $screenActual->outputCard = $request->outputCard[0];
                $screenActual->outputLength = $request->outputLength[0];
                $screenActual->color = $request->color[0];
                $screenActual->tapeWeight = $request->tapeWeight[0];
                $screenActual->wireWeight = $request->wireWeight[0];
                $screenActual->overLapActual1 = $request->overLapActual1[0];
                $screenActual->overLapActual2 = $request->overLapActual2[0];
                $screenActual->overLapActual3 = $request->overLapActual3[0];
                $screenActual->overLapActual4 = $request->overLapActual4[0];
                $screenActual->dimAfter1 = $request->dimAfter1[0];
                $screenActual->dimAfter2 = $request->dimAfter2[0];
                $screenActual->dimAfter3 = $request->dimAfter3[0];
                $screenActual->dimAfter4 = $request->dimAfter4[0];
                $screenActual->tapeDimention = $request->tapeDimention[0];
                $screenActual->status = $request->status[0];
                $screenActual->productionOperator = $request->productionOperator[0];
                $screenActual->notes = $request->notes[0];
                $screenActual->added_by = $name;
                $screenActual->shift = $shift;
                $screenActual->save();

                //To  Add New ScreenActualTimes
                $screenActualTime = new ScreenActualsTimes();
                $screenActualTime->screenactuals_id = $screenActual->id;
                $screenActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $screenActualTime->machine_time = $request->machine[1];
                $screenActualTime->inputDrum_time = $request->inputDrum[1];
                $screenActualTime->inputCard_time = $request->inputCard[1];
                $screenActualTime->inputLength_time = $request->inputLength[1];
                $screenActualTime->outputDrum_time = $request->outputDrum[1];
                $screenActualTime->outputCard_time = $request->outputCard[1];
                $screenActualTime->outputLength_time = $request->outputLength[1];
                $screenActualTime->color_time = $request->color[1];
                $screenActualTime->tapeWeight_time = $request->tapeWeight[1];
                $screenActualTime->wireWeight_time = $request->wireWeight[1];
                $screenActualTime->overLapActual1_time = $request->overLapActual1[1];
                $screenActualTime->overLapActual2_time = $request->overLapActual2[1];
                $screenActualTime->overLapActual3_time = $request->overLapActual3[1];
                $screenActualTime->overLapActual4_time = $request->overLapActual4[1];
                $screenActualTime->dimAfter1_time = $request->dimAfter1[1];
                $screenActualTime->dimAfter2_time = $request->dimAfter2[1];
                $screenActualTime->dimAfter3_time = $request->dimAfter3[1];
                $screenActualTime->dimAfter4_time = $request->dimAfter4[1];
                $screenActualTime->tapeDimention_time = $request->tapeDimention[1];
                $screenActualTime->status_time = $request->status[1];
                $screenActualTime->productionOperator_time = $request->productionOperator[1];
                $screenActualTime->notes_time = $request->notes[1];
                $screenActualTime->added_by = $name;
                $screenActualTime->shift = $shift;
                $screenActualTime->save();

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
                        "screen_id" => $screenActual->id,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold                
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $screenActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->size_type[0] == null) ? '' : $request->size_type[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = '';
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Screen";
                    $hold->added_by = $name;
                    $hold->shift = $shift;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = ($request->jopOrderNumber[1] == null) ? '' : $request->jopOrderNumber[1];
                    $holdTime->drumNumber_time = ($request->outputDrum[1] == null) ? '' : $request->outputDrum[1];
                    $holdTime->cableSize_time = ($request->size_type[1] == null) ? '' : $request->size_type[1];
                    $holdTime->length_time = ($request->outputLength[1] == null) ? '' : $request->outputLength[1];
                    $holdTime->description_time = '';
                    $holdTime->machine_time = ($request->machine[1] == null) ? '' : $request->machine[1];
                    $holdTime->reasonOfHold_time = ($request->notes[1] == null) ? '' : $request->notes[1];
                    $holdTime->added_by = $name;
                    $holdTime->shift = $shift;
                    $holdTime->save();
                }

                //To save change That Happend in Screen Table
                $screens = DB::table('screens')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'size_type' => '',
                    'volt' => '',
                    'overLapStandard' => '',
                    'outerDiameter' => '',
                    'numberOfWire_wireDim' => '',
                    'tape_wire_weight' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'color' => '',
                    'tapeWeight' => '',
                    'wireWeight' => '',
                    'overLapActual1' => '',
                    'overLapActual2' => '',
                    'overLapActual3' => '',
                    'overLapActual4' => '',
                    'dimAfter1' => '',
                    'dimAfter2' => '',
                    'dimAfter3' => '',
                    'dimAfter4' => '',
                    'tapeDimention' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size_type',
                    'volt',
                    'overLapStandard',
                    'outerDiameter',
                    'numberOfWire_wireDim',
                    'tape_wire_weight',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'color',
                    'tapeWeight',
                    'wireWeight',
                    'overLapActual1',
                    'overLapActual2',
                    'overLapActual3',
                    'overLapActual4',
                    'dimAfter1',
                    'dimAfter2',
                    'dimAfter3',
                    'dimAfter4',
                    'tapeDimention',
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
                    '',
                    ''
                );
                event(new WatchingEmployee('screen', $request->data_form_item, $attributes, $values));
            } else {

                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('screenactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('screenactuals')->find($request->id_update)->shift;

                if (empty($request->overLapActual1[0]) && (!empty($request->overLapActual2[0]) || !empty($request->overLapActual3[0]) || !empty($request->overLapActual4[0]))) {
                    return 'Error-overLapActual1';
                }

                if (empty($request->dimAfter1[0]) && (!empty($request->dimAfter2[0]) || !empty($request->dimAfter3[0]) || !empty($request->dimAfter4[0]))) {
                    return 'Error-dimAfter1';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                $rowDataScreenActual = DB::table('screenactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'inputDrum' => $request->inputDrum[0],
                        'inputCard' => $request->inputCard[0],
                        'inputLength' => $request->inputCard[0],
                        'outputDrum' => $request->outputDrum[0],
                        'outputCard' => $request->outputCard[0],
                        'outputLength' => $request->outputCard[0],
                        'color' => $request->color[0],
                        'tapeWeight' => $request->tapeWeight[0],
                        'wireWeight' => $request->wireWeight[0],
                        'overLapActual1' => $request->overLapActual1[0],
                        'overLapActual2' => $request->overLapActual2[0],
                        'overLapActual3' => $request->overLapActual3[0],
                        'overLapActual4' => $request->overLapActual4[0],
                        'dimAfter1' => $request->dimAfter1[0],
                        'dimAfter2' => $request->dimAfter2[0],
                        'dimAfter3' => $request->dimAfter3[0],
                        'dimAfter4' => $request->dimAfter4[0],
                        'tapeDimention' => $request->tapeDimention[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $rowDataScreenActualTime = DB::table('screenactualstimes')
                    ->where('screenactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'inputDrum_time' => $request->inputDrum[1],
                        'inputCard_time' => $request->inputCard[1],
                        'inputLength_time' => $request->inputCard[1],
                        'outputDrum_time' => $request->outputDrum[1],
                        'outputCard_time' => $request->outputCard[1],
                        'outputLength_time' => $request->outputCard[1],
                        'color_time' => $request->color[1],
                        'tapeWeight_time' => $request->tapeWeight[1],
                        'wireWeight_time' => $request->wireWeight[1],
                        'overLapActual1_time' => $request->overLapActual1[1],
                        'overLapActual2_time' => $request->overLapActual2[1],
                        'overLapActual3_time' => $request->overLapActual3[1],
                        'overLapActual4_time' => $request->overLapActual4[1],
                        'dimAfter1_time' => $request->dimAfter1[1],
                        'dimAfter2_time' => $request->dimAfter2[1],
                        'dimAfter3_time' => $request->dimAfter3[1],
                        'dimAfter4_time' => $request->dimAfter4[1],
                        'tapeDimention_time' => $request->tapeDimention[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'notes_time' => $request->notes[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $checkTraceability = DB::table("traceability")->where('screen_id', $request->id_update)->exists();

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
                        "screen_id" => $request->id_update,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Screen'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = $request->outputDrum[0];
                        $hold->cableSize = $request->size_type[0];
                        $hold->length = $request->outputLength[0];
                        $hold->description = '';
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Screen";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeInsert;
                        $hold->save();

                        // To Add New HoldTime
                        $holdTime = new HoldTime();
                        $holdTime->hold_id = $hold->id;
                        $holdTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                        $holdTime->drumNumber_time = $request->outputDrum[1];
                        $holdTime->cableSize_time = $request->size_type[1];
                        $holdTime->length_time = $request->outputLength[1];
                        $holdTime->description_time = '';
                        $holdTime->machine_time = $request->machine[1];
                        $holdTime->reasonOfHold_time = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Screen'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Screen'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->size_type[0],
                                'length' => $request->outputLength[0],
                                'description' => '',
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Screen",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[1],
                                'drumNumber_time' => $request->outputDrum[1],
                                'cableSize_time' => $request->size_type[1],
                                'length_time' => $request->outputLength[1],
                                'description_time' => '',
                                'machine_time' => $request->machine[1],
                                'reasonOfHold_time' =>  $request->notes[1],
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);
                    }
                }

                //To save change That Happend in Screen Table
                $screens = DB::table('screens')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $shiftOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'size_type' => '',
                    'volt' => '',
                    'overLapStandard' => '',
                    'outerDiameter' => '',
                    'numberOfWire_wireDim' => '',
                    'tape_wire_weight' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'color' => '',
                    'tapeWeight' => '',
                    'wireWeight' => '',
                    'overLapActual1' => '',
                    'overLapActual2' => '',
                    'overLapActual3' => '',
                    'overLapActual4' => '',
                    'dimAfter1' => '',
                    'dimAfter2' => '',
                    'dimAfter3' => '',
                    'dimAfter4' => '',
                    'tapeDimention' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size_type',
                    'volt',
                    'overLapStandard',
                    'outerDiameter',
                    'numberOfWire_wireDim',
                    'tape_wire_weight',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'color',
                    'tapeWeight',
                    'wireWeight',
                    'overLapActual1',
                    'overLapActual2',
                    'overLapActual3',
                    'overLapActual4',
                    'dimAfter1',
                    'dimAfter2',
                    'dimAfter3',
                    'dimAfter4',
                    'tapeDimention',
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
                    '',
                    ''
                );
                event(new WatchingEmployee('screen', $request->data_form_item, $attributes, $values));

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

            $checkJopOrderNumber = DB::table('screenstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $screenStandard = DB::table('screenstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();

                //To save change That Happend in Screen Table
                $screens = DB::table('screens')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $screenStandard->jopOrderNumber,
                    'size_type' => $screenStandard->size_type,
                    'volt' => $screenStandard->volt,
                    'overLapStandard' => $screenStandard->overLapStandard,
                    'outerDiameter' => $screenStandard->outerDiameter,
                    'numberOfWire_wireDim' => $screenStandard->numberOfWire_wireDim,
                    'tape_wire_weight' => $screenStandard->tape_wire_weight
                ]);
                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size_type',
                    'volt',
                    'overLapStandard',
                    'outerDiameter',
                    'numberOfWire_wireDim',
                    'tape_wire_weight'
                );
                $values = array(
                    $screenStandard->jopOrderNumber,
                    $screenStandard->size_type,
                    $screenStandard->volt,
                    $screenStandard->overLapStandard,
                    $screenStandard->outerDiameter,
                    $screenStandard->numberOfWire_wireDim,
                    $screenStandard->tape_wire_weight
                );
                event(new WatchingEmployee('screen', $request->data_form_item, $attributes, $values));

                return (array) $screenStandard;
            } else {

                //To save change That Happend in Screen Table
                $screens = DB::table('screens')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'size_type' => '',
                    'volt' => '',
                    'overLapStandard' => '',
                    'outerDiameter' => '',
                    'numberOfWire_wireDim' => '',
                    'tape_wire_weight' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size_type',
                    'volt',
                    'overLapStandard',
                    'outerDiameter',
                    'numberOfWire_wireDim',
                    'tape_wire_weight'
                );
                $values = array(
                    $request->jopOrderNumber,
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('screen', $request->data_form_item, $attributes, $values));

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

            //  return $request;

            $alertIsExist = DB::table('screenactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataScreenActual = DB::table('screenactuals')->where('id', $request->id)->first();
            $rowDataScreenStandard = DB::table('screenstandards')->where('id', $rowDataScreenActual->jopOrderNumber_id)->first();
            $rowDataScreenActualTime = DB::table('screenactualstimes')->where('id', $request->id)->first();
            $rowDataScreenStandardTime = DB::table('screenstandardstimes')->where('id', $rowDataScreenActual->jopOrderNumber_id)->first();

            //To save change That Happend in Screen Table
            $screens = DB::table('screens')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataScreenStandard->jopOrderNumber == null) ? '' : $rowDataScreenStandard->jopOrderNumber,
                'size_type' => ($rowDataScreenStandard->size_type == null) ? '' : $rowDataScreenStandard->size_type,
                'volt' => ($rowDataScreenStandard->volt == null) ? '' : $rowDataScreenStandard->volt,
                'overLapStandard' => ($rowDataScreenStandard->overLapStandard == null) ? '' : $rowDataScreenStandard->overLapStandard,
                'outerDiameter' => ($rowDataScreenStandard->outerDiameter == null) ? '' : $rowDataScreenStandard->outerDiameter,
                'numberOfWire_wireDim' => ($rowDataScreenStandard->numberOfWire_wireDim == null) ? '' : $rowDataScreenStandard->numberOfWire_wireDim,
                'tape_wire_weight' => ($rowDataScreenStandard->tape_wire_weight == null) ? '' : $rowDataScreenStandard->tape_wire_weight,
                'machine' => ($rowDataScreenActual->machine == null) ? '' : $rowDataScreenActual->machine,
                'inputDrum' => ($rowDataScreenActual->inputDrum == null) ? '' : $rowDataScreenActual->inputDrum,
                'inputCard' => ($rowDataScreenActual->inputCard == null) ? '' : $rowDataScreenActual->inputCard,
                'inputLength' => ($rowDataScreenActual->inputLength == null) ? '' : $rowDataScreenActual->inputLength,
                'outputDrum' => ($rowDataScreenActual->outputDrum == null) ? '' : $rowDataScreenActual->outputDrum,
                'outputCard' => ($rowDataScreenActual->outputCard == null) ? '' : $rowDataScreenActual->outputCard,
                'outputLength' => ($rowDataScreenActual->outputLength == null) ? '' : $rowDataScreenActual->outputLength,
                'color' => ($rowDataScreenActual->color == null) ? '' : $rowDataScreenActual->color,
                'tapeWeight' => ($rowDataScreenActual->tapeWeight == null) ? '' : $rowDataScreenActual->tapeWeight,
                'wireWeight' => ($rowDataScreenActual->wireWeight == null) ? '' : $rowDataScreenActual->wireWeight,
                'overLapActual1' => ($rowDataScreenActual->overLapActual1 == null) ? '' : $rowDataScreenActual->overLapActual1,
                'overLapActual2' => ($rowDataScreenActual->overLapActual2 == null) ? '' : $rowDataScreenActual->overLapActual2,
                'overLapActual3' => ($rowDataScreenActual->overLapActual3 == null) ? '' : $rowDataScreenActual->overLapActual3,
                'overLapActual4' => ($rowDataScreenActual->overLapActual4 == null) ? '' : $rowDataScreenActual->overLapActual4,
                'dimAfter1' => ($rowDataScreenActual->dimAfter1 == null) ? '' : $rowDataScreenActual->dimAfter1,
                'dimAfter2' => ($rowDataScreenActual->dimAfter2 == null) ? '' : $rowDataScreenActual->dimAfter2,
                'dimAfter3' => ($rowDataScreenActual->dimAfter3 == null) ? '' : $rowDataScreenActual->dimAfter3,
                'dimAfter4' => ($rowDataScreenActual->dimAfter4 == null) ? '' : $rowDataScreenActual->dimAfter4,
                'tapeDimention' => ($rowDataScreenActual->tapeDimention == null) ? '' : $rowDataScreenActual->tapeDimention,
                'status' => ($rowDataScreenActual->status == null) ? '' : $rowDataScreenActual->status,
                'productionOperator' => ($rowDataScreenActual->productionOperator == null) ? '' : $rowDataScreenActual->productionOperator,
                'notes' => ($rowDataScreenActual->notes == null) ? '' : $rowDataScreenActual->notes
            ]);

            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'size_type',
                'volt',
                'overLapStandard',
                'outerDiameter',
                'numberOfWire_wireDim',
                'tape_wire_weight',
                'machine',
                'inputDrum',
                'inputCard',
                'inputLength',
                'outputDrum',
                'outputCard',
                'outputLength',
                'color',
                'tapeWeight',
                'wireWeight',
                'overLapActual1',
                'overLapActual2',
                'overLapActual3',
                'overLapActual4',
                'dimAfter1',
                'dimAfter2',
                'dimAfter3',
                'dimAfter4',
                'tapeDimention',
                'status',
                'productionOperator',
                'notes',
                'added_by'
            );
            $values = array(
                $rowDataScreenStandard->jopOrderNumber,
                $rowDataScreenStandard->size_type,
                $rowDataScreenStandard->volt,
                $rowDataScreenStandard->overLapStandard,
                $rowDataScreenStandard->outerDiameter,
                $rowDataScreenStandard->numberOfWire_wireDim,
                $rowDataScreenStandard->tape_wire_weight,
                $rowDataScreenActual->machine,
                $rowDataScreenActual->inputDrum,
                $rowDataScreenActual->inputCard,
                $rowDataScreenActual->inputLength,
                $rowDataScreenActual->outputDrum,
                $rowDataScreenActual->outputCard,
                $rowDataScreenActual->outputLength,
                $rowDataScreenActual->color,
                $rowDataScreenActual->tapeWeight,
                $rowDataScreenActual->wireWeight,
                $rowDataScreenActual->overLapActual1,
                $rowDataScreenActual->overLapActual2,
                $rowDataScreenActual->overLapActual3,
                $rowDataScreenActual->overLapActual4,
                $rowDataScreenActual->dimAfter1,
                $rowDataScreenActual->dimAfter2,
                $rowDataScreenActual->dimAfter3,
                $rowDataScreenActual->dimAfter4,
                $rowDataScreenActual->tapeDimention,
                $rowDataScreenActual->status,
                $rowDataScreenActual->productionOperator,
                $rowDataScreenActual->notes
            );
            event(new WatchingEmployee('screen', $request->data_form_item, $attributes, $values));

            return array(
                $rowDataScreenStandard,
                $rowDataScreenActual,
                $rowDataScreenActualTime,
                $rowDataScreenStandardTime
            );
        }
    }

    public function checkRow(Request $request)
    {
        if ($request->ajax()) {

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            // return $request;

            //To Check About "who did make insert ?"
            $name = Auth::guard('web')->user()->name;

            $rowUpdateData = DB::table('screens')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('screen', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if ($request->input['name'] == "overLapActual") {

                $dataRow = DB::table('screens')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();

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
        } else {
            DB::table('users')->where('id', Auth::user()->id)->update([
                'online' => false
            ]);
            Auth::logout();
            return "Logout";
        }
    }
}
