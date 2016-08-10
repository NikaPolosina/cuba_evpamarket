@extends('layouts.app')
    @section('content')
    @include('layouts.header_menu')

    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
    <div class="row">
        {!! HTML::script('/js/caunt_product.js') !!}
        @if(count($companies))
            @foreach($companies as $value)
                <div class="company_block_cart">

                <div class="col-md-12 cart_name">
                    <h3 style="    font-family: sans-serif; text-transform: uppercase; text-align: center; font-weight: 700;">Магазин: <sapn style="color: darkblue;">{{$value['company']->company_name}}</sapn></h3>
                </div>

                <div class="col-md-8 col-md-offset-2" style="border: 1px solid #c1c1c1; background-color: #f5f5f5; margin-bottom: 25px;">
                    <div class="" style="margin-top: 25px">

                        {{ Form::open(array('url' => '/order',  'method' => 'post')) }}
                        {{  Form::token()}}


                        {!! Form::hidden('company_id', $value['company']->id, ['class' => 'form-control', 'data-name' =>'company_id']) !!}

                            <div class="col-md-12 my_my">

                                <style>
                                    .table_mod{
                                        border-collapse: separate!important;
                                    }
                                    .table_mod td, .table_mod th{
                                        padding: 5px!important;
                                        margin: 5px!important;
                                    }
                                    .my_b{
                                        width: 50%;
                                    }
                                    .input-group-btn{
                                        max-width: 30px;
                                        max-height: 30px;
                                        height: 30px;
                                        text-align: center;
                                        width: 30px;
                                    }
                                    #input_b{
                                        height:30px;
                                    }

                                </style>

                                @foreach($value['products'] as $val)

                                    <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p" style="background-color: white;">
                                        <div class="col-sm-1">
                                            {!! Form::checkbox('product['.$val->id.'][checked]', 'true', ['class' => 'sfzs']) !!}
                                            <input class="input_id_del" value="{{$val->id}}" type="hidden"/>
                                        </div>
                                        <div class="col-sm-2">
                                            <div style="max-width: 100%;">
                                                <img class="img_product img-thumbnail" src="{{$val['firstFile']}}" alt=""/>
                                            </div>
                                        </div>

                                        <div class="col-sm-9">
                                            <table class="table_product table_mod" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                <tr>
                                                    <td width="35%"><span class="option_table">Товар:</span></td>
                                                    <td width="65%" valign="top"><p class="name" style="font-size: 16px; font-weight: bold; color: darkblue;" >{{$val['product_name']}}</p></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><span class="option_table">Краткое описание:</span></td>
                                                    <td width="65%" valign="top"><p style="font-size: 16px;" class="product_description"> {{$val['product_description']}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="35%"><span class="option_table">Количество:</span></td>
                                                    <td width="65%" valign="top">

                                                        {{-------------------------------Количество товара----------------------------------}}
                                                        <div class="my_b">
                                                            <div class="input-group number-spinner">
                                                            <span class="input-group-btn data-dwn">
                                                                <button type="button" class="btn btn-default btn-info left_b" data-dir="dwn" style="width: 30px;     height: 30px;">
                                                                    <span class="glyphicon glyphicon-minus" style=" left: 5px;"></span>
                                                                </button>
                                                            </span>

                                                                {!! Form::text('product['.$val->id.'][cnt]', $val['cnt'], ['class' => 'form-control  text-center my_b"', 'id'=>'input_b', 'data-name' =>'cnt',  "min"=>"1", "max"=>"40", "readonly" ]) !!}

                                                            <span class="input-group-btn data-up">
                                                                <button  type="button" class="btn btn-default btn-info right_b" data-dir="up" style="width: 30px;     height: 30px;">
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
                                                    <td width="35%" valign="top"><span class="option_table">Цена за еденицу товара:</span></td>
                                                    <td width="65%" valign="top"><div class="product_price yelloy"><span class="product_price_one" style=""> {{$val['product_price']}}</span> <span>руб.</span></div></td>
                                                </tr>
                                                <tr>
                                                    <td width="35%" valign="top"><span class="option_table">Общяя стомость:</span></td>
                                                    <td width="65%" valign="top">
                                                        <div class="product_price yelloy_big">
                                                            <span class="all_product_price" style=""> {{$val['product_price']*$val['cnt']}} </span><span>руб.</span>
                                                        </div>
                                                    </td>
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
                                @if(count($value['company']->getDiscountAccumulativ) > 0)
                                    <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p" style="background-color: white;">
                                        <tr style="background-color: #f7f7f9; outline: 1px solid #dedee4;">
                                            <td width="50%" valign="top">
                                                <span class="option_table" style="margin: 10px;">Cкидки магазина:</span>
                                                <p style="font-size: 13px; margin: 10px">Это накопительная скидка, которую предоставляет магазин.
                                                    Эта скидка действует при заказе на сумму, которая соответствует диапазону соответствующей процентной скидки.
                                                    После оформления заказа и подтверждени продавцом о его получении покупателем - эта скидка закрепляется за Вами до тех пор,
                                                    пока Вы не повысите сумму накоплений в этом магазине до следующей болие высокой скидки. </p>
                                            </td>
                                            <td>
                                                <table class="my_table" border="2" align="center" bordercolor="#ddd">
                                                    <tr>
                                                        <th>При заказе на сумму от:</th>
                                                        <th>Скидка</th>
                                                    </tr>
                                                    @foreach($value['company']->getDiscountAccumulativ as $val)
                                                        <tr class=" <?=($value['discount']['id'] == $val->id)? 'current_discount':'' ?>" ><td><span style="color: #2a62bc;">{{$val->from}} руб.</span></td><td><span style="color: indianred;">{{$val->percent}} %</span></td></tr>
                                                    @endforeach

                                                </table>
                                            </td>
                                        </tr>
                                    </div>
                                @endif

                                <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p" style="background-color: white;">
                                <h3>Сумма по завершенным заказам в этом магазине : <b>{{$value['totalHistoryAmount']}}</b> руб.</h3>
                                <h3>Текущая покупка на сумму : <b>{{$value['totalAmount']}}</b> руб.</h3>
                                <h3>Ощая сумма для учёта скидки : <b>{{$value['total']}}</b> руб.</h3>
                                    @if($value['discount'])
                                        <h3>У Вас будет скидка : <b>{{$value['discount']['percent']}}</b> %</h3>
                                    @endif
                                </div>
                                <div class="col-sm-10 col-sm-offset-1" style="margin-bottom: 25px;">

                                        {!! Form::submit('Оформить заказ', ['class' => 'btn btn-lg btn-success button_my']) !!}

                                    </div>
                            </div>

                        {{ Form::close() }}
                    </div>
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
        .option_table{
            font-size: 18px;
        }

        .my_table td,th {
            padding: 5px!important;
        }

        .my_table{
            border-spacing: 3px!important;
            border-collapse: separate;
            text-align: center;
            margin-top: 10px;
        }
        .button_my{
            margin-bottom: 10px;
            float:right;
            box-shadow: 3px 3px 7px 0 rgba(105, 206, 95, .5), inset 0 -3px 0 0 #3a9731;
            background: -webkit-linear-gradient(top, #79d670, #4bbe3f);
        }

        .current_discount{
            background: green;
            font-weight: bold;
            color: black;
        }
    </style>

@endsection
