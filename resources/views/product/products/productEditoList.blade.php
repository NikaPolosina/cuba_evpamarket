<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th colspan="6">
            <?php

            $mainCategory = array_shift($category);
            echo $mainCategory[0]['title'];
            ?>

        </th>
    </tr>
    <tr>
        <th colspan="6">

            <?php
            $bread = '';
            foreach ($category as $value) {
                $bread = $bread.$value[0]['title'].' > ';
            }
            echo $bread;
            ?>

        </th>



    </tr>
    <tr>
        <th>№</th><th>Товар</th><th>Описание товара</th><th>Фото</th><th>Цена</th><th>Действие</th>
    </tr>
    </thead>
    <tbody class="tBody">


    @foreach ($products as $item)

        <tr>

            <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td><td><a href="{{ url('products', $item->id) }}">{{ $item->product_name }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->product_image }}</td><td>{{ $item->product_price }}</td>
            <td>



                <a href="{{ url('products/' . $item->id . '/edit') }}">
                    <button type="submit" class="btn btn-primary btn-xs">Изменить</button>
                </a>



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
<input class="cimpanyIdclass" type="hidden" name="cimpanyId" value="{{$company}}"/>
<input class="categoryIdclass" type="hidden" name="categoryId" value="{{$value[0]['id']}}"/>



<a class="addCategoryProduct btn btn-primary pull-left btn-sm">+</a>
<a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">x</a>
<div class="col-sm-12">
    <div class="addProductCategory" style="display: none">
    {!! Form::open(['url' => 'products-category', 'class' => 'form-horizontal']) !!}


    @if(isset($company))  <input type="hidden" name="company_id" value="{{$company}}"/>  @endif

    <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
        <input class="categoryIdclass" type="hidden" name="categoryId" value="{{$value[0]['id']}}"/>

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
</div>


<script>

$('.addCategoryProduct').on('click', function(){

  var companyId = $('.cimpanyIdclass').val();
  var categoryId = $('.categoryIdclass').val();

    $.ajax({
        type: "POST",
        url: "/products/create-by-category",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            companyId: companyId,
            categoryId: categoryId
        },
        success: function(msg){
            console.log('ura');


            $('.addProductCategory').toggle();

        }
    });


});

$('#destroycheck').on('click', function() {
        event.preventDefault();
        var selected = [];
        var inputs = $('.tBody').find('input:checked');
        inputs.each(function() {
            selected.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "/products/destroy-check",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: '<?=$company?>',
                checkId: selected
            },
            success: function(msg){
                inputs.each(function() {
                    $(this).parents('tr').eq(0).remove();
                });
            }
        });


    });

</script>


