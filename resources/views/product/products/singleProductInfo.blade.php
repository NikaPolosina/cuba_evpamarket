
@extends('layouts.app')

@section('content')
    @include('layouts.header_menu')
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

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
                                    <td style="width: 500px; padding: 20px;;"> {{ $singleProduct['product_description'] }} </tdstyle>
                                    <td> {{ $singleProduct['product_price'] }} </td>
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
    <style>
        .tabbable-custom>.nav-tabs>li.active {
            border-top: 3px solid #32c5d2!important;
        }
    </style>
@endsection


