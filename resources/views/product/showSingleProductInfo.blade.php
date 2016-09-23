<div class="col-xs-10 col-sm-10 item_class">
    <div class="panel panel-default item_class_2">
        <div class="panel-body item_class_3">
            <link rel="stylesheet" type="text/css" href="/css/single_product_info.css"/>
            <link rel="stylesheet" type="text/css" href="/css/show_product.css"/>
            <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
            @include('product.modalAddProductCart')
            @include('product.modalAddProductLike')
            <div class="row row_row">
                <div class="item_class_3">
                    <div class="item_class_4 item_1">
                        <input style="display: none" data-name="product-id" type="text" value="{{ $singleProduct->id}}"/>
                        <div class="carent_my_product">
                            <div class="col-sm-12">
                                <div class="portlet box">
                                    <div class="portlet-title">
                                        <div class="caption" >
                                            <h1>{{ $singleProduct->product_name}}</h1>

                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tabbable-custom ">
                                            <ul class="nav nav-tabs ">
                                                <li class=" @if(!isset($scroll_feed))active @endif " style="border-top: 3px solid #32c5d2!important;">
                                                    <a href="#tab_5_1" data-toggle="tab"> Все о товаре </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_5_2" data-toggle="tab"> Характеристики</a>
                                                </li>
                                                <li>
                                                    <a href="#tab_5_3" data-toggle="tab">Фото</a>
                                                </li>
                                                <li class="@if(isset($scroll_feed))active @endif">
                                                    <a href="#tab_5_4" data-toggle="tab"> Отзывы </a>
                                                </li>
                                                <li>
                                                    <a href="#tab_5_5" data-toggle="tab"> Доставка </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content" style="min-height: 600px;">
                                                <div class="tab-pane @if(!isset($scroll_feed)) active @endif" id="tab_5_1">
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
                                                                            <a class="img_a "href="{{$val}}" title="{{$single}}" download="{{$single}}" data-gallery="">
                                                                                <img class="detail-img-thumbs-l-i" src="{{$val}}"></a>
                                                                            <a style="display: none" href="{{$val}}" title="{{$single}}" title="{{$single}}" download="{{$single}}" data-gallery="">{{$single}}</a>
                                                                        @endforeach
                                                                    @endif
                                                                </td>
                                                                <td style="width: 50%;">
                                                                    <div class="product_img">
                                                                        <img  style="max-width: 350px" class="img-thumbnail"  src="{{$firstFile}}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class = "product_navigation desk">
                                                                        <div class="price">
                                                                            <span class="desk-price">{{ $singleProduct->product_price}} руб.</span>
                                                                                        <span style="margin: auto;">

                                                                                            <button class=" btn-lg btn-success button_my to_cart"  data-product-id="{{$singleProduct->id}}" ><img style="display: inline-block;" src="/img/system/cart-white.png" alt=""><span style="font-weight: bold"> Купить</span></button>
                                                                                        </span>
                                                                        </div>
                                                                        <div class="detail-tools">
                                                                            <div class="img_like">
                                                                                @if(!Auth::guest())
                                                                                    <span class="like"></span>
                                                                                    <span>Добавить в желания</span>
                                                                                @endif
                                                                            </div>
                                                                            <div class="cont_stars">


                                                                                <div class="par">
                                                                                    <div class="stars">
                                                                                        <div style="width:{{$singleProduct['raiting']}}%" class="star_feed">&nbsp;</div>
                                                                                    </div>
                                                                                </div>




                                                                                @if($singleProduct->count > 0)



                                                                                    <span class="num_of_rev">{{$singleProduct->count}} отзывов</span>
                                                                                @else
                                                                                    <span class="num_of_rev"> нет отзывов</span>
                                                                                @endif



                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <h2 class="detail-tabs-i-title"><span style="font-weight: 600">Описание</span>
                                                        <span class="detail-tabs-i-title-inner">{{ $singleProduct->product_name }} </span>
                                                    </h2>
                                                    <div>
                                                        {!! $singleProduct->content !!}
                                                    </div>



                                                </div>
                                                <div class="tab-pane" id="tab_5_2">
                                                    <p style="font-size: 16px; font-weight: bold"> Xарактеристики  {{ $singleProduct->product_name }} </p>
                                                </div>
                                                <div class="tab-pane" id="tab_5_3">
                                                <p style="font-size: 16px; font-weight: bold"> Фото  {{ $singleProduct->product_name }}
                                                    @if(isset($singleFile) && count($singleFile))
                                                        @foreach($singleFile as $val)
                                                            <?php $all = explode("/", $val);
                                                            $single = array_pop($all);
                                                            ?>
                                                            <div class="col-sm-6 col-sm-offset-3">
                                                                <div class="single_photo">
                                                                    <img class="img-thumbnail" src="{{$val}}" alt="" style="max-height: 100%;">
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </p>
                                                </div>
                                                <div class="tab-pane @if(isset($scroll_feed)) active @endif" id="tab_5_4">


                                                    <p style="font-size: 16px; font-weight: bold">Отзывы</p>


                                                    @if($singleProduct->getFeedback)
                                                        @foreach($singleProduct->getFeedback as $item)


                                                            <div class="row">
                                                                <div class="col-xs-12 @if(isset($scroll_feed)) @if($scroll_feed['order_id'] == $item->order_id && $scroll_feed['user_id'] == $item->user_id) my_feed_back @endif @endif">

                                                                        <div class="feedback">
                                                                            <table class="table_feed" border="0" width="100%">
                                                                               {{-- <input value="{{$item->user_id}}" type="text"/>
                                                                                <input value="{{$item->order_id}}" type="text"/>--}}

                                                                                <tr>
                                                                                    <td width="10%" style="color: #06c;font-weight: 700;">{{$item->getUser->getUserInformation->name}}</td>
                                                                                    <td>
                                                                                        <div class="par">
                                                                                            <div class="stars">
                                                                                                <div style="width:{{($item->rating*100)/5}}%" class="star_feed">&nbsp;</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="right"  class="a"></td>
                                                                                    <td>
                                                                                        <div class="feed_content">
                                                                                            {{$item->feedback}}
                                                                                        </div>

                                                                                    </td>
                                                                                </tr>

                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td style="color: #999;">
                                                                                        {{ $item->created_at->toDateTimeString()}}
                                                                                    </td>
                                                                                </tr>

                                                                            </table>
                                                                        </div>

                                                                </div>
                                                            </div>

                                                            <style>
                                                                .my_feed_back{
                                                                    background-color: #dff0d8;
                                                                }

                                                                .feedback{
                                                                    padding: 10px;
                                                                    border-top: 1px solid #ddd;
                                                                    margin-bottom: 10px;
                                                                }

                                                                td{
                                                                    padding:8px!important;
                                                                }

                                                            </style>


                                                            @endforeach
                                                        @else
                                                         Отзывов нет

                                                    @endif





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
        </div>
    </div>
</div>

<script>
    var getProductUrl = '{{route('ajax_single_product')}}';
    var addToCartUrl = '{{route('ajax_add_to_cart')}}';
    var cartUrl = '{{route('cart')}}';






</script>

{!! HTML::script('/js/like_and_cart_add.js') !!}