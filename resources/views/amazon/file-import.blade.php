@extends('app')

@section('title', 'Product Import Export')

@section('content')

<script type="text/javascript">

    function progressBar() {
        $(".progress").show();

        var elem = document.getElementById("progress-bar");
        var width = 1;
        var interval;

        resetProgressBar();

        interval = setInterval(frame, 100);

        function frame() {
            if (width >= 100) {
              clearInterval(interval);
            } else {
              width++;
              elem.style.width = width + '%';
            }
        }
    }

    function resetProgressBar() {
        var elem = document.getElementById("progress-bar");
        var width = 1;
        var interval;

        width = 1;
        clearInterval(interval)
        elem.style.width = width + '%';
    }
</script>

<section class="content">
    <div class="container">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                @if(Session::has('message'))
                    <div class="alert {{ Session::get('alert-class') }}">
                       {{ Session::get('message') }}
                    </div>
                @endif
                <!-- jquery validation -->
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Product Import Export</h3>
                        <form method="get" action="storage/sample.csv">
                            <button style="float: right;" type="submit" class="btn btn-default btn-sm">Download Sample CSV</button>
                        </form>
                    </div>

                    <form action="{{ route('fileExport') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="categoryurl">CSV</label>
                                <input type="file" name="csvfile">
                            </div>
                            <div class="progress" style="display: none;">
                              <div class="progress-bar bg-primary progress-bar-striped" id="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                <span class="sr-only"></span>
                              </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" onclick="progressBar()" name="export" class="btn btn-primary">Export Details</button>
                            <button type="submit" name="import" class="btn btn-warning">Import Details</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection