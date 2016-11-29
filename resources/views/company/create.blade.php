@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')

<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-3 col-md-offset-2">
            <h3 style="font-weight: bold;color: darkblue;">Создать новый магазин</h3>
        </div>
</div>

<div class="col-sm-12">
    <hr>
    {!! Form::open(['url' => 'company-done-create', 'class' => 'form-horizontal company_form', 'id'=>'fileupload']) !!}

                <div class="form-group {{ $errors->has('company_name') ? 'has-error' : ''}}">
                    <label class="col-sm-2  control-label" for="company_name">Название магазина: <span class="required_css">*</span> </label>
                <div class="col-sm-4">
                    {!! Form::text('company_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('company_description') ? 'has-error' : ''}}">
                <label class="col-sm-2  control-label" for="company_description">Описание магазина: <span class="required_css">*</span> </label>
                <div class="col-sm-4">
                    {!! Form::text('company_description', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('company_description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">

                {!! Form::label('company_logo', 'Логотип: ', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-7">
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Выбрать картинку...</span>
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
            <div class="form-group {{ $errors->has('company_contact_info') ? 'has-error' : ''}}">
                {!! Form::label('company_contact_info', 'Контактная информация: ', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::textarea('company_contact_info', null, ['class' => 'form-control', 'rows' => '3']) !!}
                    {!! $errors->first('company_contact_info', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div  style="padding: 0px 15px 0px 15px;" class="form-group{{ $errors->has('region') ? ' has-error' : '' }}">
                <label class="col-sm-2  control-label" for="region">Регион: <span class="required_css">*</span> </label>
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

                $('#sel1').val({{$user->region_id}}).trigger('chosen:updated');
                $('#sel2').val({{$user->city_id}}).trigger('chosen:updated');

                $('#sel1').on('change', function(){
                    console.log($(this).val());
                    if($(this).val().length){
                        $.ajax({
                            type: "GET",
                            url: "/get-city-by-region/"+$(this).val(),
                            data: '',
                            success: function(data){
                                $('#sel2_holder').show();
                                var selector = $('#sel2');

                                selector.html('');

                                $.each(data, function(index, value) {
                                    selector.append('<option value="'+value.id_cities+'">'+value.title_cities+'</option>');
                                });

                                $('#sel2').trigger('chosen:updated');

                                $('.chosen').chosen({no_results_text: "Oops, nothing found!"}).trigger("chosen:updated")
                                
                            }
                        });
                    }


                });
            });


        </script>

            <div style="padding: 0px 15px 0px 15px;" id="sel2_holder" class="form-group{{ $errors->has('city_id') ? ' has-error' : '' }}">

                <label class="col-sm-2  control-label" for="city">Город: <span class="required_css">*</span> </label>
                <div class="col-md-4">
                    <div class="form-group">

                        <select class="chosen-select"  name="city" id="sel2">
                            {{--<option value="{{$user->city_id}}">{{$city_tile->title_cities}}</option>--}}
                             @foreach($city as $value)
                                 <option value="{{$value->id_cities}}">{{$value->title_cities}}</option>
                             @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Улица: </label>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="street" value="{{--{{ old('street') }}--}}{{$user->street}}">
                    @if ($errors->has('street'))
                        <span class="help-block">
                            <strong>{{ $errors->first('street') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                <label class="col-md-2 control-label">Дом: </label>
                <div class="col-md-1">
                    <input type="text" class="form-control" name="address" value="{{--{{ old('address') }}--}} {{$user->address}}">

                    @if ($errors->has('address'))
                        <span class="help-block">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-1">
                    {!! Form::submit('Создать', ['class' => 'btn btn-primary form-control']) !!}

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
            var nededPath = 'companies/';
            var imageObj;
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
                    $('.files').html(preview);
                    imageObj = null;
                });

                $('.company_form').on('submit', function(){
                    if(imageObj){
                        imageObj.submit();
                        imageObj = null;
                        event.preventDefault();
                    }
                });

            });
        </script>
    </div>

    </div>
</div>
</div>

    <style>
      .chosen-container-active{
            width: 50% !important;
        }
      .chosen-container{
            width: 50% !important;
        }
    </style>

@endsection