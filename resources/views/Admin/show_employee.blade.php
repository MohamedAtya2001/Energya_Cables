<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>show Employee</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/ShowEmployee/ShowEmployee.css') }}">


</head>

<body>
    @include('layout.navbar')


    <h1 class="text-center my-4">Employees</h1>

    <div id="Employee" class="container-fluid container-lg">

        <div class="filter my-5">

            <div class="filterValue mx-auto">
                <div class="row align-items-center justify-content-center">
                    <div class="col-6 col-md-5">
                        <select class="form-control d-inline input" name="fillerName" id="FilterName" aria-describedby="helpId" required>
                            <option value="name">Name</option>
                            <option value="shift">Shift</option>
                            <option value="activation">Activation</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-5">
                        <div id="Shift" class="form-control">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="shift_1" id="Shift_1" onclick="shiftFilter(this)" checked>
                                <label class="custom-control-label" for="Shift_1">Shift 1</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="shift_2" id="Shift_2" onclick="shiftFilter(this)" checked>
                                <label class="custom-control-label" for="Shift_2">Shift 2</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="shift_3" id="Shift_3" onclick="shiftFilter(this)" checked>
                                <label class="custom-control-label" for="Shift_3">Shift 3</label>
                            </div>
                        </div>
                        <div id="Activation" class="form-control">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="online" id="Online" onclick="activationFilter(this)" checked>
                                <label class="custom-control-label" for="Online">Online</label>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="offline" id="Offline" onclick="activationFilter(this)" checked>
                                <label class="custom-control-label" for="Offline">Offline</label>
                            </div>
                        </div>
                        <input type="text" class="form-control w-100 input" id="FilterValue" name="fillerValue" aria-describedby="helpId" autocomplete="off">
                    </div>
                    <div class="col-12 col-md-2 p-0 mt-3 mr-3 m-md-0">
                        <button class="btn btn-info d-block ml-auto" id="Filter">
                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span>Get Employees</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID : </th>
                    <th>Name : </th>
                    <th>Shift : </th>
                    <th>Activation : </th>
                    <th>Options : </th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

    </div>

    <div class="container clearfix">
        <button class="float-right btn d-none mr-3 my-3" data-count-rows="25" id="Limit">
            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            <span>See More</span>
        </button>
    </div>

    <div id="MakeSure">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>

            <h4 class="text-warning">Are You Sure ?</h4>

            <button id="Yes" class="btn btn-danger my-3 float-right mr-3">
                <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                <span>Yes</span>
            </button>
            <button id="No" class="btn btn-info my-3 float-right mr-3">No</button>

        </div>
    </div>

    <div id="Edit">
        <div class="box clearfix">
            <i class="far fa-times-circle"></i>
            <h2 class="text-center my-4">Edit Employee</h2>

            <form class="m-auto clearfix" action="{{ route('admin.editEmployee.employee') }}">
                @csrf
                <p class="text-success updated d-none"></p>
                <div class="form-group mb-4">
                    <label for="">Name : </label>
                    <input type="text" class="form-control input mb-2 pl-2" name="name" id="name" autocomplete="off" value="{{old('name')}}">
                    <p class="text-danger d-none" data-error-name="name"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="">Email : </label>
                    <input type="text" class="form-control input mb-2 pl-2" name="email" id="email" autocomplete="off" value="{{old('email')}}">
                    <p class="text-danger d-none" data-error-name="email"></p>
                </div>

                <div class="form-group mb-4">
                    <label for="">Reset Password : </label>
                    <label class="password">
                        <input type="password" class="form-control input mb-2 pl-2" name="password" id="password" autocomplete="off" value="{{old('password')}}">
                        <i class="fas fa-eye"></i>
                        <i class="fas fa-eye-slash"></i>
                    </label>
                    <p class="text-danger d-none" data-error-name="password"></p>
                </div>

                <button class="btn btn-info my-3 float-right mr-3" type="submit">
                    <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                    <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <span>Edit</span>
                </button>
            </form>

        </div>
    </div>



    <script src="{{ asset('layout/JavaScript/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Popper.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/JMA.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/ShowEmployee/ShowEmployee.js') }}"></script>


</body>


</html>