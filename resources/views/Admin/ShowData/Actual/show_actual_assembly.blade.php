<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assembly Actual</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For DaterAngepicker.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/daterangepicker.css') }}" />
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/ShowData.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/Printer/Assembly/PrinterAssembly.css') }}">


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
                    <a class="dropdown-item" href="{{ route('admin.show.actual.insulation') }}">L.V Insulation</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.CCVInsulation') }}">CCV Insulation</a>
                    <a class="dropdown-item" href="{{ route('admin.show.actual.screen') }}">Screen</a>
                    <a class="dropdown-item active" href="{{ route('admin.show.actual.assembly') }}">Assembly</a>
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
        <h1 class="m-auto">Assembly Actual Sheets</h1>
    </div>

    <div id="Edit">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center my-4">Edit Drowing</h2>

            <form action="{{ route('assembly.edit.row') }}" class="clearfix">
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
                                <div class="fifthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="inputDrum1" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputDrum2" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputDrum3" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputDrum4" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputDrum5" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Input Card :</label>
                                <div class="fifthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputCard5" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Input Length :</label>
                                <div class="fifthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="inputLength1" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputLength2" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputLength3" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputLength4" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="inputLength5" aria-describedby="helpId" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Color :</label>
                                <div class="fifthInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="color1" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="color2" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="color3" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="color4" aria-describedby="helpId" autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="color5" aria-describedby="helpId" autocomplete="off">
                                </div>
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
                                <label>Outer Dim:</label>
                                <div class="thirdInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="outerDimMinActual" aria-describedby="helpId" required autocomplete="off" placeholder="Min" required>
                                    <input type="text" class="form-control d-inline input" name="outerDimNomActual" aria-describedby="helpId" required autocomplete="off" placeholder="Nom" required>
                                    <input type="text" class="form-control d-inline input" name="outerDimMaxActual" aria-describedby="helpId" required autocomplete="off" placeholder="Max" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Ovality % :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Lay Length :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Direction :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="direction" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="row twisted">
                                <label>Filler :</label>
                                <div class="fix-group">
                                    <input type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerActual" aria-describedby="helpId" required autocomplete="off">
                                    <select class="form-control d-inline input twisted_select" name="twistedActual" aria-describedby="helpId" required autocomplete="off">
                                        <option value="Twisted">Twisted</option>
                                        <option value="Not Twisted">Not Twisted</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>P.P Tape :</label>
                                <div class="secondInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="ppTapeSize" placeholder="Size" aria-describedby="helpId" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="ppTapeOverLap" placeholder="OverLap" aria-describedby="helpId" required autocomplete="off">
                                </div>
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
                                <textarea type="text" class="form-control d-inline ml-2 input" maxlength="100" name="notes" aria-describedby="helpId" autocomplete="off"></textarea>
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
            <form action="{{ route('assembly.iso') }}">
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

            <form action="{{ route('assembly.get') }}" class="clearfix">
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
                <a href="{{ route('admin.show.standard.assembly') }}"><button class="btn btn-assembly float-left">Show Standards</button></a>
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
                        <th>Filler / p.p Tape : </th>
                        <td></td>
                        <th>Over Lap : </th>
                        <td></td>
                    </tr>
                    <tr>
                        <th>Outer Min Dim : </th>
                        <td></td>
                        <th>Outer Nom Dim : </th>
                        <td></td>
                        <th>Outer Max Dim : </th>
                        <td></td>
                        <th>Lay Length : </th>
                        <td></td>
                        <th>Ovality : </th>
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
                                <option value="machine">Machine</option>
                                <option value="inputDrum">Input Drum</option>
                                <option value="inputCard">Input Card</option>
                                <option value="inputLength">Input Length</option>
                                <option value="color">color</option>
                                <option value="outputDrum">Output Drum</option>
                                <option value="outputCard">Output Card</option>
                                <option value="outputLength">Output Length</option>
                                <option value="status">Status</option>
                                <option value="productionOperator">Production Operator</option>
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
                            <th>Machine</th>
                            <th class="text-center sixColumns" colspan="6">
                                Input

                            </th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Output
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 px-2 text-center">Drum</span>
                                    <span class="col-4 p-0 m-0 px-2 text-center">Card</span>
                                    <span class="col-4 p-0 m-0 px-2 text-center">Length</span>
                                </div>
                            </th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Outer Dim
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                    <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                    <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                </div>
                            </th>
                            <th>Ovality</th>
                            <th class="text-center pb-0 twoColumns" colspan="2">
                                Lay Length
                                <div class="row m-0 mt-2">
                                    <span class="col-6 p-0 m-0 px-2 text-center">Length</span>
                                    <span class="col-6 p-0 m-0 px-2 text-center">Direction</span>
                                </div>
                            </th>
                            <th>Filler</th>
                            <th class="text-center pb-0 twoColumns" colspan="2">
                                P.P Tape
                                <div class="row m-0 mt-2">
                                    <span class="col-6 p-0 m-0 px-2 text-center">Size</span>
                                    <span class="col-6 p-0 m-0 px-2 text-center">Over Lab</span>
                                </div>
                            </th>
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
    <script src="{{ asset('layout/JavaScript/ShowData/Actual/ShowActualAssembly.js') }}"></script>


</body>


</html>