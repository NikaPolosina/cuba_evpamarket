<div class="row">
    <div class="col-sm-12">
        <div class="container_user_msg">
            @if(count($userInfo['msgAll']))

                @foreach($userInfo['msgAll'] as $itemMsg)

                    @if(count($itemMsg['get_chat_msgs']) !== 0)
                {{--    @foreach($itemMsg['get_chat_msgs'] as $it)--}}
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
                                   {{$itemMsg['get_chat_msgs'][0]['get_user_to']['get_user_information']['name']}} {{$itemMsg['get_chat_msgs'][0]['get_user_to']['get_user_information']['surname']}}
                                </div>
                                <div class="body_sm">
                                    {!!$itemMsg['get_chat_msgs'][0]['body']  !!}
                                    <span class="time">{{ date('d.m.Y', strtotime($itemMsg['get_chat_msgs'][0]['created_at'])) }}</span>
                                </div>
                            </div>
                        </div>
                        </a>
                    @endif
                    @endforeach
         {{--       @endforeach--}}

            @endif
        </div>
    </div>
</div>

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

    .body_sm{
        font-weight: 300;
    }
    .single_msg:hover{
        background-color: rgba(0, 196, 255, 0.09);
    }
    .img_sing{
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