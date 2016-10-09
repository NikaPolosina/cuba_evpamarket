<div class="col-md-10" id="chat_content">
    <!-- BEGIN PORTLET-->
    <div class="portlet light ">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-bubble font-hide hide"></i>
                <span class="caption-subject font-hide bold uppercase">Chats</span>
            </div>
           {{-- <div class="actions">
                <div class="portlet-input input-inline">
                    <div class="input-icon right">
                        <i class="icon-magnifier"></i>
                        <input type="text" class="form-control input-circle" placeholder="search..."> </div>
                </div>
            </div>--}}
        </div>


        <div class="portlet-body" id="chats">
            <div class="scroller" style="height: 525px;" data-always-visible="1" data-rail-visible1="1">
                <ul class="chats">
                    @foreach($userInfo['beetwenTwo'] as $val)

                        <li class="@if($val['from_id'] == Auth::user()->id) out @else in @endif">
                            @if(!empty($val['get_user_from']['get_user_information']['avatar']) && file_exists(public_path().$val['get_user_from']['get_user_information']['avatar']))
                                <img class="avatar" src="{{$val['get_user_from']['get_user_information']['avatar']}}" alt="avatar">
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



<script>
    var url = 'ws://<?=$_SERVER['HTTP_HOST']?>:<?=env('PORT', 5000)?>';
    var data;
    var conn = true;

    var from_id           = '{{Auth::user()->id}}';
    var from_email        = '{{Auth::user()->email}}';

    var to_id = '{{($conversation->from_id == Auth::user()->id) ? $conversation->to_id : $conversation->from_id}}';
    var connected_id = '{{$conversation->id}}';

</script>





