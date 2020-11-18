<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Register</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/Navbar/Navbar.css') }}">
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/Register/Register.css') }}">

    <link rel="stylesheet" href="{{ asset('layout/css/animate.min.css') }}">

</head>

<body>


    @include('layout.navbar')



    <div class="container my-5">

        <div class="register">

            <div class="box">

                <div class="header">
                    <h4>Register</h4>
                </div>

                <div class="form">



                    <p class="text-success"></p>

                    <form id="Register" action-admin="{{ route('register.admin.code') }}" action-employee="{{ route('register.employee') }}" class="clearfix">

                        @csrf

                        <div class="form-group">
                            <label for="">Name : </label>
                            <input type="text" class="form-control" name="name" id="name" autocomplete="off" value="{{old('name')}}">
                            <p class="alert alert-danger mt-2 d-none" data-error="name"></p>
                        </div>

                        <div class="form-group">
                            <label for="">Email : </label>
                            <input type="text" class="form-control" name="email" id="email" autocomplete="off" value="{{old('email')}}">
                            <p class="alert alert-danger mt-2 d-none" data-error="email"></p>
                        </div>

                        <div id="SendCode" class="form-group d-none">
                            <label for="">Code : </label>
                            <div class="row">
                                <div class="col-10">
                                    <input type="text" class="form-control" name="code" id="code" autocomplete="off" value="{{old('code')}}">
                                </div>
                                <div class="col-2">
                                    <button id="SendCodeButton" type="button" class="btn" data-route="{{ route('register.admin') }}"><i class="far fa-arrow-alt-circle-right"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Password : </label>
                            <label class="password">
                                <input type="password" class="form-control" name="password" id="password" autocomplete="off" value="{{old('password')}}">
                                <i class="fas fa-eye"></i>
                                <i class="fas fa-eye-slash"></i>
                            </label>
                            <p class="alert alert-danger mt-2 d-none" data-error="password"></p>
                        </div>

                        <div class="form-group">
                            <label for="">Class :</label>
                            <select class="form-control" name="class" id="class">
                                <option value="employee">Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <button class="btn float-right" type="submit">
                            <i class="bug fas fa-exclamation-triangle d-none text-warning"></i>
                            <span class="spinner spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span>Submit</span>
                        </button>

                    </form>

                </div>

            </div>

        </div>


    </div>



    <script src="{{ asset('layout/JavaScript/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Popper.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/JMA.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Register/Register.js') }}"></script>

    <script>
        $(".password i.fa-eye").click(function() {
            $("#password").attr('type', 'text');
            $(this).fadeOut();
            $(".password i.fa-eye-slash").fadeIn();
        })
        $(".password i.fa-eye-slash").click(function() {
            $("#password").attr('type', 'Password');
            $(this).fadeOut();
            $(".password i.fa-eye").fadeIn();
        })
    </script>


</body>


</html>