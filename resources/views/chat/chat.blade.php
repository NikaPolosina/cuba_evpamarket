<link rel="stylesheet" href="/css/emojionearea.min.css" />



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
        <div class="portlet-body" id="chats" style="    box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;">
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
                                <span class="body body_im"> {!! $val['body'] !!} </span>
                            </div>
                        </li>

                    @endforeach
                @endif

                </ul>
            </div>
        {{--    <div class="chat-form">
                <div class="input-cont">
                    <input class="form-control my_input_msg_js" type="text" placeholder="Введите сообщению сюда..." />
                </div>
                    <div class="btn-cont">
                    <span class="arrow"> </span>
                    <a href="" class="btn blue icn-only">
                        <i class="fa fa-check icon-white"></i>
                    </a>
                </div>
            </div>--}}


            <div class="chat-form" style="padding: 10px 0px 0px;!important;">
                <div class="input_classic">
                    <div class="span6 ya">
                        <div class="di">
                            <div class="my_avatar avatar_css" style="float: left">
                                @if(!empty($userInfo->avatar) && file_exists(public_path().$userInfo->avatar))
                                    <img src="{{$userInfo->avatar}}" alt="avatar">
                                @else
                                    <img src="/img/placeholder/avatar.jpg" alt="avatar"/>
                                @endif
                            </div>
                            <div class=" avatar_css my_avatar" style="float:right; width: 20%">

                                @if($conversation->from_id == Auth::user()->id && $conversation->to_id !== Auth::user()->id)
                                    <img class="" src="/img/users/{{$conversation->to_id}}/avatar.png" alt="avatar">
                                @elseif($conversation->from_id !== Auth::user()->id && $conversation->to_id == Auth::user()->id)
                                    <img class="" src="/img/users/{{$conversation->from_id}}/avatar.png" alt="avatar">
                                @endif

                            </div>

                        </div>
                        <div class="input-cont">
                             <textarea class="my_input_msg_js" style="border: 0!important; width: 80%" id="emojionearea1" placeholder="Введите Ваше сообщение..."></textarea>
                        </div>
                        <div class="sometin btn">
                            <button class="flat_button fl_r">Отправить</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END PORTLET-->
</div>





<style>
    .body_im>img{
        display: inline-block;
        width: 24px;
        height: 24px;
    }
    .body_im>div>img{
        display: inline-block;
        width: 24px;
        height: 24px;
    }
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


<script src="/js/emojionearea.min.js"></script>

<script>

    $(document).ready(function() {
        $("#emojionearea1").emojioneArea({
            pickerPosition: "top",
            tonesStyle: "bullet"
        });
        $("#emojionearea2").emojioneArea({
            pickerPosition: "bottom",
            tonesStyle: "radio"
        });
        $("#emojionearea3").emojioneArea({
            pickerPosition: "left",
            filtersPosition: "bottom",
            tonesStyle: "square"
        });
        $("#emojionearea4").emojioneArea({
            pickerPosition: "bottom",
            filtersPosition: "bottom",
            tonesStyle: "checkbox"
        });
        $("#emojionearea5").emojioneArea({
            pickerPosition: "top",
            filtersPosition: "bottom",
            tones: false,
            autocomplete: false,
            inline: true,
            hidePickerOnBlur: false
        });
    });
</script>



<style>
    * {
        font-family: Arial, Helvetica, san-serif;
    }
    .row:after, .row:before {
        content: " ";
        display: table;
        clear: both;
    }
    .span6 {
        float: left;
        width: 100%;
        padding: 1% 1% 0% 1%;
    }
    .emojionearea-editor:not(.inline) {
        min-height: 3em!important;
    }
    /*--------------------*/
    .sometin{
        padding: 15px 5px 5px 5px;
        min-height: 35px;
        border-top: 1px #d7d8db solid;
    }
    .flat_button{
        padding: 7px 16px 8px;
        margin: 0;
        font-size: 12.5px;
        display: inline-block;
        zoom: 1;
        cursor: pointer;
        white-space: nowrap;
        outline: none;
        font-family: -apple-system,BlinkMacSystemFont,Roboto,Open Sans,Helvetica Neue,sans-serif;
        vertical-align: top;
        line-height: 15px;
        text-align: center;
        text-decoration: none;
        background: none;
        background-color: #5e81a8;
        color: #fff;
        border: 0;
        border-radius: 2px!important;
        box-sizing: border-box;
    }
    .fl_r {
        float: right;
    }
    .ya{
        border-radius: 0 0 2px 2px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
    }
    .my_avatar{
        width: 20%;

    }
    .avatar_css{
        height: 46px!important;
        width: 46px!important;
        border-radius: 50%!important;
        overflow: hidden;
    }
    .avatar_css>img{
        max-width: 100%;
        height: auto;
        display: block;
    }

    .emojionearea{
        float: right;
        width: 80%;
    }
    .sometin{
        width: 80%;
        float: right;
    }
</style>



