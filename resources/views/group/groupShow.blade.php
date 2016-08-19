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

            </ul>

            <div class="tab-content">

                    @include('group.list')


                <!--tab_1_2-->
                <div class="tab-pane" id="tab_1_2">


                    {{ Form::open(array('method' => 'post', 'url' => '/group-create' , 'class' => 'form-inline' )) }}
                    {!! csrf_field() !!}


                        <div class="form-group {{ $errors->has('group_name') ? 'has-error' : ''}}">
                            {!! Form::label('group_name', 'Имя группы: ', ['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::text('group_name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                {!! $errors->first('group_name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>



                        <div  class="form-group{{ $errors->has('my_company') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Компании</label>
                            <div class="col-md-6">
                                <div class="form-group" style="margin: 0px">
                                    <select class="chosen-select" name="my_company" id="sel1">



                                        <option value="">Выбирите компанию</option>
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


            </div>

        </div>

    </div>





@endsection