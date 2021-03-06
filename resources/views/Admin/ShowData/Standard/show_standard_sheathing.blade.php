<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sheathing Standard</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For DaterAngepicker.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/daterangepicker.css') }}" />
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/ShowData/ShowData.css') }}">


</head>

<body>

    @include('layout.navbar')

    <div class="nav-sheet my-4">
        <div class="container">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle d-block ml-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Standard Sheets
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('admin.show.standard.drowing') }}">Dowing</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.stranding') }}">Stranding</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.insulation') }}">L.V Insulation</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.CCVInsulation') }}">CCV Insulation</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.screen') }}">Screen</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.assembly') }}">Assembly</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.bedding') }}">Bedding</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.armouring') }}">Armouring</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.lead') }}">Lead</a>
                    <a class="dropdown-item" href="{{ route('admin.show.standard.taps') }}">Taps</a>
                    <a class="dropdown-item active" href="{{ route('admin.show.standard.sheathing') }}">Sheathing</a>
                </div>
            </div>
        </div>
    </div>

    <div class="headLine my-5">
        <h1 class="m-auto">Sheathing Standard Sheets</h1>
    </div>

    <div id="Edit">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center my-4">Edit Sheathing</h2>

            <form action="{{ route('sheathing.standard.edit.row') }}" class="clearfix">
                @csrf

                <div class="row standard">
                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Jop Order Number :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Cable Size :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Cable Description :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Volt :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Thickness :</label>
                                <div class="thirdInput">
                                    <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required autocomplete="off">
                                    <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Eccentricity % :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Outer Dim :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Ovality % :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Material :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Color :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Spark :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-3">
                        <div class="item">
                            <div class="form-group">
                                <label>Weight :</label>
                                <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required autocomplete="off">
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

    <div id="Data">

        <div class="button-print clearfix my-3">
            <div class="container">
                <a href="{{ route('admin.show.actual.sheathing') }}"><button class="btn btn-sheathing float-left">Show Actual</button></a>
            </div>
        </div>

        <div class="printContent d-none"></div>

        <div class="sheets">

            <div class="filter my-5">

                <div class="filterValue mx-auto">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-6 col-md-5">
                            <select class="form-control d-inline input" name="fillerName" id="FilterName" aria-describedby="helpId" required>
                                <option value="shift">Shift</option>
                                <option value="added_by">Added By</option>
                                <option value="jopOrderNumber">Jop Order Number</option>
                                <option value="cableSize">(Size / Type)</option>
                                <option value="materialStandard">Lay Length</option>
                                <option value="colorStandard">(Powder / Grease) Weight</option>
                                <option value="weightStandard">(Powder / Grease) Weight</option>
                                <option value="updated_by">Updated_by</option>
                                <option value="periodOfTime">Period Of Time</option>
                            </select>
                        </div>
                        <div class="col-6 col-md-5">
                            <div id="reportrange">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <input type="text" class="form-control w-100 input" id="FilterValue" name="fillerValue" aria-describedby="helpId" autocomplete="off">
                        </div>
                        <div class="col-12 col-md-2 p-0 mt-3 mr-3 m-md-0">
                            <button class="btn btn-info d-block ml-auto" id="Filter">
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
                            <th>Jop Order Number</th>
                            <th>Cable Size</th>
                            <th>Cable Description</th>
                            <th>Volt</th>
                            <th class="text-center pb-0 threeColumns" colspan="3">
                                Thickness
                                <div class="row m-0 mt-2">
                                    <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                    <span class="col-4 p-0 m-0 px-2 text-center">Nom</span>
                                    <span class="col-4 p-0 m-0 px-2 text-center">Min</span>
                                </div>
                            </th>
                            <th>Eccentricity</th>
                            <th>Outer Dim</th>
                            <th>Ovality</th>
                            <th>Material</th>
                            <th>Color</th>
                            <th>Spark</th>
                            <th>Weight</th>
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
    <script src="{{ asset('layout/JavaScript/moment.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/daterangepicker.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/ShowData/Standard/ShowStandardSheathing.js') }}"></script>


</body>


</html>