<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Events\WatchingEmployee;
use App\Hold;
use App\HoldTime;
use App\StrandingActual;
use App\StrandingActualsTimes;
use App\StrandingStandard;
use App\StrandingStandardsTimes;
use App\Traceability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StrandingController extends Controller
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

    public function insertStranding(Request $request)
    {
        if ($request->ajax()) {
            $this->request = $request;
            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }
            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;


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

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS1[0])) {
                    return "Error-conductorDimActual_HS1";
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

                // Traceability
                if (!empty($request->outputCard[0])) {
                    $chain = array($request->outputCard[0]);

                    $newTraceability = new Traceability();
                    $newTraceability->jopOrderNumber = $request->jopOrderNumber[0];
                    $newTraceability->outputCard = $request->outputCard[0];
                    $newTraceability->stranding_id = $strandingActual->id;
                    $newTraceability->chain = serialize($chain);
                    $newTraceability->save();
                }

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

                //To save change That Happend in Stranding Table
                $strandings = DB::table('strandings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'size' => '',
                    'type' => '',
                    'volt' => '',
                    'conductorDimStandard' => '',
                    'preformingLayStandard' => '',
                    'waterBlockingTapStandard' => '',
                    'TDS_number' => '',
                    'conductorWeightStandard' => '',
                    'resistance' => '',
                    'constructionStandard' => '',
                    'layLengthStandard' => '',
                    'powder_grease_weightStandard' => '',
                    'machine' => '',
                    'shape' => '',
                    'angel' => '',
                    'inputCard1' => '',
                    'inputCard2' => '',
                    'inputCard3' => '',
                    'inputCard4' => '',
                    'cage1' => '',
                    'cage2' => '',
                    'cage3' => '',
                    'cage4' => '',
                    'drumNumber' => '',
                    'outputCard' => '',
                    'length' => '',
                    'constructionActual' => '',
                    'conductorDimActual_HS1' => '',
                    'conductorDimActual_HS2' => '',
                    'conductorDimActual_HS3' => '',
                    'conductorDimActual_HS4' => '',
                    'conductorDimActual_FI1' => '',
                    'conductorDimActual_FI2' => '',
                    'conductorDimActual_FI3' => '',
                    'conductorDimActual_FI4' => '',
                    'ovality' => '',
                    'preformingLayActual' => '',
                    'waterBlockingTapActual' => '',
                    'layLengthDirection' => '',
                    'conductorWeightActual' => '',
                    'resistance1' => '',
                    'length1' => '',
                    'resistance2' => '',
                    'length2' => '',
                    'resistance3' => '',
                    'length3' => '',
                    'resistance4' => '',
                    'length4' => '',
                    'layLengthActual' => '',
                    'powder_grease_weightActual' => '',
                    'visual' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size',
                    'type',
                    'volt',
                    'conductorDimStandard',
                    'preformingLayStandard',
                    'waterBlockingTapStandard',
                    'TDS_number',
                    'conductorWeightStandard',
                    'resistance',
                    'constructionStandard',
                    'layLengthStandard',
                    'powder_grease_weightStandard',
                    'machine',
                    'shape',
                    'angel',
                    'inputCard1',
                    'inputCard2',
                    'inputCard3',
                    'inputCard4',
                    'cage1',
                    'cage2',
                    'cage3',
                    'cage4',
                    'drumNumber',
                    'outputCard',
                    'length',
                    'constructionActual',
                    'conductorDimActual_HS1',
                    'conductorDimActual_HS2',
                    'conductorDimActual_HS3',
                    'conductorDimActual_HS4',
                    'conductorDimActual_FI1',
                    'conductorDimActual_FI2',
                    'conductorDimActual_FI3',
                    'conductorDimActual_FI4',
                    'ovality',
                    'preformingLayActual',
                    'waterBlockingTapActual',
                    'layLengthDirection',
                    'conductorWeightActual',
                    'resistance1',
                    'length1',
                    'resistance2',
                    'length2',
                    'resistance3',
                    'length3',
                    'resistance4',
                    'length4',
                    'layLengthActual',
                    'powder_grease_weightActual',
                    'visual',
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
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('stranding', $request->data_form_item, $attributes, $values));
            } else {

                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('strandingactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('strandingactuals')->find($request->id_update)->shift;

                $regex_angel = "/^[0-9.]+$/";
                $regex_conductorDimActual_HS = "/^([0-9.]+\*[0-9.]+)?$/";

                if ($request->shape[0] == "Sector" && !preg_match($regex_angel, $request->angel[0])) {
                    return "Error-angel";
                }

                if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS1[0])) {
                    return "Error-conductorDimActual_HS1";
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
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
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

                // Traceability
                $checkTraceability = DB::table("traceability")->where("stranding_id", $request->id_update)->exists();

                if (!$checkTraceability) {
                    $chain = array($request->outputCard[0]);

                    $newTraceability = new Traceability();
                    $newTraceability->jopOrderNumber = $request->jopOrderNumber[0];
                    $newTraceability->outputCard = $request->outputCard[0];
                    $newTraceability->stranding_id = $request->id_update;
                    $newTraceability->chain = serialize($chain);
                    $newTraceability->save();
                }

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

                //To save change That Happend in Stranding Table
                $strandings = DB::table('strandings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $nameOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'size' => '',
                    'type' => '',
                    'volt' => '',
                    'conductorDimStandard' => '',
                    'preformingLayStandard' => '',
                    'waterBlockingTapStandard' => '',
                    'TDS_number' => '',
                    'conductorWeightStandard' => '',
                    'resistance' => '',
                    'constructionStandard' => '',
                    'layLengthStandard' => '',
                    'powder_grease_weightStandard' => '',
                    'machine' => '',
                    'shape' => '',
                    'angel' => '',
                    'inputCard1' => '',
                    'inputCard2' => '',
                    'inputCard3' => '',
                    'inputCard4' => '',
                    'cage1' => '',
                    'cage2' => '',
                    'cage3' => '',
                    'cage4' => '',
                    'drumNumber' => '',
                    'outputCard' => '',
                    'length' => '',
                    'constructionActual' => '',
                    'conductorDimActual_HS1' => '',
                    'conductorDimActual_HS2' => '',
                    'conductorDimActual_HS3' => '',
                    'conductorDimActual_HS4' => '',
                    'conductorDimActual_FI1' => '',
                    'conductorDimActual_FI2' => '',
                    'conductorDimActual_FI3' => '',
                    'conductorDimActual_FI4' => '',
                    'ovality' => '',
                    'preformingLayActual' => '',
                    'waterBlockingTapActual' => '',
                    'layLengthDirection' => '',
                    'conductorWeightActual' => '',
                    'resistance1' => '',
                    'length1' => '',
                    'resistance2' => '',
                    'length2' => '',
                    'resistance3' => '',
                    'length3' => '',
                    'resistance4' => '',
                    'length4' => '',
                    'layLengthActual' => '',
                    'powder_grease_weightActual' => '',
                    'visual' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size',
                    'type',
                    'volt',
                    'conductorDimStandard',
                    'preformingLayStandard',
                    'waterBlockingTapStandard',
                    'TDS_number',
                    'conductorWeightStandard',
                    'resistance',
                    'constructionStandard',
                    'layLengthStandard',
                    'powder_grease_weightStandard',
                    'machine',
                    'shape',
                    'angel',
                    'inputCard1',
                    'inputCard2',
                    'inputCard3',
                    'inputCard4',
                    'cage1',
                    'cage2',
                    'cage3',
                    'cage4',
                    'drumNumber',
                    'outputCard',
                    'length',
                    'constructionActual',
                    'conductorDimActual_HS1',
                    'conductorDimActual_HS2',
                    'conductorDimActual_HS3',
                    'conductorDimActual_HS4',
                    'conductorDimActual_FI1',
                    'conductorDimActual_FI2',
                    'conductorDimActual_FI3',
                    'conductorDimActual_FI4',
                    'ovality',
                    'preformingLayActual',
                    'waterBlockingTapActual',
                    'layLengthDirection',
                    'conductorWeightActual',
                    'resistance1',
                    'length1',
                    'resistance2',
                    'length2',
                    'resistance3',
                    'length3',
                    'resistance4',
                    'length4',
                    'layLengthActual',
                    'powder_grease_weightActual',
                    'visual',
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
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('stranding', $request->data_form_item, $attributes, $values));

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
            $checkJopOrderNumber = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $strandingStandard = DB::table('strandingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();

                //To save change That Happend in Stranding Table
                $strandings = DB::table('strandings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $strandingStandard->jopOrderNumber,
                    'size' => $strandingStandard->size,
                    'type' => $strandingStandard->type,
                    'volt' => $strandingStandard->volt,
                    'conductorDimStandard' => $strandingStandard->conductorDimStandard,
                    'preformingLayStandard' => $strandingStandard->preformingLayStandard,
                    'waterBlockingTapStandard' => $strandingStandard->waterBlockingTapStandard,
                    'TDS_number' => $strandingStandard->TDS_number,
                    'conductorWeightStandard' => $strandingStandard->conductorWeightStandard,
                    'resistance' => $strandingStandard->resistance,
                    'constructionStandard' => $strandingStandard->constructionStandard,
                    'layLengthStandard' => $strandingStandard->layLengthStandard,
                    'powder_grease_weightStandard' => $strandingStandard->powder_grease_weightStandard
                ]);
                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size',
                    'type',
                    'volt',
                    'conductorDimStandard',
                    'preformingLayStandard',
                    'waterBlockingTapStandard',
                    'TDS_number',
                    'conductorWeightStandard',
                    'resistance',
                    'constructionStandard',
                    'layLengthStandard',
                    'powder_grease_weightStandard',
                );
                $values = array(
                    $strandingStandard->jopOrderNumber,
                    $strandingStandard->size,
                    $strandingStandard->type,
                    $strandingStandard->volt,
                    $strandingStandard->conductorDimStandard,
                    $strandingStandard->preformingLayStandard,
                    $strandingStandard->waterBlockingTapStandard,
                    $strandingStandard->TDS_number,
                    $strandingStandard->conductorWeightStandard,
                    $strandingStandard->resistance,
                    $strandingStandard->constructionStandard,
                    $strandingStandard->layLengthStandard,
                    $strandingStandard->powder_grease_weightStandard
                );
                event(new WatchingEmployee('stranding', $request->data_form_item, $attributes, $values));

                return (array) $strandingStandard;
            } else {

                //To save change That Happend in Stranding Table
                $strandings = DB::table('strandings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'size' => '',
                    'type' => '',
                    'volt' => '',
                    'conductorDimStandard' => '',
                    'preformingLayStandard' => '',
                    'waterBlockingTapStandard' => '',
                    'TDS_number' => '',
                    'conductorWeightStandard' => '',
                    'resistance' => '',
                    'constructionStandard' => '',
                    'layLengthStandard' => '',
                    'powder_grease_weightStandard' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'size',
                    'type',
                    'volt',
                    'conductorDimStandard',
                    'preformingLayStandard',
                    'waterBlockingTapStandard',
                    'TDS_number',
                    'conductorWeightStandard',
                    'resistance',
                    'constructionStandard',
                    'layLengthStandard',
                    'powder_grease_weightStandard',
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
                    '',
                    '',
                    ''
                );
                event(new WatchingEmployee('stranding', $request->data_form_item, $attributes, $values));

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

            $alertIsExist = DB::table('strandingactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataStrandingActual = DB::table('strandingactuals')->where('id', $request->id)->first();
            $rowDataStrandingStandard = DB::table('strandingstandards')->where('id', $rowDataStrandingActual->jopOrderNumber_id)->first();
            $rowDataStrandingActualTime = DB::table('strandingactualstimes')->where('id', $request->id)->first();
            $rowDataStrandingStandardTime = DB::table('strandingstandardstimes')->where('id', $rowDataStrandingActual->jopOrderNumber_id)->first();

            //To save change That Happend in Stranding Table
            $strandings = DB::table('strandings')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataStrandingStandard->jopOrderNumber == null) ? '' : $rowDataStrandingStandard->jopOrderNumber,
                'size' => ($rowDataStrandingStandard->size == null) ? '' : $rowDataStrandingStandard->size,
                'type' => ($rowDataStrandingStandard->type == null) ? '' : $rowDataStrandingStandard->type,
                'volt' => ($rowDataStrandingStandard->volt == null) ? '' : $rowDataStrandingStandard->volt,
                'conductorDimStandard' => ($rowDataStrandingStandard->conductorDimStandard == null) ? '' : $rowDataStrandingStandard->conductorDimStandard,
                'preformingLayStandard' => ($rowDataStrandingStandard->preformingLayStandard == null) ? '' : $rowDataStrandingStandard->preformingLayStandard,
                'waterBlockingTapStandard' => ($rowDataStrandingStandard->waterBlockingTapStandard == null) ? '' : $rowDataStrandingStandard->waterBlockingTapStandard,
                'TDS_number' => ($rowDataStrandingStandard->TDS_number == null) ? '' : $rowDataStrandingStandard->TDS_number,
                'conductorWeightStandard' => ($rowDataStrandingStandard->conductorWeightStandard == null) ? '' : $rowDataStrandingStandard->conductorWeightStandard,
                'resistance' => ($rowDataStrandingStandard->resistance == null) ? '' : $rowDataStrandingStandard->resistance,
                'constructionStandard' => ($rowDataStrandingStandard->constructionStandard == null) ? '' : $rowDataStrandingStandard->constructionStandard,
                'layLengthStandard' => ($rowDataStrandingStandard->layLengthStandard == null) ? '' : $rowDataStrandingStandard->layLengthStandard,
                'powder_grease_weightStandard' => ($rowDataStrandingStandard->powder_grease_weightStandard == null) ? '' : $rowDataStrandingStandard->powder_grease_weightStandard,
                'machine' => ($rowDataStrandingActual->machine == null) ? '' : $rowDataStrandingActual->machine,
                'shape' => ($rowDataStrandingActual->shape == null) ? '' : $rowDataStrandingActual->shape,
                'angel' => ($rowDataStrandingActual->angel == null) ? '' : $rowDataStrandingActual->angel,
                'inputCard1' => ($rowDataStrandingActual->inputCard1 == null) ? '' : $rowDataStrandingActual->inputCard1,
                'inputCard2' => ($rowDataStrandingActual->inputCard2 == null) ? '' : $rowDataStrandingActual->inputCard2,
                'inputCard3' => ($rowDataStrandingActual->inputCard3 == null) ? '' : $rowDataStrandingActual->inputCard3,
                'inputCard4' => ($rowDataStrandingActual->inputCard4 == null) ? '' : $rowDataStrandingActual->inputCard4,
                'cage1' => ($rowDataStrandingActual->cage1 == null) ? '' : $rowDataStrandingActual->cage1,
                'cage2' => ($rowDataStrandingActual->cage2 == null) ? '' : $rowDataStrandingActual->cage2,
                'cage3' => ($rowDataStrandingActual->cage3 == null) ? '' : $rowDataStrandingActual->cage3,
                'cage4' => ($rowDataStrandingActual->cage4 == null) ? '' : $rowDataStrandingActual->cage4,
                'drumNumber' => ($rowDataStrandingActual->drumNumber == null) ? '' : $rowDataStrandingActual->drumNumber,
                'outputCard' => ($rowDataStrandingActual->outputCard == null) ? '' : $rowDataStrandingActual->outputCard,
                'length' => ($rowDataStrandingActual->length == null) ? '' : $rowDataStrandingActual->length,
                'constructionActual' => ($rowDataStrandingActual->constructionActual == null) ? '' : $rowDataStrandingActual->constructionActual,
                'conductorDimActual_HS1' => ($rowDataStrandingActual->conductorDimActual_HS1 == null) ? '' : $rowDataStrandingActual->conductorDimActual_HS1,
                'conductorDimActual_HS2' => ($rowDataStrandingActual->conductorDimActual_HS2 == null) ? '' : $rowDataStrandingActual->conductorDimActual_HS2,
                'conductorDimActual_HS3' => ($rowDataStrandingActual->conductorDimActual_HS3 == null) ? '' : $rowDataStrandingActual->conductorDimActual_HS3,
                'conductorDimActual_HS4' => ($rowDataStrandingActual->conductorDimActual_HS4 == null) ? '' : $rowDataStrandingActual->conductorDimActual_HS4,
                'conductorDimActual_FI1' => ($rowDataStrandingActual->conductorDimActual_FI1 == null) ? '' : $rowDataStrandingActual->conductorDimActual_FI1,
                'conductorDimActual_FI2' => ($rowDataStrandingActual->conductorDimActual_FI2 == null) ? '' : $rowDataStrandingActual->conductorDimActual_FI2,
                'conductorDimActual_FI3' => ($rowDataStrandingActual->conductorDimActual_FI3 == null) ? '' : $rowDataStrandingActual->conductorDimActual_FI3,
                'conductorDimActual_FI4' => ($rowDataStrandingActual->conductorDimActual_FI4 == null) ? '' : $rowDataStrandingActual->conductorDimActual_FI4,
                'ovality' => ($rowDataStrandingActual->ovality == null) ? '' : $rowDataStrandingActual->ovality,
                'preformingLayActual' => ($rowDataStrandingActual->preformingLayActual == null) ? '' : $rowDataStrandingActual->preformingLayActual,
                'waterBlockingTapActual' => ($rowDataStrandingActual->waterBlockingTapActual == null) ? '' : $rowDataStrandingActual->waterBlockingTapActual,
                'layLengthDirection' => ($rowDataStrandingActual->layLengthDirection == null) ? '' : $rowDataStrandingActual->layLengthDirection,
                'conductorWeightActual' => ($rowDataStrandingActual->conductorWeightActual == null) ? '' : $rowDataStrandingActual->conductorWeightActual,
                'resistance1' => ($rowDataStrandingActual->resistance1 == null) ? '' : $rowDataStrandingActual->resistance1,
                'length1' => ($rowDataStrandingActual->length1 == null) ? '' : $rowDataStrandingActual->length1,
                'resistance2' => ($rowDataStrandingActual->resistance2 == null) ? '' : $rowDataStrandingActual->resistance2,
                'length2' => ($rowDataStrandingActual->length2 == null) ? '' : $rowDataStrandingActual->length2,
                'resistance3' => ($rowDataStrandingActual->resistance3 == null) ? '' : $rowDataStrandingActual->resistance3,
                'length3' => ($rowDataStrandingActual->length3 == null) ? '' : $rowDataStrandingActual->length3,
                'resistance4' => ($rowDataStrandingActual->resistance4 == null) ? '' : $rowDataStrandingActual->resistance4,
                'length4' => ($rowDataStrandingActual->length4 == null) ? '' : $rowDataStrandingActual->length4,
                'layLengthActual' => ($rowDataStrandingActual->layLengthActual == null) ? '' : $rowDataStrandingActual->layLengthActual,
                'powder_grease_weightActual' => ($rowDataStrandingActual->powder_grease_weightActual == null) ? '' : $rowDataStrandingActual->powder_grease_weightActual,
                'visual' => ($rowDataStrandingActual->visual == null) ? '' : $rowDataStrandingActual->visual,
                'status' => ($rowDataStrandingActual->status == null) ? '' : $rowDataStrandingActual->status,
                'productionOperator' => ($rowDataStrandingActual->productionOperator == null) ? '' : $rowDataStrandingActual->productionOperator,
                'notes' => ($rowDataStrandingActual->notes == null) ? '' : $rowDataStrandingActual->notes
            ]);
            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'size',
                'type',
                'volt',
                'conductorDimStandard',
                'preformingLayStandard',
                'waterBlockingTapStandard',
                'TDS_number',
                'conductorWeightStandard',
                'resistance',
                'constructionStandard',
                'layLengthStandard',
                'powder_grease_weightStandard',
                'machine',
                'shape',
                'angel',
                'inputCard1',
                'inputCard2',
                'inputCard3',
                'inputCard4',
                'cage1',
                'cage2',
                'cage3',
                'cage4',
                'drumNumber',
                'outputCard',
                'length',
                'constructionActual',
                'conductorDimActual_HS1',
                'conductorDimActual_HS2',
                'conductorDimActual_HS3',
                'conductorDimActual_HS4',
                'conductorDimActual_FI1',
                'conductorDimActual_FI2',
                'conductorDimActual_FI3',
                'conductorDimActual_FI4',
                'ovality',
                'preformingLayActual',
                'waterBlockingTapActual',
                'layLengthDirection',
                'conductorWeightActual',
                'resistance1',
                'length1',
                'resistance2',
                'length2',
                'resistance3',
                'length3',
                'resistance4',
                'length4',
                'layLengthActual',
                'powder_grease_weightActual',
                'visual',
                'status',
                'productionOperator',
                'notes'
            );
            $values = array(
                $rowDataStrandingStandard->jopOrderNumber,
                $rowDataStrandingStandard->size,
                $rowDataStrandingStandard->type,
                $rowDataStrandingStandard->volt,
                $rowDataStrandingStandard->conductorDimStandard,
                $rowDataStrandingStandard->preformingLayStandard,
                $rowDataStrandingStandard->waterBlockingTapStandard,
                $rowDataStrandingStandard->TDS_number,
                $rowDataStrandingStandard->conductorWeightStandard,
                $rowDataStrandingStandard->resistance,
                $rowDataStrandingStandard->constructionStandard,
                $rowDataStrandingStandard->layLengthStandard,
                $rowDataStrandingStandard->powder_grease_weightStandard,
                $rowDataStrandingActual->machine,
                $rowDataStrandingActual->shape,
                $rowDataStrandingActual->angel,
                $rowDataStrandingActual->inputCard1,
                $rowDataStrandingActual->inputCard2,
                $rowDataStrandingActual->inputCard3,
                $rowDataStrandingActual->inputCard4,
                $rowDataStrandingActual->cage1,
                $rowDataStrandingActual->cage2,
                $rowDataStrandingActual->cage3,
                $rowDataStrandingActual->cage4,
                $rowDataStrandingActual->drumNumber,
                $rowDataStrandingActual->outputCard,
                $rowDataStrandingActual->length,
                $rowDataStrandingActual->constructionActual,
                $rowDataStrandingActual->conductorDimActual_HS1,
                $rowDataStrandingActual->conductorDimActual_HS2,
                $rowDataStrandingActual->conductorDimActual_HS3,
                $rowDataStrandingActual->conductorDimActual_HS4,
                $rowDataStrandingActual->conductorDimActual_FI1,
                $rowDataStrandingActual->conductorDimActual_FI2,
                $rowDataStrandingActual->conductorDimActual_FI3,
                $rowDataStrandingActual->conductorDimActual_FI4,
                $rowDataStrandingActual->ovality,
                $rowDataStrandingActual->preformingLayActual,
                $rowDataStrandingActual->waterBlockingTapActual,
                $rowDataStrandingActual->layLengthDirection,
                $rowDataStrandingActual->conductorWeightActual,
                $rowDataStrandingActual->resistance1,
                $rowDataStrandingActual->length1,
                $rowDataStrandingActual->resistance2,
                $rowDataStrandingActual->length2,
                $rowDataStrandingActual->resistance3,
                $rowDataStrandingActual->length3,
                $rowDataStrandingActual->resistance4,
                $rowDataStrandingActual->length4,
                $rowDataStrandingActual->layLengthActual,
                $rowDataStrandingActual->powder_grease_weightActual,
                $rowDataStrandingActual->visual,
                $rowDataStrandingActual->status,
                $rowDataStrandingActual->productionOperator,
                $rowDataStrandingActual->notes
            );
            event(new WatchingEmployee('stranding', $request->data_form_item, $attributes, $values));

            return array(
                $rowDataStrandingStandard,
                $rowDataStrandingActual,
                $rowDataStrandingActualTime,
                $rowDataStrandingStandardTime
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

            $rowUpdateData = DB::table('strandings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('stranding', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if (false) {


                $dataRow = DB::table('strandings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();

                if (false) {

                    $message = ['employee' => $name, 'Sheet' => 'Stranding', 'errors' => ''];

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
