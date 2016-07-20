@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <h1 style="text-align: center">Оформление заказа</h1>
            </div>


            {{ Form::open(array('url' => '/order-ready',  'method' => 'post')) }}
              {{  Form::token()}}
            <div class="company_block_cart">
                <div class="col-md-4 col-md-offset-4 cart_name">
                    <h3>Магазин: ИМЯ МАГАЗИНА</h3>
                </div>
                <div class="col-md-8 col-md-offset-2 " style="outline: solid grey 1px;">
                    <div class="col-sm-10 col-sm-offset-1 product_item_cart product_item_p">
                   {{-- @foreach($value['products'] as $val)--}}
                        <div>
                            <div class="col-sm-3">
                                <div style="max-width: 100%;">
                                    <img class="img_product img-thumbnail" src="/img/placeholder/avatar.jpg" alt=""/>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <table class="table_product" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="35%"><span class="option_table">Товар:</span></td>
                                        <td width="65%" valign="top"><p class="name" style=" font-size: 20px;">ИМЯ ПРОДУКТА</p></td>
                                    </tr>
                                    <tr>
                                        <td width="35%"><span class="option_table">Краткое описание:</span></td>
                                        <td width="65%" valign="top"><p style="font-size: 20px;" class="product_description"> ОПИСАНИЕ</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%">
                                            {!! Form::label('cnt', 'Количество: ', ['class' => 'col-sm-3 control-label option_table']) !!}
                                        </td>
                                        <td width="65%" valign="top">

                                            {!! Form::text('cnt', 2, ['class' => 'form-control product_price yelloy_big', 'data-name' =>'cnt']) !!}

                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="50%" valign="top">
                                            {!! Form::label('price', 'Цена: ', ['class' => 'col-sm-3 control-label option_table']) !!}
                                        </td>
                                        <td width="50%" valign="top">
                                            {!! Form::text('price', 1500, ['class' => 'form-control product_price yelloy', 'data-name' =>'price']) !!}
                                        </td>

                                    </tr>


                                </table>

                                <hr/>
                                <div class="buttom_menu">
                                    <input style="display: none" value="ID" type="text"/>

                                </div>
                            </div>
                        </div>

                   {{-- @endforeach--}}
                    <div class="col-sm-6 col-sm-offset-3">

                        <table class="table_product" border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="50%" valign="top">
                                {!! Form::label('total_price', 'Общяя стомость: ', ['class' => 'col-sm-3 control-label option_table']) !!}
                                </td>
                                <td width="50%" valign="top">
                                {!! Form::text('total_price', 3000, ['class' => 'form-control product_price yelloy_big', 'data-name' =>'total_price']) !!}
                               </td>

                            </tr>
                        </table>
                    </div>

                        <div class="col-sm-12">
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
                                    {!! Form::label('street', 'Улица ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                    {!! Form::text('street', $info_user->street, ['class' => 'form-control', 'data-name' =>'street']) !!}
                                    </div>

                                </div>
                                <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                    {!! Form::label('address', 'Дом ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                    {!! Form::text('address', $info_user->address, ['class' => 'form-control', 'data-name' =>'address']) !!}
                                        </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-5" style="margin-bottom: 3px">
                                {!! Form::hidden('user_id', $user->id, ['class' => 'form-control', 'data-name' =>'user_id']) !!}

                            </div>


                        </div>
                            <hr>

                        {!! Form::submit('Заказать', ['class' => 'btn btn-success btn-lg button_my']) !!}
                    </div>

                </div>
            </div>

            {{ Form::close() }}




        </div>
    <style>

        .button_my{
            float:right;
            box-shadow: 3px 3px 7px 0 rgba(105, 206, 95, .5), inset 0 -3px 0 0 #3a9731;
            background: -webkit-linear-gradient(top, #79d670, #4bbe3f);
        }
    </style>

@endsection