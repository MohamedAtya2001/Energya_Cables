<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\DrowingActual;
use App\DrowingActualsTimes;
use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowDrowingActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataDrowing()
    {
        return view('Admin.ShowData.Actual.show_actual_drowing');
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

    public function getDataDrowing(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $checkJopOrderNumber = DB::table('drowingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {
                if ($request->filter['sheetsType'] == 'complete') {
                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('drowingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                        $actualRows = DB::table('drowingactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['coilNumber', 'LIKE', '%' . $request->filter['coilNumber'] . '%'],
                                ['cage', 'LIKE', '%' . $request->filter['cage'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['wireDimMinActual', '!=', null],
                                ['elongationActual', '!=', null],
                                ['tensileActual', '!=', null],
                                ['visual', '!=', null],
                                ['status', '!=', null]
                            ])->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->whereBetween('created_at', [$from, $to]);

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('drowingactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['coilNumber', 'LIKE', '%' . $request->filter['coilNumber'] . '%'],
                                ['cage', 'LIKE', '%' . $request->filter['cage'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['wireDimMinActual', '!=', null],
                                ['elongationActual', '!=', null],
                                ['tensileActual', '!=', null],
                                ['visual', '!=', null],
                                ['status', '!=', null]
                            ])->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('drowingactualstimes')->whereIn('drowingactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('drowingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                        $actualRows = DB::table('drowingactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['coilNumber', 'LIKE', '%' . $request->filter['coilNumber'] . '%'],
                                ['cage', 'LIKE', '%' . $request->filter['cage'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['wireDimMinActual', '!=', null],
                                ['elongationActual', '!=', null],
                                ['tensileActual', '!=', null],
                                ['visual', '!=', null],
                                ['status', '!=', null]
                            ])->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            });

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('drowingactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['coilNumber', 'LIKE', '%' . $request->filter['coilNumber'] . '%'],
                                ['cage', 'LIKE', '%' . $request->filter['cage'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['wireDimMinActual', '!=', null],
                                ['elongationActual', '!=', null],
                                ['tensileActual', '!=', null],
                                ['visual', '!=', null],
                                ['status', '!=', null]
                            ])->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                        $actualTimeRows = DB::table('drowingactualstimes')->whereIn('drowingactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('drowingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                    $actualRows = DB::table('drowingactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                        ->where('machine', null)
                        ->orWhere('coilNumber', null)
                        ->orWhere('wireDimMinActual', null)
                        ->orWhere('elongationActual', null)
                        ->orWhere('tensileActual', null)
                        ->orWhere('cage', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('visual', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('drowingactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                        ->where('machine', null)
                        ->orWhere('coilNumber', null)
                        ->orWhere('wireDimMinActual', null)
                        ->orWhere('elongationActual', null)
                        ->orWhere('tensileActual', null)
                        ->orWhere('cage', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('visual', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                    $actualTimeRows = DB::table('drowingactualstimes')->whereIn('drowingactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataDrowing(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('drowingactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('drowingactualstimes')->where('drowingactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataDrowing(Request $request)
    {
        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

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

            $rowDataDrowingActual = DrowingActual::where('id', '=', $request->id)
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
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataDrowingActualTime = DrowingActualsTimes::where('drowingactuals_id', '=', $request->id)
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
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $drowingActual = DB::table('drowingactuals')->where('id', '=', $request->id)->first();
            $drowingActualTime = DB::table('drowingactualstimes')->where('drowingactuals_id', '=', $request->id)->first();
            $drowingStandard = DB::table('drowingstandards')->where('id', $drowingActual->jopOrderNumber_id)->first();
            $drowingStandardTime = DB::table('drowingstandardstimes')->where('drowingstandards_id', $drowingActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Drowing'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $drowingStandard->jopOrderNumber;
                    $hold->drumNumber = '';
                    $hold->cableSize = $drowingStandard->size;
                    $hold->length = '';
                    $hold->description = '';
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Drowing";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $drowingStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = '';
                    $holdTime->cableSize_time = $drowingStandardTime->size_time;
                    $holdTime->length_time = '';
                    $holdTime->description_time = '';
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Drowing'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Drowing'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => '',
                            'length' => '',
                            'description' => '',
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Drowing",
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);

                    $holdTime = DB::table('holdtimes')
                        ->where('hold_id', $dataOfHold->id)
                        ->update([
                            'drumNumber_time' => '',
                            'length_time' => '',
                            'description_time' => '',
                            'machine_time' => $request->machine[1],
                            'reasonOfHold_time' =>  $request->notes[1],
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);
                }
            }

            return array($drowingActual, $drowingActualTime);
        }
    }

    public function deleteDataDrowing(Request $request)
    {
        if ($request->ajax()) {
            $deleteActualTimeRow = DB::table('drowingactualstimes')->where('drowingactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('drowingactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Drowing')->exists();

            if (!$chickISO) {
                $drowingISO = new ISO();
                $drowingISO->sheet = "Drowing";
                $drowingISO->save();
            }


            $drowingISO = DB::table('iso')->where('sheet', 'Drowing')->get();
            return $drowingISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Drowing')->exists();

            if (!$chickISO) {

                $drowingISO = new ISO();
                $drowingISO->sheet = "Drowing";
                $drowingISO->issueNumber = $request->issueNumber;
                $drowingISO->issueDate = $request->issueDate;
                $drowingISO->modifiedDate = $request->modifiedDate;
                $drowingISO->durationOfPreservation     = $request->durationOfPreservation;
                $drowingISO->material = $request->material;
                $drowingISO->save();
            } else {
                $drowingISO = DB::table('iso')->where('sheet', 'Drowing')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $drowingISO = DB::table('iso')->where('sheet', 'Drowing')->get();

            $result = $this->getDataDrowing($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $drowingISO);

            return $result;
        }
    }
}
