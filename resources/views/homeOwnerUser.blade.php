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
                <li style="display: none">
                    <a href="#tab_1_2" data-toggle="tab"> Настройки аккаунта </a>
                </li>
                <li style="display: none">
                    <a href="#tab_1_3" data-toggle="tab"> Помощь </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1_1">
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="list-unstyled profile-nav">

                                <li>
                                    @if(!empty($userInfo->avatar) && file_exists(public_path().$userInfo->avatar))
                                        <img src="{{$userInfo->avatar}}" alt="avatar">
                                    @else
                                         <img src="/img/placeholder/avatar.jpg" alt="avatar" />
                                    @endif
                                </li>
                                <li>
                                    <a href="/my_shops"> Магазины

                                        <span> {{count($curentUser->getCompanies)}} </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Сообщения
                                        <span> 0 </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="/cart"> Корзина
                                        <span> @if(isset($product_cnt)){{$product_cnt}}@endif </span></a>
                                </li>
                                <li>
                                    <a href="/like"> Избранное
                                        <span> @if(isset($product_cnt_like)){{$product_cnt_like}}@endif</span></a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Платежи
                                        <span> 0 </span></a>
                                </li>
                                <li>
                                    <a href="javascript:;"> Доставка </a>
                                </li>

                            </ul>

                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8 profile-info">
                                    <h1 class="font-green sbold uppercase">{{$userInfo->name}} {{$userInfo->surname}}</h1>
                                    <p>
                                       {{$userInfo->about_me}}
                                    </p>
                                    <p>
                                        <a href="javascript:;">{{$userInfo->my_site}} </a>
                                    </p>
                                    <ul class="list-inline">
                                        <li>
                                            <i class="fa fa-briefcase"></i> Отправка </li>
                                        <li>
                                            <i class="fa fa-star"></i> Отзывы </li>
                                        <li>
                                            <a href="/like">   <li> <i class="fa fa-heart"></i> В избранных </li></a>
                                    </ul>
                                </div>
                                <!--end col-md-8-->
                                <div class="col-md-4">
                                    <div class="portlet sale-summary">
                                        <div class="portlet-title">
                                            <div class="caption font-red sbold"> Продано Товаров </div>
                                            <div class="tools">
                                                <a class="reload" href="javascript:;"> </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <ul class="list-unstyled">
                                                <li>
                                                                    <span class="sale-info"> ЗA СЕГОДНЯ
                                                                        <i class="fa fa-img-up"></i>
                                                                    </span>
                                                    <span class="sale-num"> 23 </span>
                                                </li>
                                                <li>
                                                                    <span class="sale-info"> ЗА НЕДЕЛЮ
                                                                        <i class="fa fa-img-down"></i>
                                                                    </span>
                                                    <span class="sale-num"> 87 </span>
                                                </li>
                                                <li>
                                                    <span class="sale-info"> ВСЕГО </span>
                                                    <span class="sale-num"> 2377 </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-md-4-->
                            </div>
                            <div class="row">
                                <div class="panel">



                                    @if(count($curentUser->getCompanies))
                                    <div class="">
                                            <h3 class="font-green sbold uppercase">Мои магазины <a href="{{ url('company/create') }}" class="btn btn-primary pull-right btn-sm">Добавить магазин</a></h3>
                                            <div class="table">
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                    <tr bgcolor="#FBFBEF">
                                                        <th>№</th><th>Logo</th><th>Имя магазина</th><th>Описание магазина</th>{{--<th width="350px">Детальное описание</th>--}}<th>Действие</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    {{-- */$x=0;/* --}}
                                                    @foreach($curentUser->getCompanies as $item)
                                                        {{-- */$x++;/* --}}
                                                        <tr>
                                                            <td>{{ $x }}</td>
                                                            <td> <img class="img-thumbnail" style="display: block; width: 100px;" src="{{$item->company_logo}}"></td><td><a href="{{ url('/product-editor', $item->id) }}">{{ $item->company_name }}</a></td><td>{{ $item->company_description }}</td>{{--<td width="200">{!!$item->company_content!!}</td>--}}

                                                            <td width="165">
                                                                <a href="{{ url('company/' . $item->id . '/edit') }}">
                                                                    <button type="submit" class="btn btn-primary btn-xs">
                                                                        <span class="glyphicon  glyphicon-pencil" aria-hidden="true"></span>
                                                                    </button>
                                                                </a>
                                                                {!! Form::open([
                                                                'method'=>'DELETE',
                                                                'url' => ['company-delete', $item->id],
                                                                'style' => 'display:inline'
                                                                ]) !!}
                                                                {{Form::button('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>', ['type'=>'submit', 'class' => 'btn btn-danger btn-xs'])}}
                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                {{--<div class="pagination"> {!! $company->render() !!} </div>--}}
                                            </div>
                                        </div>
                                    @else

                                    <div><h3>У вас пока нет ни одного магазина. Воспользуйтесь кнопкой "создать" для того что бы создать магазин.</h3></div>
                                    <a href="{{ url('company/create') }}" class="btn btn-primary pull-left btn-sm btn green">Создать магазин</a>
                                   @endif
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
                <!--tab_1_2-->
                <div class="tab-pane" id="tab_1_2">
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
                                    <form role="form" action="/user/simple_user/setting/security/edit-owner" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="form-group">
                                            <label class="control-label">Имя</label>
                                            <input type="text" value="{{$userInfo->name}}" class="form-control" name="name" required /> </div>
                                        <div class="form-group">
                                            <label class="control-label">Фамилия</label>
                                            <input type="text" value="{{$userInfo->surname}}" class="form-control"  name="surname" required /> </div>
                                        <div class="form-group">
                                            <label class="control-label">Номер Телефона</label>
                                            <input type="text" value="{{$userInfo->getUser->phone}}" class="form-control" name="phone" required/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <input type="text" value="{{$userInfo->getUser->email}}" class="form-control" name="email" required  /> </div>
                                        <div class="form-group">
                                            <label class="control-label">Обо мне</label>
                                            <textarea  class="form-control" rows="3" name="about_me">{{$userInfo->about_me}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Веб. сайт</label>
                                            <input type="text" value="{{$userInfo->my_site}}" class="form-control" name="my_site" /> </div>
                                        <div class="form-group">
                                            <label class="control-label">Улица</label>
                                            <input type="text" value="{{$userInfo->street}}" class="form-control" name="street"/> </div>
                                        <div class="form-group">
                                            <label class="control-label">Номер дома</label>
                                            <input type="text" value="{{$userInfo->address}}" class="form-control" name="address"/> </div>
                                        <div class="margiv-top-10">
                                            <button type="submit" class="btn green">Сохранить изменения</button>
                                            <button type="reset" class="btn default">Отменить</button>
                                        </div>
                                    </form>
                                </div>

                                <div id="tab_2-2" class="tab-pane">
                                    <p> Для загрузки аватара нажмите кнопку "Загрузить фото".
                                    </p>
                                    <form action="/avatar-uploader" role="form" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-group">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                    @if(!empty($userInfo->avatar) && file_exists(public_path().$userInfo->avatar))
                                                        <img src="{{$userInfo->avatar}}" alt="avatar">
                                                    @else
                                                        <img src="/img/placeholder/avatar.jpg" alt="avatar" />
                                                    @endif </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                <div>
                                                                    <span class="btn default btn-file">
                                                                        <span class="fileinput-new"> Выбрать фото </span>
                                                                        <span class="fileinput-exists"> Изменить </span>
                                                                        <input type="file" name="avatar"> </span>
                                                    <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Отменить </a>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="margin-top-10">
                                           <button type="submit" class="btn green">Сохранить</button>
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
                <div class="tab-pane" id="tab_1_3">
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
