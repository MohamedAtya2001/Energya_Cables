<nav class="navbar navbar-expand-sm navbar-light bg-light" id="Navbar">
    <div class="container">
        @if(Auth::guard('web')->check())
        <a class="navbar-brand" href="{{ route('user.home') }}"><img src="{{ asset('layout/images/Home/logo.gif') }}" alt="" class="img-fluid"></a>
        @elseif(Auth::guard('admin')->check())
        <a class="navbar-brand" href="{{ route('admin.home') }}"><img src="{{ asset('layout/images/Home/logo.gif') }}" alt="" class="img-fluid"></a>
        @endif
        <div class="dropdown">
            <button class="btn dropdown-toggle d-block ml-auto" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if(Auth::guard('web')->check())
                {{ Auth::guard('web')->user()->name }}
                @elseif(Auth::guard('admin')->check())
                {{ Auth::guard('admin')->user()->name }}
                @endif
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @if(Auth::guard('admin')->check())
                <a class="dropdown-item" href="{{ route('admin.home') }}">Sheets</a>
                @endif
                @if(Auth::guard('admin')->check())
                <a class="dropdown-item" href="{{ route('register') }}">Register</a>
                <a class="dropdown-item" href="{{ route('admin.show.standard.drowing') }}">Standard Sheets</a>
                <a class="dropdown-item" href="{{ route('admin.show.actual.drowing') }}">Actual Sheets</a>
                <a class="dropdown-item" href="{{ route('report.hold') }}">Reports</a>
                <a class="dropdown-item" href="{{ route('admin.show.admin') }}">Admins</a>
                <a class="dropdown-item" href="{{ route('admin.show.employee') }}">Employees</a>
                @endif
                @if(Auth::guard('web')->check())
                <a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a>
                @elseif(Auth::guard('admin')->check())
                <a class="dropdown-item" href="{{ route('admin.logout') }}">Logout</a>
                @endif
            </div>
        </div>
</nav>