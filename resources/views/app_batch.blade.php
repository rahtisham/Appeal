<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($pageTitle)?$pageTitle.' | ':'' }}{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style type="text/css">
      .content-wrapper, .main-header {
        margin-left: 250px !important;
      }
      [class*=sidebar-dark-] {
          background-color: #041e42;
      }
    </style>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script type="text/javascript">
      function openbatch(){
          $('#myModal').modal('show');
      }
      function mskumodal(){
          $('#mskuModal').modal('show');
      }
      function editbatch(id){
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $.ajax({
            type:'POST',
            url:'{{ URL::to("batch/edit_batch") }}',  
            data: {id: id},
            dataType: 'json',
            success:function(html){
                console.log(html);
            }
        });
        $('#myModal').modal('show');
      }
      $(document).ready(function(){

        $('#mskusubmit').click(function(e){
            e.preventDefault();
            $.ajax({
              type: 'post',
              url: '{{ URL::to("createmsku") }}',
              data: $('#mskuform').serialize(),
              success: function () {
                $('#mskuModal').modal('hide');
                $('.shipping_item').css('display','block');
              }
            });
        });

        /*$('#mskuform').on('submit', function (e) {

          e.preventDefault();

          $.ajax({
            type: 'post',
            url: '{{ URL::to("createmsku") }}',
            data: $('#mskuform').serialize(),
            success: function () {
              alert('form was submitted');
            }
          });

        });*/
        
        $('#search_asin').click(function(){
          var searchtxt = $('#asin_txt').val();
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          })
          $.ajax({
              type:'POST',
              url:'{{ URL::to("searchAsin") }}',  
              data: {txt: searchtxt},
              dataType: 'json',
              beforeSend: function() {
                $("#itemtbl").empty();
              },
              success:function(data){

                var markup = '<thead><tr><th style="width: 20%">Image</th><th style="width: 40%">Title</th><th style="width: 20%">Product Type</th><th style="width: 10%">Rank</th><th style="width: 10%"></th></tr></thead><tbody><tr><td><img src="'+data.image+'" alt="Image" width="100"></td><td>'+data.title+'</td><td>'+data.product_group+'</td><td>'+data.rank+'</td><td class="project-actions text-right"><a class="btn btn-info btn-sm" href="#" onclick="mskumodal();">Select</a></td></tr></tbody>';
              
                $("#itemtbl").append(markup);
                $("#itemasin").val(data.asin);
              },
              error: function () {
                var markup = '<tr><th colspan="5">No Item found for this ASIN.</th></tr>';
                $("#itemtbl").append(markup);
              }
          });
        });
      });
    </script>

</head>
<body class="hold-transition layout-top-nav">
<div class="loader">
  <img class="loader_img" src="{{ asset('/storage/images/loader.gif') }}">
</div>  
<div class='progresstop' id="progress_div">
  <div class='bar' id='bar1'></div>
  <div class='percent' id='percent1'></div>
</div>
<input type="hidden" id="progress_width" value="0">
<div class="wrapper">

  <!-- Header -->
  @include('header')
  @include('sidebar')

  <!-- Sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@yield('title')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
               <?php $segments = ''; ?>
                @foreach(Request::segments() as $segment)
                    <?php $segments .= '/'.$segment; ?>
                    <li class="breadcrumb-item active">
                        {{ucwords($segment)}}
                    </li>
                @endforeach
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <!-- Your Page Content Here -->
      @yield('content')
    </div>
    <!-- /.content -->
  </div>

   <!-- Footer -->
  @include('footer')

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->

</body>
</html>
