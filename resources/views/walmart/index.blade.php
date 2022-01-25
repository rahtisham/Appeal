@extends('app')

@section('title', 'Walmart Scraping')

@section('content')

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
                        <h3 class="card-title">Walmart Scrap</h3>
                    </div>

                    {!! Form::open(array('route' => 'walmartScrapCat','method'=>'POST')) !!}
                    <div class="card-body">
                        <div class="form-group">
                            <label for="categoryurl">Category Url</label>
                                {!! Form::url('categoryurl', null, array('placeholder' => 'Enter Category Url','class' => 'form-control')) !!}
                        </div>

                        <div class="form-group">
                            <label>OR</label>
                        </div>

                        <div class="form-group">
                            <label for="producturl">Product Url</label>
                                {!! Form::url('producturl', null, array('placeholder' => 'Enter Product Url','class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection