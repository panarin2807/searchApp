<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <img src="{{ asset('image/nav_logo.png') }}" height="auto" width="100%" style="max-width: 280px" />
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
                        {{-- <a href="{{ URL::to('admin/user') }}" class="nav-link">จัดการผู้ใช้</a> --}}
                        <li class="nav-item dropdown">
                            <a href="#" id="reportDropdown" class="nav-link dropdown-toggle" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>จัดการผู้ใช้</a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reportDropdown">
                                <a href="{{ URL::to('admin/user') }}" class="dropdown-item">นักศึกษา</a>
                                <a href="{{ route('admin.managePersonel') }}" class="dropdown-item">บุคลากร</a>
                            </div>
                        </li>
                        <a href="{{ route('project.index') }}" class="nav-link">จัดการโครงงาน</a>
                        {{-- <a href="{{ route('admin.setting') }}" class="nav-link">ตั้งค่า Config</a> --}}
                    @endif
                    @if (Auth::guard('web')->user()->type == 1)
                        <li class="nav-item dropdown">
                            <a href="#" id="reportDropdown" class="nav-link dropdown-toggle" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>รายงาน</a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="reportDropdown">
                                <a href="{{ route('reportGroup') }}" class="dropdown-item">รายงานแยกตามหมวดหมู่</a>
                                <a href="{{ route('reportTeacher') }}" class="dropdown-item">รายงานแยกตามที่ปรึกษา</a>
                            </div>
                        </li>
                    @endif
                    <a href="{{ url('/home') }}" class="nav-link">ค้นหาโครงงาน</a>
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
                            {{-- <a href="{{ route('home') }}" class="dropdown-item">Dashboard</a> --}}
                            {{-- @if (Auth::guard('web')->user()->type != 2)
                                <a href="{{ url('user/' . Auth::guard('web')->user()->id . '/edit') }}"
                                    class="dropdown-item">Account Setting</a>
                            @endif --}}
                            <a href="{{ url('user/' . Auth::guard('web')->user()->id . '/edit') }}"
                                class="dropdown-item">Account Setting</a>
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
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li> --}}
                @endif
            </ul>
        </div>
    </div>
</nav>
