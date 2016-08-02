@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <h3>Страница магазина</h3>

            {!! Form::open(['url' => '/company-content', 'class' => 'form-horizontal company_form', 'id'=>'fileupload']) !!}
            {{Form::hidden('company_id', $company_id)}}

            <div class="form-group {{ $errors->has('company_content') ? 'has-error' : ''}}">
                {!! Form::label('company_content', 'Детальное описание: ', ['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::textarea('company_content', NULL, ['class' => 'form-control']) !!}
                    {!! $errors->first('company_content', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-8 col-sm-1">
                    {!! Form::submit('Создать', ['class' => 'btn btn-primary form-control']) !!}

                </div>
            </div>



            {!! Form::close() !!}
        </div>



    </div>
    <script src="/plugins/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "textarea",theme: "modern",width: 800,height: 300,
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

@endsection