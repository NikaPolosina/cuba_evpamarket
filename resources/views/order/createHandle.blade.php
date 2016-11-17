@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    @include('layouts.breadcrumbs')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1" style="border: 3px solid #eee; padding: 10px;">
            <div class="col-sm-10 col-sm-offset-1">
                <h1 style="text-align: center">Оформление заказа  в ручную</h1>
            </div>
            {{ Form::open(array('url' => '/order-ready-handle',  'method' => 'post')) }}
            {!! Form::hidden('company_id', $seller->getCompanies[0]['id'], ['class' => 'form-control', 'data-name' =>'company_id']) !!}

            {{  Form::token()}}
            <div class="company_block_cart">
                <div class="col-md-4 col-md-offset-4 cart_name">
                    <h3 style="text-align: center">Заказ по магазину: <span style="color: darkblue;">{{$seller->getCompanies[0]['company_name']}}</span> </h3>
                </div>
                <div class="col-md-8">
                    <div class="product_item_cart product_item_p">
                        <div class="col-sm-12">

                            <div class="form-group col-sm-12" style="margin-bottom: 10px">
                                {!! Form::label('total_price', 'Покупка на сумму: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::number('total_price', '', ['class' => 'form-control total_amount', 'data-name' =>'total_price', 'min' => '1', 'placeholder' => 'Введите сумму на которую была произведена покупка....']) !!}
                                </div>
                            </div>

                            <div class="form-group col-sm-12" style="margin-bottom: 10px">
                                {!! Form::label('note', 'Примечание к заказу: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::textarea('note', '', ['class' => 'form-control', 'data-name' =>'note', 'rows' => '3    ']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                    {!! Form::label('name', 'Имя: ', ['class' => 'control-label col-sm-3']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('name', $user->getUserInformation->name, ['class' => 'form-control', 'data-name' =>'name']) !!}
                                    </div>
                                </div>
                                <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                    {!! Form::label('surname', 'Фамилия: ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('surname', $user->getUserInformation->surname, ['class' => 'form-control', 'data-name' =>'surname']) !!}
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
                                        {!! Form::text('street', $user->getUserInformation->street, ['class' => 'form-control', 'data-name' =>'street']) !!}
                                    </div>
                                </div>

                                <div class="form-group col-sm-12" style="margin-bottom: 3px">
                                    {!! Form::label('address', 'Дом: ', ['class' => 'col-sm-3 control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('address', $user->getUserInformation->address, ['class' => 'form-control', 'data-name' =>'address']) !!}
                                    </div>
                                </div>

                            </div>
                            <div class="form-group col-sm-5" style="margin-bottom: 3px">
                                {!! Form::hidden('user_id', $user->id, ['class' => 'form-control', 'data-name' =>'user_id']) !!}
                            </div>
                        </div>
                        {!! Form::submit('Оформить', ['class' => 'btn btn-success btn-lg button_my']) !!}
                    </div>

                </div>

                <div class="col-sm-4" style="border: solid 1px #eeeeee;">
                    <h4>Информация по заказам в магазие -  <span style="color: darkblue;"> {{$seller->getCompanies[0]['company_name']}}</span>, покупателем -  <span style="color: darkblue;"> {{$user->getUserInformation->name}} {{$user->getUserInformation->surname}} </span></h4>
                        <div class="block_info_order" style="text-align: center; padding: 10px;">
                            @if(!$money)
                                ПОКУПОК НЕТ
                                @else
                                <div class=" product_price">
                                    <input class="total_history_amount" type="hidden" value="{{$money->money}}"/>
                                    <h4>
                                        Сумма завершенных заказов </br>по данному магазину составляет -  <span style="color: darkblue;">  <span class="">{{$money->money}} </span> руб.</span>
                                    </h4>

                                    <h4>
                                        Общяя сумма заказов составляет -  <span style="color: darkblue;">  <span class="total">{{$money->money}} </span> руб.</span>
                                    </h4>

                                    <h4 style="font-weight: bold">
                                        Сумма к оплате -  <span style="color: darkblue;">  <span class="sum_for_pay">0 </span> руб.</span>
                                    </h4>
                                    <h4>
                                        Текущая покупка на сумму -  <span style="color: darkblue;">  <span class="curent_sum">{{$money->money}} </span> руб.</span>
                                    </h4>
                                    <h4>
                                        Текущая скидка составляет - <span style="color: darkblue;">  <span class="current_percent">0 </span> %</span>

                                    </h4>

                                    <table class="my_table discount_table" border="2" align="center" bordercolor="#ddd">
                                        <tr>
                                            <th>При заказе на сумму от:</th>
                                            <th>Скидка</th>
                                        </tr>
                                        @foreach($seller->getCompanies[0]->getDiscountAccumulativ as $val)

                                            <tr data-from="{{$val['from']}}" data-percent="{{$val->percent}}" >
                                                <td><span style="color: #2a62bc;">{{$val->from}} руб.</span></td>
                                                <td><span style="color: indianred;">{{$val->percent}} %</span></td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>


    <script>

        $(document).ready(function () {
            $('input.total_amount').on('keyup', function () {
                calculateAmount();
            });
        });

        function calculateAmount(){
            var mainParent                 = $('.company_block_cart').eq(0);//Находим родителя
            var input_total_history_amount = mainParent.find('input.total_history_amount').val();//сумма в рублях по завершонным заказам покупателя.
            var input_total_amount          = mainParent.find('input.total_amount').val();//сумма текущей покупки в ручном режиме которую вводит продавец.
            if(!input_total_amount.length){
                input_total_amount = 0;
            }// При загрузке страницы ставим сумму текущей покупки 0 рублей.
            var span_total                 = mainParent.find('span.total');
            var span_curent_sum                 = mainParent.find('span.curent_sum');
            var span_curent_percent                = mainParent.find('span.current_percent');
            var span_sum_for_pay                = mainParent.find('span.sum_for_pay');
            var showTotal                  = parseInt(input_total_history_amount);
            var current                    = parseInt(input_total_amount);

            showTotal         = showTotal + current;
            var discountTable = mainParent.find('.discount_table');

            if(discountTable.length){
                var tr = discountTable.find('tr[data-from]');
                tr.removeClass('current_discount');
                var percent = 0;
                tr.each(function(){
                    percent = ($(this).attr('data-from') <= showTotal ) ? $(this).attr('data-percent') : percent;
                });
                percent = parseInt(percent);
                discountTable.find('tr[data-percent="' + percent + '"]').addClass('current_discount');
            }
            span_curent_sum.html(input_total_amount);
            span_total.html(showTotal);
            span_sum_for_pay.html(input_total_amount -(input_total_amount*percent/100));
            span_curent_percent.html(percent);
        }
        calculateAmount();
    </script>

    <style>
        .table_mod{
            border-collapse: separate!important;
        }
        .table_mod td, .table_mod th{
            /*padding: 5px!important;
            margin: 5px!important;*/
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


        .current_discount{
            background: #a7eea7;
            font-weight: bold;
            color: black;
        }
    </style>

@endsection