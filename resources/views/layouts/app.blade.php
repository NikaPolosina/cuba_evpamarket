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
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:500' rel='stylesheet' type='text/css'>

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
{{-----------------------------------------------------------}}

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding: 0px 15px;" href="{{ url('/') }}"> <img class="logo" src="/img/system/logo.png" style="width: 50px; "></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="col-md-6 col-md-offset-3">

                <div class="input-group col-sm-12">
                    <form style=" margin: 7px 0px 0px 0px;" class="input-group" method="POST" action="/find">
                        {{ csrf_field() }}

                                <span style=" top: 0px;" class="input-group-addon  glyphicon glyphicon-search" aria-hidden="true"></span>
                                 <input class="form-control" name="find" type="text" placeholder="Введите текст для поиска"/>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Поиск</button>
                                    </span>
                    </form>
                </div>

            </div>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a style="float: left" href="{{ url('/register-c') }}">Регистрация</a></li>
                <li><a href="{{ url('/login') }}">Вход</a></li>
                   @else
                    <li><a href="{{ url('/home') }}">Домой</a></li>
                    <li class="dropdown">
                        <?php if(Auth::user()->getUserInformation){?>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->getUserInformation->name }}
                            <span class="caret"></span>
                        </a>
                        <?php  }  ?>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выйти</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
{{-----------------------------------------------------------}}
<script>

    $('.input-group').on('submit', function(){
    var input = $('.form-control');
    if(input.val().length < 1){
        input.focus();
        return false;
    }
    });

</script>
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
