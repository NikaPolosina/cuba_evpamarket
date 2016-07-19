@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')

    <div style="border: solid 2px darkgrey; padding: 10px;">
        <div class="table-responsive">
            <h1 style="text-align: center">{{ $company->company_name }} </h1>
            <hr>
        </div>

        <div class="row">
            <div class="col-md-3">

                <a id="addCategory" href="{{url('/category/category-setup', $company->id)}}">Добавить категорию</a>
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
            </div>
        </div>


        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <div id="myModal" class="mod modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Форма редактирования продуктов</h4>
                            </div>
                            <div class="modal-body">

                                <div class="row" adasd>
                                    <style>
                                        .my_form label{
                                            text-align: left;
                                        }

                                        .form-horizontal .control-label{
                                            text-align: left !important;
                                        }
                                    </style>
                                    <div class="col-sm-10 col-sm-offset-1">

                                        {!! Form::open(['class' => 'form-horizontal my_form', 'id'=> 'fileupload']) !!}
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
                                            <strong>Внимание!</strong> Категория товара не выбрана. Выбирите катигорию.
                                        </div>

                                        <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
                                            {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::text('product_name', NULL, ['class' => 'form-control', 'data-name' =>'name']) !!}

                                            <div style="display: none" class="error" data-id="name">
                                                <strong>Внимание!</strong> <span></span>
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                                            {!! Form::label('product_description', 'Краткое описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::text('product_description', NULL, ['class' => 'form-control', 'required' => 'required', 'data-name' =>'description']) !!}

                                            <div style="display: none" class="error" data-id="description">
                                                <strong>Внимание!</strong> <span></span>
                                            </div>
                                        </div>


                                        <div class="form-group {{ $errors->has('content') ? 'has-error' : ''}}">
                                            {!! Form::label('content', 'Полное описание: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::textarea('content', NULL, ['class' => 'form-control tiny', 'data-name' =>'content']) !!}
                                        </div>

                                        {!! Form::hidden('product_image', NULL, ['class' => 'form-control', 'data-name' =>'photo']) !!}

                                        <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
                                            {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}
                                            {!! Form::number('product_price', NULL, ['class' => 'form-control', 'data-name' =>'price', 'min'=>0]) !!}

                                            <div style="display: none"class="error" data-id="price">
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
                                                    <span>Добавить файл..</span>
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


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary submit_modal_form">Сохранить изменения</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>


        <div>

            <div>
                <!-- blueimp Gallery styles -->
                <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
                <!-- blueimp Gallery script -->
                <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
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

                <!--

                <a href="https://jquery-file-upload.appspot.com/image%2Fjpeg/1201873945/555.jpg" title="555.jpg" download="555.jpg" data-gallery="">
                    <img src="https://jquery-file-upload.appspot.com/image%2Fjpeg/1201873945/555.jpg.80x80.jpg">
                </a>

                -->


                <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
                <link rel="stylesheet" href="/plugins/file_uploader/css/jquery.fileupload.css">
                <link rel="stylesheet" href="/plugins/file_uploader/css/jquery.fileupload-ui.css">
                <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
                <script src="/plugins/file_uploader/js/vendor/jquery.ui.widget.js"></script>
                <!-- The Templates plugin is included to render the upload/download listings -->
                <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
                <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
                <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
                <!-- The Canvas to Blob plugin is included for image resizing functionality -->
                <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
                <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
                <script src="/plugins/file_uploader/js/jquery.iframe-transport.js"></script>
                <!-- The basic File Upload plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload.js"></script>
                <!-- The File Upload processing plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload-process.js"></script>
                <!-- The File Upload image preview & resize plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload-image.js"></script>
                <!-- The File Upload audio preview plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload-audio.js"></script>
                <!-- The File Upload video preview plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload-video.js"></script>
                <!-- The File Upload validation plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload-validate.js"></script>
                <!-- The File Upload user interface plugin -->
                <script src="/plugins/file_uploader/js/jquery.fileupload-ui.js"></script>
            </div>






            <script>

                var nededPath, productId, mainImg;
                $(function(){
                    $('#fileupload').fileupload({
                        url                : '{{route('file_uploader')}}',
                        previewMaxWidth    : 300,
                        previewMaxHeight   : 300,
                        filesContainer     : $('.files'),
                        uploadTemplateId   : null,
                        downloadTemplateId : null,
                        uploadTemplate     : null,
                        downloadTemplate   : null,
                        autoUpload         : true,
                    })
                    .on('fileuploadprocessalways', function(e, data){
                    })
                    .on('fileuploadadd', function(e, data){})
                    .on('fileuploadsubmit', function(e, data){data.formData = {path : nededPath};})
                    .on('fileuploaddone', function(e, data){

                            var row   = $('<tr class="template-upload">' +
                                    '<td>' +
                                    '<div>' +
                                    '<button class="btn btn-danger delete" data-type="DELETE" data-url="'+data.result.files[0]["deleteUrl"]+'&path='+nededPath+'"> Удалить </button>' +
                                    '<div>Главная <input class="product_image" name="qe" type="radio" value="'+data.result.files[0].name+'"></div>' +
                                    '</div>' +
                                    '<span class="preview"></span></td>' +
                                    '<div class="error"></div>' +
                                    '</td>' +
                                    '</tr>');
                            row.find('.preview').append(data.files[0].preview);
                            $('.files').append(row);

                    })
                    .on('fileuploaddestroy', function (e, data) {

                        if(productId){
                            if(confirm('Вы уверены чт хотите удалить картинку ? Если Вы это сделаете, то она навсегда удалится с вашего альбома.')){
                                $(data.context.context).parents('tr').eq(0).remove();
                            }else{
                                return false;
                            }
                        }else{
                            $(data.context.context).parents('tr').eq(0).remove();
                        }

                    })
                    .on('fileuploadfail', function(e, data){});
                });


                $(document).ready(function(){
                    /* Нажатие на кнопку изменить и создать новый*/
                    $('#product_list').delegate('.open', 'click', function(){
                        nededPath = 'temp/'+Date.now()+'/';
                        productId = false;
                        mainImg = '';
                        $('.mod').find('.form-group').find('input[data-name="product_id"]').val('');
                        $('.mod').find('.form-group').find('.product_id').val('');
                        $('.mod').find('.form-group').find('select[data-name="category_name"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="name"]').val('');
                        $('.mod').find('.form-group').find('textarea[data-name="description"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="content"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="photo"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="price"]').val('');
                        $('.files').html('');
                        var categoryId    = $('.table').find('.companyIdClass').val();
                        var categoryTitle = $('.table').find('.companyTitleClass').val();
                        var modalSelect   = $('.mod').find('select[data-name="category_name"]');
                        var modalSpan     = $('.mod').find('.modalSpan');
                        if(categoryId.length && modalSelect.find('option[value="' + categoryId + '"]').length){
                            modalSelect.val(categoryId);
                            modalSelect.hide();
                            modalSpan.html(categoryTitle).show();
                        }else{
                            modalSelect.show();
                            modalSpan.html('').hide();
                        }
                        if($(this).hasClass('edit')){
                            
                            var id     = $(this).parents('tr').eq(0).find('.option').val();
                            $.ajax({
                                type    : "POST",
                                url     : "/products/edit-categoty",
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {productId : id},
                                success : function(msg){

                                    mainImg = msg.product.product_image;

                                    $('.mod').find('select[name="category_name"]').hide();
                                    $('.mod').find('.modalSpan').text(msg.productCategory.title).show();
                                    $('.mod').find('.form-group').find('select[data-name="category_name"]').find("option[selected='selected']").attr('selected', false);
                                    $('.mod').find('.form-group').find('.product_id').val(msg.product.id);
                                    $('.mod').find('.form-group').find('select[data-name="category_name"]').val(msg.product.category_id);
                                    $('.mod').find('.form-group').find('input[data-name="product_id"]').val(msg.product.id);
                                    $('.mod').find('.form-group').find('input[data-name="name"]').val(msg.product.product_name);
                                    $('.mod').find('.form-group').find('input[data-name="description"]').val(msg.product.product_description);
                                    tinyMCE.activeEditor.setContent(msg.product.content);
                                    $('.mod').find('.form-group').find('input[data-name="photo"]').val(msg.product.product_image);
                                    $('.mod').find('.form-group').find('input[data-name="price"]').val(msg.product.product_price);
                                    $('.mod').find('#product_form').find('input[type="text"]').eq(0).focus();
                                    productId = msg.product.id;
                                    nededPath  = 'companies/<?=$company->id;?>'+'/products/'+msg.product.id+'/';
                                    $.ajax({
                                        url      : $('#fileupload').fileupload('option', 'url'),
                                        dataType : 'json',
                                        context  : $('#fileupload')[0],
                                        data     : {
                                            image : [],
                                            path  : nededPath
                                        }
                                    }).done(function(result){

                                        if(result.files.length){
                                            result.files.forEach(function(value){
                                                var row   = $('<tr class="template-upload">' +
                                                        '<td>' +
                                                        '<div>' +
                                                        '<button class="btn btn-danger delete ask" data-type="DELETE" data-url="'+value["deleteUrl"]+'&path='+nededPath+'"> Удалиь </button>' +
                                                        '<div>Главная <input '+((value.name  == mainImg)?'checked':'' )+' class="product_image" name="qe" type="radio" value="'+value.name+'"></div>' +
                                                        '</div>' +
                                                        '<span class="preview"></span></td>' +
                                                        '<div class="error"></div>' +
                                                        '</td>' +
                                                        '</tr>');
                                                row.find('.preview').append('<img src="'+value.thumbnailUrl+'">');
                                                $('.files').append(row);

                                            });
                                        }


                                    });

                                    $('.mod').modal();

                                }
                            });

                        }else{
                            $('.mod').modal();
                        }

                    });
                    /* Выбор главной картинки (чекпоинт)*/
                    $('body').delegate('.product_image', 'change', function(){
                        $('.mod').find('form').find('input[name="product_image"]').val($(this).val());
                    });
                    /* Сохранение (кнопка сохранить изминения) изменения товаров при нажатии на кнопку (изменить)*/
                    $('.submit_modal_form').on('click', function(){
                        var modForm = $('.mod').find('form');
                        if(modForm.length){
                            var data = {};
                            var inputs    = $('.mod').find('[data-name]');
                            inputs.each(function(){
                                data[$(this).attr('data-name')] = $(this).val();
                            });
                            data.content = tinyMCE.activeEditor.getContent();
                            if(data.name.length == 0){
                                $('[data-name="name"]').focus();
                                return false;
                            }
                              if(data.description.length == 0){
                                    $('[data-name="description"]').focus();
                                    return false;
                                }
                            if(data.category_name.length == 0){
                                $('.mod').find('.msgDenger').show();
                                return false;
                            }else{
                                $('.mod').find('.msgDenger').hide();
                            }


                            $('div.error').hide();

                            var path = '/products-category';
                            var update = false;
                            if(data.product_id.length > 0){
                                path = '/products/ajax-update';
                                update = true;
                            }

                            if(!productId)
                                data.filesPath = nededPath;
                            $.ajax({
                                type    : "POST",
                                url     : path,
                                headers : {
                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                },
                                data    : {
                                    company_id : '<?=$company->id?>',
                                    product    : data
                                },
                                success : function(data){
                                    if(data.error){
                                        $.each(data.error, function( index, value ) {

                                            $('div[data-id="'+index+'"]').find('span').text(value);
                                            $('div[data-id="'+index+'"]').show();
                                        });
                                        return false;
                                    }
                                    var tr = $(data);
                                    var id = tr.find('.option').val();

                                    if(update){
                                        var old = $('.tBody').find('.option[value="'+id+'"]').parents('tr').eq(0);
                                        old.after(tr);
                                        old.remove();

                                        $('[data-name="description"]').val('');
                                        tinyMCE.activeEditor.setContent('');

                                    }else{
                                        $('.tBody').append(tr);
                                        inputs.each(function(){
                                            if($(this).attr('data-name') != 'category_name'){
                                                $(this).val('');
                                            }
                                        });
                                    }
                                    
                                    $('.mod').modal('hide');
                                }
                            });

                        }
                        /*На закрытие модалки чистим все поля формы*/
                        $('#myModal').on('hidden.bs.modal', function (e) {
                            inputs.each(function(){
                                if($(this).attr('data-name') != 'category_name'){
                                    $(this).val('');
                                }
                            });
                            $('[data-name="description"]').val('');
                            tinyMCE.activeEditor.setContent('');
                        })

                    });

                });

            </script>


        </div>

        <script>

            var categories      = [];
            var currentCategory = null;
            var data            = <?=$category?>;
            var images          = [];

            $(document).ready(function(){



                /*---------------------Работа с катигориями-----------------------*/
                $('#custom-checkable').treeview({

                    data            : data,
                    showCheckbox    : true,
                    enableLinks     : false,
                    onNodeChecked   : function(event, node){

                        $('#custom-checkable').treeview('selectNode', node.nodeId);
                        categories = [];
                        $('#product_list').html('');
                        var list = $('#custom-checkable').treeview('getChecked');
                        if(list.length > 1){
                            var tree = $('#custom-checkable').treeview(true);
                            list.forEach(function(element){
                                if(node.href != element.href){
                                    tree.uncheckNode(element, {silent : true});
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
                            type    : "POST",
                            url     : "/get-product-list",
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : {
                                companyId  : '<?=$company->id?>',
                                categoryId : categories
                            },
                            success : function(msg){
                                $('#product_list').html(msg);
                            }
                        });
                    },
                    onNodeUnchecked : function(event, node){

                        $('#custom-checkable').treeview('unselectNode', node.nodeId);

                        $('.product_category').val('')
                        $('#product_list').html('');
                        categories      = [];
                        currentCategory = null;
                        $.ajax({
                            type    : "POST",
                            url     : "/get-product-list",
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : {
                                companyId  : '<?=$company->id?>',
                                categoryId : categories
                            },
                            success : function(msg){
                                $('#product_list').html(msg);
                            }
                        });
                    },
                    onNodeSelected: function(event, node){
                        $('#custom-checkable').treeview('checkNode', node.nodeId);
                    },
                    onNodeUnselected: function(event, node){
                        $('#custom-checkable').treeview('uncheckNode', node.nodeId);
                    }
                }).treeview('collapseAll');

                $('#product_list').delegate('.paginate a', 'click', function(){
                    event.preventDefault();
                    var a   = $(this);
                    var url = a.attr("href");
                    var id  = url.substring(url.lastIndexOf('=') + 1)
                    if(id.length){
                        $.ajax({
                            type    : "POST",
                            url     : "/get-product-list?page=" + id,
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : {
                                companyId  : '<?=$company->id?>',
                                categoryId : categories
                            },
                            success : function(msg){
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
                    type    : "POST",
                    url     : "/products/destroy-check",
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    data    : {
                        id      : '<?=$company?>',
                        checkId : selected
                    },
                    success : function(msg){
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
                    type    : "POST",
                    url     : "/destroy",
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    data    : {
                        id : productId
                    },
                    success : function(msg){
                        tr.remove();
                    }
                });
            });

        </script>
        {!! HTML::script('/plugins/tinymce/tinymce_init.js') !!}
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

        <style>

            .error{
                color: red;
            }

        </style>
@endsection

