<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"><!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
    <title>MavPlan | University of Nebraska Omaha</title>
    <meta content="" name="description"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <link href="//www.unomaha.edu/_files/css/default-001-header-footer.css" rel="stylesheet"/>
    <script src="//www.unomaha.edu/_files/js/modernizr-2.5.3.min.js"></script>
    <script src="//www.unomaha.edu/_files/js/respond.min.js"></script>
    <!-- USER SCRIPTS -->
    <script src="{{ asset('/js/vendor.js') }}"></script>
    {{--<script src="{{ asset('/js/angular.js') }}"></script>--}}
    <script src="{{ asset('/js/app.js') }}"></script>
    <!-- /USER SCRIPTS -->

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.24/jquery-ui.min.js" type="text/javascript"></script>
    <script src="//www.unomaha.edu/_files/js/respond.min.js"></script>
    <script src="//www.unomaha.edu/_files/js/jquery.flexslider-min.js" type="text/javascript"></script>
    <script src="//www.unomaha.edu/_files/js/bootstrap.min.js"></script>

    <link href="//www.unomaha.edu/_files/css/colorbox/colorbox.css" media="screen" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="//www.ist.unomaha.edu/css/template_fixes.css">
    {{--<link href="{{ asset('css/app.css') }}" media="screen" rel="stylesheet" type="text/css"/>--}}
    @yield('header')
</head>
<body ng-app="CourseApp">
<div class="subsite" id="content">
    <nav></nav>
    <div class="hide-mobile" id="header">
        <div class="main-header clearfix">
            <div class="inner-content">
                <div class="subsite-logos">

                    <div class="home-logo">
                        <a href="http://www.unomaha.edu/">
                            <img alt="University of Nebraska Omaha" src="https://www.unomaha.edu/_files/images/logo-subsite-o-2.png"/>
                        </a>
                    </div>
                    <div>
                        <!-- USER HEADER DESKTOP -->
                        <a class="college" href="http://www.unomaha.edu/college-of-information-science-and-technology/">College of Information Science &amp; Technology</a>
                        <a class="department" href="/">MavPlan</a>
                        <!-- /USER HEADER DESKTOP -->
                    </div>
                    <div id="sup-navigation">
                        <div class="search">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="nav" class="navbar">
            <div class="inner-content"><ul class="nav clearfix">
                    @if (Auth::guest())
                        <li><a href="">Login</a></li>
                    @else
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Students <b class="caret"> </b></a>
                            <ul class="dropdown-menu">
                                <li></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Programs <b class="caret"> </b></a>
                            <ul class="dropdown-menu">
                                <li><a href="">View Programs</a></li>
                                @if (Auth::user()->canEdit())
                                    <li><a href="">Add New Program</a></li>
                                @endif
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown">Courses <b class="caret"> </b></a>
                            <ul class="dropdown-menu">
                                <li><a href="">View Courses</a></li>
                                @if(Auth::user()->canEdit())
                                    <li><a href="">Add a Course</a></li>
                                @endif
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"> </b></a>
                            <ul class="dropdown-menu">
                                <li><a href="">My Account</a></li>
                                <li><a href="">Log Out</a></li>
                            </ul>
                        </li>
                        @if (Auth::user()->canEdit())
                            <li class="dropdown">
                                <a href="" class="dropdown-toggle" data-toggle="dropdown">Admin <b class="caret"> </b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="">Admin Panel</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul></div>
        </div>
    </div>
    <div role="main">
        <div id="hero">
            <div class="inner-content">
                <h1>@yield('page_title')</h1>
            </div>
        </div>
        <div id="breadcrumbs">
            <div class="inner-content">
                <div class="row-fluid">
                    <div class="span12">
                        <ul class="breadcrumb">
                            <li><a href="http://www.unomaha.edu/">UNO</a></li>
                            <li><a href="http://www.unomaha.edu/college-of-information-science-and-technology/">College of Information Science &amp; Technology</a></li>
                            <li><a href="/">MavPlan</a></li>
                            @yield('breadcrumbs')
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-r" id="content_main">
            <div class="inner-content">
                <!-- USER MAIN CONTENT -->
            @include('partials._flash')
            @include('partials._errors')
            @yield('content')
            <!-- /USER MAIN CONTENT -->
            </div>
        </div>
    </div>
    <footer>
        <div class="inner-content">
            <div class="mobile-clearfix">
                <div class="span5 alpha">
                    <ul>
                        <li class="column-header">NEXT STEPS</li>
                        <li><a href="http://www.unomaha.edu/admissions/">Apply for Admission</a></li>
                        <li><a href="http://www.unomaha.edu/admissions/visit/">Visit the Campus</a></li>
                        <li><a href="http://www.unomaha.edu/tour/">Take a Virtual Tour</a></li>
                        <li><a href="https://ebruno.unomaha.edu/crm/rfi/">Request Information</a></li>
                    </ul>
                </div>
                <div class="span5">
                    <ul>
                        <li class="column-header">JUST FOR YOU</li>
                        <li><a href="http://www.unomaha.edu/admissions/">Future Students</a></li>
                        <li><a href="http://www.unomaha.edu/current.php">Current Students</a></li>
                        <li><a href="http://www.unomaha.edu/humanresources/employment.php">Work at UNO</a></li>
                        <li><a href="http://www.unomaha.edu/facstaff.php">Faculty &amp; Staff</a></li>
                    </ul>
                </div>
            </div>
            <div class="mobile-clearfix">
                <div class="span5">
                    <ul>
                        <li class="column-header">RESOURCES</li>
                        <li><a href="http://my.unomaha.edu/">my.unomaha.edu</a></li>
                        <li><a href="http://events.unomaha.edu/">Calendars</a></li>
                        <li><a href="http://www.unomaha.edu/maps/">Campus Map</a></li>
                        <li><a href="http://library.unomaha.edu/">Library</a></li>
                        <li><a href="http://registrar.unomaha.edu/catalogs.php">Course Catalog</a></li>
                        <li><a href="http://cashiering.unomaha.edu/">Pay Your Bill</a></li>
                    </ul>
                </div>
                <div class="span5">
                    <ul>
                        <li class="column-header">AFFILIATES</li>
                        <li><a href="http://www.nebraska.edu/">Nebraska System</a></li>
                        <li><a href="http://pki.nebraska.edu/">Peter Kiewit Institute</a></li>
                        <li><a href="http://nufoundation.org/Page.aspx?pid=375">Campaign for Nebraska</a></li>
                    </ul>
                </div>
            </div>
            <div class="mobile-clearfix">
                <div class="span5 omega">
                    <ul class="social">
                        <li class="column-header">CONNECT</li>
                        <li><a class="phone" href="tel:402.554.2380">&#160;402.554.2380</a></li>
                        <li><a class="facebook" href="https://www.facebook.com/unocist" target="_blank">&#160;Facebook</a></li>
                        <li><a class="twitter" href="https://twitter.com/unocist" target="_blank">&#160;Twitter</a></li>
                        <li><a class="youtube" href="https://www.youtube.com/channel/UClrgDqDeLKtshxX69HcOGlQ" target="_blank">&#160;YouTube</a></li>
                        <li><a class="instagram" href="http://instagram.com/unocist/" target="_blank">&#160;Instagram</a></li>
                        <li><a class="enotes" href="https://www.unomaha.edu/news/maverick-daily/" target="_blank">&#160;The Maverick Daily</a></li>
                    </ul>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span9"><a href="/" id="footer-logo">University of Nebraska Omaha</a>
                    <p>University of Nebraska Omaha, 6001 Dodge Street, Omaha, NE 68182</p>
                    <p>&#169; {{ date('Y') }} | <a href="http://emergency.unomaha.edu/">Emergency Information</a> <span class="footer-alert">Alert</span></p>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="//www.unomaha.edu/_files/js/bootstrap-hover-dropdown.min.js"></script>
<script src="//www.unomaha.edu/_files/js/jquery.foundation.navigation.js"></script>
<script src="//www.unomaha.edu/_files/js/jquery.mousewheel.min.js"></script>
<script src="//www.unomaha.edu/_files/js/jquery.mCustomScrollbar.min.js"></script>
<script src="//www.unomaha.edu/_files/js/jquery-picture-min.js"></script>
<script src="//www.unomaha.edu/_files/js/script.js"></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-54038627-17', 'auto');
    ga('send', 'pageview');

</script>

</body>
</html>