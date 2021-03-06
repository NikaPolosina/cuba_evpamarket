<?php
$show = false;
?>


<div class="row">
    <div class="col-sm-12">
        <div class="container_user_msg">
            <div class="con">
                Разговоры
            </div>

            @if(count($userInfo['msgAll']))
                @foreach($userInfo['msgAll'] as $itemMsg)
                    @if(count($itemMsg['get_chat_msgs']) != 0)
                            <a href="/get-single-conversation/{{Auth::user()->id}}/{{(Auth::user()->id == $itemMsg['get_chat_msgs'][0]['get_user_to']['id'] )? $itemMsg['get_chat_msgs'][0]['get_user_from']['id']: $itemMsg['get_chat_msgs'][0]['get_user_to']['id']}}">
                                <div class="single_msg">
                                    <div class="single_img col-sm-2">

                                        @if(!empty($itemMsg['get_chat_msgs'][0]['get_user_from']['get_user_information']['avatar']) && file_exists(public_path().$itemMsg['get_chat_msgs'][0]['get_user_from']['get_user_information']['avatar']))
                                            <img class="img_sing" src="{{$itemMsg['get_chat_msgs'][0]['get_user_from']['get_user_information']['avatar']}}" alt="avatar">
                                        @else
                                            <img class="img_sing" src="/img/placeholder/avatar.jpg" alt="avatar"/>
                                        @endif

                                    </div>
                                    <div class="single_body col-sm-10">
                                        <div class="user_name">
                                         {{--  <span>от кого </span>--}} <input class="id_from" value="{{$itemMsg['get_chat_msgs'][0]['get_user_from']['id']}}" type="hidden"/>
                                          {{-- <span>кому </span> --}}<input  class="id_to" value="{{$itemMsg['get_chat_msgs'][0]['get_user_to']['id']}}" type="hidden"/>

                                           {{$itemMsg['get_chat_msgs'][0]['get_user_from']['get_user_information']['name']}} {{$itemMsg['get_chat_msgs'][0]['get_user_from']['get_user_information']['surname']}}
                                        </div>
                                        <div class="body_sm col-sm-12">
                                            <div class="col-sm-2">
                                                   <div class="bloc_img">
                                                       @if(is_file(public_path().'/img/users/'.$itemMsg['get_chat_msgs'][(count($itemMsg['get_chat_msgs'])-1)]['get_user_from']['get_user_information']['id'].'/avatar.png'))
                                                           <img class=" my_sing" src="{{'/img/users/'.$itemMsg['get_chat_msgs'][(count($itemMsg['get_chat_msgs'])-1)]['get_user_from']['get_user_information']['id'].'/avatar.png'}}" alt="avatar">
                                                       @else
                                                           <img class=" my_sing" src="/img/placeholder/avatar.jpg" alt="avatar"/>
                                                       @endif
                                                   </div>
                                            </div>


                                            <div class="panel-body col-sm-10" style="padding: 0px!important;">


                                                <?=$itemMsg['get_chat_msgs'][(count($itemMsg['get_chat_msgs'])-1)]['get_user_from']['get_user_information']['name'].' '.$itemMsg['get_chat_msgs'][(count($itemMsg['get_chat_msgs'])-1)]['get_user_from']['get_user_information']['surname'].': '?>
                                                {!!$itemMsg['get_chat_msgs'][(count($itemMsg['get_chat_msgs'])-1)]['body']!!}
                                                <span class="time">{{ date('d.m.Y', strtotime($itemMsg['get_chat_msgs'][0]['created_at'])) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>
                    @else

                        <div class="single_msg">
                            <div class="body_sm" style="text-align: center">

                                <h4 style="line-height: 33px;">У Вас разговоров нет.</h4>

                            </div>
                        </div>

                    @endif

                @endforeach

            @else

                <div class="single_msg">
                    <div class="body_sm" style="text-align: center">

                        <h4 style="line-height: 33px;">У Вас разговоров нет.</h4>

                    </div>
                </div>


            @endif
        </div>
    </div>
</div>

<style>
    .bloc_img{
        width: 30px;
        height: 30px;
        border: solid 1px grey;
        border-radius: 50%!important;
        overflow: hidden;
    }
    .bloc_img>img{
        float: right;
    }
    .container_user_msg{
        min-height: 384px;
        background-color: rgb(240, 246, 250);
        padding: 20px 10px 20px 10px;
    }
    .con{
        padding: 0px 0px 5px 0px;
        font-size: 14px;
        font-weight: bold;
        color: #169ef4;
    }

</style>

{{--<script>

    $('.single_msg').on('click', function () {
        var id_from = $(this).find('input.id_from').val();
        var id_to = $(this).find('input.id_to').val();
        console.log(id_from);
        console.log(id_to);


        $.ajax({
            type    : "POST",
            url     : 'get-single-conversation/'+id_from+'/'+id_to,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data    : {

            },
            success : function(response){

            },
            error   : function(response){

            }
        });



    })


</script>--}}



<style>

/*
    @media screen and (max-width:950px){
        img.img_sing{
            height: 100px!important;
            width: 100px!important;
        }
    }
*/
.body_sm>img{
    display: inline-block;
    width: 30px;
}
    .body_sm{
        font-weight: 300;
    }
    .single_msg:hover{
        background-color: rgba(0, 196, 255, 0.09);
    }
    .img_sing{
        margin: auto;
        max-height: 60px;
    }
    .time{
        color: darkgrey;
        float: right;
    }
    .user_name{
        font-size: 14px;
        font-weight: 600;
    }

    .container_user_msg{

        border-radius: 2px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;

    }
    .single_msg{
        height: 70px;
        border-bottom: 1px solid #e3e4e8;
        padding: 5px;
        background-color: #fff;
    }


</style>