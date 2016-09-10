@extends('layouts.app')

@section('content')

    <link href="../assets/pages/css/about.min.css" rel="stylesheet" type="text/css" />
    <div class="container">

        <div class="row margin-bottom-40 stories-header" data-auto-height="true">
            <div class="col-md-12">
                {{--<h1>Привет {{$userInfo->name}} !!!</h1>--}}
                <h2>Выбери род своей деятельности</h2>
            </div>
        </div>
        <div class="row margin-bottom-20 stories-cont">
            <div class="col-sm-8  col-sm-offset-2">


                <div class="col-sm-6">
                    <div class="portlet light">
                        <div class="photo">
                            <img src="/img/system/simple1.jpg" alt="" class="img-responsive" /> </div>
                        <div class="title">
                            <span> Покупатель </span>
                        </div>
                        <div class="desc">
                            <div style="height: 90px;">
                            <span>
                                Регистрируясь на сайте Вы можете получить доступ ко всем магазинам сайта для осуществления покупок, для этого выберите опцию «Зарегистрироваться как покупатель».  </span>
                            </span>

                            </div>
                            <hr/>

                            {!! Form::open(['url' => route('set_user_role'), 'class' => 'form-horizontal company_form', 'id'=>'fileupload']) !!}
                                {!! Form::hidden('role', 'simple_user') !!}
                                {!! Form::submit('Зарегистрироваться как покупатель', ['class' => 'btn btn-default btn-sm']) !!}
                            {!! Form::close() !!}


                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="portlet light">
                        <div class="photo">
                            <img src="/img/system/ovner.jpg" alt="" class="img-responsive" /> </div>
                        <div class="title">
                            <span> Продавец </span>
                        </div>
                        <div class="desc">
                            <div style="height: 90px;">
                            <span>  Если Вы хотите создать свой магазин и продавать свои товары другим пользователям сайта, для этого выберите опцию
                                «Зарегистрироваться как продавец»</span>

                                </div>
                            <hr/>
                            {!! Form::open(['url' => route('set_user_role'), 'class' => 'form-horizontal company_form', 'id'=>'fileupload']) !!}
                                {!! Form::hidden('role', 'company_owner') !!}
                                {!! Form::submit('Зарегистрироваться как продавец', ['class' => 'btn btn-default btn-sm']) !!}
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>










@endsection