<!DOCTYPE html>
<html lang="en">
@include('layouts.head')

<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        @include('layouts.header')
        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('layouts.footer')
        @include('layouts.control-sidebar')
    </div>

    @include('layouts.scripts')
</body>

</html>