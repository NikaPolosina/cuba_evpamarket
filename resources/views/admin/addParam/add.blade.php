@extends('admin.header_footer_layout')

@section('content')

    @if(isset($param))
        {!! Form::model($param, ['method' => 'PATCH', 'url' => route('admin_create_additional_param'), 'class' => 'form-horizontal']) !!}
        {{Form::hidden('id')}}
    @else
        {!! Form::open(['url' => route('admin_create_additional_param'), 'class' => 'form-horizontal']) !!}
    @endif


    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
        <div class="col-sm-12">
            <div class="col-sm-4">
                {{ Form::label('title', 'Имя: ', ['class' => 'col-sm-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::text('title', NULL, ['class' => 'form-control my_form_add_param']) !!}
                        {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                    </div>

                </div>
                {{ Form::label('description', 'Описание: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::textarea('description', NULL, ['class' => 'form-control my_form_add_param my_textarea', 'rows' => '3']) !!}
                        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                {{ Form::label('sort', 'Сортировка: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::number('sort', NULL, ['class' => 'form-control my_form_add_param ', 'min' => 0]) !!}
                        {!! $errors->first('sort', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                {{ Form::label('placeholder', 'Подсказка: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::text('placeholder', NULL, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('placeholder', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                {{ Form::label('required', 'Обязательно: ', ['class' => 'col-md-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-12">
                        {!! Form::select('required', array('1' => 'ДА', '0' => 'НЕТ'), NULL, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('required', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col-sm-5 value">

                {{ Form::label('type', 'Тип : ', ['class' => 'col-sm-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-8">
                        {!! Form::select('type', array('checkbox' => 'checkbox', 'radio' => 'radio', 'select' =>'select'), NULL, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                {{ Form::label('default', 'По умолчанию: ', ['class' => 'col-sm-2 control-label'])}}
                <div class="col-sm-10">
                    <div class="col-sm-8">
                        {!! Form::text('default', NULL, ['class' => 'form-control my_form_add_param ']) !!}
                        {!! $errors->first('default', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                {!! Form::button('Добавить значение', ['class' => 'btn btn-default add addButt pull-right']) !!}


                <div class="clearfix">


                </div>


                <div id="list">
                    @if(is_array($param->value) && count($param->value))
                        @foreach($param->value as $key=>$item)
                            <div class="value_holder"><label class="col-sm-2 control-label" for="value">Значение: </label>
                                <div class="col-sm-10">
                                    <div class="col-sm-8">
                                        <input class="form-control my_form_add_param" type="text" value="{{$item['name']}}" name="value[{{$key}}][name]" />
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::button('Цвет', ['class' => 'btn btn-success color_switch']) !!}
                                        <div class="backColor" id="{{$key}}" style="background-color: {{(isset($item['css'])) ? $item['css'] : ''}}"></div>
                                        <input data-key="{{$key}}" class="css_input" type="hidden" value="{{(isset($item['css'])) ? $item['css'] : ''}}" name="value[{{$key}}][css]" />
                                        {!! Form::button('x', ['class' => 'btn btn-danger delete_value']) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-10 col-sm-1">
                    {!! Form::submit('Сохранить', ['class' => 'btn btn-primary form-control']) !!}
                </div>
            </div>

            {{ Form::close() }}
        </div>

        <style>

            .my_form_add_param {
                margin-bottom: 10px;
            }

            .addButt {

                margin-bottom: 10px;

            }

            .backColor {
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
            
            function addValueHolder(){
                randomId = Math.random().toString(36).substring(2);
                ids.push(randomId);
                tpl_b = '';
                tpl_b += '<div class="value_holder"><label class="col-sm-2 control-label" for="value">Значение: </label>';
                tpl_b += '<div class="col-sm-10">';
                tpl_b += '<div class="col-sm-8">';
                tpl_b += ' <input class="form-control my_form_add_param" type="text" value="" name="value[' + randomId + '][name]" />';
                tpl_b += '</div>';
                tpl_b += ' <div class="col-sm-4">';
                tpl_b += ' {!! Form::button('Цвет', ['class' => 'btn btn-success']) !!}';
                tpl_b += '<div class="backColor" id="' + randomId + '" ></div>';
                tpl_b += ' <input class="css_input" type="hidden" value="" name="value[' + randomId + '][css]" />';
                tpl_b += ' {!! Form::button('x', ['class' => 'btn btn-danger delete_value']) !!}';
                tpl_b += '</div>';
                tpl_b += '</div>';
                tpl_b += '</div>';
                $('#list').append(tpl_b);
                randomId          = '';
                var colorSelector = ids.forEach(function(element, index){
                    if(index == 0){
                        randomId += '#' + element + ' ';
                    }else{
                        randomId += ', #' + element;
                    }
                });
                $(randomId).ColorPicker({
                    onChange     : function(hsb, hex, rgb){
                        currentSelector.css('backgroundColor', '#' + hex);
                        currentSelector.next().val('#' + hex);
                    },
                    onBeforeShow : function(event){
                        currentSelector = $(this);
                    }
                });
                randomId = null;
            }

            document.addEventListener("DOMContentLoaded", function(){
                $('.addButt').on('click', function(){
                    addValueHolder();
                });
                $('#list').delegate('.delete_value', 'click', function(){
                    $(this).parents('.value_holder').eq(0).remove();
                });


                if($('.css_input').length){

                    randomId          = '';

                    $('.css_input').each(function(index, input){
                        if(index == 0){
                            randomId += '#' + $(input).attr('data-key') + ' ';
                        }else{
                            randomId += ', #' + $(input).attr('data-key');
                        }
                    });

                    $(randomId).ColorPicker({
                        onChange     : function(hsb, hex, rgb){
                            currentSelector.css('backgroundColor', '#' + hex);
                            currentSelector.next().val('#' + hex);
                        },
                        onBeforeShow : function(event){
                            currentSelector = $(this);
                        }
                    });
                    randomId = null;
                    console.log(randomId);

                }




            });

        </script>

@endsection
