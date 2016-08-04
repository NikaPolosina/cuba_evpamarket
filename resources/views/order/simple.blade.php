@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')


    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="    border: 3px solid #eee;">
            <div class="col-sm-10 col-sm-offset-1">
                <h1 style="text-align: center">Заказ состоит из:</h1>
            </div>

            <div class="company_block_cart">

                    <div class="col-sm-10 col-sm-offset-1">
                        @foreach($order->products as $val)
                            <div class="row product_item_p">

                                <div class="col-sm-3">
                                    <div class="class_img">

                                        <img class="img-thumbnail" src="{{$val->firstFile}}" alt=""/>

                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <table class="table_product" border="1" bordercolor="#cecdc9"  width="100%">
                                        <tr>
                                            <td><span class="option_table_order">Товар:</span></td>
                                            <td  valign="top"><span class="name">{{$val->product_name}}</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="option_table_order">Краткое описание:</span></td>
                                            <td valign="top"><span class="product_description"> {{$val->product_description}}</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="option_table_order">Колличество:</span></td>
                                            <td>
                                                <span>{{$val->cnt}}</span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td valign="top">
                                                {!! Form::label('price', 'Цена: ', ['class' => 'control-label option_table_order']) !!}
                                            </td>
                                            <td valign="top">
                                                <div class="form-control product_price">
                                                    {{$val->product_price}} <span> руб.</span>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td valign="top">
                                                {!! Form::label('price_product', 'Вместе: ', ['class' => ' control-label option_table_order']) !!}
                                            </td>
                                            <td valign="top">
                                                <div class="form-control product_price">
                                                    {{$val->product_price*$val->cnt}}<span> руб.</span>
                                                </div>
                                            </td>

                                        </tr>


                                    </table>

                                </div>




                            </div>
                        @endforeach
                    </div>

                        <div class="col-sm-3 col-sm-offset-9">
                            <span style="font-weight: bold;">Общяя стоимость: </span>
                            <div class="form-control product_price">
                                {{$order->total_price}}<span> руб.</span>
                            </div>

                        </div>

            </div>

        </div>

    </div>
    <style>
        .class_img{
            line-height: 200px;
            text-align: center;
            width: 200px;
            height:200px;
            margin: auto;
        }
        .class_img img{
            vertical-align: middle;
            max-height:200px;

        }

        td, th {
            padding: 5px 10px 5px 10px!important;
        }
        td>p{
            font-size: 1em!important;
            font-family: Arial;
        }
        .product_price{
            text-align: center;
            width: 110px;
            background: #fff3b5;
            font-size: 16px;
        }

        .count_product{
            width: 70px;
            height: 20px;
            background: #ecebe6;
            text-align: center;
        }
        .option_table_order{

            font-weight: 600;
            font-size: 1em!important;
            font-family: Arial;
        }

        .button_my{
            float:right;
            box-shadow: 3px 3px 7px 0 rgba(105, 206, 95, .5), inset 0 -3px 0 0 #3a9731;
            background: -webkit-linear-gradient(top, #79d670, #4bbe3f);
        }
    </style>

@endsection