<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    My Application's Landing Page.
                </div>

                <?php if(!Auth::user()){?>
                <button type="button" class="btn btn-default"><a href="{{ url('/register') }}">Покупатель</a></button>
                <button type="button" class="btn btn-default"><a href="{{ url('/register-company') }}">Продавец</a></button>

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