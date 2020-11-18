<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Hold;
use App\HoldTime;
use App\CCVInsulationActual;
use App\CCVInsulationActualsTimes;
use App\CCVInsulationStandard;
use App\CCVInsulationStandardsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CCVInsulationController extends Controller
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

    public function insertCCVInsulation(Request $request)
    {
        // return $request;
        if ($request->ajax()) {
            $this->request = $request;
            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('ccvinsulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('admin')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New CCVInsulationStansard
                    $ccvinsulationStandard = new CCVInsulationStandard();
                    $ccvinsulationStandard->jopOrderNumber = $request->jopOrderNumber[0];
                    $ccvinsulationStandard->size = $request->size[0];
                    $ccvinsulationStandard->description = $request->description[0];
                    $ccvinsulationStandard->thicknessMinISC = $request->thicknessMinISC[0];
                    $ccvinsulationStandard->thicknessMinINS = $request->thicknessMinINS[0];
                    $ccvinsulationStandard->thicknessMinOSC = $request->thicknessMinOSC[0];
                    $ccvinsulationStandard->thicknessNomISC = $request->thicknessNomISC[0];
                    $ccvinsulationStandard->thicknessNomINS = $request->thicknessNomINS[0];
                    $ccvinsulationStandard->thicknessNomOSC = $request->thicknessNomOSC[0];
                    $ccvinsulationStandard->dimAfter = $request->dimAfter[0];
                    $ccvinsulationStandard->added_by = $name;
                    $ccvinsulationStandard->shift = $shift;
                    $ccvinsulationStandard->save();

                    $jopOrderNumber_id = DB::table('ccvinsulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                    //To Add New CCVInsulationStansardTimes
                    $ccvinsulationStandardTime = new CCVInsulationStandardsTimes();
                    $ccvinsulationStandardTime->ccvinsulationstandards_id = $jopOrderNumber_id;
                    $ccvinsulationStandardTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $ccvinsulationStandardTime->size_time = $request->size[1];
                    $ccvinsulationStandardTime->description_time = $request->description[1];
                    $ccvinsulationStandardTime->thicknessMinISC_time = $request->thicknessMinISC[1];
                    $ccvinsulationStandardTime->thicknessMinINS_time = $request->thicknessMinINS[1];
                    $ccvinsulationStandardTime->thicknessMinOSC_time = $request->thicknessMinOSC[1];
                    $ccvinsulationStandardTime->thicknessNomISC_time = $request->thicknessNomISC[1];
                    $ccvinsulationStandardTime->thicknessNomINS_time = $request->thicknessNomINS[1];
                    $ccvinsulationStandardTime->thicknessNomOSC_time = $request->thicknessNomOSC[1];
                    $ccvinsulationStandardTime->dimAfter_time = $request->dimAfter[1];
                    $ccvinsulationStandardTime->added_by = $name;
                    $ccvinsulationStandardTime->shift = $shift;
                    $ccvinsulationStandardTime->save();
                }

                $jopOrderNumber_id = DB::table('ccvinsulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                if (
                    (empty($request->thicknessISCStartMin[0]) || empty($request->thicknessISCStartNom[0]) || empty($request->thicknessISCStartMax[0])) &&
                    (!empty($request->thicknessISCStartMin[0]) || !empty($request->thicknessISCStartNom[0]) || !empty($request->thicknessISCStartMax[0]))
                ) {
                    return 'Error-thicknessISCStart';
                }

                if (
                    (empty($request->thicknessINSStartMin[0]) || empty($request->thicknessINSStartNom[0]) || empty($request->thicknessINSStartMax[0])) &&
                    (!empty($request->thicknessINSStartMin[0]) || !empty($request->thicknessINSStartNom[0]) || !empty($request->thicknessINSStartMax[0]))
                ) {
                    return 'Error-thicknessINSStart';
                }

                if (
                    (empty($request->thicknessOSCStartMin[0]) || empty($request->thicknessOSCStartNom[0]) || empty($request->thicknessOSCStartMax[0])) &&
                    (!empty($request->thicknessOSCStartMin[0]) || !empty($request->thicknessOSCStartNom[0]) || !empty($request->thicknessOSCStartMax[0]))
                ) {
                    return 'Error-thicknessOSCStart';
                }

                if (
                    (empty($request->thicknessISCEndMin[0]) || empty($request->thicknessISCEndNom[0]) || empty($request->thicknessISCEndMax[0])) &&
                    (!empty($request->thicknessISCEndMin[0]) || !empty($request->thicknessISCEndNom[0]) || !empty($request->thicknessISCEndMax[0]))
                ) {
                    return 'Error-thicknessISCEnd';
                }

                if (
                    (empty($request->thicknessINSEndMin[0]) || empty($request->thicknessINSEndNom[0]) || empty($request->thicknessINSEndMax[0])) &&
                    (!empty($request->thicknessINSEndMin[0]) || !empty($request->thicknessINSEndNom[0]) || !empty($request->thicknessINSEndMax[0]))
                ) {
                    return 'Error-thicknessINSEnd';
                }

                if (
                    (empty($request->thicknessOSCEndMin[0]) || empty($request->thicknessOSCEndNom[0]) || empty($request->thicknessOSCEndMax[0])) &&
                    (!empty($request->thicknessOSCEndMin[0]) || !empty($request->thicknessOSCEndNom[0]) || !empty($request->thicknessOSCEndMax[0]))
                ) {
                    return 'Error-thicknessOSCEnd';
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

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                //To Add New CCVInsulationActual
                $ccvinsulationActual = new CCVInsulationActual();
                $ccvinsulationActual->jopOrderNumber_id = $jopOrderNumber_id;
                $ccvinsulationActual->jopOrderNumber = $request->jopOrderNumber[0];
                $ccvinsulationActual->machine = $request->machine[0];
                $ccvinsulationActual->inputDrum = $request->inputDrum[0];
                $ccvinsulationActual->inputCard = $request->inputCard[0];
                $ccvinsulationActual->inputLength = $request->inputLength[0];
                $ccvinsulationActual->outputDrum = $request->outputDrum[0];
                $ccvinsulationActual->outputCard = $request->outputCard[0];
                $ccvinsulationActual->outputLength = $request->outputLength[0];
                $ccvinsulationActual->thicknessISCStartMin = $request->thicknessISCStartMin[0];
                $ccvinsulationActual->thicknessISCStartNom = $request->thicknessISCStartNom[0];
                $ccvinsulationActual->thicknessISCStartMax = $request->thicknessISCStartMax[0];
                $ccvinsulationActual->thicknessINSStartMin = $request->thicknessINSStartMin[0];
                $ccvinsulationActual->thicknessINSStartNom = $request->thicknessINSStartNom[0];
                $ccvinsulationActual->thicknessINSStartMax = $request->thicknessINSStartMax[0];
                $ccvinsulationActual->thicknessOSCStartMin = $request->thicknessOSCStartMin[0];
                $ccvinsulationActual->thicknessOSCStartNom = $request->thicknessOSCStartNom[0];
                $ccvinsulationActual->thicknessOSCStartMax = $request->thicknessOSCStartMax[0];
                $ccvinsulationActual->thicknessISCEndMin = $request->thicknessISCEndMin[0];
                $ccvinsulationActual->thicknessISCEndNom = $request->thicknessISCEndNom[0];
                $ccvinsulationActual->thicknessISCEndMax = $request->thicknessISCEndMax[0];
                $ccvinsulationActual->thicknessINSEndMin = $request->thicknessINSEndMin[0];
                $ccvinsulationActual->thicknessINSEndNom = $request->thicknessINSEndNom[0];
                $ccvinsulationActual->thicknessINSEndMax = $request->thicknessINSEndMax[0];
                $ccvinsulationActual->thicknessOSCEndMin = $request->thicknessOSCEndMin[0];
                $ccvinsulationActual->thicknessOSCEndNom = $request->thicknessOSCEndNom[0];
                $ccvinsulationActual->thicknessOSCEndMax = $request->thicknessOSCEndMax[0];
                $ccvinsulationActual->dimBefore1 = $request->dimBefore1[0];
                $ccvinsulationActual->dimBefore2 = $request->dimBefore2[0];
                $ccvinsulationActual->dimAfterStartMin = $request->dimAfterStartMin[0];
                $ccvinsulationActual->dimAfterStartNom = $request->dimAfterStartNom[0];
                $ccvinsulationActual->dimAfterStartMax = $request->dimAfterStartMax[0];
                $ccvinsulationActual->dimAfterEndMin = $request->dimAfterEndMin[0];
                $ccvinsulationActual->dimAfterEndNom = $request->dimAfterEndNom[0];
                $ccvinsulationActual->dimAfterEndMax = $request->dimAfterEndMax[0];
                $ccvinsulationActual->status = $request->status[0];
                $ccvinsulationActual->productionOperator = $request->productionOperator[0];
                $ccvinsulationActual->notes = $request->notes[0];
                $ccvinsulationActual->added_by = $name;
                $ccvinsulationActual->shift = $shift;
                $ccvinsulationActual->save();

                //To  Add New CCVInsulationActualTimes
                $ccvinsulationActualTime = new CCVInsulationActualsTimes();
                $ccvinsulationActualTime->ccvinsulationactuals_id = $ccvinsulationActual->id;
                $ccvinsulationActualTime->jopOrderNumber = $request->jopOrderNumber[0];
                $ccvinsulationActualTime->machine_time = $request->machine[1];
                $ccvinsulationActualTime->inputDrum_time = $request->inputDrum[1];
                $ccvinsulationActualTime->inputCard_time = $request->inputCard[1];
                $ccvinsulationActualTime->inputLength_time = $request->inputLength[1];
                $ccvinsulationActualTime->outputDrum_time = $request->outputDrum[1];
                $ccvinsulationActualTime->outputCard_time = $request->outputCard[1];
                $ccvinsulationActualTime->outputLength_time = $request->outputLength[1];
                $ccvinsulationActualTime->thicknessISCStartMin_time = $request->thicknessISCStartMin[1];
                $ccvinsulationActualTime->thicknessISCStartNom_time = $request->thicknessISCStartNom[1];
                $ccvinsulationActualTime->thicknessISCStartMax_time = $request->thicknessISCStartMax[1];
                $ccvinsulationActualTime->thicknessINSStartMin_time = $request->thicknessINSStartMin[1];
                $ccvinsulationActualTime->thicknessINSStartNom_time = $request->thicknessINSStartNom[1];
                $ccvinsulationActualTime->thicknessINSStartMax_time = $request->thicknessINSStartMax[1];
                $ccvinsulationActualTime->thicknessOSCStartMin_time = $request->thicknessOSCStartMin[1];
                $ccvinsulationActualTime->thicknessOSCStartNom_time = $request->thicknessOSCStartNom[1];
                $ccvinsulationActualTime->thicknessOSCStartMax_time = $request->thicknessOSCStartMax[1];
                $ccvinsulationActualTime->thicknessISCEndMin_time = $request->thicknessISCEndMin[1];
                $ccvinsulationActualTime->thicknessISCEndNom_time = $request->thicknessISCEndNom[1];
                $ccvinsulationActualTime->thicknessISCEndMax_time = $request->thicknessISCEndMax[1];
                $ccvinsulationActualTime->thicknessINSEndMin_time = $request->thicknessINSEndMin[1];
                $ccvinsulationActualTime->thicknessINSEndNom_time = $request->thicknessINSEndNom[1];
                $ccvinsulationActualTime->thicknessINSEndMax_time = $request->thicknessINSEndMax[1];
                $ccvinsulationActualTime->thicknessOSCEndMin_time = $request->thicknessOSCEndMin[1];
                $ccvinsulationActualTime->thicknessOSCEndNom_time = $request->thicknessOSCEndNom[1];
                $ccvinsulationActualTime->thicknessOSCEndMax_time = $request->thicknessOSCEndMax[1];
                $ccvinsulationActualTime->dimBefore1_time = $request->dimBefore1[1];
                $ccvinsulationActualTime->dimBefore2_time = $request->dimBefore2[1];
                $ccvinsulationActualTime->dimAfterStartMin_time = $request->dimAfterStartMin[1];
                $ccvinsulationActualTime->dimAfterStartNom_time = $request->dimAfterStartNom[1];
                $ccvinsulationActualTime->dimAfterStartMax_time = $request->dimAfterStartMax[1];
                $ccvinsulationActualTime->dimAfterEndMin_time = $request->dimAfterEndMin[1];
                $ccvinsulationActualTime->dimAfterEndNom_time = $request->dimAfterEndNom[1];
                $ccvinsulationActualTime->dimAfterEndMax_time = $request->dimAfterEndMax[1];
                $ccvinsulationActualTime->status_time = $request->status[1];
                $ccvinsulationActualTime->productionOperator_time = $request->productionOperator[1];
                $ccvinsulationActualTime->notes_time = $request->notes[1];
                $ccvinsulationActualTime->added_by = $name;
                $ccvinsulationActualTime->shift = $shift;
                $ccvinsulationActualTime->save();

                // To Make Hold If Status is Hold                
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $ccvinsulationActual->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = ($request->outputDrum[0] == null) ? '' : $request->outputDrum[0];
                    $hold->cableSize = ($request->size[0] == null) ? '' : $request->size[0];
                    $hold->length = ($request->outputLength[0] == null) ? '' : $request->outputLength[0];
                    $hold->description = ($request->description[0] == null) ? '' : $request->description[0];
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "CCVInsulation";
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
                $nameOfWhoMadeInsert = DB::table('ccvinsulationactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('ccvinsulationactuals')->find($request->id_update)->shift;

                if (
                    (empty($request->thicknessISCStartMin[0]) || empty($request->thicknessISCStartNom[0]) || empty($request->thicknessISCStartMax[0])) &&
                    (!empty($request->thicknessISCStartMin[0]) || !empty($request->thicknessISCStartNom[0]) || !empty($request->thicknessISCStartMax[0]))
                ) {
                    return 'Error-thicknessISCStart';
                }

                if (
                    (empty($request->thicknessINSStartMin[0]) || empty($request->thicknessINSStartNom[0]) || empty($request->thicknessINSStartMax[0])) &&
                    (!empty($request->thicknessINSStartMin[0]) || !empty($request->thicknessINSStartNom[0]) || !empty($request->thicknessINSStartMax[0]))
                ) {
                    return 'Error-thicknessINSStart';
                }

                if (
                    (empty($request->thicknessOSCStartMin[0]) || empty($request->thicknessOSCStartNom[0]) || empty($request->thicknessOSCStartMax[0])) &&
                    (!empty($request->thicknessOSCStartMin[0]) || !empty($request->thicknessOSCStartNom[0]) || !empty($request->thicknessOSCStartMax[0]))
                ) {
                    return 'Error-thicknessOSCStart';
                }

                if (
                    (empty($request->thicknessISCEndMin[0]) || empty($request->thicknessISCEndNom[0]) || empty($request->thicknessISCEndMax[0])) &&
                    (!empty($request->thicknessISCEndMin[0]) || !empty($request->thicknessISCEndNom[0]) || !empty($request->thicknessISCEndMax[0]))
                ) {
                    return 'Error-thicknessISCEnd';
                }

                if (
                    (empty($request->thicknessINSEndMin[0]) || empty($request->thicknessINSEndNom[0]) || empty($request->thicknessINSEndMax[0])) &&
                    (!empty($request->thicknessINSEndMin[0]) || !empty($request->thicknessINSEndNom[0]) || !empty($request->thicknessINSEndMax[0]))
                ) {
                    return 'Error-thicknessINSEnd';
                }

                if (
                    (empty($request->thicknessOSCEndMin[0]) || empty($request->thicknessOSCEndNom[0]) || empty($request->thicknessOSCEndMax[0])) &&
                    (!empty($request->thicknessOSCEndMin[0]) || !empty($request->thicknessOSCEndNom[0]) || !empty($request->thicknessOSCEndMax[0]))
                ) {
                    return 'Error-thicknessOSCEnd';
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

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                $rowDataCCVInsulationActual = DB::table('ccvinsulationactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'inputDrum' => $request->inputDrum[0],
                        'inputCard' => $request->inputCard[0],
                        'inputLength' => $request->inputLength[0],
                        'outputDrum' => $request->outputDrum[0],
                        'outputCard' => $request->outputCard[0],
                        'outputLength' => $request->outputLength[0],
                        'thicknessISCStartMin' => $request->thicknessISCStartMin[0],
                        'thicknessISCStartNom' => $request->thicknessISCStartNom[0],
                        'thicknessISCStartMax' => $request->thicknessISCStartMax[0],
                        'thicknessINSStartMin' => $request->thicknessINSStartMin[0],
                        'thicknessINSStartNom' => $request->thicknessINSStartNom[0],
                        'thicknessINSStartMax' => $request->thicknessINSStartMax[0],
                        'thicknessOSCStartMin' => $request->thicknessOSCStartMin[0],
                        'thicknessOSCStartNom' => $request->thicknessOSCStartNom[0],
                        'thicknessOSCStartMax' => $request->thicknessOSCStartMax[0],
                        'thicknessISCEndMin' => $request->thicknessISCEndMin[0],
                        'thicknessISCEndNom' => $request->thicknessISCEndNom[0],
                        'thicknessISCEndMax' => $request->thicknessISCEndMax[0],
                        'thicknessINSEndMin' => $request->thicknessINSEndMin[0],
                        'thicknessINSEndNom' => $request->thicknessINSEndNom[0],
                        'thicknessINSEndMax' => $request->thicknessINSEndMax[0],
                        'thicknessOSCEndMin' => $request->thicknessOSCEndMin[0],
                        'thicknessOSCEndNom' => $request->thicknessOSCEndNom[0],
                        'thicknessOSCEndMax' => $request->thicknessOSCEndMax[0],
                        'dimBefore1' => $request->dimBefore1[0],
                        'dimBefore2' => $request->dimBefore2[0],
                        'dimAfterStartMin' => $request->dimAfterStartMin[0],
                        'dimAfterStartNom' => $request->dimAfterStartNom[0],
                        'dimAfterStartMax' => $request->dimAfterStartMax[0],
                        'dimAfterEndMin' => $request->dimAfterEndMin[0],
                        'dimAfterEndNom' => $request->dimAfterEndNom[0],
                        'dimAfterEndMax' => $request->dimAfterEndMax[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate,
                    ]);

                $rowDataCCVInsulationActualTime = DB::table('ccvinsulationactualstimes')
                    ->where('ccvinsulationactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'inputDrum_time' => $request->inputDrum[1],
                        'inputCard_time' => $request->inputCard[1],
                        'inputLength_time' => $request->inputLength[1],
                        'outputDrum_time' => $request->outputDrum[1],
                        'outputCard_time' => $request->outputCard[1],
                        'outputLength_time' => $request->outputLength[1],
                        'thicknessISCStartMin_time' => $request->thicknessISCStartMin[1],
                        'thicknessISCStartNom_time' => $request->thicknessISCStartNom[1],
                        'thicknessISCStartMax_time' => $request->thicknessISCStartMax[1],
                        'thicknessINSStartMin_time' => $request->thicknessINSStartMin[1],
                        'thicknessINSStartNom_time' => $request->thicknessINSStartNom[1],
                        'thicknessINSStartMax_time' => $request->thicknessINSStartMax[1],
                        'thicknessOSCStartMin_time' => $request->thicknessOSCStartMin[1],
                        'thicknessOSCStartNom_time' => $request->thicknessOSCStartNom[1],
                        'thicknessOSCStartMax_time' => $request->thicknessOSCStartMax[1],
                        'thicknessISCEndMin_time' => $request->thicknessISCEndMin[1],
                        'thicknessISCEndNom_time' => $request->thicknessISCEndNom[1],
                        'thicknessISCEndMax_time' => $request->thicknessISCEndMax[1],
                        'thicknessINSEndMin_time' => $request->thicknessINSEndMin[1],
                        'thicknessINSEndNom_time' => $request->thicknessINSEndNom[1],
                        'thicknessINSEndMax_time' => $request->thicknessINSEndMax[1],
                        'thicknessOSCEndMin_time' => $request->thicknessOSCEndMin[1],
                        'thicknessOSCEndNom_time' => $request->thicknessOSCEndNom[1],
                        'thicknessOSCEndMax_time' => $request->thicknessOSCEndMax[1],
                        'dimBefore1_time' => $request->dimBefore1[1],
                        'dimBefore2_time' => $request->dimBefore2[1],
                        'dimAfterStartMin_time' => $request->dimAfterStartMin[1],
                        'dimAfterStartNom_time' => $request->dimAfterStartNom[1],
                        'dimAfterStartMax_time' => $request->dimAfterStartMax[1],
                        'dimAfterEndMin_time' => $request->dimAfterEndMin[1],
                        'dimAfterEndNom_time' => $request->dimAfterEndNom[1],
                        'dimAfterEndMax_time' => $request->dimAfterEndMax[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'notes_time' => $request->notes[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);


                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'CCVInsulation'], ['sheet_id', $request->id_update]])->exists();
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
                        $hold->fromSheet = "CCVInsulation";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeInsert;
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
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'CCVInsulation'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'CCVInsulation'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => $request->outputDrum[0],
                                'cableSize' => $request->size[0],
                                'length' => $request->outputLength[0],
                                'description' => $request->description[0],
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "CCVInsulation",
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

            $checkJopOrderNumber = DB::table('ccvinsulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $ccvinsulationStandard = DB::table('ccvinsulationstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                return (array) $ccvinsulationStandard;
            } else {
                return $request->jopOrderNumber;
            }
        }
    }

    public function getRow(Request $request)
    {
        if ($request->ajax()) {
            // return $request;

            $alertIsExist = DB::table('ccvinsulationactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataCCVInsulationActual = DB::table('ccvinsulationactuals')->where('id', $request->id)->first();
            $rowDataCCVInsulationStandard = DB::table('ccvinsulationstandards')->where('id', $rowDataCCVInsulationActual->jopOrderNumber_id)->first();
            $rowDataCCVInsulationActualTime = DB::table('ccvinsulationactualstimes')->where('id', $request->id)->first();
            $rowDataCCVInsulationStandardTime = DB::table('ccvinsulationstandardstimes')->where('id', $rowDataCCVInsulationActual->jopOrderNumber_id)->first();

            return array(
                $rowDataCCVInsulationStandard,
                $rowDataCCVInsulationActual,
                $rowDataCCVInsulationActualTime,
                $rowDataCCVInsulationStandardTime
            );
        }
    }
}
