<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stranding Report</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For DaterAngepicker.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/daterangepicker.css') }}" />
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/Reports/Reports.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Reports/Printer/Stranding/PrinterStranding.css') }}">


</head>

<body>
    @include('layout.navbar')

    <div class="nav-sheet my-4">
        <div class="container">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle d-block ml-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Reports
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('report.hold') }}">Hold</a>
                    <a class="dropdown-item" href="{{ route('report.finish') }}">Finish</a>
                    <a class="dropdown-item" href="{{ route('report.rewind') }}">Rewind</a>
                    <a class="dropdown-item" href="{{ route('report.extrusion') }}">Extrusion</a>
                    <a class="dropdown-item active" href="{{ route('report.stranding') }}">Stranding</a>
                </div>
            </div>
        </div>
    </div>

    <div class="headLine my-5">
        <h1 class="m-auto">Stranding Report</h1>
    </div>

    <div id="Remark">
        <div class="box clearfix report">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center my-4">Remark</h2>

            <form action="{{ route('report.remark.stranding') }}" class="clearfix">
                @csrf

                <div class="form-group">
                    <label>Remark :</label>
                    <textarea type="text" class="form-control d-inline ml-2 input" maxlength="100" name="remark" aria-describedby="helpId" required></textarea>
                </div>

                <button class="btn btn-info my-3 float-right mr-3" type="submit">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Remark</span>
                </button>

            </form>

        </div>
    </div>

    <div id="Data" data-logoSrc="{{ asset('layout/images/Home/logo.gif') }}">

        <div class="button-print clearfix my-3">
            <div class="container">
                <button id="StartPrint" class="btn btn-success float-right" disabled>
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Print Report</span>
                </button>
            </div>
        </div>

        <div class="printContent d-none"></div>

        <div class="sheets">

            <div class="filter my-5">

                <div class="filterValue mx-auto">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6 col-md-5">
                            <select class="form-control d-inline input" name="fillerName" id="FilterName" aria-describedby="helpId" required>
                                <option value="jopOrderNumber">Jop Order Number</option>
                                <option value="size">Size</option>
                                <option value="type">Type</option>
                                <option value="shape">Shape</option>
                                <option value="angel">Angel</option>
                                <option value="weightDeviation">Weight Deviation</option>
                                <option value="periodOfTime">Period Of Time</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-5">
                            <div id="reportrange">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <div id="WeightDeviation" class="form-control">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="red" id="Red" onclick="weightDeviationFilter(this)" checked>
                                    <label class="custom-control-label" for="Red">Red</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="green" id="Green" onclick="weightDeviationFilter(this)" checked>
                                    <label class="custom-control-label" for="Green">Green</label>
                                </div>
                            </div>
                            <input type="text" class="form-control w-100 input" id="FilterValue" name="fillerValue" aria-describedby="helpId" autocomplete="off">
                        </div>
                        <div class="col-12 col-md-2 p-0 mt-3 mr-3 m-md-0">
                            <button class="btn btn-info d-block ml-auto" id="Filter">
                                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <span>Get Report</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <div class="report my-3">
                <p class="alert alert-warning text-center d-none">There Is No Data</p>
                <table class="table m-auto">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>jop Order Number</th>
                            <th>Date / Time</th>
                            <th>Size</th>
                            <th>Type</th>
                            <th>Shape</th>
                            <th>Construction</th>
                            <th class="text-center pb-0 px-0 fourColumns" colspan="4">
                                Weight (kg/km)
                                <div class="row m-0 mt-2">
                                    <span class="col-3 p-0 m-0 text-center">Drum No</span>
                                    <span class="col-3 p-0 m-0 text-center">Standard</span>
                                    <span class="col-3 p-0 m-0 text-center">Actual</span>
                                    <span class="col-3 p-0 m-0 text-center">Deviation%</span>
                                </div>
                            </th>
                            <th colspan="7">Resistance</th>
                            <th>Remarks</th>
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
    <script src="{{ asset('layout/JavaScript/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Popper.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/JMA.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/printThis.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/moment.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/daterangepicker.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Reports/StrandingReport.js') }}"></script>


</body>


</html>