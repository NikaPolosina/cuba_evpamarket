
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


   <div class="row row_row">
            <div class="item_class_3">
                <div class="item_class_4 item_1">
                <input style="display: none" data-name="product-id" type="text" value="{{ $singleProduct['id'] }}"/>
                <div class="carent_my_product">
        <div class="col-sm-10 col-md-offset-1">
        <h1 style="font-size: 2.76923em; font-weight: normal; line-height: 1.2em; margin-bottom: 0.325em; letter-spacing: -0.025em;">Товар</h1>

    <div class="portlet box yellow">
        <div class="portlet-title" style="background-color: #32c5d2!important;">
            <div class="caption">
              <h1>{{ $singleProduct['product_name'] }}</h1>
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
                        <a href="#tab_5_3" data-toggle="tab"> Обзор и видео </a>
                    </li>
                    <li>
                        <a href="#tab_5_4" data-toggle="tab"> Фото </a>
                    </li>
                    <li>
                        <a href="#tab_5_5" data-toggle="tab"> Отзывы </a>
                    </li>
                    <li>
                        <a href="#tab_5_6" data-toggle="tab"> Доставка </a>
                    </li>
                </ul>
                <div class="tab-content">
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
                                        <img class="img-thumbnail" style="display: block; width: 200px; float: right;" src="{{$firstFile}}">


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
                                    {{ $singleProduct['content'] }}
                                </td>
                                <td style="width: 250px;">
                                    {{ $singleProduct['content'] }}
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        <p>
                            <a class="btn green" href="" target="_blank"> Купить </a>
                        </p>
                    </div>
                    <div class="tab-pane" id="tab_5_3">
                        <p style="font-size: 16px; font-weight: bold"> Фото и видео  {{ $singleProduct['product_name'] }} !!!</p>

                        <table class="table table-bordered table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td style="width: 250px;">
                                        <img class="img-thumbnail" style="display: block; width: 200px; float: right;" src="{{$firstFile}}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

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

@endsection

