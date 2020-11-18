<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Alert;
use App\DrowingActual;
use App\DrowingActualsTimes;
use App\DrowingStandard;
use App\DrowingStandardsTimes;
use App\Events\WatchingEmployee;
use App\Hold;
use App\HoldTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DrowingController extends Controller
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

    public function insertDrowing(Request $request)
    {
        if ($request->ajax()) {
            if (!$this->checkEmployeeShift()) {
                return 'Logout';
            }
            if ($request->update == 'false') {

                $shift = 'shift ' . $this->currentShift();

                $checkJopOrderNumber = DB::table('drowingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->exists();

                //To Check About "who did make insert ?"
                $name = Auth::guard('web')->user()->name;

                //To Check if Standard is new or not
                if (!$checkJopOrderNumber) {

                    //To Add New DrowingStansard
                    $jopOrderDrowing = new DrowingStandard();
                    $jopOrderDrowing->jopOrderNumber = $request->jopOrderNumber[0];
                    $jopOrderDrowing->wireDimMinStandard = $request->wireDimMinStandard[0];
                    $jopOrderDrowing->wireDimNomStandard = $request->wireDimNomStandard[0];
                    $jopOrderDrowing->wireDimMaxStandard = $request->wireDimMaxStandard[0];
                    $jopOrderDrowing->size = $request->size[0];
                    $jopOrderDrowing->volt = $request->volt[0];
                    $jopOrderDrowing->elongationStandard = $request->elongationStandard[0];
                    $jopOrderDrowing->tensileStandard = $request->tensileStandard[0];
                    $jopOrderDrowing->added_by = $name;
                    $jopOrderDrowing->shift = $shift;
                    $jopOrderDrowing->save();

                    $jopOrderNumber_id = DB::table('drowingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');


                    //To Add New DrowingStansardTimes
                    $jopOrderDrowing_time = new DrowingStandardsTimes();
                    $jopOrderDrowing_time->drowingstandards_id = $jopOrderNumber_id;
                    $jopOrderDrowing_time->jopOrderNumber_time = $request->jopOrderNumber[1];
                    $jopOrderDrowing_time->wireDimMinStandard_time = $request->wireDimMinStandard[1];
                    $jopOrderDrowing_time->wireDimNomStandard_time = $request->wireDimNomStandard[1];
                    $jopOrderDrowing_time->wireDimMaxStandard_time = $request->wireDimMaxStandard[1];
                    $jopOrderDrowing_time->size_time = $request->size[1];
                    $jopOrderDrowing_time->volt_time = $request->volt[1];
                    $jopOrderDrowing_time->elongationStandard_time = $request->elongationStandard[1];
                    $jopOrderDrowing_time->tensileStandard_time = $request->tensileStandard[1];
                    $jopOrderDrowing_time->added_by = $name;
                    $jopOrderDrowing_time->shift = $shift;
                    $jopOrderDrowing_time->save();
                }

                $jopOrderNumber_id = DB::table('drowingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber[0])->value('id');

                if (
                    (empty($request->wireDimMinActual[0]) || empty($request->wireDimNomActual[0]) || empty($request->wireDimMaxActual[0])) &&
                    (!empty($request->wireDimMinActual[0]) || !empty($request->wireDimNomActual[0]) || !empty($request->wireDimMaxActual[0]))
                ) {
                    return 'Error-wireDimActual';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                //To Add New DrowingActual
                $actualDrowing = new DrowingActual();
                $actualDrowing->jopOrderNumber_id = $jopOrderNumber_id;
                $actualDrowing->jopOrderNumber = $request->jopOrderNumber[0];
                $actualDrowing->machine = $request->machine[0];
                $actualDrowing->coilNumber = $request->coilNumber[0];
                $actualDrowing->wireDimMinActual =  $request->wireDimMinActual[0];
                $actualDrowing->wireDimNomActual =  $request->wireDimNomActual[0];
                $actualDrowing->wireDimMaxActual =  $request->wireDimMaxActual[0];
                $actualDrowing->elongationActual = $request->elongationActual[0];
                $actualDrowing->tensileActual = $request->tensileActual[0];
                $actualDrowing->cage = $request->cage[0];
                $actualDrowing->outputCard = $request->outputCard[0];
                $actualDrowing->visual = $request->visual[0];
                $actualDrowing->status = $request->status[0];
                $actualDrowing->productionOperator = $request->productionOperator[0];
                $actualDrowing->notes = $request->notes[0];
                $actualDrowing->added_by = $name;
                $actualDrowing->shift = $shift;
                $actualDrowing->save();

                //To  Add New DrowingActualTimes
                $actualDrowingTime = new DrowingActualsTimes();
                $actualDrowingTime->drowingactuals_id = $actualDrowing->id;
                $actualDrowingTime->jopOrderNumber = $request->jopOrderNumber[0];
                $actualDrowingTime->machine_time = $request->machine[1];
                $actualDrowingTime->coilNumber_time = $request->coilNumber[1];
                $actualDrowingTime->wireDimMinActual_time = $request->wireDimMinActual[1];
                $actualDrowingTime->wireDimNomActual_time = $request->wireDimNomActual[1];
                $actualDrowingTime->wireDimMaxActual_time = $request->wireDimMaxActual[1];
                $actualDrowingTime->elongationActual_time = $request->elongationActual[1];
                $actualDrowingTime->tensileActual_time = $request->tensileActual[1];
                $actualDrowingTime->cage_time = $request->cage[1];
                $actualDrowingTime->outputCard_time = $request->outputCard[1];
                $actualDrowingTime->visual_time = $request->visual[1];
                $actualDrowingTime->status_time = $request->status[1];
                $actualDrowingTime->productionOperator_time = $request->productionOperator[1];
                $actualDrowingTime->notes_time = $request->notes[1];
                $actualDrowingTime->added_by = $name;
                $actualDrowingTime->shift = $shift;
                $actualDrowingTime->save();

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $actualDrowing->id;
                    $hold->jopOrderNumber = ($request->jopOrderNumber[0] == null) ? '' : $request->jopOrderNumber[0];
                    $hold->drumNumber = '';
                    $hold->cableSize = ($request->size[0] == null) ? '' : $request->size[0];
                    $hold->length = '';
                    $hold->description = '';
                    $hold->machine = ($request->machine[0] == null) ? '' : $request->machine[0];
                    $hold->reasonOfHold = ($request->notes[0] == null) ? '' : $request->notes[0];
                    $hold->fromSheet = "Drowing";
                    $hold->added_by = $name;
                    $hold->shift = $shift;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = ($request->jopOrderNumber[1] == null) ? '' : $request->jopOrderNumber[1];
                    $holdTime->drumNumber_time = '';
                    $holdTime->cableSize_time = ($request->size[1] == null) ? '' : $request->size[1];
                    $holdTime->length_time = '';
                    $holdTime->description_time = '';
                    $holdTime->machine_time = ($request->machine[1] == null) ? '' : $request->machine[1];
                    $holdTime->reasonOfHold_time = ($request->notes[1] == null) ? '' : $request->notes[1];
                    $holdTime->added_by = $name;
                    $holdTime->shift = $shift;
                    $holdTime->save();
                }



                //To save change That Happend in Drowing Table
                $drowings = DB::table('drowings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $name]
                ])->update([
                    'jopOrderNumber' => '',
                    'wireDimMinStandard' => '',
                    'wireDimNomStandard' => '',
                    'wireDimMaxStandard' => '',
                    'size' => '',
                    'volt' => '',
                    'machine' => '',
                    'elongationStandard' => '',
                    'tensileStandard' => '',
                    'coilNumber' => '',
                    'wireDimMinActual' => '',
                    'wireDimNomActual' => '',
                    'wireDimMaxActual' => '',
                    'elongationActual' => '',
                    'tensileActual' => '',
                    'cage' => '',
                    'outputCard' => '',
                    'visual' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'wireDimMinStandard',
                    'wireDimNomStandard',
                    'wireDimMaxStandard',
                    'size',
                    'volt',
                    'elongationStandard',
                    'tensileStandard',
                    'machine',
                    'coilNumber',
                    'wireDimMinActual',
                    'wireDimNomActual',
                    'wireDimMaxActual',
                    'elongationActual',
                    'tensileActual',
                    'cage',
                    'outputCard',
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
                    ''
                );
                event(new WatchingEmployee('drowing', $request->data_form_item, $attributes, $values));
            } else {
                $shiftOfWhoMadeUpdate = 'shift ' . $this->currentShift();

                //To Check About "who did make Update ?"
                $nameOfWhoMadeUpdate = Auth::guard('web')->user()->name;

                // To Get nameOfWhoMadeInsert and shiftOfWhoMadeInsert
                $nameOfWhoMadeInsert = DB::table('drowingactuals')->find($request->id_update)->added_by;
                $shiftOfWhoMadeInsert = DB::table('drowingactuals')->find($request->id_update)->shift;

                if (
                    (empty($request->wireDimMinActual[0]) || empty($request->wireDimNomActual[0]) || empty($request->wireDimMaxActual[0])) &&
                    (!empty($request->wireDimMinActual[0]) || !empty($request->wireDimNomActual[0]) || !empty($request->wireDimMaxActual[0]))
                ) {
                    return 'Error-wireDimActual';
                }

                //To Return Error-notes is Required if Status is Hold
                if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                    return 'Error-notes';
                }

                $rowDataDrowingActual = DB::table('drowingactuals')
                    ->where('id', '=', $request->id_update)
                    ->update([
                        'machine' => $request->machine[0],
                        'coilNumber' => $request->coilNumber[0],
                        'wireDimMinActual' => $request->wireDimMinActual[0],
                        'wireDimNomActual' => $request->wireDimNomActual[0],
                        'wireDimMaxActual' => $request->wireDimMaxActual[0],
                        'elongationActual' => $request->elongationActual[0],
                        'tensileActual' => $request->tensileActual[0],
                        'cage' => $request->cage[0],
                        'outputCard' => $request->outputCard[0],
                        'visual' => $request->visual[0],
                        'status' => $request->status[0],
                        'productionOperator' => $request->productionOperator[0],
                        'notes' => $request->notes[0],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                $rowDataDrowingActualTime = DB::table('drowingactualstimes')
                    ->where('drowingactuals_id', '=', $request->id_update)
                    ->update([
                        'machine_time' => $request->machine[1],
                        'coilNumber_time' => $request->coilNumber[1],
                        'wireDimMinActual_time' => $request->wireDimMinActual[1],
                        'wireDimNomActual_time' => $request->wireDimNomActual[1],
                        'wireDimMaxActual_time' => $request->wireDimMaxActual[1],
                        'elongationActual_time' => $request->elongationActual[1],
                        'tensileActual_time' => $request->tensileActual[1],
                        'cage_time' => $request->cage[1],
                        'outputCard_time' => $request->outputCard[1],
                        'visual_time' => $request->visual[1],
                        'status_time' => $request->status[1],
                        'productionOperator_time' => $request->productionOperator[1],
                        'added_by' => $nameOfWhoMadeInsert . " / " . $nameOfWhoMadeUpdate,
                        'shift' => $shiftOfWhoMadeInsert . " / " . $shiftOfWhoMadeUpdate
                    ]);

                // To Make Hold If Status is Hold
                if ($request->status[0] == "hold") {
                    $holdIsExists = DB::table('hold')->where([['fromSheet', 'Drowing'], ['sheet_id', $request->id_update]])->exists();
                    if (!$holdIsExists) {
                        // To Add New Hold
                        $hold = new Hold();
                        $hold->sheet_id = $request->id_update;
                        $hold->jopOrderNumber = $request->jopOrderNumber[0];
                        $hold->drumNumber = '';
                        $hold->cableSize = $request->size[0];
                        $hold->length = '';
                        $hold->description = '';
                        $hold->machine = $request->machine[0];
                        $hold->reasonOfHold = $request->notes[0];
                        $hold->fromSheet = "Drowing";
                        $hold->added_by = $nameOfWhoMadeUpdate;
                        $hold->shift = $shiftOfWhoMadeInsert;
                        $hold->save();

                        // To Add New HoldTime
                        $holdTime = new HoldTime();
                        $holdTime->hold_id = $hold->id;
                        $holdTime->jopOrderNumber_time = $request->jopOrderNumber[1];
                        $holdTime->drumNumber_time = '';
                        $holdTime->cableSize_time = $request->size[1];
                        $holdTime->length_time = '';
                        $holdTime->description_time = '';
                        $holdTime->machine_time = $request->machine[1];
                        $holdTime->reasonOfHold_time = $request->notes[1];
                        $holdTime->added_by = $nameOfWhoMadeUpdate;
                        $holdTime->shift = $shiftOfWhoMadeInsert;
                        $holdTime->save();
                    } else {
                        $dataOfHold = DB::table('hold')->where([['fromSheet', 'Drowing'], ['sheet_id', $request->id_update]])->first();
                        $hold = DB::table('hold')
                            ->where([['fromSheet', 'Drowing'], ['sheet_id', $request->id_update]])
                            ->update([
                                'jopOrderNumber' => $request->jopOrderNumber[0],
                                'drumNumber' => '',
                                'cableSize' => $request->size[0],
                                'length' => '',
                                'description' => '',
                                'machine' => $request->machine[0],
                                'reasonOfHold' =>  $request->notes[0],
                                'fromSheet' => "Drowing",
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);

                        $holdTime = DB::table('holdtimes')
                            ->where('hold_id', $dataOfHold->id)
                            ->update([
                                'jopOrderNumber_time' => $request->jopOrderNumber[1],
                                'drumNumber_time' => '',
                                'cableSize_time' => $request->size[1],
                                'length_time' => '',
                                'description_time' => '',
                                'machine_time' => $request->machine[1],
                                'reasonOfHold_time' =>  $request->notes[1],
                                'added_by' => $dataOfHold->added_by . ' / ' . $nameOfWhoMadeUpdate,
                                'shift' => $dataOfHold->shift . ' / ' . $shiftOfWhoMadeInsert
                            ]);
                    }
                }

                //To save change That Happend in Drowing Table
                $drowings = DB::table('drowings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', $nameOfWhoMadeUpdate]
                ])->update([
                    'jopOrderNumber' => '',
                    'wireDimMinStandard' => '',
                    'wireDimNomStandard' => '',
                    'wireDimMaxStandard' => '',
                    'size' => '',
                    'volt' => '',
                    'machine' => '',
                    'elongationStandard' => '',
                    'tensileStandard' => '',
                    'coilNumber' => '',
                    'wireDimMinActual' => '',
                    'wireDimNomActual' => '',
                    'wireDimMaxActual' => '',
                    'elongationActual' => '',
                    'tensileActual' => '',
                    'cage' => '',
                    'outputCard' => '',
                    'visual' => '',
                    'status' => '',
                    'productionOperator' => '',
                    'notes' => ''
                ]);

                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'wireDimMinStandard',
                    'wireDimNomStandard',
                    'wireDimMaxStandard',
                    'size',
                    'volt',
                    'elongationStandard',
                    'tensileStandard',
                    'machine',
                    'coilNumber',
                    'wireDimMinActual',
                    'wireDimNomActual',
                    'wireDimMaxActual',
                    'elongationActual',
                    'tensileActual',
                    'cage',
                    'outputCard',
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
                    ''
                );
                event(new WatchingEmployee('drowing', $request->data_form_item, $attributes, $values));

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

            $checkJopOrderNumber = DB::table('drowingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->exists();

            if ($checkJopOrderNumber) {
                $drowingStandard = DB::table('drowingstandards')->where('jopOrderNumber', '=', $request->jopOrderNumber)->first();
                //To save change That Happend in Drowing Table
                $drowings = DB::table('drowings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $drowingStandard->jopOrderNumber,
                    'wireDimMinStandard' => $drowingStandard->wireDimMinStandard,
                    'wireDimNomStandard' => $drowingStandard->wireDimNomStandard,
                    'wireDimMaxStandard' => $drowingStandard->wireDimMaxStandard,
                    'size' => $drowingStandard->size,
                    'volt' => $drowingStandard->volt,
                    'elongationStandard' => $drowingStandard->elongationStandard,
                    'tensileStandard' => $drowingStandard->tensileStandard
                ]);
                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'wireDimMinStandard',
                    'wireDimNomStandard',
                    'wireDimMaxStandard',
                    'size',
                    'volt',
                    'elongationStandard',
                    'tensileStandard',
                );
                $values = array(
                    $drowingStandard->jopOrderNumber,
                    $drowingStandard->wireDimMinStandard,
                    $drowingStandard->wireDimNomStandard,
                    $drowingStandard->wireDimMaxStandard,
                    $drowingStandard->size,
                    $drowingStandard->volt,
                    $drowingStandard->elongationStandard,
                    $drowingStandard->tensileStandard,
                );
                event(new WatchingEmployee('drowing', $request->data_form_item, $attributes, $values));

                return (array) $drowingStandard;
            } else {
                //To save change That Happend in Drowing Table
                $drowings = DB::table('drowings')->where([
                    ['form_item', $request->data_form_item],
                    ['employee_name', Auth::guard('web')->user()->name]
                ])->update([
                    'jopOrderNumber' => $request->jopOrderNumber,
                    'wireDimMinStandard' => '',
                    'wireDimNomStandard' => '',
                    'wireDimMaxStandard' => '',
                    'size' => '',
                    'volt' => '',
                    'elongationStandard' => '',
                    'tensileStandard' => ''
                ]);
                //For Send Change That Happend by Employee To Admin
                $attributes = array(
                    'jopOrderNumber',
                    'wireDimMinStandard',
                    'wireDimNomStandard',
                    'wireDimMaxStandard',
                    'size',
                    'volt',
                    'elongationStandard',
                    'tensileStandard',
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
                );
                event(new WatchingEmployee('drowing', $request->data_form_item, $attributes, $values));

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

            $alertIsExist = DB::table('drowingactuals')->where('id', $request->id)->exists();

            if (!$alertIsExist) {
                return "Alert Has Deleted By Admin";
            }

            $rowDataDrowingActual = DB::table('drowingactuals')->where('id', $request->id)->first();
            $rowDataDrowingStandard = DB::table('drowingstandards')->where('id', $rowDataDrowingActual->jopOrderNumber_id)->first();
            $rowDataDrowingActualTime = DB::table('drowingactualstimes')->where('id', $request->id)->first();
            $rowDataDrowingStandardTime = DB::table('drowingstandardstimes')->where('id', $rowDataDrowingActual->jopOrderNumber_id)->first();

            //To save change That Happend in Drowing Table
            $drowings = DB::table('drowings')->where([
                ['form_item', $request->data_form_item],
                ['employee_name', Auth::guard('web')->user()->name]
            ])->update([
                'jopOrderNumber' => ($rowDataDrowingStandard->jopOrderNumber == null) ? '' : $rowDataDrowingStandard->jopOrderNumber,
                'wireDimMinStandard' => ($rowDataDrowingStandard->wireDimMinStandard == null) ? '' : $rowDataDrowingStandard->wireDimMinStandard,
                'wireDimNomStandard' => ($rowDataDrowingStandard->wireDimNomStandard == null) ? '' : $rowDataDrowingStandard->wireDimNomStandard,
                'wireDimMaxStandard' => ($rowDataDrowingStandard->wireDimMaxStandard == null) ? '' : $rowDataDrowingStandard->wireDimMaxStandard,
                'size' => ($rowDataDrowingStandard->size == null) ? '' : $rowDataDrowingStandard->size,
                'volt' => ($rowDataDrowingStandard->volt == null) ? '' : $rowDataDrowingStandard->volt,
                'elongationStandard' => ($rowDataDrowingStandard->elongationStandard == null) ? '' : $rowDataDrowingStandard->elongationStandard,
                'tensileStandard' => ($rowDataDrowingStandard->tensileStandard == null) ? '' : $rowDataDrowingStandard->tensileStandard,
                'machine' => ($rowDataDrowingActual->machine == null) ? '' : $rowDataDrowingActual->machine,
                'coilNumber' => ($rowDataDrowingActual->coilNumber == null) ? '' : $rowDataDrowingActual->coilNumber,
                'wireDimMinActual' => ($rowDataDrowingActual->wireDimMinActual == null) ? '' : $rowDataDrowingActual->wireDimMinActual,
                'wireDimNomActual' => ($rowDataDrowingActual->wireDimNomActual == null) ? '' : $rowDataDrowingActual->wireDimNomActual,
                'wireDimMaxActual' => ($rowDataDrowingActual->wireDimMaxActual == null) ? '' : $rowDataDrowingActual->wireDimMaxActual,
                'elongationActual' => ($rowDataDrowingActual->elongationActual == null) ? '' : $rowDataDrowingActual->elongationActual,
                'tensileActual' => ($rowDataDrowingActual->tensileActual == null) ? '' : $rowDataDrowingActual->tensileActual,
                'cage' => ($rowDataDrowingActual->cage == null) ? '' : $rowDataDrowingActual->cage,
                'outputCard' => ($rowDataDrowingActual->outputCard == null) ? '' : $rowDataDrowingActual->outputCard,
                'visual' => ($rowDataDrowingActual->visual == null) ? '' : $rowDataDrowingActual->visual,
                'status' => ($rowDataDrowingActual->status == null) ? '' : $rowDataDrowingActual->status,
                'productionOperator' => ($rowDataDrowingActual->productionOperator == null) ? '' : $rowDataDrowingActual->productionOperator,
                'notes' => ($rowDataDrowingActual->notes == null) ? '' : $rowDataDrowingActual->notes
            ]);

            //For Send Change That Happend by Employee To Admin
            $attributes = array(
                'jopOrderNumber',
                'wireDimMinStandard',
                'wireDimNomStandard',
                'wireDimMaxStandard',
                'size',
                'volt',
                'elongationStandard',
                'tensileStandard',
                'machine',
                'coilNumber',
                'wireDimMinActual',
                'wireDimNomActual',
                'wireDimMaxActual',
                'elongationActual',
                'tensileActual',
                'cage',
                'outputCard',
                'visual',
                'status',
                'productionOperator',
                'notes'
            );
            $values = array(
                $rowDataDrowingStandard->jopOrderNumber,
                $rowDataDrowingStandard->wireDimMinStandard,
                $rowDataDrowingStandard->wireDimNomStandard,
                $rowDataDrowingStandard->wireDimMaxStandard,
                $rowDataDrowingStandard->size,
                $rowDataDrowingStandard->volt,
                $rowDataDrowingStandard->elongationStandard,
                $rowDataDrowingStandard->tensileStandard,
                $rowDataDrowingActual->machine,
                $rowDataDrowingActual->coilNumber,
                $rowDataDrowingActual->wireDimMinActual,
                $rowDataDrowingActual->wireDimNomActual,
                $rowDataDrowingActual->wireDimMaxActual,
                $rowDataDrowingActual->elongationActual,
                $rowDataDrowingActual->tensileActual,
                $rowDataDrowingActual->cage,
                $rowDataDrowingActual->outputCard,
                $rowDataDrowingActual->visual,
                $rowDataDrowingActual->status,
                $rowDataDrowingActual->productionOperator,
                $rowDataDrowingActual->notes
            );
            event(new WatchingEmployee('drowing', $request->data_form_item, $attributes, $values));


            return array(
                $rowDataDrowingStandard,
                $rowDataDrowingActual,
                $rowDataDrowingActualTime,
                $rowDataDrowingStandardTime
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

            $rowUpdateData = DB::table('drowings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->update([
                $request->input['name'] => ($request->input['value'] == null) ? '' : $request->input['value']
            ]);

            //For Send Change That Happend by Employee To Admin
            event(new WatchingEmployee('drowing', $request->data_form_item, [$request->input['name']], [$request->input['value']]));

            if ($request->input['name'] == "wireDimActual") {


                $dataRow = DB::table('drowings')->where([['employee_name', $name], ['form_item', $request->data_form_item]])->get();

                //To Get Min, Nom And Max from wireDimStandard
                $arrayOfWireDimStandard = array();
                $statment = $dataRow[0]->wireDimStandard;
                $counter = 0;
                $part = "";
                for ($i = 0; $i < strlen($statment); $i++) {
                    if ($statment[$i] == '/') {
                        $arrayOfWireDimStandard[$counter] = $part;
                        $counter++;
                        $part = "";
                    } else {
                        $part = $part . $statment[$i];
                        if ($i == strlen($statment) - 1) {
                            $arrayOfWireDimStandard[$counter] = $part;
                        }
                    }
                }

                //To Get Min, Nom And Max from wireDimActual
                if ($request->input['value'] != null) {
                    $arrayOfWireDimActual = array();
                    $statment = $request->input['value'];
                    $counter = 0;
                    $part = "";
                    for ($i = 0; $i < strlen($statment); $i++) {
                        if ($statment[$i] == '/') {
                            $arrayOfWireDimActual[$counter] = $part;
                            $counter++;
                            $part = "";
                        } else {
                            $part = $part . $statment[$i];
                            if ($i == strlen($statment) - 1) {
                                $arrayOfWireDimActual[$counter] = $part;
                            }
                        }
                    }
                } else {
                    for ($i = 0; $i < 3; $i++) {
                        $arrayOfWireDimActual[$i] = NULL;
                    }
                }


                if (false) {

                    $message = ['employee' => $name, 'Sheet' => 'Drowing', 'errors' => 'wireDimActual'];

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
