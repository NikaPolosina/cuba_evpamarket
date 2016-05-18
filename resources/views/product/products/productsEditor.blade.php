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
                {{-----------------------------------------------------------}}

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content col-md-10 col-sm-offset-1">
                            <div class="modal-header">
                                <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Добавление товара</h4>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                <button type="button" class="btn create btn-primary">Создать</button>
                                <button type="button" class="btn update btn-primary">Обновить</button>






                            </div>
                        </div>
                    </div>
                </div>

{{-----------------------------------------------------------------}}




                <div class="table" id="product_list">
                    @include('product.products.productEditorList', array(
                                    'products' => $company->getProducts()->paginate($paginCnt),
                                    'category' => false
                                     ))
                </div>
<div style="display: none;">
                <div class="product-editor">
                    <div class="col-sm-12">
                        <div class="row">
                            <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                                <div style="display: block">
                                    <div class="col-sm-4">

                                                <div class="addProductCategory">
                                                {!! Form::open(['class' => 'form-horizontal ', 'id'=> 'product_form']) !!}
                                                <div style="display: none" class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
                                                    {!! Form::label('product_id', 'Id: ', ['class' => 'control-label']) !!}
                                                    {!! Form::text('product_id', null, ['class' => 'form-control', 'data-name' =>'product_id']) !!}
                                                </div>
                                                <div class="form-group {{ $errors->has('category_name') ? 'has-error' : ''}}">
                                                    {!! Form::label('category_name', 'Категория: ', ['class' => 'col-sm-3 control-label']) !!}
                                                        <select   name="category_name"  data-name="category_name">
                                                            @if(count($myCategories))

                                                            @foreach($myCategories as $value)
                                                                    <option  value="{{$value['id']}}">{{$value['title']}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    <span class="modalSpan" ></span>
                                                </div>
                                                <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
                                                    {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
                                                    {!! Form::text('product_name', null, ['class' => 'form-control', 'data-name' =>'name']) !!}
                                                </div>
                                                <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                                                    {!! Form::label('product_description', 'Краткое описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                                    {!! Form::text('product_description', null, ['class' => 'form-control', 'required' => 'required', 'data-name' =>'description']) !!}
                                                </div>
                                                <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                                                    {!! Form::label('content', 'Полное описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                                    {!! Form::text('content', null, ['class' => 'form-control', 'data-name' =>'content']) !!}
                                                </div>




                                                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                                                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                <span style="font-weight: 700;">Фото:</span>
                                                <div class="row fileupload-buttonbar" style="float: right;">

                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                               <span class="btn btn-success fileinput-button">
                                                                   <i class="glyphicon glyphicon-plus"></i>
                                                                   <span>Add files...</span>
                                                                   <input type="file" name="files[]" multiple>
                                                               </span>
                                                  {{--  <button type="submit" class="btn btn-primary start">
                                                        <i class="glyphicon glyphicon-upload"></i>
                                                        <span>Start upload</span>
                                                    </button>--}}
                                                    <button type="reset" class="btn btn-warning cancel">
                                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                                        <span>Cancel upload</span>
                                                    </button>
                                                    <button type="button" class="btn btn-danger delete">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                    <input type="checkbox" class="toggle">
                                                    <!-- The global file processing state -->
                                                    <span class="fileupload-process"></span>


                                                </div>

                                                <!-- The global progress state -->
                                                <div style="display: none;" class="col-lg-5 fileupload-progress fade">
                                                    <!-- The global progress bar -->
                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                    </div>
                                                    <!-- The extended global progress state -->
                                                    <div class="progress-extended">&nbsp;</div>
                                                </div>

                                                <!-- The table listing the files available for upload/download -->
                                                <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>





                                                    <div class="form-group {{ $errors->has('product_image') ? 'has-error' : ''}}">
                                                        {!! Form::label('product_image', 'Фото: ', ['class' => 'col-sm-3 control-label']) !!}

                                                            {!! Form::text('product_image', null, ['class' => 'form-control', 'data-name' =>'photo']) !!}

                                                    </div>
                                                    <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
                                                        {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}

                                                            {!! Form::number('product_price', null, ['class' => 'form-control', 'data-name' =>'price']) !!}

                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-3 col-sm-3">

                                                        </div>
                                                    </div>

                                                    </div>
                                                            {!! Form::close() !!}
                                     </div>
                                </div>
                            </form>
                        </div>



                        <!-- The blueimp Gallery widget -->
                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                            <div class="slides"></div>
                            <h3 class="title"></h3>
                            <a class="prev">‹</a>
                            <a class="next">›</a>
                            <a class="close">×</a>
                            <a class="play-pause"></a>
                            <ol class="indicator"></ol>
                        </div>


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

                $('#myModal').modal({show:false});

                $('#custom-checkable').treeview({
                    data: data,
                    showCheckbox: true,
                    enableLinks: true,
                    onNodeChecked: function (event, node) {
                       /* $('.addProductCategory').hide();//ertyuiosdfghkwertyuierty*/
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

                $('#myModal').delegate('.update', 'click', function () {
                    event.preventDefault();
                    var data = {};
                    data['id'] = $('#myModal').find('.form-group').find('input[data-name="product_id"]').val();
                    data['name'] =  $('#myModal').find('.form-group').find('input[data-name="name"]').val();
                    data['description'] =  $('#myModal').find('.form-group').find('input[data-name="description"]').val();
                    data['content'] =  $('#myModal').find('.form-group').find('input[data-name="content"]').val();
                    data['photo'] =  $('#myModal').find('.form-group').find('input[data-name="photo"]').val();
                    data['price'] =  $('#myModal').find('.form-group').find('input[data-name="price"]').val();
                    data['category_name'] =  $('#myModal').find('.form-group').find('select[data-name="category_name"]').val();

                    $.ajax({
                        type: "POST",
                        url: "/products/ajax-update",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: data,
                        success: function (msg) {
                            $('#myModal').find('.close').click();
                           /* $('.addProductCategory').hide();*/
                            var currentTr = $('#product_list').find('.option[value="' + data.id + '"]').parents('tr').eq(0);
                            currentTr.after(msg);
                            currentTr.remove();
                        }
                    });

                });

                $('#myModal').delegate('.create', 'click', function (){
                    event.preventDefault();
                    var selected1 = {};

                    var inputs = $('#myModal').find('.addProductCategory').find('[data-name]');
                     var img = $('.files');





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

                            $('#myModal').modal('hide');








                        }
                    });
                });

            });

            $('#product_list').delegate('.chang-product', 'click', function () {
                
                $('#myModal').modal('show');
                $('#myModal').find('.modal-body').html($('.addProductCategory'));
                $('#myModal').find('.create').hide();
                $('#myModal').find('.update').show();
                $('#myModal').find('.form-group ').find('.productId').val('');

            event.preventDefault();
            var id = $(this).parents('tr').eq(0).find('.option').val();
            var inputs =  $('#myModal').find('.addProductCategory').find('[data-name]');
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

                    $('#myModal').find('.form-group').find('select[data-name="category_name"]').find("option[selected='selected']").attr('selected', false);
                    $('#myModal').find('.form-group').find('.product_id').val(msg.product.id);
                    $('#myModal').find('.form-group').find('select[data-name="category_name"]').val(msg.product.category_id);
                    $('#myModal').find('.form-group').find('input[data-name="product_id"]').val(msg.product.id);
                    $('#myModal').find('.form-group').find('input[data-name="name"]').val(msg.product.product_name);
                    $('#myModal').find('.form-group').find('input[data-name="description"]').val(msg.product.product_description);
                    $('#myModal').find('.form-group').find('input[data-name="content"]').val(msg.product.content);
                    $('#myModal').find('.form-group').find('input[data-name="photo"]').val(msg.product.product_image);
                    $('#myModal').find('.form-group').find('input[data-name="price"]').val(msg.product.product_price);
                    $('#myModal').find('.addProductCategory').show();
                    $('#myModal').find('#product_form').find('input.create').hide();
                    $('#myModal').find('#product_form').find('input.update').show();
                    $('#myModal').find('#product_form').find('input[type="text"]').eq(0).focus();
                }
            });
        });

            $('.table').delegate('.add-new-product', 'click', function(){

                $('#myModal').modal('show');

                $('#myModal').find('.modal-body').html($('.addProductCategory'));
                $('#myModal').find('.create').show();
                $('#myModal').find('.update').hide();


                $('#myModal').find('.modal-body').html($('.addProductCategory'));

                var inputs = $('#myModal').find('.addProductCategory').find('[data-name]');
                inputs.each(function() {
                    if( $(this).attr('data-name') != 'category_name'){
                        $(this).val('');
                    }
                });

                $('#product_form').find('input.update').hide();
                $('#product_form').find('input.create').show();
                var inputs = $('.addProductCategory').find('[data-name]');

                var categoryId = $('.table').find('.companyIdClass').val();
                var categoryTitle = $('.table').find('.companyTitleClass').val();

                var modalSelect = $('#myModal').find('select[data-name="category_name"]');
                var modalSpan = $('#myModal').find('.modalSpan');
                if(categoryId.length && modalSelect.find('option[value="'+categoryId+'"]').length){
                    console.log(modalSelect);

                        modalSelect.val(categoryId);
                        modalSelect.hide();
                    modalSpan.html(categoryTitle).show();
                }else{
                    modalSelect.show();
                    modalSpan.html('').hide();
                }

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

