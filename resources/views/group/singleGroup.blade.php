@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')


<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-3">
            <div class="group_body">
                <div class="group_name">
                    <h2 class="name_css">Пригласить в группу</h2>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group myGroup" style="margin: 0px">
                                <select data-placeholder="Выбирите магазин..." class="chosen-select" style="width:300px;" tabindex="2" name="my_company" required>
                                    <option value=""></option>
                                    {{--<option value="calendar" title="http://www.abe.co.nz/edit/image_cache/Hamach_300x60c0.JPG"></option>--}}
                                    @foreach($allUser as $value)
                                        <option value="{{$value['id']}}" style="background-image: url('{{$value['getUserInformation']['avatar']}}')">{{$value['getUserInformation']['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="people_group_css">
                    <div class="people_simple_css">
                        <p style="font-size: 14px">Учасники  <span style="color: #939393; padding: 0 6px;">{{count($users)}}</span></p>
                        @foreach($users as $val)
                            <div style="display: inline-block">
                                <div class="sercl_img_css">
                                    <img src="{{$val['getUserInformation']['avatar']}}" alt="">
                                </div>
                                <a href="/show-user/{{$val['id']}}"><div style="text-align: center">{{$val['getUserInformation']['name']}}</div></a>
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
                        <h4 style="font-weight: bolder">Магазин -  {{$group->getCompany['company_name']}}</h4>
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
        <div class="col-sm-3">

        </div>
    </div>
</div>



    <script type="text/javascript">
        var config = {
            '.chosen-select'           : {},
            '.chosen-select-deselect'  : {allow_single_deselect:true},
            '.chosen-select-no-single' : {disable_search_threshold:10},
            '.chosen-select-no-results': {no_results_text:'Ой, ничего не найдено!'},
            '.chosen-select-width'     : {width:"95%"}
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }



    </script>

@endsection
<style>


    .chosen-container .chosen-results li.highlighted {
        background-color: white!important;
        color: black!important;
    }

    .myGroup .chosen-container .chosen-results li{
        line-height: 50px;
    }


    .group_name:after{
        content: '';
        display: table;
        clear: both;
    }

    .active-result {

       background: transparent url({{$value['getUserInformation']['avatar']}}) no-repeat 0 center;
        padding-left: 70px !important;
        background-size: contain !important;


    }
    .active-result:hover{
        color: red!important;
        outline: solid 1px red!important;
    }


    .span_momey_css{
        color: blue;
        margin: auto;
        padding: 5px;
        line-height: 30px;
    }
    .block_money_css{
        font-size: 17px;
    }
    .sercl_img_css{
        overflow: hidden;
        width: 50px;
        height: 50px;
        border: 0;
        color: transparent;
        border-radius: 50%;

    }
    .money_css{

        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        height:30px;
        width: 100%
        text-align: center;
        background-color: white;
        border-radius: 3px;
        display: inline-block;
    }

    .people_group_css{
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        margin: 15px;
        border-radius: 5px;
        background-color: white;
        padding:8px;

    }
    .group_name_css{
        border-bottom: 1px solid #e7e8ec;
    }
    .name_company{
        color: darkblue;

    }
    .name_css{
    text-align: center;
    font-size: 19px;
    font-weight: 400;
}
    .group_body{
        background: ghostwhite;
        border-radius: 2px;
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        padding: 5px;
    }
    .group_body:after{
        content: '';
        display: table;
        clear: both;
    }
</style>


<script>
    var setBg = function (elems, user) {

        for (var i = 0; i < users.length; i++) {
            var path = '/img/users/' + i + '/avatar' + i +'.png';
        }

        elems.css({
            'background' : path;
        });
    }
</script>