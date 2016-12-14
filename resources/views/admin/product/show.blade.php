@extends('admin.header_footer_layout')
@section('content')



    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> Список статусов по товарам</span>
                        <a href="javascript:;" style="margin-left: 30px;">
                            <button type="button" class="add_new_status_product">Добавить</button> </a>
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
                            <th> Имя </th>
                            <th> Ключ </th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>

                        {{-- */$x=0;/* --}}
                        @foreach($status as $item)
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

                                <td class="status_name"><a href="">{{$item->status_name}}</a></td>

                                <td class="center kay"> {{$item->status_key}} </td>

                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Действия
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a  class="addChange" href="javascript:;">
                                                    <i class="icon-docs"></i> Редактировать </a>
                                            </li>
                                            <li>
                                                <a class="confirm" href="/admin/status-product-delete/{{$item->id}}">
                                                    <i class="icon-tag"></i> Удалить </a>
                                            </li>
                                            <li class="divider"> </li>

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

    {{---------------------------------------------Модальное окно для создания и редактирования статусов по продуктам------------------------------------------------}}
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <div id="modal_status_product" class="mod modal fade bs-example-modal-xs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog modal-xs">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Форма редактирования статуса по товарам</h4>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(array('method' => 'post', 'url' => '/admin/status-product-update' , 'class' => 'form-group url_modal' )) }}
                            {!! csrf_field() !!}

                            <div class="row">
                                {!! Form::label('status_key', 'Ключ: ', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-6">
                                    <span style="font-weight: bold;">Примичание:</span><span> Ключ необходимо указать латынскими символами. </span>
                                    {!! Form::text('status_key', NULL, ['class' => 'form-group advanced_search_name form-control status_key', 'required' => 'required']) !!}
                                    {!! $errors->first('status_key', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="row">
                                {!! Form::label('status_name', 'Название: ', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('status_name', NULL, ['class' => 'form-group advanced_search_name form-control status_name', 'required' => 'required']) !!}
                                    {!! $errors->first('status_name', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            {!! Form::hidden('id', NULL, ['class' => 'form-group advanced_search_surname form-control id_modal']) !!}


                        </div>
                        <div class="modal-footer">
                            {!! Form::submit('Сохранить', ['class' => 'btn btn-primary save_change_status_product']) !!}
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
            //При нажатии на кнопку - Редактировать.
            $('a.addChange').on('click', function () {
                //Находим необходимую информацию.
                var id = $(this).parents('tr.gradeX').find('td.id').text();
                var kay = $(this).parents('tr.gradeX').find('td.kay').text();
                var status_name = $(this).parents('tr.gradeX').find('td.status_name').text();
                //Заполняем поля модального окна необходимой информацией.
                $('div#modal_status_product').find('input.id_modal').val(id);
                $('div#modal_status_product').find('input.status_key').val(kay);
                $('div#modal_status_product').find('input.status_name').val(status_name);
                $('#modal_status_product').modal();//Показ модалки.
            });

            $('button.add_new_status_product').on('click', function () {
                $('form.url_modal').attr('action','/admin/status-product-create');
                $('#modal_status_product').modal();
            });


        });

    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('.confirm').on('click', function () {
                if(!confirm(('Вы уверены ?'))){
                    return false;
                }
            });
        });
    </script>
@endsection
