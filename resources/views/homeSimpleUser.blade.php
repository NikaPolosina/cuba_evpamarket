@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><span>Моя страница</span></div>

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
