<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\AssemblyActual;
use App\AssemblyActualsTimes;
use App\AssemblyStandard;
use App\AssemblyStandardsTimes;
use App\Events\WatchingEmployee;
use App\Hold;
use App\HoldTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssemblyController extends Controller
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

    public function insertAssembly(Request $request)
    {
        if ($request->ajax()) {
            $this->request = $request;

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            if ($request->update == 'false') {
                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();
                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New AssemblyStansard
                    $assemblyStandard = new AssemblyStandard();
                    $assemblyStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $assemblyStandard->cableSize = $request->cableSize[0];
                    $assemblyStandard->cableDescription = $request->cableDescription[0];
                    $assemblyStandard->outerDimMinStandard = $request->outerDimMinStandard[0];
                    $assemblyStandard->outerDimNomStandard = $request->outerDimNomStandard[0];
                    $assemblyStandard->outerDimMaxStandard = $request->outerDimMaxStandard[0];
                    $assemblyStandard->fillerStandard = $request->fillerStandard[0];
                    $assemblyStandard->twistedStandard = $request->twistedStandard[0];
                    $assemblyStandard->overLap = $request->overLap[0];
                    $assemblyStandard->ovalityStandard = $request->ovalityStandard[0];
                    $assemblyStandard->layLengthStandard = $request->layLengthStandard[0];
                    $assemblyStandard->added_by = $name;
                    $assemblyStandard->shift = $shift;
                    $assemblyStandard->save();

                    $jopOrderNumber_id = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New AssemblyStansardTimes
                    $assemblyStandardTime = new AssemblyStandardsTimes();
                    $assemblyStandardTime->assemblystandards_id = $jopOrderNumber_id;
                    $assemblyStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $assemblyStandardTime->cableSize_time = $request->cableSize[1];
                    $assemblyStandardTime->cableDescription_time = $request->cableDescription[1];
                    $assemblyStandardTime->outerDimMinStandard_time = $request->outerDimMinStandard[1];
                    $assemblyStandardTime->outerDimNomStandard_time = $request->outerDimNomStandard[1];
                    $assemblyStandardTime->outerDimMaxStandard_time = $request->outerDimMaxStandard[1];
                    $assemblyStandardTime->fillerStandard_time = $request->fillerStandard[1];
                    $assemblyStandardTime->twistedStandard_time = $request->twistedStandard[1];
                    $assemblyStandardTime->overLap_time = $request->overLap[1];
                    $assemblyStandardTime->ovalityStandard_time = $request->ovalityStandard[1];
                    $assemblyStandardTime->layLengthStandard_time = $request->layLengthStandard[1];
                    $assemblyStandardTime->added_by = $name;
                    $assemblyStandardTime->shift = $shift;
                    $assemblyStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                $regex_color = "/^([A-z]+)?$/";

                if (
                    empty($request->inputDrum1[0]) &&
                    (!empty($request->inputDrum2[0]) || !empty($request->inputDrum3[0]) || !empty($request->inputDrum4[0]) || !empty($request->inputDrum5[0]))
                ) {
                    return 'Error-inputDrum1';
                }

                if (
                    empty($request->inputCard1[0]) &&
                    (!empty($request->inputCard2[0]) || !empty($request->inputCard3[0]) || !empty($request->inputCard4[0]) || !empty($request->inputCard5[0]))
                ) {
                    return 'Error-inputCard1';
                }

                if (
                    empty($request->inputLength1[0]) &&
                    (!empty($request->inputLength2[0]) || !empty($request->inputLength3[0]) || !empty($request->inputLength4[0]) || !empty($request->inputLength5[0]))
                ) {
                    return 'Error-inputLength1';
                }

                if (!preg_match($regex_color, $request->color1[0]) || (empty($request->color1[0]) && (!empty($request->color2[0]) || !empty($request->color3[0]) || !empty($request->color4[0]) || !empty($request->color5[0])))) {
                    return "Error-color1";
                }

                if (!preg_match($regex_color, $request->color2[0])) {
                    return "Error-color2";
                }

                if (!preg_match($regex_color, $request->color3[0])) {
                    return "Error-color3";
                }

                if (!preg_match($regex_color, $request->color4[0])) {
                    return "Error-color4";
                }

                if (!preg_match($regex_color, $request->color5[0])) {
                    return "Error-color5";
                }

                if (
                    (empty($request->outerDimMinActual[0]) || empty($request->outerDimNomActual[0]) || empty($request->outerDimMaxActual[0])) &&
                    (!empty($request->outerDimMinActual[0]) || !empty($request->outerDimNomActual[0]) || !empty($request->outerDimMaxActual[0]))
                ) {
                    return 'Error-outerDimActual';
                }

                if (
                    (empty($request->ppTapeSize[0]) || empty($request->ppTapeOverLap[0])) &&
                    (!empty($request->ppTapeSize[0]) || !empty($request->ppTapeOverLap[0]))
                ) {
                    return 'Error-ppTape';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }


                //To Add New AssemblyActual
                $assemblyActual = new AssemblyActual();
                $assemblyActual->jopOrderNumber_id = $jopOrderNumber_id;
                $assemblyActual->jopOrderNumber = $request->jopOrderNumber[0];
                $assemblyActual->machine = $request->machine[0];
                $assemblyActual->inputDrum1 = $request->inputDrum1[0];
                $assemblyActual->inputDrum2 = $request->inputDrum2[0];
                $assemblyActual->inputDrum3 = $request->inputDrum3[0];
                $assemblyActual->inputDrum4 = $request->inputDrum4[0];
                $assemblyActual->inputDrum5 = $request->inputDrum5[0];
                $assemblyActual->inputCard1 = $request->inputCard1[0];
                $assemblyActual->inputCard2 = $request->inputCard2[0];
                $assemblyActual->inputCard3 = $request->inputCard3[0];
                $assemblyActual->inputCard4 = $request->inputCard4[0];
                $assemblyActual->inputCard5 = $request->inputCard5[0];
                $assemblyActual->inputLength1 = $request->inputLength1[0];
                $assemblyActual->inputLength2 = $request->inputLength2[0];
                $assemblyActual->inputLength3 = $request->inputLength3[0];
                $assemblyActual->inputLength4 = $request->inputLength4[0];
                $assemblyActual->inputLength5 = $request->inputLength5[0];
                $assemblyActual->color1 = $request->color1[0];
                $assemblyActual->color2 = $request->color2[0];
                $assemblyActual->color3 = $request->color3[0];
                $assemblyActual->color4 = $request->color4[0];
                $assemblyActual->color5 = $request->color5[0];
                $assemblyActual->outputDrum = $request->outputDrum[0];
                $assemblyActual->outputCard = $request->outputCard[0];
                $assemblyActual->outputLength = $request->outputLength[0];
                $assemblyActual->outerDimMinActual = $request->outerDimMinActual[0];
                $assemblyActual->outerDimNomActual = $request->outerDimNomActual[0];
                $assemblyActual->outerDimMaxActual = $request->outerDimMaxActual[0];
                $assemblyActual->ovalityActual = $request->ovalityActual[0];
                $assemblyActual->layLengthActual = $request->layLengthActual[0];
                $assemblyActual->direction = $request->direction[0];
                $assemblyActual->fillerActual = $request->fillerActual[0];
                $assemblyActual->twistedActual = $request->twistedActual[0];
                $assemblyActual->ppTapeSize = $request->ppTapeSize[0];
                $assemblyActual->ppTapeOverLap = $request->ppTapeOverLap[0];
                $assemblyActual->status = $request->status[0];
                $assemblyActual->productionOperator = $request->productionOperator[0];
                $assemblyActual->notes = $request->notes[0];
                $assemblyActual->added_by = $name;
                $assemblyActual->shift = $shift;
                $assemblyActual->save();

                //To  Add New AssemblyActualTimes
                $assemblyActualTime = new AssemblyActualsTimes();
                $assemblyActualTime->assemblyactuals_id = $assemblyActual->id;
                $assemblyActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $assemblyActualTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                $assemblyActualTime->machine_time = $request->machine[1];
                $assemblyActualTime->inputDrum1_time = $request->inputDrum1[1];
                $assemblyActualTime->inputDrum2_time = $request->inputDrum2[1];
                $assemblyActualTime->inputDrum3_time = $request->inputDrum3[1];
                $assemblyActualTime->inputDrum4_time = $request->inputDrum4[1];
                $assemblyActualTime->inputDrum5_time = $request->inputDrum5[1];
                $assemblyActualTime->inputCard1_time = $request->inputCard1[1];
                $assemblyActualTime->inputCard2_time = $request->inputCard2[1];
                $assemblyActualTime->inputCard3_time = $request->inputCard3[1];
                $assemblyActualTime->inputCard4_time = $request->inputCard4[1];
                $assemblyActualTime->inputCard5_time = $request->inputCard5[1];
                $assemblyActualTime->inputLength1_time = $request->inputLength1[1];
                $assemblyActualTime->inputLength2_time = $request->inputLength2[1];
                $assemblyActualTime->inputLength3_time = $request->inputLength3[1];
                $assemblyActualTime->inputLength4_time = $request->inputLength4[1];
                $assemblyActualTime->inputLength5_time = $request->inputLength5[1];
                $assemblyActualTime->color1_time = $request->color1[1];
                $assemblyActualTime->color2_time = $request->color2[1];
                $assemblyActualTime->color3_time = $request->color3[1];
                $assemblyActualTime->color4_time = $request->color4[1];
                $assemblyActualTime->color5_time = $request->color5[1];
                $assemblyActualTime->outputDrum_time = $request->outputDrum[1];
                $assemblyActualTime->outputCard_time = $request->outputCard[1];
                $assemblyActualTime->outputLength_time = $request->outputLength[1];
                $assemblyActualTime->outerDimMinActual_time = $request->outerDimMinActual[1];
                $assemblyActualTime->outerDimNomActual_time = $request->outerDimNomActual[1];
                $assemblyActualTime->outerDimMaxActual_time = $request->outerDimMaxActual[1];
                $assemblyActualTime->ovalityActual_time = $request->ovalityActual[1];
                $assemblyActualTime->layLengthActual_time = $request->layLengthActual[1];
                $assemblyActualTime->direction_time = $request->direction[1];
                $assemblyActualTime->fillerActual_time = $request->fillerActual[1];
                $assemblyActualTime->twistedActual_time = $request->twistedActual[1];
                $assemblyActualTime->ppTapeSize_time = $request->ppTapeSize[1];
                $assemblyActualTime->ppTapeOverLap_time = $request->ppTapeOverLap[1];
                $assemblyActualTime->status_time = $request->status[1];
                $assemblyActualTime->productionOperator_time = $request->productionOperator[1];
                $assemblyActualTime->notes_time = $request->notes[1];
                $assemblyActualTime->added_by = $name;
                $assemblyActualTime->shift = $shift;
                $assemblyActualTime->save();

                // Traceability
                if (!empty($request->inputCard1[0]) && !empty($request->outputCard[0])) {
                    $traceability = DB::table("traceability")->where([
                        ['jopOrderNumber', $request->jopOrderNumber[0]]
                    ])
                        ->where(function ($query) {
                            if ($this->request->inputCard1[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard1[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard2[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard2[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard3[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard3[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard4[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard4[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard5[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard5[0]);
                            }
                        });

                    $chain = unserialize($traceability->value('chain'));
                    array_push($chain, $request->outputCard[0]);

                    $traceability->update([
                        "outputCardInsulation1" => null,
                        "outputCardInsulation2" => null,
                        "outputCardInsulation3" => null,
                        "outputCardInsulation4" => null,
                        "outputCardInsulation5" => null,
                        "outputCard" => $request->outputCard[0],
                        "assembly_id" => $assemblyActual->id,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $assemblyActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->cableSize[0] == null) ? '' : $request->cableSize[0];
                    $hold->length = ($request->layLengthActual[0] == null) ? '' : $request->layLengthActual[0];
                    $hold->description = ($request->cableDescription[0] == null) ? '' : $request->cableDescription[0];
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Assembly";
                    $hold->added_by = $name;
                    $hold->shift = $shift;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[1] == null) ? '' : $request->jopOrderNumber[1];
                    $hold->drumNumber = ($request->outputDrum[1] == null) ? '' : $request->outputDrum[1];
                    $hold->cableSize = ($request->cableSize[1] == null) ? '' : $request->cableSize[1];
                    $hold->length = ($request->layLengthActual[1] == null) ? '' : $request->layLengthActual[1];
                    $hold->description = ($request->cableDescription[1] == null) ? '' : $request->cableDescription[1];
                    $hold->machine = ($request->machine[1] == null) ? '' : $request->machine[1];
                    $hold->reasonOfHold = ($request->notes[1] == null) ? '' : $request->notes[1];
                    $holdTime->added_by = $name;
                    $holdTime->shift = $shift;
                    $holdTime->save();
                }

                //To save change That Happend in Assembly Table
                $assemblys = DB::table('assemblys')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'cableDescription' => '',
                    'outerDimMinStandard' => '',
                    'outerDimNomStandard' => '',
                    'outerDimMaxStandard' => '',
                    'fillerStandard' => '',
                    'twistedStandard' => '',
                    'overLap' => '',
                    'ovalityStandard' => '',
                    'layLengthStandard' => '',
                    'machine' => '',
                    'inputDrum1' => '',
                    'inputDrum2' => '',
                    'inputDrum3' => '',
                    'inputDrum4' => '',
                    'inputDrum5' => '',
                    'inputCard1' => '',
                    'inputCard2' => '',
                    'inputCard3' => '',
                    'inputCard4' => '',
                    'inputCard5' => '',
                    'inputLength1' => '',
                    'inputLength2' => '',
                    'inputLength3' => '',
                    'inputLength4' => '',
                    'inputLength5' => '',
                    'color1' => '',
                    'color2' => '',
                    'color3' => '',
                    'color4' => '',
                    'color5' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'outerDimMinActual' => '',
                    'outerDimNomActual' => '',
                    'outerDimMaxActual' => '',
                    'ovalityActual' => '',
                    'layLengthActual' => '',
                    'direction' => '',
                    'fillerActual' => '',
                    'twistedActual' => '',
                    'ppTapeSize' => '',
                    'ppTapeOverLap' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'outerDimMinStandard',
                    'outerDimNomStandard',
                    'outerDimMaxStandard',
                    'fillerStandard',
                    'twistedStandard',
                    'overLap',
                    'ovalityStandard',
                    'layLengthStandard',
                    'machine',
                    'inputDrum1',
                    'inputDrum2',
                    'inputDrum3',
                    'inputDrum4',
                    'inputDrum5',
                    'inputCard1',
                    'inputCard2',
                    'inputCard3',
                    'inputCard4',
                    'inputCard5',
                    'inputLength1',
                    'inputLength2',
                    'inputLength3',
                    'inputLength4',
                    'inputLength5',
                    'color1',
                    'color2',
                    'color3',
                    'color4',
                    'color5',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'outerDimMinActual',
                    'outerDimNomActual',
                    'outerDimMaxActual',
                    'ovalityActual',
                    'layLengthActual',
                    'direction',
                    'fillerActual',
                    'twistedActual',
                    'ppTapeSize',
                    'ppTapeOverLap',
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
                event(new WatchingEmployee('assembly', $request->data_form_item, $attributes, $values));
            } else {
                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('assemblyactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('assemblyactuals')->find($request->id_update)->shift;

                $regex_color = "/^([A-z]+)?$/";

                if (
                    empty($request->inputDrum1[0]) &&
                    (!empty($request->inputDrum2[0]) || !empty($request->inputDrum3[0]) || !empty($request->inputDrum4[0]) || !empty($request->inputDrum5[0]))
                ) {
                    return 'Error-inputDrum1';
                }

                if (
                    empty($request->inputCard1[0]) &&
                    (!empty($request->inputCard2[0]) || !empty($request->inputCard3[0]) || !empty($request->inputCard4[0]) || !empty($request->inputCard5[0]))
                ) {
                    return 'Error-inputCard1';
                }

                if (
                    empty($request->inputLength1[0]) &&
                    (!empty($request->inputLength2[0]) || !empty($request->inputLength3[0]) || !empty($request->inputLength4[0]) || !empty($request->inputLength5[0]))
                ) {
                    return 'Error-inputLength1';
                }

                if (!preg_match($regex_color, $request->color1[0]) || (empty($request->color1[0]) && (!empty($request->color2[0]) || !empty($request->color3[0]) || !empty($request->color4[0]) || !empty($request->color5[0])))) {
                    return "Error-color1";
                }

                if (!preg_match($regex_color, $request->color2[0])) {
                    return "Error-color2";
                }

                if (!preg_match($regex_color, $request->color3[0])) {
                    return "Error-color3";
                }

                if (!preg_match($regex_color, $request->color4[0])) {
                    return "Error-color4";
                }

                if (!preg_match($regex_color, $request->color5[0])) {
                    return "Error-color5";
                }

                if (
                    (empty($request->outerDimMinActual[0]) || empty($request->outerDimNomActual[0]) || empty($request->outerDimMaxActual[0])) &&
                    (!empty($request->outerDimMinActual[0]) || !empty($request->outerDimNomActual[0]) || !empty($request->outerDimMaxActual[0]))
                ) {
                    return 'Error-outerDimActual';
                }

                if (
                    (empty($request->ppTapeSize[0]) || empty($request->ppTapeOverLap[0])) &&
                    (!empty($request->ppTapeSize[0]) || !empty($request->ppTapeOverLap[0]))
                ) {
                    return 'Error-ppTape';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }


                $rowDataAssemblyActual = DB::table('assemblyactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'inputDrum1' => $request->inputDrum1[0],
                        'inputDrum2' => $request->inputDrum2[0],
                        'inputDrum3' => $request->inputDrum3[0],
                        'inputDrum4' => $request->inputDrum4[0],
                        'inputDrum5' => $request->inputDrum5[0],
                        'inputCard1' => $request->inputCard1[0],
                        'inputCard2' => $request->inputCard2[0],
                        'inputCard3' => $request->inputCard3[0],
                        'inputCard4' => $request->inputCard4[0],
                        'inputCard5' => $request->inputCard5[0],
                        'inputLength1' => $request->inputLength1[0],
                        'inputLength2' => $request->inputLength2[0],
                        'inputLength3' => $request->inputLength3[0],
                        'inputLength4' => $request->inputLength4[0],
                        'inputLength5' => $request->inputLength5[0],
                        'color1' => $request->color1[0],
                        'color2' => $request->color2[0],
                        'color3' => $request->color3[0],
                        'color4' => $request->color4[0],
                        'color5' => $request->color5[0],
                        'outputDrum' => $request->outputDrum[0],
                        'outputCard' => $request->outputCard[0],
                        'outputLength' => $request->outputLength[0],
                        'outerDimMinActual' => $request->outerDimMinActual[0],
                        'outerDimNomActual' => $request->outerDimNomActual[0],
                        'outerDimMaxActual' => $request->outerDimMaxActual[0],
                        'ovalityActual' => $request->ovalityActual[0],
                        'layLengthActual' => $request->layLengthActual[0],
                        'direction' => $request->direction[0],
                        'fillerActual' => $request->fillerActual[0],
                        'twistedActual' => $request->twistedActual[0],
                        'ppTapeSize' => $request->ppTapeSize[0],
                        'ppTapeOverLap' => $request->ppTapeOverLap[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $rowDataAssemblyActualTime = DB::table('assemblyactualstimes')
                    ->where('assemblyactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'inputDrum1_time' => $request->inputDrum1[1],
                        'inputDrum2_time' => $request->inputDrum2[1],
                        'inputDrum3_time' => $request->inputDrum3[1],
                        'inputDrum4_time' => $request->inputDrum4[1],
                        'inputDrum5_time' => $request->inputDrum5[1],
                        'inputCard1_time' => $request->inputCard1[1],
                        'inputCard2_time' => $request->inputCard2[1],
                        'inputCard3_time' => $request->inputCard3[1],
                        'inputCard4_time' => $request->inputCard4[1],
                        'inputCard5_time' => $request->inputCard5[1],
                        'inputLength1_time' => $request->inputLength1[1],
                        'inputLength2_time' => $request->inputLength2[1],
                        'inputLength3_time' => $request->inputLength3[1],
                        'inputLength4_time' => $request->inputLength4[1],
                        'inputLength5_time' => $request->inputLength5[1],
                        'color1_time' => $request->color1[1],
                        'color2_time' => $request->color2[1],
                        'color3_time' => $request->color3[1],
                        'color4_time' => $request->color4[1],
                        'color5_time' => $request->color5[1],
                        'outputDrum_time' => $request->outputDrum[1],
                        'outputCard_time' => $request->outputCard[1],
                        'outputLength_time' => $request->outputLength[1],
                        'outerDimMinActual_time' => $request->outerDimMinActual[1],
                        'outerDimNomActual_time' => $request->outerDimNomActual[1],
                        'outerDimMaxActual_time' => $request->outerDimMaxActual[1],
                        'ovalityActual_time' => $request->ovalityActual[1],
                        'layLengthActual_time' => $request->layLengthActual[1],
                        'direction_time' => $request->direction[1],
                        'fillerActual_time' => $request->fillerActual[1],
                        'twistedActual_time' => $request->twistedActual[1],
                        'ppTapeSize_time' => $request->ppTapeSize[1],
                        'ppTapeOverLap_time' => $request->ppTapeOverLap[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'notes_time' => $request->notes[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $checkTraceability = DB::table("traceability")->where('assembly_id', $request->id_update)->exists();

                // Traceability
                if (!$checkTraceability) {
                    $traceability = DB::table("traceability")->where([
                        ['jopOrderNumber', $request->jopOrderNumber[0]]
                    ])
                        ->where(function ($query) {
                            if ($this->request->inputCard1[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard1[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard1[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard2[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard2[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard2[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard3[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard3[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard3[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard4[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard4[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard4[0]);
                            }
                        })
                        ->where(function ($query) {
                            if ($this->request->inputCard5[0] != null) {
                                $query->where('outputCardInsulation1', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation2', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation3', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation4', $this->request->inputCard5[0])
                                    ->orWhere('outputCardInsulation5', $this->request->inputCard5[0]);
                            }
                        });

                    $chain = unserialize($traceability->value('chain'));
                    array_push($chain, $request->outputCard[0]);

                    $traceability->update([
                        "outputCardInsulation1" => null,
                        "outputCardInsulation2" => null,
                        "outputCardInsulation3" => null,
                        "outputCardInsulation4" => null,
                        "outputCardInsulation5" => null,
                        "outputCard" => $request->outputCard[0],
                        "assembly_id" => $request->id_update,
                        "chain" => serialize($chain)
                    ]);
                }

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Assembly'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = $request->outputDrum[0];
                        $hold->cableSize = $request->cableSize[0];
                        $hold->length = $request->layLengthActual[0];
                        $hold->description = $request->cableDescription[0];
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Assembly";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeInsert;
                        $hold->save();

                        // To Add New HoldTime
                        $holdTime = new HoldTime();
                        $holdTime->hold_id = $hold->id;
                        $hold->jopOrderNumber = $request->jopOrderNumber[1];
                        $hold->drumNumber = $request->outputDrum[1];
                        $hold->cableSize = $request->cableSize[1];
                        $hold->length = $request->layLengthActual[1];
                        $hold->description = $request->cableDescription[1];
                        $hold->machine = $request->machine[1];
                        $hold->reasonOfHold = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Assembly'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Assembly'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->cableSize[0],
                                'length' => $request->layLengthActual[0],
                                'description' => $request->cableDescription[0],
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Assembly",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[1],
                                'drumNumber_time' => $request->outputDrum[1],
                                'cableSize_time' => $request->cableSize[1],
                                'length_time' => $request->layLengthActual[1],
                                'description_time' => $request->cableDescription[1],
                                'machine_time' => $request->machine[1],
                                'reasonOfHold_time' =>  $request->notes[1],
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);
                    }
                }

                //To save change That Happend in Assembly Table
                $assemblys = DB::table('assemblys')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $nameOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'cableDescription' => '',
                    'outerDimMinStandard' => '',
                    'outerDimNomStandard' => '',
                    'outerDimMaxStandard' => '',
                    'fillerStandard' => '',
                    'twistedStandard' => '',
                    'overLap' => '',
                    'ovalityStandard' => '',
                    'layLengthStandard' => '',
                    'machine' => '',
                    'inputDrum1' => '',
                    'inputDrum2' => '',
                    'inputDrum3' => '',
                    'inputDrum4' => '',
                    'inputDrum5' => '',
                    'inputCard1' => '',
                    'inputCard2' => '',
                    'inputCard3' => '',
                    'inputCard4' => '',
                    'inputCard5' => '',
                    'inputLength1' => '',
                    'inputLength2' => '',
                    'inputLength3' => '',
                    'inputLength4' => '',
                    'inputLength5' => '',
                    'color1' => '',
                    'color2' => '',
                    'color3' => '',
                    'color4' => '',
                    'color5' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'outerDimMinActual' => '',
                    'outerDimNomActual' => '',
                    'outerDimMaxActual' => '',
                    'ovalityActual' => '',
                    'layLengthActual' => '',
                    'direction' => '',
                    'fillerActual' => '',
                    'twistedActual' => '',
                    'ppTapeSize' => '',
                    'ppTapeOverLap' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'outerDimMinStandard',
                    'outerDimNomStandard',
                    'outerDimMaxStandard',
                    'fillerStandard',
                    'twistedStandard',
                    'overLap',
                    'ovalityStandard',
                    'layLengthStandard',
                    'machine',
                    'inputDrum1',
                    'inputDrum2',
                    'inputDrum3',
                    'inputDrum4',
                    'inputDrum5',
                    'inputCard1',
                    'inputCard2',
                    'inputCard3',
                    'inputCard4',
                    'inputCard5',
                    'inputLength1',
                    'inputLength2',
                    'inputLength3',
                    'inputLength4',
                    'inputLength5',
                    'color1',
                    'color2',
                    'color3',
                    'color4',
                    'color5',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'outerDimMinActual',
                    'outerDimNomActual',
                    'outerDimMaxActual',
                    'ovalityActual',
                    'layLengthActual',
                    'direction',
                    'fillerActual',
                    'twistedActual',
                    'ppTapeSize',
                    'ppTapeOverLap',
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
                event(new WatchingEmployee('assembly', $request->data_form_item, $attributes, $values));

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

            $checkJopOrderNumber = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $assemblyStandard = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                //To save change That Happend in Assembly Table
                $assemblys = DB::table('assemblys')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $assemblyStandard->jopOrderNumber,
                    'cableSize' => $assemblyStandard->cableSize,
                    'cableDescription' => $assemblyStandard->cableDescription,
                    'outerDimMinStandard' => $assemblyStandard->outerDimMinStandard,
                    'outerDimNomStandard' => $assemblyStandard->outerDimNomStandard,
                    'outerDimMaxStandard' => $assemblyStandard->outerDimMaxStandard,
                    'fillerStandard' => $assemblyStandard->fillerStandard,
                    'twistedStandard' => $assemblyStandard->twistedStandard,
                    'overLap' => $assemblyStandard->overLap,
                    'ovalityStandard' => $assemblyStandard->ovalityStandard,
                    'layLengthStandard' => $assemblyStandard->layLengthStandard,
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'outerDimMinStandard',
                    'outerDimNomStandard',
                    'outerDimMaxStandard',
                    'fillerStandard',
                    'twistedStandard',
                    'overLap',
                    'ovalityStandard',
                    'layLengthStandard'
                );
                $values = array(
                    $assemblyStandard->jopOrderNumber,
                    $assemblyStandard->cableSize,
                    $assemblyStandard->cableDescription,
                    $assemblyStandard->outerDimMinStandard,
                    $assemblyStandard->outerDimNomStandard,
                    $assemblyStandard->outerDimMaxStandard,
                    $assemblyStandard->fillerStandard,
                    $assemblyStandard->twistedStandard,
                    $assemblyStandard->overLap,
                    $assemblyStandard->ovalityStandard,
                    $assemblyStandard->layLengthStandard
                );
                event(new WatchingEmployee('assembly', $request->data_form_item, $attributes, $values));

                return (array) $assemblyStandard;
            } else {
                //To save change That Happend in Assembly Table
                $assemblys = DB::table('assemblys')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'cableSize' => '',
                    'cableDescription' => '',
                    'outerDimMinStandard' => '',
                    'outerDimNomStandard' => '',
                    'outerDimMaxStandard' => '',
                    'fillerStandard' => '',
                    'twistedStandard' => '',
                    'overLap' => '',
                    'ovalityStandard' => '',
                    'layLengthStandard' => '',
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'outerDimMinStandard',
                    'outerDimNomStandard',
                    'outerDimMaxStandard',
                    'fillerStandard',
                    'twistedStandard',
                    'overLap',
                    'ovalityStandard',
                    'layLengthStandard'
                );
                $values = array(
                    $request->jopOrderNumber,
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
                event(new WatchingEmployee('assembly', $request->data_form_item, $attributes, $values));

                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;
            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            $alertIsExist = DB::table('assemblyactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataAssemblyActual = DB::table('assemblyactuals')->where('id', $request->id)->first();
            $rowDataAssemblyStandard = DB::table('assemblystandards')->where('id', $rowDataAssemblyActual->jopOrderNumber_id)->first();
            $rowDataAssemblyActualTime = DB::table('assemblyactualstimes')->where('id', $request->id)->first();
            $rowDataAssemblyStandardTime = DB::table('assemblystandardstimes')->where('id', $rowDataAssemblyActual->jopOrderNumber_id)->first();

            //To save change That Happend in Assembly Table
            $assemblys = DB::table('assemblys')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataAssemblyStandard->jopOrderNumber == null) ? '' : $rowDataAssemblyStandard->jopOrderNumber,
                'cableSize' => ($rowDataAssemblyStandard->cableSize == null) ? '' : $rowDataAssemblyStandard->cableSize,
                'cableDescription' => ($rowDataAssemblyStandard->cableDescription == null) ? '' : $rowDataAssemblyStandard->cableDescription,
                'outerDimMinStandard' => ($rowDataAssemblyStandard->outerDimMinStandard == null) ? '' : $rowDataAssemblyStandard->outerDimMinStandard,
                'outerDimNomStandard' => ($rowDataAssemblyStandard->outerDimNomStandard == null) ? '' : $rowDataAssemblyStandard->outerDimNomStandard,
                'outerDimMaxStandard' => ($rowDataAssemblyStandard->outerDimMaxStandard == null) ? '' : $rowDataAssemblyStandard->outerDimMaxStandard,
                'fillerStandard' => ($rowDataAssemblyStandard->fillerStandard == null) ? '' : $rowDataAssemblyStandard->fillerStandard,
                'twistedStandard' => ($rowDataAssemblyStandard->twistedStandard == null) ? '' : $rowDataAssemblyStandard->twistedStandard,
                'overLap' => ($rowDataAssemblyStandard->overLap == null) ? '' : $rowDataAssemblyStandard->overLap,
                'ovalityStandard' => ($rowDataAssemblyStandard->ovalityStandard == null) ? '' : $rowDataAssemblyStandard->ovalityStandard,
                'layLengthStandard' => ($rowDataAssemblyStandard->layLengthStandard == null) ? '' : $rowDataAssemblyStandard->layLengthStandard,
                'machine' => ($rowDataAssemblyActual->machine == null) ? '' : $rowDataAssemblyActual->machine,
                'inputDrum1' => ($rowDataAssemblyActual->inputDrum1 == null) ? '' : $rowDataAssemblyActual->inputDrum1,
                'inputDrum2' => ($rowDataAssemblyActual->inputDrum2 == null) ? '' : $rowDataAssemblyActual->inputDrum2,
                'inputDrum3' => ($rowDataAssemblyActual->inputDrum3 == null) ? '' : $rowDataAssemblyActual->inputDrum3,
                'inputDrum4' => ($rowDataAssemblyActual->inputDrum4 == null) ? '' : $rowDataAssemblyActual->inputDrum4,
                'inputDrum5' => ($rowDataAssemblyActual->inputDrum5 == null) ? '' : $rowDataAssemblyActual->inputDrum5,
                'inputCard1' => ($rowDataAssemblyActual->inputCard1 == null) ? '' : $rowDataAssemblyActual->inputCard1,
                'inputCard2' => ($rowDataAssemblyActual->inputCard2 == null) ? '' : $rowDataAssemblyActual->inputCard2,
                'inputCard3' => ($rowDataAssemblyActual->inputCard3 == null) ? '' : $rowDataAssemblyActual->inputCard3,
                'inputCard4' => ($rowDataAssemblyActual->inputCard4 == null) ? '' : $rowDataAssemblyActual->inputCard4,
                'inputCard5' => ($rowDataAssemblyActual->inputCard5 == null) ? '' : $rowDataAssemblyActual->inputCard5,
                'inputLength1' => ($rowDataAssemblyActual->inputLength1 == null) ? '' : $rowDataAssemblyActual->inputLength1,
                'inputLength2' => ($rowDataAssemblyActual->inputLength2 == null) ? '' : $rowDataAssemblyActual->inputLength2,
                'inputLength3' => ($rowDataAssemblyActual->inputLength3 == null) ? '' : $rowDataAssemblyActual->inputLength3,
                'inputLength4' => ($rowDataAssemblyActual->inputLength4 == null) ? '' : $rowDataAssemblyActual->inputLength4,
                'inputLength5' => ($rowDataAssemblyActual->inputLength5 == null) ? '' : $rowDataAssemblyActual->inputLength5,
                'color1' => ($rowDataAssemblyActual->color1 == null) ? '' : $rowDataAssemblyActual->color1,
                'color2' => ($rowDataAssemblyActual->color2 == null) ? '' : $rowDataAssemblyActual->color2,
                'color3' => ($rowDataAssemblyActual->color3 == null) ? '' : $rowDataAssemblyActual->color3,
                'color4' => ($rowDataAssemblyActual->color4 == null) ? '' : $rowDataAssemblyActual->color4,
                'color5' => ($rowDataAssemblyActual->color5 == null) ? '' : $rowDataAssemblyActual->color5,
                'outputDrum' => ($rowDataAssemblyActual->outputDrum == null) ? '' : $rowDataAssemblyActual->outputDrum,
                'outputCard' => ($rowDataAssemblyActual->outputCard == null) ? '' : $rowDataAssemblyActual->outputCard,
                'outputLength' => ($rowDataAssemblyActual->outputLength == null) ? '' : $rowDataAssemblyActual->outputLength,
                'outerDimMinActual' => ($rowDataAssemblyActual->outerDimMinActual == null) ? '' : $rowDataAssemblyActual->outerDimMinActual,
                'outerDimNomActual' => ($rowDataAssemblyActual->outerDimNomActual == null) ? '' : $rowDataAssemblyActual->outerDimNomActual,
                'outerDimMaxActual' => ($rowDataAssemblyActual->outerDimMaxActual == null) ? '' : $rowDataAssemblyActual->outerDimMaxActual,
                'ovalityActual' => ($rowDataAssemblyActual->ovalityActual == null) ? '' : $rowDataAssemblyActual->ovalityActual,
                'layLengthActual' => ($rowDataAssemblyActual->layLengthActual == null) ? '' : $rowDataAssemblyActual->layLengthActual,
                'direction' => ($rowDataAssemblyActual->direction == null) ? '' : $rowDataAssemblyActual->direction,
                'fillerActual' => ($rowDataAssemblyActual->fillerActual == null) ? '' : $rowDataAssemblyActual->fillerActual,
                'twistedActual' => ($rowDataAssemblyActual->twistedActual == null) ? '' : $rowDataAssemblyActual->twistedActual,
                'ppTapeSize' => ($rowDataAssemblyActual->ppTapeSize == null) ? '' : $rowDataAssemblyActual->ppTapeSize,
                'ppTapeOverLap' => ($rowDataAssemblyActual->ppTapeOverLap == null) ? '' : $rowDataAssemblyActual->ppTapeOverLap,
                'status' => ($rowDataAssemblyActual->status == null) ? '' : $rowDataAssemblyActual->status,
                'productionOperator' => ($rowDataAssemblyActual->productionOperator == null) ? '' : $rowDataAssemblyActual->productionOperator,
                'notes' => ($rowDataAssemblyActual->notes == null) ? '' : $rowDataAssemblyActual->notes
            ]);

            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'cableSize',
                'cableDescription',
                'outerDimMinStandard',
                'outerDimNomStandard',
                'outerDimMaxStandard',
                'fillerStandard',
                'twistedStandard',
                'overLap',
                'ovalityStandard',
                'layLengthStandard',
                'machine',
                'inputDrum1',
                'inputDrum2',
                'inputDrum3',
                'inputDrum4',
                'inputDrum5',
                'inputCard1',
                'inputCard2',
                'inputCard3',
                'inputCard4',
                'inputCard5',
                'inputLength1',
                'inputLength2',
                'inputLength3',
                'inputLength4',
                'inputLength5',
                'color1',
                'color2',
                'color3',
                'color4',
                'color5',
                'outputDrum',
                'outputCard',
                'outputLength',
                'outerDimMinActual',
                'outerDimNomActual',
                'outerDimMaxActual',
                'ovalityActual',
                'layLengthActual',
                'direction',
                'fillerActual',
                'twistedActual',
                'ppTapeSize',
                'ppTapeOverLap',
                'status',
                'productionOperator',
                'notes'
            );
            $values = array(
                $rowDataAssemblyStandard->jopOrderNumber,
                $rowDataAssemblyStandard->cableSize,
                $rowDataAssemblyStandard->cableDescription,
                $rowDataAssemblyStandard->outerDimMinStandard,
                $rowDataAssemblyStandard->outerDimNomStandard,
                $rowDataAssemblyStandard->outerDimMaxStandard,
                $rowDataAssemblyStandard->fillerStandard,
                $rowDataAssemblyStandard->twistedStandard,
                $rowDataAssemblyStandard->overLap,
                $rowDataAssemblyStandard->ovalityStandard,
                $rowDataAssemblyStandard->layLengthStandard,
                $rowDataAssemblyActual->machine,
                $rowDataAssemblyActual->inputDrum1,
                $rowDataAssemblyActual->inputDrum2,
                $rowDataAssemblyActual->inputDrum3,
                $rowDataAssemblyActual->inputDrum4,
                $rowDataAssemblyActual->inputDrum5,
                $rowDataAssemblyActual->inputCard1,
                $rowDataAssemblyActual->inputCard2,
                $rowDataAssemblyActual->inputCard3,
                $rowDataAssemblyActual->inputCard4,
                $rowDataAssemblyActual->inputCard5,
                $rowDataAssemblyActual->inputLength1,
                $rowDataAssemblyActual->inputLength2,
                $rowDataAssemblyActual->inputLength3,
                $rowDataAssemblyActual->inputLength4,
                $rowDataAssemblyActual->inputLength5,
                $rowDataAssemblyActual->color1,
                $rowDataAssemblyActual->color2,
                $rowDataAssemblyActual->color3,
                $rowDataAssemblyActual->color4,
                $rowDataAssemblyActual->color5,
                $rowDataAssemblyActual->outputDrum,
                $rowDataAssemblyActual->outputCard,
                $rowDataAssemblyActual->outputLength,
                $rowDataAssemblyActual->outerDimMinActual,
                $rowDataAssemblyActual->outerDimNomActual,
                $rowDataAssemblyActual->outerDimMaxActual,
                $rowDataAssemblyActual->ovalityActual,
                $rowDataAssemblyActual->layLengthActual,
                $rowDataAssemblyActual->direction,
                $rowDataAssemblyActual->fillerActual,
                $rowDataAssemblyActual->twistedActual,
                $rowDataAssemblyActual->ppTapeSize,
                $rowDataAssemblyActual->ppTapeOverLap,
                $rowDataAssemblyActual->status,
                $rowDataAssemblyActual->productionOperator,
                $rowDataAssemblyActual->notes
            );
            event(new WatchingEmployee('assembly', $request->data_form_item, $attributes, $values));

            return array(
                $rowDataAssemblyStandard,
                $rowDataAssemblyActual,
                $rowDataAssemblyActualTime,
                $rowDataAssemblyStandardTime
            );
        }
    }

    public function checkRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            //To Check About "who did make insert ?"
            $name = Auth::guard('web')->user()->name;

            $rowUpdateData = DB::table('assemblys')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('assembly', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if ($request->input['name'] == "outerDimActual") {


                $dataRow = DB::table('assemblys')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();

                // return $dataRow;

                //To Get Min, Nom And Max from outerDimStandard
                $arrayOfOuterDimStandard = array();
                $statment = $dataRow[0]->outerDimStandard;
                $counter = 0;
                $part = "";
                for ($i = 0; $i < strlen($statment); $i++) {
                    if ($statment[$i] == '/') {
                        $arrayOfOuterDimStandard[$counter] = $part;
                        $counter++;
                        $part = "";
                    } else {
                        $part = $part . $statment[$i];
                        if ($i == strlen($statment) - 1) {
                            $arrayOfOuterDimStandard[$counter] = $part;
                        }
                    }
                }

                //To Get Min, Nom And Max from outerDimActual
                if ($request->input['value'] != null) {
                    $arrayOfOuterDimActual = array();
                    $statment = $request->input['value'];
                    $counter = 0;
                    $part = "";
                    for ($i = 0; $i < strlen($statment); $i++) {
                        if ($statment[$i] == '/') {
                            $arrayOfOuterDimActual[$counter] = $part;
                            $counter++;
                            $part = "";
                        } else {
                            $part = $part . $statment[$i];
                            if ($i == strlen($statment) - 1) {
                                $arrayOfOuterDimActual[$counter] = $part;
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < 3; $i++) {
                        $arrayOfOuterDimActual[$i] = NULL;
                    }
                }

                // return array( $arrayOfOuterDimActual,  $arrayOfOuterDimStandard);


                if (
                    ($arrayOfOuterDimActual[0] != null && $arrayOfOuterDimActual[0] != $arrayOfOuterDimStandard[0])  ||
                    ($arrayOfOuterDimActual[1] != null && $arrayOfOuterDimActual[1] != $arrayOfOuterDimStandard[1]) ||
                    ($arrayOfOuterDimActual[2] != null && $arrayOfOuterDimActual[2] != $arrayOfOuterDimStandard[2])
                ) {

                    $message = ['employee' => $name, 'Sheet' => 'Assembly', 'errors' => 'outerDimActual'];

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
