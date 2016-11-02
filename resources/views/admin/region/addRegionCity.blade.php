@extends('admin.header_footer_layout')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>

                        <span class="caption-subject bold uppercase"> Регион {{$region->title}}</span>
                    </div>

                </div>
                <div class="portlet-body">

                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    <span></span>
                                </label>
                            </th>
                            <th> # </th>
                            <th> Регион </th>
                            <th> Город </th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>

                        {{-- */$x=0;/* --}}
                        @foreach($city as $item)
                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <input class="id_cities" value="{{$item->id_cities}}" type="hidden"/>
                                <input class="id" value="{{$item->id}}" type="hidden"/>
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> {{ $x }} </td>

                                <td> {{$region->title}}</td>

                                <td class="title">{{$item->title_cities}}</td>


                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Действия
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a  class="tut" href="javascript:;">
                                                    <i class="icon-docs"></i> Редактировать </a>
                                            </li>
                                            <li>
                                                <a href="/admin/city-destroy/{{$item->id_cities}}">
                                                    <i class="icon-tag"></i> Удалить </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>



    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">

            <div id="modal_delete" class="mod modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-xs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Форма редактирования категрии</h4>
                        </div>
                        <div class="modal-body">

                            {{ Form::open(array('method' => 'post', 'url' => '/admin/city-update' , 'class' => 'form-group' )) }}
                            {!! csrf_field() !!}
                            <div class="row">
                                {!! Form::label('category_title', 'Категория: ', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('title', NULL, ['class' => 'form-group advanced_search_name form-control title_modal', 'required' => 'required']) !!}
                                    {!! $errors->first('user_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            {!! Form::hidden('id', NULL, ['class' => 'form-group advanced_search_surname form-control id_modal']) !!}
                            {!! Form::hidden('id_cities', NULL, ['class' => 'form-group advanced_search_surname form-control id_cities']) !!}


                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script>

        $(document).ready(function(){
            $('a.tut').on('click', function () {
                var id = $(this).parents('tr.gradeX').find('input.id').val();
                var id_cities = $(this).parents('tr.gradeX').find('input.id_cities').val();
                var title = $(this).parents('tr.gradeX').find('td.title').text();
                $('div#modal_delete').find('input.id_modal').val(id);
                $('div#modal_delete').find('input.id_cities').val(id_cities);
                $('div#modal_delete').find('input.title_modal').val(title);


                $('#modal_delete').modal();



            });
            /**
             * Show modal window with current product
             * */


        });

    </script>

@endsection

