@extends('...layouts.app')

@section('content')

    <h1>Создать новый магазин</h1>
    <hr/>

    {!! Form::open(['url' => 'company', 'class' => 'form-horizontal']) !!}

                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                {!! Form::label('company_name', 'Название магазина: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
                {!! Form::label('company_description', 'Описание магазина: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_logo') ? 'has-error' : ''}}">
                {!! Form::label('company_logo', 'Logo: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_logo', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_logo', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
                {!! Form::label('company_content', 'Детальное описание: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_content', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_address') ? 'has-error' : ''}}">
                {!! Form::label('company_address', 'Адрес: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_address', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_address', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_contact_info') ? 'has-error' : ''}}">
                {!! Form::label('company_contact_info', 'Контактная информация: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_contact_info', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_contact_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_additional_info') ? 'has-error' : ''}}">
                {!! Form::label('company_additional_info', 'Дополнительная информация: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_additional_info', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_additional_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Создать', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection