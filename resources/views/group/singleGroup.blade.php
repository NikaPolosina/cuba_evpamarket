@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')


    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <div class="group_body">
                    <div class="group_name">

                                <h2 class="name_css">Пригласить в группу</h2>

                             <a class="ui_header_ext_search">Расширеный поиск</a>

                        <div class="col-md-12">

                                <div class="form-group myGroup group_holder">
                                    <select data-placeholder="Выбирите пользователя..." class="chosen-select group_selector" style="width:300px;" tabindex="2" name="my_company" required>
                                        <option value=""></option>
                                        @foreach($allUser as $value)
                                            <option value="{{$value['id']}}" style="background-image: url('{{$value['getUserInformation']['avatar']}}')">{{$value['getUserInformation']['name']}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn-default invite_to_group" data-group="{{$group->id}}">Пригласить</button>

                                    <div class="progress" style="display: none">
                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            <span class="sr-only">45% Complete</span>
                                        </div>
                                    </div>

                                    <div class="alert alert-success invite_sent" role="alert" style="display: none">Приглашение в группу было отправлено пльзователю.</div>
                                    <div class="alert alert-danger invite_error" role="alert" style="display: none">Ошибка отправки, повторите попытку немного позже.</div>

                                </div>

                        </div>
                    </div>

                    <div class="people_group_css find_refine">
                        <div style="text-align: center">
                           <span style="text-align: center; font-size: 16px; ">Параметры поиска</span>
                            <span style="display: inline-block; float: right"><img src="/img/system/list.png" alt=""></span>
                            <hr>
                        </div>

                        {{ Form::open(array('method' => 'post', 'url' => '#' , 'class' => 'form-group' )) }}
                                {!! csrf_field() !!}
                                    <div class="row">
                                        {!! Form::label('user_name', 'Имя: ', ['class' => 'col-sm-4 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('user_name', NULL, ['class' => 'form-group', 'required' => 'required']) !!}
                                            {!! $errors->first('user_name', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        {!! Form::label('user_name', 'Фамилия: ', ['class' => 'col-sm-4 control-label']) !!}
                                        <div class="col-sm-6">
                                            {!! Form::text('user_surname', NULL, ['class' => 'form-group']) !!}
                                            {!! $errors->first('user_surname', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>
                                    <div class="row">

                                            <label class="col-md-4 control-label">Возраст: </label>
                                            <div class="col-md-4">
                                                <div class="form-group" style="margin: 0px">

                                                    <select data-placeholder="" class="" style="width:50px;" tabindex="2" name="from">
                                                        <option value="">От</option>
                                                        @for($i = 18; $i < 90; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                       @endfor
                                                    </select>
                                                    <select data-placeholder="" class="" style="width:50px;" tabindex="2" name="to">

                                                    <option value="">До</option>
                                                    @for($i = 18; $i < 90; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>

                                                </div>
                                            </div>

                                    </div>
                                    <div class="row" style="margin-top: 5px">



                                            {!! Form::label('gender', 'Пол: ', ['class' => 'col-sm-4 control-label']) !!}



                                        <div class="col-sm-4">
                                            <fieldset class="find_group_css">

                                                <div class="form-group" style="margin: 0px">
                                                    <label for="men">
                                                        {!! Form::radio('gender', NULL, ['class' => 'form-group col-sm-4 ', 'id' => 'men']) !!}
                                                        <span>Мужской</span>
                                                    </label>
                                                    <label for="women">
                                                        {!! Form::radio('gender', NULL, ['class' => 'form-group col-sm-4 ' , 'id' => 'women']) !!}
                                                        <span>Женский</span>
                                                    </label>
                                                    <label for="other">
                                                        {!! Form::radio('gender', NULL, ['class' => 'form-group col-sm-4 ', 'id' => 'other']) !!}
                                                        <span>Любой</span>
                                                    </label>
                                                    {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>



                        <div class="row">
                            @include('layouts.regionCity')
                        </div>


                           <div class="row">
                               <div class="col-xs-12 text-right">
                                   {!! Form::submit('Найти', ['class' => 'button_find_css']) !!}
                               </div>
                           </div>

                        {{ Form::close() }}
                    </div>

                    <div class="people_group_css">
                        <div class="people_find">
                                <h4>По запрсу найдено:</h4>
                            <hr>
                            <div class="single_people_css" style="display: table; width: 100%">

                                <div style="display: table-cell; vertical-align: middle">

                                    <div class="css_peo" style="display: inline-block">
                                        <div class="sercl_img_css">
                                            <img src="/img/system/plase.jpg" alt="">
                                        </div>
                                    </div>

                                    <div class="css_peo">
                                        <p style="display: inline-block;">Имя Фамилия</p>
                                    </div>

                                    <div class="css_peo">
                                        <button class="btn-default invite_to_group" data-group="{{$group->id}}">Пригласить</button>
                                    </div>

                                </div>

                            </div>


                        </div>
                    </div>


                    <div class="people_group_css">
                        <div class="people_simple_css">
                            <p style="font-size: 14px">Учасники
                                <span style="color: #939393; padding: 0 6px;">{{count($users)}}</span></p>
                            @foreach($users as $val)
                                <div style="display: inline-block">
                                    <div class="sercl_img_css">
                                        <img src="{{$val['getUserInformation']['avatar']}}" alt="">
                                    </div>
                                    <a href="/show-user/{{$val['id']}}">
                                        <div style="text-align: center">{{$val['getUserInformation']['name']}}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-sm-6">
                <div class="group_body">
                    <div class="group_name">
                        <h2 class="name_css name_company">{{$group['group_name']}}</h2>
                        <hr>
                        <div class="col-sm-6">
                            <h4 style="font-weight: bolder">Магазин - {{$group->getCompany['company_name']}}</h4>
                            <h5>{{$group->getCompany['company_description']}}</h5>
                        </div>
                        <div class="col-sm-6 block_money_css">
                            <span style="margin-right: 10px;">Сумма накопрлений составляет:</span>
                            <div class="money_css">
                            <span class="span_momey_css">
                               {{$group['money']}}
                            </span>
                            </div>
                            <span style="margin-left: 10px;">руб.</span>
                            <span style="margin-right: 10px;">Размер скидки у данного магазина составляет:</span>
                            <div class="money_css">
                            <span class="span_momey_css">
                                {{$discount}}
                            </span>
                            </div>
                            <span style="margin-left: 10px;">%</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-2">

            </div>
        </div>
    </div>



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






        $('.ui_header_ext_search').on('click', function () {
            console.log('ljgkwegi');
            return false;
            
        })

    </script>


    <script>
        var groupInviteUrl = '{{route('group_invite_action')}}';
    </script>

    {{ HTML::script('/js/group/invite.js') }}
@endsection
<style>
    .css_peo{
        margin: 0 10px!important;
        padding: 0!important;
        vertical-align: middle;
        display: inline-block;
        text-align: center;

    }
    .css_peo p{
        margin: 0!important;
    }
    .find_group_css label{
        display: block;
        width: 100%;
    }
    .button_find_css{
        display: inline-block;

             }
.find_refine:after {
    content: '';
    display: table;
    clear: both;
}
.ui_header_ext_search{
    cursor: pointer;
    float: right;
    font-size: 14px;
    background: url(/img/system/magnifying-glass.png?2) no-repeat;
    background-position: left 22px;
    padding-left: 25px;
    line-height: 60px;
}

    .chosen-container .chosen-results li.highlighted {
        background-color: rgba(198, 198, 198, 0.47) !important;
        color: black !important;
    }

    .myGroup .chosen-container .chosen-results li {
        line-height: 50px;
    }

    .group_name:after {
        content: '';
        display: table;
        clear: both;
    }

    .myGroup .active-result {

        background: transparent url({{$value['getUserInformation']['avatar']}}) no-repeat 0 center;
        padding-left: 70px !important;
        background-size: contain !important;

    }

    .span_momey_css {
        color: blue;
        margin: auto;
        padding: 5px;
        line-height: 30px;
    }

    .block_money_css {
        font-size: 17px;
    }

    .sercl_img_css {
        overflow: hidden;
        width: 50px;
        height: 50px!important;
        border: 0;
        color: transparent;
        border-radius: 50%;
    }
    .sercl_img_css img{
        height: 50px!important;

    }

    .money_css {

        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        height: 30px;

        text-align: center;
        background-color: white;
        border-radius: 3px;
        display: inline-block;
    }

    .people_group_css {
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        margin: 15px;
        border-radius: 5px;
        background-color: white;
        padding: 8px;

    }

    .group_name_css {
        border-bottom: 1px solid #e7e8ec;
    }

    .name_company {
        color: darkblue;

    }

    .name_css {
        display: inline-block;
        margin: 5px 0px 5px 20px;
        font-size: 19px;
        font-weight: 400;
    }

    .group_body {
        background: ghostwhite;
        border-radius: 2px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        padding: 5px;
    }

    .group_body:after {
        content: '';
        display: table;
        clear: both;
    }

    .people_group_css .chosen-container {
        width: 100% !important;
    }
</style>


