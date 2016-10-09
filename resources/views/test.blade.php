@extends('layouts.app')

@section('content')


    {!! HTML::script('/js/test.js') !!}


    {{--<div class="button">
        <button onclick="send();">Send</button>
    </div>


    <script>
       // var conn = new WebSocket('ws://<?=$_SERVER['HTTP_HOST']?>:3042');
        var conn = new WebSocket('ws://185.68.16.7:3045');
        conn.onopen = function (e) {
            console.log('Соединение установлено!');
        }
        conn.onmessage = function (e) {
            console.log('Получено данные ' +e.data);
        }
        function send() {
            var data = 'Данные для отправки: ' +Math.random();
            conn.send(data);
            console.log('Отправлено: '+data);
        }
    </script>
--}}

@endsection