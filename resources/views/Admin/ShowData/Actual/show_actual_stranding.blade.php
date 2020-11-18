<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stranding Actual</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For DaterAngepicker.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/daterangepicker.css') }}" />
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/ShowData.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/Printer/Stranding/PrinterStranding.css') }}">


</head>

<body>

    @include('layout.navbar')

    <div class="nav-sheet my-4">
        <div class="container">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle d-block ml-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actual Sheets
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('admin.show.actual.drowing') }}">Dowing</a>
                    <a class="dropdown-item active" href="{{ route('admin.show.actual.stranding') }}">Stranding</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.insulation') }}">L.V Insulation</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.CCVInsulation') }}">CCV Insulation</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.screen') }}">Screen</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.assembly') }}">Assembly</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.bedding') }}">Bedding</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.armouring') }}">Armouring</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.lead') }}">Lead</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.taps') }}">Taps</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.sheathing') }}">Sheathing</a>
                </div>
            </div>
        </div>
    </div>

    <div class="headLine my-5">
        <h1 class="m-auto">Stranding Actual Sheets</h1>
    </div>

    <div id="Edit">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center my-4">Edit Drowing</h2>

            <form action="{{ route('stranding.edit.row') }}" class="clearfix">
                @csrf

                <div class="row actual">

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Machine :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="row shapes">
                                <label>Shape :</label>
                                <div class="fix-group">
                                    <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" autocomplete="off" required disabled>
                                    <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" autocomplete="off" required>
                                        <option value="Circular">Circular</option>
                                        <option value="Sector">Sector</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Input Card :</label>
                                <div class="fourthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" autocomplete="off" required>
                                    <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Cage :</label>
                                <div class="fourthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" autocomplete="off" required>
                                    <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Drum Number :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Output Card :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Length :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Construction :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                <div class="fourthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" autocomplete="off" required>
                                    <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                <div class="fourthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" autocomplete="off" required>
                                    <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Ovality:</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Preforming Lay :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Resistance At Length (1) :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" autocomplete="off" required>
                                    <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Resistance At Length (2) :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Resistance At Length (3) :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Resistance At Length (4) :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Water Blocking Tap :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Lay Length Direction :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Conductor Weight :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Lay Length :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Powder Weight :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Visual :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Status :</label>
                                <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId" autocomplete="off" required>
                                    <option value="pass">Pass</option>
                                    <option value="hold">Hold</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Production Operator :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Notes :</label>
                                <textarea type="text" class="form-control d-inline ml-2 input" maxlength="100" name="notes" aria-describedby="helpId"></textarea>
                            </div>
                        </div>
                    </div>


                </div>

                <button class="btn btn-info my-3 float-right mr-3" type="submit">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                </button>

            </form>

        </div>
    </div>

    <div id="ISO">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center">Data For Report</h2>
            <form action="{{ route('stranding.iso') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="item">
                            <div class="form-group">
                                <label>Issue Number : </label>
                                <input type="text" class="form-control input" name="issueNumber" aria-describedby="helpId" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item">
                            <div class="form-group">
                                <label>Issue Date : </label>
                                <input type="text" class="form-control input" name="issueDate" aria-describedby="helpId" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item">
                            <div class="form-group">
                                <label>Modified Date : </label>
                                <input type="text" class="form-control input" name="modifiedDate" aria-describedby="helpId" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item">
                            <div class="form-group">
                                <label>Duration Of Preservation</label>
                                <input type="text" class="form-control input" name="durationOfPreservation" aria-describedby="helpId" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="item">
                            <div class="form-group">
                                <label>Material : </label>
                                <input type="text" class="form-control input" name="material" aria-describedby="helpId" placeholder="" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Print Report</span>
                </button>
            </form>
        </div>
    </div>

    <div id="Data" data-logoSrc="{{ asset('layout/images/Home/logo.gif') }}">
        <div class="jopOrderNumber w-50 m-auto">

            <form action="{{ route('stranding.get') }}" class="clearfix">
                @csrf
                <div class="form-group">
                    <label>Jop Order Number :</label>
                    <input type="text" class="form-control d-inline ml-4 input w-75" name="jopOrderNumber" aria-describedby="helpId" autocomplete="off" required>
                </div>

                <button class="btn btn-info my-3 float-right mr-3" type="submit">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Get Sheets</span>
                </button>

            </form>


        </div>

        <div class="button-print clearfix my-3">
            <div class="container">
                <a href="{{ route('admin.show.standard.stranding') }}"><button class="btn btn-stranding float-left">Show Standards</button></a>
                <button id="StartPrint" class="btn btn-success float-right" disabled>
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Print Report</span>
                </button>
            </div>
        </div>

        <div class="printContent d-none"></div>

        <div class="sheets">

            <div class="standard my-3">

                <table class="table w-75 mx-auto my-3 table2">
                    <tr>
                        <th>Jop Order Number : </th>
                        <td></td>
                        <th>Volt : </th>
                        <td></td>
                        <th>Conductor Dim(H & S & φ) : </th>
                        <td></td>
                        <th>Size : </th>
                        <td></td>
                        <th>Preforming Lay : </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Water Blocking Tap : </th>
                        <td></td>
                        <th>T.D.S No. : </th>
                        <td></td>
                        <th>Conductor Weight :</th>
                        <td></td>
                        <th>Resistance : </th>
                        <td></td>
                        <th>Construction :</th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Lay Length : </th>
                        <td></td>
                        <th>(Powder / Grease) Weight :</th>
                        <td></td>
                        <th></th>
                        <td></td>
                        <th></th>
                        <td></td>
                        <th></th>
                        <td></td>
                    </tr>

                </table>

            </div>

            <div class="filter my-5">

                <div class="filterValue mx-auto">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6 col-md-5">
                            <select class="form-control d-inline input" name="fillerName" id="FilterName" aria-describedby="helpId" data-last-selected="shift" required disabled>
                                <option value="shift">Shift</option>
                                <option value="added_by">Added By</option>
                                <option value="jopOrderNumber">Jop Order Number</option>
                                <option value="machine">Machine</option>
                                <option value="angel">Angel</option>
                                <option value="shape">Shape</option>
                                <option value="inputCard">Input Card</option>
                                <option value="drumNumber">Drum Number</option>
                                <option value="outputCard">Output Card</option>
                                <option value="length">Length</option>
                                <option value="constructionActual">Construction</option>
                                <option value="conductorDimActual_HS">Conductor Dim (H * S)</option>
                                <option value="conductorDimActual_FI">Conductor Dim (&phi;)</option>
                                <option value="conductorWeightActual">Conductor Weight</option>
                                <option value="resistanceAtLength">Resistance At Length</option>
                                <option value="status">status</option>
                                <option value="productionOperator">production Operator</option>
                                <option value="notes">Notes</option>
                                <option value="periodOfTime">Period Of Time</option>
                                <option value="updated_by">Updated_by</option>
                                <option value="sheetsType">Sheets Type</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-5">
                            <div id="reportrange">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <div id="SubJopOrderNumber" class="form-control">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="jopOrderNumber" id="jopOrderNumber" onclick="jopOrderNumberFilter(this)" checked>
                                    <label class="custom-control-label" for="jopOrderNumber">JOP</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="subJopOrderNumber" id="subJopOrderNumber" onclick="jopOrderNumberFilter(this)" checked>
                                    <label class="custom-control-label" for="subJopOrderNumber">JOP.</label>
                                </div>
                            </div>
                            <div id="SheetsType" class="form-control">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="uncomplete" id="Uncomplete" onclick="sheetsTypeFilter(this)">
                                    <label class="custom-control-label" for="Uncomplete">Uncomplete</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="complete" id="Complete" onclick="sheetsTypeFilter(this)" checked>
                                    <label class="custom-control-label" for="Complete">Complete</label>
                                </div>
                            </div>
                            <div id="Status" class="form-control">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="hold" id="Hold" onclick="statusFilter(this)" checked>
                                    <label class="custom-control-label" for="Hold">Hold</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="pass" id="Pass" onclick="statusFilter(this)" checked>
                                    <label class="custom-control-label" for="Pass">Pass</label>
                                </div>
                            </div>
                            <div id="ResistanceAtLength" class="form-control">
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline input" name="resistance" id="Resistance" aria-describedby="helpId" placeholder="Ω" autocomplete="off" onblur="resistanceAtLengthFilter(this)">
                                    <input type="text" class="form-control d-inline input" name="length" id="Length" aria-describedby="helpId" placeholder="M" autocomplete="off" onblur="resistanceAtLengthFilter(this)">
                                </div>
                            </div>
                            <input type="text" class="form-control w-100 input" id="FilterValue" name="fillerValue" aria-describedby="helpId" autocomplete="off" disabled>
                        </div>
                        <div class="col-12 col-md-2 p-0 mt-3 mr-3 m-md-0">
                            <button class="btn btn-info d-block ml-auto" id="Filter" disabled>
                                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <span>Get Sheets</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="actual my-3">
                <p class="alert alert-warning text-center d-none">There Is No Data</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Date / Time</th>
                            <th>Shift</th>
                            <th>Add By</th>
                            <th class="thJopOrderNumber d-none">jopOrderNumber</th>
                            <th>Machine</th>
                            <th>Angel</th>
                            <th>Shape</th>
                            <th>Input Card</th>
                            <th>Cage</th>
                            <th>Drum Number</th>
                            <th>Output Card</th>
                            <th>Length</th>
                            <th>Construction</th>
                            <th class="p-0 text-center threeColumns" colspan="3">
                                Conductor Dim
                                <div class="conductorDim row m-0">
                                    <span class="col-4 p-0 m-0 text-center">H</span>
                                    <span class="col-4 p-0 m-0 text-center">S</span>
                                    <span class="col-4 p-0 m-0 text-center">φ</span>
                                </div>
                            </th>
                            <th>Ovality</th>
                            <th>Preforming Lay</th>
                            <th>Water Blocking Tap</th>
                            <th>Lay Length Direction</th>
                            <th>Conductor Weight</th>
                            <th class="p-0 text-center twoColumns" colspan="2">
                                Resistance At Length
                                <div class="row m-0">
                                    <span class="col-6 p-0 m-0 text-center">Ω</span>
                                    <span class="col-6 p-0 m-0 text-center">M</span>
                                </div>
                            </th>
                            <th>Lay Length</th>
                            <th>Powder Weight</th>
                            <th>Visual</th>
                            <th>Status</th>
                            <th>Production Operator</th>
                            <th class="notes">Notes</th>
                            <th>Updated_by</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <button class="float-right d-none btn mr-3 mb-3" data-count-rows="25" id="Limit">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>See More</span>
            </button>

        </div>


    </div>

    <script src="{{ asset('layout/JavaScript/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Popper.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/JMA.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/printThis.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/moment.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/daterangepicker.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/ShowData/Actual/ShowActualStranding.js') }}"></script>

</body>

</html>