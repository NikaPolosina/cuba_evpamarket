@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>Привет {{$curentUser->name}} !!!</h1></div>



                    <div class="panel-body">
                        Добро пожаловать. Вы залогинены!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
