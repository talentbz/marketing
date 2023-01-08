<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title> @yield('title') | Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('admin.layouts.head-css')
</head>

@section('body')
    <body data-sidebar="dark">
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @include('admin.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <!-- loading spinner -->
            <div class="spinner-wrapper">
                <div class="spinner-border text-primary m-1" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- JAVASCRIPT -->
    @include('admin.layouts.vendor-scripts')
    <script>
        $(document).ready(function(){
        //ajax loading spinner
        var loading = $('.spinner-wrapper').hide();
        $(document)
            .ajaxStart(function () {
                loading.show();
            })
            .ajaxStop(function () {
                setTimeout(function(){
                    loading.hide();
                }, 500)
            });
        })
    </script>
</body>

</html>
