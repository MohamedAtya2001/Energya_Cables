<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\BeddingActual;
use App\BeddingActualsTimes;
use App\BeddingStandard;
use App\BeddingStandardsTimes;
use App\Hold;
use App\HoldTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeddingController extends Controller
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

    public function insertBedding(Request $request)
    {
        // return $request;
        if ($request->ajax()) {
            $this->request = $request;
            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('beddingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New BeddingStansard
                    $beddingStandard = new BeddingStandard();
                    $beddingStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $beddingStandard->cableSize = $request->cableSize[0];
                    $beddingStandard->cableDescription = $request->cableDescription[0];
                    $beddingStandard->volt = $request->volt[0];
                    $beddingStandard->thicknessMinStandard = $request->thicknessMinStandard[0];
                    $beddingStandard->thicknessNomStandard = $request->thicknessNomStandard[0];
                    $beddingStandard->thicknessMaxStandard = $request->thicknessMaxStandard[0];
                    $beddingStandard->eccentricityStandard = $request->eccentricityStandard[0];
                    $beddingStandard->outerDim = $request->outerDim[0];
                    $beddingStandard->ovalityStandard = $request->ovalityStandard[0];
                    $beddingStandard->materialStandard = $request->materialStandard[0];
                    $beddingStandard->colorStandard = $request->colorStandard[0];
                    $beddingStandard->sparkStandard = $request->sparkStandard[0];
                    $beddingStandard->weightStandard = $request->weightStandard[0];
                    $beddingStandard->added_by = $name;
                    $beddingStandard->shift = $shift;
                    $beddingStandard->save();


                    $jopOrderNumber_id = DB::table('beddingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New BeddingStansardTimes
                    $beddingStandardTime = new BeddingStandardsTimes();
                    $beddingStandardTime->beddingstandards_id = $jopOrderNumber_id;
                    $beddingStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $beddingStandardTime->cableSize_time = $request->cableSize[1];
                    $beddingStandardTime->cableDescription_time = $request->cableDescription[1];
                    $beddingStandardTime->volt_time = $request->volt[1];
                    $beddingStandardTime->thicknessMinStandard_time = $request->thicknessMinStandard[1];
                    $beddingStandardTime->thicknessNomStandard_time = $request->thicknessNomStandard[1];
                    $beddingStandardTime->thicknessMaxStandard_time = $request->thicknessMaxStandard[1];
                    $beddingStandardTime->eccentricityStandard_time = $request->eccentricityStandard[1];
                    $beddingStandardTime->outerDim_time = $request->outerDim[1];
                    $beddingStandardTime->ovalityStandard_time = $request->ovalityStandard[1];
                    $beddingStandardTime->materialStandard_time = $request->materialStandard[1];
                    $beddingStandardTime->colorStandard_time = $request->colorStandard[1];
                    $beddingStandardTime->sparkStandard_time = $request->sparkStandard[1];
                    $beddingStandardTime->weightStandard_time = $request->weightStandard[1];
                    $beddingStandardTime->added_by = $name;
                    $beddingStandardTime->shift = $shift;
                    $beddingStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('beddingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

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

                //To Add New BeddingActual
                $beddingActual = new BeddingActual();
                $beddingActual->jopOrderNumber_id = $jopOrderNumber_id;
                $beddingActual->jopOrderNumber = $request->jopOrderNumber[0];
                $beddingActual->machine = $request->machine[0];
                $beddingActual->inputDrum = $request->inputDrum[0];
                $beddingActual->inputCard = $request->inputCard[0];
                $beddingActual->inputLength = $request->inputLength[0];
                $beddingActual->outputDrum = $request->outputDrum[0];
                $beddingActual->outputCard = $request->outputCard[0];
                $beddingActual->outputLength = $request->outputLength[0];
                $beddingActual->colorActual = $request->colorActual[0];
                $beddingActual->thicknessStartMinActual = $request->thicknessStartMinActual[0];
                $beddingActual->thicknessStartNomActual = $request->thicknessStartNomActual[0];
                $beddingActual->thicknessStartMaxActual = $request->thicknessStartMaxActual[0];
                $beddingActual->thicknessEndMinActual = $request->thicknessEndMinActual[0];
                $beddingActual->thicknessEndNomActual = $request->thicknessEndNomActual[0];
                $beddingActual->thicknessEndMaxActual = $request->thicknessEndMaxActual[0];
                $beddingActual->eccentricityActual = $request->eccentricityActual[0];
                $beddingActual->dimBefore1 = $request->dimBefore1[0];
                $beddingActual->dimBefore2 = $request->dimBefore2[0];
                $beddingActual->dimAfterStartMin = $request->dimAfterStartMin[0];
                $beddingActual->dimAfterStartNom = $request->dimAfterStartNom[0];
                $beddingActual->dimAfterStartMax = $request->dimAfterStartMax[0];
                $beddingActual->dimAfterEndMin = $request->dimAfterEndMin[0];
                $beddingActual->dimAfterEndNom = $request->dimAfterEndNom[0];
                $beddingActual->dimAfterEndMax = $request->dimAfterEndMax[0];
                $beddingActual->weightActual = $request->weightActual[0];
                $beddingActual->materialActual = $request->materialActual[0];
                $beddingActual->ovalityActual1 = $request->ovalityActual1[0];
                $beddingActual->ovalityActual2 = $request->ovalityActual2[0];
                $beddingActual->sparkActual = $request->sparkActual[0];
                $beddingActual->status = $request->status[0];
                $beddingActual->productionOperator = $request->productionOperator[0];
                $beddingActual->notes = $request->notes[0];
                $beddingActual->added_by = $name;
                $beddingActual->shift = $shift;
                $beddingActual->save();



                //To  Add New BeddingActualTimes
                $beddingActualTime = new BeddingActualsTimes();
                $beddingActualTime->beddingactuals_id = $beddingActual->id;
                $beddingActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $beddingActualTime->machine_time = $request->machine[1];
                $beddingActualTime->inputDrum_time = $request->inputDrum[1];
                $beddingActualTime->inputCard_time = $request->inputCard[1];
                $beddingActualTime->inputLength_time = $request->inputLength[1];
                $beddingActualTime->outputDrum_time = $request->outputDrum[1];
                $beddingActualTime->outputCard_time = $request->outputCard[1];
                $beddingActualTime->outputLength_time = $request->outputLength[1];
                $beddingActualTime->colorActual_time = $request->colorActual[1];
                $beddingActualTime->thicknessStartMinActual_time = $request->thicknessStartMinActual[1];
                $beddingActualTime->thicknessStartNomActual_time = $request->thicknessStartNomActual[1];
                $beddingActualTime->thicknessStartMaxActual_time = $request->thicknessStartMaxActual[1];
                $beddingActualTime->thicknessEndMinActual_time = $request->thicknessEndMinActual[1];
                $beddingActualTime->thicknessEndNomActual_time = $request->thicknessEndNomActual[1];
                $beddingActualTime->thicknessEndMaxActual_time = $request->thicknessEndMaxActual[1];
                $beddingActualTime->eccentricityActual_time = $request->eccentricityActual[1];
                $beddingActualTime->dimBefore1_time = $request->dimBefore1[1];
                $beddingActualTime->dimBefore2_time = $request->dimBefore2[1];
                $beddingActualTime->dimAfterStartMin_time = $request->dimAfterStartMin[1];
                $beddingActualTime->dimAfterStartNom_time = $request->dimAfterStartNom[1];
                $beddingActualTime->dimAfterStartMax_time = $request->dimAfterStartMax[1];
                $beddingActualTime->dimAfterEndMin_time = $request->dimAfterEndMin[1];
                $beddingActualTime->dimAfterEndNom_time = $request->dimAfterEndNom[1];
                $beddingActualTime->dimAfterEndMax_time = $request->dimAfterEndMax[1];
                $beddingActualTime->weightActual_time = $request->weightActual[1];
                $beddingActualTime->materialActual_time = $request->materialActual[1];
                $beddingActualTime->ovalityActual1_time = $request->ovalityActual1[1];
                $beddingActualTime->ovalityActual2_time = $request->ovalityActual2[1];
                $beddingActualTime->sparkActual_time = $request->sparkActual[1];
                $beddingActualTime->status_time = $request->status[1];
                $beddingActualTime->productionOperator_time = $request->productionOperator[1];
                $beddingActualTime->notes_time = $request->notes[1];
                $beddingActualTime->added_by = $name;
                $beddingActualTime->shift = $shift;
                $beddingActualTime->save();

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $beddingActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->cableSize[0] == null) ? '' : $request->cableSize[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = ($request->cableDescription[0] == null) ? '' : $request->cableDescription[0];
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Bedding";
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
                $nameOfWhoMadeInsert = DB::table('beddingactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('beddingactuals')->find($request->id_update)->shift;

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

                $rowDataBeddingActual = DB::table('beddingactuals')
                    ->where('id', '=', $request->id_update)
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
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $rowDataBeddingActualTime = DB::table('beddingactualstimes')
                    ->where('beddingactuals_id', '=', $request->id_update)
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
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Bedding'], ['sheet_id', $request->id_update]])->exists();
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
                        $hold->fromSheet = "Bedding";
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
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Bedding'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Bedding'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->cableSize[0],
                                'length' => $request->outputLength[0],
                                'description' => $request->cableDescription[0],
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Bedding",
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

            $checkJopOrderNumber = DB::table('beddingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $beddingStandard = DB::table('beddingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $beddingStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $alertIsExist = DB::table('beddingactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataBeddingActual = DB::table('beddingactuals')->where('id', $request->id)->first();
            $rowDataBeddingStandard = DB::table('beddingstandards')->where('id', $rowDataBeddingActual->jopOrderNumber_id)->first();
            $rowDataBeddingActualTime = DB::table('beddingactualstimes')->where('id', $request->id)->first();
            $rowDataBeddingStandardTime = DB::table('beddingstandardstimes')->where('id', $rowDataBeddingActual->jopOrderNumber_id)->first();

            return array(
                $rowDataBeddingStandard,
                $rowDataBeddingActual,
                $rowDataBeddingActualTime,
                $rowDataBeddingStandardTime
            );
        }
    }
}
