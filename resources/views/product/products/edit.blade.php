@extends('layouts.master')

@section('content')

    <h1>Edit Product</h1>
    <hr/>

    {!! Form::model($product, [
        'method' => 'PATCH',
        'url' => ['products', $product->id],
        'class' => 'form-horizontal'
    ]) !!}
    @if(isset($company))  <input type="hidden" name="company_id" value="{{ $company->id }}"/>  @endif
    @if(count($product->getCompany))  <input type="hidden" name="company_id" value="{{ $product->getCompany[0]->id }}"/>  @endif


                <div class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
                {!! Form::label('product_id', 'Product Id: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('product_id', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                {!! Form::label('product_description', 'Описание: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('product_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('product_description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('product_image') ? 'has-error' : ''}}">
                {!! Form::label('product_image', 'Фото: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('product_image', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('product_image', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
                {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::number('product_price', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('product_price', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
    <?php
    die('Surprise, you are here !!!');


    ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Обновить', ['class' => 'btn btn-primary form-control']) !!}
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