<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WatchingEmployee</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/Home/Home.css') }}">

    <link rel="stylesheet" href="{{ asset('layout/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/bootnavbar.css') }}">



</head>

<body>

    @include('layout.navbar')

    <div class="Buttons">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="drowing">Drowing</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="stranding">Stranding</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="insulation">L.V Insulation</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="CCVInsulation">CCV Insulation</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="screen">Screen</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="assembly">Assembly</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="bedding">Bedding</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="armouring">Armouring</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="Lead">Lead</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="taps">Taps</button>
                </div>

                <div class="col-lg-3 col-xs-6 col-sm-6 col-md-6">
                    <button class="option btn btn-success my-4 mx-auto d-block" data-sheet="sheathing">Sheathing</button>
                </div>

            </div>
        </div>
    </div>

    <div class="sheetes">

        <div class="drowing">

            <div id="drowing" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option1" id="Drowing_1" data-item="0">
                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">


                                    <h2 class="text-center">Drowing Page 1</h2>

                                    <form action="{{ route('admin.findDrowingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfDrowing">
                                        @csrf
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.drowing') }}" class="clearfix drowingActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" data-error="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label> Size:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" data-error="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" data-error="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationStandard" data-error="elongationStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileStandard" data-error="tensileStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" data-error="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Coil Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="coilNumber" data-error="coilNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationActual" data-error="elongationActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileActual" data-error="tensileActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cage" data-error="cage" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" data-error="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" data-error="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" data-error="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" data-error="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" data-error="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option1" id="Drowing_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>


                                <div class="content">

                                    <h2 class="text-center">Drowing Page 2</h2>

                                    <form action="{{ route('admin.findDrowingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfDrowing">
                                        @csrf
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.drowing') }}" class="clearfix drowingActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" data-error="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label> Size:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" data-error="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" data-error="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationStandard" data-error="elongationStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileStandard" data-error="tensileStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" data-error="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Coil Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="coilNumber" data-error="coilNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationActual" data-error="elongationActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileActual" data-error="tensileActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cage" data-error="cage" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" data-error="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" data-error="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" data-error="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" data-error="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" data-error="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option1" id="Drowing_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">


                                    <h2 class="text-center">Drowing Page 3</h2>

                                    <form action="{{ route('admin.findDrowingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfDrowing">
                                        @csrf
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.drowing') }}" class="clearfix drowingActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" data-error="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label> Size:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" data-error="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" data-error="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationStandard" data-error="elongationStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileStandard" data-error="tensileStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" data-error="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Coil Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="coilNumber" data-error="coilNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationActual" data-error="elongationActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileActual" data-error="tensileActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cage" data-error="cage" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" data-error="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" data-error="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" data-error="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" data-error="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" data-error="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option1" id="Drowing_4" data-item="3">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">


                                    <h2 class="text-center">Drowing Page 4</h2>

                                    <form action="{{ route('admin.findDrowingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfDrowing">
                                        @csrf
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.drowing') }}" class="clearfix drowingActual" data-update="false" data-form-item="4">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" data-error="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label> Size:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" data-error="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" data-error="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationStandard" data-error="elongationStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileStandard" data-error="tensileStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" data-error="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Coil Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="coilNumber" data-error="coilNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Dim :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="wireDimMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="wireDimNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="wireDimMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>elongation :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="elongationActual" data-error="elongationActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tensile :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tensileActual" data-error="tensileActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cage" data-error="cage" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" data-error="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" data-error="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" data-error="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" data-error="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" data-error="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#drowing" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#drowing" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="stranding">

            <div id="stranding" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option2" id="Stranding_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 1</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>



                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 2</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>


                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 3</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_4" data-item="3">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>



                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 4</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="4">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_5" data-item="4">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>


                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 5</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="5">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_6" data-item="5">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 6</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="6">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_7" data-item="6">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 7</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="7">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_8" data-item="7">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 8</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="8">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_9" data-item="8">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 9</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="9">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Stranding_10" data-item="9">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findStrandingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfStranding">
                                        @csrf
                                        <h2 class="text-center">Stranding Page 10</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.stranding') }}" class="clearfix strandingActual" data-update="false" data-form-item="10">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row size_type">
                                                        <label>Size / Type :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input size" name="size" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input type" name="type" aria-describedby="helpId" required>
                                                                <option value="CU">CU</option>
                                                                <option value="AL">AL</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim(H & S & &phi;):</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorDimStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>T.D.S No. :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="TDS_number" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="resistance" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Powder / Grease) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row shapes">
                                                        <label>Shape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline input angel" name="angel" aria-describedby="helpId" disabled>
                                                            <select class="form-control d-inline input shape" onchange="shapeIsChanged(this)" name="shape" aria-describedby="helpId" required>
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
                                                            <input type="text" class="form-control d-inline ml-1 input" name="inputCard1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="inputCard4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cage :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="cage1" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage2" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage3" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="cage4" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Drum Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="drumNumber" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="length" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Construction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="constructionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (H * S) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_HS1" onblur="conductorDimActual(this)" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS2" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS3" placeholder="H*S" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_HS4" placeholder="H*S" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label style="font-size: 15px;">Conductor Dim (&phi;) :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="conductorDimActual_FI1" onblur="conductorDimActual(this)" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI2" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI3" placeholder="&phi;" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="conductorDimActual_FI4" placeholder="&phi;" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovality" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Preforming Lay :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="preformingLayActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (1) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance1" placeholder="Ω" aria-describedby="helpId" required>
                                                            <input type="text" class="form-control d-inline input" name="length1" placeholder="M" aria-describedby="helpId" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (2) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance2" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length2" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (3) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance3" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length3" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Resistance At Length (4) :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="resistance4" placeholder="Ω" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="length4" placeholder="M" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Water Blocking Tap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="waterBlockingTapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthDirection" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Conductor Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="conductorWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Powder Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="powder_grease_weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Visual :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="visual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#stranding" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#stranding" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="insulation">

            <div id="insulation" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option3" id="Insulation_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findInsulationStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfInsulation">
                                        @csrf
                                        <h2 class="text-center">Insulation Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.insulation') }}" class="clearfix insulationActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Master Patch :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="masterPatch" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Insulation_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findInsulationStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfInsulation">
                                        @csrf
                                        <h2 class="text-center">Insulation Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.insulation') }}" class="clearfix insulationActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Master Patch :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="masterPatch" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Insulation_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findInsulationStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfInsulation">
                                        @csrf
                                        <h2 class="text-center">Insulation Page 3</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.insulation') }}" class="clearfix insulationActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Master Patch :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="masterPatch" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#insulation" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#insulation" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="CCVInsulation">

            <div id="CCVInsulation" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option1" id="CCVInsulation_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('user.findCCVInsulationStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfCCVInsulation">
                                        @csrf
                                        <h2 class="text-center">CCV Insulation Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('user.CCVInsulation') }}" class="clearfix CCVInsulationActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="description" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Min :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinISC" aria-describedby="helpId" placeholder="ISC" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMinINS" aria-describedby="helpId" placeholder="INS" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMinOSC" aria-describedby="helpId" placeholder="OSC" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Nom :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessNomISC" aria-describedby="helpId" placeholder="ISC" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomINS" aria-describedby="helpId" placeholder="INS" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomOSC" aria-describedby="helpId" placeholder="OSC" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness ISC Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessISCStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness INS Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessINSStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness OSC Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessOSCStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness ISC End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessISCEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness INS End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessINSEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness OSC End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessOSCEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="CCVInsulation_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('user.findCCVInsulationStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfCCVInsulation">
                                        @csrf
                                        <h2 class="text-center">CCV Insulation Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('user.CCVInsulation') }}" class="clearfix CCVInsulationActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="description" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Min :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinISC" aria-describedby="helpId" placeholder="ISC" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMinINS" aria-describedby="helpId" placeholder="INS" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMinOSC" aria-describedby="helpId" placeholder="OSC" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Nom :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessNomISC" aria-describedby="helpId" placeholder="ISC" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomINS" aria-describedby="helpId" placeholder="INS" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomOSC" aria-describedby="helpId" placeholder="OSC" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness ISC Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessISCStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness INS Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessINSStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness OSC Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessOSCStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness ISC End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessISCEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness INS End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessINSEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness OSC End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessOSCEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="CCVInsulation_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('user.findCCVInsulationStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfCCVInsulation">
                                        @csrf
                                        <h2 class="text-center">CCV Insulation Page 3</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" inputSearch required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('user.CCVInsulation') }}" class="clearfix CCVInsulationActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="description" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Min :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinISC" aria-describedby="helpId" placeholder="ISC" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMinINS" aria-describedby="helpId" placeholder="INS" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMinOSC" aria-describedby="helpId" placeholder="OSC" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Nom :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessNomISC" aria-describedby="helpId" placeholder="ISC" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomINS" aria-describedby="helpId" placeholder="INS" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomOSC" aria-describedby="helpId" placeholder="OSC" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness ISC Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessISCStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness INS Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessINSStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness OSC Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessOSCStartMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCStartNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCStartMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness ISC End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessISCEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessISCEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness INS End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessINSEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessINSEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness OSC End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessOSCEndMin" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCEndNom" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessOSCEndMax" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <a class="carousel-control-prev" href="#CCVInsulation" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#CCVInsulation" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="screen">

            <div id="screen" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option4" id="Screen_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findScreenStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfScreen">
                                        @csrf
                                        <h2 class="text-center">Screen Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.screen') }}" class="clearfix screenActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Strandard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Size / Type ) :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size_type" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overLapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Number Of Wire * Wire Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="numberOfWire_wireDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>( Tape/ Wire) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tape_wire_weight" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">

                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="color" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">

                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeWeight" aria-describedby="helpId">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="wireWeight" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="overLapActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual2" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual3" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual4" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfter1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter2" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter3" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter4" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeDimention" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option4" id="Screen_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findScreenStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfScreen">
                                        @csrf
                                        <h2 class="text-center">Screen Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.screen') }}" class="clearfix screenActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Strandard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Size / Type ) :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size_type" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overLapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Number Of Wire * Wire Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="numberOfWire_wireDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>( Tape/ Wire) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tape_wire_weight" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">

                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="color" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">

                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeWeight" aria-describedby="helpId">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="wireWeight" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="overLapActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual2" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual3" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual4" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfter1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter2" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter3" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter4" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeDimention" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option4" id="Screen_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findScreenStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfScreen">
                                        @csrf
                                        <h2 class="text-center">Screen Page 3</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.screen') }}" class="clearfix screenActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Strandard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>(Size / Type ) :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size_type" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overLapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Number Of Wire * Wire Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="numberOfWire_wireDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>( Tape/ Wire) Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tape_wire_weight" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">

                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="color" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">

                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeWeight" aria-describedby="helpId">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="wireWeight" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="overLapActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual2" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual3" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="overLapActual4" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <div class="fourthInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfter1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter2" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter3" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimAfter4" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeDimention" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#screen" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#screen" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="assembly">

            <div id="assembly" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option5" id="Assembly_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findAssemblyStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfAssembly">
                                        @CSRF
                                        <h2 class="text-center">Assembly Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.assembly') }}" class="clearfix assemblyActual" data-update="false" data-form-item="1">
                                        @CSRF
                                        <h2 class="text-center">Standard</h2>

                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim:</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="outerDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="outerDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="outerDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row twisted">
                                                        <label>Filler / p.p Tape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerStandard" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input twisted_select" name="twistedStandard" aria-describedby="helpId" required>
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
                                                        <label>Over Lap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overLap" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>

                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="color" aria-describedby="helpId" placeholder="red-red-red-red-red">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim:</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outerDimActual" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Direction :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="direction" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row twisted">
                                                        <label>Filler :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerActual" aria-describedby="helpId">
                                                        <select disabled class="form-control d-inline input twisted_select" name="twistedActual" aria-describedby="helpId">
                                                            <option value="Twisted">Twisted</option>
                                                            <option value="Not Twisted">Not Twisted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>P.P Tape :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ppTape" aria-describedby="helpId" placeholder="Size / Over Lap">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select disabled class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea disabled type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option5" id="Assembly_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>
                                <div class="content">

                                    <form action="{{ route('admin.findAssemblyStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfAssembly">
                                        @CSRF
                                        <h2 class="text-center">Assembly Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.assembly') }}" class="clearfix assemblyActual" data-update="false" data-form-item="2">
                                        @CSRF
                                        <h2 class="text-center">Standard</h2>

                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim:</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="outerDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="outerDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="outerDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row twisted">
                                                        <label>Filler / p.p Tape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerStandard" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input twisted_select" name="twistedStandard" aria-describedby="helpId" required>
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
                                                        <label>Over Lap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overLap" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>

                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="color" aria-describedby="helpId" placeholder="red-red-red-red-red">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim:</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outerDimActual" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Direction :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="direction" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row twisted">
                                                        <label>Filler :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerActual" aria-describedby="helpId">
                                                        <select disabled class="form-control d-inline input twisted_select" name="twistedActual" aria-describedby="helpId">
                                                            <option value="Twisted">Twisted</option>
                                                            <option value="Not Twisted">Not Twisted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>P.P Tape :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ppTape" aria-describedby="helpId" placeholder="Size / Over Lap">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select disabled class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea disabled type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option5" id="Assembly_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findAssemblyStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfAssembly">
                                        @CSRF
                                        <h2 class="text-center">Assembly Page 3</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.assembly') }}" class="clearfix assemblyActual" data-update="false" data-form-item="3">
                                        @CSRF
                                        <h2 class="text-center">Standard</h2>

                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim:</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="outerDimMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="outerDimNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="outerDimMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row twisted">
                                                        <label>Filler / p.p Tape :</label>
                                                        <div class="fix-group">
                                                            <input type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerStandard" aria-describedby="helpId" required>
                                                            <select class="form-control d-inline input twisted_select" name="twistedStandard" aria-describedby="helpId" required>
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
                                                        <label>Over Lap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overLap" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="layLengthStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>

                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId" placeholder="10-20-30-40-50">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="color" aria-describedby="helpId" placeholder="red-red-red-red-red">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim:</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outerDimActual" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Lay Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="layLengthActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Direction :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="direction" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="row twisted">
                                                        <label>Filler :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input twisted_input" name="fillerActual" aria-describedby="helpId">
                                                        <select disabled class="form-control d-inline input twisted_select" name="twistedActual" aria-describedby="helpId">
                                                            <option value="Twisted">Twisted</option>
                                                            <option value="Not Twisted">Not Twisted</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>P.P Tape :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ppTape" aria-describedby="helpId" placeholder="Size / Over Lap">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select disabled class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea disabled type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#assembly" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#assembly" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="bedding">

            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option3" id="Bedding_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findBeddingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfBedding">
                                        @csrf
                                        <h2 class="text-center">Bedding Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.bedding') }}" class="clearfix beddingActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>ThicknessEnd :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Bedding_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findBeddingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfBedding">
                                        @csrf
                                        <h2 class="text-center">Bedding Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.bedding') }}" class="clearfix beddingActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>ThicknessEnd :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="armouring">

            <div id="armouring" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option7" id="Armouring_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findArmouringStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfArmouring">
                                        @csrf
                                        <h2 class="text-center">Armouring Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.armouring') }}" class="clearfix armouringActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Gap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overGapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape dimention :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeDimention" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Number Of Wire * Wire Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="numberOfWire_wireDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire / Tape :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="wire_tape" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Gap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overGapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="direction" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option7" id="Armouring_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findArmouringStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfArmouring">
                                        @csrf
                                        <h2 class="text-center">Armouring Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.armouring') }}" class="clearfix armouringActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Gap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overGapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape dimention :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="tapeDimention" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Number Of Wire * Wire Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="numberOfWire_wireDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Wire / Tape :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="wire_tape" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Gap :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="overGapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Direction :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="direction" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#armouring" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#armouring" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="Lead">

            <div id="lead" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option1" id="Lead_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>



                                <div class="content">

                                    <form action="{{ route('admin.findLeadStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfLead">
                                        @csrf
                                        <h2 class="text-center">Lead Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.lead') }}" class="clearfix leadActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Description:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="description" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfterStart" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfterEnd" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option2" id="Lead_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findLeadStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfLead">
                                        @csrf
                                        <h2 class="text-center">Lead Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.lead') }}" class="clearfix leadActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Description:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="description" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfterStart" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfterEnd" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Lead_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findLeadStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfLead">
                                        @csrf
                                        <h2 class="text-center">Lead Page 3</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.lead') }}" class="clearfix leadActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="size" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Description:</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="description" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfterStart" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="dimAfterEnd" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#lead" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#lead" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="taps">

            <div id="taps" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option9" id="Taps_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findTapsStandard') }}" class="clearfix  numberOfJopOrder searchJopOrderNumberOfTaps">
                                        @csrf
                                        <h2 class="text-center">Taps Page 1</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.taps') }}" class="clearfix tapsActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>

                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="overLapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeDimentionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>

                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeDimentionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="overLapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select disabled class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea disabled type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option9" id="Taps_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findTapsStandard') }}" class="clearfix  numberOfJopOrder searchJopOrderNumberOfTaps">
                                        @csrf
                                        <h2 class="text-center">Taps Page 2</h2>

                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.taps') }}" class="clearfix tapsActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>

                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="overLapStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeDimentionStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Diameter :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outerDiameter" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeWeightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>

                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Dimention :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeDimentionActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Tape Weight :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="tapeWeightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Over Lap :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="overLapActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="dimAfter" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select disabled class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea disabled type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>
                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#taps" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#taps" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

        <div class="sheathing">

            <div id="sheathing" class="carousel slide" data-ride="carousel" data-interval="false" data-wrap="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="popUp popUp_data_option3" id="Sheathing_1" data-item="0">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findSheathingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfSheathing">
                                        @csrf
                                        <h2 class="text-center">Sheathing Page 1</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.sheathing') }}" class="clearfix sheathingActual" data-update="false" data-form-item="1">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Sheathing_2" data-item="1">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findSheathingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfSheathing">
                                        @csrf
                                        <h2 class="text-center">Sheathing Page 2</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.sheathing') }}" class="clearfix sheathingActual" data-update="false" data-form-item="2">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Sheathing_3" data-item="2">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findSheathingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfSheathing">
                                        @csrf
                                        <h2 class="text-center">Sheathing Page 3</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.sheathing') }}" class="clearfix sheathingActual" data-update="false" data-form-item="3">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>
                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessMinStandard" aria-describedby="helpId" placeholder="Min" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessNomStandard" aria-describedby="helpId" placeholder="Nom" required>
                                                            <input type="text" class="form-control d-inline input" name="thicknessMaxStandard" aria-describedby="helpId" placeholder="Max" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <h2 class="text-center">Actual</h2>
                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessStartMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessStartMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="thicknessEndMinActual" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndNomActual" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="thicknessEndMaxActual" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimBefore1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="dimBefore2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterStartMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterStartMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <div class="thirdInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="dimAfterEndMin" aria-describedby="helpId" placeholder="Min">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndNom" aria-describedby="helpId" placeholder="Nom">
                                                            <input type="text" class="form-control d-inline input" name="dimAfterEndMax" aria-describedby="helpId" placeholder="Max">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <div class="secondInput">
                                                            <input type="text" class="form-control d-inline ml-1 input" name="ovalityActual1" aria-describedby="helpId">
                                                            <input type="text" class="form-control d-inline input" name="ovalityActual2" aria-describedby="helpId">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="popUp popUp_data_option3" id="Sheathing_4" data-item="3">

                            <div class="box">
                                <i class="fas fa-minus-circle"></i>

                                <div class="content">

                                    <form action="{{ route('admin.findSheathingStandard') }}" class="clearfix numberOfJopOrder searchJopOrderNumberOfSheathing">
                                        @csrf
                                        <h2 class="text-center">Sheathing Page 4</h2>
                                        <div class="form-group">
                                            <label>Jop Order Number :</label>
                                            <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Get Standard</span>
                                        </button>

                                    </form>

                                    <form action="{{ route('admin.sheathing') }}" class="clearfix sheathingActual" data-update="false" data-form-item="4">
                                        @csrf
                                        <h2 class="text-center">Standard</h2>

                                        <div class="row standard">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Jop Order Number :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="jopOrderNumber" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Size :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="cableSize" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Cable Description :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="cableDescription" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Volt :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="volt" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Thickness :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="thicknessStandard" aria-describedby="helpId" placeholder="Min/Nom/Max" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="eccentricityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Outer Dim :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outerDim" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality % :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ovalityStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>material :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="material" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="colorStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="sparkStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="weightStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="materialStandard" aria-describedby="helpId" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <h2 class="text-center">Actual</h2>

                                        <div class="row actual">

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Machine :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="machine" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Input Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="inputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Card :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputCard" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Output Length :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="outputLength" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Apperance Of Drum :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="apperanceOfDrum" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Color :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="colorActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Message :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="message" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>ThicknessStart :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="thicknessStartActual" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>ThicknessEnd :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="thicknessEndActual" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Eccentricity % :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="eccentricityActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim Before :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="dimBefore" aria-describedby="helpId" placeholder="10-20 Or 10*20">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After Start :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="dimAfterStart" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Dim After End :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="dimAfterEnd" aria-describedby="helpId" placeholder="Min/Nom/Max">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Weight :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="weightActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Material :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="materialActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Ovality :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="ovalityActual" aria-describedby="helpId" placeholder="10-20">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Meter Measuring :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="meterMeasuring" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Spark :</label>
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="sparkActual" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Status :</label>
                                                        <select disabled class="form-control d-inline ml-2 input" name="status" aria-describedby="helpId">
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
                                                        <input disabled type="text" class="form-control d-inline ml-2 input" name="productionOperator" aria-describedby="helpId">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-3">
                                                <div class="item">
                                                    <div class="form-group">
                                                        <label>Notes :</label>
                                                        <textarea disabled type="text" class="form-control d-inline ml-2" name="notes" aria-describedby="helpId"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button disabled class="btn btn-info my-3 float-right mr-3" type="submit">
                                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <span>Send</span>
                                        </button>

                                    </form>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#sheathing" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#sheathing" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>

        </div>

    </div>


    <script src="{{ asset('layout/JavaScript/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Popper.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/JMA.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Home/Admin/Home.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Home/Admin/Home.js') }}"></script>
    <script src="https://js.pusher.com/6.0/pusher.min.js"></script>
    <script src="{{ asset('layout/JavaScript/Home/Admin/WatchingEmployee.js') }}"></script>
</body>

</html>