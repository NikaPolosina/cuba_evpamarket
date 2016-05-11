@extends('...layouts.app')

@section('content')

    <div style="border: solid 2px darkgrey; padding: 10px;">
        <div class="table-responsive">
            <h1 style="text-align: center">{{ $company->company_name }} </h1>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-3">
                <hr>
                <h4>Категории товаров</h4>
                <hr>
                <div class="allCategory form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">

                    <div id="custom-checkable" class=""></div>

                </div>
            </div>
            <div class="col-sm-9">
                <div class="table" id="product_list">
                    @include('product.products.productEditorList', array(
                                    'products' => $company->getProducts()->paginate($paginCnt),
                                    'category' => false
                                     ))

                </div>

                <div class="product-editor">
                  {{--  <a class="addCategoryProduct btn btn-primary pull-left btn-sm">+</a>
                    <a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">x</a>--}}

                    <div class="col-sm-12">
                        <div class="addProductCategory" style="display: none">
                            {!! Form::open(['class' => 'form-horizontal ', 'id'=> 'product_form']) !!}

                            <input class="cimpanyIdclass" type="hidden" name="cimpanyId" value="{{$company->id}}"/>



                            <div style="display: none" class="form-group {{ $errors->has('product_id') ? 'has-error' : ''}}">
                                {!! Form::label('product_id', 'Продукт ID: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('product_id', null, ['class' => 'form-control', 'data-name' =>'product_id']) !!}

                                    {!! $errors->first('product_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div style="display: none" class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                {!! Form::label('category_id', 'Категория ID: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('category_id', null, ['class' => 'form-control', 'data-name' =>'category_id']) !!}
                                    {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('category_name') ? 'has-error' : ''}}">
                                {!! Form::label('category_name', 'Категория: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('category_name', null, ['class' => 'form-control', 'data-name' =>'category_name']) !!}
                                    {!! $errors->first('category_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
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
                                    {!! Form::submit('Create', ['class' => 'create btn btn-primary form-control']) !!}
                                    {!! Form::submit('Update', ['class' => 'update btn btn-primary form-control']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}


                        </div>
                    </div>

                </div>

            </div>
        </div>



        <script>

            var categories = [];
            var data = <?=$category?>;
            $(document).ready(function(){
                $('#custom-checkable').treeview({
                    data: data,
                    showCheckbox: true,
                    enableLinks: true,
                    onNodeChecked: function (event, node) {
                        $('.addProductCategory').hide();//ertyuiosdfghkwertyuierty
                        categories = [];
                        $('#product_list').html('');
                        var list = $('#custom-checkable').treeview('getChecked');
                        if (list.length > 1) {
                            var tree = $('#custom-checkable').treeview(true);
                            list.forEach(function (element) {
                                if (node.href != element.href) {
                                    tree.uncheckNode(element, {silent: true});
                                }
                            });
                        }

                        categories.push(node['id']);
                        if (node['nodes'].length > 0) {
                            var childrens = node['nodes'];
                            do {
                                childrens.forEach(function (currentNode, key) {
                                    categories.push(currentNode['id']);
                                    if (currentNode['nodes'].length > 0) {
                                        currentNode['nodes'].forEach(function (nNode, k) {
                                            childrens.push(nNode);
                                        });
                                    }
                                    childrens.splice(key, 1);
                                });
                            } while (childrens.length > 0);
                        }


                        $.ajax({
                            type: "POST",
                            url: "/get-product-list",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                companyId: '<?=$company->id?>',
                                categoryId: categories
                            },
                            success: function (msg) {
                                $('#product_list').html(msg);
                            }
                        });

                    },
                    onNodeUnchecked: function (event, node) {
                        $('.product_category').val('')
                        $('#product_list').html('');
                        categories = [];

                        $.ajax({
                            type: "POST",
                            url: "/get-product-list",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                companyId: '<?=$company->id?>',
                                categoryId: categories
                            },
                            success: function (msg) {
                                $('#product_list').html(msg);
                            }
                        });



                    }
                }).treeview('collapseAll');

                $('#product_list').delegate('.paginate a', 'click', function () {
                    event.preventDefault();
                    var a = $(this);
                    var url = a.attr("href");
                    var id = url.substring(url.lastIndexOf('=') + 1)

                    if (id.length) {
                        $.ajax({
                            type: "POST",
                            url: "/get-product-list?page=" + id,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                companyId: '<?=$company->id?>',
                                categoryId: categories
                            },
                            success: function (msg) {
                                $('#product_list').html(msg);
                            }
                        });

                    }

                });

            });



        $('#product_list').delegate('.editCategoryButton', 'click', function () {


            $('.form-group ').find('.productId').val('');

            event.preventDefault();
            var id = $(this).parents('tr').eq(0).find('.option').val();

            var inputs = $('.addProductCategory').find('[data-name]');
            inputs.each(function () {
                if ($(this).attr('data-name') != 'category_id') {
                    $(this).val('');
                }
            });

            $.ajax({
                type: "POST",
                url: "/products/edit-categoty",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    productId: id
                },
                success: function (msg) {

                    
                    $('.form-group').find('.product_id').val(msg.product.id);
                    $('.form-group').find('input[data-name="category_id"]').val(msg.product.category_id);
                    $('.form-group').find('input[data-name="category_name"]').val(msg.productCategory.title);
                    $('.form-group').find('input[data-name="product_id"]').val(msg.product.id);
                    $('.form-group').find('input[data-name="name"]').val(msg.product.product_name);
                    $('.form-group').find('input[data-name="description"]').val(msg.product.product_description);
                    $('.form-group').find('input[data-name="photo"]').val(msg.product.product_image);
                    $('.form-group').find('input[data-name="price"]').val(msg.product.product_price);

                    $('.addProductCategory').show();
                    $('#product_form').find('input.create').hide();
                    $('#product_form').find('input.update').show();

                    $('#product_form').find('input[type="text"]').eq(0).focus();


                }
            });

        });



            $('.table').delegate('.addCategoryProduct', 'click', function(){

                $('.addProductCategory').toggle();
                $('#product_form').find('input.update').hide();
                $('#product_form').find('input.create').show();

                var inputs = $('.addProductCategory').find('[data-name]');

                var categoryId = $('.table').find('.companyIdClass').val();
                var categoryTitle = $('.table').find('.companyTitleClass').val();

                  $('.product-editor').find('input[data-name="category_id"]').val(categoryId);
                    $('.product-editor').find('input[data-name="category_name"]').val(categoryTitle);


                inputs.each(function() {
                    if($(this).attr('data-name') != 'category_id' && $(this).attr('data-name') != 'category_name'){
                        $(this).val('');
                    }
                });
            });


        $('.update').on('click', function () {
            var buttom = $(this);
//            buttom.disable();


            event.preventDefault();

            var data = {};

            data['id'] = $('.form-group').find('input[data-name="product_id"]').val();
            data['name'] = $('.form-group').find('input[data-name="name"]').val();
            data['description'] = $('.form-group').find('input[data-name="description"]').val();
            data['photo'] = $('.form-group').find('input[data-name="photo"]').val();
            data['price'] = $('.form-group').find('input[data-name="price"]').val();

            $.ajax({
                type: "POST",
                url: "/products/ajax-update",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function (msg) {
//                    buttom.enable();

                    $('.addProductCategory').hide();
                    var currentTr = $('#product_list').find('.option[value="' + data.id + '"]').parents('tr').eq(0);

                    currentTr.after(msg);


                    currentTr.remove();

                }
            });

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
            $('.table').delegate('#destroycheck', 'click', function() {


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

@endsection

