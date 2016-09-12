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
                        <span class="caption-subject bold uppercase" style="color: darkblue;"> Список Моих Магазинов</span>
                    </div>

                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                            <tr>
                                <th> № </th>
                                <th> Имя Магазина</th>
                                <th> Описание </th>
                                <th> Арес </th>
                                <th width="30"> Новые заказы </th>
                            </tr>
                        </thead>
                        <tbody>

                        {{-- */$x=0;/* --}}
                        @foreach($companys as $item)
                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <td> {{ $x }} </td>
                                <td>
                                    @if(count($item->getOrder) > 0)
                                        <a href="order-by-status/{{$item->id}}/1"> {{$item->company_name}}</a>
                                    @else
                                        <a href="/show-order/{{$item->id}}"> {{$item->company_name}}</a>

                                    @endif


                                </td>
                                <td> {{$item->company_description}} </td>
                                <td> {{$item->street}} {{$item->address}}</td>
                                <td align="center">

                                    @if(count($item->getOrder) > 0)
                                        <a href="order-by-status/{{$item->id}}/1"> <span class="badge">@if(count($item->getOrder) > 0){{count($item->getOrder)}}@endif</span></a>
                                    @else
                                        <a href="/show-order/{{$item->id}}"><span class="badge">@if(count($item->getOrder) > 0){{count($item->getOrder)}}@endif</span></a>

                                    @endif






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
            background-color: red;
            text-align: center;

        }

    </style>

@endsection
