@extends('...layouts.app')

@section('content')

    @include('layouts.header_menu')
    <link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />




    <div class="row">
        <div class="col-md-10 col-sm-offset-1">
        @include('layouts.breadcrumbs')
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase" style="color: darkblue"> Список Заказов</span>
                    </div>


                </div>
                <div class="portlet-body">
                    <div class="tabbable-line tabbable-full-width">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1_1" data-toggle="tab"> Все заказы </a>
                            </li>
                            <li style="">
                                <a href="#tab_1_2" data-toggle="tab"> Завершонные </a>
                            </li>
                            <li style="">
                                <a href="#tab_1_3" data-toggle="tab"> Активные </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_1">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Продавец </th>
                                        <th> Контактная информация </th>
                                        <th> Адресс доставки </th>
                                        <th> Сумма заказа </th>
                                        <th> Скидка</th>
                                        <th> Сумма co скидкой</th>
                                        <th> Статус </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- */$x=0;/* --}}
                                    @foreach($order as $item)
                                        {{-- */$x++;/* --}}
                                        <tr class="odd gradeX">
                                            <td> {{ $x }} </td>
                                            <td><a href="/show-simple-order/{{$item->id}}"> {{$item->getCompany[0]['company_name']}}</a></td>
                                            <td>{{$item->getCompany[0]['company_contact_info']}}</td>

                                            <td> Регион: {{$item->region}}, г. {{$item->city}}, {{$item->street}} {{$item->address}} </td>
                                            <td> {{$item->total_price}} <span> руб.</span>
                                            </td>  <td> {{$item->percent}} <span> %</span> </td>
                                            <td> {{$item->total_price}} <span> руб.</span>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> {{$item->getStatusOwner->getStatusSiple->title}}</button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--tab_1_2-->
                            <div class="tab-pane" id="tab_1_2">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Продавец </th>
                                        <th> Контактная информация </th>
                                        <th> Адресс доставки </th>
                                        <th> Сумма заказа </th>
                                        <th> Скидка</th>
                                        <th> Сумма co скидкой</th>
                                        <th> Статус </th>
                                        <th> Отзыв </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- */$x=0;/* --}}
                                    @foreach($finishOrder as $item)
                                        {{-- */$x++;/* --}}
                                        <tr class="odd gradeX">
                                            <td> {{ $x }} </td>
                                            <td><a href="/show-simple-order/{{$item->id}}"> {{$item->getCompany[0]['company_name']}}</a></td>
                                            <td>{{$item->getCompany[0]['company_contact_info']}}</td>

                                            <td> Регион: {{$item->region}}, г. {{$item->city}}, {{$item->street}} {{$item->address}} </td>
                                            <td> {{$item->total_price}} <span> руб.</span>
                                            </td>  <td> {{$item->percent}} <span> %</span> </td>
                                            <td> {{$item->total_price}} <span> руб.</span>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> {{$item->getStatusOwner->getStatusSiple->title}}</button>
                                                </div>
                                            </td>
                                            <td>

                                                    <div class="btn-group">

                                                        @if(count($item->getFeedback))
                                                            <a href="#">
                                                                <button class="btn btn-xs default dropdown-toggle" type="button" aria-expanded="false">Просмотреть отзыв</button>
                                                            </a>
                                                        @else

                                                        <a href="/feedback-view/{{$item->id}}">
                                                        <button class="btn btn-xs red dropdown-toggle" type="button" aria-expanded="false">Оставить отзыв</button>
                                                        </a>
                                                        @endif

                                                    </div>

                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="tab_1_3">
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th> # </th>
                                        <th> Продавец </th>
                                        <th> Контактная информация </th>
                                        <th> Адресс доставки </th>
                                        <th> Сумма заказа </th>
                                        <th> Скидка</th>
                                        <th> Сумма co скидкой</th>
                                        <th> Статус </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- */$x=0;/* --}}
                                    @foreach($activeOrder as $item)
                                        {{-- */$x++;/* --}}
                                        <tr class="odd gradeX">
                                            <td> {{ $x }} </td>
                                            <td><a href="/show-simple-order/{{$item->id}}"> {{$item->getCompany[0]['company_name']}}</a></td>
                                            <td>{{$item->getCompany[0]['company_contact_info']}}</td>

                                            <td> Регион: {{$item->region}}, г. {{$item->city}}, {{$item->street}} {{$item->address}} </td>
                                            <td> {{$item->total_price}} <span> руб.</span>
                                            </td>  <td> {{$item->percent}} <span> %</span> </td>
                                            <td> {{$item->total_price}} <span> руб.</span>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> {{$item->getStatusOwner->getStatusSiple->title}}</button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--end tab-pane-->
                    </div>



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
