@extends('admin.header_footer_layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> Список статусов по товарам</span>
                    </div>

                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    <span></span>
                                </label>
                            </th>
                            <th> # </th>
                            <th> Магазин </th>
                            <th> id </th>
                            <th> Имя товара</th>
                            <th> Описание </th>
                           {{-- <th> Статус - id </th>--}}
                            <th> Статус</th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>

                        {{-- */$x=0;/* --}}
                        @foreach($product as $item)
                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> {{ $x }} </td>
                                <td class="id"> {{$item->getCompany[0]->company_name}}</td>
                                <td class="id"> {{$item->id}}</td>
                                <td class="status_name"><a href="">{{$item->product_name}}</a></td>
                                <td class="status_name">{{$item->product_description}}</td>

                              {{--  <td class="center kay"> {{$item->status_product}} </td>--}}
                                <td class="center kay"> <span class="{{$item->getStatusProduct->status_key}} span_key">{{$item->getStatusProduct->status_name}}</span> </td>

                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Изменить статус
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            @foreach($status as $st)
                                                <li>
                                                    <a  class="addChange" href="/admin/status-product-change/{{$item->id}}/{{$st->status_key}}">
                                                       {{$st->status_name}} </a>
                                                </li>
                                                @endforeach
                                            <li class="divider"> </li>

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


    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <style>
        .span_key{
            padding: 2px 8px 2px 8px;;
        }
        span.active{
            background-color: #13c813;
        }
        span.delete{
            background-color: red;
        }
        span.progress{
            background-color: yellow;
        }
        span.blocked{
            background-color: #d5d5d5;
        }
        span.archive{
            background-color: cornflowerblue;
        }
    </style>

@endsection
