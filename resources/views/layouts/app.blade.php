<?php $time_start = microtime(true) ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Gallery App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('/js/vendor.js') }}"></script>
    <script src="{{ asset('/js/app.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" media="screen" rel="stylesheet" type="text/css"/>
    <script src="{{ asset('/js/angular.js') }}"></script>
    @yield('header')
    <script type="text/javascript">

    </script>

</head>
<body>
<div class="jumbotron" id="header-background">
    <div class="container text-center">
    </div>
</div>
<div class="top-header">
    <nav class="navbar navbar-inverse" id="mainnav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ action('HomeController@home') }}">Magnus</a>
            </div>
            <div class="collapse navbar-collapse" id="magnus-navbar">
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="{{ action('HomeController@home') }}">
                            Home <i class="caret"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ action('HomeController@home', 'trending') }}">Trending</a></li>
                            <li><a href="{{ action('HomeController@home', 'popular') }}">Popular</a></li>
                            <li><a href="{{ action('HomeController@home') }}">New</a></li>
                        </ul>
                    </li>
                    <li @if(Request::is('featured')) class="active" @endif >
                        <a href="#">Featured</a>
                    </li>
                    <li @if(Request::is('gallery')) class="active" @endif >
                        <a href="{{ action('GalleryController@index') }}">Galleries</a>
                    </li>
                    <li @if(Request::is('submit')) class="active" @endif >
                        <a href="{{ action('OpusController@newSubmission') }}">Submit</a>
                    </li>
                    <li>
                        {!! Form::open(['url'=>'/search/', 'method'=>'get', 'class'=>'navbar-left navbar-form', 'role'=>'search', 'onsubmit'=>'return false;']) !!}
                        <div class="search-area">
                            <div class="search-box input-group">
                                <input type="text" class="form-control" placeholder="Search tags using @tag" name="q" value="{{ Magnus::getSearchQuery() }}" id="search-terms">
                                <span class="input-group-btn">
                                    {!! Form::submit('Search', ['class' => 'btn btn-primary',
                                                     'onclick'=>'window.location.href=this.form.action +\'/\' + this.form.q.value.replace(/\s/, \'+\') + \'?sort=relevance&order=desc\';']) !!}
                                </span>
                            </div>
                        </div>
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
                        <li>
                            <a href="{{ action('NotificationController@index') }}">
                                Messages <span class="badge">{{ Notification::messageCount(Auth::user()) }}</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ action('ProfileController@show', Auth::user()->slug) }}">
                                        <img src="{{ Auth::user()->getAvatar() }}" width="25px"> My Profile</a>
                                </li>
                                <li><a href="{{ action('AccountController@manageAccount', Auth::user()->slug) }}">
                                        <span class="fa fa-user"></span> Account</a>
                                </li>
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
</div>
<div class="main">
    <div class="main-container container-fluid" ng-app="Magnus">
        <div class="container">
            @include('partials._flash')
            @include('partials._errors')
        </div>
        <div class="bg-gradient"></div>
        @unless(Auth::check() and Auth::user()->hasRole(Config::get('roles.banned-code')))
            @yield('content')
            @else
                <h2 class="text-center">You are banned :(</h2>
                @endunless
    </div>
    <?php $end_time = microtime(true); $execution_time = round(($end_time - $time_start)/60, 10); ?>
    <footer class="container-fluid text-center">
        <p>&copy; 2016 <strong>Vile</strong>Studio</p>
        <p><small>{{ config('app.codename') }} v. {{ config('app.version') }} <small>powered by Laravel</small></small></p>
        <p>Rendered in <?=$execution_time ?> seconds</p>
    </footer>
</div>
</body>
</html>