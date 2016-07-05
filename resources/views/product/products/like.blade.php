@extends('layouts.app')
@section('content')

    @include('layouts.header_menu')

    <div class="row">

        @if(!$product == '' )
            @foreach($product as $val)
                <div class="col-sm-9 col-sm-offset-1 product_item_cart">

                    <div class="col-sm-3">
                        <div style="max-width: 100%;">
                            <img class="img_product img-thumbnail" src="{{$val['firstFile']}}" alt=""/>
                        </div>
                    </div>

                    <div class="col-sm-9">
                        <table class="table_product" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="35%"><span class="option_table">Товар:</span></td>
                                <td width="65%" valign="top"><p class="name" style=" font-size: 20px;">{{$val['product_name']}}</p></td>
                            </tr>
                            <tr>
                                <td width="35%"><span class="option_table">Краткое описание:</span></td>
                                <td width="65%" valign="top"><p style="font-size: 20px;" class="product_description"> {{$val['product_description']}}</p>
                                </td>
                            </tr>
                            <tr>
                                <td width="35%"><span class="option_table">В наличии: </span></td>
                                <td width="65%" valign="top"><p style="font-size: 20px;" class=""> 40шт</p>

                            </tr>
                            <tr>
                                <td width="35%" valign="top"><span class="option_table">Цена:</span></td>
                                <td width="65%" valign="top"><div class="product_price yelloy"><span class="product_price_one" style=""> {{$val['product_price']}}</span> <span>руб.</span></div></td>
                            </tr>

                        </table>
                        <hr/>
                        <div class="buttom_menu">
                            <input style="display: none" value="{{$val['id']}}" type="text"/>
                            <button type="button" class="btn btn-default button_delete">Удалить из избранного</button>
                            <button type="button" class="btn btn-warning">Добавить твар в корзину</button>
                        </div>
                    </div>

                </div>
            @endforeach
            <div class="col-sm-9 col-sm-offset-1 product_item_cart cart_empty" style="display: none">
                <h1>В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</h1>
            </div>
        @else
            <div class="col-sm-9 col-sm-offset-1 product_item_cart cart_empty">
                <h1>В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</h1>
            </div>
        @endif
    </div>

@endsection
