<div class="row">

    <div class="col-sm-10 col-sm-offset-1">
        {{--{{dd($product)}}--}}
        {{--{{dd($userCategories)}}--}}
        {{--{{dd($company)}}--}}
        {{--{{dd($category)}}--}}

        @if($product)
            {!! Form::model($product, ['method' => 'PATCH', 'url' => route('save_product_form'), 'class' => 'form-horizontal']) !!}
            {{Form::hidden('id')}}
        @else
            {!! Form::open(['url' => route('save_product_form'), 'class' => 'form-horizontal']) !!}
        @endif

        {{--{!! Form::open(['class' => 'form-horizontal my_form', 'id'=> 'fileupload']) !!}--}}

        <div style="display: none" class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
            {!! Form::label('product_id', 'Id: ', ['class' => 'control-label']) !!}
            {!! Form::text('product_id', NULL, ['class' => 'form-control', 'data-name' =>'product_id']) !!}
        </div>

        <div class="form-group {{ $errors->has('category_name') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label" for="category_name">Категория:
                <span class="required_css">*</span></label> <select name="category_name" data-name="category_name">
                @if(count($userCategories))
                    <option value="">Выбирите категорию</option>
                    @foreach($userCategories as $value)
                        <option value="{{$value['id']}}">{{$value['title']}}</option>
                    @endforeach
                @endif
            </select> <span class="modalSpan"></span>
        </div>

        <div class="msgDenger alert alert-danger" style="display: none;">
            <strong>Внимание!</strong> Категория товара не выбрана. Выбирите катигорию.
        </div>

        <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label" for="product_name">Товар: <span class="required_css">*</span> </label>
            {!! Form::text('product_name', NULL, ['class' => 'form-control', 'data-name' =>'name']) !!}
            <div style="display: none" class="error" data-id="name">
                <strong>Внимание!</strong> <span></span>
            </div>
        </div>

        <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label" for="product_description">Краткое описание:
                <span class="required_css">*</span> </label>
            {!! Form::text('product_description', NULL, ['class' => 'form-control', 'required' => 'required', 'data-name' =>'description']) !!}

            <div style="display: none" class="error" data-id="description">
                <strong>Внимание!</strong> <span></span>
            </div>
        </div>


        <div class="">Полное описание: <span class="required_css">*</span></div>

        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
            {!! Form::label('', 'Полное описание: ', ['class' => 'col-sm-3 control-label']) !!}
            {!! Form::textarea('content', NULL, ['class' => 'form-control tiny', 'data-name' =>'content']) !!}
        </div>

        {{-------------------------------------Блок с доплнительной информацией------------------------------------------}}
        <div class="form-group addParam">

        </div>
        {{-------------------------------------Блок с доплнительной информацией------------------------------------------}}

        {!! Form::hidden('product_image', NULL, ['class' => 'form-control', 'data-name' =>'photo']) !!}

        <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
            <label class="col-sm-3 control-label" for="product_price">Цена: <span class="required_css">*</span> </label>
            {!! Form::number('product_price', NULL, ['class' => 'form-control', 'data-name' =>'price', 'min'=>0]) !!}
            <div style="display: none" class="error" data-id="price">
                <strong>Внимание!</strong> <span></span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                {{--Картинка--}}
            </div>
        </div>


        <div class="row">
            <div class="col-sm-4 col-sm-offset-4">
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Добавить картинку..</span>
                    <input type="file" name="files[]" multiple>
                </span>
            </div>

            <div class="col-sm-12">
                <table>
                    <tbody class="files"></tbody>
                </table>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>


<style>
    .my_form label {
        text-align: left;
    }

    .form-horizontal .control-label {
        text-align: left !important;
    }
</style>