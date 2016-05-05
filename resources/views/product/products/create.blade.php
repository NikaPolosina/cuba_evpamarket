@extends('layouts.master')

@section('content')

    <h1>Добавить товар @if(isset($company))  в компанию - {!!$company->company_name!!}  @endif  </h1>
    <hr/>



    <div class="row">
        <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
            <div class="col-md-3">

                <div id="custom-checkable" class=""></div>


                <script>





                    var defaultData = [
                        {
                            text: 'Parent 1',
                            href: '#parent1',

                            nodes: [
                                {
                                    text: 'Child 1',
                                    href: '#child1',
                                    nodes: [

                                    ]
                                }
                            ]
                        }
                    ];

                    var data = <?=$category?>

                            $('#custom-checkable').treeview({
//                    data: defaultData,
                                data: data,
                                showCheckbox: true,
                                enableLinks: true,



                                onNodeChecked: function(event, node) {
                                    console.log(node.href);
                                    $('.product_category').val(node.href)

                                },
                                onNodeUnchecked: function (event, node) {
                                    $('.product_category').val('')
                                    console.log(node.text + ' was unchecked');
                                }
                            }).treeview('collapseAll');




                </script>
                {{--<div class="form-group">
                    <select class="chosen-select" name="category_id" id="sel1">
                        <option value="">Выбирите категорию</option>
                        @foreach($category as $value)
                            <option value="{{$value->id}}">{{$value->title}}</option>
                        @endforeach
                    </select>
                </div>--}}
            </div>
        </div>





        {!! Form::open(['url' => 'products', 'class' => 'form-horizontal']) !!}





        @if(isset($company))  <input type="hidden" name="company_id" value="{{ $company->id }}"/>  @endif

        <?php

       
        ?>
        <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
            {!! Form::hidden('product_category', null, ['class' => 'product_category']) !!}
            {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
                {!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
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


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

@endsection