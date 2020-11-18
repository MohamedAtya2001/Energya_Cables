<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public $drowingActuals;
    public $strandingActuals;
    public $insulationActuals;
    public $CCVInsulationActuals;
    public $screenActuals;
    public $assemblyActuals;
    public $beddingActuals;
    public $armouringActuals;
    public $leadActuals;
    public $tapsActuals;
    public $sheathingActuals;

    public function GetNullSheets()
    {
        $this->drowingActuals = DB::table('drowingactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('coilNumber', null)
            ->orWhere('wireDimMinActual', null)
            ->orWhere('elongationActual', null)
            ->orWhere('tensileActual', null)
            ->orWhere('cage', null)
            ->orWhere('outputCard', null)
            ->orWhere('visual', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->strandingActuals = DB::table('strandingactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('shape', null)
            ->orWhere('inputCard1', null)
            ->orWhere('cage1', null)
            ->orWhere('drumNumber', null)
            ->orWhere('outputCard', null)
            ->orWhere('length', null)
            ->orWhere('constructionActual', null)
            ->orWhere(function ($query) {
                $query->where([
                    ['conductorDimActual_HS1', null],
                    ['conductorDimActual_FI1', null]
                ]);
            })
            ->orWhere('ovality', null)
            ->orWhere('preformingLayActual', null)
            ->orWhere('waterBlockingTapActual', null)
            ->orWhere('resistance1', null)
            ->orWhere('layLengthDirection', null)
            ->orWhere('conductorweightActual', null)
            ->orWhere('layLengthActual', null)
            ->orWhere('powder_grease_weightActual', null)
            ->orWhere('visual', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->insulationActuals = DB::table('insulationactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('inputDrum', null)
            ->orWhere('inputCard', null)
            ->orWhere('inputLength', null)
            ->orWhere('outputDrum', null)
            ->orWhere('outputCard', null)
            ->orWhere('outputLength', null)
            ->orWhere('apperanceOfDrum', null)
            ->orWhere('colorActual', null)
            ->orWhere('message', null)
            ->orWhere('thicknessStartMinActual', null)
            ->orWhere('thicknessEndMinActual', null)
            ->orWhere('eccentricityActual', null)
            ->orWhere('dimBefore1', null)
            ->orWhere('dimAfterStartMin', null)
            ->orWhere('dimAfterEndMin', null)
            ->orWhere('weightActual', null)
            ->orWhere('materialActual', null)
            ->orWhere('ovalityActual1', null)
            ->orWhere('sparkActual', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->CCVInsulationActuals = DB::table('ccvinsulationactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('inputDrum', null)
            ->orWhere('inputCard', null)
            ->orWhere('inputLength', null)
            ->orWhere('outputDrum', null)
            ->orWhere('outputCard', null)
            ->orWhere('outputLength', null)
            ->orWhere('thicknessISCStartMin', null)
            ->orWhere('thicknessINSStartMin', null)
            ->orWhere('thicknessOSCStartMin', null)
            ->orWhere('thicknessISCEndMin', null)
            ->orWhere('thicknessINSEndMin', null)
            ->orWhere('thicknessOSCEndMin', null)
            ->orWhere('dimBefore1', null)
            ->orWhere('dimAfterStartMin', null)
            ->orWhere('dimAfterEndMin', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->screenActuals = DB::table('screenactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
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
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->assemblyActuals = DB::table('assemblyactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
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
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->beddingActuals = DB::table('beddingactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('inputDrum', null)
            ->orWhere('inputCard', null)
            ->orWhere('inputLength', null)
            ->orWhere('outputDrum', null)
            ->orWhere('outputCard', null)
            ->orWhere('outputLength', null)
            ->orWhere('colorActual', null)
            ->orWhere('thicknessStartMinActual', null)
            ->orWhere('thicknessEndMinActual', null)
            ->orWhere('eccentricityActual', null)
            ->orWhere('dimBefore1', null)
            ->orWhere('dimAfterStartMin', null)
            ->orWhere('dimAfterEndMin', null)
            ->orWhere('weightActual', null)
            ->orWhere('materialActual', null)
            ->orWhere('ovalityActual1', null)
            ->orWhere('sparkActual', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->armouringActuals = DB::table('armouringactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('inputDrum', null)
            ->orWhere('inputCard', null)
            ->orWhere('inputLength', null)
            ->orWhere('outputDrum', null)
            ->orWhere('outputCard', null)
            ->orWhere('outputLength', null)
            ->orWhere('ovalityActual', null)
            ->orWhere('dimAfterStartMin', null)
            ->orWhere('dimAfterEndNom', null)
            ->orWhere('wire_tape', null)
            ->orWhere('overGapActual', null)
            ->orWhere('direction', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->leadActuals = DB::table('leadactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
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
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        $this->tapsActuals = DB::table('tapsactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
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
            ->orWhere('productionOperator', null)
            ->get();


        /* =================================== */

        $this->sheathingActuals = DB::table('sheathingactuals')->select(
            'id',
            'jopOrderNumber',
        )->where('machine', null)
            ->orWhere('inputDrum', null)
            ->orWhere('inputCard', null)
            ->orWhere('inputLength', null)
            ->orWhere('outputDrum', null)
            ->orWhere('outputCard', null)
            ->orWhere('outputLength', null)
            ->orWhere('apperanceOfDrum', null)
            ->orWhere('colorActual', null)
            ->orWhere('message', null)
            ->orWhere('thicknessStartMinActual', null)
            ->orWhere('thicknessEndMinActual', null)
            ->orWhere('eccentricityActual', null)
            ->orWhere('dimBefore1', null)
            ->orWhere('dimAfterStartMin', null)
            ->orWhere('dimAfterEndMin', null)
            ->orWhere('weightActual', null)
            ->orWhere('materialActual', null)
            ->orWhere('ovalityActual1', null)
            ->orWhere('meterMeasuring', null)
            ->orWhere('sparkActual', null)
            ->orWhere('status', null)
            ->orWhere('productionOperator', null)
            ->get();

        /* =================================== */

        return [
            'drowing' => $this->drowingActuals,
            'stranding' => $this->strandingActuals,
            'insulation' => $this->insulationActuals,
            'bedding' => $this->beddingActuals,
            'sheathing' => $this->sheathingActuals,
            'screen' => $this->screenActuals,
            'armouring' => $this->armouringActuals,
            'taps' => $this->tapsActuals,
            'assembly' => $this->assemblyActuals,
            'Lead' => $this->leadActuals,
            'CCVInsulation' => $this->CCVInsulationActuals
        ];
    }

    public function index()
    {

        $this->GetNullSheets();

        return view('Admin.home')->with([
            'drowingActuals' => $this->drowingActuals,
            'strandingActuals' => $this->strandingActuals,
            'insulationActuals' => $this->insulationActuals,
            'beddingActuals' => $this->beddingActuals,
            'sheathingActuals' => $this->sheathingActuals,
            'screenActuals' => $this->screenActuals,
            'armouringActuals' => $this->armouringActuals,
            'tapsActuals' => $this->tapsActuals,
            'assemblyActuals' => $this->assemblyActuals,
            'leadActuals' => $this->leadActuals,
            'CCVInsulationActuals' => $this->CCVInsulationActuals
        ]);
    }

    public function getLabels()
    {
        $labels = DB::table("traceability")->select("label")->where("complete", false)->get();

        return $labels;
    }
}
