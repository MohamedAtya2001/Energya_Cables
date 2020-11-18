<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Hold;
use App\HoldTime;
use App\InsulationActual;
use App\InsulationActualsTimes;
use App\InsulationStandard;
use App\InsulationStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsulationController extends Controller
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

    public function insertInsulation(Request $request)
    {
        // return $request;
        if ($request->ajax()) {

            $this->request = $request;

            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('insulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New InsulationStansard
                    $insulationStandard = new InsulationStandard();
                    $insulationStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $insulationStandard->cableSize = $request->cableSize[0];
                    $insulationStandard->cableDescription = $request->cableDescription[0];
                    $insulationStandard->volt = $request->volt[0];
                    $insulationStandard->thicknessMinStandard = $request->thicknessMinStandard[0];
                    $insulationStandard->thicknessNomStandard = $request->thicknessNomStandard[0];
                    $insulationStandard->thicknessMaxStandard = $request->thicknessMaxStandard[0];
                    $insulationStandard->eccentricityStandard = $request->eccentricityStandard[0];
                    $insulationStandard->outerDim = $request->outerDim[0];
                    $insulationStandard->ovalityStandard = $request->ovalityStandard[0];
                    $insulationStandard->materialStandard = $request->materialStandard[0];
                    $insulationStandard->colorStandard = $request->colorStandard[0];
                    $insulationStandard->sparkStandard = $request->sparkStandard[0];
                    $insulationStandard->weightStandard = $request->weightStandard[0];
                    $insulationStandard->masterPatch = $request->masterPatch[0];
                    $insulationStandard->added_by = $name;
                    $insulationStandard->shift = $shift;
                    $insulationStandard->save();


                    $jopOrderNumber_id = DB::table('insulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New InsulationStansardTimes
                    $insulationStandardTime = new InsulationStandardsTimes();
                    $insulationStandardTime->insulationstandards_id = $jopOrderNumber_id;
                    $insulationStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $insulationStandardTime->cableSize_time = $request->cableSize[1];
                    $insulationStandardTime->cableDescription_time = $request->cableDescription[1];
                    $insulationStandardTime->volt_time = $request->volt[1];
                    $insulationStandardTime->thicknessMinStandard_time = $request->thicknessMinStandard[1];
                    $insulationStandardTime->thicknessNomStandard_time = $request->thicknessNomStandard[1];
                    $insulationStandardTime->thicknessMaxStandard_time = $request->thicknessMaxStandard[1];
                    $insulationStandardTime->eccentricityStandard_time = $request->eccentricityStandard[1];
                    $insulationStandardTime->outerDim_time = $request->outerDim[1];
                    $insulationStandardTime->ovalityStandard_time = $request->ovalityStandard[1];
                    $insulationStandardTime->materialStandard_time = $request->materialStandard[1];
                    $insulationStandardTime->colorStandard_time = $request->colorStandard[1];
                    $insulationStandardTime->sparkStandard_time = $request->sparkStandard[1];
                    $insulationStandardTime->weightStandard_time = $request->weightStandard[1];
                    $insulationStandardTime->masterPatch_time = $request->masterPatch[1];
                    $insulationStandardTime->added_by = $name;
                    $insulationStandardTime->shift = $shift;
                    $insulationStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('insulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

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

                //To Add New InsulationActual
                $insulationActual = new InsulationActual();
                $insulationActual->jopOrderNumber_id = $jopOrderNumber_id;
                $insulationActual->jopOrderNumber = $request->jopOrderNumber[0];
                $insulationActual->machine = $request->machine[0];
                $insulationActual->inputDrum = $request->inputDrum[0];
                $insulationActual->inputCard = $request->inputCard[0];
                $insulationActual->inputLength = $request->inputLength[0];
                $insulationActual->outputDrum = $request->outputDrum[0];
                $insulationActual->outputCard = $request->outputCard[0];
                $insulationActual->outputLength = $request->outputLength[0];
                $insulationActual->apperanceOfDrum = $request->apperanceOfDrum[0];
                $insulationActual->colorActual = $request->colorActual[0];
                $insulationActual->message = $request->message[0];
                $insulationActual->thicknessStartMinActual = $request->thicknessStartMinActual[0];
                $insulationActual->thicknessStartNomActual = $request->thicknessStartNomActual[0];
                $insulationActual->thicknessStartMaxActual = $request->thicknessStartMaxActual[0];
                $insulationActual->thicknessEndMinActual = $request->thicknessEndMinActual[0];
                $insulationActual->thicknessEndNomActual = $request->thicknessEndNomActual[0];
                $insulationActual->thicknessEndMaxActual = $request->thicknessEndMaxActual[0];
                $insulationActual->eccentricityActual = $request->eccentricityActual[0];
                $insulationActual->dimBefore1 = $request->dimBefore1[0];
                $insulationActual->dimBefore2 = $request->dimBefore2[0];
                $insulationActual->dimAfterStartMin = $request->dimAfterStartMin[0];
                $insulationActual->dimAfterStartNom = $request->dimAfterStartNom[0];
                $insulationActual->dimAfterStartMax = $request->dimAfterStartMax[0];
                $insulationActual->dimAfterEndMin = $request->dimAfterEndMin[0];
                $insulationActual->dimAfterEndNom = $request->dimAfterEndNom[0];
                $insulationActual->dimAfterEndMax = $request->dimAfterEndMax[0];
                $insulationActual->weightActual = $request->weightActual[0];
                $insulationActual->materialActual = $request->materialActual[0];
                $insulationActual->ovalityActual1 = $request->ovalityActual1[0];
                $insulationActual->ovalityActual2 = $request->ovalityActual2[0];
                $insulationActual->meterMeasuring = $request->meterMeasuring[0];
                $insulationActual->sparkActual = $request->sparkActual[0];
                $insulationActual->status = $request->status[0];
                $insulationActual->productionOperator = $request->productionOperator[0];
                $insulationActual->notes = $request->notes[0];
                $insulationActual->added_by = $name;
                $insulationActual->shift = $shift;
                $insulationActual->save();



                //To  Add New InsulationActualTimes
                $insulationActualTime = new InsulationActualsTimes();
                $insulationActualTime->insulationactuals_id = $insulationActual->id;
                $insulationActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $insulationActualTime->machine_time = $request->machine[1];
                $insulationActualTime->inputDrum_time = $request->inputDrum[1];
                $insulationActualTime->inputCard_time = $request->inputCard[1];
                $insulationActualTime->inputLength_time = $request->inputLength[1];
                $insulationActualTime->outputDrum_time = $request->outputDrum[1];
                $insulationActualTime->outputCard_time = $request->outputCard[1];
                $insulationActualTime->outputLength_time = $request->outputLength[1];
                $insulationActualTime->apperanceOfDrum_time = $request->apperanceOfDrum[1];
                $insulationActualTime->colorActual_time = $request->colorActual[1];
                $insulationActualTime->message_time = $request->message[1];
                $insulationActualTime->thicknessStartMinActual_time = $request->thicknessStartMinActual[1];
                $insulationActualTime->thicknessStartNomActual_time = $request->thicknessStartNomActual[1];
                $insulationActualTime->thicknessStartMaxActual_time = $request->thicknessStartMaxActual[1];
                $insulationActualTime->thicknessEndMinActual_time = $request->thicknessEndMinActual[1];
                $insulationActualTime->thicknessEndNomActual_time = $request->thicknessEndNomActual[1];
                $insulationActualTime->thicknessEndMaxActual_time = $request->thicknessEndMaxActual[1];
                $insulationActualTime->eccentricityActual_time = $request->eccentricityActual[1];
                $insulationActualTime->dimBefore1_time = $request->dimBefore1[1];
                $insulationActualTime->dimBefore2_time = $request->dimBefore2[1];
                $insulationActualTime->dimAfterStartMin_time = $request->dimAfterStartMin[1];
                $insulationActualTime->dimAfterStartNom_time = $request->dimAfterStartNom[1];
                $insulationActualTime->dimAfterStartMax_time = $request->dimAfterStartMax[1];
                $insulationActualTime->dimAfterEndMin_time = $request->dimAfterEndMin[1];
                $insulationActualTime->dimAfterEndNom_time = $request->dimAfterEndNom[1];
                $insulationActualTime->dimAfterEndMax_time = $request->dimAfterEndMax[1];
                $insulationActualTime->weightActual_time = $request->weightActual[1];
                $insulationActualTime->materialActual_time = $request->materialActual[1];
                $insulationActualTime->ovalityActual1_time = $request->ovalityActual1[1];
                $insulationActualTime->ovalityActual2_time = $request->ovalityActual2[1];
                $insulationActualTime->meterMeasuring_time = $request->meterMeasuring[1];
                $insulationActualTime->sparkActual_time = $request->sparkActual[1];
                $insulationActualTime->status_time = $request->status[1];
                $insulationActualTime->productionOperator_time = $request->productionOperator[1];
                $insulationActualTime->notes_time = $request->notes[1];
                $insulationActualTime->added_by = $name;
                $insulationActualTime->shift = $shift;
                $insulationActualTime->save();

                // To Make Hold If Status is Hold                
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $insulationActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->cableSize[0] == null) ? '' : $request->cableSize[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = ($request->cableDescription[0] == null) ? '' : $request->cableDescription[0];
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Insulation";
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
                $nameOfWhoMadeInsert = DB::table('insulationactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('insulationactuals')->find($request->id_update)->shift;

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

                $rowDataInsulationActual = DB::table('insulationactuals')
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
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate,
                    ]);

                $rowDataInsulationActualTime = DB::table('insulationactualstimes')
                    ->where('insulationactuals_id', '=', $request->id_update)
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
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Insulation'], ['sheet_id', $request->id_update]])->exists();
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
                        $hold->fromSheet = "Insulation";
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
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Insulation'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Insulation'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->cableSize[0],
                                'length' => $request->outputLength[0],
                                'description' => $request->cableDescription[0],
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Insulation",
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

            $checkJopOrderNumber = DB::table('insulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $insulationStandard = DB::table('insulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $insulationStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $alertIsExist = DB::table('insulationactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataInsulationActual = DB::table('insulationactuals')->where('id', $request->id)->first();
            $rowDataInsulationStandard = DB::table('insulationstandards')->where('id', $rowDataInsulationActual->jopOrderNumber_id)->first();
            $rowDataInsulationActualTime = DB::table('insulationactualstimes')->where('id', $request->id)->first();
            $rowDataInsulationStandardTime = DB::table('insulationstandardstimes')->where('id', $rowDataInsulationActual->jopOrderNumber_id)->first();

            return array(
                $rowDataInsulationStandard,
                $rowDataInsulationActual,
                $rowDataInsulationActualTime,
                $rowDataInsulationStandardTime
            );
        }
    }
}
