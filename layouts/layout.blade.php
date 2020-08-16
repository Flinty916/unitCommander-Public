<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ settings()->get('title', 'Unit Commander') }}</title>
    <meta name="title" content="{{ settings()->get('title', 'Unit Commander') }}">
    <meta name="description"
          content="{{ settings()->get('description', "Unit Commander is a Web Based Administrative tool for Community Managers built by Flint's Designs.") }}">
    <meta name="keywords" content="Unit, Commander, Arma, Arma3, Arma 3, Admin, Administrator, Flint's Designs, Flinty">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Flint's Designs">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name='HandheldFriendly' content='True'>
    <meta name='MobileOptimized' content='320'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-touch-fullscreen' content='yes'>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="@asset('css/Global.css')">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <span class="navbar-brand" href="#">{{ settings()->get('title', 'Unit Commander') }}</span>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('users') }}">Players</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/ranks">Ranks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/awards">Awards</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/training">Training</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/positions">Positions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/units">Units</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/events">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/orbat">ORBAT</a>
            </li>
        </ul>
    </div>
</nav>


@content()

<br />
<br />
<div class="footer">
    <div class="footer_contents">
        <div class="row p-0">
            <div class="col-lg-6 col-sm-12 p-0">
                @guest
                    <p>You are not Logged In. <a href="{{ route('login') }}">Log in?</a></p>
                @endguest
                @auth
                        <p>Welcome back {{ Auth::user()->nickname }}, <a href="/profile">Visit Profile?</a>. <a style="cursor:pointer;" id="logout-link">Logout?</a></p>
                        <form action="{{ route('logout') }}" method="POST" class="pl-3" id="logout">
                            @csrf
                        </form>
                @endauth
            </div>
            <div class="col-lg-6 col-sm-12 p-0">
                <div class="float-md-right">
                    <p>
                        {{ settings()->get('title', 'Unit Commander') }}
                        @can('edit_settings')
                            - <a href="/settings">Configuration</a>
                        @endcan
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Popper.JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
        crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
        crossorigin="anonymous"></script>
<!-- jQuery Custom Scroller CDN -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

<script type="text/javascript" src="/JS/Sidenav.js"></script>
<script type="text/javascript" src="/JS/confirm.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('.sidebarCollapse').on('click', function () {
            $('#sidebar, #content').toggleClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>
<script>
    let form = document.getElementById('logout')
    document.getElementById('logout-link').addEventListener('click', function() {
        form.submit()
    })
</script>
@scripts()
</body>

</html>
