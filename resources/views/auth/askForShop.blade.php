@extends('layouts.app')

@section('content')

    <link href="../assets/pages/css/about.min.css" rel="stylesheet" type="text/css" />
    <div class="container">

        <div class="row margin-bottom-40 stories-header" data-auto-height="true">
            <div class="col-md-12">
                <h1>Привет {{$userInfo->name}} !!!</h1>
                <h2>Выбери род своей деятельности</h2>
            </div>
        </div>
        <div class="row margin-bottom-20 stories-cont">
            <div class="col-sm-8  col-sm-offset-2">

                <div class="col-sm-6">
                    <div class="portlet light">
                        <div class="photo">
                            <img src="/img/system/ovner.jpg" alt="" class="img-responsive" /> </div>
                        <div class="title">
                            <span> Продавец </span>
                        </div>
                        <div class="desc">
                            <span> Регистрируясь на сайте Вы можете получить доступ ко всем магазинам сайта для осуществления покупок, для этого выберите опцию «Зарегистрироваться как продавец».  </span>
                            <hr/>
                            <a href="{{ url('/homeOwnerUser') }}" class="btn btn-default btn-sm">Зарегистрироваться как продавец</a>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="portlet light">
                        <div class="photo">
                            <img src="/img/system/simple1.jpg" alt="" class="img-responsive" /> </div>
                        <div class="title">
                            <span> Покупатель </span>
                        </div>
                        <div class="desc">
                            <span> Если Вы хотите создать свой магазин и продавать свои товары другим пользователям сайта, выберите опцию «Зарегистрироваться как покупатель» </span>
                            <hr/>
                            <a href="{{ url('/home') }}" class="btn btn-default btn-sm">Зарегистрироваться как покупатель</a>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>










@endsection