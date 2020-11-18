<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Events\WatchingEmployee;
use App\Hold;
use App\HoldTime;
use App\TapsActual;
use App\TapsActualsTimes;
use App\TapsStandard;
use App\TapsStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TapsController extends Controller
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

    public function insertTaps(Request $request)
    {
        if ($request->ajax()) {
            $this->request = $request;
            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }
            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('tapsstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;

                if (!$checkJopOrderNumber) {

                    //To Add New TapsStansard
                    $tapsStandard = new TapsStandard();
                    $tapsStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $tapsStandard->cableSize = $request->cableSize[0];
                    $tapsStandard->volt = $request->volt[0];
                    $tapsStandard->overLapStandard = $request->overLapStandard[0];
                    $tapsStandard->tapeDimentionStandard = $request->tapeDimentionStandard[0];
                    $tapsStandard->outerDiameter = $request->outerDiameter[0];
                    $tapsStandard->tapeWeightStandard = $request->tapeWeightStandard[0];
                    $tapsStandard->added_by = $name;
                    $tapsStandard->shift = $shift;
                    $tapsStandard->save();

                    $jopOrderNumber_id = DB::table('tapsstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New TapsStansardTimes
                    $tapsStandardTime = new TapsStandardsTimes();
                    $tapsStandardTime->tapsstandards_id = $jopOrderNumber_id;
                    $tapsStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $tapsStandardTime->cableSize_time = $request->cableSize[1];
                    $tapsStandardTime->volt_time = $request->volt[1];
                    $tapsStandardTime->overLapStandard_time = $request->overLapStandard[1];
                    $tapsStandardTime->tapeDimentionStandard_time = $request->tapeDimentionStandard[1];
                    $tapsStandardTime->outerDiameter_time = $request->outerDiameter[1];
                    $tapsStandardTime->tapeWeightStandard_time = $request->tapeWeightStandard[1];
                    $tapsStandardTime->added_by = $name;
                    $tapsStandardTime->shift = $shift;
                    $tapsStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('tapsstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                //To Add New TapsActual
                $tapsActual = new TapsActual();
                $tapsActual->jopOrderNumber_id = $jopOrderNumber_id;
                $tapsActual->jopOrderNumber = $request->jopOrderNumber[0];
                $tapsActual->machine = $request->machine[0];
                $tapsActual->inputDrum = $request->inputDrum[0];
                $tapsActual->inputCard = $request->inputCard[0];
                $tapsActual->inputLength = $request->inputLength[0];
                $tapsActual->outputDrum = $request->outputDrum[0];
                $tapsActual->outputCard = $request->outputCard[0];
                $tapsActual->outputLength = $request->outputLength[0];
                $tapsActual->tapeDimentionActual = $request->tapeDimentionActual[0];
                $tapsActual->tapeWeightActual = $request->tapeWeightActual[0];
                $tapsActual->overLapActual = $request->overLapActual[0];
                $tapsActual->dimAfter = $request->dimAfter[0];
                $tapsActual->status = $request->status[0];
                $tapsActual->productionOperator = $request->productionOperator[0];
                $tapsActual->notes = $request->notes[0];
                $tapsActual->added_by = $name;
                $tapsActual->shift = $shift;
                $tapsActual->save();

                //To  Add New TapsActualTimes
                $tapsActualTime = new TapsActualsTimes();
                $tapsActualTime->tapsactuals_id = $tapsActual->id;
                $tapsActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $tapsActualTime->machine_time = $request->machine[1];
                $tapsActualTime->inputDrum_time = $request->inputDrum[1];
                $tapsActualTime->inputCard_time = $request->inputCard[1];
                $tapsActualTime->inputLength_time = $request->inputLength[1];
                $tapsActualTime->outputDrum_time = $request->outputDrum[1];
                $tapsActualTime->outputCard_time = $request->outputCard[1];
                $tapsActualTime->outputLength_time = $request->outputLength[1];
                $tapsActualTime->tapeDimentionActual_time = $request->tapeDimentionActual[1];
                $tapsActualTime->tapeWeightActual_time = $request->tapeWeightActual[1];
                $tapsActualTime->overLapActual_time = $request->overLapActual[1];
                $tapsActualTime->dimAfter_time = $request->dimAfter[1];
                $tapsActualTime->status_time = $request->status[1];
                $tapsActualTime->productionOperator_time = $request->productionOperator[1];
                $tapsActualTime->notes_time = $request->notes[1];
                $tapsActualTime->added_by = $name;
                $tapsActualTime->shift = $shift;
                $tapsActualTime->save();

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
                        "taps_id" => $tapsActual->id,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $tapsActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->cableSize[0] == null) ? '' : $request->cableSize[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = '';
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Taps";
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

                //To save change That Happend in Taps Table
                $taps = DB::table('taps')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'volt' => '',
                    'overLapStandard' => '',
                    'tapeDimentionStandard' => '',
                    'outerDiameter' => '',
                    'tapeWeightStandard' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'tapeDimentionActual' => '',
                    'tapeWeightActual' => '',
                    'overLapActual' => '',
                    'dimAfter' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'overLapStandard',
                    'tapeDimentionStandard',
                    'outerDiameter',
                    'tapeWeightStandard',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'tapeDimentionActual',
                    'tapeWeightActual',
                    'overLapActual',
                    'dimAfter',
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
                    ''
                );
                event(new WatchingEmployee('taps', $request->data_form_item, $attributes, $values));
            } else {

                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('tapsactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('tapsactuals')->find($request->id_update)->shift;

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                $rowDataTapsActual = DB::table('tapsactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'inputDrum' => $request->inputDrum[0],
                        'inputCard' => $request->inputCard[0],
                        'inputLength' => $request->inputCard[0],
                        'outputDrum' => $request->outputDrum[0],
                        'outputCard' => $request->outputCard[0],
                        'outputLength' => $request->outputCard[0],
                        'tapeDimentionActual' => $request->tapeDimentionActual[0],
                        'tapeWeightActual' => $request->tapeWeightActual[0],
                        'overLapActual' => $request->overLapActual[0],
                        'dimAfter' => $request->dimAfter[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);
                $rowDataTapsActualTime = DB::table('tapsactualstimes')
                    ->where('tapsactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'inputDrum_time' => $request->inputDrum[1],
                        'inputCard_time' => $request->inputCard[1],
                        'inputLength_time' => $request->inputCard[1],
                        'outputDrum_time' => $request->outputDrum[1],
                        'outputCard_time' => $request->outputCard[1],
                        'outputLength_time' => $request->outputCard[1],
                        'tapeDimentionActual_time' => $request->tapeDimentionActual[1],
                        'tapeWeightActual_time' => $request->tapeWeightActual[1],
                        'overLapActual_time' => $request->overLapActual[1],
                        'dimAfter_time' => $request->dimAfter[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'notes_time' => $request->notes[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $checkTraceability = DB::table("traceability")->where('taps_id', $request->id_update)->exists();

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
                        "taps_id" => $request->id_update,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Taps'], ['sheet_id', $request->id_update]])->exists();
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
                        $hold->fromSheet = "Taps";
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
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Taps'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Taps'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->cableSize[0],
                                'length' => $request->outputLength[0],
                                'description' => '',
                                'machine' => $request->machine[0],
                                'reasonOfHold' => $request->notes[0],
                                'fromSheet' => "Taps",
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

                //To save change That Happend in Taps Table
                $taps = DB::table('taps')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $nameOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'volt' => '',
                    'overLapStandard' => '',
                    'tapeDimentionStandard' => '',
                    'outerDiameter' => '',
                    'tapeWeightStandard' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'tapeDimentionActual' => '',
                    'tapeWeightActual' => '',
                    'overLapActual' => '',
                    'dimAfter' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'overLapStandard',
                    'tapeDimentionStandard',
                    'outerDiameter',
                    'tapeWeightStandard',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'tapeDimentionActual',
                    'tapeWeightActual',
                    'overLapActual',
                    'dimAfter',
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
                    ''
                );
                event(new WatchingEmployee('taps', $request->data_form_item, $attributes, $values));

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

            $checkJopOrderNumber = DB::table('tapsstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $tapsStandard = DB::table('tapsstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();

                //To save change That Happend in Taps Table
                $taps = DB::table('taps')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $tapsStandard->jopOrderNumber,
                    'cableSize' => $tapsStandard->cableSize,
                    'volt' => $tapsStandard->volt,
                    'overLapStandard' => $tapsStandard->overLapStandard,
                    'tapeDimentionStandard' => $tapsStandard->tapeDimentionStandard,
                    'outerDiameter' => $tapsStandard->outerDiameter,
                    'tapeWeightStandard' => $tapsStandard->tapeWeightStandard
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'overLapStandard',
                    'tapeDimentionStandard',
                    'outerDiameter',
                    'tapeWeightStandard'
                );
                $values = array(
                    $tapsStandard->jopOrderNumber,
                    $tapsStandard->cableSize,
                    $tapsStandard->volt,
                    $tapsStandard->overLapStandard,
                    $tapsStandard->tapeDimentionStandard,
                    $tapsStandard->outerDiameter,
                    $tapsStandard->tapeWeightStandard
                );
                event(new WatchingEmployee('taps', $request->data_form_item, $attributes, $values));

                return (array) $tapsStandard;
            } else {

                //To save change That Happend in Taps Table
                $taps = DB::table('taps')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'cableSize' => '',
                    'volt' => '',
                    'overLapStandard' => '',
                    'tapeDimentionStandard' => '',
                    'outerDiameter' => '',
                    'tapeWeightStandard' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'volt',
                    'overLapStandard',
                    'tapeDimentionStandard',
                    'outerDiameter',
                    'tapeWeightStandard'
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
                event(new WatchingEmployee('taps', $request->data_form_item, $attributes, $values));

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

            $alertIsExist = DB::table('Tapsactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataTapsActual = DB::table('Tapsactuals')->where('id', $request->id)->first();
            $rowDataTapsStandard = DB::table('Tapsstandards')->where('id', $rowDataTapsActual->jopOrderNumber_id)->first();
            $rowDataTapsActualTime = DB::table('Tapsactualstimes')->where('id', $request->id)->first();
            $rowDataTapsStandardTime = DB::table('Tapsstandardstimes')->where('id', $rowDataTapsActual->jopOrderNumber_id)->first();

            //To save change That Happend in Taps Table
            $taps = DB::table('taps')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataTapsStandard->jopOrderNumber == null) ? '' : $rowDataTapsStandard->jopOrderNumber,
                'cableSize' => ($rowDataTapsStandard->cableSize == null) ? '' : $rowDataTapsStandard->cableSize,
                'volt' => ($rowDataTapsStandard->volt == null) ? '' : $rowDataTapsStandard->volt,
                'overLapStandard' => ($rowDataTapsStandard->overLapStandard == null) ? '' : $rowDataTapsStandard->overLapStandard,
                'tapeDimentionStandard' => ($rowDataTapsStandard->tapeDimentionStandard == null) ? '' : $rowDataTapsStandard->tapeDimentionStandard,
                'outerDiameter' => ($rowDataTapsStandard->outerDiameter == null) ? '' : $rowDataTapsStandard->outerDiameter,
                'tapeWeightStandard' => ($rowDataTapsStandard->tapeWeightStandard == null) ? '' : $rowDataTapsStandard->tapeWeightStandard,
                'machine' => ($rowDataTapsActual->machine == null) ? '' : $rowDataTapsActual->machine,
                'inputDrum' => ($rowDataTapsActual->inputDrum == null) ? '' : $rowDataTapsActual->inputDrum,
                'inputCard' => ($rowDataTapsActual->inputCard == null) ? '' : $rowDataTapsActual->inputCard,
                'inputLength' => ($rowDataTapsActual->inputLength == null) ? '' : $rowDataTapsActual->inputLength,
                'outputDrum' => ($rowDataTapsActual->outputDrum == null) ? '' : $rowDataTapsActual->outputDrum,
                'outputCard' => ($rowDataTapsActual->outputCard == null) ? '' : $rowDataTapsActual->outputCard,
                'outputLength' => ($rowDataTapsActual->outputLength == null) ? '' : $rowDataTapsActual->outputLength,
                'tapeDimentionActual' => ($rowDataTapsActual->tapeDimentionActual == null) ? '' : $rowDataTapsActual->tapeDimentionActual,
                'tapeWeightActual' => ($rowDataTapsActual->tapeWeightActual == null) ? '' : $rowDataTapsActual->tapeWeightActual,
                'overLapActual' => ($rowDataTapsActual->overLapActual == null) ? '' : $rowDataTapsActual->overLapActual,
                'dimAfter' => ($rowDataTapsActual->dimAfter == null) ? '' : $rowDataTapsActual->dimAfter,
                'status' => ($rowDataTapsActual->status == null) ? '' : $rowDataTapsActual->status,
                'productionOperator' => ($rowDataTapsActual->productionOperator == null) ? '' : $rowDataTapsActual->productionOperator,
                'notes' => ($rowDataTapsActual->notes == null) ? '' : $rowDataTapsActual->notes
            ]);

            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'cableSize',
                'volt',
                'overLapStandard',
                'tapeDimentionStandard',
                'outerDiameter',
                'tapeWeightStandard',
                'machine',
                'inputDrum',
                'inputCard',
                'inputLength',
                'outputDrum',
                'outputCard',
                'outputLength',
                'tapeDimentionActual',
                'tapeWeightActual',
                'overLapActual',
                'dimAfter',
                'status',
                'productionOperator',
                'notes'
            );
            $values = array(
                $rowDataTapsStandard->jopOrderNumber,
                $rowDataTapsStandard->cableSize,
                $rowDataTapsStandard->volt,
                $rowDataTapsStandard->overLapStandard,
                $rowDataTapsStandard->tapeDimentionStandard,
                $rowDataTapsStandard->outerDiameter,
                $rowDataTapsStandard->tapeWeightStandard,
                $rowDataTapsActual->machine,
                $rowDataTapsActual->inputDrum,
                $rowDataTapsActual->inputCard,
                $rowDataTapsActual->inputLength,
                $rowDataTapsActual->outputDrum,
                $rowDataTapsActual->outputCard,
                $rowDataTapsActual->outputLength,
                $rowDataTapsActual->tapeDimentionActual,
                $rowDataTapsActual->tapeWeightActual,
                $rowDataTapsActual->overLapActual,
                $rowDataTapsActual->dimAfter,
                $rowDataTapsActual->status,
                $rowDataTapsActual->productionOperator,
                $rowDataTapsActual->notes
            );
            event(new WatchingEmployee('taps', $request->data_form_item, $attributes, $values));

            return array(
                $rowDataTapsStandard,
                $rowDataTapsActual,
                $rowDataTapsActualTime,
                $rowDataTapsStandardTime
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

            $rowUpdateData = DB::table('taps')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('taps', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if (false) {


                $dataRow = DB::table('taps')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();

                if (false) {

                    $message = ['employee' => $name, 'Sheet' => 'Taps', 'errors' => 'wireDimActual'];

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
