@extends('..admin.header_footer_layout')

@section('content')
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Статистика продаж магазина</span>
                    </div>

                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="col-md-4">
                                <div class="portlet sale-summary">
                                    <div class="portlet-title">
                                        <div class="caption font-red sbold"> Продано Товаров </div>
                                        {{--   <div class="tools">
                                               <a class="reload" href="javascript:;"> </a>
                                           </div>--}}
                                    </div>
                                    <div class="portlet-body">
                                        <ul class="list-unstyled">
                                            <li>
                            <span class="sale-info"> ЗA СЕГОДНЯ
                                <i class="fa fa-img-up"></i>
                            </span>
                                                <span class="sale-num"> {{$company->perDayAmount}} </span>
                                            </li>
                                            <li>
                            <span class="sale-info"> ЗА НЕДЕЛЮ
                                <i class="fa fa-img-down"></i>
                            </span>
                                                <span class="sale-num"> {{$company->perWeekAmount}}  </span>
                                            </li>
                                            <li>
                                                <span class="sale-info"> ВСЕГО </span>
                                                <span class="sale-num"> {{$company->totalAmount}} </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>


@endsection

