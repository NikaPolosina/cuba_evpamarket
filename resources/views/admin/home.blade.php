
@extends('admin.header_footer_layout')
@section('content')
<div class="row">
    <div class="col-md-6 col-sm-6">
        <!-- BEGIN PORTLET-->
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bubble font-hide hide"></i>
                    <span class="caption-subject font-hide bold uppercase">Чат</span>
                </div>
                <div class="actions">
                    <div class="portlet-input input-inline">
                        <div class="input-icon right">
                            <i class="icon-magnifier"></i>
                            <input type="text" class="form-control input-circle" placeholder="Поиск..."> </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body" id="chats">
                <div class="scroller" style="height: 525px;" data-always-visible="1" data-rail-visible1="1">
                    <ul class="chats">
                        <li class="out">
                            <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar2.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name">Елена Ильинская </a>
                                <span class="datetime"> в 20:11 </span>
                                <span class="body"> Привет)) У меня есть вопрс к тебе.</span>
                            </div>
                        </li>
                        <li class="in">
                            <img class="avatar" alt="" src="../assets/layouts/layout/img/avatar1.jpg" />
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name">Артем Познанский </a>
                                <span class="datetime"> в 20:30 </span>
                                <span class="body">Привет. </span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="chat-form">
                    <div class="input-cont">
                        <input class="form-control" type="text" placeholder="Введите свое сообщение сюда..." /> </div>
                    <div class="btn-cont">
                        <span class="arrow"> </span>
                        <a href="" class="btn blue icn-only">
                            <i class="fa fa-check icon-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

@endsection