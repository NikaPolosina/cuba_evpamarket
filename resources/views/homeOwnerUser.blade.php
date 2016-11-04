@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    @include('layouts.breadcrumbs')

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />

    <div class="container">
        <div class="row">

        <div class="profile">
            <div class="tabbable-line tabbable-full-width">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1" data-toggle="tab" id="profile"> Мой профиль </a>
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
                            <div class="col-sm-3 col-md-3">
                                <ul class="list-unstyled profile-nav">
                                    <li>
                                        <div class="img_avatar_css">
                                            @if(!empty($userInfo->avatar) && file_exists(public_path().$userInfo->avatar))
                                                <img src="{{$userInfo->avatar}}" alt="avatar">
                                            @else
                                                 <img src="/img/placeholder/avatar.jpg" alt="avatar" />
                                            @endif
                                        </div>
                                    </li>
                                    <li>
                                        <a href="/my_shops"> Заказы
                                            <span> {{$count}} </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="msg"  href="javascript:;"> Сообщения
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
                                        @if(isset($groupInvites) && $groupInvites>0)
                                            <a href="/show-group-list#invite"> Группы
                                                @if(isset($groupInvites)) <span>{{$groupInvites}}</span>@endif
                                            </a>
                                        @else
                                            <a href="/show-group-list"> Группы
                                                @if(isset($groupInvites)) <span>{{$groupInvites}}</span>@endif
                                            </a>
                                        @endif
                                    </li>
                                </ul>

                            </div>
                            <div class="col-sm-9 col-md-9">

                                @if($userInfo['beetwenTwo'])
                                    <div class="chat_beet">
                                        @include('chat.chat')
                                    </div>

                                    <div class="chat" style="display: none;">
                                        @include('chat.chatAll')
                                    </div>
                                @else
                                    <div class="chat" style="display: none;">
                                        @include('chat.chatAll')
                                    </div>
                                @endif

                                    <?php
                                    $class = '';
                                    if($userInfo['beetwenTwo']){
                                        $class = 'style="display: none";';
                                    }
                                    ?>

                                    <div class="col-md-12 profile-info" <?=$class?> >
                                        <div class="row">



                                            <div class="col-md-8 profile-info">
                                                <h1 class="font-green sbold uppercase">{{$userInfo->name}} {{$userInfo->surname}}</h1>
                                                <p>
                                                   {{$userInfo->about_me}}
                                                </p>
                                                <p>
                                                    <a href="javascript:;">{{$userInfo->my_site}} </a>
                                                </p>

                                                <a href="/like"> <i class="fa fa-heart"></i> В избранных </a>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="panel">

                                                @if(count($curentUser->getCompanies))
                                                <div class="">
                                                        <h3 class="font-green sbold uppercase my_font_css">Мои магазины <a href="{{ url('company/create') }}" class="btn btn-primary pull-right btn-sm">Добавить магазин</a></h3>
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
                                                                    <tr data-id="{{$item->id}}">
                                                                        <td>{{ $x }}</td>
                                                                        <td> <img class="img-thumbnail" style="display: block; width: 100px;" src="{{$item->company_logo}}"></td><td><a href="{{ url('/product-editor', $item->id) }}">{{ $item->company_name }}</a></td><td>{{ $item->company_description }}</td>{{--<td width="200">{!!$item->company_content!!}</td>--}}

                                                                        <td width="165">
                                                                            <a href="{{ url('company/' . $item->id . '/edit') }}">
                                                                                <button   data-toggle="tooltip" data-placement="top" title="Редактировать" type="submit" class="btn btn-primary btn-xs">
                                                                                    <span class="glyphicon  glyphicon-pencil" aria-hidden="true"></span>
                                                                                </button>
                                                                            </a>
                                                                            <button  data-toggle="tooltip" data-placement="top" title="Удалить" data-id="{{$item->id}}" type="" class="btn btn-danger btn-xs tut">
                                                                                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                                                            </button>

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
                                        </div>
                                <!--end row-->
                            </div>
                        </div>
                    </div>
                    <!--tab_1_2-->
                    <div class="tab-pane" id="tab_1_2">

                        @include('user.homeTab_owner_12')

                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="tab_1_3">
                        @include('user.homeTab13')
                    </div>
                    <!--end tab-pane-->
                </div>
            </div>
    </div>
    </div>

        <style>
            .my_font_css{
                font-size: 18px;
            }

        </style>

        <script>

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });


            $(document).ready(function () {

                $('#msg').on('click', function (event) {

                    event.preventDefault();
                    $( ".chat" ).show();
                    $( ".profile-info" ).hide();
                    $('.chat_beet').hide();
                });

                $('#profile').on('click', function (event) {
                    event.preventDefault();
                    $('.chat_beet').hide();
                    $( ".chat" ).hide();
                    $( ".profile-info" ).show();

                });

            });

        </script>


        <script>
            $('.tut').on('click', function (e) {
                var c_modal = new CModal({
                    title: 'Подтвердите Ваше действие',
                    body:'<h3>Вы уверены, что хотите удалить этот магазин?</h3>',
                    confirmBtn:'Удалить',
                    cancelBtn:'Отменить',
                    action: function(){
                        var button = $(e.currentTarget);

                        $.ajax({
                            type    : "POST",
                            url     :       '/company-delete/'+ button.data('id'),
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : {
                                
                            },
                            success : function(response){
                                $('tr[data-id='+response+']').remove();

                            },
                            error   : function(response){
                                console.log('ajax went wrong');
                            }
                        });


                    }
                });
                c_modal.show();
            })

        </script>

    {{------------------------------------------------------------------------------------------------------------------------------}}



    <script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
    <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
    <script src="/assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
    <script src="/assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
    <script src="/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
    <script src="/assets/pages/scripts/dashboard.js" type="text/javascript"></script>



    </div>
</div>
@endsection
