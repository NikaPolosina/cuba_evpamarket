<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">

                @include('slide')

                <div class="col-sm-12" ><h3>Магазины</h3></div>

                    <div class="col-sm-12" >
                        @foreach($companyAll as $valueCompanw)
                            <div class="col-md-3 carentFindCompany">
                                <div class="shop_show" style="border: solid 1px grey; margin: 3px;">
                                    <a class="">{{$valueCompanw->company_name}}</a>
                                    <input id="input_id" value="{{$valueCompanw->id}}" type="hidden"/>

                                    <?php  if(!empty($valueCompanw->company_logo)&& file_exists(public_path().'/img/custom/companies/thumbnail/'.$valueCompanw->company_logo)) {
                                        $logo = '/img/custom/companies/thumbnail/'.$valueCompanw->company_logo;
                                    }else{
                                        $logo = '/img/custom/files/thumbnail/plase.jpg';
                                    } ?>

                                    <img class="img-thumbnail" style="display: block; width: 100%;" src="{{$logo}}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                <hr/>
                <div class="col-sm-12"><h3>Товары</h3></div>
                    <div class="col-sm-12">
                        <?php foreach($productAll as $v){
                            $idProduct = $v['id'];
                            $idCompany = $v->getCompany[0]['id'];
                            $directory = public_path().'/img/custom/companies/'.$idCompany.'/products/'.$idProduct;
                            $directoryMy = '/img/custom/companies/'.$idCompany.'/products/'.$idProduct.'/';
                            if(!empty($v['product_image']) && File::exists($directory.'/'.$v['product_image'])){
                                $firstFile = $directoryMy.$v['product_image'];
                            }else{
                                if(is_dir($directory)){
                                    $files = scandir($directory);
                                    $firstFile = $directoryMy.$files[2];// because [0] = "." [1] = ".."
                                    if(is_dir(public_path().$firstFile)){
                                        if(isset($files[3]))
                                            $firstFile = $directoryMy.$files[3];
                                        else
                                            $firstFile = '/img/custom/files/thumbnail/plase.jpg';
                                    }
                                }else{
                                    $firstFile = '/img/custom/files/thumbnail/plase.jpg';
                                }
                            }
                        ?>
                            <div class="col-md-3">
                                <div class="carentFindProduct">
                                    <div class="item">
                                        <p><h4 class="show-product">{{$v->product_name}}</h4></p>
                                       @if(isset($firstFile))
                                        <img class="img-thumbnail show-product" src="{{$firstFile}}">
                                       @endif
                                        <input class="input_id_product" value="{{$v->id}}" type="hidden"/>
                                        <br>   <p style="font-size: 14px;">{{$v->content}}</p>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


{!! HTML::script('/js/welcome.js') !!}
@endsection


        <style>
            body{
                background:#edeae2 url(../images/cardboard.jpg) repeat top left;
                color:#000;
                font-family: 'PT Sans Narrow', 'Arial Narrow', Arial, sans-serif;
                font-size:13px;
                min-height:800px;
            }
            .show-product {
                cursor: pointer;
            }
            .shop_show{
                cursor: pointer;
            }
            .register_right{
                padding-top: 0px!important;
                text-align: left!important;
            }
            a:hover {
                text-decoration: none!important; /* Отменяем подчеркивание у ссылки */
            }
            .masonry {
                margin: 1.5em 0;
                padding: 0;
                column-gap: 1.5em; /* Общее расстояние между колонками */
                font-size: .85em;
                -moz-column-gap: 1.5em; /* Расстояние между колонками для Firefox */
                -webkit-column-gap: 1.5em; /* Расстояние между колонками  для Safari, Chrome и iOS */
            }

            /* Элементы в виде плиток с содержанием */
            .item {
                display: inline-block;
                background: #fff;
                padding: 1em;
                margin: 0 0 1.5em;
                width: 100%;
                box-sizing: border-box; /* Изменения алгоритма расчета ширины и высоты элемента.*/
                -moz-box-sizing: border-box; /* Для Firefox */
                -webkit-box-sizing: border-box; /* Для Safari, Chrome, iOS иAndroid */
                box-shadow: 2px 2px 4px 0 #ccc; /* Внешняя тень плиток */
            }

            /* Стили картинок, видое и фреймов внутри адаптивных плиток */
            img, iframe {
                max-width: 100%;
                height: auto;
                display: block;
            }

            /* Стили ссылок внутри плиток */
            .item a {
                text-decoration: none;
                color: #359CC6;
                margin: 0 10px;
            }

            /* Стили ссылок при наведении */
            .item a:hover {
                color: #E88F00;
                border-bottom: 1px dotted #9F1D35;
            }

            /* Медиа-запросы для различных размеров адаптивного макета */
            @media only screen and (min-width: 400px) {
                .masonry {
                    -moz-column-count: 2;
                    -webkit-column-count: 2;
                    column-count: 2;
                }
            }

            @media only screen and (min-width: 700px) {
                .masonry {
                    -moz-column-count: 3;
                    -webkit-column-count: 3;
                    column-count: 3;
                }
            }

            @media only screen and (min-width: 900px) {
                .masonry {
                    -moz-column-count: 4;
                    -webkit-column-count: 4;
                    column-count: 4;
                }
            }

            @media only screen and (min-width: 1100px) {
                .masonry {
                    -moz-column-count: 5;
                    -webkit-column-count: 5;
                    column-count: 5;
                }
            }

            @media only screen and (min-width: 1280px) {
                .wrapper {
                    width: 1260px;
                }
            }
        </style>