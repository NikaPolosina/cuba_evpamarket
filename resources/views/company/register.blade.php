@extends('......layouts.app')

@section('content')
    @include('layouts.header_menu')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Для регистрации мвгазина, заполните необходимые поля.</h4></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register_company') }}">
                            {!! csrf_field() !!}

                            <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                                {!! Form::label('company_name', 'Название мвгазина: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('company[company_name]', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
                                {!! Form::label('company_description', 'Описание мвгазина: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('company[company_description]', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_logo') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_logo]', 'Лого мвгазина: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('company[company_logo]', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('company_logo', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_content]', 'Детальная информация о мвгазине: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('company[company_content]', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_address') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_address]', 'Адрес: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('company[company_address]', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('company_address', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_contact_info') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_contact_info]', 'Контактная информация: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('company[company_contact_info]', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('company_contact_info', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_additional_info') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_additional_info]', 'Доплнительная информация: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('company[company_additional_info]', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('company_additional_info', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Создать
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! HTML::script('/js/registerList.js') !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif


@endsection
