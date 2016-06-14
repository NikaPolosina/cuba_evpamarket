@extends('homeSimpleUser')

@section('content_user')

    <div class="col-sm-10 myPageContent">
        <div class="row">
            <div class="col-sm-12 contentInfo">

                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#main" aria-controls="home" role="tab" data-toggle="tab">Общие настройки</a></li>
                        <li role="presentation"><a href="#security" aria-controls="profile" role="tab" data-toggle="tab">Безопасность</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active " id="main">

                            <div class="col-sm-12 setting_overall_body">
                                <div class="col-sm-6">
                                    <form id="fileupload" action="">

                                        <div class="div_overall"><span class="span_overall">Ваше имя: </span><input value="{{$userInfo->name}}" name="name" type="text"/></div>
                                        <div class="div_overall"><span class="span_overall">Ваша фамилия: </span><input value="{{$userInfo->surname}}" name="surname" type="text"/></div>
                                        <div class="div_overall"><span class="span_overall">Улица: </span><input value="{{$userInfo->street}}" name="street" type="text"/></div>
                                        <div class="div_overall"><span class="span_overall">Номер дома</span><input value="{{$userInfo->address}}" name="address" type="text"/></div>

                                        <div class="col-sm-6">
                                            <div class="row fileupload-buttonbar">
                                                <div class="col-lg-7">
                                                    <span class="btn btn-success fileinput-button">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Загрузить файл...</span>
                                                        <input type="file" name="files[]">
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <table class="files">
                                                    <tr class="template-upload">
                                                        <td>
                                                            <img width="300" height="300" src="/img/system/place_holder.png">
                                                        </td>
                                                        </td>
                                                    </tr>
                                                </table>
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
                                var userId = '{{$user->id}}';
                                var nededPath = '/users/'+userId+'/avatar/';
                                var nededFiles = [];
                                var fileUrl  ='{{route('file_uploader')}}';
                            </script>

                                {!! HTML::script('/js/setting.js') !!}

                            <script>
                                $(document).ready(function(){

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
                                            $('.files').html('');
                                            result.files.forEach(function(value){
                                                var row   = $('<tr class="template-upload">' +
                                                        '<td>' +
                                                        '<div>' +
                                                        '<button class="btn btn-danger delete" data-type="DELETE" data-url="'+value["deleteUrl"]+'&path='+nededPath+'"> Удалить </button>' +
                                                        '</div>' +
                                                        '<img src="'+value['thumbnailUrl']+'">' +
                                                        '</td>' +
                                                        '<div class="error"></div>' +
                                                        '</td>' +
                                                        '</tr>');
                                                $('.files').append(row);
                                            });
                                        }

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

                                .button_setting_overall{
                                    float: right;
                                }

                            </style>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="security">
                            Безопасность
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection