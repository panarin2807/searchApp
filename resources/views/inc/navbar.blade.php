<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if(Auth::guard('student')->check())
                <li class="nav-item dropdown">
                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::guard('student')->user()->username }} (Student) <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                        <a href="{{route('student.home')}}" class="dropdown-item">Dashboard</a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#student-logout-form').submit();">
                            Logout
                        </a>
                        <form id="student-logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @elseif(Auth::guard('personel')->check())
                <li class="nav-item dropdown">
                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::guard('personel')->user()->username }} (Personel) <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                        <a href="{{route('student.home')}}" class="dropdown-item">Dashboard</a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#person-logout-form').submit();">
                            Logout
                        </a>
                        <form id="person-logout-form" action="{{ route('person.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('student.register') }}">Register</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>