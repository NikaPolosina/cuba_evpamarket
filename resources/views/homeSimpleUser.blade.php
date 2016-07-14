@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="../assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="../assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />

    <link href="../assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->


    <div class="container">
        <div class="row">
            {{setlocale(LC_ALL, 'de_RU')}}

            <div class="profile">
                <div class="tabbable-line tabbable-full-width">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_1_1" data-toggle="tab"> Мой профиль </a>
                        </li>
                        <li>
                            <a href="#tab_1_3" data-toggle="tab"> Настройки аккаунта </a>
                        </li>
                        <li>
                            <a href="#tab_1_6" data-toggle="tab"> Помощь </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1_1">
                            <div class="row">
                                <div class="col-md-3">
                                    <ul class="list-unstyled profile-nav">
                                        <li>
                                            <img src="../assets/pages/media/profile/people19.png" class="img-responsive pic-bordered" alt="" />
                                        </li>
                                        <li>
                                            <a href="javascript:;"> Сообщения
                                                <span> 0 </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/cart"> Корзина
                                                <span> @if(isset($product_cnt)){{$product_cnt}}@endif </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/like"> Избранные
                                                 <span> @if(isset($product_cnt_like)){{$product_cnt_like}}@endif </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-8 profile-info">
                                            <h1 class="font-green sbold uppercase">{{$userInfo->name}} {{$userInfo->surname}}</h1>
                                            <ul class="list-inline">
                                                <li>
                                                    <i class="fa fa-calendar"></i> {{date('j  F Y ')}} </li>
                                                <li>
                                                    <i class="fa fa-heart"></i> В избранных </li>
                                            </ul>
                                        </div>
                                        <!--end col-md-8-->
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                        </div>
                        <!--tab_1_2-->
                        <div class="tab-pane" id="tab_1_3">
                            <div class="row profile-account">
                                <div class="col-md-3">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#tab_1-1">
                                                <i class="fa fa-cog"></i> Персональная информация </a>
                                            <span class="after"> </span>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_2-2">
                                                <i class="fa fa-picture-o"></i> Сменить Аватар </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_3-3">
                                                <i class="fa fa-lock"></i> Сменить Пароль </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_4-4">
                                                <i class="fa fa-eye"></i> Приватность</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="tab-content">
                                        <div id="tab_1-1" class="tab-pane active">
                                            <form role="form" action="#">
                                                <div class="form-group">
                                                    <label class="control-label">Имя</label>
                                                    <input type="text" placeholder="{{$userInfo->name}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Фамилия</label>
                                                    <input type="text" placeholder="{{$userInfo->surname}}" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Обо мне</label>
                                                    <textarea class="form-control" rows="3" placeholder="Информация которую я написал."></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Веб. сайт</label>
                                                    <input type="text" placeholder="http://www.mywebsite.com" class="form-control" /> </div>
                                                <div class="margiv-top-10">
                                                    <a href="javascript:;" class="btn green"> Сохранить изменения</a>
                                                    <a href="javascript:;" class="btn default"> Отменить </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_2-2" class="tab-pane">
                                            <p> Для загрузки аватара нажмите кнопку "Загрузить фото".
                                            </p>
                                            <form action="#" role="form">
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" /> </div>
                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        <div>
                                                            <span class="btn default btn-file">
                                                                <span class="fileinput-new"> Выбрать фото </span>
                                                                <span class="fileinput-exists"> Изменить </span>
                                                                <input type="file" name="..."> </span>
                                                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Отменить </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margin-top-10">
                                                    <a href="javascript:;" class="btn green"> Сохранить </a>
                                                </div>
                                            </form>
                                        </div>
                                        <script>
                                            var src = $('div.fileinput-new').find('img').attr('src');


                                            console.log(src);



                                        </script>


                                        <div id="tab_3-3" class="tab-pane">
                                            <form action="#">
                                                <div class="form-group">
                                                    <label class="control-label">Старый Пароль</label>
                                                    <input type="password" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Новый Пароль</label>
                                                    <input type="password" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Повторите Новый пароль</label>
                                                    <input type="password" class="form-control" /> </div>
                                                <div class="margin-top-10">
                                                    <a href="javascript:;" class="btn green"> Изменить Пароль </a>
                                                    <a href="javascript:;" class="btn default"> Отменить </a>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="tab_4-4" class="tab-pane">
                                            <form action="#">
                                                <table class="table table-bordered table-striped">
                                                    <tr>
                                                        <td> Возможность отправлять мне собщения от других пользователей. </td>
                                                        <td>
                                                            <div class="mt-radio-inline">
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="optionsRadios31" value="option1" /> Да
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="optionsRadios31" value="option2" checked/> Нет
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Возможность просматривать мой профиль другими пользователями. </td>
                                                        <td>
                                                            <div class="mt-radio-inline">
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="optionsRadios41" value="option1" /> Да
                                                                    <span></span>
                                                                </label>
                                                                <label class="mt-radio">
                                                                    <input type="radio" name="optionsRadios41" value="option2" checked/> Нет
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--end profile-settings-->
                                                <div class="margin-top-10">
                                                    <a href="javascript:;" class="btn green"> Сохранить изменения </a>
                                                    <a href="javascript:;" class="btn default"> Отменить </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-md-9-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane" id="tab_1_6">
                            <div class="row">
                                <div class="col-md-2">
                                    <ul class="ver-inline-menu tabbable margin-bottom-10">
                                        <li class="active">
                                            <a data-toggle="tab" href="#tab_1">
                                                <i class="fa fa-briefcase"></i> Основные вопросы </a>
                                            <span class="after"> </span>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_2">
                                                <i class="fa fa-group"></i> Отношения </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_3">
                                                <i class="fa fa-leaf"></i> Сервис </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_1">
                                                <i class="fa fa-info-circle"></i> Лицензия </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_2">
                                                <i class="fa fa-tint"></i> Платежные правила </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#tab_3">
                                                <i class="fa fa-plus"></i> Задать вопрос </a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>

        {{------------------------------------------------------------------------------------------------------------------------------}}


        <script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>


        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="../assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
        <script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>



    </div>
    </div>
@endsection








{{--<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                --}}{{-----------------------------------------------------------------------------------------------------------}}{{--
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
                --}}{{-----------------------------------------------------------------------------------------------------------}}{{--

                --}}{{------------------------------------------------------------------------------------------------}}{{--
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

                --}}{{--------------------------------------------------------------------------------------------------}}{{--



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

</style>--}}

