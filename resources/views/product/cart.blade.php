@extends('layouts.app')
    @section('content')
    @include('layouts.header_menu')

    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
    <div class="row">
        {!! HTML::script('/js/count_product.js') !!}
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
                                        /*padding: 5px!important;
                                        margin: 5px!important;*/
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

                                    .right{
                                        text-align: right;
                                    }
                                    .name{
                                        color: darkblue;
                                    }
                                    .left{
                                        font-size: 16px;
                                        font-weight: bold;
                                        margin: 0;
                                        padding: 0 35px;
                                    }
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
                                    .btn-info{
                                        height:100%;
                                    }
                                    .product_price_cart{
                                        border-radius: 4px;
                                        display: inline-block;
                                        vertical-align: middle;
                                        white-space: nowrap;
                                        border: 1px solid transparent;
                                        font-size: 16px;
                                        padding: 5px;
                                    }
                                    tr{
                                        height: 40px;
                                    }
                                    .a{
                                        text-align: right;
                                        display: inline-block;
                                    }
                                    .b{
                                        display: inline-block;
                                    }
                                    .my_input{
                                        width: 80px!important;

                                    }
                                    .table_product{
                                         border-spacing: 0px!important;
                                    }


                                </style>
                                @foreach($value['products'] as $val)

                                    <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p on" style="background-color: white;     padding-top: 30px;">
                                        <div class="col-sm-1">
                                            <input type="checkbox" name="{{'product['.$val->id.'][checked]'}}" value="true" class="switch" checked/>
{{--                                            {!! Form::checkbox('product['.$val->id.'][checked]', 'true', ['checked' => 'checked', 'class'=>'switch']) !!}--}}
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
                                                    <td width="40%" class="right option_table">

                                                        Товар:

                                                    </td>
                                                    <td width="60%" class="name left">

                                                            {{$val['product_name']}}

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%" class="right option_table">

                                                       Краткое описание:

                                                    </td>
                                                    <td width="60%" class="product_description left">

                                                        {{$val['product_description']}}

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%" class="right option_table">

                                                            Количество:

                                                     </td>
                                                    <td width="60%" class="left">

                                                        {{-------------------------------Количество товара----------------------------------}}
                                                        <div class="my_b">
                                                            <div class="input-group number-spinner">
                                                            <span class="input-group-btn data-dwn">
                                                                <button type="button" class="btn btn-default btn-info left_b" data-dir="dwn" style="width: 30px;     height: 30px;">
                                                                    <span class="glyphicon glyphicon-minus" style=" left: 5px;"></span>
                                                                </button>
                                                            </span>

                                                                {!! Form::text('product['.$val->id.'][cnt]', $val['cnt'], ['class' => 'form-control my_input text-center my_b"', 'id'=>'input_b', 'data-name' =>'cnt',  "min"=>"1", "max"=>"40", "readonly" ]) !!}

                                                            <span class="input-group-btn data-up">
                                                                <button  type="button" class="btn btn-default btn-info right_b" data-dir="up" style="width: 30px;     height: 30px;">
                                                                    <span style="width: 2px;" class="glyphicon glyphicon-plus"></span>
                                                                </button>
                                                            </span>
                                                            </div>
                                                        </div>

                                                        <div class="">
                                                            <p>{{--В наличии: 40 шт.--}}</p>

                                                        </div>
                                                        {{-----------------------------------------------------------------------------------}}

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%" class="right option_table">
                                                       Цена за еденицу товара:
                                                    </td>
                                                    <td width="60%" class="left">
                                                        <div class="product_price_cart yelloy">
                                                            <span class="product_price_one">
                                                                {{$val['product_price']}}</span>
                                                            <span>руб.</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="40%" class="right option_table">

                                                            Общяя стомость:

                                                    </td>
                                                    <td width="60%" class="left">
                                                        <div class="product_price_cart yelloy_big">
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

                                <div>
                                        @if(count($value['company']->getDiscountAccumulativ) > 0)
                                            <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p discount_zone" style="background-color: white;">
                                                <tr style="background-color: #f7f7f9; outline: 1px solid #dedee4;">
                                                    <td width="50%" valign="top">
                                                        <span class="option_table" style="margin: 10px;">Cкидки магазина:</span>
                                                        <p style="font-size: 13px; margin: 10px">Это накопительная скидка, которую предоставляет магазин.
                                                            Эта скидка действует при заказе на сумму, которая соответствует диапазону соответствующей процентной скидки.
                                                            После оформления заказа и подтверждени продавцом о его получении покупателем - эта скидка закрепляется за Вами до тех пор,
                                                            пока Вы не повысите сумму накоплений в этом магазине до следующей болие высокой скидки. </p>
                                                    </td>
                                                    <td>
                                                        <table class="my_table discount_table" border="2" align="center" bordercolor="#ddd">
                                                            <tr>
                                                                <th>При заказе на сумму от:</th>
                                                                <th>Скидка</th>
                                                            </tr>
                                                            @foreach($value['company']->getDiscountAccumulativ as $val)
                                                                <tr data-from="{{$val['from']}}" data-percent="{{$val->percent}}" class=" <?=($value['discount']['id'] == $val->id)? 'current_discount':'' ?>" ><td><span style="color: #2a62bc;">{{$val->from}} руб.</span></td><td><span style="color: indianred;">{{$val->percent}} %</span></td></tr>
                                                            @endforeach

                                                        </table>
                                                    </td>
                                                </tr>
                                            </div>
                                        @endif

                                        <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p amount_zone" style="background-color: white; padding-bottom: 20px;">

                                            <h3 class="total_history_amount">
                                               <div class="a col-sm-9">Сумма по завершенным заказам в этом магазине :</div>
                                                <div class="b col-sm-3"> <b><span class="total_history_amount">{{$value['totalHistoryAmount']}}</span></b> руб.</div>
                                                <input type="hidden" class="total_history_amount" value="{{$value['totalHistoryAmount']}}"/>
                                            </h3>

                                            <h3  class="total_amount">
                                                <div class="a col-sm-9"> Текущая покупка на сумму :</div>
                                                <div class="b col-sm-3">  <b><span class="total_amount">{{$value['totalAmount']}}</span></b> руб.</div>
                                                <input type="hidden" class="total_amount" value="{{$value['totalAmount']}}"/>
                                            </h3>

                                            <h3  class="total">
                                                <div class="a col-sm-9">Ощая сумма для учёта скидки :</div>
                                                <div class="b col-sm-3"> <b><span class="total">{{$value['total']}}</span></b> руб.</div>
                                                <input type="hidden" class="total" value="{{$value['total']}}"/>
                                            </h3>

                                            @if($value['discount'])
                                                <h3>Ваша скидка :  <b><span class="percent">{{$value['discount']['percent']}}</span> %</b></h3>
                                            @endif
                                        </div>
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


@endsection
