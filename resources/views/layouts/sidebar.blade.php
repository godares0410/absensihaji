<!-- /Users/admin/Documents/absensinew/resources/views/layouts/sidebar.blade.php -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE-2/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name ?? 'Admin' }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ request()->is('home') ? 'active' : '' }}">
                <a href="{{ url('/home') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ request()->is('data-peserta*') ? 'active' : '' }}">
                <a href="{{ url('/data-peserta') }}">
                    <i class="fa fa-dashboard"></i> <span>Data Peserta</span>
                </a>
            </li>
            <li class="{{ request()->is('data-scan') ? 'active' : '' }}">
                <a href="{{ url('/data-scan') }}">
                    <i class="fa fa-dashboard"></i> <span>Data Scan</span>
                </a>
            </li>
            <li class="{{ request()->is('admin-users') ? 'active' : '' }}">
                <a href="{{ url('/admin-users') }}">
                    <i class="fa fa-dashboard"></i> <span>User Admin</span>
                </a>
            </li>
            <!-- Tambahkan menu lainnya di sini -->
        </ul>
    </section>
</aside>