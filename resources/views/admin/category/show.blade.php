@extends('..admin.header_footer_layout')

@section('content')


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> Список Категорий</span>
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
                            <th> id </th>
                            <th> parent_id </th>
                            <th> Название </th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- */$x=0;/* --}}
                        @foreach($category as $item)
                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> {{ $x }} </td>

                                <td class="id"> {{$item->id}}</td>

                                <td class="center"> {{$item->parent_id}} </td>
                                <td class="center title"> {{$item->title}} </td>
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
                                                <a  class="" href="/admin/category-param/{{$item->id}}">
                                                    <i class="icon-docs"></i> Дополнительные параметры товара </a>
                                            </li>
                                            <li>
                                                <a href="/admin/category-destroy/{{$item->id}}">
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

                            {{ Form::open(array('method' => 'post', 'url' => '/admin/category-update' , 'class' => 'form-group' )) }}
                            {!! csrf_field() !!}
                            <div class="row">
                                {!! Form::label('category_title', 'Категория: ', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('title', NULL, ['class' => 'form-group advanced_search_name form-control title_modal', 'required' => 'required']) !!}
                                    {!! $errors->first('user_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                                    {!! Form::hidden('id', NULL, ['class' => 'form-group advanced_search_surname form-control id_modal']) !!}


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

    <script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script>

        $(document).ready(function(){
            $('a.tut').on('click', function () {
                var id = $(this).parents('tr.gradeX').find('td.id').text();
                var title = $(this).parents('tr.gradeX').find('td.title').text();
                $('div#modal_delete').find('input.id_modal').val(id);
                $('div#modal_delete').find('input.title_modal').val(title);


                $('#modal_delete').modal();



            });
            /**
             * Show modal window with current product
             * */


        });

    </script>



@endsection

