@extends('...layouts.app')

@section('content')

    <h1>Редактировать магазин</h1>
    <hr/>

    {!! Form::model($company, [
        'method' => 'PATCH',
        'url' => ['company', $company->id],
        'class' => 'form-horizontal company_form',
        'id'=>'fileupload'
    ]) !!}

                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                {!! Form::label('company_name', 'Название магазина: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
                {!! Form::label('company_description', 'Описание магазина: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('company_logo', 'Logo: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">

                    <div class="row fileupload-buttonbar">

                        <div class="col-lg-7">
                                        <span class="btn btn-success fileinput-button">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Add files...</span>
                                            <input type="file" name="files[]">
                                        </span>
                            <button type="button" class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Delete</span>
                            </button>
                        </div>

                    </div>

                    <div class="files">
                        <img width="300" height="300" src="/img/system/place_holder.png">
                    </div>

                </div>
                {!! Form::hidden('company_logo', null, ['class' => 'form-control', 'id'=>'company_logo']) !!}
            </div>





    <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
                {!! Form::label('company_content', 'Описание: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_content', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_address') ? 'has-error' : ''}}">
                {!! Form::label('company_address', 'Адрес: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_address', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_address', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_contact_info') ? 'has-error' : ''}}">
                {!! Form::label('company_contact_info', 'Контактная информация: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::text('company_contact_info', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_contact_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_additional_info') ? 'has-error' : ''}}">
                {!! Form::label('company_additional_info', 'Дополнительная информация: ', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    {!! Form::textarea('company_additional_info', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_additional_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-3">
            {!! Form::submit('Обновить', ['class' => 'btn btn-primary form-control']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif


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


        <!-- Plugin init and setup-->
        <script>

            var nededPath = 'companies/';
            var imageObj;
            var nededFiles = ['<?=$company->company_logo?>'];
            var defaultObj;
            var deleteObj;

            $(function(){


                $('#fileupload').fileupload({
                    url : '{{route('file_uploader')}}',
                    uploadTemplateId: null,
                    downloadTemplateId: null,
                    previewMaxWidth: 300,
                    previewMaxHeight: 300,
                })
                .on('fileuploadprocessalways', function (e, data) {
                    var preview = '<img width="300" height="300" src="/img/system/place_holder.png">';
                    if(data.files[0]['preview']){
                        preview = data.files[0]['preview'];
                    }
                    $('.files').html(preview);
                    if(defaultObj){
                        deleteObj = defaultObj;
                        defaultObj = null;
                    }
                })
                .on('fileuploadadd', function(e, data){
                    imageObj = data;
                })
                .on('fileuploadsubmit', function(e, data){
                    data.formData = {path : nededPath};
                })
                .on('fileuploaddone', function(e, data){
                    if(data.result.files[0]['name']){
                        $('#company_logo').val(data.result.files[0]['name']);
                    }
                    $('.company_form').submit();
                })
                .on('fileuploadfail', function(e, data){
                    $('.company_form').submit();
                });

                $('.delete').on('click', function(){
                    var preview = '<img width="300" height="300" src="/img/system/place_holder.png">';
                    $('#company_logo').val('');
                    $('.files').html(preview);
                    imageObj = null;
                    if(defaultObj){
                        deleteObj = defaultObj;
                        defaultObj = null;
                    }
                });

                $('.company_form').on('submit', function(){
                    if(deleteObj){
                        $.ajax({
                            url      : deleteObj.files[0]['deleteUrl'],
                            method:'delete',
                            data:{path: nededPath}
                        });
                    }
                    if(imageObj){
                        imageObj.submit();
                        imageObj = null;
                        event.preventDefault();
                    }
                });

                $.ajax({
                    url      : $('#fileupload').fileupload('option', 'url'),
                    dataType : 'json',
                    context  : $('#fileupload')[0],
                    data     : {
                        image : nededFiles,
                        path  : nededPath
                    },
                }).done(function(result){
                    var preview = '<img width="300" height="300" src="/img/system/place_holder.png">';
                    if(result.files.length){
                        defaultObj = result
                        preview = '<img src="'+result.files[0]['thumbnailUrl']+'">';
                    }
                    $('.files').html(preview);
                });

            });
        </script>



    </div>




    <script src="/plugins/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",theme: "modern",width: 680,height: 300,
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons paste textcolor " +
                "responsivefilemanager" +
                " code"
            ],
            toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
            toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
            image_advtab: true ,

            external_filemanager_path:"/plugins/responsive_filemanager/filemanager/",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : "/plugins/responsive_filemanager/filemanager/plugin.min.js"}
        });
    </script>

    

@endsection