@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    @include('layouts.breadcrumbs')


    <link rel="stylesheet" type="text/css" href="../css/show_cart_like.css"/>
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="    border: 3px solid #eee;">
            <div class="col-sm-10 col-sm-offset-1">
                <h1 style="text-align: center">Заказ состоит из:</h1>
            </div>

            <div class="company_block_cart">

                    <div class="col-sm-10 col-sm-offset-1">

                        @if($order->products)

                            @foreach($order->products as $val)
                                <div class="row product_item_p">

                                    <div class="col-sm-3">
                                        <div class="class_img">
                                            @if(empty($val->product_image) && is_dir(public_path().'/img/custom/companies/'.$val->getCompany[0]->id.'/products/'.$val->id))
                                                <?php
                                                $files = scandir(public_path().'/img/custom/companies/'.$val->getCompany[0]->id.'/products/'.$val->id);
                                                ?>
                                                <img class="img-thumbnail" src="/img/custom/companies/{{$val->getCompany[0]->id}}/products/{{$val->id}}/{{$files[2]}}" alt=""/>
                                            @elseif(!empty($val->product_image) && file_exists(public_path().'/img/custom/companies/'.$val->getCompany[0]->id.'/products/'.$val->id.'/'.$val->product_image))
                                                <img class="img-thumbnail" src="/img/custom/companies/{{$val->getCompany[0]->id}}/products/{{$val->id}}/{{$val->product_image}}" alt=""/>
                                                @else
                                                <img class="img-thumbnail" src="/img/system/plase.jpg" alt=""/>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <table class="table_product" border="1" bordercolor="#cecdc9"  width="100%">
                                            <tr>
                                                <td width="30%" style="text-align: right"><span class="option_table_order">Товар:</span></td>
                                                <td align="center" valign="top"><span class="name">{{$val->product_name}}</span></td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="text-align: right"><span class="option_table_order">Краткое описание:</span></td>
                                                <td align="center" valign="top"><span class="product_description"> {{$val->product_description}}</span></td>
                                            </tr>
                                            <tr>
                                                <td width="30%" style="text-align: right"><span class="option_table_order">Колличество:</span></td>
                                                <td align="center"  align="center">
                                                    <span>{{$val->cnt}}</span>
                                                </td>
                                            </tr>

                                            @if(count($val->add_param))

                                                <tr>
                                                    <td width="30%" style="text-align: right"><span class="option_table_order">Дополнительные данные:</span></td>
                                                    <td align="center"  align="center">


                                                        @foreach($val->add_param as $param)
                                                            <div>
                                                                <span>{{$param['title']}}:</span>
                                                                @if(is_array($param['add_param']))
                                                                    @foreach($param['add_param'] as $cnt => $valName)
                                                                        {{$valName['name']}}
                                                                        <div style="font-weight: bold">
                                                                            @if(array_key_exists('css', $valName))
                                                                                @if(array_key_exists($cnt, $param['param_value']['css']))
                                                                                    <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; margin-left: 15px;  background-color: {{$param['param_value']['css'][$cnt]}}"></div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    {{$param['param_value']['name']}}
                                                                @endif

                                                            </div>

                                                     {{--       <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: red"></div>--}}

                                                            <hr />
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td valign="top" width="30%" style="text-align: right">
                                                    {!! Form::label('price', 'Цена: ', ['class' => 'control-label option_table_order']) !!}
                                                </td>
                                                <td valign="top" align="center">
                                                    <div class="form-control product_price">
                                                        {{$val->product_price}} <span> руб.</span>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td valign="top" width="30%" style="text-align: right">
                                                    {!! Form::label('price_product', 'Вместе: ', ['class' => ' control-label option_table_order']) !!}
                                                </td>
                                                <td valign="top" align="center">
                                                    <div class="form-control product_price">
                                                        {{$val->product_price*$val->cnt}}<span> руб.</span>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td width="30%" style="text-align: right"><span class="option_table_order">Примечание к заказу:</span></td>
                                                <td align="center" valign="top"><span class="product_description"> {{$order->note}}</span></td>
                                            </tr>

                                        </table>

                                    </div>

                                </div>
                            @endforeach

                        @else
                            <h3>Заказ был выполнен в ручном режиме. </h3>
                        @endif

                    </div>

                        <div class="col-sm-3 col-sm-offset-9" style="margin-bottom: 20px;">
                            <span style="font-weight: bold;">Общяя стоимость: </span>
                            <div class="form-control product_price">
                                {{$order->total_price}}<span> руб.</span>
                            </div>
                        </div>
                        <div class="col-sm-3 col-sm-offset-9" style="margin-bottom: 20px;">
                            <span style="font-weight: bold;">Общяя стоимость cо скидкой: </span>
                            <div class="form-control product_price">
                                {{$order->discount_price}}<span> руб.</span>
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