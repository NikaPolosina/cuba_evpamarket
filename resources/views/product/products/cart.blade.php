@extends('layouts.app')
    @section('content')
    @include('layouts.header_menu')

    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
    <div class="row">
        {!! HTML::script('/js/caunt_product.js') !!}
        @if(count($companies))
            @foreach($companies as $value)
                <div class="col-md-8 col-md-offset-2" style="border: 1px solid #eee; background-color: #f8f8f8; margin-bottom: 5px;">
                    <div class="company_block_cart" >

                        {{ Form::open(array('url' => '/order',  'method' => 'post')) }}
                        {{  Form::token()}}
                        <div class="col-md-12 cart_name">
                            <h3 style="text-align: center">Магазин: <sapn style="color: darkblue;">{{$value['company']->company_name}}</sapn></h3>
                        </div>

                        {!! Form::hidden('company_id', $value['company']->id, ['class' => 'form-control', 'data-name' =>'company_id']) !!}

                            <div class="col-md-12 ">
                                @foreach($value['products'] as $val)

                                    <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p" style="background-color: white;">
                                        <div class="col-sm-1">
                                            {!! Form::checkbox('product['.$val->id.'][checked]', 'true', ['class' => 'sfzs']) !!}
                                        </div>
                                        <div class="col-sm-2">
                                            <div style="max-width: 100%;">
                                                <img class="img_product img-thumbnail" src="{{$val['firstFile']}}" alt=""/>
                                            </div>
                                        </div>

                                        <div class="col-sm-9">
                                            <table class="table_product" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td width="35%"><span class="option_table">Товар:</span></td>
                                                    <td width="65%" valign="top"><p class="name">{{$val['product_name']}}</p></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><span class="option_table">Краткое описание:</span></td>
                                                    <td width="65%" valign="top"><p style="font-size: 20px;" class="product_description"> {{$val['product_description']}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><span class="option_table">Количество:</span></td>
                                                    <td width="65%" valign="top">

                                                        {{-------------------------------Количество товара----------------------------------}}
                                                        <div class="my_b">
                                                            <div class="input-group number-spinner">
                                                            <span class="input-group-btn data-dwn">
                                                                <button type="button" class="btn btn-default btn-info left_b" data-dir="dwn">
                                                                    <span class="glyphicon glyphicon-minus"></span>
                                                                </button>
                                                            </span>

                                                              {{--  <input type="text" class="form-control text-center my_b" value="{{$val['cnt']}}" min="1" max="40" readonly>--}}
                                                                {!! Form::text('product['.$val->id.'][cnt]', $val['cnt'], ['class' => 'form-control  text-center my_b"', 'data-name' =>'cnt',  "min"=>"1", "max"=>"40", "readonly" ]) !!}
                                                               {{-- {!! Form::checkbox('product['.$val->id.'][checked]', '1', ['class' => 'sfzs']) !!}
    --}}
                                                            <span class="input-group-btn data-up">
                                                                <button  type="button" class="btn btn-default btn-info right_b" data-dir="up">
                                                                    <span style="width: 2px;" class="glyphicon glyphicon-plus"></span>
                                                                </button>
                                                            </span>
                                                            </div>
                                                        </div>

                                                        <style>
                                                            .btn-info{
                                                                height:100%;
                                                            }
                                                        </style>

                                                        <div class="">
                                                            <p>{{--В наличии: 40 шт.--}}</p>

                                                        </div>
                                                        {{-----------------------------------------------------------------------------------}}

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="35%" valign="top"><span class="option_table">Цена:</span></td>
                                                    <td width="65%" valign="top"><div class="product_price yelloy"><span class="product_price_one" style=""> {{$val['product_price']}}</span> <span>руб.</span></div></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%" valign="top"><span class="option_table">Общяя стомость:</span></td>
                                                    <td width="65%" valign="top"><div class="product_price yelloy_big"><span class="all_product_price" style=""> {{$val['product_price']*$val['cnt']}} </span><span>руб.</span></div></td>
                                                </tr>
                                            </table>
                                            <hr/>
                                            <div class="buttom_menu">
                                                <input style="display: none" value="{{$val['id']}}" type="text"/>
                                                <button type="button" class="btn btn-default button_delete">Удалить</button>

                                            </div>
                                        </div>

                                    </div>

                                @endforeach
                                    <div class="col-sm-10 col-sm-offset-1">

                                        {!! Form::submit('Оформить заказ', ['class' => 'btn btn-lg btn-success button_my']) !!}

                                    </div>
                            </div>



                        {{ Form::close() }}
                    </div>
                </div>

            @endforeach
            <div class="col-sm-9 col-sm-offset-1 product_item_cart cart_empty product_item_p" style="display: none">
                <h1>Ваша корзина пуста. Вернитесь к сайту что бы добавить товары в корзину.</h1>
            </div>
        @else
            <div class="col-sm-9 col-sm-offset-1 product_item_cart cart_empty product_item_p">
                <h1>Ваша корзина пуста. Вернитесь к сайту что бы добавить товары в корзину.</h1>
            </div>
        @endif
    </div>

    {!! HTML::script('/js/product/cart_delete.js') !!}

    <style>

        .button_my{
            margin-bottom: 10px;
            float:right;
            box-shadow: 3px 3px 7px 0 rgba(105, 206, 95, .5), inset 0 -3px 0 0 #3a9731;
            background: -webkit-linear-gradient(top, #79d670, #4bbe3f);
        }
    </style>

@endsection
