

<div class="col-sm-12 setting_overall_body">
    <div class="col-sm-6">
        <form id="fileupload_avatar" action="">
                <div class="div_overall"><span class="span_overall">Ваше имя: </span><input value="{{$userInfo->name}}" name="name" type="text"/></div>
                <div class="div_overall"><span class="span_overall">Ваша фамилия: </span><input value="{{$userInfo->surname}}" name="surname" type="text"/></div>
                <div class="div_overall"><span class="span_overall">Улица: </span><input value="{{$userInfo->street}}" name="street" type="text"/></div>
                <div class="div_overall"><span class="span_overall">Номер дома</span><input value="{{$userInfo->address}}" name="address" type="text"/></div>
                <div class="div_overall"><span class="span_overall">Фото:</span><input value="{{$userInfo->avatar}}" name="address" type="text"/></div>


                <div class="col-sm-6">
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-7">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Загрузить файл...</span>
                                    <input type="file" name="files[]">
                                </span>
                            <button type="button" class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Удалить</span>
                            </button>
                        </div>
                    </div>
                    <div class="files">
                        <img width="300" height="300" src="/img/system/place_holder.png">
                    </div>
                </div>



                <button type="button" class="btn btn-default button_setting_overall">Изменить</button>


            <div class="col-sm-6">
                <div data-id ="message" class="alert alert-success" role="alert" style="display: none"> </div>
            </div>
        </form>
    </div>
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




<script>


    var nededPath = '/users';
    var imageObj;
    var nededFiles = ['<?=$userInfo->avatar?>'];
    var defaultObj;
    var deleteObj;



    $(function(){

        $('#fileupload_avatar').fileupload({
            url : '{{route('file_uploader')}}',
            uploadTemplateId: null,
            downloadTemplateId: null,
            previewMaxWidth: 300,
            previewMaxHeight: 300
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











    $('.button_setting_overall').on('click', function(){
       var name = $('[name="name"]').val();
       var surname = $('[name="surname"]').val();
       var street = $('[name="street"]').val();
       var address = $('[name="address"]').val();

        
        $.ajax({
            type: "POST",
            url: '/user/simple_user/setting/security/edit',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                surname: surname,
                street: street,
                address: address
            },
            success: function(msg){

                $('div[data-id ="message"]').text('Инфрмация успешно сохранена.').toggle('slow');
                setTimeout(function(){
                    $('div[data-id ="message"]').text('').toggle('slow');
                }, 4000);


            }
        });

    });
    
</script>



<style>
    .span_overall{
        display: inline-block;
        width: 100px;
    }
    .div_overall{
        margin: 1px;
    }
    .setting_overall_body{

    }
    .button_setting_overall{
        float: right;
    }

</style>