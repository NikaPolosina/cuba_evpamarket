@extends('...layouts.app')

@section('content')

    @include('layouts.header_menu')
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />

    <div class="row">
        <div class="col-md-10 col-sm-offset-1">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase" style="color: darkblue"> Список Заказов</span>
                    </div>

                </div>
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
                                <td> {{$item->total_price}} <span> руб.</span> </td>
                                <td style="color: red;"> {{$item->discount_price}} <span> руб.</span> </td>
                                <td style="color: red;"> {{$item->percent}} <span> %</span> </td>

                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> {{$item->getStatusOwner->title}}
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
        .badge{
            background-color: red
        }

    </style>

@endsection
