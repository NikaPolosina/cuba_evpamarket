{{------------------------------------------------------------------------------------------------}}
@extends('homeSimpleUser')

@section('content_user')

<div class="col-sm-10 myPageContent">
    <div class="row">
        <div class="col-sm-12 contentInfo">

            <div class="col-sm-4" style="border: solid 1px red;">
                <img class="img-thumbnail" src="/img/custom/files/thumbnail/plase.jpg" alt="" style="width: 200px; height: 200px"/>

            </div>
            <div class="col-sm-8" style="border: solid 1px red;">
                <h1>{{$userInfo->name}} {{$userInfo->surname}}</h1>
                <h5>{{$userInfo->country}}</h5>
            </div>

        </div>
    </div>
</div>
@endsection
{{--------------------------------------------------------------------------------------------------}}

