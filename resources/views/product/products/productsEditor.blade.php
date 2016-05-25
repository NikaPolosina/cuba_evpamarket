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
                            data            : data,
                            showCheckbox    : true,
                            enableLinks     : false,
                            onNodeChecked   : function(event, node){
                                a.show();
                                ul.append('<li><input checked="checked" type="checkbox" value="' + node.id + '"/>' + node.text + '</li>');
                            },
                            onNodeUnchecked : function(event, node){
                                ul.find('input[value="' + node.id + '"]').parent().remove();
                                if(ul.find('input').length < 1){
                                    a.hide();
                                }
                                console.log(node.text + ' was unchecked');
                            }
                        }).treeview('collapseAll');
                    });
                    $('.addCategoryCompany').on('click', function(){
                        event.preventDefault();
                        var inputs     = ul.find("input:checked");
                        var categories = [];
                        inputs.each(function(){
                            categories.push($(this).val());
                        });
                        $.ajax({
                            type    : "POST",
                            url     : "/attach-category-to-company",
                            headers : {
                                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                            },
                            data    : {
                                companyId  : '<?=$company->id?>',
                                categories : categories
                            },
                            success : function(msg){
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
                                            <strong>Внимание!</strong> Категория товара не выбрана. Выбирите катигорию.
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


                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>
                </div>

            </div>

        </div>


        <div class="row">


            <div class="col-sm-8 col-sm-offset-2">

                <div class="mod modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                            </div>
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-sm-10 col-sm-offset-1" style="border: solid">


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

                var nededPath  = 'companies/<?=$company->id;?>';
                var imageObj   = [];
                var nededFiles = [];
                var defaultObj = [];
                var deleteObj  = [];
                var form;

                $(function(){
                    $('#fileupload').fileupload({
                        url                : '{{route('file_uploader')}}',
                        previewMaxWidth    : 300,
                        previewMaxHeight   : 300,
                        filesContainer     : $('.files'),
                        uploadTemplateId   : null,
                        downloadTemplateId : null,
                        uploadTemplate     : function(o){
                        },
                        downloadTemplate   : function(o){
                        }
                    })
                    .on('fileuploadprocessalways', function(e, data){
                        imageObj.push(data.files[0]);
                        var index = imageObj.length - 1;
                        var row   = $('<tr class="template-upload">' +
                                '<td>' +
                                '<div>' +
                                '<button class="cancel" data-id="' + index + '">Cancel</button>' +
                                '<input type="radio"  name="default_img" class="default_img" data-id="' + index + '">Set as default' +
                                '</div>' +
                                '<span class="preview"></span></td>' +
                                '<div class="error"></div>' +
                                '</td>' +
                                '</tr>');
                        row.find('.preview').append(data.files[0].preview);
                        if(data.files[0].error){
                            row.find('.error').text(data.files[0].error);
                        }
                        $('.files').append(row);
                        if(!form){
                            form       = data;
                            form.files = [];
                        }
                    })
                    .on('fileuploadadd', function(e, data){})
                    .on('fileuploadsubmit', function(e, data){data.formData = {path : nededPath};})
                    .on('fileuploaddone', function(e, data){})
                    .on('fileuploadfail', function(e, data){});
                });

                $(document).ready(function(){
                    $('#product_list').delegate('.open', 'click', function(){

                        $('.mod').find('.form-group').find('input[data-name="product_id"]').val('');
                        $('.mod').find('.form-group').find('.product_id').val('');
                        $('.mod').find('.form-group').find('select[data-name="category_name"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="name"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="description"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="content"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="photo"]').val('');
                        $('.mod').find('.form-group').find('input[data-name="price"]').val('');


                        imageObj   = [];
                        nededFiles = [];
                        defaultObj = [];
                        deleteObj  = [];
                        form = null;
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

                                    $('.mod').find('select[name="category_name"]').hide();
                                    $('.mod').find('.modalSpan').text(msg.productCategory.title).show();
                                    $('.mod').find('.form-group').find('select[data-name="category_name"]').find("option[selected='selected']").attr('selected', false);
                                    $('.mod').find('.form-group').find('.product_id').val(msg.product.id);
                                    $('.mod').find('.form-group').find('select[data-name="category_name"]').val(msg.product.category_id);
                                    $('.mod').find('.form-group').find('input[data-name="product_id"]').val(msg.product.id);
                                    $('.mod').find('.form-group').find('input[data-name="name"]').val(msg.product.product_name);
                                    $('.mod').find('.form-group').find('input[data-name="description"]').val(msg.product.product_description);
                                    $('.mod').find('.form-group').find('input[data-name="content"]').val(msg.product.content);
                                    $('.mod').find('.form-group').find('input[data-name="photo"]').val(msg.product.product_image);
                                    $('.mod').find('.form-group').find('input[data-name="price"]').val(msg.product.product_price);
                                    $('.mod').find('.addProductCategory').show();
                                    $('.mod').find('#product_form').find('input.create').hide();
                                    $('.mod').find('#product_form').find('input.update').show();
                                    $('.mod').find('#product_form').find('input[type="text"]').eq(0).focus();


                                    nededPath  = 'companies/<?=$company->id;?>'+'/products/'+msg.product.id+'/';

                                    $.ajax({
                                        url      : $('#fileupload').fileupload('option', 'url'),
                                        dataType : 'json',
                                        context  : $('#fileupload')[0],
                                        data     : {
                                            image : nededFiles,
                                            path  : nededPath
                                        }
                                    }).done(function(result){
                                        console.log(result);

                                        imageObj   = [];
                                        defaultObj = [];
                                        deleteObj  = [];
                                        if(result.files.length){
                                            result.files.forEach(function(value){
                                                defaultObj.push(value);
                                                var index = defaultObj.length - 1;
                                                var row   = $('<tr class="template-upload">' +
                                                        '<td>' +
                                                        '<div>' +
                                                        '<button class="delete" data-id="' + index + '">DELETE</button>' +
                                                        '</div>' +
                                                        '<span class="preview"></span></td>' +
                                                        '<div class="error"></div>' +
                                                        '</td>' +
                                                        '</tr>');
                                                row.find('.preview').append('<img src="' + value.thumbnailUrl + '">');
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
                    
                    
                    $('.submit_modal_form').on('click', function(){
                        

                        var modForm = $('.mod').find('form');
                        if(modForm.length){

                            var data = {};
                            var inputs    = $('.mod').find('[data-name]');
                            inputs.each(function(){
                                data[$(this).attr('data-name')] = $(this).val();
                            });


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


                            var path = '/products-category';
                            var update = false;
                            if(data.product_id.length > 0){
                                path = '/products/ajax-update';
                                update = true;
                            }

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
                                    var tr = $(data);
                                    var id = tr.find('.option').val();

                                    if(update){
                                        var old = $('.tBody').find('.option[value="'+id+'"]').parents('tr').eq(0);
                                        old.after(tr);
                                        old.remove();
                                    }else{
                                        $('.tBody').append(tr);
                                        inputs.each(function(){
                                            if($(this).attr('data-name') != 'category_name'){
                                                $(this).val('');
                                            }
                                        });
                                    }


                                    if(id.length > 0){
                                        if(deleteObj.length > 0){
                                            nededPath  = 'companies/<?=$company->id;?>'+'/products/'+tr.find('.option').val()+'/';
                                            deleteObj.forEach(function(value){
                                                $.ajax({
                                                    url    : value['deleteUrl'],
                                                    method : 'delete',
                                                    data   : {path : nededPath}
                                                });
                                            });
                                            deleteObj = [];
                                        }

                                        if(form && imageObj.length>0){
                                            imageObj.forEach(function(value){
                                                if(value)
                                                    form.files.push(value);
                                            });
                                            nededPath  = 'companies/<?=$company->id;?>'+'/products/'+tr.find('.option').val()+'/';
                                            form.submit();
                                            imageObj = [];
                                        }

                                    }
                                    $('.mod').modal('hide');
                                }
                            });

















                            
                        }
                    });




                    $('#fileupload').on('submit', function(){
                        if(deleteObj.length){
                            deleteObj.forEach(function(value){
                                $.ajax({
                                    url    : value['deleteUrl'],
                                    method : 'delete',
                                    data   : {path : nededPath}
                                });
                            });
                            deleteObj = [];
                        }
                        if(imageObj.length){
                            imageObj.forEach(function(value){
                                form.files.push(value);
                            });
                            form.submit();
                            event.preventDefault();
                            imageObj = [];
                        }
                        if(!deleteObj.length && !imageObj.length){
                            console.log('time to save');
                        }
                        return false;
                        event.preventDefault();
                    });

                    $('.files').delegate('.cancel', 'click', function(){
                        imageObj[$(this).attr('data-id')] = null;
                    });

                    $('.files').delegate('.delete', 'click', function(){
                        var index = $(this).attr('data-id');
                        deleteObj.push(defaultObj[index]);
                        $(this).parents('tr').eq(0).remove();
                        event.preventDefault();
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
                        type    : "POST",
                        url     : "/products/edit-categoty",
                        headers : {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        data    : {
                            productId : id
                        },
                        success : function(msg){
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
                                image  = [];
                                images.forEach(function(item, i, images){
                                    image.push(item['name']);
                                });
                            }
                            $('#fileupload').addClass('fileupload-processing');
                            $.ajax({
                                url      : $('#fileupload').fileupload('option', 'url'),
                                dataType : 'json',
                                context  : $('#fileupload')[0],
                                data     : {
                                    image  : image,
                                    'path' : ''
                                },
                            }).always(function(){
                                $(this).removeClass('fileupload-processing');
                            }).done(function(result){

                                //                        console.log(result);
                                $(this).fileupload('option', 'done').call(this, $.Event('done'), {result : result});
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
                    images                = [];
                    $.ajax({
                        type    : "POST",
                        url     : "/products/ajax-update",
                        headers : {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        data    : data,
                        success : function(msg){
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
                        type    : "POST",
                        url     : "/products-category",
                        headers : {
                            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                        },
                        data    : {
                            company_id : '<?=$company->id?>',
                            product    : selected1
                        },
                        success : function(data){
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

                $('#myModal').modal({show : false});

                $('#custom-checkable').treeview({
                    data            : data,
                    showCheckbox    : true,
                    enableLinks     : false,
                    onNodeChecked   : function(event, node){
                        /* $('.addProductCategory').hide();//ertyuiosdfghkwertyuierty*/
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

