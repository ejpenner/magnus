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

<div class="jumbotron" id="header-background">
    <div class="container text-center">
        <h1>Gallery App</h1>
        <p>The Appening</p>
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
                <li @if(Request::is('/')) class="active" @endif ><a href="{{ action('HomeController@index') }}">Home</a></li>
                <li @if(Request::is('featured')) class="active" @endif ><a href="#">Featured</a></li>
                <li @if(Request::is('recent')) class="active" @endif ><a href="#">Recent</a></li>
                <li @if(Request::is('gallery')) class="active" @endif ><a href="{{ action('GalleryController@index') }}">Galleries</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check() and Auth::user()->hasRole("admin"))
                    <li @if(Request::is('admin')) class="active dropdown" @else class="dropdown" @endif>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin Panel <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ action('UserController@index') }}">Users</a></li>
                            <li><a href="{{ action('PermissionController@index') }}">Permissions</a></li>
                        </ul>
                    </li>
                @endif
                @if(Auth::check())
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"> {{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ action('UserController@manageAccount', Auth::user()->id) }}"><span class="fa fa-user"></span> Account</a></li>
                                <li><a href="/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                            </ul>
                        </li>
                @else
                    <li><a href="/login"><span class="fa fa-user"></span> Login</a></li>
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