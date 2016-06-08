<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
<div class="row">
        @if (Auth::guest())
                    <div class="col-md-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">Войти</div>
                                <div class="panel-body">
                                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                        {!! csrf_field() !!}
                                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label class="col-md-12 control-label register_right">E-Mail</label>
                                                <div class="col-md-12">
                                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                                    @if ($errors->has('email'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label class="col-md-12 control-label register_right">Пароль</label>
                                                <div class="col-md-12">
                                                    <input type="password" class="form-control" name="password">
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="remember"> Запомнить меня
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-btn fa-sign-in"></i>Вход
                                                    </button>
                                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">Забыл пароль?</a>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                        </div>
                    </div>

                <div class="col-md-10">
            @endif
                    <div class="col-md-12">

                    <div class="">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <p style="display: inline-block"> Добро пожаловать!</p>

                                    <form method="POST" action="find" style="display: inline-block; float: right">
                                        {{ csrf_field() }}
                                        <input name="find" type="text" placeholder="Введите текст для поиска"/>
                                        <p style="display: inline-block"><input type="submit" value="Искать">
                                    </form>
                                </div>
                                <div class="panel-body">
                              {{--      <img style="width: 100%; height: 50%" src="/img/bg.jpg" alt="картинка">--}}


                                <?php
                                        if(isset($data)){
                                            //echo'Искомое слово - '.$search.'<br>';
                                            //echo 'Время выполнения - '.(time() - $time).'секунд. <br>';
                                            echo 'Найдено записей - '.count($data);
                                        ?>
                                        <div>
                                            <?php
                                                foreach ($data as $value) {?>
                                                <div class="col-md-2">
                                                    <div class="carentFindProduct" style="border: solid 1px grey; margin: 3px;">Искомая строка -{{$value->product_name}}</div>
                                                </div>

                                        </div>
                                            <?php }
                                            ?>
                                    <hr>
                                    <?php
                                    }else{
                                    ?>

                                    <div class="col-sm-10">

                                        <div><h3 style="">Магазины</h3></div>


                                        <?php foreach($companyAll as $valueCompanw){?>
                                        <div class="col-md-2 carentFindCompany">
                                            <div class="shop_show" style="border: solid 1px grey; margin: 3px;">
                                                <a class="">{{$valueCompanw->company_name}}</a>
                                                <input id="input_id" value="{{$valueCompanw->id}}" type="hidden"/>

                                                <?php  if(!empty($valueCompanw->company_logo)&& file_exists(public_path().'/img/custom/companies/thumbnail/'.$valueCompanw->company_logo)) {
                                                    $logo = '/img/custom/companies/thumbnail/'.$valueCompanw->company_logo;
                                                }else{

                                                    $logo = '/img/custom/files/thumbnail/plase.jpg';
                                                } ?>

                                                <img class="img-thumbnail" style="display: block; width: 100%;" src="<?=$logo?>">
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="col-sm-10">
                                        <hr>
                                        <div><h3>Товары</h3></div>
                                    </div>


                                    <div class="col-sm-10 masonry">

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

                                        <div class="carentFindProduct">

                                            <div class="item">
                                                <p><h4 class="show-product">{{$v->product_name}}</h4></p>
                                                <?php if(isset($firstFile)){?>
                                                <img class="img-thumbnail show-product" src="<?=$firstFile?>">
                                                <?php } ?>
                                                <input class="input_id_product" value="{{$v->id}}" type="hidden"/>
                                                <br>   <p style="font-size: 14px;">{{$v->content}}</p>
                                            </div>

                                        </div>


                                                <?php } ?>
                                    </div>


                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
</div>

{!! HTML::script('/js/welcome.js') !!}
@endsection


        <style>
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