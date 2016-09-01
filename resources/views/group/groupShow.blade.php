@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')

    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">


            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#tab_1_1" data-toggle="tab"> Мои группы </a>
                </li>
                <li>
                    <a href="#tab_1_2" data-toggle="tab"> Создать группу </a>
                </li>
                <li data-id="invite">
                    <a href="#tab_1_3" data-toggle="tab"> Приглашения в группы </a>
                </li>

            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab_1_1">
                    @include('group.list')
                </div>

            <!--tab_1_2-->
                <div class="tab-pane" id="tab_1_2">


                    {{ Form::open(array('method' => 'post', 'url' => '/group-create' , 'class' => 'form-inline' )) }}
                    {!! csrf_field() !!}


                    <div class="form-group {{ $errors->has('group_name') ? 'has-error' : ''}}">
                        {!! Form::label('group_name', 'Имя группы: ', ['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-6">
                            {!! Form::text('group_name', NULL, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('group_name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>


                    <div class="form-group{{ $errors->has('my_company') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Компании</label>
                        <div class="col-md-6">
                            <div class="form-group" style="margin: 0px">

                                <select data-placeholder="Выбирите магазин..." class="chosen-select" style="width:350px;" tabindex="2" name="my_company" required>
                                    <option value=""></option>
                                    @foreach($my_company as $value)
                                        <option value="{{$value['id']}}">{{$value['company_name']}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </div>


                    {!! Form::submit('Создать', ['class' => 'btn btn-primary form-control']) !!}

                    {{ Form::close() }}


                </div>

                <div class="tab-pane" id="tab_1_3">
                    @if(count($groupInvites))
                        <ul class="list-group">
                        @foreach($groupInvites as $msg)
                            <li class="list-group-item">
                                <div>
                                    <span>Вы получили приглашение о вступлении в группу: <div style="display: inline-block; margin: 0px 10px 0px 10px;"><a href="/single-group/{{$msg->group->id}}">{{$msg->group->group_name}}</a></div> </span>
                                    <div class="btn-group" role="group" aria-label="...">
                                        <a href="{{route('enable_group_invite', [$msg->id])}}"><button type="button" class="btn btn-success">Вступить</button></a>
                                        <a href="{{route('disable_group_invite', [$msg->id])}}"><button type="button" class="btn btn-danger">Отказаться</button></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    @else
                        <ul class="list-group">
                            <li class="list-group-item">На данный ммент приглашений в группу нет.
                        </ul>
                    @endif
                </div>


            </div>

        </div>

    </div>

    <style>
        .chosen-container {
            min-width: 200px;
        }
    </style>

    <script type="text/javascript">
        var config = {
            '.chosen-select'            : {},
            '.chosen-select-deselect'   : {allow_single_deselect : true},
            '.chosen-select-no-single'  : {disable_search_threshold : 10},
            '.chosen-select-no-results' : {no_results_text : 'Ой, ничего не найдено!'},
            '.chosen-select-width'      : {width : "95%"}
        }
        for(var selector in config){
            $(selector).chosen(config[selector]);
        }
        $('.chosen-select').change(function(){
            var val = $(this).find('option:selected').text();
            $('.chosen-select').parents('.form-inline').find('input#group_name').val(val);
        });


        $(document).ready(function(){
            if(window.location.hash){
                var hash = window.location.hash.substring(1);
                $('.nav-tabs').find('li').each(function(key, val){
                    $(val).removeClass('active');
                });

                $('.nav-tabs').find('li[data-id="' + hash + '"]').addClass('active');
                var id = $('.nav-tabs').find('li[data-id="' + hash + '"]').find('a').attr('href');
                id = id.substring(1);

                $('.tab-pane').each(function(key, val){
                    $(val).removeClass('active');
                });

                $('div#'+id).addClass('active');

            }
        });
    </script>



@endsection