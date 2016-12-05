@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1" style="    border: 3px solid #eee;">
                @include('layouts.breadcrumbs')

                <div class="col-sm-10 col-sm-offset-1">

                    <div style="text-align: center; font-size: 24px;">Оформление заказа</div>
                </div>


                {{ Form::open(array('url' => '/order-ready',  'method' => 'post')) }}
                {!! Form::hidden('company_id', $company->id, ['class' => 'form-control', 'data-name' =>'company_id']) !!}

                {{  Form::token()}}
                <div class="company_block_cart">
                    <div class="col-md-4 col-md-offset-4 cart_name">
                        <div style="text-align: center; font-size: 22px;">Магазин: <span style="color: darkblue;">{{$company->company_name}}</span> </div>

                    </div>
                    <div class="col-md-8 col-md-offset-2 ">
                        <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p">


                        @foreach($products as $val)

                                <div class="ara" style="margin-bottom: 5px!important;">
                                <div class="col-sm-3">
                                    <div style="max-width: 100%;">
                                        <img class="img_product img-thumbnail" src="{{$val->firstFile}}" alt=""/>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <table class="table_product" border="1" bordercolor="#cecdc9"  width="100%">
                                        <tr>
                                            <td  width="40%" class="right"><span class="option_table_order">Товар:</span></td>
                                            <td  width="60%" class="left"><span class="name">{{$val->product_name}}</span></td>
                                        </tr>
                                        <tr>
                                            <td width="40%" class="right"><span class="option_table_order">Краткое описание:</span></td>
                                            <td  width="60%" class="left"><span class="product_description"> {{$val->product_description}}</span></td>
                                        </tr>
                                        <tr>
                                            <td  width="40%" class="right">
                                                {!! Form::label('product['.$val->id.'][cnt]', 'Количество: ', ['class' => 'control-label option_table_order']) !!}
                                            </td>
                                            <td  width="60%" class="left">

{!! Form::text('product['.$val->hash.'][cnt]', $val->cnt, ['class' => 'form-control count_product', 'data-name' =>'cnt', 'readonly']) !!}

                                            </td>
                                        </tr>
                                                {{--Выводим дополнительные параметры указанные по этому товару--}}
                                        @if(count($val['value']))
                                            <tr>
                                                <td  width="40%" class="right">
                                                    <div class="control-label option_table_order">Дополнительные параметры</div>
                                                </td>
                                                <td  width="60%" class="left">
                                                    <table>
                                                        @include('product.cartAddParamShow', ['add_param'=>$val->value])
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr>
                                            <td  width="40%" class="right">
                                                {!! Form::label('price', 'Цена: ', ['class' => 'control-label option_table_order']) !!}
                                            </td>
                                            <td  width="60%" class="left">
                                                <div class="form-control product_price">
                                                    {{$val->product_price}} <span> руб.</span>
                                                </div>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td  width="40%" class="right">
                                                {!! Form::label('price_product', 'Вместе: ', ['class' => ' control-label option_table_order']) !!}
                                            </td>
                                            <td  width="60%" class="left">
                                                <div class="form-control product_price">
                                                    {{$val->product_price*$val->cnt}}<span> руб.</span>
                                                </div>
                                            </td>

                                        </tr>


                                    </table>

                                </div>
                            </div>

                        @endforeach

                        <div class="col-sm-6 col-sm-offset-3">
                            <table class="table_product" border="0"  width="100%">
                                <tr>
                                    <td width="50%" class="right">
                                    {!! Form::label('total_price', 'Общяя стомость: ', ['class' => 'control-label option_table_order']) !!}
                                    </td>
                                    <td width="50%" class="left">
                                        <div class="form-control product_price">
                                            {{$total_price}}<span> руб.</span>
                                        </div>
                                   </td>
                                </tr>

                                @if($total_discount > 0)
                                    <tr>
                                        <td width="50%" class="right">
                                        {!! Form::label('total_discount', 'Cкидка: ', ['class' => 'control-label option_table_order_вшысщгте']) !!}
                                        </td>
                                        <td width="50%" class="left">
                                            <div class="form-control product_price" style="background-color: #fdd0af; color: red;">
                                                {{$percent}}<span> %</span>
                                            </div>
                                       </td>
                                    </tr>
                                    <tr>
                                        <td width="50%" class="right">
                                        {!! Form::label('total_price_discount', 'Цена со скидкой: ', ['class' => 'control-label option_table_order_вшысщгте']) !!}
                                        </td>
                                        <td width="50%" class="left">
                                            <div class="form-control product_price" style="background-color: #fdd0af; color: red;">
                                                {{$total_price-$total_discount}}<span> руб.</span>
                                            </div>
                                       </td>
                                    </tr>
                                @endif
                            </table>


                        </div>
                            <div class="col-sm-12" style="border-top: solid 2px #eee; padding-top: 5px;">

                                <div class="col-sm-6">


                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('name', 'Имя: ', ['class' => 'control-label col-sm-3']) !!}
                                            <div class="col-sm-9">
                                                {!! Form::text('name', $info_user->name, ['class' => 'form-control', 'data-name' =>'name']) !!}
                                            </div>
                                        </div>
                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('surname', 'Фамилия: ', ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-9">
                                            {!! Form::text('surname', $info_user->surname, ['class' => 'form-control', 'data-name' =>'surname']) !!}
                                        </div>
                                    </div>

                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('phone', 'Номер телефона: ', ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-9">
                                            {!! Form::text('phone', $user->phone, ['class' => 'form-control', 'data-name' =>'phone']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('region_id', 'Регион: ', ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-9">
                                        {!! Form::text('region_id', $region->title, ['class' => 'form-control', 'data-name' =>'region_id']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('city_id', 'Город: ', ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-9">
                                        {!! Form::text('city_id', $city->title_cities, ['class' => 'form-control', 'data-name' =>'city_id']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('street', 'Улица: ', ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-9">
                                        {!! Form::text('street', $info_user->street, ['class' => 'form-control', 'data-name' =>'street']) !!}
                                        </div>


                                    </div>

                                    <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                        {!! Form::label('address', 'Дом: ', ['class' => 'col-sm-3 control-label']) !!}
                                        <div class="col-sm-9">
                                        {!! Form::text('address', $info_user->address, ['class' => 'form-control', 'data-name' =>'address']) !!}
                                            </div>
                                    </div>


                                </div>
                                {{--------------------------------------------------------------------}}
                                <div class="form-group col-sm-12" style="margin-bottom: 3px; padding-left: 30px;padding-right: 30px;">
                                    {!! Form::label('note', 'Примечание к заказу: ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::textarea('note', '', ['class' => 'form-control', 'data-name' =>'note', 'rows' => '3    ']) !!}
                                    </div>
                                </div>
                                {{-----------------------------------------------------------------------}}

                                <div class="form-group col-sm-5" style="margin-bottom: 3px">
                                    {!! Form::hidden('user_id', $user->id, ['class' => 'form-control', 'data-name' =>'user_id']) !!}

                                </div>


                            </div>


                            {!! Form::submit('Заказать', ['class' => 'btn btn-success btn-lg button_my']) !!}
                        </div>

                    </div>
                </div>

                {{ Form::close() }}


            </div>

        </div>
    <style>

        td, th {
            padding: 0px 10px 0px 10px!important;
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