<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/admin/plugins/summernote/summernote-bs4.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.layouts.components.navbar')
    @include('admin.layouts.components.sidebar')
    <div class="content-wrapper">
        @yield('breadcrumbs')
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
    @include('admin.layouts.components.footer')
    <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<script src="{{ asset('/assets/admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('/assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('/assets/admin/dist/js/adminlte.js') }}"></script>
@stack('script_js')
</body>
</html>
