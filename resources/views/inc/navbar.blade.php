<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @if (Auth::guard('web')->check())
                    @if (Auth::guard('web')->user()->type == 2)
                        <a href="{{ URL::to('admin/user') }}" class="nav-link">จัดการผู้ใช้</a>
                        {{-- <a href="{{ route('admin.setting') }}" class="nav-link">ตั้งค่า Config</a> --}}
                    @endif
                    <a href="{{ route('project.create') }}" class="nav-link">เพิ่มโครงงาน</a>
                    <li class="nav-item dropdown">
                        @if (Auth::guard('web')->user()->type == 0)
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('web')->user()->fname }} (Student)<span class="caret"></span>
                            </a>
                        @elseif(Auth::guard('web')->user()->type == 1)
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('web')->user()->fname }} (Teacher)<span class="caret"></span>
                            </a>
                        @else
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('web')->user()->fname }} (Admin)<span class="caret"></span>
                            </a>
                        @endif
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a href="{{ route('home') }}" class="dropdown-item">Dashboard</a>
                            @if (Auth::guard('web')->user()->type != 2)
                                <a href="{{ url('user/' . Auth::guard('web')->user()->id . '/edit') }}"
                                    class="dropdown-item">Account Setting</a>
                            @endif
                            <a class="dropdown-item" href="#"
                                onclick="event.preventDefault();document.querySelector('#logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
