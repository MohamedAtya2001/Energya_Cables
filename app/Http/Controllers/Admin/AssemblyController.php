<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\AssemblyActual;
use App\AssemblyActualsTimes;
use App\AssemblyStandard;
use App\AssemblyStandardsTimes;
use App\Hold;
use App\HoldTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssemblyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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

    public function insertAssembly(Request $request)
    {
        if ($request->ajax()) {
            $this->request = $request;
            if ($request->update == 'false') {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

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
            } else {
                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('admin')->user()->name;

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
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate,
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

                return "Updated";
            }
        }
    }

    public function findJopOrderNumber(Request $request)
    {
        if ($request->ajax()) {

            $checkJopOrderNumber = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $assemblyStandard = DB::table('assemblystandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $assemblyStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $alertIsExist = DB::table('assemblyactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataAssemblyActual = DB::table('assemblyactuals')->where('id', $request->id)->first();
            $rowDataAssemblyStandard = DB::table('assemblystandards')->where('id', $rowDataAssemblyActual->jopOrderNumber_id)->first();
            $rowDataAssemblyActualTime = DB::table('assemblyactualstimes')->where('id', $request->id)->first();
            $rowDataAssemblyStandardTime = DB::table('assemblystandardstimes')->where('id', $rowDataAssemblyActual->jopOrderNumber_id)->first();

            return array(
                $rowDataAssemblyStandard,
                $rowDataAssemblyActual,
                $rowDataAssemblyActualTime,
                $rowDataAssemblyStandardTime
            );
        }
    }
}
