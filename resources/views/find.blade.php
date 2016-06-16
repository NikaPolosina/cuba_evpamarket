<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">

                    {{--<input type="text" value="Найдено записей - {{count($data)}}"/>--}}


                @if(isset($data))
                        @foreach($data as $value)
                        <div class="col-sm-4" style="    border: solid 1px #bbb7b7;">
                            <div class="product-box">
                                <div class="container">
                                    <?php

                                        $idProduct = $value['id'];
                                        $idCompany = $value->getCompany[0]['id'];
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
                    @endif


                </div>
            </div>
        </div>
    </div>

    <style>
            .hero-image{
                display: inline-block;
                max-width: 100%;
            }

        .product-box {
            font: 13px/23px "Raleway", Arial, sans-serif;
            color: #303336;
            padding: 40px 0px 0px 0px;
        }

        .container {
            margin: 0 auto;
            width: 300px;
            height: 360px;
            background: white;
            border-radius: 3px;
            position: relative;
        }

        .price {
            position: absolute;
            top: 20%;
            left: 25%;
            color: white;
            text-align: center;
            background: rgba(0, 153, 255, 0.8);
            border-radius: 50%;
            padding: 19px 33px;
            font-size: 22px;
        }
        .price div {
            margin-top: 5px;
            font-weight: bold;
        }

        .information {
            text-align: center;
            margin-top: 18px;
        }

        .name {
            font-size: 22px;
        }

        .store {
            font-size: 16px;
            color: #8c98a8;
            margin-bottom: 28px;
        }

        .button {
            text-decoration: none;
            background: #49B956;
            color: white;
            font-size: 16px;
            font-weight: 500;
            padding: 12px 54px;
            border-radius: 5px;
        }
        .button:hover {
            background: #60CF6F;
            text-decoration: none;
        }



    </style>
@endsection