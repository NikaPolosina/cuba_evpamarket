@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="/css/find.css" />

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body">

                {{--<input type="text" value="Найдено записей - {{count($data)}}"/>--}}



            @if(isset($data) && count($data)>= 1)
                    <h3>Товары по данной категории.</h3>
                @foreach($data as $value)
                <div class="col-sm-4" style="    border: solid 1px #bbb7b7;">
                    <div class="product-box">
                        <div class="container">
                            <?php

                            $idProduct = $value->id;
                            $idCompany =$value->getCompany->first()->id;
                            $directory = public_path().'/img/custom/companies/'.$idCompany.'/products/'.$idProduct;
                            $directoryMy = '/img/custom/companies/'.$idCompany.'/products/'.$idProduct.'/';

                            if(is_dir($directory)){

                                $files = scandir($directory);
                                $firstFile = $directoryMy.$files[2];// because [0] = "." [1] = ".."

                                if(is_dir(public_path().$firstFile)){
                                    if(isset($files[3]))
                                        $firstFile = $directoryMy.$files[3];
                                    else
                                        $firstFile = '/img/system/plase.jpg';
                                }
                            }else{
                                $firstFile = '/img/system/plase.jpg';
                            }

                            ?>



                            <img src="{{$firstFile}}" alt="cookies" class="hero-image" />
                            <div class="price">рублей
                                <div>{{$value->product_price}}</div>
                            </div>

                            <div class="information">
                                <div class="name">{{$value->product_name}}</div>
                                <div class="store">cuba.com</div>
                                <a href="#" class="button">Купить продукт</a>
                            </div>



                        </div>
                    </div>
                </div>
                @endforeach

            @else
                  <h3>В данной категрии пока ещё нет товаров.</h3>
            @endif



            </div>
        </div>
    </div>
</div>


@endsection