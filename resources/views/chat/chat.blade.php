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
    console.log(url);

    var data;
    var conn = new WebSocket(url);

    conn.onopen    = function(e){
        console.log("Соединение установлено!");
        data                 = {};
        data['action']       = 'login';
        data['id']           = '{{Auth::user()->id}}';
        data['email']        = '{{Auth::user()->email}}';
        data['connected_id'] = 1;
        console.log(data);
        conn.send(JSON.stringify(data));
    };
    conn.onclose   = function(event){
        console.log('close');
        if(event.wasClean){
            console.log('Соединение закрыто чисто');
        }else{
            console.log('Обрыв соединения'); // например, "убит" процесс сервера
        }
        console.log('Код: ' + event.code + ' причина: ' + event.reason);
    };

    conn.onerror   = function(){
        console.log('error');
    };

    // send  msg
        $('div.btn-cont').on('click', function () {
            event.preventDefault();
            var msg    = $(this).parents('.chat-form').find('input.my_input_msg_js').val();
            if(!msg.length){
                $(this).parents('.chat-form').find('input.my_input_msg_js').focus()
                return false;
            }
            data                 = {};
            data['action']       = 'chat';
            data['to']           = 4;
            data['connected_id'] = 2;
            data['msg']          = msg;
//                console.log(data);
            conn.send(JSON.stringify(data));

        });

    // response from server
    conn.onmessage = function(e){
        data = JSON.parse(e.data);
       // console.info(data);
        if(data.success){
            var avatar_in = '/img/users/4/avatar.png';
            var avatar = $('li.out').find('img.avatar').attr('src');


            switch(data.action){
                case 'login':
                    for(var key in data.chat){
                        console.log('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
                       // $('ul.chats').append('<li class="out"><img class="avatar" alt="" src="/assets/layouts/layout/img/avatar1.jpg"/><div class="message"><span class="arrow"> </span><a href="javascript:;" class="name"> Bob Nilson </a> <span class="datetime"> at 20:30 </span><span class="body">'+ data +'</span></div></li>');
                        //content.append('<p> -  ('+data.chat[key].created_at+') ->  ' + data.chat[key].body + '</p>');
                    }
                    break;
                case 'chat':
                        console.log(data);
                    $('ul.chats').append('<li class="in"><img class="avatar" alt="" src="'+avatar+'"/><div class="message"><span class="arrow"> </span><a href="javascript:;" class="name"> <?=$userInfo->name?><?=$userInfo->surname?> </a> <span class="datetime"> at 20:30 </span><span class="body">'+ data.msg +'</span></div></li>');
                    break;
            }

        }else{
            console.log(data.msg);
        }
    };

</script>





