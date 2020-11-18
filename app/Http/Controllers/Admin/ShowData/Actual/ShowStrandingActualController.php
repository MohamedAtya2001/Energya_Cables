<?php

namespace App\Http\Controllers\Admin\ShowData\Actual;

use App\Hold;
use App\HoldTime;
use App\Http\Controllers\Controller;
use App\ISO;
use App\StrandingActual;
use App\StrandingActualsTimes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShowStrandingActualController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showDataStranding()
    {
        return view('Admin.ShowData.Actual.show_actual_stranding');
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

    public function getDataStranding(Request $request)
    {

        if ($request->ajax()) {

            //To Access Prameter Inside CallBack Function
            $this->request = $request;

            $checkJopOrderNumber = DB::table('strandingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->exists();

            if (!$checkJopOrderNumber) {
                return "Not Found";
            } else {

                if ($request->filter['sheetsType'] == 'complete') {

                    $from = $request->filter['periodOfTime']['start'];
                    $to = $request->filter['periodOfTime']['end'];

                    if ($from != "" && $to != "") {
                        $standardRow = DB::table('strandingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                        $actualRows = DB::table('strandingactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['shape', 'LIKE', '%' . $request->filter['shape'] . '%'],
                                ['angel', 'LIKE', '%' . $request->filter['angel'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['length', 'LIKE', '%' . $request->filter['length'] . '%'],
                                ['constructionActual', 'LIKE', '%' . $request->filter['constructionActual'] . '%'],
                                ['conductorWeightActual', 'LIKE', '%' . $request->filter['conductorWeightActual'] . '%'],
                                ['cage1', '!=', null],
                                ['ovality', '!=', null],
                                ['preformingLayActual', '!=', null],
                                ['waterBlockingTapActual', '!=', null],
                                ['layLengthDirection', '!=', null],
                                ['layLengthActual', '!=', null],
                                ['powder_grease_weightActual', '!=', null],
                                ['visual', '!=', null]
                            ])
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('conductorDimActual_HS1', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS2', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS3', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS4', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%');
                                    });
                                })
                                    ->orWhere(function ($query) {
                                        $query->where(function ($query) {
                                            $query->where('conductorDimActual_FI1', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI2', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI3', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI4', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%');
                                        });
                                    });
                            })
                            ->where(function ($query) {
                                $query->where('resistance1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('length1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%');
                            })
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })
                            ->where(function ($query) {
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

                        $actualIdAsArray = DB::table('strandingactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['shape', 'LIKE', '%' . $request->filter['shape'] . '%'],
                                ['angel', 'LIKE', '%' . $request->filter['angel'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['length', 'LIKE', '%' . $request->filter['length'] . '%'],
                                ['constructionActual', 'LIKE', '%' . $request->filter['constructionActual'] . '%'],
                                ['conductorWeightActual', 'LIKE', '%' . $request->filter['conductorWeightActual'] . '%'],
                                ['cage1', '!=', null],
                                ['ovality', '!=', null],
                                ['preformingLayActual', '!=', null],
                                ['waterBlockingTapActual', '!=', null],
                                ['layLengthDirection', '!=', null],
                                ['layLengthActual', '!=', null],
                                ['powder_grease_weightActual', '!=', null],
                                ['visual', '!=', null]
                            ])
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('conductorDimActual_HS1', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS2', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS3', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS4', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%');
                                    });
                                })
                                    ->orWhere(function ($query) {
                                        $query->where(function ($query) {
                                            $query->where('conductorDimActual_FI1', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI2', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI3', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI4', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%');
                                        });
                                    });
                            })
                            ->where(function ($query) {
                                $query->where('resistance1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('length1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%');
                            })
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })
                            ->where(function ($query) {
                                if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                    $query->where('status', 'hold');
                                } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'pass');
                                } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'hold')
                                        ->orWhere('status', 'pass');
                                }
                            })->whereBetween('created_at', [$from, $to])->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();
                        $actualTimeRows = DB::table('strandingactualstimes')->whereIn('strandingactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    } else {
                        $standardRow = DB::table('strandingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                        $actualRows = DB::table('strandingactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['shape', 'LIKE', '%' . $request->filter['shape'] . '%'],
                                ['angel', 'LIKE', '%' . $request->filter['angel'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['length', 'LIKE', '%' . $request->filter['length'] . '%'],
                                ['constructionActual', 'LIKE', '%' . $request->filter['constructionActual'] . '%'],
                                ['conductorWeightActual', 'LIKE', '%' . $request->filter['conductorWeightActual'] . '%'],
                                ['cage1', '!=', null],
                                ['ovality', '!=', null],
                                ['preformingLayActual', '!=', null],
                                ['waterBlockingTapActual', '!=', null],
                                ['layLengthDirection', '!=', null],
                                ['layLengthActual', '!=', null],
                                ['powder_grease_weightActual', '!=', null],
                                ['visual', '!=', null]
                            ])
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('conductorDimActual_HS1', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS2', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS3', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS4', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%');
                                    });
                                })
                                    ->orWhere(function ($query) {
                                        $query->where(function ($query) {
                                            $query->where('conductorDimActual_FI1', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI2', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI3', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI4', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%');
                                        });
                                    });
                            })
                            ->where(function ($query) {
                                $query->where('resistance1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('length1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%');
                            })
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })
                            ->where(function ($query) {
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

                        $actualIdAsArray = DB::table('strandingactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                            ->where([
                                ['shift', 'LIKE', '%' . $request->filter['shift'] . '%'],
                                ['added_by', 'LIKE', '%' . $request->filter['added_by'] . '%'],
                                ['machine', 'LIKE', '%' . $request->filter['machine'] . '%'],
                                ['shape', 'LIKE', '%' . $request->filter['shape'] . '%'],
                                ['angel', 'LIKE', '%' . $request->filter['angel'] . '%'],
                                ['productionOperator', 'LIKE', '%' . $request->filter['productionOperator'] . '%'],
                                ['updated_by', 'LIKE', '%' . $request->filter['updated_by'] . '%'],
                                ['drumNumber', 'LIKE', '%' . $request->filter['drumNumber'] . '%'],
                                ['outputCard', 'LIKE', '%' . $request->filter['outputCard'] . '%'],
                                ['length', 'LIKE', '%' . $request->filter['length'] . '%'],
                                ['constructionActual', 'LIKE', '%' . $request->filter['constructionActual'] . '%'],
                                ['conductorWeightActual', 'LIKE', '%' . $request->filter['conductorWeightActual'] . '%'],
                                ['cage1', '!=', null],
                                ['ovality', '!=', null],
                                ['preformingLayActual', '!=', null],
                                ['waterBlockingTapActual', '!=', null],
                                ['layLengthDirection', '!=', null],
                                ['layLengthActual', '!=', null],
                                ['powder_grease_weightActual', '!=', null],
                                ['visual', '!=', null]
                            ])
                            ->where(function ($query) {
                                $query->where('inputCard1', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard2', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard3', 'LIKE', '%' . $this->request->filter['inputCard'] . '%')
                                    ->orWhere('inputCard4', 'LIKE', '%' . $this->request->filter['inputCard'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where(function ($query) {
                                    $query->where(function ($query) {
                                        $query->where('conductorDimActual_HS1', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS2', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS3', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%')
                                            ->orWhere('conductorDimActual_HS4', 'LIKE', '%' . $this->request->filter['conductorDimActual_HS'] . '%');
                                    });
                                })
                                    ->orWhere(function ($query) {
                                        $query->where(function ($query) {
                                            $query->where('conductorDimActual_FI1', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI2', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI3', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%')
                                                ->orWhere('conductorDimActual_FI4', 'LIKE', '%' . $this->request->filter['conductorDimActual_FI'] . '%');
                                        });
                                    });
                            })
                            ->where(function ($query) {
                                $query->where('resistance1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%')
                                    ->orWhere('resistance4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['resistance'] . '%');
                            })
                            ->where(function ($query) {
                                $query->where('length1', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length2', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length3', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%')
                                    ->orWhere('length4', 'LIKE', '%' . $this->request->filter['resistanceAtLength']['length'] . '%');
                            })
                            ->where(function ($query) {
                                if ($this->request->filter['notes'] == 'true') {
                                    $query->where('notes', '!=', '');
                                }
                            })
                            ->where(function ($query) {
                                if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'false') {
                                    $query->where('status', 'hold');
                                } else if ($this->request->filter['status']['hold'] == 'false' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'pass');
                                } else if ($this->request->filter['status']['hold'] == 'true' && $this->request->filter['status']['pass'] == 'true') {
                                    $query->where('status', 'hold')
                                        ->orWhere('status', 'pass');
                                }
                            })->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                        $actualTimeRows = DB::table('strandingactualstimes')->whereIn('strandingactuals_id', $actualIdAsArray)->get();

                        return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                    }
                } else {

                    $standardRow = DB::table('strandingstandards')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])->get();

                    $actualRows = DB::table('strandingactuals')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                        ->where('machine', null)
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
                        ->orWhere('productionOperator', null);

                    $countOfActualsRows = $actualRows->get()->count();
                    $actualRowsLimit = $actualRows->skip($request->filter['limit'] - 25)->take(25)->get();

                    $actualIdAsArray = DB::table('strandingactuals')->select('id')->whereIn('jopOrderNumber', [$request->filter['jopOrderNumber'], $request->filter['subJopOrderNumber']])
                        ->where('machine', null)
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
                        ->orWhere('productionOperator', null)->skip($request->filter['limit'] - 25)->take(25)->pluck('id')->toArray();

                    $actualTimeRows = DB::table('strandingactualstimes')->whereIn('strandingactuals_id', $actualIdAsArray)->get();

                    return array($standardRow, $actualRowsLimit, $actualTimeRows, $countOfActualsRows);
                }
            }
        }
    }

    public function getRowToEditDataStranding(Request $request)
    {
        if ($request->ajax()) {


            $actualRow = DB::table('strandingactuals')->where('id', $request->rowId)->get()[0];
            $actualTimeRow = DB::table('strandingactualstimes')->where('strandingactuals_id', $request->rowId)->get()[0];

            return array($actualRow, $actualTimeRow);
        }
    }

    public function editDataStranding(Request $request)
    {

        if ($request->ajax()) {

            $shiftOfAdminWhoMadeUpdate = 'shift ' . $this->currentShift();

            //To Check About "who did make Update ?"
            $nameOfAdminWhoMadeUpdate = Auth::guard('admin')->user()->name;

            $regex_angel = "/^[0-9.]+$/";
            $regex_conductorDimActual_HS = "/^([0-9.]+\*[0-9.]+)?$/";

            if ($request->shape[0] == "Sector" && !preg_match($regex_angel, $request->angel[0])) {
                return "Error-angel";
            }

            if (
                empty($request->inputCard1[0]) &&
                (!empty($request->inputCard2[0]) || !empty($request->inputCard3[0]) || !empty($request->inputCard4[0]))
            ) {
                return 'Error-inputCard1';
            }

            if (
                empty($request->cage1[0]) &&
                (!empty($request->cage2[0]) || !empty($request->cage3[0]) || !empty($request->cage4[0]))
            ) {
                return 'Error-cage1';
            }

            if (
                (empty($request->conductorDimActual_HS1[0]) && (!empty($request->conductorDimActual_HS2[0]) || !empty($request->conductorDimActual_HS3[0]) || !empty($request->conductorDimActual_HS4[0])))
                ||
                (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS1[0]))
            ) {
                return 'Error-conductorDimActual_HS1';
            }

            if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS2[0])) {
                return "Error-conductorDimActual_HS2";
            }

            if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS3[0])) {
                return "Error-conductorDimActual_HS3";
            }

            if (!preg_match($regex_conductorDimActual_HS, $request->conductorDimActual_HS4[0])) {
                return "Error-conductorDimActual_HS4";
            }

            if (
                empty($request->conductorDimActual_FI1[0]) &&
                (!empty($request->conductorDimActual_FI2[0]) || !empty($request->conductorDimActual_FI3[0]) || !empty($request->conductorDimActual_FI4[0]))
            ) {
                return 'Error-conductorDimActual_FI1';
            }

            if (
                (
                    (empty($request->resistance1[0]) || empty($request->length1[0])) &&
                    (!empty($request->resistance1[0]) || !empty($request->length1[0]))) ||
                (
                    (empty($request->resistance1[0]) && empty($request->length1[0])) &&
                    (
                        (!empty($request->resistance2[0]) && !empty($request->length2[0])) ||
                        (!empty($request->resistance3[0]) && !empty($request->length3[0])) ||
                        (!empty($request->resistance4[0]) && !empty($request->length4[0]))))
            ) {
                return 'Error-resistanceAtLength1';
            }

            if (
                (empty($request->resistance2[0]) || empty($request->length2[0])) &&
                (!empty($request->resistance2[0]) || !empty($request->length2[0]))
            ) {
                return 'Error-resistanceAtLength2';
            }

            if (
                (empty($request->resistance3[0]) || empty($request->length3[0])) &&
                (!empty($request->resistance3[0]) || !empty($request->length3[0]))
            ) {
                return 'Error-resistanceAtLength3';
            }

            if (
                (empty($request->resistance4[0]) || empty($request->length4[0])) &&
                (!empty($request->resistance4[0]) || !empty($request->length4[0]))
            ) {
                return 'Error-resistanceAtLength4';
            }

            //To Return Error-notes is Required if Status is Hold
            if (($request->status[0]) == 'hold' && empty($request->notes[0])) {
                return 'Error-notes';
            }

            $rowDataStrandingActual = DB::table('strandingactuals')
                ->where('id', '=', $request->id)
                ->update([
                    'machine' => $request->machine[0],
                    'shape' => $request->shape[0],
                    'angel' => ($request->shape[0] == "Sector") ? $request->angel[0] : "",
                    'inputCard1' => $request->inputCard1[0],
                    'inputCard2' => $request->inputCard2[0],
                    'inputCard3' => $request->inputCard3[0],
                    'inputCard4' => $request->inputCard4[0],
                    'cage1' => $request->cage1[0],
                    'cage2' => $request->cage2[0],
                    'cage3' => $request->cage3[0],
                    'cage4' => $request->cage4[0],
                    'drumNumber' => $request->drumNumber[0],
                    'outputCard' => $request->outputCard[0],
                    'length' => $request->length[0],
                    'constructionActual' => $request->constructionActual[0],
                    'conductorDimActual_HS1' => $request->conductorDimActual_HS1[0],
                    'conductorDimActual_HS2' => $request->conductorDimActual_HS2[0],
                    'conductorDimActual_HS3' => $request->conductorDimActual_HS3[0],
                    'conductorDimActual_HS4' => $request->conductorDimActual_HS4[0],
                    'conductorDimActual_FI1' => $request->conductorDimActual_FI1[0],
                    'conductorDimActual_FI2' => $request->conductorDimActual_FI2[0],
                    'conductorDimActual_FI3' => $request->conductorDimActual_FI3[0],
                    'conductorDimActual_FI4' => $request->conductorDimActual_FI4[0],
                    'ovality' => $request->ovality[0],
                    'preformingLayActual' => $request->preformingLayActual[0],
                    'waterBlockingTapActual' => $request->waterBlockingTapActual[0],
                    'layLengthDirection' => $request->layLengthDirection[0],
                    'resistance1' => $request->resistance1[0],
                    'length1' => $request->length1[0],
                    'resistance2' => $request->resistance2[0],
                    'length2' => $request->length2[0],
                    'resistance3' => $request->resistance3[0],
                    'length3' => $request->length3[0],
                    'resistance4' => $request->resistance4[0],
                    'length4' => $request->length4[0],
                    'conductorWeightActual' => $request->conductorWeightActual[0],
                    'layLengthActual' => $request->layLengthActual[0],
                    'powder_grease_weightActual' => $request->powder_grease_weightActual[0],
                    'visual' => $request->visual[0],
                    'status' => $request->status[0],
                    'productionOperator' => $request->productionOperator[0],
                    'notes' => $request->notes[0],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);

            $rowDataStrandingActualTime = DB::table('strandingactualstimes')
                ->where('strandingactuals_id', '=', $request->id)
                ->update([
                    'machine_time' => $request->machine[1],
                    'shape_time' => $request->shape[1],
                    'angel_time' => ($request->shape[0] == "Sector") ? $request->angel[1] : "",
                    'inputCard1_time' => $request->inputCard1[1],
                    'inputCard2_time' => $request->inputCard2[1],
                    'inputCard3_time' => $request->inputCard3[1],
                    'inputCard4_time' => $request->inputCard4[1],
                    'cage1_time' => $request->cage1[1],
                    'cage2_time' => $request->cage2[1],
                    'cage3_time' => $request->cage3[1],
                    'cage4_time' => $request->cage4[1],
                    'drumNumber_time' => $request->drumNumber[1],
                    'outputCard_time' => $request->outputCard[1],
                    'length_time' => $request->length[1],
                    'constructionActual_time' => $request->constructionActual[1],
                    'conductorDimActual_HS1_time' => $request->conductorDimActual_HS1[1],
                    'conductorDimActual_HS2_time' => $request->conductorDimActual_HS2[1],
                    'conductorDimActual_HS3_time' => $request->conductorDimActual_HS3[1],
                    'conductorDimActual_HS4_time' => $request->conductorDimActual_HS4[1],
                    'conductorDimActual_FI1_time' => $request->conductorDimActual_FI1[1],
                    'conductorDimActual_FI2_time' => $request->conductorDimActual_FI2[1],
                    'conductorDimActual_FI3_time' => $request->conductorDimActual_FI3[1],
                    'conductorDimActual_FI4_time' => $request->conductorDimActual_FI4[1],
                    'ovality_time' => $request->ovality[1],
                    'preformingLayActual_time' => $request->preformingLayActual[1],
                    'waterBlockingTapActual_time' => $request->waterBlockingTapActual[1],
                    'layLengthDirection_time' => $request->layLengthDirection[1],
                    'resistance1_time' => $request->resistance1[1],
                    'length1_time' => $request->length1[1],
                    'resistance2_time' => $request->resistance2[1],
                    'length2_time' => $request->length2[1],
                    'resistance3_time' => $request->resistance3[1],
                    'length3_time' => $request->length3[1],
                    'resistance4_time' => $request->resistance4[1],
                    'length4_time' => $request->length4[1],
                    'conductorWeightActual_time' => $request->conductorWeightActual[1],
                    'layLengthActual_time' => $request->layLengthActual[1],
                    'powder_grease_weightActual_time' => $request->powder_grease_weightActual[1],
                    'visual_time' => $request->visual[1],
                    'status_time' => $request->status[1],
                    'productionOperator_time' => $request->productionOperator[1],
                    'notes_time' => $request->notes[1],
                    'updated_by' => $nameOfAdminWhoMadeUpdate
                ]);


            //GET Standard To Create Hold
            $strandingActual = DB::table('strandingactuals')->where('id', '=', $request->id)->first();
            $strandingActualTime = DB::table('strandingactualstimes')->where('strandingactuals_id', '=', $request->id)->first();
            $strandingStandard = DB::table('strandingstandards')->where('id', $strandingActual->jopOrderNumber_id)->first();
            $strandingStandardTime = DB::table('strandingstandardstimes')->where('strandingstandards_id', $strandingActual->jopOrderNumber_id)->first();

            // To Make Hold If Status is Hold
            if ($request->status[0] == "hold") {
                $holdIsExists = DB::table('hold')->where([['fromSheet', 'Stranding'], ['sheet_id', $request->id]])->exists();
                if (!$holdIsExists) {
                    // To Add New Hold
                    $hold = new Hold();
                    $hold->sheet_id = $request->id;
                    $hold->jopOrderNumber = $strandingStandard->jopOrderNumber;
                    $hold->drumNumber = $request->drumNumber[0];
                    $hold->cableSize = $strandingStandard->size;
                    $hold->length = $request->length[0];
                    $hold->description = null;
                    $hold->machine = $request->machine[0];
                    $hold->reasonOfHold = $request->notes[0];
                    $hold->fromSheet = "Stranding";
                    $hold->added_by = $nameOfAdminWhoMadeUpdate;
                    $hold->shift = $shiftOfAdminWhoMadeUpdate;
                    $hold->save();

                    // To Add New HoldTime
                    $holdTime = new HoldTime();
                    $holdTime->hold_id = $hold->id;
                    $holdTime->jopOrderNumber_time = $strandingStandardTime->jopOrderNumber_time;
                    $holdTime->drumNumber_time = $request->drumNumber[1];
                    $holdTime->cableSize_time = $strandingStandardTime->size_time;
                    $holdTime->length_time = $request->length[1];
                    $holdTime->description_time = null;
                    $holdTime->machine_time = $request->machine[1];
                    $holdTime->reasonOfHold_time = $request->notes[1];
                    $holdTime->added_by = $nameOfAdminWhoMadeUpdate;
                    $holdTime->shift = $shiftOfAdminWhoMadeUpdate;
                    $holdTime->save();
                } else {
                    $dataOfHold = DB::table('hold')->where([['fromSheet', 'Stranding'], ['sheet_id', $request->id]])->first();
                    $hold = DB::table('hold')
                        ->where([['fromSheet', 'Stranding'], ['sheet_id', $request->id]])
                        ->update([
                            'drumNumber' => $request->drumNumber[0],
                            'length' => $request->length[0],
                            'machine' => $request->machine[0],
                            'reasonOfHold' =>  $request->notes[0],
                            'fromSheet' => "Stranding",
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);

                    $holdTime = DB::table('holdtimes')
                        ->where('hold_id', $dataOfHold->id)
                        ->update([
                            'drumNumber_time' => $request->drumNumber[1],
                            'length_time' => $request->length[1],
                            'machine_time' => $request->machine[1],
                            'reasonOfHold_time' =>  $request->notes[1],
                            'added_by' => $dataOfHold->added_by . ' | ' . $nameOfAdminWhoMadeUpdate,
                            'shift' => $dataOfHold->shift . ' | ' . $shiftOfAdminWhoMadeUpdate
                        ]);
                }
            }

            return array($strandingActual, $strandingActualTime);
        }
    }

    public function deleteDataStranding(Request $request)
    {
        if ($request->ajax()) {
            $deleteActualTimeRow = DB::table('strandingactualstimes')->where('strandingactuals_id', $request->rowId)->delete();
            $deleteActualRow = DB::table('strandingactuals')->where('id', $request->rowId)->delete();
        }
    }

    public function getISO(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Stranding')->exists();

            if (!$chickISO) {
                $strandingISO = new ISO();
                $strandingISO->sheet = "Stranding";
                $strandingISO->save();
            }


            $strandingISO = DB::table('iso')->where('sheet', 'Stranding')->get();
            return $strandingISO;
        }
    }

    public function iso(Request $request)
    {
        if ($request->ajax()) {

            $chickISO = DB::table('iso')->where('sheet', 'Stranding')->exists();

            if (!$chickISO) {

                $strandingISO = new ISO();
                $strandingISO->sheet = "Stranding";
                $strandingISO->issueNumber = $request->issueNumber;
                $strandingISO->issueDate = $request->issueDate;
                $strandingISO->modifiedDate = $request->modifiedDate;
                $strandingISO->durationOfPreservation     = $request->durationOfPreservation;
                $strandingISO->material = $request->material;
                $strandingISO->save();
            } else {
                $strandingISO = DB::table('iso')->where('sheet', 'Stranding')->update([
                    'issueNumber' => $request->issueNumber,
                    'issueDate' => $request->issueDate,
                    'modifiedDate' => $request->modifiedDate,
                    'durationOfPreservation' => $request->durationOfPreservation,
                    'material' => $request->material
                ]);
            }

            $strandingISO = DB::table('iso')->where('sheet', 'Stranding')->get();


            $result = $this->getDataStranding($request);

            array_pop($result);
            array_pop($result);

            array_push($result, $strandingISO);

            return $result;
        }
    }
}
