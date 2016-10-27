@extends('admin.header_footer_layout')

@section('content')





    {{ Form::open(array('url' => '/admin/create-add-param',  'method' => 'post')) }}
    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
        <div class="col-sm-12">
            <div class="col-sm-4">
                {{ Form::label('title', 'Имя: ', ['class' => 'col-sm-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::text('title', null, ['class' => 'form-control my_form_add_param']) !!}
                        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>
                {{ Form::label('description', 'Описание: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::textarea('description', null, ['class' => 'form-control my_form_add_param my_textarea', 'rows' => '3']) !!}
                        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                {{ Form::label('sort', 'Сортировка: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::number('sort', null, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('sort', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                {{ Form::label('placeholder', 'Подсказка: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::text('placeholder', null, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('placeholder', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                {{ Form::label('required', 'Обязательно: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::select('required', array('1' => 'ДА', '0' => 'НЕТ'), null, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('required', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-5 value">

                {{ Form::label('type', 'Тип : ', ['class' => 'col-sm-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-8">
                        {!! Form::select('type', array('checkbox' => 'checkbox', 'radio' => 'radio', 'select' =>'select'), null, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                    {{ Form::label('default', 'По умолчанию: ', ['class' => 'col-sm-2 control-label'])}}
                    <div class="col-sm-10">
                        <div class="col-sm-8">
                            {!! Form::text('default', null, ['class' => 'form-control my_form_add_param ']) !!}
                            {!! $errors->first('default', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>


                <div id="list">

                </div>

            </div>
            <div class="col-sm-3 addButt">
                <div id="colorSelectoro">
                    <div style="background-color: #0000ff"></div>
                </div>
                <hr>
             {!! Form::button('Добавить', ['class' => 'btn btn-default add']) !!}
            </div>



        <div class="form-group">
            <div class="col-sm-offset-10 col-sm-1">
                {!! Form::submit('Создать', ['class' => 'btn btn-primary form-control']) !!}
            </div>
        </div>

    {{ Form::close() }}
</div>

    <style>
        .my_form_add_param{
            margin-bottom: 10px;
        }
        .addButt{
            box-shadow: 0 1px 10px 0 rgba(50,50,50,.2);
            background: #fff;
            padding: 10px 25px 10px;
        }
        .backColor{
            margin-left: 3px;
            line-height: 1.44;
            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            touch-action: manipulation;
            cursor: pointer;
            border: 1px solid transparent;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 14px;
            width: 34px;
            height: 34px;
            border: solid 1px grey;
            display: inline-block;
            padding: 6px 12px;
            font-size: 14px;
        }
    </style>


        <script>

            var randomId, currentSelector, tpl_b;
            var ids = [];

            function addValueHolder() {
                randomId = Math.random().toString(36).substring(20);

                ids.push(randomId);

                tpl_b = '';
                tpl_b += '<label class="col-sm-2 control-label" for="value">Значение: </label>';
                tpl_b += '<div class="col-sm-10">';
                tpl_b  += '<div class="col-sm-8">';
                tpl_b += ' <input class="form-control my_form_add_param" type="text" value="" name="value['+randomId+'][name]" />';
                tpl_b += '</div>';
                tpl_b += ' <div class="col-sm-4">';
                tpl_b += ' {!! Form::button('Цвет', ['class' => 'btn btn-success']) !!}';
                tpl_b += '<div class="backColor" id="'+randomId+'" ></div>';
                tpl_b += ' <input class="css_input" type="hidden" value="" name="value['+randomId+'][css]" />';
                tpl_b += ' {!! Form::button('x', ['class' => 'btn btn-danger']) !!}';

                tpl_b += '</div>';
                tpl_b += '</div>';

                $('#list').append(tpl_b);

                randomId = '';
                var colorSelector = ids.forEach(function(element, index){
                    if(index == 0){
                        randomId += '#' + element + ' ';
                    }else{
                        randomId += ', #' + element;
                    }
                });

                $(randomId).ColorPicker({
                    onChange : function(hsb, hex, rgb){
                        currentSelector.css('backgroundColor', '#' + hex);
                        currentSelector.next().val('#' + hex);
                    },
                    onBeforeShow : function(event){
                        currentSelector = $(this);
                    }
                });
                randomId = null;
            }

            document.addEventListener("DOMContentLoaded", function() {
                addValueHolder();

                $('.addButt').find('button.add').on('click', function () {
                    addValueHolder();
                });

            });

        </script>

@endsection
