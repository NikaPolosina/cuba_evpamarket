<meta charset="utf-8">
<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="/plugins/FileUploader/css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/plugins/FileUploader/css/jquery.fileupload.css">
<link rel="stylesheet" href="/plugins/FileUploader/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="/plugins/FileUploader/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="/plugins/FileUploader/css/jquery.fileupload-ui-noscript.css"></noscript>

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
                   <span>Start</span>
               </button>
           {% } %}
           {% if (!i) { %}
               <button class="btn btn-warning cancel">
                   <i class="glyphicon glyphicon-ban-circle"></i>
                   <span>Cancel</span>
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
                   <span>Delete</span>
               </button>
               <input type="checkbox" name="delete" value="1" class="toggle">
           {% } else { %}
               <button class="btn btn-warning cancel">
                   <i class="glyphicon glyphicon-ban-circle"></i>
                   <span>Cancel</span>
               </button>
           {% } %}
       </td>
   </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="/plugins/FileUploader/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/plugins/FileUploader/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/plugins/FileUploader/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="/plugins/FileUploader/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="/plugins/FileUploader/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->



    <h1>Добавить товар @if(isset($company))  в компанию - {!!$company->company_name!!}  @endif  </h1>
    <hr/>

        <div class="col-sm-12">
            <div class="row">
                     <div class="col-md-3 form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">

                            <div id="custom-checkable" class=""></div>
                            <script>

                                var data = <?=$category?>

                                        $('#custom-checkable').treeview({
                                            data: data,
                                            showCheckbox: true,
                                            enableLinks: true,
                                            onNodeChecked: function(event, node) {
                                                console.log(node.href);
                                                $('.product_category').val(node.href)

                                            },
                                            onNodeUnchecked: function (event, node) {
                                                $('.product_category').val('')
                                                console.log(node.text + ' was unchecked');
                                            }
                                        }).treeview('collapseAll');
                            </script>


                     </div>


                    <div class="col-sm-9">
                        <div class="row">
                        <!-- The file upload form used as target for the file upload widget -->
                        <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">



                                @if(isset($company))  <input type="hidden" name="company_id" value="{{ $company->id }}"/>  @endif
                                <div class="col-sm-6">
                                        <div class="form-group {{ $errors->has('product_name') ? 'has-error' : ''}}">
                                            {!! Form::hidden('product_category', null, ['class' => 'product_category']) !!}
                                            {!! Form::label('product_name', 'Товар: ', ['class' => 'col-sm-3 control-label']) !!}

                                                {!! Form::text('product_name', null, ['class' => 'form-control']) !!}
                                                {!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
                                        </div>

                                        <div class="form-group {{ $errors->has('product_description') ? 'has-error' : ''}}">
                                            {!! Form::label('product_description', 'Описание: ', ['class' => 'col-sm-3 control-label']) !!}

                                                {!! Form::textarea('product_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                                {!! $errors->first('product_description', '<p class="help-block">:message</p>') !!}
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
                                                <button type="submit" class="btn btn-primary start">
                                                    <i class="glyphicon glyphicon-upload"></i>
                                                    <span>Start upload</span>
                                                </button>
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


                                      {{--  <div class="form-group {{ $errors->has('product_image') ? 'has-error' : ''}}">
                                            {!! Form::label('product_image', 'фото: ', ['class' => 'col-sm-3 control-label']) !!}

                                                {!! Form::text('product_image', null, ['class' => 'form-control']) !!}
                                                {!! $errors->first('product_image', '<p class="help-block">:message</p>') !!}

                                        </div>--}}

                                        <div class="form-group {{ $errors->has('product_price') ? 'has-error' : ''}}">
                                            {!! Form::label('product_price', 'Цена: ', ['class' => 'col-sm-3 control-label']) !!}

                                                {!! Form::number('product_price', null, ['class' => 'form-control']) !!}
                                                {!! $errors->first('product_price', '<p class="help-block">:message</p>') !!}

                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-9 col-sm-3">
                                                {!! Form::submit('Create', ['class' => 'btn btn-primary form-control']) !!}
                                            </div>
                                        </div>
                                </div>

                            </form>
                        </div>
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


                 {{--   {!! Form::open(['url' => 'products', 'class' => 'form-horizontal']) !!}--}}

                  {{--
                    {!! Form::close() !!}--}}
        </div>
    </div>






