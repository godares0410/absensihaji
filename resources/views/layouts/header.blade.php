<header class="main-header">
    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <span class="logo-mini"><b>A</b>LT</span>
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(auth()->user()->foto)
                        <img src="{{ asset('image/' . auth()->user()->foto) }}" class="user-image" alt="User Image">
                        @else
                        <img src="{{ asset('image/icon.png') }}" class="user-image" alt="User Image">
                        @endif
                        <span class="hidden-xs">{{ auth()->user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            @if(auth()->user()->foto)
                            <img src="{{ asset('image/' . auth()->user()->foto) }}" class="img-circle" alt="User Image">
                            @else
                            <img src="{{ asset('image/icon.png') }}" class="img-circle" alt="User Image">
                            @endif
                            <p>
                                {{ auth()->user()->name ?? 'Admin' }} - Administrator
                                <small>Member since {{ optional(auth()->user())->created_at->format('M. Y') ?? 'Nov. 2023' }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>