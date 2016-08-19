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

                        <div class="input-group col-sm-12">
                            <form style=" margin: 7px 0px 0px 0px;" class="input-group" method="POST" action="/find">
                                {{ csrf_field() }}

                                <span style=" top: 0px!important; display:table-cell;" class="input-group-addon  glyphicon glyphicon-search" aria-hidden="true"></span>
                                <input class="form-control" name="find" type="text" placeholder="Найти..."/>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Поиск</button>
                                    </span>
                            </form>
                        </div>

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
            <div class="group_body">
                <div class="group_name">
                    <h2 class="name_css">Учасники</h2>
                </div>


                    <div class="people_group_css">
                        <div class="people_simple_css">
                            <p style="font-size: 14px">Учасники  <span style="color: #939393; padding: 0 6px;">{{count($users)}}</span></p>

                        @foreach($users as $val)
                                @if(!$val['getUserInformation']['avatar'])
                                    <?php  $img = '/img/placeholder/avatar.jpg'?>
                                @else
                                    <?php  $img = $val['getUserInformation']['avatar']?>
                                @endif
                            <div style="display: inline-block">
                                    <div class="sercl_img_css">
                                        <img src="{{$img}}" alt="">
                                    </div>
                                <a href="/show-user/{{$val['id']}}"><div style="text-align: center">{{$val['getUserInformation']['name']}}</div></a>
                            </div>
                            @endforeach
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
<style>
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
        border-radius: 5px;
        background-color: white;
        padding:8px;
    }
    .people_group_css{
        box-shadow: 0 1px 0 0 #d7d8db, 0 0 0 1px #e3e4e8;
        margin: 5px;

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
