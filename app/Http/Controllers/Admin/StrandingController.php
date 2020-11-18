<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Hold;
use App\HoldTime;
use App\StrandingActual;
use App\StrandingActualsTimes;
use App\StrandingStandard;
use App\StrandingStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StrandingController extends Controller
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

    public function insertStranding(Request $request)
    {
        // return $request;
        if ($request->ajax()) {

            $this->request = $request;

            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

                if (!$checkJopOrderNumber) {

                    //To Add New StrandingStansard
                    $strandingStandard = new StrandingStandard();
                    $strandingStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $strandingStandard->size = $request->size[0];
                    $strandingStandard->type = $request->type[0];
                    $strandingStandard->volt = $request->volt[0];
                    $strandingStandard->conductorDimStandard = $request->conductorDimStandard[0];
                    $strandingStandard->preformingLayStandard = $request->preformingLayStandard[0];
                    $strandingStandard->waterBlockingTapStandard = $request->waterBlockingTapStandard[0];
                    $strandingStandard->TDS_number = $request->TDS_number[0];
                    $strandingStandard->conductorWeightStandard = $request->conductorWeightStandard[0];
                    $strandingStandard->resistance = $request->resistance[0];
                    $strandingStandard->constructionStandard = $request->constructionStandard[0];
                    $strandingStandard->layLengthStandard = $request->layLengthStandard[0];
                    $strandingStandard->powder_grease_weightStandard = $request->powder_grease_weightStandard[0];
                    $strandingStandard->added_by = $name;
                    $strandingStandard->shift = $shift;
                    $strandingStandard->save();

                    $jopOrderNumber_id = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New StrandingStansardTimes
                    $strandingStandardTime = new StrandingStandardsTimes();
                    $strandingStandardTime->strandingstandards_id = $jopOrderNumber_id;
                    $strandingStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $strandingStandardTime->size_time = $request->size[1];
                    $strandingStandardTime->type_time = $request->type[1];
                    $strandingStandardTime->volt_time = $request->volt[1];
                    $strandingStandardTime->conductorDimStandard_time = $request->conductorDimStandard[1];
                    $strandingStandardTime->preformingLayStandard_time = $request->preformingLayStandard[1];
                    $strandingStandardTime->waterBlockingTapStandard_time = $request->waterBlockingTapStandard[1];
                    $strandingStandardTime->TDS_number_time = $request->TDS_number[1];
                    $strandingStandardTime->conductorWeightStandard_time = $request->conductorWeightStandard[1];
                    $strandingStandardTime->resistance_time = $request->resistance[1];
                    $strandingStandardTime->constructionStandard_time = $request->constructionStandard[1];
                    $strandingStandardTime->layLengthStandard_time = $request->layLengthStandard[1];
                    $strandingStandardTime->powder_grease_weightStandard_time = $request->powder_grease_weightStandard[1];
                    $strandingStandardTime->added_by = $name;
                    $strandingStandardTime->shift = $shift;
                    $strandingStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                $regex_angel = "/^[0-9.]+$/";
                $regex_conductorDimActual_HS = "/^([0-9.]+\*[0-9.]+)?$/";

                if ($request->shape[0] == "Sector" && !preg_match($regex_angel, $request->angel[0])) {
                    return "Error-angel";
                }

                if (
                    empty($request->inputCard1[0]) &&
                    (!empty($request->inputCard2[0]) || !empty($request->inputCard3[0]) || !empty($request->inputCard4[0]))
                ) {
                    return 'Error-inputCard1';
                }

                if (
                    empty($request->cage1[0]) &&
                    (!empty($request->cage2[0]) || !empty($request->cage3[0]) || !empty($request->cage4[0]))
                ) {
                    return 'Error-cage1';
                }

                if (
                    (empty($request->conductorDimActual_HS1[0]) && (!empty($request->conductorDimActual_HS2[0]) || !empty($request->conductorDimActual_HS3[0]) || !empty($request->conductorDimActual_HS4[0])))
                    ||
                    (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS1[0]))
                ) {
                    return 'Error-conductorDimActual_HS1';
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS2[0])) {
                    return "Error-conductorDimActual_HS2";
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS3[0])) {
                    return "Error-conductorDimActual_HS3";
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS4[0])) {
                    return "Error-conductorDimActual_HS4";
                }

                if (
                    empty($request->conductorDimActual_FI1[0]) &&
                    (!empty($request->conductorDimActual_FI2[0]) || !empty($request->conductorDimActual_FI3[0]) || !empty($request->conductorDimActual_FI4[0]))
                ) {
                    return 'Error-conductorDimActual_FI1';
                }

                if (
                    (
                        (empty($request->resistance1[0]) || empty($request->length1[0])) &&
                        (!empty($request->resistance1[0]) || !empty($request->length1[0]))) ||
                    (
                        (empty($request->resistance1[0]) && empty($request->length1[0])) &&
                        (
                            (!empty($request->resistance2[0]) && !empty($request->length2[0])) ||
                            (!empty($request->resistance3[0]) && !empty($request->length3[0])) ||
                            (!empty($request->resistance4[0]) && !empty($request->length4[0]))))
                ) {
                    return 'Error-resistanceAtLength1';
                }

                if (
                    (empty($request->resistance2[0]) || empty($request->length2[0])) &&
                    (!empty($request->resistance2[0]) || !empty($request->length2[0]))
                ) {
                    return 'Error-resistanceAtLength2';
                }

                if (
                    (empty($request->resistance3[0]) || empty($request->length3[0])) &&
                    (!empty($request->resistance3[0]) || !empty($request->length3[0]))
                ) {
                    return 'Error-resistanceAtLength3';
                }

                if (
                    (empty($request->resistance4[0]) || empty($request->length4[0])) &&
                    (!empty($request->resistance4[0]) || !empty($request->length4[0]))
                ) {
                    return 'Error-resistanceAtLength4';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                //To Add New StrandingActual
                $strandingActual = new StrandingActual();
                $strandingActual->jopOrderNumber_id = $jopOrderNumber_id;
                $strandingActual->jopOrderNumber = $request->jopOrderNumber[0];
                $strandingActual->machine = $request->machine[0];
                $strandingActual->shape = $request->shape[0];
                ($request->shape[0] == "Sector") ? $strandingActual->angel = $request->angel[0] : $strandingActual->angel = "";
                $strandingActual->inputCard1 = $request->inputCard1[0];
                $strandingActual->inputCard2 = $request->inputCard2[0];
                $strandingActual->inputCard3 = $request->inputCard3[0];
                $strandingActual->inputCard4 = $request->inputCard4[0];
                $strandingActual->cage1 = $request->cage1[0];
                $strandingActual->cage2 = $request->cage2[0];
                $strandingActual->cage3 = $request->cage3[0];
                $strandingActual->cage4 = $request->cage4[0];
                $strandingActual->drumNumber = $request->drumNumber[0];
                $strandingActual->outputCard = $request->outputCard[0];
                $strandingActual->length = $request->length[0];
                $strandingActual->constructionActual = $request->constructionActual[0];
                $strandingActual->conductorDimActual_HS1 = $request->conductorDimActual_HS1[0];
                $strandingActual->conductorDimActual_HS2 = $request->conductorDimActual_HS2[0];
                $strandingActual->conductorDimActual_HS3 = $request->conductorDimActual_HS3[0];
                $strandingActual->conductorDimActual_HS4 = $request->conductorDimActual_HS4[0];
                $strandingActual->conductorDimActual_FI1 = $request->conductorDimActual_FI1[0];
                $strandingActual->conductorDimActual_FI2 = $request->conductorDimActual_FI2[0];
                $strandingActual->conductorDimActual_FI3 = $request->conductorDimActual_FI3[0];
                $strandingActual->conductorDimActual_FI4 = $request->conductorDimActual_FI4[0];
                $strandingActual->ovality = $request->ovality[0];
                $strandingActual->preformingLayActual = $request->preformingLayActual[0];
                $strandingActual->waterBlockingTapActual = $request->waterBlockingTapActual[0];
                $strandingActual->layLengthDirection = $request->layLengthDirection[0];
                $strandingActual->conductorWeightActual = $request->conductorWeightActual[0];
                $strandingActual->resistance1 = $request->resistance1[0];
                $strandingActual->length1 = $request->length1[0];
                $strandingActual->resistance2 = $request->resistance2[0];
                $strandingActual->length2 = $request->length2[0];
                $strandingActual->resistance3 = $request->resistance3[0];
                $strandingActual->length3 = $request->length3[0];
                $strandingActual->resistance4 = $request->resistance4[0];
                $strandingActual->length4 = $request->length4[0];
                $strandingActual->layLengthActual = $request->layLengthActual[0];
                $strandingActual->powder_grease_weightActual = $request->powder_grease_weightActual[0];
                $strandingActual->visual = $request->visual[0];
                $strandingActual->status = $request->status[0];
                $strandingActual->productionOperator = $request->productionOperator[0];
                $strandingActual->notes = $request->notes[0];
                $strandingActual->added_by = $name;
                $strandingActual->shift = $shift;
                $strandingActual->save();

                //To  Add New StrandingActualTimes
                $strandingActualTime = new StrandingActualsTimes();
                $strandingActualTime->strandingactuals_id = $strandingActual->id;
                $strandingActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $strandingActualTime->machine_time = $request->machine[1];
                $strandingActualTime->shape_time = $request->shape[1];
                ($request->shape[0] == "Sector") ? $strandingActualTime->angel_time = $request->angel[1] : $strandingActualTime->angel_time = "";
                $strandingActualTime->inputCard1_time = $request->inputCard1[1];
                $strandingActualTime->inputCard2_time = $request->inputCard2[1];
                $strandingActualTime->inputCard3_time = $request->inputCard3[1];
                $strandingActualTime->inputCard4_time = $request->inputCard4[1];
                $strandingActualTime->cage1_time = $request->cage1[1];
                $strandingActualTime->cage2_time = $request->cage2[1];
                $strandingActualTime->cage3_time = $request->cage3[1];
                $strandingActualTime->cage4_time = $request->cage4[1];
                $strandingActualTime->drumNumber_time = $request->drumNumber[1];
                $strandingActualTime->outputCard_time = $request->outputCard[1];
                $strandingActualTime->length_time = $request->length[1];
                $strandingActualTime->constructionActual_time = $request->constructionActual[1];
                $strandingActualTime->conductorDimActual_HS1_time = $request->conductorDimActual_HS1[1];
                $strandingActualTime->conductorDimActual_HS2_time = $request->conductorDimActual_HS2[1];
                $strandingActualTime->conductorDimActual_HS3_time = $request->conductorDimActual_HS3[1];
                $strandingActualTime->conductorDimActual_HS4_time = $request->conductorDimActual_HS4[1];
                $strandingActualTime->conductorDimActual_FI1_time = $request->conductorDimActual_FI1[1];
                $strandingActualTime->conductorDimActual_FI2_time = $request->conductorDimActual_FI2[1];
                $strandingActualTime->conductorDimActual_FI3_time = $request->conductorDimActual_FI3[1];
                $strandingActualTime->conductorDimActual_FI4_time = $request->conductorDimActual_FI4[1];
                $strandingActualTime->ovality_time = $request->ovality[1];
                $strandingActualTime->preformingLayActual_time = $request->preformingLayActual[1];
                $strandingActualTime->waterBlockingTapActual_time = $request->waterBlockingTapActual[1];
                $strandingActualTime->layLengthDirection_time = $request->layLengthDirection[1];
                $strandingActualTime->conductorWeightActual_time = $request->conductorWeightActual[1];
                $strandingActualTime->resistance1_time = $request->resistance1[1];
                $strandingActualTime->length1_time = $request->length1[1];
                $strandingActualTime->resistance2_time = $request->resistance2[1];
                $strandingActualTime->length2_time = $request->length2[1];
                $strandingActualTime->resistance3_time = $request->resistance3[1];
                $strandingActualTime->length3_time = $request->length3[1];
                $strandingActualTime->resistance4_time = $request->resistance4[1];
                $strandingActualTime->length4_time = $request->length4[1];
                $strandingActualTime->layLengthActual_time = $request->layLengthActual[1];
                $strandingActualTime->powder_grease_weightActual_time = $request->powder_grease_weightActual[1];
                $strandingActualTime->visual_time = $request->visual[1];
                $strandingActualTime->status_time = $request->status[1];
                $strandingActualTime->productionOperator_time = $request->productionOperator[1];
                $strandingActualTime->notes_time = $request->notes[1];
                $strandingActualTime->added_by = $name;
                $strandingActualTime->shift = $shift;
                $strandingActualTime->save();

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $strandingActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->drumNumber[0] == null) ? '' : $request->drumNumber[0];
                    $hold->cableSize = ($request->size[0] == null) ? '' : $request->size[0];
                    $hold->length = ($request->length[0] == null) ? '' : $request->length[0];
                    $hold->description = '';
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Stranding";
                    $hold->added_by = $name;
                    $hold->shift = $shift;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = ($request->jopOrderNumber[1] == null) ? '' : $request->jopOrderNumber[1];
                    $holdTime->drumNumber_time = ($request->drumNumber[1] == null) ? '' : $request->drumNumber[1];
                    $holdTime->cableSize_time = ($request->size[1] == null) ? '' : $request->size[1];
                    $holdTime->length_time = ($request->length[1] == null) ? '' : $request->length[1];
                    $holdTime->description_time = '';
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
                $nameOfWhoMadeInsert = DB::table('strandingactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('strandingactuals')->find($request->id_update)->shift;

                $regex_angel = "/^[0-9.]+$/";
                $regex_conductorDimActual_HS = "/^([0-9.]+\*[0-9.]+)?$/";

                if ($request->shape[0] == "Sector" && !preg_match($regex_angel, $request->angel[0])) {
                    return "Error-angel";
                }

                if (
                    empty($request->inputCard1[0]) &&
                    (!empty($request->inputCard2[0]) || !empty($request->inputCard3[0]) || !empty($request->inputCard4[0]))
                ) {
                    return 'Error-inputCard1';
                }

                if (
                    empty($request->cage1[0]) &&
                    (!empty($request->cage2[0]) || !empty($request->cage3[0]) || !empty($request->cage4[0]))
                ) {
                    return 'Error-cage1';
                }

                if (
                    (empty($request->conductorDimActual_HS1[0]) && (!empty($request->conductorDimActual_HS2[0]) || !empty($request->conductorDimActual_HS3[0]) || !empty($request->conductorDimActual_HS4[0])))
                    ||
                    (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS1[0]))
                ) {
                    return 'Error-conductorDimActual_HS1';
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS2[0])) {
                    return "Error-conductorDimActual_HS2";
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS3[0])) {
                    return "Error-conductorDimActual_HS3";
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS4[0])) {
                    return "Error-conductorDimActual_HS4";
                }

                if (
                    empty($request->conductorDimActual_FI1[0]) &&
                    (!empty($request->conductorDimActual_FI2[0]) || !empty($request->conductorDimActual_FI3[0]) || !empty($request->conductorDimActual_FI4[0]))
                ) {
                    return 'Error-conductorDimActual_FI1';
                }

                if (
                    (
                        (empty($request->resistance1[0]) || empty($request->length1[0])) &&
                        (!empty($request->resistance1[0]) || !empty($request->length1[0]))) ||
                    (
                        (empty($request->resistance1[0]) && empty($request->length1[0])) &&
                        (!empty($request->resistance2[0]) && !empty($request->length2[0])) &&
                        (!empty($request->resistance3[0]) && !empty($request->length3[0])) &&
                        (!empty($request->resistance4[0]) && !empty($request->length4[0])))
                ) {
                    return 'Error-resistanceAtLength1';
                }

                if (
                    (empty($request->resistance2[0]) || empty($request->length2[0])) &&
                    (!empty($request->resistance2[0]) || !empty($request->length2[0]))
                ) {
                    return 'Error-resistanceAtLength2';
                }

                if (
                    (empty($request->resistance3[0]) || empty($request->length3[0])) &&
                    (!empty($request->resistance3[0]) || !empty($request->length3[0]))
                ) {
                    return 'Error-resistanceAtLength3';
                }

                if (
                    (empty($request->resistance4[0]) || empty($request->length4[0])) &&
                    (!empty($request->resistance4[0]) || !empty($request->length4[0]))
                ) {
                    return 'Error-resistanceAtLength4';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }


                $rowDataStrandingActual = DB::table('strandingactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'shape' => $request->shape[0],
                        'angel' => ($request->shape[0] == "Sector") ? $request->angel[0] : "",
                        'inputCard1' => $request->inputCard1[0],
                        'inputCard2' => $request->inputCard2[0],
                        'inputCard3' => $request->inputCard3[0],
                        'inputCard4' => $request->inputCard4[0],
                        'cage1' => $request->cage1[0],
                        'cage2' => $request->cage2[0],
                        'cage3' => $request->cage3[0],
                        'cage4' => $request->cage4[0],
                        'drumNumber' => $request->drumNumber[0],
                        'outputCard' => $request->outputCard[0],
                        'length' => $request->length[0],
                        'constructionActual' => $request->constructionActual[0],
                        'conductorDimActual_HS1' => $request->conductorDimActual_HS1[0],
                        'conductorDimActual_HS2' => $request->conductorDimActual_HS2[0],
                        'conductorDimActual_HS3' => $request->conductorDimActual_HS3[0],
                        'conductorDimActual_HS4' => $request->conductorDimActual_HS4[0],
                        'conductorDimActual_FI1' => $request->conductorDimActual_FI1[0],
                        'conductorDimActual_FI2' => $request->conductorDimActual_FI2[0],
                        'conductorDimActual_FI3' => $request->conductorDimActual_FI3[0],
                        'conductorDimActual_FI4' => $request->conductorDimActual_FI4[0],
                        'ovality' => $request->ovality[0],
                        'preformingLayActual' => $request->preformingLayActual[0],
                        'waterBlockingTapActual' => $request->waterBlockingTapActual[0],
                        'layLengthDirection' => $request->layLengthDirection[0],
                        'resistance1' => $request->resistance1[0],
                        'length1' => $request->length1[0],
                        'resistance2' => $request->resistance2[0],
                        'length2' => $request->length2[0],
                        'resistance3' => $request->resistance3[0],
                        'length3' => $request->length3[0],
                        'resistance4' => $request->resistance4[0],
                        'length4' => $request->length4[0],
                        'conductorWeightActual' => $request->conductorWeightActual[0],
                        'layLengthActual' => $request->layLengthActual[0],
                        'powder_grease_weightActual' => $request->powder_grease_weightActual[0],
                        'visual' => $request->visual[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate,
                    ]);

                $rowDataStrandingActualTime = DB::table('strandingactualstimes')
                    ->where('strandingactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'shape_time' => $request->shape[1],
                        'angel_time' => ($request->shape[0] == "Sector") ? $request->angel[1] : "",
                        'inputCard1_time' => $request->inputCard1[1],
                        'inputCard2_time' => $request->inputCard2[1],
                        'inputCard3_time' => $request->inputCard3[1],
                        'inputCard4_time' => $request->inputCard4[1],
                        'cage1_time' => $request->cage1[1],
                        'cage2_time' => $request->cage2[1],
                        'cage3_time' => $request->cage3[1],
                        'cage4_time' => $request->cage4[1],
                        'drumNumber_time' => $request->drumNumber[1],
                        'outputCard_time' => $request->outputCard[1],
                        'length_time' => $request->length[1],
                        'constructionActual_time' => $request->constructionActual[1],
                        'conductorDimActual_HS1_time' => $request->conductorDimActual_HS1[1],
                        'conductorDimActual_HS2_time' => $request->conductorDimActual_HS2[1],
                        'conductorDimActual_HS3_time' => $request->conductorDimActual_HS3[1],
                        'conductorDimActual_HS4_time' => $request->conductorDimActual_HS4[1],
                        'conductorDimActual_FI1_time' => $request->conductorDimActual_FI1[1],
                        'conductorDimActual_FI2_time' => $request->conductorDimActual_FI2[1],
                        'conductorDimActual_FI3_time' => $request->conductorDimActual_FI3[1],
                        'conductorDimActual_FI4_time' => $request->conductorDimActual_FI4[1],
                        'ovality_time' => $request->ovality[1],
                        'preformingLayActual_time' => $request->preformingLayActual[1],
                        'waterBlockingTapActual_time' => $request->waterBlockingTapActual[1],
                        'layLengthDirection_time' => $request->layLengthDirection[1],
                        'resistance1_time' => $request->resistance1[1],
                        'length1_time' => $request->length1[1],
                        'resistance2_time' => $request->resistance2[1],
                        'length2_time' => $request->length2[1],
                        'resistance3_time' => $request->resistance3[1],
                        'length3_time' => $request->length3[1],
                        'resistance4_time' => $request->resistance4[1],
                        'length4_time' => $request->length4[1],
                        'conductorWeightActual_time' => $request->conductorWeightActual[1],
                        'layLengthActual_time' => $request->layLengthActual[1],
                        'powder_grease_weightActual_time' => $request->powder_grease_weightActual[1],
                        'visual_time' => $request->visual[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'notes_time' => $request->notes[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);


                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Stranding'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = $request->drumNumber[0];
                        $hold->cableSize = $request->size[0];
                        $hold->length = $request->length[0];
                        $hold->description = '';
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Stranding";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeInsert;
                        $hold->save();

                        // To Add New HoldTime
                        $holdTime = new HoldTime();
                        $holdTime->hold_id = $hold->id;
                        $holdTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                        $holdTime->drumNumber_time = $request->drumNumber[1];
                        $holdTime->cableSize_time = $request->size[1];
                        $holdTime->length_time = $request->length[1];
                        $holdTime->description_time = '';
                        $holdTime->machine_time = $request->machine[1];
                        $holdTime->reasonOfHold_time = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Stranding'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Stranding'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->drumNumber[0],
                                'cableSize' => $request->size[0],
                                'length' => $request->length[0],
                                'description' => '',
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Stranding",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[1],
                                'drumNumber_time' => $request->drumNumber[1],
                                'cableSize_time' => $request->size[1],
                                'length_time' => $request->length[1],
                                'description_time' => '',
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

            $checkJopOrderNumber = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $strandingStandard = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $strandingStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            //  return $request;

            $alertIsExist = DB::table('strandingactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataStrandingActual = DB::table('strandingactuals')->where('id', $request->id)->first();
            $rowDataStrandingStandard = DB::table('strandingstandards')->where('id', $rowDataStrandingActual->jopOrderNumber_id)->first();
            $rowDataStrandingActualTime = DB::table('strandingactualstimes')->where('id', $request->id)->first();
            $rowDataStrandingStandardTime = DB::table('strandingstandardstimes')->where('id', $rowDataStrandingActual->jopOrderNumber_id)->first();

            return array(
                $rowDataStrandingStandard,
                $rowDataStrandingActual,
                $rowDataStrandingActualTime,
                $rowDataStrandingStandardTime
            );
        }
    }
}
