<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\AssemblyActual;
use App\AssemblyActualsTimes;
use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowAssemblyActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataAssembly()
    {
        return view('Admin.ShowData.Actual.show_actual_assembly');
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

    public function getDataAssembly(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $checkJopOrderNumber = DB::table('assemblystandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('assemblystandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('assemblyactuals')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['outerDimMinActual', '!=', null],
                            ['ovalityActual', '!=', null],
                            ['layLengthActual', '!=', null],
                            ['direction', '!=', null],
                            ['fillerActual', '!=', null],
                            ['twistedActual', '!=', null],
                            ['ppTapeSize', '!=', null]
                        ])
                            ->where(function ($query) {
                                $query->where('inputDrum1', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum2', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum3', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum4', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum5', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard5', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputLength1', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength2', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength3', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength4', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength5', 'LIKE', '%' . $this->request->filter['inputLength'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('color1', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color2', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color3', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color4', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color5', 'LIKE', '%' . $this->request->filter['color'] . '%');
                            })
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

                        $actualIdAsArray = DB::table('assemblyactuals')->select('id')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['outerDimMinActual', '!=', null],
                            ['ovalityActual', '!=', null],
                            ['layLengthActual', '!=', null],
                            ['direction', '!=', null],
                            ['fillerActual', '!=', null],
                            ['twistedActual', '!=', null],
                            ['ppTapeSize', '!=', null]
                        ])
                            ->where(function ($query) {
                                $query->where('inputDrum1', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum2', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum3', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum4', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum5', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard5', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputLength1', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength2', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength3', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength4', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength5', 'LIKE', '%' . $this->request->filter['inputLength'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('color1', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color2', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color3', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color4', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color5', 'LIKE', '%' . $this->request->filter['color'] . '%');
                            })
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
                        $actualTimeRows = DB::table('assemblyactualstimes')->whereIn('assemblyactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('assemblystandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                        $actualRows = DB::table('assemblyactuals')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['outerDimMinActual', '!=', null],
                            ['ovalityActual', '!=', null],
                            ['layLengthActual', '!=', null],
                            ['direction', '!=', null],
                            ['fillerActual', '!=', null],
                            ['twistedActual', '!=', null],
                            ['ppTapeSize', '!=', null]
                        ])
                            ->where(function ($query) {
                                $query->where('inputDrum1', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum2', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum3', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum4', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum5', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard5', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputLength1', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength2', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength3', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength4', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength5', 'LIKE', '%' . $this->request->filter['inputLength'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('color1', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color2', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color3', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color4', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color5', 'LIKE', '%' . $this->request->filter['color'] . '%');
                            })
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

                        $actualIdAsArray = DB::table('assemblyactuals')->select('id')->where([
                            ['jopOrderNumber', $request->filter['jopOrderNumber']],
                            ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                            ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                            ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%'],
                            ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                            ['outputLength', 'LIKE', '%' . $request->filter['outputLength'] . '%'],
                            ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                            ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                            ['outerDimMinActual', '!=', null],
                            ['ovalityActual', '!=', null],
                            ['layLengthActual', '!=', null],
                            ['direction', '!=', null],
                            ['fillerActual', '!=', null],
                            ['twistedActual', '!=', null],
                            ['ppTapeSize', '!=', null]
                        ])
                            ->where(function ($query) {
                                $query->where('inputDrum1', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum2', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum3', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum4', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%')
                                    ->orWhere('inputDrum5', 'LIKE', '%' . $this->request->filter['inputDrum'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard5', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('inputLength1', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength2', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength3', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength4', 'LIKE', '%' . $this->request->filter['inputLength'] . '%')
                                    ->orWhere('inputLength5', 'LIKE', '%' . $this->request->filter['inputLength'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('color1', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color2', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color3', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color4', 'LIKE', '%' . $this->request->filter['color'] . '%')
                                    ->orWhere('color5', 'LIKE', '%' . $this->request->filter['color'] . '%');
                            })
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
                        $actualTimeRows = DB::table('assemblyactualstimes')->whereIn('assemblyactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {
                    $standardRow = DB::table('assemblystandards')->where('jopOrderNumber', $request->filter['jopOrderNumber'])->get();
                    $actualRows = DB::table('assemblyactuals')->where('machine', null)
                        ->orWhere('inputDrum1', null)
                        ->orWhere('inputCard1', null)
                        ->orWhere('inputLength1', null)
                        ->orWhere('color1', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('outerDimMinActual', null)
                        ->orWhere('ovalityActual', null)
                        ->orWhere('layLengthActual', null)
                        ->orWhere('direction', null)
                        ->orWhere('fillerActual', null)
                        ->orWhere('twistedActual', null)
                        ->orWhere('ppTapeSize', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('assemblyactuals')->select('id')->where('machine', null)
                        ->orWhere('inputDrum1', null)
                        ->orWhere('inputCard1', null)
                        ->orWhere('inputLength1', null)
                        ->orWhere('color1', null)
                        ->orWhere('outputDrum', null)
                        ->orWhere('outputCard', null)
                        ->orWhere('outputLength', null)
                        ->orWhere('outerDimMinActual', null)
                        ->orWhere('ovalityActual', null)
                        ->orWhere('layLengthActual', null)
                        ->orWhere('direction', null)
                        ->orWhere('fillerActual', null)
                        ->orWhere('twistedActual', null)
                        ->orWhere('ppTapeSize', null)
                        ->orWhere('status', null)
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                    $actualTimeRows = DB::table('assemblyactualstimes')->whereIn('assemblyactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataAssembly(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('assemblyactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('assemblyactualstimes')->where('assemblyactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataAssembly(Request $request)
    {

        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            $regex_color = "/^([A-z]+)?$/";

            if (
                empty($request->inputDrum1[0]) &&
                (!empty($request->inputDrum2[0]) || !empty($request->inputDrum3[0]) || !empty($request->inputDrum4[0]) || !empty($request->inputDrum5[0]))
            ) {
                return 'Error-inputDrum1';
            }

            if (
                empty($request->inputCard1[0]) &&
                (!empty($request->inputCard2[0]) || !empty($request->inputCard3[0]) || !empty($request->inputCard4[0]) || !empty($request->inputCard5[0]))
            ) {
                return 'Error-inputCard1';
            }

            if (
                empty($request->inputLength1[0]) &&
                (!empty($request->inputLength2[0]) || !empty($request->inputLength3[0]) || !empty($request->inputLength4[0]) || !empty($request->inputLength5[0]))
            ) {
                return 'Error-inputLength1';
            }

            if (!preg_match($regex_color, $request->color1[0]) || (empty($request->color1[0]) && (!empty($request->color2[0]) || !empty($request->color3[0]) || !empty($request->color4[0]) || !empty($request->color5[0])))) {
                return "Error-color1";
            }

            if (!preg_match($regex_color, $request->color2[0])) {
                return "Error-color2";
            }

            if (!preg_match($regex_color, $request->color3[0])) {
                return "Error-color3";
            }

            if (!preg_match($regex_color, $request->color4[0])) {
                return "Error-color4";
            }

            if (!preg_match($regex_color, $request->color5[0])) {
                return "Error-color5";
            }

            if (
                (empty($request->outerDimMinActual[0]) || empty($request->outerDimNomActual[0]) || empty($request->outerDimMaxActual[0])) &&
                (!empty($request->outerDimMinActual[0]) || !empty($request->outerDimNomActual[0]) || !empty($request->outerDimMaxActual[0]))
            ) {
                return 'Error-outerDimActual';
            }

            if (
                (empty($request->ppTapeSize[0]) || empty($request->ppTapeOverLap[0])) &&
                (!empty($request->ppTapeSize[0]) || !empty($request->ppTapeOverLap[0]))
            ) {
                return 'Error-ppTape';
            }

            //To Return Error-notes is Required if Status is Hold
            if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                return 'Error-notes';
            }

            $rowDataAssemblyActual = AssemblyActual::where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'inputDrum1' => $request->inputDrum1[0],
                    'inputDrum2' => $request->inputDrum2[0],
                    'inputDrum3' => $request->inputDrum3[0],
                    'inputDrum4' => $request->inputDrum4[0],
                    'inputDrum5' => $request->inputDrum5[0],
                    'inputCard1' => $request->inputCard1[0],
                    'inputCard2' => $request->inputCard2[0],
                    'inputCard3' => $request->inputCard3[0],
                    'inputCard4' => $request->inputCard4[0],
                    'inputCard5' => $request->inputCard5[0],
                    'inputLength1' => $request->inputLength1[0],
                    'inputLength2' => $request->inputLength2[0],
                    'inputLength3' => $request->inputLength3[0],
                    'inputLength4' => $request->inputLength4[0],
                    'inputLength5' => $request->inputLength5[0],
                    'color1' => $request->color1[0],
                    'color2' => $request->color2[0],
                    'color3' => $request->color3[0],
                    'color4' => $request->color4[0],
                    'color5' => $request->color5[0],
                    'outputDrum' => $request->outputDrum[0],
                    'outputCard' => $request->outputCard[0],
                    'outputLength' => $request->outputLength[0],
                    'outerDimMinActual' => $request->outerDimMinActual[0],
                    'outerDimNomActual' => $request->outerDimNomActual[0],
                    'outerDimMaxActual' => $request->outerDimMaxActual[0],
                    'ovalityActual' => $request->ovalityActual[0],
                    'layLengthActual' => $request->layLengthActual[0],
                    'direction' => $request->direction[0],
                    'fillerActual' => $request->fillerActual[0],
                    'twistedActual' => $request->twistedActual[0],
                    'ppTapeSize' => $request->ppTapeSize[0],
                    'ppTapeOverLap' => $request->ppTapeOverLap[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataAssemblyActualTime = AssemblyActualsTimes::where('assemblyactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'inputDrum1_time' => $request->inputDrum1[1],
                    'inputDrum2_time' => $request->inputDrum2[1],
                    'inputDrum3_time' => $request->inputDrum3[1],
                    'inputDrum4_time' => $request->inputDrum4[1],
                    'inputDrum5_time' => $request->inputDrum5[1],
                    'inputCard1_time' => $request->inputCard1[1],
                    'inputCard2_time' => $request->inputCard2[1],
                    'inputCard3_time' => $request->inputCard3[1],
                    'inputCard4_time' => $request->inputCard4[1],
                    'inputCard5_time' => $request->inputCard5[1],
                    'inputLength1_time' => $request->inputLength1[1],
                    'inputLength2_time' => $request->inputLength2[1],
                    'inputLength3_time' => $request->inputLength3[1],
                    'inputLength4_time' => $request->inputLength4[1],
                    'inputLength5_time' => $request->inputLength5[1],
                    'color1_time' => $request->color1[1],
                    'color2_time' => $request->color2[1],
                    'color3_time' => $request->color3[1],
                    'color4_time' => $request->color4[1],
                    'color5_time' => $request->color5[1],
                    'outputDrum_time' => $request->outputDrum[1],
                    'outputCard_time' => $request->outputCard[1],
                    'outputLength_time' => $request->outputLength[1],
                    'outerDimMinActual_time' => $request->outerDimMinActual[1],
                    'outerDimNomActual_time' => $request->outerDimNomActual[1],
                    'outerDimMaxActual_time' => $request->outerDimMaxActual[1],
                    'ovalityActual_time' => $request->ovalityActual[1],
                    'layLengthActual_time' => $request->layLengthActual[1],
                    'direction_time' => $request->direction[1],
                    'fillerActual_time' => $request->fillerActual[1],
                    'twistedActual_time' => $request->twistedActual[1],
                    'ppTapeSize_time' => $request->ppTapeSize[1],
                    'ppTapeOverLap_time' => $request->ppTapeOverLap[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            //GET Standard To Create Hold
            $assemblyActual = DB::table('assemblyactuals')->where('id', '=', $request->id)->first();
            $assemblyActualTime = DB::table('assemblyactualstimes')->where('assemblyactuals_id', '=', $request->id)->first();
            $assemblyStandard = DB::table('assemblystandards')->where('id', $assemblyActual->jopOrderNumber_id)->first();
            $assemblyStandardTime = DB::table('assemblystandardstimes')->where('assemblystandards_id', $assemblyActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Assembly'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $assemblyStandard->jopOrderNumber;
                    $hold->drumNumber = $request->outputDrum[0];
                    $hold->cableSize = $assemblyStandard->cableSize;
                    $hold->length = $request->layLengthActual[0];
                    $hold->description = $assemblyStandard->cableDescription;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Assembly";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $hold->jopOrderNumber = $assemblyStandardTime->jopOrderNumber_time;
                    $hold->drumNumber = $request->outputDrum[1];
                    $hold->cableSize = $assemblyStandardTime->cableSize_time;
                    $hold->length = $request->layLengthActual[1];
                    $hold->description = $assemblyStandardTime->cableDescription_time;
                    $hold->machine = $request->machine[1];
                    $hold->reasonOfHold = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Assembly'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Assembly'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->outputDrum[0],
                            'length' => $request->layLengthActual[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Assembly",
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);

                    $holdTime = DB::table('holdtimes')
                        ->where('hold_id', $dataOfHold->id)
                        ->update([
                            'drumNumber_time' => $request->outputDrum[1],
                            'length_time' => $request->layLengthActual[1],
                            'machine_time' => $request->machine[1],
                            'reasonOfHold_time' =>  $request->notes[1],
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);
                }
            }

            return array($assemblyActual, $assemblyActualTime);
        }
    }

    public function deleteDataAssembly(Request $request)
    {
        if ($request->ajax()) {

            $actual = DB::table('assemblyactuals')->where('id', $request->rowId)->first();

            $traceability = DB::table("traceability")->where([
                ['jopOrderNumber', $actual->jopOrderNumber],
                ['outputCard', $actual->outputCard]
            ]);

            if ($traceability->exists()) {
                $chain = unserialize($traceability->first()->chain);
                array_pop($chain);

                $traceability->update([
                    "outputCard" => $chain[count($chain) - 1],
                    "chain" => serialize($chain),
                    "assembly_id" => null
                ]);
            } else {
                return "Error";
            }

            $deleteActualTimeRow = DB::table('assemblyactualstimes')->where('assemblyactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('assemblyactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Assembly')->exists();

            if (!$chickISO) {
                $assemblyISO = new ISO();
                $assemblyISO->sheet = "Assembly";
                $assemblyISO->save();
            }


            $assemblyISO = DB::table('iso')->where('sheet', 'Assembly')->get();
            return $assemblyISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Assembly')->exists();

            if (!$chickISO) {

                $assemblyISO = new ISO();
                $assemblyISO->sheet = "Assembly";
                $assemblyISO->issueNumber = $request->issueNumber;
                $assemblyISO->issueDate = $request->issueDate;
                $assemblyISO->modifiedDate = $request->modifiedDate;
                $assemblyISO->durationOfPreservation     = $request->durationOfPreservation;
                $assemblyISO->material = $request->material;
                $assemblyISO->save();
            } else {
                $assemblyISO = DB::table('iso')->where('sheet', 'Assembly')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $assemblyISO = DB::table('iso')->where('sheet', 'Assembly')->get();


            $result = $this->getDataAssembly($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $assemblyISO);

            return $result;
        }
    }
}
