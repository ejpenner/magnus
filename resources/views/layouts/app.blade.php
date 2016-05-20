<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gallery App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" media="screen" rel="stylesheet" type="text/css"/>

    <style>

    </style>

</head>
<body>

<div class="jumbotron">
    <div class="container text-center">
        <h1>Gallery App</h1>
        <p>Ayyyy lmao</p>
    </div>
</div>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Logo</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li @if(Request::is('home')) class="active" @endif ><a href="{{ action('HomeController@index') }}">Home</a></li>
                <li @if(Request::is('featured')) class="active" @endif ><a href="#">Featured</a></li>
                <li @if(Request::is('recent')) class="active" @endif ><a href="#">Recent</a></li>
                <li @if(Request::is('gallery')) class="active" @endif ><a href="{{ action('GalleryController@index') }}">Galleries</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li><a href="{{ action('ProfileController@index') }}"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }}</a></li>
                @else
                    <li><a href="/login"><span class="glyphicon glyphicon-user"></span> Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="container">
        @include('partials._flash')
        @include('partials._errors')
    </div>
    @yield('content')
</div>
<footer class="container-fluid text-center">
    <p>&copy; 2016 <strong>VILEST</strong>udios</p>
</footer>

</body>
</html>