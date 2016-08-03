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
                        previewMaxWidth: 150,
                        previewMaxHeight: 150,
                    })
                            .on('fileuploadprocessalways', function (e, data) {
                                var preview = '<img width="150" height="150" src="/img/system/place_holder.png">';
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
                        var preview = '<img width="150" height="150" src="/img/system/place_holder.png">';
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
                        var preview = '<img width="150" height="150" src="/img/system/place_holder.png">';
                        if(result.files.length){
                            defaultObj = result;
                            console.log(result.files[0]);



                            preview = '<a ' +
                                    'href="'+result.files[0]["url"]+'" ' +
                                    'title="'+result.files[0]["name"]+'" download="'+result.files[0]["name"]+'" data-gallery="">' +
                                    '<img src="'+result.files[0]["thumbnailUrl"]+'">' +
                                    '</a>';
                        }
                        $('.files').html(preview);
                    });

                });
            </script>

        </div>