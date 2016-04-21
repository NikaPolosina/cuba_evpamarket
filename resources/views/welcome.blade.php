<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Добро пожаловать!</div>

                <div class="panel-body">
                   Кто вы?
                </div>

                <?php if(!Auth::user()){?>
                <form action="{{ url('/register') }}" style="display: inline-block"> <button type="submit" class="btn btn-default">Покупатель</button></form>
                <form action="{{ url('/register-company') }}" style="display: inline-block"><button type="submit" class="btn btn-default">Продавец</button></form>
         {{--
--}}
            <?php } ?>


            </div>

        </div>

    </div>
</div>
@endsection
<style>
    a:hover {
        text-decoration: none!important; /* Отменяем подчеркивание у ссылки */
    }
</style>