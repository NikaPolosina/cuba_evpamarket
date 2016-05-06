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

        @include('product.products.singleProductTr', array('item' => $item))

    @endforeach

    </tbody>

</table>
<div class="paginate">
        <?php echo $products->render(); ?>
</div>
<input class="cimpanyIdclass" type="hidden" name="cimpanyId" value="{{$company}}"/>

<a class="addCategoryProduct btn btn-primary pull-left btn-sm">+</a>
<a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">x</a>
<div class="col-sm-12">
    <div class="addProductCategory" style="display: none">
        <input class="categoryIdclass" type="hidden" name="categoryId" value="{{$value[0]['id']}}"/>

        {!! Form::open(['class' => 'form-horizontal']) !!}
    {{--{!! Form::open(['url' => 'products-category', 'class' => 'form-horizontal']) !!}--}}


    @if(isset($company))  <input type="hidden" name="company_id" value="{{$company}}"/>  @endif

    <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
        <input data-name="category_id" class="categoryIdclass" type="hidden" name="categoryId" value="{{$value[0]['id']}}"/>

        {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('product_name', null, ['class' => 'form-control', 'data-name' =>'name']) !!}
            {!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
        {!! Form::label('product_description', 'Описание: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('product_description', null, ['class' => 'form-control', 'required' => 'required', 'data-name' =>'description']) !!}
            {!! $errors->first('product_description', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('product_image') ? 'has-error' : ''}}">
        {!! Form::label('product_image', 'Фото: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::text('product_image', null, ['class' => 'form-control', 'data-name' =>'photo']) !!}
            {!! $errors->first('product_image', '<p class="help-block">:message</p>') !!}
        </div>
    </div>
    <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
        {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}
        <div class="col-sm-6">
            {!! Form::number('product_price', null, ['class' => 'form-control', 'data-name' =>'price']) !!}
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
        $('.addProductCategory').toggle();
    });

    $('.form-horizontal').on('submit', function(){
        event.preventDefault();
        var selected1 = {};
        var inputs = $('.addProductCategory').find('[data-name]');

        
        inputs.each(function() {
            selected1[$(this).attr('data-name')] = $(this).val();
        });


        $.ajax({
            type: "POST",
            url: "/products-category",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: '<?=$company?>',
                checkId: selected1
            },
            success: function(data){
                $('.tBody').append(data);

                inputs.each(function() {
                    if($(this).attr('data-name') != 'category_id'){
                        $(this).val('');
                    }
                });

                $('.addCategoryProduct').click();
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


