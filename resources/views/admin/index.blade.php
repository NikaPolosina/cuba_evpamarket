@extends('admin.header_footer_layout')
@section('content')
<div class="page-container">

    @include('/admin/menu_navigation')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- END THEME PANEL -->
            <h3 class="page-title"> Домой
                <small>dashboard & statistics</small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/admin">Домой</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>Домой</span>
                    </li>
                </ul>

            </div>

            <div class="clearfix"></div>

            @include('/admin/home')

        </div>
        <!-- END CONTENT BODY -->
    </div>

    <a href="javascript:;" class="page-quick-sidebar-toggler">
        <i class="icon-login"></i>
    </a>
</div>


@endsection