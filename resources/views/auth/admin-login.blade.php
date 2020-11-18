<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Admin Login</title>

    <link rel="stylesheet" href="{{ asset('layout/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('layout/css/all.min.css') }}">
    <!-- For Style.css -->
    <link rel="stylesheet" href="{{ asset('layout/css/Login/Login.css') }}">


</head>

<body>

    <div class="container">
        <div class="box">
            <div class="login loginAdmin">
                <a class="employee" href="{{ route('user.login') }}">Employee</a>
                <h1 class="text-info text-center mb-4">Login</h1>
                @if(session('invalid'))
                <p class="text-danger">{{ session('invalid') }}</p>
                @endif
                <form action="{{ route('admin.login.submit') }}" method="POST" class="clearfix">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="User Name..." autocomplete="off" value="{{ old('email') }}">
                        @error('email')
                        <p class="alert alert-danger mt-2">
                            {{$message}}
                        </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="password">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Your Password..." autocomplete="off" value="{{ old('password') }}">
                            <i class="fas fa-eye"></i>
                            <i class="fas fa-eye-slash"></i>
                        </label>
                        @error('password')
                        <p class="alert alert-danger mt-2">
                            {{$message}}
                        </p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary float-right">Submit</button>

                </form>

            </div>
        </div>
    </div>



    <script src="{{ asset('layout/JavaScript/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Popper.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/bootstrap.min.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/JMA.js') }}"></script>
    <script src="{{ asset('layout/JavaScript/Login/Login.js') }}"></script>
</body>


</html>