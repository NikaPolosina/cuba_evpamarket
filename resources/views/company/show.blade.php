@extends('...layouts.master')

@section('content')
    <h1>Компания</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>Название компании</th><th>Краткое описание</th><th>Company Logo</th><th>Описание</th><th>Адрес</th><th>Контактная информация</th><th>Дополнительная информация</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td> {{ $company->company_name }} </td><td> {{ $company->company_description }} </td><td> {{ $company->company_logo }} </td>
                <td> {{ $company->company_content }} </td> <td> {{ $company->company_address }} </td> <td> {{ $company->company_contact_info }} </td> <td> {{ $company->company_additional_info }} </td>
            </tr>
            </tbody>
        </table>
    </div>

    <?php

    if(count($company->getProducts)){



    ?>

    {{-- @if(count($company->getProducts))--}}

    <h1>Продукты <a href="{{ url('products/create/'.$company->id) }}" class="btn btn-primary pull-right btn-sm">Добавить продукт</a></h1>

    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th>S.No</th><th>Категория</th><th>Товар</th><th>Описание товара</th><th>Фото</th><th>Цена</th><th>Действие</th>
            </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach ($company->getProducts as $item)



                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td>{{ $item->getCategory['title'] }}</td><td><a href="{{ url('products', $item->id) }}">{{ $item->product_name }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->product_image }}</td><td>{{ $item->product_price }}</td>
                    <td>


                        <a href="{{ url('products/' . $item->id . '/edit') }}">
                            <button type="submit" class="btn btn-primary btn-xs">Изменить</button>
                        </a> /



                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['products', $item->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::submit('Удалить', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}


                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

    </div>

    {{--   @endif
--}}
    <?php
    }else{


    ?>

    <h1>Добавить продукт</h1>
    <hr/>

    {!! Form::open(['url' => 'products', 'class' => 'form-horizontal']) !!}

    <input type="hidden" name="company_id" value="{{ $company->id }}"/>



    <div class="allCategory form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
        <div class="col-md-6 col-md-offset-3">

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
                $('.allCategory').click(function(){
                    //действия
                    return false;
                });




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




    <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
        {!! Form::hidden('product_category', null, ['class' => 'product_category']) !!}
        {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
            {!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
        {!! Form::label('product_description', 'Описание товара: ', ['class' => 'col-sm-3 control-label']) !!}
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
    <?php
    }
    ?>
    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
@endsection

