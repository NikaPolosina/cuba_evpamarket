<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>


            <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="/plugins/chosen_v1.5.1/chosen.jquery.js"></script>
    <script src="/js/bootstrap-treeview.js"></script>


                    <!-- Fonts -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>
    <link href="/plugins/chosen_v1.5.1/chosen.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">







    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
        #app-layout{
            padding-top: 0px;
        }
    </style>


</head>
<body id="app-layout">

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->

                <a class="navbar-brand" style="padding: 0px;" href="{{ url('/') }}">
                    <img class="logo" src="/img/system/logo.png" style="width: 50px;">
                </a>

            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                @if(Auth::check())

                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Домой</a></li>
                </ul>
                    @endif

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a style="float: left" href="{{ url('/register-c') }}">Регистрация</a></li>
                       {{-- <li><a href="{{ url('/register') }}">Регистрация</a></li>--}}
                        <li><a href="{{ url('/login') }}">Вход</a></li>

                    @else
                        <li class="dropdown">

                         <?php
                                if(Auth::user()->getUserInformation){
                            ?>

                             <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                 {{ Auth::user()->getUserInformation->name }}
                                 <span class="caret"></span>
                             </a>

                            <?php    }

                            ?>


                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выйти</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>


    <style>

        .logo {

            animation: turn 5s infinite;
        }

        @-webkit-keyframes turn {
            to {
                -webkit-transform: rotateY(360deg);
            }
        }
        @keyframes turn {
            to {
                transform: rotateY(360deg);
            }
        }
    </style>
    @yield('content')

</body>
</html>
