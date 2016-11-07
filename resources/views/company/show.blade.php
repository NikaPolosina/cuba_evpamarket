@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')


    <link rel="stylesheet" type="text/css" href="../css/welcome.css"/>
    <div class="row">
        @include('layouts.category_menu', $category)

        <div class="row_row">
            <div class="row item_class_4">

                <div class="table-responsive">
                    <div class="seller" style="margin: 6px 6px 6px 30px">
                        <span>Продавец:</span> <a href="/show-user/{{$company->getUser[0]->id}}">{{$company->getUser[0]->getUserInformation->name}}{{$company->getUser[0]->getUserInformation->surname}}</a>
                        <a href="/get-single-conversation/{{Auth::user()->id}}/{{$company->getUser[0]->id}}"><button type="button" class="btn btn-default btn-sm">Связаться с продавцом</button></a>

                    </div>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Logo</th>
                            <th>Название магазина</th>
                            <th>Краткое описание</th>
                            <th>Детальное описание</th>
                            <th>Адрес</th>
                            <th>Контактная информация</th>
                            <th>Дополнительная информация</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><img class="img-thumbnail" style="display: block; width: 100px;" src="{{$img}}"></td>
                            <td> {{ $company->company_name }} </td>
                            <td> {{ $company->company_description }} </td>
                            <td> {!! $company->company_content !!} </td>
                            <td> {{ $company->company_address }} </td>
                            <td> {{ $company->company_contact_info }} </td>
                            <td> {!! $company->company_additional_info !!} </td>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-md-8 ">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @include('product.showAllProduct', ['productAll', $productAll])

                        </div>
                    </div>
                </div>


                @if ($errors->any())
                    <ul class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                @endif
            </div>
        </div>
    </div>
@endsection

<style>
    .seller{
        font-size: 16px;
    }
    .seller>a{
        font-weight: bold;
    }

</style>