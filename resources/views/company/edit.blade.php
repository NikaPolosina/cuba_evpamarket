@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')

<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h1>Редактировать магазин</h1>
        <hr/>

        {!! Form::model($company, [
            'method' => 'PATCH',
            'url' => ['company-create-single', $company->id],
            'class' => 'form-horizontal company_form',
            'id'=>'fileupload'
        ]) !!}


        <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
            {!! Form::label('company_name', 'Название магазина: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::text('company_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
            {!! Form::label('company_description', 'Описание магазина: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::text('company_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('company_logo', 'Logo: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Добавить файл...</span>
                                    <input type="file" name="files[]">
                                </span>
                        <button type="button" class="btn btn-danger delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Удалить</span>
                        </button>
                    </div>
                </div>
                <div class="files">
                    <img width="150" height="150" src="/img/system/place_holder.png">
                </div>
            </div>
        </div>

        {!! Form::hidden('company_logo', null, ['class' => 'form-control', 'id'=>'company_logo']) !!}
        <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
            {!! Form::label('company_content', 'Детальное описание: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::textarea('company_content', null, ['class' => 'form-control']) !!}
                {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('company_contact_info') ? 'has-error' : ''}}">
            {!! Form::label('company_contact_info', 'Контактная информация: ', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
                {!! Form::text('company_contact_info', null, ['class' => 'form-control']) !!}
                {!! $errors->first('company_contact_info', '<p class="help-block">:message</p>') !!}
            </div>
        </div>
        <div  style="padding: 0px 15px 0px 15px;" class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Регион</label>
            <div class="col-md-4">
                <div class="form-group">
                    <select class="chosen-select" name="region" id="sel1">
                        {{--<option value="{{$user->region_id}}">{{$region_tile->title}}</option>--}}
                        @foreach($region as $value)
                            <option value="{{$value->id_region}}">{{$value->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function(){
                $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});

                $('#sel1').val({{$company->region_id}}).trigger('chosen:updated');
                $('#sel2').val({{$company->city_id}}).trigger('chosen:updated');

                $('#sel1').on('change', function(){
                    console.log($(this).val());
                    if($(this).val().length){
                        $.ajax({
                            type: "GET",
                            url: "/get-city-by-region/"+$(this).val(),
                            data: '',
                            success: function(data){
                                $('#sel2_holder').show();
                                var selector = $('#sel2')

                                selector.html('');

                                $.each(data, function(index, value) {

                                    selector.append('<option value="'+value.id_cities+'">'+value.title_cities+'</option>');
                                });

                                $('.chosen').chosen({no_results_text: "Oops, nothing found!"}).trigger("chosen:updated")


                            }
                        });
                    }


                });
            });

        </script>

        <div style="padding: 0px 15px 0px 15px;" id="sel2_holder" class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Город</label>
            <div class="col-md-4">
                <div class="form-group">

                    <select class="chosen-select"  name="city" id="sel2">
                        @foreach($city as $value)
                            <option value="{{$value->id_cities}}">{{$value->title_cities}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Улица</label>
            <div class="col-md-4">
                <input type="text" class="form-control" name="street" value="{{ $company['street'] }}">
                @if ($errors->has('street'))
                    <span class="help-block">
                            <strong>{{ $errors->first('street') }}</strong>
                        </span>
                @endif
            </div>
        </div>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="col-md-2 control-label">Дом</label>
            <div class="col-md-1">
                <input type="text" class="form-control" name="address" value="{{$company['address']  }}">

                @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-5 col-sm-1">
                {!! Form::submit('Сохранить', ['class' => 'btn btn-primary form-control']) !!}

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

        @include('file_upload')
        <script>

            var nededPath = 'companies/{{$company->id}}/company/';
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

        <script src="/plugins/tinymce/tinymce.min.js"></script>
        <script>
            tinymce.init({
                selector: "textarea",theme: "modern",width: 605,height: 200,
                language: 'ru',
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



    </div>
</div>

@endsection