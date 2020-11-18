<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use App\LeadActual;
use App\LeadActualsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowLeadActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataLead()
    {
        return view('Admin.ShowData.Actual.show_actual_lead');
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

    public function getDataLead(Request $request)
    {
        if ($request->ajax()) {

            $checkJopOrderNumber = DB::table('leadstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {
                $this->request = $request;

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('leadstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('leadactuals')->where([
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
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessStartNomActual', '!=', null],
                            ['thicknessStartMaxActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['thicknessEndNomActual', '!=', null],
                            ['thicknessEndMaxActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStart', '!=', null],
                            ['dimAfterEnd', '!=', null],
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

                        $actualIdAsArray = DB::table('leadactuals')->select('id')->where([
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
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessStartNomActual', '!=', null],
                            ['thicknessStartMaxActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['thicknessEndNomActual', '!=', null],
                            ['thicknessEndMaxActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStart', '!=', null],
                            ['dimAfterEnd', '!=', null],
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
                        $actualTimeRows = DB::table('leadactualstimes')->whereIn('leadactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('leadstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('leadactuals')->where([
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
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessStartNomActual', '!=', null],
                            ['thicknessStartMaxActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['thicknessEndNomActual', '!=', null],
                            ['thicknessEndMaxActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStart', '!=', null],
                            ['dimAfterEnd', '!=', null],
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

                        $actualIdAsArray = DB::table('leadactuals')->select('id')->where([
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
                            ['weightActual', 'LIKE', '%' . $request->filter['weightActual'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['thicknessStartMinActual', '!=', null],
                            ['thicknessStartNomActual', '!=', null],
                            ['thicknessStartMaxActual', '!=', null],
                            ['thicknessEndMinActual', '!=', null],
                            ['thicknessEndNomActual', '!=', null],
                            ['thicknessEndMaxActual', '!=', null],
                            ['dimBefore1', '!=', null],
                            ['dimAfterStart', '!=', null],
                            ['dimAfterEnd', '!=', null],
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
                        $actualTimeRows = DB::table('leadactualstimes')->whereIn('leadactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {

                    $standardRow = DB::table('leadstandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                    $actualRows = DB::table('leadactuals')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('thicknessStartMinActual', null)
                        ->orWhere('thicknessStartNomActual', null)
                        ->orWhere('thicknessStartMaxActual', null)
                        ->orWhere('thicknessEndMinActual', null)
                        ->orWhere('thicknessEndNomActual', null)
                        ->orWhere('thicknessEndMaxActual', null)
                        ->orWhere('dimBefore1', null)
                        ->orWhere('dimAfterStart', null)
                        ->orWhere('dimAfterEnd', null)
                        ->orWhere('weightActual', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('leadactuals')->select('id')->where('machine', null)
                        ->orWhere('inputDrum', null)
                        ->orWhere('inputCard', null)
                        ->orWhere('inputLength', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('thicknessStartMinActual', null)
                        ->orWhere('thicknessStartNomActual', null)
                        ->orWhere('thicknessStartMaxActual', null)
                        ->orWhere('thicknessEndMinActual', null)
                        ->orWhere('thicknessEndNomActual', null)
                        ->orWhere('thicknessEndMaxActual', null)
                        ->orWhere('dimBefore1', null)
                        ->orWhere('dimAfterStart', null)
                        ->orWhere('dimAfterEnd', null)
                        ->orWhere('weightActual', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                    $actualTimeRows = DB::table('leadactualstimes')->whereIn('leadactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataLead(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('leadactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('leadactualstimes')->where('leadactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataLead(Request $request)
    {
        if ($request->ajax()) {
            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

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

            $rowDataLeadActual = LeadActual::where('id', '=', $request->id)
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
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataLeadActualTime = LeadActualsTimes::where('leadactuals_id', '=', $request->id)
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
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $leadActual = DB::table('leadactuals')->where('id', '=', $request->id)->first();
            $leadActualTime = DB::table('leadactualstimes')->where('leadactuals_id', '=', $request->id)->first();
            $leadStandard = DB::table('leadstandards')->where('id', $leadActual->jopOrderNumber_id)->first();
            $leadStandardTime = DB::table('leadstandardstimes')->where('leadstandards_id', $leadActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Lead'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $leadStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $leadStandard->size;
                    $hold->length = $request->outputLength[0];
                    $hold->description = $leadStandard->description;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Lead";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $leadStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->outputDrum[1];
                    $holdTime->cableSize_time = $leadStandardTime->size_time;
                    $holdTime->length_time = $request->outputLength[1];
                    $holdTime->description_time = $leadStandardTime->description_time;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Lead'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Lead'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->outputLength[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Lead",
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

            return array($leadActual, $leadActualTime);
        }
    }

    public function deleteDataLead(Request $request)
    {
        if ($request->ajax()) {
            $deleteActualTimeRow = DB::table('leadactualstimes')->where('leadactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('leadactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Lead')->exists();

            if (!$chickISO) {
                $leadISO = new ISO();
                $leadISO->sheet = "Lead";
                $leadISO->save();
            }


            $leadISO = DB::table('iso')->where('sheet', 'Lead')->get();
            return $leadISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Lead')->exists();

            if (!$chickISO) {

                $leadISO = new ISO();
                $leadISO->sheet = "Lead";
                $leadISO->issueNumber = $request->issueNumber;
                $leadISO->issueDate = $request->issueDate;
                $leadISO->modifiedDate = $request->modifiedDate;
                $leadISO->durationOfPreservation     = $request->durationOfPreservation;
                $leadISO->material = $request->material;
                $leadISO->save();
            } else {
                $leadISO = DB::table('iso')->where('sheet', 'Lead')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $leadISO = DB::table('iso')->where('sheet', 'Lead')->get();


            $result = $this->getDataLead($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $leadISO);

            return $result;
        }
    }
}
