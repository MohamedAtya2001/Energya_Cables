<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\RemarksRepots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExtrusionReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('Admin.Reports.Extrusion_Report');
    }

    public $request;

    public function getDataExtrusion(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {

                $insulation = [];
                $bedding = [];
                $sheathing = [];
                $countOfInsulationReportsRows = 0;
                $countOfBeddingReportsRows = 0;
                $countOfSheathingReportsRows = 0;
                $remarksOfInsulation = [];
                $remarksOfBedding = [];
                $remarksOfSheathing = [];

                if ($request->filter['process']['insulation'] == 'true') {

                    $insulation = DB::table("insulationactuals")
                        ->join('insulationstandards', 'insulationactuals.jopOrderNumber_id', '=', 'insulationstandards.id')
                        ->where([
                            ['insulationstandards.jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                            ['insulationstandards.cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                            ['insulationactuals.machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['insulationactuals.inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['insulationactuals.outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%']
                        ])->where(function ($query) {
                            if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                                $query->whereRaw('((insulationactuals.weightActual - insulationstandards.weightStandard) / insulationstandards.weightStandard) > ?', [0]);
                            }
                            if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                                $query->whereRaw('((insulationactuals.weightActual - insulationstandards.weightStandard) / insulationstandards.weightStandard) <= ?', [0]);
                            }
                        })
                        ->whereBetween('insulationactuals.created_at', [$from, $to])
                        ->select([
                            '*',
                            'insulationactuals.id AS id',
                            'insulationactuals.created_at AS created_at',
                            DB::raw('(((insulationactuals.weightActual - insulationstandards.weightStandard) / insulationstandards.weightStandard) * 100) AS weightDeviation')
                        ]);

                    $countOfInsulationReportsRows = $insulation->count();
                    $insulation = $insulation->skip($request->filter['insulationLimit'] - 25)->take(25)->get();

                    $remarksOfInsulation = DB::table('remarksreports')->where('report_name', '=', 'insulation')->get();
                }

                if ($request->filter['process']['bedding'] == 'true') {

                    $bedding = DB::table("beddingactuals")
                        ->join('beddingstandards', 'beddingactuals.jopOrderNumber_id', '=', 'beddingstandards.id')
                        ->where([
                            ['beddingstandards.jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                            ['beddingstandards.cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                            ['beddingactuals.machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['beddingactuals.inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['beddingactuals.outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%']
                        ])->where(function ($query) {
                            if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                                $query->whereRaw('((beddingactuals.weightActual - beddingstandards.weightStandard) / beddingstandards.weightStandard) > ?', [0]);
                            }
                            if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                                $query->whereRaw('((beddingactuals.weightActual - beddingstandards.weightStandard) / beddingstandards.weightStandard) <= ?', [0]);
                            }
                        })
                        ->whereBetween('beddingactuals.created_at', [$from, $to])
                        ->select([
                            '*',
                            'beddingactuals.id AS id',
                            'beddingactuals.created_at AS created_at',
                            DB::raw('(((beddingactuals.weightActual - beddingstandards.weightStandard) / beddingstandards.weightStandard) * 100) AS weightDeviation')
                        ]);

                    $countOfBeddingReportsRows = $bedding->count();
                    $bedding = $bedding->skip($request->filter['beddingLimit'] - 25)->take(25)->get();

                    $remarksOfBedding = DB::table('remarksreports')->where('report_name', '=', 'bedding')->get();
                }

                if ($request->filter['process']['sheathing'] == 'true') {

                    $sheathing = DB::table("sheathingactuals")
                        ->join('sheathingstandards', 'sheathingactuals.jopOrderNumber_id', '=', 'sheathingstandards.id')
                        ->where([
                            ['sheathingstandards.jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                            ['sheathingstandards.cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                            ['sheathingactuals.machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['sheathingactuals.inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['sheathingactuals.outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%']
                        ])->where(function ($query) {
                            if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                                $query->whereRaw('((sheathingactuals.weightActual - sheathingstandards.weightStandard) / sheathingstandards.weightStandard) > ?', [0]);
                            }
                            if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                                $query->whereRaw('((sheathingactuals.weightActual - sheathingstandards.weightStandard) / sheathingstandards.weightStandard) <= ?', [0]);
                            }
                        })
                        ->whereBetween('sheathingactuals.created_at', [$from, $to])
                        ->select([
                            '*',
                            'sheathingactuals.id AS id',
                            'sheathingactuals.created_at AS created_at',
                            DB::raw('(((sheathingactuals.weightActual - sheathingstandards.weightStandard) / sheathingstandards.weightStandard) * 100) AS weightDeviation')
                        ]);

                    $countOfSheathingReportsRows = $sheathing->count();
                    $sheathing = $sheathing->skip($request->filter['sheathingLimit'] - 25)->take(25)->get();

                    $remarksOfSheathing = DB::table('remarksreports')->where('report_name', '=', 'sheathing')->get();
                }
            } else {

                $insulation = [];
                $bedding = [];
                $sheathing = [];
                $countOfInsulationReportsRows = 0;
                $countOfBeddingReportsRows = 0;
                $countOfSheathingReportsRows = 0;
                $remarksOfInsulation = [];
                $remarksOfBedding = [];
                $remarksOfSheathing = [];

                if ($request->filter['process']['insulation'] == 'true') {

                    $insulation = DB::table("insulationactuals")
                        ->join('insulationstandards', 'insulationactuals.jopOrderNumber_id', '=', 'insulationstandards.id')
                        ->where([
                            ['insulationstandards.jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                            ['insulationstandards.cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                            ['insulationactuals.machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['insulationactuals.inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['insulationactuals.outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%']
                        ])->where(function ($query) {
                            if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                                $query->whereRaw('((insulationactuals.weightActual - insulationstandards.weightStandard) / insulationstandards.weightStandard) > ?', [0]);
                            }
                            if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                                $query->whereRaw('((insulationactuals.weightActual - insulationstandards.weightStandard) / insulationstandards.weightStandard) <= ?', [0]);
                            }
                        })
                        ->select([
                            '*',
                            'insulationactuals.id AS id',
                            'insulationactuals.created_at AS created_at',
                            DB::raw('(((insulationactuals.weightActual - insulationstandards.weightStandard) / insulationstandards.weightStandard) * 100) AS weightDeviation')
                        ]);

                    $countOfInsulationReportsRows = $insulation->count();
                    $insulation = $insulation->skip($request->filter['insulationLimit'] - 25)->take(25)->get();

                    $remarksOfInsulation = DB::table('remarksreports')->where('report_name', '=', 'insulation')->get();
                }

                if ($request->filter['process']['bedding'] == 'true') {

                    $bedding = DB::table("beddingactuals")
                        ->join('beddingstandards', 'beddingactuals.jopOrderNumber_id', '=', 'beddingstandards.id')
                        ->where([
                            ['beddingstandards.jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                            ['beddingstandards.cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                            ['beddingactuals.machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['beddingactuals.inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['beddingactuals.outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%']
                        ])->where(function ($query) {
                            if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                                $query->whereRaw('((beddingactuals.weightActual - beddingstandards.weightStandard) / beddingstandards.weightStandard) > ?', [0]);
                            }
                            if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                                $query->whereRaw('((beddingactuals.weightActual - beddingstandards.weightStandard) / beddingstandards.weightStandard) <= ?', [0]);
                            }
                        })
                        ->select([
                            '*',
                            'beddingactuals.id AS id',
                            'beddingactuals.created_at AS created_at',
                            DB::raw('(((beddingactuals.weightActual - beddingstandards.weightStandard) / beddingstandards.weightStandard) * 100) AS weightDeviation')
                        ]);

                    $countOfBeddingReportsRows = $bedding->count();
                    $bedding = $bedding->skip($request->filter['beddingLimit'] - 25)->take(25)->get();

                    $remarksOfBedding = DB::table('remarksreports')->where('report_name', '=', 'bedding')->get();
                }

                if ($request->filter['process']['sheathing'] == 'true') {

                    $sheathing = DB::table("sheathingactuals")
                        ->join('sheathingstandards', 'sheathingactuals.jopOrderNumber_id', '=', 'sheathingstandards.id')
                        ->where([
                            ['sheathingstandards.jopOrderNumber', 'LIKE', '%' . $request->filter['jopOrderNumber'] . '%'],
                            ['sheathingstandards.cableSize', 'LIKE', '%' . $request->filter['cableSize'] . '%'],
                            ['sheathingactuals.machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                            ['sheathingactuals.inputDrum', 'LIKE', '%' . $request->filter['inputDrum'] . '%'],
                            ['sheathingactuals.outputDrum', 'LIKE', '%' . $request->filter['outputDrum'] . '%']
                        ])->where(function ($query) {
                            if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                                $query->whereRaw('((sheathingactuals.weightActual - sheathingstandards.weightStandard) / sheathingstandards.weightStandard) > ?', [0]);
                            }
                            if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                                $query->whereRaw('((sheathingactuals.weightActual - sheathingstandards.weightStandard) / sheathingstandards.weightStandard) <= ?', [0]);
                            }
                        })
                        ->select([
                            '*',
                            'sheathingactuals.id AS id',
                            'sheathingactuals.created_at AS created_at',
                            DB::raw('(((sheathingactuals.weightActual - sheathingstandards.weightStandard) / sheathingstandards.weightStandard) * 100) AS weightDeviation')
                        ]);

                    $countOfSheathingReportsRows = $sheathing->count();
                    $sheathing = $sheathing->skip($request->filter['sheathingLimit'] - 25)->take(25)->get();

                    $remarksOfSheathing = DB::table('remarksreports')->where('report_name', '=', 'sheathing')->get();
                }
            }


            $extrusionReport = [
                'insulation' => array($insulation, $remarksOfInsulation, $countOfInsulationReportsRows),
                'bedding' => array($bedding, $remarksOfBedding, $countOfBeddingReportsRows),
                'sheathing' => array($sheathing, $remarksOfSheathing, $countOfSheathingReportsRows),
            ];

            return $extrusionReport;
        }
    }

    public function printData(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataExtrusion($request);
        }
    }

    public function remark(Request $request)
    {
        if ($request->ajax()) {
            $remarksIsExist = DB::table('remarksreports')->where([
                ['report_id', $request->remark['report_id']],
                ['report_name', $request->remark['report_name']]
            ])->exists();
            if (!$remarksIsExist) {
                $remarkReport = new RemarksRepots();
                $remarkReport->report_id = $request->remark['report_id'];
                $remarkReport->report_name = $request->remark['report_name'];
                $remarkReport->remark = $request->remark['remark'];
                $remarkReport->save();
            } else {
                $remarkReport = DB::table('remarksreports')->where([
                    ['report_id', $request->remark['report_id']],
                    ['report_name', $request->remark['report_name']]
                ])->update([
                    'remark' => $request->remark['remark']
                ]);
            }
        }
    }

    public function getRemark(Request $request)
    {
        if ($request->ajax()) {
            $remarksIsExist = DB::table('remarksreports')->where([
                ['report_id', $request->report_id],
                ['report_name', $request->report_name]
            ])->exists();
            if (!$remarksIsExist) {
                return '';
            } else {
                $remarkReport = DB::table('remarksreports')->where([
                    ['report_id', $request->report_id],
                    ['report_name', $request->report_name]
                ])->first();
                return $remarkReport->remark;
            }
        }
    }
}
