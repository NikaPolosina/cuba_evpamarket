@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    {{-----------------------------------------------------------------------------------------------------------}}
                    <nav class="navbar navbar-default" style="margin-bottom: 0px;">
                        <div class="container-fluid">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="/">Cuba</a>
                            </div>

                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                                <form class="navbar-form navbar-left" role="search">
                                    <div class="form-group">

                                        <div class="form-control" style="margin-left: 130px;      height: 26px;   padding: 0px 0px;  " >
                                            <span class="glyphicon glyphicon-search" aria-hidden="true" style="    color: rgba(128, 128, 128, 0.55); padding: 2px;"></span>
                                                    <input style="    border: none; padding: 2px; " type="text"  placeholder="Введите искомое слово">
                                        </div>

                                    </div>
                                    <button type="submit" class="btn btn-default btn-sm">Найти</button>
                                </form>
                                <ul class="nav nav_dropdown navbar-nav navbar-right">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Помощь <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Чат поддержки</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="#">Написать письмо</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                    {{-----------------------------------------------------------------------------------------------------------}}

                    {{------------------------------------------------------------------------------------------------}}
                    <div class="col-sm-12" style="border: solid 1px black;">


                            <div class="col-sm-2" style="padding: 0px;">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach($simple_user_menu as $menuItem)
                                        <li class="singleMenu"><a class="singleUtl" href="{{$menuItem['url']}}">{{$menuItem['title']}}<span class="{{$menuItem['span']}}" style="float: right"></span></a></li>
                                    @endforeach
                                </ul>
                            </div>

                        @yield('content_user')

                        </div>

                    {{--------------------------------------------------------------------------------------------------}}



                    <div class="panel-body">
                        Добро пожаловать. Вы залогинены!
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>


    </script>
    <style>
       .nav_dropdown>li>a {
            padding: 15px 15px!important;
          }
         .singleMenu a{
             background-color: rgba(0, 92, 255, 0.25);
            border: 1px solid #a2a2a2;
            color: black;
            text-decoration: none;

        }
         .nav>li>a.singleUtl:hover{
             background-color:  rgba(51, 122, 183, 0.11);
         }
         .nav>li>a{
             padding: 5px 10px;
         }
         .nav-stacked>li+li{
              margin-top: 0px;
         }

    </style>
@endsection
