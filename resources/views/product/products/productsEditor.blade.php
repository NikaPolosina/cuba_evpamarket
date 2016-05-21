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
                        <ul data-id="select_input"></ul>
                        <button type="submit" style="float: right" class="addCategoryCompany btn btn-primary btn-xs">Добавить</button>
                    </div>
                    <h4>Все категории</h4>
                    <div id="custom-checkable1" class="">
                    </div>
                </div>

                <script>
                    var a  = $('.allCategoryBlock').find('.selectCategory');
                    var ul = a.find('ul[data-id="select_input"]');
                    $('#addCategory').on('click', function(){
                        event.preventDefault();
                        $('.allCategoryBlock').toggle();
                        var data = <?=$categories?>

                        $('#custom-checkable1').treeview({
                            data:data,
                            showCheckbox:true,
                            enableLinks:true,
                            onNodeChecked:function(event, node){
                                a.show();
                                ul.append('<li><input checked="checked" type="checkbox" value="' + node.id + '"/>' + node.text + '</li>');
                            },
                            onNodeUnchecked:function(event, node){
                                ul.find('input[value="' + node.id + '"]').parent().remove();
                                if(ul.find('input').length < 1){
                                    a.hide();
                                }
                                console.log(node.text + ' was unchecked');
                            }
                        }).treeview('collapseAll');
                    });
                    $('.addCategoryCompany').on('click', function(){
                        var inputs     = ul.find("input:checked");
                        var categories = [];
                        inputs.each(function(){
                            categories.push($(this).val());
                        });
                        $.ajax({
                            type:"POST",
                            url:"/attach-category-to-company",
                            headers:{
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                companyId:'<?=$company->id?>',
                                categories:categories
                            },
                            success:function(msg){
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
                                <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
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

                    <div class="col-sm-12">
                        <div class="row">


                            <div style="display: block">
                                <div class="col-sm-4">

                                    <div class="addProductCategory">

                                        {!! Form::open(['class' => 'form-horizontal ', 'id'=> 'product_form']) !!}
                                        <div style="display: none" class="form-group {{ $errors->has('id') ? 'has-error' : ''}}">
                                            {!! Form::label('product_id', 'Id: ', ['class' => 'control-label']) !!}
                                            {!! Form::text('product_id', NULL, ['class' => 'form-control', 'data-name' =>'product_id']) !!}
                                        </div>
                                        <div class="form-group {{ $errors->has('category_name') ? 'has-error' : ''}}">
                                            {!! Form::label('category_name', 'Категория: ', ['class' => 'col-sm-3 control-label']) !!}
                                            <select name="category_name" data-name="category_name">
                                                @if(count($myCategories))
                                                    <option value="">Выбирите категорию</option>
                                                    @foreach($myCategories as $value)
                                                        <option value="{{$value['id']}}">{{$value['title']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="modalSpan"></span>
                                        </div>

                                        <div class="msgDenger alert alert-danger" style="display: none;">
                                            <strong>Внимание!</strong> Выбирите катигорию.
                                        </div>


                                        <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
                                            {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::text('product_name', NULL, ['class' => 'form-control', 'data-name' =>'name']) !!}
                                        </div>
                                        <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                                            {!! Form::label('product_description', 'Краткое описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::text('product_description', NULL, ['class' => 'form-control', 'required' => 'required', 'data-name' =>'description']) !!}
                                        </div>
                                        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                                            {!! Form::label('content', 'Полное описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::text('content', NULL, ['class' => 'form-control', 'data-name' =>'content']) !!}
                                        </div>

                                        {!! Form::hidden('product_image', NULL, ['class' => 'form-control', 'data-name' =>'photo']) !!}

                                        <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
                                            {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}

                                            {!! Form::number('product_price', NULL, ['class' => 'form-control', 'data-name' =>'price']) !!}

                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-3 col-sm-3">

                                            </div>
                                        </div>


                                        {!! Form::close() !!}



















                                        <div style="border: solid ">


                                            <div class="container">
                                                <!-- The file upload form used as target for the file upload widget -->
                                                <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                                                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                                    <noscript>
                                                        <input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/">
                                                    </noscript>
                                                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                    <div class="row fileupload-buttonbar">
                                                        <div class="col-lg-7">
                                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                <span class="btn btn-success fileinput-button">
                                                    <i class="glyphicon glyphicon-plus"></i>
                                                    <span>Добавить файл...</span>
                                                    <input type="file" name="files[]" multiple>
                                                </span>
                                                            <button type="submit" class="btn btn-primary start">
                                                                <i class="glyphicon glyphicon-upload"></i>
                                                                <span>Начать загрузку</span>
                                                            </button>
                                                            <button type="reset" class="btn btn-warning cancel">
                                                                <i class="glyphicon glyphicon-ban-circle"></i>
                                                                <span>Отменить загрузку</span>
                                                            </button>
                                                            <button type="button" class="btn btn-danger delete">
                                                                <i class="glyphicon glyphicon-trash"></i>
                                                                <span>Удалить</span>
                                                            </button>
                                                            <input type="checkbox" class="toggle">
                                                            <!-- The global file processing state -->
                                                            <span class="fileupload-process"></span>
                                                        </div>
                                                        <!-- The global progress state -->
                                                      {{--  <div class="col-lg-5 fileupload-progress fade">
                                                            <!-- The global progress bar -->
                                                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                            </div>
                                                            <!-- The extended global progress state -->
                                                            <div class="progress-extended">&nbsp;</div>
                                                        </div>--}}
                                                    </div>
                                                    <!-- The table listing the files available for upload/download -->
                                                    <table style=" width: 50%;" role="presentation" class="table table-striped">
                                                        <tbody class="files"></tbody>
                                                    </table>
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

                                            <style>

                                                .form-control{
                                                    width: 75%;
                                                }
                                            </style>

<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Загрузить</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Отменить</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Удалить</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Отменить</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}






                                </script>

                                        </div>







                                        <?php
                                        //                                                $files = json_encode(array('test small 64.jpg'));
                                        $files = json_encode(array());
                                        $path = '';
                                        ?>

                                        <script>
                                            $(function(){

                                                'use strict';
                                                $('#fileupload').fileupload({
                                                    url:"{{route('file_uploader')}}"
                                                });
                                                $('#fileupload').fileupload(
                                                        'option',
                                                        'redirect',
                                                        window.location.href.replace(
                                                                /\/[^\/]*$/,
                                                                '/cors/result.html?%s'
                                                        )
                                                );
                                                $('#fileupload').bind('fileuploadcompleted', function(e, data){

                                                    console.log('fileuploadcompleted = '+images.length);

                                                    if(data.result['files'].length){

                                                        var ch = true;

                                                        images.forEach(function(item, i, images) {

                                                            console.log('=========');
                                                            console.log(data.result['files'][0]['name']);
                                                            console.log(item.name);
                                                            console.log('=========');

                                                            if(data.result['files'][0]['name'] == item.name){
                                                                ch = false;
                                                            }
                                                        });

                                                        if(ch){
                                                            var image_arr = {};
                                                            image_arr['name'] = data.result['files'][0]['name'];
                                                            image_arr['url'] = data.result['files'][0]['deleteUrl'];
                                                            images.push(image_arr);
                                                        }

                                                    }
                                                });

                                                $('#fileupload').bind('fileuploaddestroy', function (e, data) {

                                                    console.log('fileuploaddestroy = '+images.length);


                                                    if(images.length){
                                                        images.forEach(function(item, i, images) {

                                                            console.log('===================');
                                                            console.log(data['url']);
                                                            console.log(item.url);
                                                            console.log('===================');


                                                            if(data['url'] == item.url){
                                                                images.splice(i, 1);
                                                            }
                                                        });
                                                    }
                                                });



                                            });
                                        </script>



                                    </div>










                                </div>



                            </div>




                        </div>
                    </div>
                </div>


            </div>
        </div>

        <script>
            var categories      = [];
            var currentCategory = null;
            var data            = <?=$category?>;
            var images = [];
            $(document).ready(function(){


                $('.table').delegate('.add-new-product', 'click', function(){
                    images = [''];
                    $('#fileupload table tbody tr.template-upload').remove();
                    $('#fileupload table tbody tr.template-download').remove();

                    $('#myModal').modal('show');
                    $('#myModal').find('.modal-body').html($('.addProductCategory'));
                    $('#myModal').find('.create').show();
                    $('#myModal').find('.update').hide();
                    $('#myModal').find('.modal-body').html($('.addProductCategory'));
                    var inputs = $('#myModal').find('.addProductCategory').find('[data-name]');
                    inputs.each(function(){
                        if($(this).attr('data-name') != 'category_name'){
                            $(this).val('');
                        }
                    });
                    $('#product_form').find('input.update').hide();
                    $('#product_form').find('input.create').show();
                    var inputs        = $('.addProductCategory').find('[data-name]');
                    var categoryId    = $('.table').find('.companyIdClass').val();
                    var categoryTitle = $('.table').find('.companyTitleClass').val();
                    var modalSelect   = $('#myModal').find('select[data-name="category_name"]');
                    var modalSpan     = $('#myModal').find('.modalSpan');
                    if(categoryId.length && modalSelect.find('option[value="' + categoryId + '"]').length){
                        modalSelect.val(categoryId);
                        modalSelect.hide();
                        modalSpan.html(categoryTitle).show();
                    }else{
                        modalSelect.show();
                        modalSpan.html('').hide();
                    }



                    $('#fileupload').addClass('fileupload-processing');
                    $.ajax({
                        url:$('#fileupload').fileupload('option', 'url'),
                        dataType:'json',
                        context:$('#fileupload')[0],
                        data:{
                            image:images,
                            'path':'<?=$path?>'
                        },
                    }).always(function(){
                        $(this).removeClass('fileupload-processing');
                    }).done(function(result){
//                        console.log(result);
                        $(this).fileupload('option', 'done')
                                .call(this, $.Event('done'), {result:result});

                    });
                    images = [];


                });




                $('#product_list').delegate('.chang-product', 'click', function(){
                    images = [];
                    $('#fileupload table tbody tr.template-upload').remove();
                    $('#fileupload table tbody tr.template-download').remove();

                    $('#myModal').modal('show');
                    $('#myModal').find('.modal-body').html($('.addProductCategory'));
                    $('#myModal').find('.create').hide();
                    $('#myModal').find('.update').show();
                    $('#myModal').find('.form-group ').find('.productId').val('');
                    event.preventDefault();
                    var id     = $(this).parents('tr').eq(0).find('.option').val();
                    var inputs = $('#myModal').find('.addProductCategory').find('[data-name]');
                    inputs.each(function(){
                        if($(this).attr('data-name') != 'category_name'){
                            $(this).val('');
                        }
                    });
                    $('#myModal').find('.modalSpan').text('');
                    $.ajax({
                        type:"POST",
                        url:"/products/edit-categoty",
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            productId:id
                        },
                        success:function(msg){
                            console.log(msg.productCategory.title);
                            $('#myModal').find('select[name="category_name"]').hide();
                            $('#myModal').find('.modalSpan').text(msg.productCategory.title).show();
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


                            image = JSON.parse(msg.product.product_image);

                            if(image[0].name){
                                images = image;
                                image = [];
                                images.forEach(function(item, i, images) {
                                    image.push(item['name']);
                                });


                            }

                            $('#fileupload').addClass('fileupload-processing');
                            $.ajax({
                                url:$('#fileupload').fileupload('option', 'url'),
                                dataType:'json',
                                context:$('#fileupload')[0],
                                data:{
                                    image : image,
                                    'path': ''
                                },
                            }).always(function(){
                                $(this).removeClass('fileupload-processing');
                            }).done(function(result){

                                //                        console.log(result);
                                $(this).fileupload('option', 'done')
                                        .call(this, $.Event('done'), {result:result});

                            });

                        }
                    });
                });





                $('#myModal').delegate('.update', 'click', function(){
                    event.preventDefault();
                    var rec = '';
                    if(images.length){
                        rec = JSON.stringify(images);
                    }

                    var data              = {};
                    data['id']            = $('#myModal').find('.form-group').find('input[data-name="product_id"]').val();
                    data['name']          = $('#myModal').find('.form-group').find('input[data-name="name"]').val();
                    data['description']   = $('#myModal').find('.form-group').find('input[data-name="description"]').val();
                    data['content']       = $('#myModal').find('.form-group').find('input[data-name="content"]').val();
//                    data['photo']         = $('#myModal').find('.form-group').find('input[data-name="photo"]').val();
                    data['photo']         = rec;
                    data['price']         = $('#myModal').find('.form-group').find('input[data-name="price"]').val();
                    data['category_name'] = $('#myModal').find('.form-group').find('select[data-name="category_name"]').val();
                    images = [];
                    $.ajax({
                        type:"POST",
                        url:"/products/ajax-update",
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },
                        data:data,
                        success:function(msg){
                            $('#myModal').find('.close').click();
                            /* $('.addProductCategory').hide();*/
                            var currentTr = $('#product_list').find('.option[value="' + data.id + '"]').parents('tr').eq(0);
                            currentTr.after(msg);
                            currentTr.remove();
                        }
                    });
                });

                $('#myModal').delegate('.create', 'click', function(){

                    var rec = '';
                    if(images.length){
                        rec = JSON.stringify(images);
                    }


                    event.preventDefault();
                    var selected1 = {};
                    var inputs    = $('#myModal').find('.addProductCategory').find('[data-name]');
                    var img       = $('.files');
                    inputs.each(function(){
                        selected1[$(this).attr('data-name')] = $(this).val();
                    });
                    console.log(selected1);

                    if(selected1.name.length == 0){
                        $('[data-name="name"]').focus();
                        return false;
                    }
                    if(selected1.category_name.length == 0){
                        $('#myModal').find('.msgDenger').show();
                        return false;
                    }else{
                        $('#myModal').find('.msgDenger').hide();
                    }


                    selected1['photo'] = rec;
                    
                    console.log(selected1);


                    $.ajax({
                        type:"POST",
                        url:"/products-category",
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        },
                        data:{
                            company_id:'<?=$company->id?>',
                            product:selected1
                        },
                        success:function(data){
                            $('.tBody').append(data);
                            inputs.each(function(){
                                if($(this).attr('data-name') != 'category_name'){
                                    $(this).val('');
                                }
                            });
                            $('#myModal').modal('hide');
                        }
                    });
                });






                $('#myModal').modal({show:false});
                $('#custom-checkable').treeview({
                    data:data,
                    showCheckbox:true,
                    enableLinks:true,
                    onNodeChecked:function(event, node){
                        /* $('.addProductCategory').hide();//ertyuiosdfghkwertyuierty*/
                        categories = [];
                        $('#product_list').html('');
                        var list = $('#custom-checkable').treeview('getChecked');
                        if(list.length > 1){
                            var tree = $('#custom-checkable').treeview(true);
                            list.forEach(function(element){
                                if(node.href != element.href){
                                    tree.uncheckNode(element, {silent:true});
                                }
                            });
                        }
                        currentCategory = node['id'];
                        categories.push(node['id']);
                        if(node['nodes'].length > 0){
                            var childrens = node['nodes'];
                            do{
                                childrens.forEach(function(currentNode, key){
                                    categories.push(currentNode['id']);
                                    if(currentNode['nodes'].length > 0){
                                        currentNode['nodes'].forEach(function(nNode, k){
                                            childrens.push(nNode);
                                        });
                                    }
                                    childrens.splice(key, 1);
                                });
                            }while(childrens.length > 0);
                        }
                        $.ajax({
                            type:"POST",
                            url:"/get-product-list",
                            headers:{
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                companyId:'<?=$company->id?>',
                                categoryId:categories
                            },
                            success:function(msg){
                                $('#product_list').html(msg);
                            }
                        });
                    },
                    onNodeUnchecked:function(event, node){
                        $('.product_category').val('')
                        $('#product_list').html('');
                        categories      = [];
                        currentCategory = null;
                        $.ajax({
                            type:"POST",
                            url:"/get-product-list",
                            headers:{
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                companyId:'<?=$company->id?>',
                                categoryId:categories
                            },
                            success:function(msg){
                                $('#product_list').html(msg);
                            }
                        });
                    }
                }).treeview('collapseAll');
                $('#product_list').delegate('.paginate a', 'click', function(){
                    event.preventDefault();
                    var a   = $(this);
                    var url = a.attr("href");
                    var id  = url.substring(url.lastIndexOf('=') + 1)
                    if(id.length){
                        $.ajax({
                            type:"POST",
                            url:"/get-product-list?page=" + id,
                            headers:{
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                companyId:'<?=$company->id?>',
                                categoryId:categories
                            },
                            success:function(msg){
                                $('#product_list').html(msg);
                            }
                        });
                    }
                });

            });




            $('.table').delegate('#destroycheck', 'click', function(){
                event.preventDefault();
                var selected = [];
                var inputs   = $('.tBody').find('input:checked');
                inputs.each(function(){
                    selected.push($(this).val());
                });
                $.ajax({
                    type:"POST",
                    url:"/products/destroy-check",
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    data:{
                        id:'<?=$company?>',
                        checkId:selected
                    },
                    success:function(msg){
                        inputs.each(function(){
                            $(this).parents('tr').eq(0).remove();
                        });
                    }
                });
            });
            $('#product_list').delegate('.deleteCategoryButton', 'click', function(){
                event.preventDefault();
                var tr        = $(this).parents('tr');
                var productId = tr.find('input[name="option"]').val();
                $.ajax({
                    type:"POST",
                    url:"/destroy",
                    headers:{
                        'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                    },
                    data:{
                        id:productId
                    },
                    success:function(msg){
                        tr.remove();
                    }
                });
            });

        </script>

        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


        <!-- Generic page styles -->
        <link rel="stylesheet" href="/plugins/file_uploader/css/style.css">
        <!-- blueimp Gallery styles -->
        <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="/plugins/file_uploader/css/jquery.fileupload.css">
        <link rel="stylesheet" href="/plugins/file_uploader/css/jquery.fileupload-ui.css">

        <!-- CSS adjustments for browsers with JavaScript disabled -->
        <noscript>
            <link rel="stylesheet" href="/plugins/file_uploader/css/jquery.fileupload-noscript.css">
        </noscript>
        <noscript>
            <link rel="stylesheet" href="/plugins/file_uploader/css/jquery.fileupload-ui-noscript.css">
        </noscript>

        {{--<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->--}}
        <script src="/plugins/file_uploader/js/vendor/jquery.ui.widget.js"></script>
        {{--<!-- The Templates plugin is included to render the upload/download listings -->--}}
        <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
        {{--<!-- The Load Image plugin is included for the preview images and image resizing functionality -->--}}
        <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
        {{--<!-- The Canvas to Blob plugin is included for image resizing functionality -->--}}
        <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
        {{--<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->--}}
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        {{--<!-- blueimp Gallery script -->--}}
        <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
        {{--<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->--}}
        <script src="/plugins/file_uploader/js/jquery.iframe-transport.js"></script>
        {{--<!-- The basic File Upload plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload.js"></script>
        {{--<!-- The File Upload processing plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload-process.js"></script>
        {{--<!-- The File Upload image preview & resize plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload-image.js"></script>
        {{--<!-- The File Upload audio preview plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload-audio.js"></script>
        {{--<!-- The File Upload video preview plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload-video.js"></script>
        {{--<!-- The File Upload validation plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload-validate.js"></script>
        {{--<!-- The File Upload user interface plugin -->--}}
        <script src="/plugins/file_uploader/js/jquery.fileupload-ui.js"></script>
        <!-- The main application script -->
    {{--<script src="/plugins/file_uploader/js/main.js"></script>--}}


@endsection

