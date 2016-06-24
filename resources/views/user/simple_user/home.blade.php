{{------------------------------------------------------------------------------------------------}}
@extends('homeSimpleUser')

@section('content_user')

<div class="col-sm-10 myPageContent">
    <div class="row">
        <div class="col-sm-12 contentInfo">

            <div class="col-sm-4 img" style="/*border: solid 1px red;*/">


            </div>
            <div class="col-sm-8" style="/*border: solid 1px red;*/">
                <h1>{{$userInfo->name}} {{$userInfo->surname}}</h1>
                <h5>{{$userInfo->country}}</h5>
            </div>

        </div>
    </div>
</div>

    <script>
        $(document).ready(function(){

            var userId = '{{$user->id}}';
            var nededPath = '/users/'+userId+'/avatar/';
            var nededFiles = [];
            var fileUrl  ='{{route('file_uploader')}}';

            $.ajax({
                url      : fileUrl,
                dataType : 'json',
                context  : '',
                data     : {
                    image : [],
                    path  : nededPath
                }
            }).done(function(result){
                if(result.files.length){
                    $('.files').html('');
                    result.files.forEach(function(value){
                        $('.img').html('<img class="img-thumbnail" src="'+value['url']+'" alt="" />');
                    });
                }else{
                    $('.img').html('<img class="img-thumbnail" src="/img/custom/files/thumbnail/plase.jpg" alt="" style="width: 200px; height: 200px"/>');
                }

            });
        });
    </script>
@endsection
{{--------------------------------------------------------------------------------------------------}}

