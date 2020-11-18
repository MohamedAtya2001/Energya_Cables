<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Hold;
use App\HoldTime;
use App\LeadActual;
use App\LeadActualsTimes;
use App\LeadStandard;
use App\LeadStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
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

    public function insertLead(Request $request)
    {
        // return $request;
        if ($request->ajax()) {

            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('leadstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New LeadStansard
                    $leadStandard = new LeadStandard();
                    $leadStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $leadStandard->size = $request->size[0];
                    $leadStandard->description = $request->description[0];
                    $leadStandard->volt = $request->volt[0];
                    $leadStandard->thicknessMinStandard = $request->thicknessMinStandard[0];
                    $leadStandard->thicknessNomStandard = $request->thicknessNomStandard[0];
                    $leadStandard->thicknessMaxStandard = $request->thicknessMaxStandard[0];
                    $leadStandard->dimAfter = $request->dimAfter[0];
                    $leadStandard->weightStandard = $request->weightStandard[0];
                    $leadStandard->added_by = $name;
                    $leadStandard->shift = $shift;
                    $leadStandard->save();


                    $jopOrderNumber_id = DB::table('leadstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New LeadStansardTimes
                    $leadStandardTime = new LeadStandardsTimes();
                    $leadStandardTime->leadstandards_id = $jopOrderNumber_id;
                    $leadStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $leadStandardTime->size_time = $request->size[1];
                    $leadStandardTime->description_time = $request->description[1];
                    $leadStandardTime->volt_time = $request->volt[1];
                    $leadStandardTime->thicknessMinStandard_time = $request->thicknessMinStandard[1];
                    $leadStandardTime->thicknessNomStandard_time = $request->thicknessNomStandard[1];
                    $leadStandardTime->thicknessMaxStandard_time = $request->thicknessMaxStandard[1];
                    $leadStandardTime->dimAfter_time = $request->dimAfter[1];
                    $leadStandardTime->weightStandard_time = $request->weightStandard[1];
                    $leadStandardTime->added_by = $name;
                    $leadStandardTime->shift = $shift;
                    $leadStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('leadstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

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

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                //To Add New LeadActual
                $leadActual = new LeadActual();
                $leadActual->jopOrderNumber_id = $jopOrderNumber_id;
                $leadActual->jopOrderNumber = $request->jopOrderNumber[0];
                $leadActual->machine = $request->machine[0];
                $leadActual->inputDrum = $request->inputDrum[0];
                $leadActual->inputCard = $request->inputCard[0];
                $leadActual->inputLength = $request->inputLength[0];
                $leadActual->outputDrum = $request->outputDrum[0];
                $leadActual->outputCard = $request->outputCard[0];
                $leadActual->outputLength = $request->outputLength[0];
                $leadActual->thicknessStartMinActual = $request->thicknessStartMinActual[0];
                $leadActual->thicknessStartNomActual = $request->thicknessStartNomActual[0];
                $leadActual->thicknessStartMaxActual = $request->thicknessStartMaxActual[0];
                $leadActual->thicknessEndMinActual = $request->thicknessEndMinActual[0];
                $leadActual->thicknessEndNomActual = $request->thicknessEndNomActual[0];
                $leadActual->thicknessEndMaxActual = $request->thicknessEndMaxActual[0];
                $leadActual->dimBefore1 = $request->dimBefore1[0];
                $leadActual->dimBefore2 = $request->dimBefore2[0];
                $leadActual->dimAfterStart = $request->dimAfterStart[0];
                $leadActual->dimAfterEnd = $request->dimAfterEnd[0];
                $leadActual->weightActual = $request->weightActual[0];
                $leadActual->status = $request->status[0];
                $leadActual->productionOperator = $request->productionOperator[0];
                $leadActual->notes = $request->notes[0];
                $leadActual->added_by = $name;
                $leadActual->shift = $shift;
                $leadActual->save();



                //To  Add New LeadActualTimes
                $leadActualTime = new LeadActualsTimes();
                $leadActualTime->leadactuals_id = $leadActual->id;
                $leadActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $leadActualTime->machine_time = $request->machine[1];
                $leadActualTime->inputDrum_time = $request->inputDrum[1];
                $leadActualTime->inputCard_time = $request->inputCard[1];
                $leadActualTime->inputLength_time = $request->inputLength[1];
                $leadActualTime->outputDrum_time = $request->outputDrum[1];
                $leadActualTime->outputCard_time = $request->outputCard[1];
                $leadActualTime->outputLength_time = $request->outputLength[1];
                $leadActualTime->thicknessStartMinActual_time = $request->thicknessStartMinActual[1];
                $leadActualTime->thicknessStartNomActual_time = $request->thicknessStartNomActual[1];
                $leadActualTime->thicknessStartMaxActual_time = $request->thicknessStartMaxActual[1];
                $leadActualTime->thicknessEndMinActual_time = $request->thicknessEndMinActual[1];
                $leadActualTime->thicknessEndNomActual_time = $request->thicknessEndNomActual[1];
                $leadActualTime->thicknessEndMaxActual_time = $request->thicknessEndMaxActual[1];
                $leadActualTime->dimBefore1_time = $request->dimBefore1[1];
                $leadActualTime->dimBefore2_time = $request->dimBefore2[1];
                $leadActualTime->dimAfterStart_time = $request->dimAfterStart[1];
                $leadActualTime->dimAfterEnd_time = $request->dimAfterEnd[1];
                $leadActualTime->weightActual_time = $request->weightActual[1];
                $leadActualTime->status_time = $request->status[1];
                $leadActualTime->productionOperator_time = $request->productionOperator[1];
                $leadActualTime->notes_time = $request->notes[1];
                $leadActualTime->added_by = $name;
                $leadActualTime->shift = $shift;
                $leadActualTime->save();

                // To Make Hold If Status is Hold                
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $leadActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->size[0] == null) ? '' : $request->size[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = ($request->description[0] == null) ? '' : $request->description[0];
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Lead";
                    $hold->added_by = $name;
                    $hold->shift = $shift;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = ($request->jopOrderNumber[1] == null) ? '' : $request->jopOrderNumber[1];
                    $holdTime->drumNumber_time = ($request->outputDrum[1] == null) ? '' : $request->outputDrum[1];
                    $holdTime->cableSize_time = ($request->size[1] == null) ? '' : $request->size[1];
                    $holdTime->length_time = ($request->outputLength[1] == null) ? '' : $request->outputLength[1];
                    $holdTime->description_time = ($request->description[1] == null) ? '' : $request->description[1];
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
                $nameOfWhoMadeInsert = DB::table('leadactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('leadactuals')->find($request->id_update)->shift;

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

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                $rowDataLeadActual = DB::table('leadactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'inputDrum' => $request->inputDrum[0],
                        'inputCard' => $request->inputCard[0],
                        'inputLength' => $request->inputLength[0],
                        'outputDrum' => $request->outputDrum[0],
                        'outputCard' => $request->outputCard[0],
                        'outputLength' => $request->outputLength[0],
                        'thicknessStartMinActual' => $request->thicknessStartMinActual[0],
                        'thicknessStartNomActual' => $request->thicknessStartNomActual[0],
                        'thicknessStartMaxActual' => $request->thicknessStartMaxActual[0],
                        'thicknessEndMinActual' => $request->thicknessEndMinActual[0],
                        'thicknessEndNomActual' => $request->thicknessEndNomActual[0],
                        'thicknessEndMaxActual' => $request->thicknessEndMaxActual[0],
                        'dimBefore1' => $request->dimBefore1[0],
                        'dimBefore2' => $request->dimBefore2[0],
                        'dimAfterStart' => $request->dimAfterStart[0],
                        'dimAfterEnd' => $request->dimAfterEnd[0],
                        'weightActual' => $request->weightActual[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $rowDataLeadActualTime = DB::table('leadactualstimes')
                    ->where('leadactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'inputDrum_time' => $request->inputDrum[1],
                        'inputCard_time' => $request->inputCard[1],
                        'inputLength_time' => $request->inputLength[1],
                        'outputDrum_time' => $request->outputDrum[1],
                        'outputCard_time' => $request->outputCard[1],
                        'outputLength_time' => $request->outputLength[1],
                        'thicknessStartMinActual_time' => $request->thicknessStartMinActual[1],
                        'thicknessStartNomActual_time' => $request->thicknessStartNomActual[1],
                        'thicknessStartMaxActual_time' => $request->thicknessStartMaxActual[1],
                        'thicknessEndMinActual_time' => $request->thicknessEndMinActual[1],
                        'thicknessEndNomActual_time' => $request->thicknessEndNomActual[1],
                        'thicknessEndMaxActual_time' => $request->thicknessEndMaxActual[1],
                        'dimBefore1_time' => $request->dimBefore1[1],
                        'dimBefore2_time' => $request->dimBefore2[1],
                        'dimAfterStart_time' => $request->dimAfterStart[1],
                        'dimAfterEnd_time' => $request->dimAfterEnd[1],
                        'weightActual_time' => $request->weightActual[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'notes_time' => $request->notes[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Lead'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = $request->outputDrum[0];
                        $hold->cableSize = $request->size[0];
                        $hold->length = $request->outputLength[0];
                        $hold->description = $request->description[0];
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Lead";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeUpdate;
                        $hold->save();

                        // To Add New HoldTime
                        $holdTime = new HoldTime();
                        $holdTime->hold_id = $hold->id;
                        $holdTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                        $holdTime->drumNumber_time = $request->outputDrum[1];
                        $holdTime->cableSize_time = $request->size[1];
                        $holdTime->length_time = $request->outputLength[1];
                        $holdTime->description_time = $request->description[1];
                        $holdTime->machine_time = $request->machine[1];
                        $holdTime->reasonOfHold_time = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeUpdate;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Lead'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Lead'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->size[0],
                                'length' => $request->outputLength[0],
                                'description' => $request->description[0],
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Lead",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[1],
                                'drumNumber_time' => $request->outputDrum[1],
                                'cableSize_time' => $request->size[1],
                                'length_time' => $request->outputLength[1],
                                'description_time' => $request->description[1],
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

            $checkJopOrderNumber = DB::table('leadstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $leadStandard = DB::table('leadstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $leadStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $rowDataLeadActual = DB::table('leadactuals')->where('id', $request->id)->first();
            $rowDataLeadStandard = DB::table('leadstandards')->where('id', $rowDataLeadActual->jopOrderNumber_id)->first();
            $rowDataLeadActualTime = DB::table('leadactualstimes')->where('id', $request->id)->first();
            $rowDataLeadStandardTime = DB::table('leadstandardstimes')->where('id', $rowDataLeadActual->jopOrderNumber_id)->first();

            return array(
                $rowDataLeadStandard,
                $rowDataLeadActual,
                $rowDataLeadActualTime,
                $rowDataLeadStandardTime
            );
        }
    }
}
