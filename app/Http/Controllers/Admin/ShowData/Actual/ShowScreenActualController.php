<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use App\ScreenActual;
use App\ScreenActualsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowScreenActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataScreen()
    {
        return view('Admin.ShowData.Actual.show_actual_screen');
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

    public function getDataScreen(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $checkJopOrderNumber = DB::table('screenstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('screenstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('screenactuals')->where([
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
                            ['color', 'LIKE', '%' . $request->filter['color'] . '%'],
                            ['tapeWeight', 'LIKE', '%' . $request->filter['tapeWeight'] . '%'],
                            ['wireWeight', 'LIKE', '%' . $request->filter['wireWeight'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['overLapActual1', '!=', null],
                            ['dimAfter1', '!=', null],
                            ['tapeDimention', '!=', null]
                        ])->where(function ($query) {
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

                        $actualIdAsArray = DB::table('screenactuals')->select('id')->where([
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
                            ['color', 'LIKE', '%' . $request->filter['color'] . '%'],
                            ['tapeWeight', 'LIKE', '%' . $request->filter['tapeWeight'] . '%'],
                            ['wireWeight', 'LIKE', '%' . $request->filter['wireWeight'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['overLapActual1', '!=', null],
                            ['dimAfter1', '!=', null],
                            ['tapeDimention', '!=', null]
                        ])->where(function ($query) {
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
                        $actualTimeRows = DB::table('screenactualstimes')->whereIn('screenactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('screenstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('screenactuals')->where([
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
                            ['color', 'LIKE', '%' . $request->filter['color'] . '%'],
                            ['tapeWeight', 'LIKE', '%' . $request->filter['tapeWeight'] . '%'],
                            ['wireWeight', 'LIKE', '%' . $request->filter['wireWeight'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['overLapActual1', '!=', null],
                            ['dimAfter1', '!=', null],
                            ['tapeDimention', '!=', null]
                        ])->where(function ($query) {
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

                        $actualIdAsArray = DB::table('screenactuals')->select('id')->where([
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
                            ['color', 'LIKE', '%' . $request->filter['color'] . '%'],
                            ['tapeWeight', 'LIKE', '%' . $request->filter['tapeWeight'] . '%'],
                            ['wireWeight', 'LIKE', '%' . $request->filter['wireWeight'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['overLapActual1', '!=', null],
                            ['dimAfter1', '!=', null],
                            ['tapeDimention', '!=', null]
                        ])->where(function ($query) {
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
                        $actualTimeRows = DB::table('screenactualstimes')->whereIn('screenactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('screenstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();

                    $actualRows = DB::table('screenactuals')->where('jopOrderNumber', $request->filter['jopOrderNumber'])
                        ->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('color', null)
                        ->orWhere('tapeWeight', null)
                        ->orWhere('wireWeight', null)
                        ->orWhere('overLapActual1', null)
                        ->orWhere('dimAfter1', null)
                        ->orWhere('tapeDimention', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('screenactuals')->select('id')->where('jopOrderNumber', $request->filter['jopOrderNumber'])
                        ->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('color', null)
                        ->orWhere('tapeWeight', null)
                        ->orWhere('wireWeight', null)
                        ->orWhere('overLapActual1', null)
                        ->orWhere('dimAfter1', null)
                        ->orWhere('tapeDimention', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                    $actualTimeRows = DB::table('screenactualstimes')->whereIn('screenactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataScreen(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('screenactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('screenactualstimes')->where('screenactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataScreen(Request $request)
    {
        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            if (empty($request->overLapActual1[0]) && (!empty($request->overLapActual2[0]) || !empty($request->overLapActual3[0]) || !empty($request->overLapActual4[0]))) {
                return 'Error-overLapActual1';
            }

            if (empty($request->dimAfter1[0]) && (!empty($request->dimAfter2[0]) || !empty($request->dimAfter3[0]) || !empty($request->dimAfter4[0]))) {
                return 'Error-dimAfter1';
            }

            //To Return Error-notes is Required if Status is Hold
            if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                return 'Error-notes';
            }

            $rowDataScreenActual = ScreenActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum' => $request->inputDrum[0],
                    'inputCard' => $request->inputCard[0],
                    'inputLength' => $request->inputCard[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputCard[0],
                    'color' => $request->color[0],
                    'tapeWeight' => $request->tapeWeight[0],
                    'wireWeight' => $request->wireWeight[0],
                    'overLapActual1' => $request->overLapActual1[0],
                    'overLapActual2' => $request->overLapActual2[0],
                    'overLapActual3' => $request->overLapActual3[0],
                    'overLapActual4' => $request->overLapActual4[0],
                    'dimAfter1' => $request->dimAfter1[0],
                    'dimAfter2' => $request->dimAfter2[0],
                    'dimAfter3' => $request->dimAfter3[0],
                    'dimAfter4' => $request->dimAfter4[0],
                    'tapeDimention' => $request->tapeDimention[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataScreenActualTime = ScreenActualsTimes::where('screenactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum_time' => $request->inputDrum[1],
                    'inputCard_time' => $request->inputCard[1],
                    'inputLength_time' => $request->inputCard[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputCard[1],
                    'color_time' => $request->color[1],
                    'tapeWeight_time' => $request->tapeWeight[1],
                    'wireWeight_time' => $request->wireWeight[1],
                    'overLapActual1_time' => $request->overLapActual1[1],
                    'overLapActual2_time' => $request->overLapActual2[1],
                    'overLapActual3_time' => $request->overLapActual3[1],
                    'overLapActual4_time' => $request->overLapActual4[1],
                    'dimAfter1_time' => $request->dimAfter1[1],
                    'dimAfter2_time' => $request->dimAfter2[1],
                    'dimAfter3_time' => $request->dimAfter3[1],
                    'dimAfter4_time' => $request->dimAfter4[1],
                    'tapeDimention_time' => $request->tapeDimention[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $screenActual = DB::table('screenactuals')->where('id', '=', $request->id)->first();
            $screenActualTime = DB::table('screenactualstimes')->where('screenactuals_id', '=', $request->id)->first();
            $screenStandard = DB::table('screenstandards')->where('id', $screenActual->jopOrderNumber_id)->first();
            $screenStandardTime = DB::table('screenstandardstimes')->where('screenstandards_id', $screenActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Screen'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $screenStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $screenStandard->size_type;
                    $hold->length = $request->outputLength[0];
                    $hold->description = '';
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Screen";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $screenStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $screenStandardTime->size_type_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = '';
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Screen'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Screen'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'description' => '',
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Screen",
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);

                    $holdTime = DB::table('holdtimes')
                        ->where('hold_id', $dataOfHold->id)
                        ->update([
                            'drumNumber_time' => $request->outputDrum[1],
                            'length_time' => $request->outputLength[1],
                            'description_time' => '',
                            'machine_time' => $request->machine[1],
                            'reasonOfHold_time' =>  $request->notes[1],
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);
                }
            }

            return array($screenActual, $screenActualTime);
        }
    }

    public function deleteDataScreen(Request $request)
    {
        if ($request->ajax()) {

            $deleteActualTimeRow = DB::table('screenactualstimes')->where('screenactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('screenactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Screen')->exists();

            if (!$chickISO) {
                $screenISO = new ISO();
                $screenISO->sheet = "Screen";
                $screenISO->save();
            }


            $screenISO = DB::table('iso')->where('sheet', 'Screen')->get();
            return $screenISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Screen')->exists();

            if (!$chickISO) {

                $screenISO = new ISO();
                $screenISO->sheet = "Screen";
                $screenISO->issueNumber = $request->issueNumber;
                $screenISO->issueDate = $request->issueDate;
                $screenISO->modifiedDate = $request->modifiedDate;
                $screenISO->durationOfPreservation = $request->durationOfPreservation;
                $screenISO->material = $request->material;
                $screenISO->save();
            } else {
                $screenISO = DB::table('iso')->where('sheet', 'Screen')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $screenISO = DB::table('iso')->where('sheet', 'Screen')->get();


            $result = $this->getDataScreen($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $screenISO);

            return $result;
        }
    }
}
