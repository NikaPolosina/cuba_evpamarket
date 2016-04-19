@extends('...layouts.master')

@section('content')

    <h1>Edit Company</h1>
    <hr/>

    {!! Form::model($company, [
        'method' => 'PATCH',
        'url' => ['company', $company->id],
        'class' => 'form-horizontal'
    ]) !!}

                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                {!! Form::label('company_name', 'Company Name: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
                {!! Form::label('company_description', 'Company Description: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_logo') ? 'has-error' : ''}}">
                {!! Form::label('company_logo', 'Company Logo: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_logo', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_logo', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
                {!! Form::label('company_content', 'Company Content: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_content', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_address') ? 'has-error' : ''}}">
                {!! Form::label('company_address', 'Company Address: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_address', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_address', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_contact_info') ? 'has-error' : ''}}">
                {!! Form::label('company_contact_info', 'Company Contact Info: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_contact_info', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_contact_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company-additional_info') ? 'has-error' : ''}}">
                {!! Form::label('company-additional_info', 'Company-additional Info: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company-additional_info', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company-additional_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
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