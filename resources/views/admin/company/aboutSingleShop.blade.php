@extends('..admin.header_footer_layout')

@section('content')


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

                            <div class="col-md-6">
                                <!-- BEGIN CHART PORTLET-->
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-bar-chart font-green-haze"></i>
                                            <span class="caption-subject bold uppercase font-green-haze"> Статистика</span>
                                            <span class="caption-helper">сдесь можно наглядно увидить статистику</span>
                                        </div>

                                    </div>
                                    <div class="portlet-body">
                                        <div id="chart_2" class="chart" style="height: 400px;"> </div>
                                    </div>
                                </div>
                                <!-- END CHART PORTLET-->
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>










<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>


<script src="/assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="/assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>


<script src="/assets/pages/scripts/charts-amcharts.js" type="text/javascript"></script>

@endsection