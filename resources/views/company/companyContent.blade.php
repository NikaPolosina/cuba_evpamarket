@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')



    {!! Form::open(['url' => '/company-content', 'class' => 'form-horizontal company_form', 'id'=>'fileupload']) !!}
        {{Form::hidden('company_id', $company_id)}}

        <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
            {!! Form::label('company_content', 'Детальное описание: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::textarea('company_content', NULL, ['class' => 'form-control']) !!}
                {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-1">
                {!! Form::submit('Создать', ['class' => 'btn btn-primary form-control']) !!}

            </div>
        </div>



    {!! Form::close() !!}

@endsection