@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            <h1>ВСЕ ЧТО В ЗАКАЗЕ</h1>
            <div class="company_block_cart">

                        @foreach($order->products as $val)

                            <div class="row">
                                <div class="col-sm-3">
                                    <div style="max-width: 100%;">
                                        <img class="img_product img-thumbnail" src="/img/users/7/avatar.png" alt=""/>
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
                                            <td valign="top"><span class="product_description">
                                                    {{$val->product_description}}</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {!! Form::label('product['.$val->id.'][cnt]', 'Количество: ', ['class' => 'control-label option_table_order']) !!}
                                            </td>
                                            <td  valign="top">

                                                {!! Form::text('product['.$val->id.'][cnt]', $val->cnt, ['class' => 'form-control count_product', 'data-name' =>'cnt', 'readonly']) !!}

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
            </div>
        </div>
    </div>



@endsection