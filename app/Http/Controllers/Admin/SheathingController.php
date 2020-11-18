<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Hold;
use App\HoldTime;
use App\SheathingActual;
use App\SheathingActualsTimes;
use App\SheathingStandard;
use App\SheathingStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SheathingController extends Controller
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

    public function insertSheathing(Request $request)
    {
        // return $request;
        if ($request->ajax()) {
            $this->request = $request;
            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New SheathingStansard
                    $sheathingStandard = new SheathingStandard();
                    $sheathingStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $sheathingStandard->cableSize = $request->cableSize[0];
                    $sheathingStandard->cableDescription = $request->cableDescription[0];
                    $sheathingStandard->volt = $request->volt[0];
                    $sheathingStandard->thicknessMinStandard = $request->thicknessMinStandard[0];
                    $sheathingStandard->thicknessNomStandard = $request->thicknessNomStandard[0];
                    $sheathingStandard->thicknessMaxStandard = $request->thicknessMaxStandard[0];
                    $sheathingStandard->eccentricityStandard = $request->eccentricityStandard[0];
                    $sheathingStandard->outerDim = $request->outerDim[0];
                    $sheathingStandard->ovalityStandard = $request->ovalityStandard[0];
                    $sheathingStandard->materialStandard = $request->materialStandard[0];
                    $sheathingStandard->colorStandard = $request->colorStandard[0];
                    $sheathingStandard->sparkStandard = $request->sparkStandard[0];
                    $sheathingStandard->weightStandard = $request->weightStandard[0];
                    $sheathingStandard->added_by = $name;
                    $sheathingStandard->shift = $shift;
                    $sheathingStandard->save();

                    $jopOrderNumber_id = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                    //To Add New SheathingStansardTimes
                    $sheathingStandardTime = new SheathingStandardsTimes();
                    $sheathingStandardTime->sheathingstandards_id = $jopOrderNumber_id;
                    $sheathingStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $sheathingStandardTime->cableSize_time = $request->cableSize[1];
                    $sheathingStandardTime->cableDescription_time = $request->cableDescription[1];
                    $sheathingStandardTime->volt_time = $request->volt[1];
                    $sheathingStandardTime->thicknessMinStandard_time = $request->thicknessMinStandard[1];
                    $sheathingStandardTime->thicknessNomStandard_time = $request->thicknessNomStandard[1];
                    $sheathingStandardTime->thicknessMaxStandard_time = $request->thicknessMaxStandard[1];
                    $sheathingStandardTime->eccentricityStandard_time = $request->eccentricityStandard[1];
                    $sheathingStandardTime->outerDim_time = $request->outerDim[1];
                    $sheathingStandardTime->ovalityStandard_time = $request->ovalityStandard[1];
                    $sheathingStandardTime->materialStandard_time = $request->materialStandard[1];
                    $sheathingStandardTime->colorStandard_time = $request->colorStandard[1];
                    $sheathingStandardTime->sparkStandard_time = $request->sparkStandard[1];
                    $sheathingStandardTime->weightStandard_time = $request->weightStandard[1];
                    $sheathingStandardTime->added_by = $name;
                    $sheathingStandardTime->shift = $shift;
                    $sheathingStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

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

                //To Add New SheathingActual
                $sheathingActual = new SheathingActual();
                $sheathingActual->jopOrderNumber_id = $jopOrderNumber_id;
                $sheathingActual->jopOrderNumber = $request->jopOrderNumber[0];
                $sheathingActual->machine = $request->machine[0];
                $sheathingActual->inputDrum = $request->inputDrum[0];
                $sheathingActual->inputCard = $request->inputCard[0];
                $sheathingActual->inputLength = $request->inputLength[0];
                $sheathingActual->outputDrum = $request->outputDrum[0];
                $sheathingActual->outputCard = $request->outputCard[0];
                $sheathingActual->outputLength = $request->outputLength[0];
                $sheathingActual->apperanceOfDrum = $request->apperanceOfDrum[0];
                $sheathingActual->colorActual = $request->colorActual[0];
                $sheathingActual->message = $request->message[0];
                $sheathingActual->thicknessStartMinActual = $request->thicknessStartMinActual[0];
                $sheathingActual->thicknessStartNomActual = $request->thicknessStartNomActual[0];
                $sheathingActual->thicknessStartMaxActual = $request->thicknessStartMaxActual[0];
                $sheathingActual->thicknessEndMinActual = $request->thicknessEndMinActual[0];
                $sheathingActual->thicknessEndNomActual = $request->thicknessEndNomActual[0];
                $sheathingActual->thicknessEndMaxActual = $request->thicknessEndMaxActual[0];
                $sheathingActual->eccentricityActual = $request->eccentricityActual[0];
                $sheathingActual->dimBefore1 = $request->dimBefore1[0];
                $sheathingActual->dimBefore2 = $request->dimBefore2[0];
                $sheathingActual->dimAfterStartMin = $request->dimAfterStartMin[0];
                $sheathingActual->dimAfterStartNom = $request->dimAfterStartNom[0];
                $sheathingActual->dimAfterStartMax = $request->dimAfterStartMax[0];
                $sheathingActual->dimAfterEndMin = $request->dimAfterEndMin[0];
                $sheathingActual->dimAfterEndNom = $request->dimAfterEndNom[0];
                $sheathingActual->dimAfterEndMax = $request->dimAfterEndMax[0];
                $sheathingActual->weightActual = $request->weightActual[0];
                $sheathingActual->materialActual = $request->materialActual[0];
                $sheathingActual->ovalityActual1 = $request->ovalityActual1[0];
                $sheathingActual->ovalityActual2 = $request->ovalityActual2[0];
                $sheathingActual->meterMeasuring = $request->meterMeasuring[0];
                $sheathingActual->sparkActual = $request->sparkActual[0];
                $sheathingActual->status = $request->status[0];
                $sheathingActual->productionOperator = $request->productionOperator[0];
                $sheathingActual->notes = $request->notes[0];
                $sheathingActual->added_by = $name;
                $sheathingActual->shift = $shift;
                $sheathingActual->save();



                //To  Add New SheathingActualTimes
                $sheathingActualTime = new SheathingActualsTimes();
                $sheathingActualTime->sheathingactuals_id = $sheathingActual->id;
                $sheathingActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $sheathingActualTime->machine_time = $request->machine[1];
                $sheathingActualTime->inputDrum_time = $request->inputDrum[1];
                $sheathingActualTime->inputCard_time = $request->inputCard[1];
                $sheathingActualTime->inputLength_time = $request->inputLength[1];
                $sheathingActualTime->outputDrum_time = $request->outputDrum[1];
                $sheathingActualTime->outputCard_time = $request->outputCard[1];
                $sheathingActualTime->outputLength_time = $request->outputLength[1];
                $sheathingActualTime->apperanceOfDrum_time = $request->apperanceOfDrum[1];
                $sheathingActualTime->colorActual_time = $request->colorActual[1];
                $sheathingActualTime->message_time = $request->message[1];
                $sheathingActualTime->thicknessStartMinActual_time = $request->thicknessStartMinActual[1];
                $sheathingActualTime->thicknessStartNomActual_time = $request->thicknessStartNomActual[1];
                $sheathingActualTime->thicknessStartMaxActual_time = $request->thicknessStartMaxActual[1];
                $sheathingActualTime->thicknessEndMinActual_time = $request->thicknessEndMinActual[1];
                $sheathingActualTime->thicknessEndNomActual_time = $request->thicknessEndNomActual[1];
                $sheathingActualTime->thicknessEndMaxActual_time = $request->thicknessEndMaxActual[1];
                $sheathingActualTime->eccentricityActual_time = $request->eccentricityActual[1];
                $sheathingActualTime->dimBefore1_time = $request->dimBefore1[1];
                $sheathingActualTime->dimBefore2_time = $request->dimBefore2[1];
                $sheathingActualTime->dimAfterStartMin_time = $request->dimAfterStartMin[1];
                $sheathingActualTime->dimAfterStartNom_time = $request->dimAfterStartNom[1];
                $sheathingActualTime->dimAfterStartMax_time = $request->dimAfterStartMax[1];
                $sheathingActualTime->dimAfterEndMin_time = $request->dimAfterEndMin[1];
                $sheathingActualTime->dimAfterEndNom_time = $request->dimAfterEndNom[1];
                $sheathingActualTime->dimAfterEndMax_time = $request->dimAfterEndMax[1];
                $sheathingActualTime->weightActual_time = $request->weightActual[1];
                $sheathingActualTime->materialActual_time = $request->materialActual[1];
                $sheathingActualTime->ovalityActual1_time = $request->ovalityActual1[1];
                $sheathingActualTime->ovalityActual2_time = $request->ovalityActual2[1];
                $sheathingActualTime->meterMeasuring_time = $request->meterMeasuring[1];
                $sheathingActualTime->sparkActual_time = $request->sparkActual[1];
                $sheathingActualTime->status_time = $request->status[1];
                $sheathingActualTime->productionOperator_time = $request->productionOperator[1];
                $sheathingActualTime->notes_time = $request->notes[1];
                $sheathingActualTime->added_by = $name;
                $sheathingActualTime->shift = $shift;
                $sheathingActualTime->save();

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $sheathingActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->cableSize[0] == null) ? '' : $request->cableSize[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = ($request->cableDescription[0] == null) ? '' : $request->cableDescription[0];
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Sheathing";
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
                    $holdTime->description_time = ($request->cableDescription[1] == null) ? '' : $request->cableDescription[1];
                    $holdTime->machine_time = ($request->machine[1] == null) ? '' : $request->machine[1];
                    $holdTime->reasonOfHold_time = ($request->notes[1] == null) ? '' : $request->notes[1];
                    $holdTime->added_by = $name;
                    $holdTime->shift = $shift;
                    $holdTime->save();
                }
            } else {

                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('admin')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('sheathingactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('sheathingactuals')->find($request->id_update)->shift;

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

                $rowDataSheathingActual = DB::table('sheathingactuals')
                    ->where('id', '=', $request->id_update)
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
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $rowDataSheathingActualTime = DB::table('sheathingactualstimes')
                    ->where('sheathingactuals_id', '=', $request->id_update)
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
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);



                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Sheathing'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = $request->outputDrum[0];
                        $hold->cableSize = $request->cableSize[0];
                        $hold->length = $request->outputLength[0];
                        $hold->description = $request->cableDescription[0];
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Sheathing";
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
                        $holdTime->description_time = $request->cableDescription[1];
                        $holdTime->machine_time = $request->machine[1];
                        $holdTime->reasonOfHold_time = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Sheathing'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Sheathing'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->cableSize[0],
                                'length' => $request->outputLength[0],
                                'description' => $request->cableDescription[0],
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Sheathing",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[0],
                                'drumNumber_time' => $request->outputDrum[0],
                                'cableSize_time' => $request->cableSize[0],
                                'length_time' => $request->outputLength[0],
                                'description_time' => $request->cableDescription[0],
                                'machine_time' => $request->machine[0],
                                'reasonOfHold_time' => $request->notes[0],
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
            $checkJopOrderNumber = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $sheathingStandard = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $sheathingStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $alertIsExist = DB::table('sheathingactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataSheathingActual = DB::table('sheathingactuals')->where('id', $request->id)->first();
            $rowDataSheathingStandard = DB::table('sheathingstandards')->where('id', $rowDataSheathingActual->jopOrderNumber_id)->first();
            $rowDataSheathingActualTime = DB::table('sheathingactualstimes')->where('id', $request->id)->first();
            $rowDataSheathingStandardTime = DB::table('sheathingstandardstimes')->where('id', $rowDataSheathingActual->jopOrderNumber_id)->first();

            return array(
                $rowDataSheathingStandard,
                $rowDataSheathingActual,
                $rowDataSheathingActualTime,
                $rowDataSheathingStandardTime
            );
        }
    }
}
