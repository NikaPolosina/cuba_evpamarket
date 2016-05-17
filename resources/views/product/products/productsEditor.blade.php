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

                <a id="addCategory" style="border: solid 1px gainsboro; padding: 2px; text-decoration: none; " href="">Добавить категорию</a>
                <a class="" style="border: solid 1px gainsboro; padding: 2px; text-decoration: none; " href="">Создать категорию</a>

                <div class="allCategoryBlock" style="display: none">
                    <div style="display: none" class="selectCategory">
                        <h4>Выбранные категории</h4>
                        <ul data-id="select_input"> </ul>

                        <button type="submit" style="float: right" class="addCategoryCompany btn btn-primary btn-xs">Добавить</button>

                    </div>
                    <h4>Все категории</h4>
                    <div id="custom-checkable1" class="">


                    </div>
                </div>

        <script>

            var a = $('.allCategoryBlock').find('.selectCategory');
            var ul = a.find('ul[data-id="select_input"]');

            $('#addCategory').on('click', function () {
                event.preventDefault();
                $('.allCategoryBlock').toggle();
                var data = <?=$categories?>

                        $('#custom-checkable1').treeview({
                            data: data,
                            showCheckbox: true,
                            enableLinks: true,
                            onNodeChecked: function(event, node) {
                                a.show();
                                ul.append('<li><input checked="checked" type="checkbox" value="'+node.id+'"/>'+ node.text+ '</li>');
                            },
                            onNodeUnchecked: function (event, node) {
                                ul.find('input[value="'+node.id+'"]').parent().remove();
                                if(ul.find('input').length < 1){
                                    a.hide();
                                }
                                console.log(node.text + ' was unchecked');
                            }
                        }).treeview('collapseAll');
            });
            $('.addCategoryCompany').on('click', function(){
                var inputs = ul.find("input:checked");
                var categories = [];
                inputs.each(function () {
                    categories.push($(this).val());
                });

                $.ajax({
                    type: "POST",
                    url: "/attach-category-to-company",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        companyId: '<?=$company->id?>',
                        categories: categories
                    },
                    success: function (msg) {
                        location.reload();


                        $('.allCategoryBlock').hide();



                    }
                });


                
            })


        </script>


                <hr>
                <h4>Мои категории</h4>
                <div class="allCategory form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">

                    <div id="custom-checkable" class="">



                    </div>

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

                           {{-- <input type="hidden" name="product_id" value="" data-name="product_id"/>--}}

                            <div style="display: none" class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
                                {!! Form::label('product_id', 'Id: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('product_id', null, ['class' => 'form-control', 'data-name' =>'product_id']) !!}
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('category_name') ? 'has-error' : ''}}">
                                {!! Form::label('category_name', 'Категория: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    <select   name="category_name"  data-name="category_name">
                                        @if(count($myCategories))

                                        @foreach($myCategories as $value)
                                                <option  value="{{$value['id']}}">{{$value['title']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
                                {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('product_name', null, ['class' => 'form-control', 'data-name' =>'name']) !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                                {!! Form::label('product_description', 'Краткое описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('product_description', null, ['class' => 'form-control', 'required' => 'required', 'data-name' =>'description']) !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                                {!! Form::label('content', 'Полное описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('content', null, ['class' => 'form-control', 'data-name' =>'content']) !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('product_image') ? 'has-error' : ''}}">
                                {!! Form::label('product_image', 'Фото: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('product_image', null, ['class' => 'form-control', 'data-name' =>'photo']) !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
                                {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::number('product_price', null, ['class' => 'form-control', 'data-name' =>'price']) !!}
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-3">
                                    {!! Form::submit('Создать', ['class' => 'create btn btn-primary form-control']) !!}
                                    {!! Form::submit('Обновить', ['class' => 'update btn btn-primary form-control']) !!}
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
            var currentCategory = null;
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

                        currentCategory = node['id'];
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
                        currentCategory = null;

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

                $('.update').on('click', function () {
                    var buttom = $(this);
        //            buttom.disable();

                    event.preventDefault();
                    var data = {};

                    data['id'] = $('.form-group').find('input[data-name="product_id"]').val();
                    data['name'] = $('.form-group').find('input[data-name="name"]').val();
                    data['description'] = $('.form-group').find('input[data-name="description"]').val();
                    data['content'] = $('.form-group').find('input[data-name="content"]').val();
                    data['photo'] = $('.form-group').find('input[data-name="photo"]').val();
                    data['price'] = $('.form-group').find('input[data-name="price"]').val();
                    data['category_name'] = $('.form-group').find('select[data-name="category_name"]').val();

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

                $('.create').on('click', function(){
                    event.preventDefault();

                    var selected1 = {};
                    var inputs = $('.addProductCategory').find('[data-name]');

                    inputs.each(function() {
                        selected1[$(this).attr('data-name')] = $(this).val();
                    });

                    if(selected1.name.length == 0){
                        $('[data-name="name"]').focus();
                        return false;
                    }

                    $.ajax({
                        type: "POST",
                        url: "/products-category",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            company_id: '<?=$company->id?>',
                            product: selected1
                        },
                        success: function(data){
                            $('.tBody').append(data);

                            inputs.each(function() {
                                if($(this).attr('data-name') != 'category_name'){
                                    $(this).val('');
                                }
                            });

                            $('.addCategoryProduct').click();
                        }
                    });
                });

            });

            $('#product_list').delegate('.editCategoryButton', 'click', function () {
            $('.form-group ').find('.productId').val('');
            event.preventDefault();
            var id = $(this).parents('tr').eq(0).find('.option').val();
            var inputs = $('.addProductCategory').find('[data-name]');
            inputs.each(function () {
                if ($(this).attr('data-name') != 'category_name') {
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
                    $('.form-group').find('select[data-name="category_name"]').find("option[selected='selected']").attr('selected', false);
                    $('.form-group').find('.product_id').val(msg.product.id);
                    $('.form-group').find('select[data-name="category_name"]').val(msg.product.category_id);
                    $('.form-group').find('input[data-name="product_id"]').val(msg.product.id);
                    $('.form-group').find('input[data-name="name"]').val(msg.product.product_name);
                    $('.form-group').find('input[data-name="description"]').val(msg.product.product_description);
                    $('.form-group').find('input[data-name="content"]').val(msg.product.content);
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
                    if( $(this).attr('data-name') != 'category_name'){
                        $(this).val('');
                    }
                });

                $('select[data-name="category_name"]').val(currentCategory);

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
            $('#product_list').delegate('.deleteCategoryButton', 'click', function () {
                event.preventDefault();
                var tr = $(this).parents('tr');
                var productId = tr.find('input[name="option"]').val();

                $.ajax({
                    type: "POST",
                    url: "/destroy",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: productId
                    },
                    success: function(msg){
                            tr.remove();
                    }
                });
            });


        </script>

@endsection

