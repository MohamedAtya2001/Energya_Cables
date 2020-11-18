<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\RemarksRepots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StrandingReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function StrandingReport()
    {
        return view('Admin.Reports.Stranding_Report');
    }

    public $request;

    public function getDataStranding(Request $request)
    {
        if ($request->ajax()) {

            $this->request = $request;

            $from = $request->filter['periodOfTime']['start'];
            $to = $request->filter['periodOfTime']['end'];

            if ($from != "" && $to != "") {

                //To Get Stranding (Actual, ActualTime, Standard, StandardTime)
                $stranding = DB::table('strandingactuals')
                    ->join('strandingactualstimes', 'strandingactuals.id', '=', 'strandingactualstimes.strandingactuals_id')
                    ->join('strandingstandards', 'strandingstandards.id', '=', 'strandingactuals.jopOrderNumber_id')
                    ->join('strandingstandardstimes', 'strandingstandards.id', '=', 'strandingstandardstimes.strandingstandards_id')
                    ->where([
                        ['strandingstandards.size', 'LIKE', '%' . $request->filter['size'] . '%'],
                        ['strandingstandards.type', 'LIKE', '%' . $request->filter['type'] . '%'],
                        ['strandingactuals.shape', 'LIKE', '%' . $request->filter['shape'] . '%'],
                        ['strandingactuals.angel', 'LIKE', '%' . $request->filter['angel'] . '%']
                    ])
                    ->where(function ($query) {
                        if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                            $query->whereRaw('((strandingactuals.conductorWeightActual - strandingstandards.conductorWeightStandard) / strandingstandards.conductorWeightStandard) > ?', [0]);
                        } else if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                            $query->whereRaw('((strandingactuals.conductorWeightActual - strandingstandards.conductorWeightStandard) / strandingstandards.conductorWeightStandard) <= ?', [0]);
                        }
                    })
                    ->whereBetween('strandingactuals.created_at', [$from, $to])
                    ->skip($request->filter['limit'] - 25)->take(25)
                    ->select([
                        '*',
                        'strandingactuals.id AS id',
                        'strandingactuals.created_at AS created_at',
                        DB::raw('(((strandingactuals.conductorWeightActual - strandingstandards.conductorWeightStandard) / strandingstandards.conductorWeightStandard) * 100) AS weightDeviation'),
                        DB::raw('((IFNULL(strandingactuals.resistance1, 0) + IFNULL(strandingactuals.resistance2, 0) + IFNULL(strandingactuals.resistance3, 0) + IFNULL(strandingactuals.resistance4, 0)) / (IF( ISNULL(strandingactuals.resistance1) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance2) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance3) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance4) = 0, 1, 0))) AS avgResistance'),
                        DB::raw('(((((IFNULL(strandingactuals.resistance1, 0) + IFNULL(strandingactuals.resistance2, 0) + IFNULL(strandingactuals.resistance3, 0) + IFNULL(strandingactuals.resistance4, 0)) / (IF( ISNULL(strandingactuals.resistance1) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance2) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance3) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance4) = 0, 1, 0))) - IFNULL(strandingstandards.resistance, 0) ) / IFNULL(strandingstandards.resistance, 0)) * 100) AS resistanceDeviation')
                    ]);

                $countOfReportsRows = $stranding->count();
                $stranding = $stranding->skip($request->filter['limit'] - 25)->take(25)->get();

                $remarks = DB::table('remarksreports')->where('report_name', '=', 'stranding')->get();
            } else {

                //To Get Stranding (Actual, ActualTime, Standard, StandardTime)
                $stranding = DB::table('strandingactuals')
                    ->join('strandingactualstimes', 'strandingactuals.id', '=', 'strandingactualstimes.strandingactuals_id')
                    ->join('strandingstandards', 'strandingstandards.id', '=', 'strandingactuals.jopOrderNumber_id')
                    ->join('strandingstandardstimes', 'strandingstandards.id', '=', 'strandingstandardstimes.strandingstandards_id')
                    ->where([
                        ['strandingstandards.size', 'LIKE', '%' . $request->filter['size'] . '%'],
                        ['strandingstandards.type', 'LIKE', '%' . $request->filter['type'] . '%'],
                        ['strandingactuals.shape', 'LIKE', '%' . $request->filter['shape'] . '%'],
                        ['strandingactuals.angel', 'LIKE', '%' . $request->filter['angel'] . '%']
                    ])
                    ->where(function ($query) {
                        if ($this->request->filter['weightDeviation']['red'] == 'true' && $this->request->filter['weightDeviation']['green'] == 'false') {
                            $query->whereRaw('((strandingactuals.conductorWeightActual - strandingstandards.conductorWeightStandard) / strandingstandards.conductorWeightStandard) > ?', [0]);
                        } else if ($this->request->filter['weightDeviation']['red'] == 'false' && $this->request->filter['weightDeviation']['green'] == 'true') {
                            $query->whereRaw('((strandingactuals.conductorWeightActual - strandingstandards.conductorWeightStandard) / strandingstandards.conductorWeightStandard) <= ?', [0]);
                        }
                    })
                    ->select([
                        '*',
                        'strandingactuals.id AS id',
                        'strandingactuals.created_at AS created_at',
                        DB::raw('(((strandingactuals.conductorWeightActual - strandingstandards.conductorWeightStandard) / strandingstandards.conductorWeightStandard) * 100) AS weightDeviation'),
                        DB::raw('((IFNULL(strandingactuals.resistance1, 0) + IFNULL(strandingactuals.resistance2, 0) + IFNULL(strandingactuals.resistance3, 0) + IFNULL(strandingactuals.resistance4, 0)) / (IF( ISNULL(strandingactuals.resistance1) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance2) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance3) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance4) = 0, 1, 0))) AS avgResistance'),
                        DB::raw('(((((IFNULL(strandingactuals.resistance1, 0) + IFNULL(strandingactuals.resistance2, 0) + IFNULL(strandingactuals.resistance3, 0) + IFNULL(strandingactuals.resistance4, 0)) / (IF( ISNULL(strandingactuals.resistance1) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance2) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance3) = 0, 1, 0) + IF( ISNULL(strandingactuals.resistance4) = 0, 1, 0))) - IFNULL(strandingstandards.resistance, 0) ) / IFNULL(strandingstandards.resistance, 0)) * 100) AS resistanceDeviation')
                    ]);

                $countOfReportsRows = $stranding->count();
                $stranding = $stranding->skip($request->filter['limit'] - 25)->take(25)->get();

                $remarks = DB::table('remarksreports')->where('report_name', '=', 'stranding')->get();
            }

            return array($stranding, $remarks, $countOfReportsRows);
        }
    }

    public function printData(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataStranding($request);
        }
    }

    public function remark(Request $request)
    {
        if ($request->ajax()) {
            $remarksIsExist = DB::table('remarksreports')->where([
                ['report_id', $request->remark['report_id']],
                ['report_name', 'stranding']
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
                    ['report_name', 'stranding']
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
                ['report_name', 'stranding']
            ])->exists();
            if (!$remarksIsExist) {
                return '';
            } else {
                $remarkReport = DB::table('remarksreports')->where([
                    ['report_id', $request->report_id],
                    ['report_name', 'stranding']
                ])->first();
                return $remarkReport->remark;
            }
        }
    }
}
