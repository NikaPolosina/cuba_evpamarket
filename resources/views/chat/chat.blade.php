<div class="col-md-10" id="chat_content">
    <!-- BEGIN PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bubble font-hide hide"></i>
                <span class="caption-subject font-hide bold uppercase">Переписка</span>
            </div>
           {{-- <div class="actions">
                <div class="portlet-input input-inline">
                    <div class="input-icon right">
                        <i class="icon-magnifier"></i>
                        <input type="text" class="form-control input-circle" placeholder="search..."> </div>
                </div>
            </div>--}}
        </div>

        <div class="up">
            ещё.....
        </div>
        <div class="portlet-body" id="chats" style=" /* border: 1px green solid;*/">
            <div class="scroller" style="height: 500px;" data-always-visible="1" data-rail-visible1="1">


                <ul class="chats">

                @if(count($userInfo['beetwenTwo']['data']))
                    @foreach(array_reverse($userInfo['beetwenTwo']['data']) as $val)
                        <li class="@if($val['from_id'] == Auth::user()->id) out @else in @endif">
                            @if(!empty($val['get_user_from']['get_user_information']['avatar']) && file_exists(public_path().$val['get_user_from']['get_user_information']['avatar']))
                                <div class="avatar avatar_css">

                                    <img class="" src="{{$val['get_user_from']['get_user_information']['avatar']}}" alt="avatar">

                                </div>
                            @else
                                <img class="avatar" src="/img/placeholder/avatar.jpg" alt="avatar"/>
                            @endif
                            <div class="message">
                                <span class="arrow"> </span>
                                <a href="javascript:;" class="name">
                                    {{$val['get_user_from']['get_user_information']['name']}} {{$val['get_user_from']['get_user_information']['surname']}}
                                </a>
                                <span class="datetime"> {{ date('H:i', strtotime($val['created_at'])) }} </span>
                                <span class="body"> {{$val['body']}} </span>
                            </div>
                        </li>

                    @endforeach
                @endif

<?php



                    ?>
                </ul>
            </div>
            <div class="chat-form">
                <div class="input-cont">
                    <input class="form-control my_input_msg_js" type="text" placeholder="Введите сообщению сюда..." />
                </div>
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





<style>
    .avatar_css{
        width: 45px;
        height: 45px;
        overflow: hidden;
    }
    .up{
        cursor: pointer;
        width: 100%;
        color: grey;
        background-color: rgba(128, 128, 128, 0.15);
        text-align: center;
        /*border: 1px red solid;*/
    }
    .up:hover{
        background-color: rgba(128, 128, 128, 0.31);
        color: darkblue;
    }
</style>

<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
<script>
    var url = 'http://<?=$_SERVER['HTTP_HOST']?>:<?=env('PORT', 5000)?>';
    //var url = 'https://cuba-io-chat.herokuapp.com/';
    var data;
    var conn = true;
    var connected_id = '{{$conversation->id}}';


    var from_id           = '{{$from->id}}';
    var from_email        = '{{$from->email}}';
    var from_avatar = '{{$from->getUserInformation->avatar}}';
    var from_name = '{{$from->getUserInformation->name}}';
    var from_surname = '{{$from->getUserInformation->surname}}';


    var to_id = '{{$to->id}}';
    var to_avatar = '{{$to->getUserInformation->avatar}}';
    var to_name = '{{$to->getUserInformation->name}}';
    var to_surname = '{{$to->getUserInformation->surname}}';

    var page = 2;

</script>





