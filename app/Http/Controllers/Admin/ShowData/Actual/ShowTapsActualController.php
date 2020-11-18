<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use App\TapsActual;
use App\TapsActualsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowTapsActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataTaps()
    {
        return view('Admin.ShowData.Actual.show_actual_taps');
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

    public function getDataTaps(Request $request)
    {
        if ($request->ajax()) {

            $checkJopOrderNumber = DB::table('tapsstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                $this->request = $request;
                
                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('tapsstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('tapsactuals')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['tapeDimentionActual', '!=', null],
                            ['tapeWeightActual', '!=', null],
                            ['overLapActual', '!=', null],
                            ['dimAfter', '!=', null]
                        ])
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->where(function ($query) {
                                if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                    $query->where('status', 'hold');
                                } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'pass');
                                } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'hold')
                                        ->orWhere('status', 'pass');
                                }
                            })->whereBetween('created_at', [$from, $to]);

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('tapsactuals')->select('id')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['tapeDimentionActual', '!=', null],
                            ['tapeWeightActual', '!=', null],
                            ['overLapActual', '!=', null],
                            ['dimAfter', '!=', null]
                        ])
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->where(function ($query) {
                                if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                    $query->where('status', 'hold');
                                } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'pass');
                                } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'hold')
                                        ->orWhere('status', 'pass');
                                }
                            })->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('tapsactualstimes')->whereIn('tapsactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('tapsstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('tapsactuals')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['tapeDimentionActual', '!=', null],
                            ['tapeWeightActual', '!=', null],
                            ['overLapActual', '!=', null],
                            ['dimAfter', '!=', null]
                        ])
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->where(function ($query) {
                                if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                    $query->where('status', 'hold');
                                } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'pass');
                                } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'hold')
                                        ->orWhere('status', 'pass');
                                }
                            });

                        $countOfActualsRows = $actualRows->get()->count();
                        $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                        $actualIdAsArray = DB::table('tapsactuals')->select('id')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['inputCard', 'LIKE', '%' . $request->filter['inputCard'] . '%'],
                            ['inputLength', 'LIKE', '%' . $request->filter['inputLength'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['tapeDimentionActual', '!=', null],
                            ['tapeWeightActual', '!=', null],
                            ['overLapActual', '!=', null],
                            ['dimAfter', '!=', null]
                        ])
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })->where(function ($query) {
                                if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                    $query->where('status', 'hold');
                                } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'pass');
                                } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'hold')
                                        ->orWhere('status', 'pass');
                                }
                            })->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('tapsactualstimes')->whereIn('tapsactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('tapsstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                    $actualRows = DB::table('tapsactuals')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('tapeDimentionActual', null)
                        ->orWhere('tapeWeightActual', null)
                        ->orWhere('overLapActual', null)
                        ->orWhere('dimAfter', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('tapsactuals')->select('id')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('tapeDimentionActual', null)
                        ->orWhere('tapeWeightActual', null)
                        ->orWhere('overLapActual', null)
                        ->orWhere('dimAfter', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                    $actualTimeRows = DB::table('tapsactualstimes')->whereIn('tapsactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataTaps(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('tapsactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('tapsactualstimes')->where('tapsactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataTaps(Request $request)
    {

        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            //To Return Error-notes is Required if Status is Hold
            if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                return 'Error-notes';
            }

            $rowDataTapsActual = TapsActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputCard[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputCard[0],
                    'tapeDimentionActual' => $request->tapeDimentionActual[0],
                    'tapeWeightActual' => $request->tapeWeightActual[0],
                    'overLapActual' => $request->overLapActual[0],
                    'dimAfter' => $request->dimAfter[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataTapsActualTime = TapsActualsTimes::where('tapsactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputCard[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputCard[1],
                    'tapeDimentionActual_time' => $request->tapeDimentionActual[1],
                    'tapeWeightActual_time' => $request->tapeWeightActual[1],
                    'overLapActual_time' => $request->overLapActual[1],
                    'dimAfter_time' => $request->dimAfter[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $tapsActual = DB::table('tapsactuals')->where('id', '=', $request->id)->first();
            $tapsActualTime = DB::table('tapsactualstimes')->where('tapsactuals_id', '=', $request->id)->first();
            $tapsStandard = DB::table('tapsstandards')->where('id', $tapsActual->jopOrderNumber_id)->first();
            $tapsStandardTime = DB::table('tapsstandardstimes')->where('tapsstandards_id', $tapsActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Taps'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $tapsStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $tapsStandard->cableSize;
                    $hold->length = $request->outputLength[0];
                    $hold->description = null;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Taps";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $tapsStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $tapsStandardTime->cableSize_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = null;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Taps'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Taps'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' => $request->notes[0],
                            'fromSheet' => "Taps",
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);

                    $holdTime = DB::table('holdtimes')
                        ->where('hold_id', $dataOfHold->id)
                        ->update([
                            'drumNumber_time' => $request->outputDrum[1],
                            'length_time' => $request->outputLength[1],
                            'machine_time' => $request->machine[1],
                            'reasonOfHold_time' =>  $request->notes[1],
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);
                }
            }

            return array($tapsActual, $tapsActualTime);
        }
    }

    public function deleteDataTaps(Request $request)
    {
        if ($request->ajax()) {

            $deleteActualTimeRow = DB::table('tapsactualstimes')->where('tapsactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('tapsactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Taps')->exists();

            if (!$chickISO) {
                $TapsISO = new ISO();
                $TapsISO->sheet = "Taps";
                $TapsISO->save();
            }


            $TapsISO = DB::table('iso')->where('sheet', 'Taps')->get();
            return $TapsISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Taps')->exists();

            if (!$chickISO) {

                $TapsISO = new ISO();
                $TapsISO->sheet = "Taps";
                $TapsISO->issueNumber = $request->issueNumber;
                $TapsISO->issueDate = $request->issueDate;
                $TapsISO->modifiedDate = $request->modifiedDate;
                $TapsISO->durationOfPreservation     = $request->durationOfPreservation;
                $TapsISO->material = $request->material;
                $TapsISO->save();
            } else {
                $TapsISO = DB::table('iso')->where('sheet', 'Taps')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $TapsISO = DB::table('iso')->where('sheet', 'Taps')->get();


            $result = $this->getDataTaps($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $TapsISO);

            return $result;
        }
    }
}
