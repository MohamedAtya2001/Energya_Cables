<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>L.V Insulation Actual</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For DaterAngepicker.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/daterangepicker.css') }}" />
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/ShowData.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/Printer/Insulation/PrinterInsulation.css') }}">


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
                    <a class="dropdown-item" href="{{ route('admin.show.actual.stranding') }}">Stranding</a>
                    <a class="dropdown-item active" href="{{ route('admin.show.actual.insulation') }}">L.V Insulation</a>
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
        <h1 class="m-auto">L.V Insulation Actual Sheets</h1>
    </div>

    <div id="Edit">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center my-4">Edit Drowing</h2>

            <form action="{{ route('insulation.edit.row') }}" class="clearfix">
                @csrf

                <div class="row actual">

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Machine :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Input Drum :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Input Card :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Input Length :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Output Drum :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Output Card :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Output Length :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Apperance Of Drum :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Color :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Message :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Thickness Start :</label>
                                <div class="thirdInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" required autocomplete="off" placeholder="Min">
                                    <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" required autocomplete="off" placeholder="Nom">
                                    <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" required autocomplete="off" placeholder="Max">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Thickness End :</label>
                                <div class="thirdInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" required autocomplete="off" placeholder="Min">
                                    <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" required autocomplete="off" placeholder="Nom">
                                    <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" required autocomplete="off" placeholder="Max">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Eccentricity % :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Dim Before :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Dim After Start :</label>
                                <div class="thirdInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" required autocomplete="off" placeholder="Min">
                                    <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" required autocomplete="off" placeholder="Nom">
                                    <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" required autocomplete="off" placeholder="Max">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Dim After End :</label>
                                <div class="thirdInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" required autocomplete="off" placeholder="Min">
                                    <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" required autocomplete="off" placeholder="Nom">
                                    <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" required autocomplete="off" placeholder="Max">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Weight :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Material :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Ovality % :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Meter Measuring :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Spark :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Status :</label>
                                <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId" required autocomplete="off">
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
                                <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId" required autocomplete="off">
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
            <form action="{{ route('insulation.iso') }}">
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

            <form action="{{ route('insulation.get') }}" class="clearfix">
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
                <a href="{{ route('admin.show.standard.insulation') }}"><button class="btn btn-insulation float-left">Show Standards</button></a>
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
                        <th>Cable Size : </th>
                        <td></td>
                        <th>Cable Description : </th>
                        <td></td>
                        <th>Volt : </th>
                        <td></td>
                        <th>Eccentricity : </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Thickness Min : </th>
                        <td></td>
                        <th>Thickness Nom : </th>
                        <td></td>
                        <th>Thickness Max : </th>
                        <td></td>
                        <th>Outer Dim : </th>
                        <td></td>
                        <th>Ovality : </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Material : </th>
                        <td></td>
                        <th>Color : </th>
                        <td></td>
                        <th>Spark : </th>
                        <td></td>
                        <th>Weight : </th>
                        <td></td>
                        <th>Master Patch : </th>
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
                                <option value="inputDrum">Input Drum</option>
                                <option value="inputCard">Input Card</option>
                                <option value="inputLength">Input Length</option>
                                <option value="outputDrum">Output Drum</option>
                                <option value="outputCard">Output Card</option>
                                <option value="outputLength">Output Length</option>
                                <option value="colorActual">color</option>
                                <option value="weightActual">Weight</option>
                                <option value="materialActual">Material</option>
                                <option value="status">Status</option>
                                <option value="productionOperator">Production Operator</option>
                                <option value="notes">Notes</option>
                                <option value="updated_by">Updated_by</option>
                                <option value="periodOfTime">Period Of Time</option>
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
                            <th class="thJopOrderNumber d-none">Jop Order Number</th>
                            <th>Machine</th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Input
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 text-center">Drum</span>
                                    <span class="col-4 p-0 m-0 text-center">Card</span>
                                    <span class="col-4 p-0 m-0 text-center">Length</span>
                                </div>
                            </th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Output
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 text-center">Drum</span>
                                    <span class="col-4 p-0 m-0 text-center">Card</span>
                                    <span class="col-4 p-0 m-0 text-center">Length</span>
                                </div>
                            </th>
                            <th>Apperance Of Drum</th>
                            <th>Color</th>
                            <th>Message</th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Thickness
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 text-center">Min</span>
                                    <span class="col-4 p-0 m-0 text-center">Nom</span>
                                    <span class="col-4 p-0 m-0 text-center">Max</span>
                                </div>
                            </th>
                            <th>Eccentricity</th>
                            <th>Dim Before</th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Dim After
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 text-center">Min</span>
                                    <span class="col-4 p-0 m-0 text-center">Nom</span>
                                    <span class="col-4 p-0 m-0 text-center">Max</span>
                                </div>
                            </th>
                            <th>Weight</th>
                            <th>Material</th>
                            <th>Ovality</th>
                            <th>Meter Measuring</th>
                            <th>Spark</th>
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
    <script src="{{ asset('layout/JavaScript/ShowData/Actual/ShowActualInsulation.js') }}"></script>


</body>


</html>