@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Привет {{$userInfo->name}} !!!</h1></div>

                    <div><h1>У Вас есть возможность зарегестрироватся как продавец, если это Вас необходимо, то выбирите пункт (Регистрация продавца)</h1></div>
                    <div style="text-align: center;">  <a href="{{ url('/homeOwnerUser') }}" class="btn btn-default btn-sm">Регистрация продавца</a> <a href="{{ url('/home') }}" class="btn btn-default btn-sm">Не интерестно</a></div>

                    <div class="panel-body">
                        Добро пожаловать. Вы залогинены!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection