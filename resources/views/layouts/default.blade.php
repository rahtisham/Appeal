<!doctype html>
<html>
<head>

    @if(Auth::user()->isAdmin())
        @include('admin_includes.head')
    @else
        @include('includes.head')
    @endif
    
</head>
<body>


    @if(Auth::user()->isAdmin())
        @include('admin_includes.header')
        @include('admin_includes.sidebar')
        @yield('content')
        @include('admin_includes.footer')
    
    @else
        @include('includes.header')
        @include('includes.sidebar')
        @yield('content')
        @include('includes.footer')
    @endif


       

</body>
</html>