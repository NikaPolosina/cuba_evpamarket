@extends('......layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h4>Для регистрации владельца компании, заполните необходимые поля.</h4></div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register_company') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Имя</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Фамилия</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="surname" value="{{ old('surname') }}">

                                    @if ($errors->has('surname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Телефон</label>

                                <div class="col-md-6">
                                    <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('date_birth') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Дата рождения</label>

                                <div class="col-md-6">
                                    <input type="data" class="form-control" name="date_birth" value="{{ old('date_birth') }}">

                                    @if ($errors->has('date_birth'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('date_birth') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Стать</label>

                                <div class="col-md-6">
                                 {{--   <input type="text" class="form-control" name="gender" value="{{ old('gender') }}">--}}
                                    <label class="checkbox-inline"><input name="gender" type="radio" value="1">Мужчина</label>
                                    <label class="checkbox-inline"><input name="gender" type="radio" value="0">Женщина</label>

                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Пароль</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Подтвердите пароль</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                                {!! Form::label('company_name', 'Название компании: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('company[company_name]', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
                                {!! Form::label('company_description', 'Описание компании: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::textarea('company[company_description]', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                    {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_logo') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_logo]', 'Лого компании: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('company[company_logo]', null, ['class' => 'form-control']) !!}
                                    {!! $errors->first('company_logo', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
                                {!! Form::label('company[company_content]', 'Детальная информацияо компании: ', ['class' => 'col-sm-3 control-label']) !!}
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


    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif


@endsection
