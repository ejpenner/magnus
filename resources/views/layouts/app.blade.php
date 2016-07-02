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
    </div>
</div>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar">Test</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('HomeController@recent') }}">Magnus</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li class="dropdown" @if(Request::is('/')) class="active" @endif >
                    <a class="dropdown-toggle" data-toggle="dropdown" href="{{ action('HomeController@recent') }}"> Home <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ action('HomeController@recent', 'hot') }}">Hot</a></li>
                        <li><a href="{{ action('HomeController@recent', 'popular') }}">Popular</a></li>
                        <li><a href="{{ action('HomeController@recent') }}">New</a></li>
                    </ul>
                </li>
                <li @if(Request::is('featured')) class="active" @endif >
                    <a href="#">Featured</a>
                </li>
                <li @if(Request::is('galleria')) class="active" @endif >
                    <a href="{{ action('GalleryController@index') }}">Galleries</a>
                </li>
                <li @if(Request::is('nova/submit')) class="active" @endif >
                    <a href="{{ action('OpusController@submit') }}">Submit</a>
                </li>
                <li @if(Request::is('search')) class="active" @endif >
                    {!! Form::open(['url'=>'/search/', 'method'=>'get', 'class'=>'navbar-form navbar-left', 'role'=>'search', 'onsubmit'=>'return false;']) !!}
                    <div class="row form-group">
                        <div class="search-area">
                            <div class="search-box">
                                <input type="text" class="form-control" placeholder="Search..." name="q" value="{{ Magnus::getSearchQuery() }}" id="search-terms">
                            </div>
                        </div>

                    </div>
                    {!! Form::submit('Search', ['class' => 'form-control btn btn-primary', 'onclick'=>'window.location.href=this.form.action +\'/\'+ this.form.q.value;']) !!}
                    {!! Form::close() !!}
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check() and Auth::user()->atLeastHasRole(Config::get('roles.admin-code')))
                    <li @if(Request::is('admin')) class="active dropdown" @else class="dropdown" @endif>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin Panel <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ action('UserController@index') }}">Users</a></li>
                            <li><a href="{{ action('RoleController@index') }}">User Roles</a></li>
                        </ul>
                    </li>
                @endif
                @if(Auth::check())
                    <li><a href="{{ action('NotificationController@index') }}">Messages <small>({{ Auth::user()->messageCount() }})</small></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"> {{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ action('ProfileController@show', Auth::user()->slug) }}"><img src="{{ Auth::user()->getAvatar() }}" width="25px" > My Profile</a></li>
                            <li><a href="{{ action('UserController@manageAccount', Auth::user()->slug) }}"><span class="fa fa-user"></span> Account</a></li>
                            <li><a href="/logout"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        </ul>
                    </li>
                @else
                    <li><a href="/login"><span class="fa fa-user"></span> Login</a></li>
                    <li><a href="/register">Register</a></li>
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
    @unless(Auth::check() and Auth::user()->hasRole(Config::get('roles.banned-code')))
        @yield('content')
    @else
        <h2>You are banned :(</h2>
    @endunless
</div>
<footer class="container-fluid text-center">
    <p>&copy; 2016 <strong>VILEST</strong>udios</p>
</footer>

</body>
</html>