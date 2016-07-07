@extends('..admin.header_footer_layout')
@section('content')
    <div class="page-container">

        @include('/admin/menu_navigation')

        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- END THEME PANEL -->
                <h3 class="page-title"> Магазины
                    <small></small>
                </h3>
                <div class="page-bar">
                    <ul class="page-breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="/admin/shop-all">магазины</a>
                            <i class="fa fa-angle-right"></i>
                        </li>
                        <li>
                            <span>магазины</span>
                        </li>
                    </ul>

                </div>

                <div class="clearfix"></div>


                <!-- END PAGE HEADER-->
                <div class="row">
                    <div class="col-md-6">
                        <!-- BEGIN SAMPLE TABLE PORTLET-->
                        <div class="portlet light ">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-social-dribbble font-green"></i>
                                    <span class="caption-subject font-green bold uppercase">Список пользователей</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-wrench"></i>
                                    </a>
                                    <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                                        <i class="icon-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-scrollable">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th> # </th>
                                            <th> Имя </th>
                                            <th> Фамилия </th>
                                            <th> Дата рождения </th>
                                            <th> Статус </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        {{-- */$x=0;/* --}}
                                            @foreach($shop as $item)
                                            {{-- */$x++;/* --}}
                                            <tr>
                                                <td> {{ $x }} </td>
                                                <td> {{$item->company_name}} </td>
                                                <td> {{$item->company_description}}</td>
                                                <td> {{$item->company_address}} </td>
                                                <td>
                                                    <span class="label label-sm label-success"> Подтвержденный </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE TABLE PORTLET-->
                    </div>

                </div>




            </div>
            <!-- END CONTENT BODY -->
        </div>

        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
    </div>


@endsection