
@extends('layouts.app')

@section('content')
    @include('layouts.header_menu')



    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Моя страница</h2></div>
                {{------------------------------------------------------------------------------------------------}}
                <div class="col-sm-12" style="border: solid 1px black;">
                    <div class="col-sm-3" style="border: solid 1px red;">
                        @foreach($menu as $menuItem)
                                <h4>{{$menuItem['title']}}</h4>
                            @endforeach
                    </div>
                    <div class="col-sm-9" style="border: solid 2px #008000;">
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="col-sm-4" style="border: solid 1px red;">
                                    <img class="img-thumbnail" src="/img/custom/files/thumbnail/plase.jpg" alt="" style="width: 200px; height: 200px"/>

                                </div>
                                <div class="col-sm-8" style="border: solid 1px red;">
                                    <h1>{{$userInfo->name}} {{$userInfo->surname}}</h1>
                                    <h5>{{$userInfo->country}}</h5>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                {{--------------------------------------------------------------------------------------------------}}
                <?php if(count($curentUser->getCompanies)){ ?>
                    <div class=""><h1>
                        <h1>Мои магазины <a href="{{ url('company/create') }}" class="btn btn-primary pull-right btn-sm">Добавить магазин</a></h1>
                        <div class="table">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr bgcolor="#FBFBEF">
                                    <th>№</th><th>Logo</th><th>Имя магазина</th><th>Описание</th><th width="350px">Детальное описание</th><th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                {{-- */$x=0;/* --}}
                                @foreach($curentUser->getCompanies as $item)

                                    <?php  if(!empty($item->company_logo )&& file_exists(public_path().'/img/custom/companies/thumbnail/'.$item->company_logo)) {
                                        $logo = '/img/custom/companies/thumbnail/'.$item->company_logo;
                                    }else{

                                        $logo = '/img/custom/files/thumbnail/plase.jpg';
                                    } ?>


                                    {{-- */$x++;/* --}}
                                    <tr>
                                        <td>{{ $x }}</td>
                                        <td> <img class="img-thumbnail" style="display: block; width: 100px;" src="<?=$logo?>"></td><td><a href="{{ url('/product-editor', $item->id) }}">{{ $item->company_name }}</a></td><td>{{ $item->company_description }}</td><td width="200">{!!$item->company_content!!}</td>

                                        <td width="165">
                                            <a href="{{ url('company/' . $item->id . '/edit') }}">
                                                <button type="submit" class="btn btn-primary btn-xs">Редактировать</button>
                                            </a> /
                                            {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['company', $item->id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::submit('Удалить', ['class' => 'btn btn-danger btn-xs']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                                    </tbody>
                            </table>
                                {{--<div class="pagination"> {!! $company->render() !!} </div>--}}
                        </div>
                    </h1></div>
       <?php
            }else{ ?>
                    <div><h1>У вас пока нет ни одного магазина. Воспользуйтесь кнопкой "создать" для того что бы создать магазин.</h1></div>
                <a href="{{ url('company/create') }}" class="btn btn-primary pull-right btn-sm">Создать</a>


            <?php }
                ?>

                <div class="panel-body">
                    Добро пожаловать. Вы залогинены!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
