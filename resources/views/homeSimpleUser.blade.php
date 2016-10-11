@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')
    @include('layouts.breadcrumbs')



    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="/assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />

    <link href="/assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->

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
                                                    <img src="/img/placeholder/avatar.jpg" alt="avatar"/>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                            <a id="msg" href="javascript:;"> Сообщения
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
                                        <li>
                                            <a href="/show-list-order-simple"> Заказы
                                                @if(count($order) > 0) <span>{{count($order)}}</span>@endif
                                            </a>
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
                                    <div class="row">

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
                                            <h1 class="font-green sbold uppercase">{{$userInfo->name}} {{$userInfo->surname}}</h1>

                                                <ul class="nav nav-tabs">
                                                    <li class="active" id="li_like">
                                                        <a href="#tab_1_6" data-toggle="tab">
                                                            <i class="fa fa-heart"></i> В избранных
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane active" style="display: none" id="tab_1_6">
                                                        <link rel="stylesheet" type="text/css" href="/css/show_cart_like.css"/>
                                                        @include('product.modalAddProductCart')
                                                        <div class="row item_class_4">
                                                            @if(count($product) > 0 )
                                                                @foreach($product as $v)
                                                                    <div class="col-sm-12  product_item_like product_item_p tom" style="padding-right: 2px; padding-left: 2px">
                                                                            @include('product.likeSingleView')

                                                                    </div>
                                                                @endforeach
                                                                <div class="col-sm-12 product_item_like like_empty product_item_p" style="display: none">
                                                                    <h1>В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</h1>
                                                                </div>
                                                            @else
                                                                <div class="col-sm-12 product_item_like like_empty product_item_p">
                                                                    <h1>В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</h1>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        {!! HTML::script('/js/product/like_delete.js') !!}
                                                        <script>
                                                            var getProductUrl = '{{route('ajax_single_product')}}';
                                                            var addToCartUrl = '{{route('ajax_add_to_cart')}}';
                                                            var cartUrl = '{{route('cart')}}';
                                                        </script>

                                                        {!! HTML::script('/js/like_and_cart_add.js') !!}

                                                    </div>

                                                </div>
                                        </div>


                                                    <script>

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


                                        <!--end col-md-8-->
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                        </div>
                        <!--tab_1_2-->

                        <div class="tab-pane" id="tab_1_2">
                        @include('user.homeTab12')

                        </div>

                        <div class="tab-pane" id="tab_1_3">
                            @include('user.homeTab13')

                        </div>
                    </div>

                    <!--end tab-pane-->
                </div>

            </div>
        </div>
    </div>
    <script>
        $('#li_like').on('click', function(){
            $('#tab_1_6').toggle    ();
        })


    </script>
    <style>
        .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
            border: none;
        }
        .tabbable-line>.tab-content {
            padding: 0px 0;
        }

    </style>

            {{------------------------------------------------------------------------------------------------------------------------------}}


            <script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
            <script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
            <!-- END CORE PLUGINS -->
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>


            <script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
            <!-- END THEME GLOBAL SCRIPTS -->
            <!-- BEGIN THEME LAYOUT SCRIPTS -->
            <script src="/assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
            <script src="/assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
            <script src="/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
            <script src="/assets/pages/scripts/dashboard.js" type="text/javascript"></script>


    </div>



@endsection








