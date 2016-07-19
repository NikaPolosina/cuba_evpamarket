
@extends('layouts.app')

@section('content')
    @include('layouts.header_menu')

    <style type="text/css" >
      .desk{
        width: 400px;
        height: 300px;
        margin: 0 auto;
        text-align: center;
        padding: 10px 0 0 0;
      } 
      .price{
        background:#fff3b5;
        width: 170px;
        height: 170px;
        padding-top: 20px;
      }
      .price > span{
        font-size: 25px;
        display: block;
          margin: 20px 0 30px 0;
      }
      .detail-tools{
          width: 200px;
          height: 170px;
          background: white;
          float: left;
          padding: 20px 0 0 0;
      }
        .img_like{
            width: 190px;
            margin: 0 auto;
            padding-left: 35px;
        }
        .cont_stars{
            margin: 20px 0 0 0;
        }
        .product_stars{
            background-image: url(/img/system/star.png);
            background-repeat: repeat-x;
            width: 81px;
            height: 20px;
            display: inline-block;
            margin: 5px 0 0 0;
        }
        .num_of_rev{
            display: block;
            margin: 0 0 10px 0;
        }




    </style>
    <link rel="stylesheet" type="text/css" href="/css/show_product.css"/>
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    {{-----------------------------------------------------------}}
    <!-- Modal -->
    <div style="z-index: 100000000000000" class="modal fade" id="modal_add_product_cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-10 col-sm-offset-1">
                <div class="modal-header">
                    <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <img style="display: inline-block;" src="/img/system/check-mark.png" alt=""/> Товар был добавлен в корзину. Товаров в Вашей корзине:
                        <span style="color:blue"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="product_info_add_cart product_item_cart">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-3">

                                    <div style="max-width: 100%;">
                                        <img class="img_product img-thumbnail" src="" alt=""/>
                                    </div>

                                    <div class="gal">

                                    </div>
                                </div>

                                <div class="col-sm-9">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td width="35%">
                                                <span style="font-size: 20px; font-weight: bolder;">Товар:</span>
                                                <input type="hidden" class="product_id"/>
                                            </td>
                                            <td width="65%" valign="top"><p class="name" style=" font-size: 20px;"></p></td>
                                        </tr>
                                        <tr>
                                            <td width="35%">
                                                <span style="font-size: 20px; font-weight: bolder;">Краткое описание:</span>
                                            </td>
                                            <td width="65%" valign="top">
                                                <p style="font-size: 20px;" class="product_description"></p></td>
                                        </tr>


                                        <tr>
                                            <td width="35%"><span class="option_table">Количество:</span></td>
                                            <td width="65%" valign="top">

                                                {{-------------------------------Количество товара----------------------------------}}
                                                <div class="my_b">
                                                    <div class="input-group number-spinner">
                                                    <span class="input-group-btn data-dwn">
                                                        <button class="btn btn-default btn-info left_b" data-dir="dwn">
                                                            <span class="glyphicon glyphicon-minus"></span>
                                                        </button>
                                                    </span>

                                                        <input type="text" class="form-control text-center my_b" value="1" min="1" max="40" readonly>

                                                    <span class="input-group-btn data-up">
                                                        <button class="btn btn-default btn-info right_b" data-dir="up">
                                                            <span style="width: 2px;" class="glyphicon glyphicon-plus"></span>
                                                        </button>
                                                    </span>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <p>В наличии: 40 шт.</p>
                                                </div>
                                                {{-----------------------------------------------------------------------------------}}

                                            </td>
                                        </tr>


                                        <tr>
                                            <td width="35%" valign="top">
                                                <span style="font-size: 20px; font-weight: bolder;">Цена:</span></td>
                                            <td width="65%" valign="top">
                                            <span class="all_product_price" style="    background: #fff3b5;
                                                                    border-radius: 4px;
                                                                    display: inline-block;
                                                                    padding: 7px 7px 5px;
                                                                    vertical-align: middle;
                                                                    margin-bottom: 5px;
                                                                    white-space: nowrap;
                                                                    border: 1px solid transparent;
                                                                    font-size: 1.38462em;font-size: 20px;
                                                        ">0</span>
                                                <span >руб</span>
                                                <span class="product_price_one" style="display: none"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="35%" valign="top">
                                                <span style="font-size: 20px; font-weight: bolder;">Всего в этом магазине:</span></td>
                                            <td width="65%" valign="top">
                                            <span class="total_in_shop" style="    background: #fff3b5;
                                                                    border-radius: 4px;
                                                                    display: inline-block;
                                                                    padding: 7px 7px 5px;
                                                                    vertical-align: middle;
                                                                    margin-bottom: 5px;
                                                                    white-space: nowrap;
                                                                    border: 1px solid transparent;
                                                                    font-size: 1.38462em;font-size: 20px;
                                                        ">0</span>
                                                <span >руб</span>

                                                <span class="total_in_shop_one" style="display: none"></span>
                                            </td>
                                        </tr>
                                    </table>



                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">
                        <img class="img_button_icon" src="/img/system/back-arrow.png" alt=""/>Продолжить покупки
                    </button>
                    <a href="/cart">
                        <button type="button" class="btn btn-danger">
                            <img class="img_button_icon" src="/img/system/shopping-cart-button.png" alt=""/> Перейти в корзину
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{-----------------------------------------------------------------}}
{{------------------------------------------------------------------------------}}

    <!-- Modal -->
    <div style="z-index: 100000000000000" class="modal fade" id="modal_add_product_like" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content col-md-10 col-sm-offset-1">
                <div class="modal-header">
                    <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <img style="display: inline-block;" src="/img/system/check-mark.png" alt=""/> Товар был добавлен в избранное. Товаров в избранном:
                        <span style="color:blue"></span></h4>
                </div>

                <div class="modal-footer" style="text-align: center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">
                        <img class="img_button_icon" src="/img/system/back-arrow.png" alt=""/>Продолжить покупки
                    </button>
                    <a href="/like">
                        <button type="button" class="btn btn-danger">
                            <img class="img_button_icon" src="/img/system/favorite-heart-button.png" alt=""/> Перейти в избранное
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    {{---------------------------------------------------------}}


   <div class="row row_row">
            <div class="item_class_3">
                <div class="item_class_4 item_1">
                <input style="display: none" data-name="product-id" type="text" value="{{ $singleProduct['id'] }}"/>
                <div class="carent_my_product">
        <div class="col-sm-10 col-md-offset-1">
        <h1 style="font-size: 2.76923em; font-weight: normal; line-height: 1.2em; margin-bottom: 0.325em; letter-spacing: -0.025em;">Товар</h1>

    <div class="portlet box">
        <div class="portlet-title">
            <div class="caption" >
              <p style="color: black; font-size: 36px; font-weight: 600;">{{ $singleProduct['product_name'] }}</p>
            </div>

        </div>
        <div class="portlet-body">
            <div class="tabbable-custom ">
                <ul class="nav nav-tabs ">
                    <li class="active" style="border-top: 3px solid #32c5d2!important;">
                        <a href="#tab_5_1" data-toggle="tab"> Все о товаре </a>
                    </li>
                    <li>
                        <a href="#tab_5_2" data-toggle="tab"> Характеристики</a>
                    </li>
                    <li>
                        <a href="#tab_5_3" data-toggle="tab">Фото</a>
                    </li>
                    <li>
                        <a href="#tab_5_4" data-toggle="tab"> Отзывы </a>
                    </li>
                    <li>
                        <a href="#tab_5_5" data-toggle="tab"> Доставка </a>
                    </li>
                </ul>
                <div class="tab-content" style="height: 100%">
                    <div class="tab-pane active" id="tab_5_1">



                        <!-- blueimp Gallery styles -->
                        <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
                        <!-- blueimp Gallery script -->
                        <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
                        <!-- The blueimp Gallery widget -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                            <div class="slides"></div>
                            <h3 class="title"></h3>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                            <a class="play-pause"></a>
                            <ol class="indicator"></ol>
                        </div>
                        <div class="table-responsive">

                            <table class="table table-bordered table-striped table-hover">

                                <tbody>
                                <tr>
                                    <td style="width: 100px;">

                                        @if(isset($singleFile) && count($singleFile))

                                            @foreach($singleFile as $val)

                                                <?php $all = explode("/", $val);
                                                $single = array_pop($all); ?>

                                                <a href="{{$val}}" title="{{$single}}" download="{{$single}}" data-gallery=""><img class="img-thumbnail" style="display: block; width: 100px; float: left" src="{{$val}}"></a>
                                                <a style="display: none" href="{{$val}}" title="{{$single}}" title="{{$single}}" download="{{$single}}" data-gallery="">{{$single}}</a>

                                            @endforeach
                                        @endif
                                    </td>
                                    <td style="width: 250px;">
                                        <div class="product_img">
                                             <img class="img-thumbnail" style="display: block; width: 200px; float: right;" src="{{$firstFile}}">
                                        </div>

                                    </td>
                                    <td style="width: 200px; padding: 20px;;"> {{ $singleProduct['product_description'] }} </td>
                                    <td>
                                        <div class = "product_navigation desk">
                                            <div class="price">
                                                <span class="desk-price">{{ $singleProduct['product_price'] }} грн.</span>
                                                <div class="">
                                                    <button class="btn btn-success ">В корзину</button>
                                                </div>
                                            </div>
                                            <div class="detail-tools">
                                                <div class="img_like">
                                                    @if(!Auth::guest())
                                                        <span class="like"></span>
                                                    @endif
                                                        <span>Добавить в желания</span>
                                                </div>
                                                <div class="cont_stars">
                                                    <span class="product_stars"></span>
                                                    <span class="num_of_rev">24 отзыва</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>
                    <div class="tab-pane" id="tab_5_2">
                        <p style="font-size: 16px; font-weight: bold"> Xарактеристики  {{ $singleProduct['product_name'] }} !!!</p>


                        <table class="table table-bordered table-striped table-hover">

                            <tbody>

                                <td style="width: 250px;">
                                    {{ $singleProduct['product_description'] }}
                                </td>
                                <td style="width: 250px;">
                                    {!! $singleProduct['content'] !!}
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="tab-pane" id="tab_5_3">

                        <p style="font-size: 16px; font-weight: bold"> Фото  {{ $singleProduct['product_name'] }} !!!


                            @if(isset($singleFile) && count($singleFile))

                                @foreach($singleFile as $val)

                                    <?php $all = explode("/", $val);
                                    $single = array_pop($all);

                                    ?>

                                <div class="col-sm-6 col-sm-offset-3">

                                    <img class="img-thumbnail" src="{{$val}}" alt="" style="width: 100%;">

                                </div>


                                @endforeach
                            @endif
                        </p>

                    </div>
                    <div class="tab-pane" id="tab_5_4">

                        <p style="font-size: 16px; font-weight: bold">Отзывы</p>


                    </div>
                    <div class="tab-pane" id="tab_5_5">

                        <p style="font-size: 16px; font-weight: bold">Оформление заказа</p>
                        <p> Обращаем Ваше внимание: на покупателей нашего магазина распространяются все права предусмотренные в Законе "О защите прав потребителя".

                            Вы можете оформить заказ двумя способами.</br>
                            а) с помощью "Корзины" непосредственно в магазине (способ описан ниже)</br>
                            б) по телефону.</br>
                            Заказ с помощью "Корзины" позволяет Вам полностью контролировать процесс. Введя Ваш e-mail и пароль, который Вы выбрали при регистрации Вы получите доступ к состоянию Вашего заказа.</br>
                            Вы сможете контролировать получение нами оплаты, отправку заказа к Вам, дату получения заказа, историю всех предыдущих заказов.
                        </p>

                        <p style="font-size: 16px; font-weight: bold">
                            Доставка товара по России
                        </p>
                        <p>
                            Доставка по России в наши пункты выдачи производится без предоплаты.</br>

                            Стоимость доставки по России в пункт самовывоза составляет 200 руб.</br>
                            На следующий рабочий день после оформления и подтверждения заказа (на сайте либо по телефону) вы сможете осмотреть, проверить комплектацию и работоспособность товара в офисе представительства в вашем городе, после чего на месте оплатить покупку.</br>


                        </p>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
                </div>
            </div>
            </div>
        </div>
    <style>
        .tabbable-custom>.nav-tabs>li.active {
            border-top: 3px solid #32c5d2!important;
        }
    </style>

    <script>
        $(function () {
            var action;
            $(".number-spinner button").mousedown(function () {
                btn = $(this);
                input = btn.closest('.number-spinner').find('input');
                btn.closest('.number-spinner').find('button').prop("disabled", false);
                var price = $(this).parents('.product_item_cart').eq(0).find('span.product_price_one').text();
                var price_all = $(this).parents('.product_item_cart').eq(0).find('span.all_product_price');

                var total_in_shop = $(this).parents('.product_item_cart').eq(0).find('span.total_in_shop');
                var total_in_shop_origin = $(this).parents('.product_item_cart').eq(0).find('span.total_in_shop_one').text();

                if (btn.attr('data-dir') == 'up') {
                    if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
                        input.val(parseInt(input.val()) + 1);
                        price_all.text(parseInt(parseInt(input.val()) * price));
                    } else {
                        btn.prop("disabled", true);
                        clearInterval(action);
                    }
                } else {
                    if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
                        input.val(parseInt(input.val()) - 1);
                        price_all.text(parseInt(parseInt(input.val()) * price));
                    } else {
                        btn.prop("disabled", true);
                        clearInterval(action);
                    }
                }



                total_in_shop.html(parseInt(total_in_shop_origin) + parseInt(price)*(parseInt(input.val())-1));



            }).mouseup(function () {
                clearInterval(action);
            });
        });

    </script>
@endsection

