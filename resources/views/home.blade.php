
@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-heading"><h1>Привет {{$userInfo->name}} !!!</h1></div>
                <div class=""><h1>



                            <h1>Мои компании <a href="{{ url('company/create') }}" class="btn btn-primary pull-right btn-sm">Добавить компанию</a></h1>
                            <div class="table">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>№</th><th>Имя компании</th><th>Описание</th><th>Company Logo</th><th>Действие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{-- */$x=0;/* --}}
                                    @foreach($curentUser->getCompanies as $item)
                                        {{-- */$x++;/* --}}
                                        <tr>
                                            <td>{{ $x }}</td>
                                            <td><a href="{{ url('company', $item->id) }}">{{ $item->company_name }}</a></td><td>{{ $item->company_description }}</td><td>{{ $item->company_logo }}</td>
                                            <td>
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


                <div class="panel-body">
                    Добро пожаловать. Вы залогинены!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
