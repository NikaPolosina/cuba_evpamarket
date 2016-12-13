<div class="col-xs-10 col-sm-10 item_class">
    <div class="panel panel-default item_class_2">
        <div class="panel-body item_class_3">
            <link rel="stylesheet" type="text/css" href="/css/single_product_info.css"/>
            <link rel="stylesheet" type="text/css" href="/css/show_product.css"/>
            <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
            @include('product.modalAddProductCart')
            @include('product.modalAddProductLike')

            <div class="row row_row">
                <div class="item_class_3">

                    <div class="seller" style="margin: 6px 6px 6px 30px">
                        <span>Продавец:</span> <a href="/show-user/{{$singleProduct->getCompany[0]->getUser[0]->id}}">{{$singleProduct->getCompany[0]->getUser[0]->getUserInformation->name}}{{$singleProduct->getCompany[0]->getUser[0]->getUserInformation->surname}}</a>
                       @if(Auth::user()) <a href="/get-single-conversation/{{Auth::user()->id}}/{{$singleProduct->getCompany[0]->getUser[0]->id}}"><button type="button" class="btn btn-default btn-sm">Связаться с продавцом</button></a>@endif

                    </div>

                    <style>
                        .seller{
                            font-size: 16px;
                        }
                        .seller>a{
                            font-weight: bold;
                        }

                    </style>

                    <div class="item_class_4 item_1">
                        <input style="display: none" data-name="product-id" type="text" value="{{$singleProduct->id}}"/>
                        <div class="carent_my_product">
                            <div class="col-sm-12">
                                <div class="portlet box">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <div>{{ $singleProduct->product_name}} <span>ID: {{$singleProduct->id}}</span></div>

                                        </div>
                                    </div>
                                    <div class="portlet-body" style="padding: 0px;">
                                        <div class="tabbable-custom ">
                                            <ul class="nav nav-tabs ">
                                                <li class="@if(!isset($scroll_feed))active @endif" style="border-top: 3px solid #32c5d2!important;">
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
                                            <div class="tab-content" style="min-height: 600px; border: none;">
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
                                                                            @if($singleProduct->min_price && $singleProduct->max_price)
                                                                                <span class="desk-price">{{ $singleProduct->min_price}} - {{$singleProduct->max_price}}  руб.</span>
                                                                            @else
                                                                                <span class="desk-price">{{ $singleProduct->product_price}} руб.</span>
                                                                            @endif
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














                                                    {{--Формирование цены для заказа (возможность выбора) --}}
                                                    <div class="add_price_block_holder">
                                                        {!! $singleProduct->content !!}

                                                        @if(isset($addParam) && is_array($singleProduct->value) )
                                                            <?php $priceTab = 0; ?>
                                                            @if(count($singleProduct->value) == 1)
                                                                @foreach($singleProduct->value as $basePrice)
                                                                    <div class="add_price_holder active">
                                                                        <?php
                                                                            if(!array_key_exists('add_param', $basePrice)){
                                                                                $basePrice['add_param'] = array();
                                                                            }
                                                                        ?>
                                                                        @include('product.additionParamPrice', ['base_price'=>$basePrice['val'], 'add_price'=>$basePrice['add_param']])
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="base_price_holder">
                                                                    <?php $priceTab = 0; ?>
                                                                    <ul class="nav nav-tabs">
                                                                        @foreach($singleProduct->value as $basePrice)
                                                                            <?php $priceTab++ ?>
                                                                            <li class="current_price <?=($priceTab == 1)?'active':'' ?>" ><a data-toggle="tab" href="#add_price_{{$priceTab}}">
                                                                                    <div>Модель: {{$basePrice['name'] or ''}}</div>
                                                                                    <div>Цена: {{$basePrice['val']}}</div>
                                                                                </a></li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <?php $priceTab = 0; ?>
                                                                    <div class="tab-content">
                                                                        @foreach($singleProduct->value as $basePrice)
                                                                            <?php $priceTab++ ?>
                                                                            <div id="add_price_{{$priceTab}}" class="add_price tab-pane fade in add_price_holder <?=($priceTab == 1)?'active':'' ?> ">
                                                                                <?php
                                                                                if(!array_key_exists('add_param', $basePrice)){
                                                                                    $basePrice['add_param'] = array();
                                                                                }
                                                                                ?>
                                                                                @include('product.additionParamPrice', ['base_price'=>$basePrice['val'], 'add_price'=>$basePrice['add_param']])
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif

                                                        @else
                                                            <div class="add_price_holder active">
                                                                <input type="hidden"  value="{{$singleProduct->product_price}}" name="" class="base_price"/>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <script>
                                                        function calculatePrice(){
                                                            var add_price_holder = $('.add_price_holder.active');
                                                            var price = {};
                                                            var addParam = {};
                                                            var type;
                                                            var item;
                                                            var add_param_holder;
                                                            var addPrice = {};

                                                            price['base_price'] = 0;
                                                            price['current_price'] = price['base_price'];
                                                            price['add_param'] = [];

                                                            if(add_price_holder.length){
                                                                price['base_price'] = parseFloat(add_price_holder.find('.base_price').val());
                                                                price['current_price'] = price['base_price'];

                                                                if(add_price_holder.find('.param_holder').length){
                                                                    //console.log(add_price_holder.find('.param_holder'));
                                                                    
                                                                    add_price_holder.find('.param_holder').each(function(index, item){
                                                                        console.log();
                                                                        

                                                                        type = $(item).find('.add_price_title').attr('data-type');

                                                                        if(type.length){
                                                                            item = $(item);

                                                                            switch (type){
                                                                                case 'checkbox':
                                                                                    if(item.find('input:checked').length){
                                                                                        if(item.find('.add_price_title').val().length){
                                                                                            addParam = {};
                                                                                            addParam['title'] = item.find('.add_price_title').val();
                                                                                            addParam['add_param'] = [];

                                                                                            item.find('input:checked').each(function(k, i){
                                                                                                add_param_holder = $(i).parents('.add_param_holder').eq(0);

                                                                                                addPrice = {};
                                                                                                addPrice['price'] = add_param_holder.find('.add_param_price').val();
                                                                                                price['current_price'] = price['current_price']+parseFloat(addPrice['price']);
                                                                                                addPrice['name'] = add_param_holder.find('.add_param_name').val();
                                                                                                addParam['add_param'].push(addPrice);
                                                                                            });
                                                                                            addPrice = {};
                                                                                        }
                                                                                    }
                                                                                    break;
                                                                                case 'radio':
                                                                                    if(item.find('input:checked').length){
                                                                                        if(item.find('input:checked').val().length){
                                                                                            addParam = {};
                                                                                            addParam['title'] = item.find('.add_price_title').val();
                                                                                            addParam['add_param'] = [];

                                                                                            item.find('input:checked').each(function(k, i){
                                                                                                add_param_holder = $(i).parents('.add_param_holder').eq(0);

                                                                                                addPrice = {};
                                                                                                addPrice['price'] = add_param_holder.find('.add_param_price').val();
                                                                                                price['current_price'] = price['current_price']+parseFloat(addPrice['price']);
                                                                                                addPrice['name'] = add_param_holder.find('.add_param_name').val();
                                                                                                addParam['add_param'].push(addPrice);
                                                                                            });
                                                                                            addPrice = {};
                                                                                        }
                                                                                    }
                                                                                    break;
                                                                                case 'select':
                                                                                    if(item.find('select').length){
                                                                                        if(item.find('select').val().length){
                                                                                            addParam = {};
                                                                                            addParam['title'] = item.find('.add_price_title').val();
                                                                                            addParam['add_param'] = [];

                                                                                            add_param_holder = item.find('select').parents('.add_param_holder').eq(0);

                                                                                            addPrice = {};
                                                                                            addPrice['price'] = add_param_holder.find('.add_param_price').val();
                                                                                            price['current_price'] = price['current_price']+parseFloat(addPrice['price']);
                                                                                            addPrice['name'] = add_param_holder.find('.add_param_name').val();
                                                                                            addParam['add_param'].push(addPrice);

                                                                                            addPrice = {};
                                                                                        }
                                                                                    }
                                                                                    break;
                                                                                case 'input':
                                                                                    if(item.find('input.jq_val_input').length){
                                                                                        if(item.find('input.jq_val_input').val().length){
                                                                                            addParam = {};
                                                                                            addParam['title'] = item.find('.add_price_title').val();
                                                                                            addParam['add_param'] = [];

                                                                                            add_param_holder = item.find('select').parents('.add_param_holder').eq(0);

                                                                                            addPrice = {};
                                                                                            addPrice['price'] = 0;
                                                                                            price['current_price'] = price['current_price']+parseFloat(addPrice['price']);
                                                                                            addPrice['name'] = item.find('input.jq_val_input').val();
                                                                                            addParam['add_param'].push(addPrice);

                                                                                            addPrice = {};
                                                                                        }
                                                                                    }
                                                                                    break;
                                                                            }

                                                                            if(Object.keys(addParam).length)
                                                                                price['add_param'].push(addParam);

                                                                            addParam = {};
                                                                        }

                                                                    });
                                                                }

                                                            }

                                                            return price;
                                                        }

                                                        var newPrice;

                                                        $(document).ready(function(){

                                                            $('.add_price_block_holder').delegate('*', 'change', function(event){
                                                                event.stopPropagation();

                                                                newPrice = calculatePrice();
                                                                $('.desk-price').html(newPrice.current_price+' руб.');
                                                                newPrice = null;
                                                            });

                                                        });
                                                    </script>
                                                    {{--Формирование цены для заказа (возможность выбора) --}}

                                                </div>
                                                <div class="tab-pane" id="tab_5_2">
                                                    <p style="font-size: 16px; font-weight: bold"> Xарактеристики  {{ $singleProduct->product_name }} </p>








                                                    {{--Характеристики для каждой базовой цены (без возможности выбора) --}}
                                                        @if(isset($addParam) && is_array($singleProduct->value))

                                                            @if(count($singleProduct->value) == 1)
                                                                <?php $paramTab = 0; ?>

                                                                @foreach($singleProduct->value as $basePrice)
                                                                    <?php $paramTab++ ?>
                                                                    <div id="add_param_{{$paramTab}}" class="tab-pane fade in <?=($paramTab == 1)?'active':'' ?>">
                                                                        <?php
                                                                        if(!array_key_exists('add_param', $basePrice)){
                                                                            $basePrice['add_param'] = array();
                                                                        }
                                                                        ?>
                                                                        @include('product.additionParamShow', ['add_price'=>$basePrice['add_param']])
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <div class="base_price_holder">
                                                                    <?php $paramTab = 0; ?>
                                                                    <ul class="nav nav-tabs">
                                                                        @foreach($singleProduct->value as $basePrice)
                                                                            <?php $paramTab++ ?>
                                                                            <li class="<?=($paramTab == 1)?'active':'' ?>"><a data-toggle="tab" href="#add_param_{{$paramTab}}">
                                                                                    <div>Модель: {{$basePrice['name'] or ''}}</div>
                                                                                    <div>Цена: {{$basePrice['val']}}</div>
                                                                                </a></li>
                                                                        @endforeach
                                                                    </ul>
                                                                    <?php $paramTab = 0; ?>
                                                                    <div class="tab-content">
                                                                        @foreach($singleProduct->value as $basePrice)
                                                                            <?php $paramTab++ ?>
                                                                            <div id="add_param_{{$paramTab}}" class="tab-pane fade in <?=($paramTab == 1)?'active':'' ?>">
                                                                                <?php
                                                                                if(!array_key_exists('add_param', $basePrice)){
                                                                                    $basePrice['add_param'] = array();
                                                                                }
                                                                                ?>
                                                                                @include('product.additionParamShow', ['add_price'=>$basePrice['add_param']])
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    {{--Характеристики для каждой базовой цены (без возможности выбора) --}}




















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
                                                                                <input class="id_feed" value="{{$item->id}}" type="hidden"/>


                                                                                <tr>
                                                                                    <td width="10%" style="color: #06c;font-weight: 700;">{{$item->getUser->getUserInformation->name}}</td>
                                                                                    <td width="60%">
                                                                                        <div class="par">
                                                                                            <div class="stars">
                                                                                                <div style="width:{{($item->rating*100)/5}}%" class="star_feed">&nbsp;</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="right"  class="a">

                                                                                        <div class="hand_img">

                                                                                            @if(!empty($item->getUser->getUserInformation->avatar) && file_exists(public_path().$item->getUser->getUserInformation->avatar))
                                                                                                <img src="{{$item->getUser->getUserInformation->avatar}}" alt="avatar">
                                                                                            @else
                                                                                                <img src="/img/placeholder/avatar.jpg" alt="avatar"/>
                                                                                            @endif
                                                                                        </div>


                                                                                    </td>
                                                                                    <td>
                                                                                        <div class="feed_content">
                                                                                            {!!$item->feedback!!}
                                                                                        </div>

                                                                                    </td>

                                                                                    @if(isset($scroll_feed))
                                                                                        @if($scroll_feed['order_id'] == $item->order_id && $scroll_feed['user_id'] == $item->user_id)
                                                                                            <td>
                                                                                                <button type="submit" class="btn default edit_feed">Редактировать</button>
                                                                                                <button type="reset" id="feed-add" class="btn default">Дополнить</button>
                                                                                            </td>
                                                                                        @endif
                                                                                    @endif

                                                                                </tr>

                                                                                <tr>
                                                                                    <td></td>
                                                                                    <td style="color: #999;">
                                                                                        {{ $item->created_at->toDateTimeString()}}
                                                                                    </td>
                                                                                </tr>

                                                                            </table>
                                                                            <div class="addit_feed_js">
                                                                                @if(count($item->getAdditionFeed))
                                                                                    @foreach($item->getAdditionFeed as $it)
                                                                                        <div class="it_css_block">
                                                                                            {!!$it->msg!!}
                                                                                            <p style="color: #999;">
                                                                                                <span>Дополнено:</span>    {{ $it->created_at->toDateTimeString()}}
                                                                                            </p>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @endif
                                                                            </div>

                                                                        </div>

                                                                </div>
                                                            </div>

                                                            <style>

                                                                .hand_img{
                                                                    width: 100px;
                                                                    height: 100px;
                                                                    overflow: hidden;
                                                                }
                                                                .hand_img>img{
                                                                    max-height: 100%;
                                                                    margin: auto;
                                                                }

                                                                .it_css_block{
                                                                    margin-bottom: 3px;
                                                                    margin-left: 20%;
                                                                    padding: 10px;
                                                                    background-color: white;
                                                                }
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
                                                                hr, p {
                                                                    margin: 0px 0;
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
@include('order.modalFeedback')

<script>


    $('.edit_feed').on('click', function () {
        $('button#feed-change').removeClass('adit_feed');
        var body = $(this).parents('.feedback').find('.feed_content').html();
        var id =  $(this).parents('.feedback').find('input.id_feed').val();
        $('input.input_id_modal_feed').val('');
        $('input.input_id_modal_feed').val(id);

        tinymce.activeEditor.setContent('');
        tinymce.activeEditor.setContent(body);
        $('#feed_modal').modal();
    });

    $('button#feed-add').on('click', function () {
        var id =  $(this).parents('.feedback').find('input.id_feed').val();
        $('input.input_id_modal_feed').val(id);
        $('button#feed-change').addClass('adit_feed');
        tinymce.activeEditor.setContent('');
        $('#feed_modal').modal();
    });

    $('button#feed-change').on('click', function () {
        var body = tinymce.activeEditor.getContent();
        var id = $('input.input_id_modal_feed').val();
        if($(this).hasClass("adit_feed")){

            $.ajax({
                type    : "POST",
                url     : '/add-ajax-addition-feed',
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {id : id, body: body},
                success : function(response){
                    $.each($('.id_feed'), function( index, value ) {

                        if($(value).val() == id){
                            $(this).parents('.feedback').find('.addit_feed_js').append( '<div class= "it_css_block">'+ response.msg +
                                    '<p style="color: #999;"><span>Дополнено:</span>' + response.updated_at + '</p></div>' );
                        }
                    });

                    $('#feed_modal').modal('hide');
                },
                error   : function(response){
                    console.log('ajax went wrong');
                }
            });
        }else{
            $.ajax({
                type    : "POST",
                url     : '/add-ajax-change-feed',
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {id : id, body: body},
                success : function(response){
                    $.each($('.id_feed'), function( index, value ) {

                        if($(value).val() == id){
                            $(this).parents('.feedback').find('.feed_content').html(response);
                        }
                    });

                    $('#feed_modal').modal('hide');
                },
                error   : function(response){
                    console.log('ajax went wrong');
                }
            });
        }

    });




    var getProductUrl = '{{route('ajax_single_product')}}';
    var addToCartUrl = '{{route('ajax_add_to_cart')}}';
    var cartUrl = '{{route('cart')}}';






</script>

{!! HTML::script('/js/like_and_cart_add.js') !!}