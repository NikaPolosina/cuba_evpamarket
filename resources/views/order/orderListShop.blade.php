@extends('...layouts.app')

@section('content')

    @include('layouts.header_menu')
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

    <div class="row">
        <div class="col-sm-12">
            <div class="portlet-title">
                <div class="caption font-dark" style=" text-align: center">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase" style="color: darkblue;"> Список Заказов</span>
                </div>

            </div>
        </div>
        <div class="col-md-2">
            <div class="list-group-item list-group-item-info" style="text-align: center">Статусы</div>
            <a class="list-group-item" href="/order-by-status/{{$company->id}}/0"><div>Все заказы</div></a>
        @foreach($myStatus as $val)
                <a class="list-group-item" href="/order-by-status/{{$company->id}}/{{$val->getStatusOwner->id}}"><div>{{$val->getStatusOwner->title}}</div></a>
                @endforeach

        </div>
        <div class="col-md-10">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">

                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> Покупатель </th>
                            <th> Номер телефона </th>
                            <th> Адресс доставки </th>
                            <th> Сумма заказа </th>
                            <th> Сумма заказа с учётом скидки </th>
                            <th> Скидка в процентах </th>
                            <th> Статус </th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- */$x=0;/* --}}


                        @foreach($order as $item)

                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <td> {{ $x }} </td>
                                <td><a href="/show-simple-order/{{$item->id}}"> {{$item->name}} {{$item->surname}}</a></td>
                                <td> {{$item->order_phone}}</td>

                                <td> Регион: {{$item->region}}, г. {{$item->city}}, {{$item->street}} {{$item->address}} </td>
                                <td style="text-align: center"> {{$item->total_price}} <span> руб.</span> </td>
                                <td style="color: red; text-align: center"> {{$item->discount_price}} <span> руб.</span> </td>
                                <td style="color: red; text-align: center"> {{$item->percent}} <span> %</span> </td>

                                <td>




                                    <div class="btn-group">
                                        <button class="btn btn-xs dropdown-toggle
                                        @if($item->getStatusOwner->key == 'not_processed')a
                                        @elseif($item->getStatusOwner->key == 'details')v
                                        @elseif($item->getStatusOwner->key == 'call')b
                                        @elseif($item->getStatusOwner->key == 'refusal_payment')c
                                         @elseif($item->getStatusOwner->key == 'verification')y
                                         @elseif($item->getStatusOwner->key == 'delivery_warehouse')bl
                                         @elseif($item->getStatusOwner->key == 'no_answer')p
                                         @elseif($item->getStatusOwner->key == 'available')e
                                         @elseif($item->getStatusOwner->key == 'waiting_payment')k
                                         @elseif($item->getStatusOwner->key == 'waiting_confirmation_payment')h
                                         @elseif($item->getStatusOwner->key == 'payment_successful')s
                                         @elseif($item->getStatusOwner->key == 'formation_order')u
                                         @elseif($item->getStatusOwner->key == 'packaging')w
                                         @elseif($item->getStatusOwner->key == 'send_intermediate_storage')n
                                         @elseif($item->getStatusOwner->key == 'sending_buyer')q
                                          @endif" type="button" data-toggle="dropdown" aria-expanded="false"> {{$item->getStatusOwner->title}}
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @foreach($status as $st)
                                                <li>
                                                    <a href="{{route('change_order_status', [$item->id, $st->id])}}">
                                                        <i class="icon-docs"></i>{{ $st->title}} </a>
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <style>
        .row {
            margin-right: 0px;
            margin-left: 0px;
        }
        .badge{
            background-color: red
        }
        .a{
            background-color: green;
        }
        .b{
            background-color: #0b94ea;
        }
        .c{
            background-color: red;
        }
        .v{
            background-color: gold;
        }
        .y{
            background-color: yellow;
        }
        .bl{
            background-color: #00c4ff;
        }
        .p{
            background-color: orange;
        }
        .e{
            background-color: #2ae0bb;
        }
        .k{
            background-color: #4d9200;
        }
        .h{
            background-color: burlywood;
        }
        .s{
            background-color: deeppink;
        }
        .u{
            background-color: mediumpurple;
        }
        .w{
            background-color: salmon;
        }
        .n{
            background-color: lightpink;
        }
        .q{
            background-color: lawngreen;
        }

    </style>

@endsection
