<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Appeal') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Header -->
    @include('headerNew')

    <!-- Sidebar -->
    @include('sidebarNew')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $page_title ?? "Title" }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Page</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')
        </section>
        <!-- /.content -->
    </div>

    <!-- Footer -->
    @include('footer')

</div>
<!-- ./wrapper -->




<!--**********************************
      Scripts
  ***********************************-->
<!-- Required vendors -->
<script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/js/deznav-init.js') }}"></script>
<script src="{{ asset('assets/vendor/owl-carousel/owl.carousel.js') }}"></script>

<!-- Chart piety plugin files -->
<script src="{{ asset('assets/vendor/peity/jquery.peity.min.js') }}"></script>

<!-- Apex Chart -->
<script src="{{ asset('assets/vendor/apexchart/apexchart.js') }}"></script>

<!-- Dashboard 1 -->
<script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script>




</body>
</html>
