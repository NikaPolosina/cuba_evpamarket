<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title>Cuba | Dashboard</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout2/css/layout.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/layouts/layout2/css/themes/blue.min.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="/assets/layouts/layout2/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/admin" style="text-decoration: none; color: white;">
                <h2><span>CUBA</span></h2> </a>
            <div class="menu-toggler sidebar-toggler">
                <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">

            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">


                    <li class="dropdown dropdown-user">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="/assets/layouts/layout2/img/avatar3_small.jpg" />
                            <span class="username username-hide-on-mobile"> Admin </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">

                            <li>
                                <a href="{{ url('/logout') }}">
                                    <i class="icon-key"></i> Выйти </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<div class="page-container">

    @include('/admin/menu_navigation')

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- END THEME PANEL -->
            <h3 class="page-title"> Путь
                <small></small>
            </h3>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="/admin/user">путь1</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <span>путь2</span>
                    </li>
                </ul>

            </div>

            <div class="clearfix"></div>

                @yield('content')

            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a>
        </div>


<div class="page-footer">

    <div class="scroll-to-top">
        <i class="icon-arrow-up"></i>
    </div>
</div>

</body>
<script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>



<script src="/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/horizontal-timeline/horozontal-timeline.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<script src="/assets/pages/scripts/dashboard.js" type="text/javascript"></script>
<script src="/assets/layouts/layout2/scripts/layout.min.js" type="text/javascript"></script>
<script src="/assets/layouts/layout2/scripts/demo.min.js" type="text/javascript"></script>
<script src="/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

<link rel="stylesheet" media="screen" type="text/css" href="/plugins/colorPicker/css/colorpicker.css" />
<script type="text/javascript" src="/plugins//colorPicker/js/colorpicker.js"></script>


</html>