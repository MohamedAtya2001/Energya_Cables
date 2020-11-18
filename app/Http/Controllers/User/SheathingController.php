<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\Events\WatchingEmployee;
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

    public function insertSheathing(Request $request)
    {
        if ($request->ajax()) {
            $this->request = $request;
            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }

            if ($request->update == "false") {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;

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
                        "sheathing_id" => $sheathingActual->id,
                        "chain" => serialize($chain)
                    ]);
                }

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

                //To save change That Happend in Sheathing Table
                $sheathings = DB::table('sheathings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'cableDescription' => '',
                    'volt' => '',
                    'thicknessMinStandard' => '',
                    'thicknessNomStandard' => '',
                    'thicknessMaxStandard' => '',
                    'eccentricityStandard' => '',
                    'outerDim' => '',
                    'ovalityStandard' => '',
                    'materialStandard' => '',
                    'colorStandard' => '',
                    'sparkStandard' => '',
                    'weightStandard' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'apperanceOfDrum' => '',
                    'colorActual' => '',
                    'message' => '',
                    'thicknessStartMinActual' => '',
                    'thicknessStartNomActual' => '',
                    'thicknessStartMaxActual' => '',
                    'thicknessEndMinActual' => '',
                    'thicknessEndNomActual' => '',
                    'thicknessEndMaxActual' => '',
                    'eccentricityActual' => '',
                    'dimBefore1' => '',
                    'dimBefore2' => '',
                    'dimAfterStartMin' => '',
                    'dimAfterStartNom' => '',
                    'dimAfterStartMax' => '',
                    'dimAfterEndMin' => '',
                    'dimAfterEndNom' => '',
                    'dimAfterEndMax' => '',
                    'weightActual' => '',
                    'materialActual' => '',
                    'ovalityActual1' => '',
                    'ovalityActual2' => '',
                    'meterMeasuring' => '',
                    'sparkActual' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'volt',
                    'thicknessMinStandard',
                    'thicknessNomStandard',
                    'thicknessMaxStandard',
                    'eccentricityStandard',
                    'outerDim',
                    'ovalityStandard',
                    'materialStandard',
                    'colorStandard',
                    'sparkStandard',
                    'weightStandard',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'apperanceOfDrum',
                    'colorActual',
                    'message',
                    'thicknessStartMinActual',
                    'thicknessStartNomActual',
                    'thicknessStartMaxActual',
                    'thicknessEndMinActual',
                    'thicknessEndNomActual',
                    'thicknessEndMaxActual',
                    'eccentricityActual',
                    'dimBefore1',
                    'dimBefore2',
                    'dimAfterStartMin',
                    'dimAfterStartNom',
                    'dimAfterStartMax',
                    'dimAfterEndMin',
                    'dimAfterEndNom',
                    'dimAfterEndMax',
                    'weightActual',
                    'materialActual',
                    'ovalityActual1',
                    'ovalityActual2',
                    'meterMeasuring',
                    'sparkActual',
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
                event(new WatchingEmployee('sheathing', $request->data_form_item, $attributes, $values));
            } else {

                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

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

                $checkTraceability = DB::table("traceability")->where('sheathing_id', $request->id_update)->exists();

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
                        "sheathing_id" => $request->id_update,
                        "chain" => serialize($chain)
                    ]);
                }

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

                //To save change That Happend in Sheathing Table
                $sheathings = DB::table('sheathings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $nameOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'cableSize' => '',
                    'cableDescription' => '',
                    'volt' => '',
                    'thicknessMinStandard' => '',
                    'thicknessNomStandard' => '',
                    'thicknessMaxStandard' => '',
                    'eccentricityStandard' => '',
                    'outerDim' => '',
                    'ovalityStandard' => '',
                    'materialStandard' => '',
                    'colorStandard' => '',
                    'sparkStandard' => '',
                    'weightStandard' => '',
                    'machine' => '',
                    'inputDrum' => '',
                    'inputCard' => '',
                    'inputLength' => '',
                    'outputDrum' => '',
                    'outputCard' => '',
                    'outputLength' => '',
                    'apperanceOfDrum' => '',
                    'colorActual' => '',
                    'message' => '',
                    'thicknessStartMinActual' => '',
                    'thicknessStartNomActual' => '',
                    'thicknessStartMaxActual' => '',
                    'thicknessEndMinActual' => '',
                    'thicknessEndNomActual' => '',
                    'thicknessEndMaxActual' => '',
                    'eccentricityActual' => '',
                    'dimBefore1' => '',
                    'dimBefore2' => '',
                    'dimAfterStartMin' => '',
                    'dimAfterStartNom' => '',
                    'dimAfterStartMax' => '',
                    'dimAfterEndMin' => '',
                    'dimAfterEndNom' => '',
                    'dimAfterEndMax' => '',
                    'weightActual' => '',
                    'materialActual' => '',
                    'ovalityActual1' => '',
                    'ovalityActual2' => '',
                    'meterMeasuring' => '',
                    'sparkActual' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'volt',
                    'thicknessMinStandard',
                    'thicknessNomStandard',
                    'thicknessMaxStandard',
                    'eccentricityStandard',
                    'outerDim',
                    'ovalityStandard',
                    'materialStandard',
                    'colorStandard',
                    'sparkStandard',
                    'weightStandard',
                    'machine',
                    'inputDrum',
                    'inputCard',
                    'inputLength',
                    'outputDrum',
                    'outputCard',
                    'outputLength',
                    'apperanceOfDrum',
                    'colorActual',
                    'message',
                    'thicknessStartMinActual',
                    'thicknessStartNomActual',
                    'thicknessStartMaxActual',
                    'thicknessEndMinActual',
                    'thicknessEndNomActual',
                    'thicknessEndMaxActual',
                    'eccentricityActual',
                    'dimBefore1',
                    'dimBefore2',
                    'dimAfterStartMin',
                    'dimAfterStartNom',
                    'dimAfterStartMax',
                    'dimAfterEndMin',
                    'dimAfterEndNom',
                    'dimAfterEndMax',
                    'weightActual',
                    'materialActual',
                    'ovalityActual1',
                    'ovalityActual2',
                    'meterMeasuring',
                    'sparkActual',
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
                event(new WatchingEmployee('sheathing', $request->data_form_item, $attributes, $values));

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

            $checkJopOrderNumber = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $sheathingStandard = DB::table('sheathingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();

                //To save change That Happend in Sheathing Table
                $sheathings = DB::table('sheathings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $sheathingStandard->jopOrderNumber,
                    'cableSize' => $sheathingStandard->cableSize,
                    'cableDescription' => $sheathingStandard->cableDescription,
                    'volt' => $sheathingStandard->volt,
                    'thicknessMinStandard' => $sheathingStandard->thicknessMinStandard,
                    'thicknessNomStandard' => $sheathingStandard->thicknessNomStandard,
                    'thicknessMaxStandard' => $sheathingStandard->thicknessMaxStandard,
                    'eccentricityStandard' => $sheathingStandard->eccentricityStandard,
                    'outerDim' => $sheathingStandard->outerDim,
                    'ovalityStandard' => $sheathingStandard->ovalityStandard,
                    'materialStandard' => $sheathingStandard->materialStandard,
                    'colorStandard' => $sheathingStandard->colorStandard,
                    'sparkStandard' => $sheathingStandard->sparkStandard,
                    'weightStandard' => $sheathingStandard->weightStandard,
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'volt',
                    'thicknessMinStandard',
                    'thicknessNomStandard',
                    'thicknessMaxStandard',
                    'eccentricityStandard',
                    'outerDim',
                    'ovalityStandard',
                    'materialStandard',
                    'colorStandard',
                    'sparkStandard',
                    'weightStandard'
                );
                $values = array(
                    $sheathingStandard->jopOrderNumber,
                    $sheathingStandard->cableSize,
                    $sheathingStandard->cableDescription,
                    $sheathingStandard->volt,
                    $sheathingStandard->thicknessMinStandard,
                    $sheathingStandard->thicknessNomStandard,
                    $sheathingStandard->thicknessMaxStandard,
                    $sheathingStandard->eccentricityStandard,
                    $sheathingStandard->outerDim,
                    $sheathingStandard->ovalityStandard,
                    $sheathingStandard->materialStandard,
                    $sheathingStandard->colorStandard,
                    $sheathingStandard->sparkStandard,
                    $sheathingStandard->weightStandard
                );
                event(new WatchingEmployee('sheathing', $request->data_form_item, $attributes, $values));

                return (array) $sheathingStandard;
            } else {
                //To save change That Happend in Sheathing Table
                $sheathings = DB::table('sheathings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'cableSize' => '',
                    'cableDescription' => '',
                    'volt' => '',
                    'thicknessMinStandard' => '',
                    'thicknessNomStandard' => '',
                    'thicknessMaxStandard' => '',
                    'eccentricityStandard' => '',
                    'outerDim' => '',
                    'ovalityStandard' => '',
                    'materialStandard' => '',
                    'colorStandard' => '',
                    'sparkStandard' => '',
                    'weightStandard' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'cableSize',
                    'cableDescription',
                    'volt',
                    'thicknessMinStandard',
                    'thicknessNomStandard',
                    'thicknessMaxStandard',
                    'eccentricityStandard',
                    'outerDim',
                    'ovalityStandard',
                    'materialStandard',
                    'colorStandard',
                    'sparkStandard',
                    'weightStandard'
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
                    '',
                    ''
                );
                event(new WatchingEmployee('sheathing', $request->data_form_item, $attributes, $values));

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

            // return $request;

            $alertIsExist = DB::table('sheathingactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataSheathingActual = DB::table('sheathingactuals')->where('id', $request->id)->first();
            $rowDataSheathingStandard = DB::table('sheathingstandards')->where('id', $rowDataSheathingActual->jopOrderNumber_id)->first();
            $rowDataSheathingActualTime = DB::table('sheathingactualstimes')->where('id', $request->id)->first();
            $rowDataSheathingStandardTime = DB::table('sheathingstandardstimes')->where('id', $rowDataSheathingActual->jopOrderNumber_id)->first();

            //To save change That Happend in Sheathing Table
            $sheathings = DB::table('sheathings')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataSheathingStandard->jopOrderNumber == null) ? '' : $rowDataSheathingStandard->jopOrderNumber,
                'cableSize' => ($rowDataSheathingStandard->cableSize == null) ? '' : $rowDataSheathingStandard->cableSize,
                'cableDescription' => ($rowDataSheathingStandard->cableDescription == null) ? '' : $rowDataSheathingStandard->cableDescription,
                'volt' => ($rowDataSheathingStandard->volt == null) ? '' : $rowDataSheathingStandard->volt,
                'thicknessMinStandard' => ($rowDataSheathingStandard->thicknessMinStandard == null) ? '' : $rowDataSheathingStandard->thicknessMinStandard,
                'thicknessNomStandard' => ($rowDataSheathingStandard->thicknessNomStandard == null) ? '' : $rowDataSheathingStandard->thicknessNomStandard,
                'thicknessMaxStandard' => ($rowDataSheathingStandard->thicknessMaxStandard == null) ? '' : $rowDataSheathingStandard->thicknessMaxStandard,
                'eccentricityStandard' => ($rowDataSheathingStandard->eccentricityStandard == null) ? '' : $rowDataSheathingStandard->eccentricityStandard,
                'outerDim' => ($rowDataSheathingStandard->outerDim == null) ? '' : $rowDataSheathingStandard->outerDim,
                'ovalityStandard' => ($rowDataSheathingStandard->ovalityStandard == null) ? '' : $rowDataSheathingStandard->ovalityStandard,
                'materialStandard' => ($rowDataSheathingStandard->materialStandard == null) ? '' : $rowDataSheathingStandard->materialStandard,
                'colorStandard' => ($rowDataSheathingStandard->colorStandard == null) ? '' : $rowDataSheathingStandard->colorStandard,
                'sparkStandard' => ($rowDataSheathingStandard->sparkStandard == null) ? '' : $rowDataSheathingStandard->sparkStandard,
                'weightStandard' => ($rowDataSheathingStandard->weightStandard == null) ? '' : $rowDataSheathingStandard->weightStandard,
                'machine' => ($rowDataSheathingActual->machine == null) ? '' : $rowDataSheathingActual->machine,
                'inputDrum' => ($rowDataSheathingActual->inputDrum == null) ? '' : $rowDataSheathingActual->inputDrum,
                'inputCard' => ($rowDataSheathingActual->inputCard == null) ? '' : $rowDataSheathingActual->inputCard,
                'inputLength' => ($rowDataSheathingActual->inputLength == null) ? '' : $rowDataSheathingActual->inputLength,
                'outputDrum' => ($rowDataSheathingActual->outputDrum == null) ? '' : $rowDataSheathingActual->outputDrum,
                'outputCard' => ($rowDataSheathingActual->outputCard == null) ? '' : $rowDataSheathingActual->outputCard,
                'outputLength' => ($rowDataSheathingActual->outputLength == null) ? '' : $rowDataSheathingActual->outputLength,
                'apperanceOfDrum' => ($rowDataSheathingActual->apperanceOfDrum == null) ? '' : $rowDataSheathingActual->apperanceOfDrum,
                'colorActual' => ($rowDataSheathingActual->colorActual == null) ? '' : $rowDataSheathingActual->colorActual,
                'message' => ($rowDataSheathingActual->message == null) ? '' : $rowDataSheathingActual->message,
                'thicknessStartMinActual' => ($rowDataSheathingActual->thicknessStartMinActual == null) ? '' : $rowDataSheathingActual->thicknessStartMinActual,
                'thicknessStartNomActual' => ($rowDataSheathingActual->thicknessStartNomActual == null) ? '' : $rowDataSheathingActual->thicknessStartNomActual,
                'thicknessStartMaxActual' => ($rowDataSheathingActual->thicknessStartMaxActual == null) ? '' : $rowDataSheathingActual->thicknessStartMaxActual,
                'thicknessEndMinActual' => ($rowDataSheathingActual->thicknessEndMinActual == null) ? '' : $rowDataSheathingActual->thicknessEndMinActual,
                'thicknessEndNomActual' => ($rowDataSheathingActual->thicknessEndNomActual == null) ? '' : $rowDataSheathingActual->thicknessEndNomActual,
                'thicknessEndMaxActual' => ($rowDataSheathingActual->thicknessEndMaxActual == null) ? '' : $rowDataSheathingActual->thicknessEndMaxActual,
                'eccentricityActual' => ($rowDataSheathingActual->eccentricityActual == null) ? '' : $rowDataSheathingActual->eccentricityActual,
                'dimBefore2' => ($rowDataSheathingActual->dimBefore2 == null) ? '' : $rowDataSheathingActual->dimBefore2,
                'dimBefore2' => ($rowDataSheathingActual->dimBefore2 == null) ? '' : $rowDataSheathingActual->dimBefore2,
                'dimAfterStartMin' => ($rowDataSheathingActual->dimAfterStartMin == null) ? '' : $rowDataSheathingActual->dimAfterStartMin,
                'dimAfterStartNom' => ($rowDataSheathingActual->dimAfterStartNom == null) ? '' : $rowDataSheathingActual->dimAfterStartNom,
                'dimAfterStartMax' => ($rowDataSheathingActual->dimAfterStartMax == null) ? '' : $rowDataSheathingActual->dimAfterStartMax,
                'dimAfterEndMin' => ($rowDataSheathingActual->dimAfterEndMin == null) ? '' : $rowDataSheathingActual->dimAfterEndMin,
                'dimAfterEndNom' => ($rowDataSheathingActual->dimAfterEndNom == null) ? '' : $rowDataSheathingActual->dimAfterEndNom,
                'dimAfterEndMax' => ($rowDataSheathingActual->dimAfterEndMax == null) ? '' : $rowDataSheathingActual->dimAfterEndMax,
                'weightActual' => ($rowDataSheathingActual->weightActual == null) ? '' : $rowDataSheathingActual->weightActual,
                'materialActual' => ($rowDataSheathingActual->materialActual == null) ? '' : $rowDataSheathingActual->materialActual,
                'ovalityActual1' => ($rowDataSheathingActual->ovalityActual1 == null) ? '' : $rowDataSheathingActual->ovalityActual1,
                'ovalityActual2' => ($rowDataSheathingActual->ovalityActual2 == null) ? '' : $rowDataSheathingActual->ovalityActual2,
                'meterMeasuring' => ($rowDataSheathingActual->meterMeasuring == null) ? '' : $rowDataSheathingActual->meterMeasuring,
                'sparkActual' => ($rowDataSheathingActual->sparkActual == null) ? '' : $rowDataSheathingActual->sparkActual,
                'status' => ($rowDataSheathingActual->status == null) ? '' : $rowDataSheathingActual->status,
                'productionOperator' => ($rowDataSheathingActual->productionOperator == null) ? '' : $rowDataSheathingActual->productionOperator,
                'notes' => ($rowDataSheathingActual->notes == null) ? '' : $rowDataSheathingActual->notes
            ]);

            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'cableSize',
                'cableDescription',
                'volt',
                'thicknessMinStandard',
                'thicknessNomStandard',
                'thicknessMaxStandard',
                'eccentricityStandard',
                'outerDim',
                'ovalityStandard',
                'materialStandard',
                'colorStandard',
                'sparkStandard',
                'weightStandard',
                'machine',
                'inputDrum',
                'inputCard',
                'inputLength',
                'outputDrum',
                'outputCard',
                'outputLength',
                'apperanceOfDrum',
                'colorActual',
                'message',
                'thicknessStartMinActual',
                'thicknessStartNomActual',
                'thicknessStartMaxActual',
                'thicknessEndMinActual',
                'thicknessEndNomActual',
                'thicknessEndMaxActual',
                'eccentricityActual',
                'dimBefore2',
                'dimBefore2',
                'dimAfterStartMin',
                'dimAfterStartNom',
                'dimAfterStartMax',
                'dimAfterEndMin',
                'dimAfterEndNom',
                'dimAfterEndMax',
                'weightActual',
                'materialActual',
                'ovalityActual1',
                'ovalityActual2',
                'meterMeasuring',
                'sparkActual',
                'status',
                'productionOperator',
                'notes'
            );
            $values = array(
                $rowDataSheathingStandard->jopOrderNumber,
                $rowDataSheathingStandard->cableSize,
                $rowDataSheathingStandard->cableDescription,
                $rowDataSheathingStandard->volt,
                $rowDataSheathingStandard->thicknessMinStandard,
                $rowDataSheathingStandard->thicknessNomStandard,
                $rowDataSheathingStandard->thicknessMaxStandard,
                $rowDataSheathingStandard->eccentricityStandard,
                $rowDataSheathingStandard->outerDim,
                $rowDataSheathingStandard->ovalityStandard,
                $rowDataSheathingStandard->materialStandard,
                $rowDataSheathingStandard->colorStandard,
                $rowDataSheathingStandard->sparkStandard,
                $rowDataSheathingStandard->weightStandard,
                $rowDataSheathingActual->machine,
                $rowDataSheathingActual->inputDrum,
                $rowDataSheathingActual->inputCard,
                $rowDataSheathingActual->inputLength,
                $rowDataSheathingActual->outputDrum,
                $rowDataSheathingActual->outputCard,
                $rowDataSheathingActual->outputLength,
                $rowDataSheathingActual->apperanceOfDrum,
                $rowDataSheathingActual->colorActual,
                $rowDataSheathingActual->message,
                $rowDataSheathingActual->thicknessStartMinActual,
                $rowDataSheathingActual->thicknessStartNomActual,
                $rowDataSheathingActual->thicknessStartMaxActual,
                $rowDataSheathingActual->thicknessEndMinActual,
                $rowDataSheathingActual->thicknessEndNomActual,
                $rowDataSheathingActual->thicknessEndMaxActual,
                $rowDataSheathingActual->eccentricityActual,
                $rowDataSheathingActual->dimBefore1,
                $rowDataSheathingActual->dimBefore2,
                $rowDataSheathingActual->dimAfterStartMin,
                $rowDataSheathingActual->dimAfterStartNom,
                $rowDataSheathingActual->dimAfterStartMax,
                $rowDataSheathingActual->dimAfterEndMin,
                $rowDataSheathingActual->dimAfterEndNom,
                $rowDataSheathingActual->dimAfterEndMax,
                $rowDataSheathingActual->weightActual,
                $rowDataSheathingActual->materialActual,
                $rowDataSheathingActual->ovalityActual1,
                $rowDataSheathingActual->ovalityActual2,
                $rowDataSheathingActual->meterMeasuring,
                $rowDataSheathingActual->sparkActual,
                $rowDataSheathingActual->status,
                $rowDataSheathingActual->productionOperator,
                $rowDataSheathingActual->notes
            );
            event(new WatchingEmployee('sheathing', $request->data_form_item, $attributes, $values));

            return array(
                $rowDataSheathingStandard,
                $rowDataSheathingActual,
                $rowDataSheathingActualTime,
                $rowDataSheathingStandardTime
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

            $rowUpdateData = DB::table('sheathings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('sheathing', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if (false) {


                $dataRow = DB::table('sheathings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();



                //To Get Min, Nom And Max from thicknessStandard
                $arrayOfThicknessStandard = array();
                $statment = $request->input['thicknessStandard'];
                $counter = 0;
                $part = "";
                for ($i = 0; $i < strlen($statment); $i++) {
                    if ($statment[$i] == '/') {
                        $arrayOfThicknessStandard[$counter] = $part;
                        $counter++;
                        $part = "";
                    } else {
                        $part = $part . $statment[$i];
                        if ($i == strlen($statment) - 1) {
                            $arrayOfThicknessStandard[$counter] = $part;
                        }
                    }
                }

                //For check is employee Enter the ThicknessStandard correct or not
                for ($i = 0; $i <= 1; $i++) {
                    if (!isset($arrayOfThicknessStandard[$i]) && $request->input['thicknessStandard'] != null) {
                        return "Error-ThicknessStandard";
                    }
                }

                //To Get Min, Nom And Max from thicknessEndActual
                if ($request->input['thicknessEndActual'] != NULL) {
                    $arrayOfThicknessEndActual = array();
                    $statment = $request->input['thicknessEndActual'];
                    $counter = 0;
                    $part = "";
                    for ($i = 0; $i < strlen($statment); $i++) {
                        if ($statment[$i] == '/') {
                            $arrayOfThicknessEndActual[$counter] = $part;
                            $counter++;
                            $part = "";
                        } else {
                            $part = $part . $statment[$i];
                            if ($i == strlen($statment) - 1) {
                                $arrayOfThicknessEndActual[$counter] = $part;
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < 3; $i++) {
                        $arrayOfThicknessEndActual[$i] = NULL;
                    }
                }

                //For check is employee Enter the thicknessEndActual correct or not
                for ($i = 0; $i <= 1; $i++) {
                    if (!isset($arrayOfThicknessEndActual[$i]) && $request->input['thicknessEndActual'] != NULL) {
                        return "Error-thicknessEndActual";
                    }
                }


                if (false) {

                    $message = ['employee' => $name, 'Sheet' => 'Sheathing', 'errors' => ''];

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
