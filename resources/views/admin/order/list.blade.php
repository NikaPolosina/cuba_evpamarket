@extends('admin.header_footer_layout')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> Список статусов по заказам</span>
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
                            <th> id_owner</th>
                            <th> id_simple</th>
                            <th> Статус (для продавца)</th>
                            <th> Статус (для покупателя)</th>
                            <th> Ключ </th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>

                        {{-- */$x=0;/* --}}
                        @foreach($statusOwner as $item)
                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> {{ $x }} </td>

                                <td class="id_owner"> {{$item->id}}</td>
                                <td class="id_simple"> {{$item->getStatusSimple->id}}</td>

                                <td class="status_title_owner"><a href="">{{$item->title}}</a></td>
                                <td class="status_title_simple"><a href="">{{$item->getStatusSimple->title}}</a></td>

                                <td class="center kay"> {{$item->key}} </td>

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
                                            {{--Также предусматрена опция удаления статуса администратором, если откоментировать
                                            ниже код, то моно будет удалять статус, но будьте внимательны лучше не удалять статус который уже задействованый какимто продуктом ибо возникнет ошибка--}}
                                            {{-- <li>
                                                 <a class="confirm" href="/admin/status-product-delete/{{$item->id}}">
                                                     <i class="icon-tag"></i> Удалить </a>
                                             </li>--}}

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
                            {{ Form::open(array('method' => 'post', 'url' => '/admin/status-order-update' , 'class' => 'form-group url_modal' )) }}
                            {!! csrf_field() !!}

                            <div class="row">
                                {!! Form::label('status_title_owner', 'Статус для продавца: ', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-6">
                                    {!! Form::text('status_title_owner', NULL, ['class' => 'form-group advanced_search_name form-control status_title_owner', 'required' => 'required']) !!}
                                    {!! $errors->first('status_title_owner', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                            {!! Form::hidden('id_owner', NULL, ['class' => 'form-group advanced_search_surname form-control id_owner']) !!}
                            {!! Form::hidden('id_simple', NULL, ['class' => 'form-group advanced_search_surname form-control id_simple']) !!}



                            <div class="row">
                               {!! Form::label('status_key', 'Статус для покупателя: ', ['class' => 'col-sm-4 control-label']) !!}


                                <div class="col-sm-6">
                                    <select class="form-control select_status">

                                        @foreach($statusSimple as $simple)
                                            <option value="{{$simple->id}}">{{$simple->title}}</option>
                                        @endforeach

                                    </select>
                                    {!! $errors->first('status_key', '<p class="help-block">:message</p>') !!}
                                </div>


                           </div>


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
                var id_owner = $(this).parents('tr.gradeX').find('td.id_owner').text();
                var id_simple = $(this).parents('tr.gradeX').find('td.id_simple').text();
                var status_title_owner = $(this).parents('tr.gradeX').find('td.status_title_owner').text();
                var x;
                //Заполняем поля модального окна необходимой информацией.
                $('div#modal_status_product').find('input.id_owner').val(id_owner);
                $('div#modal_status_product').find('input.id_simple').val(id_simple);


                $('div#modal_status_product').find('input.status_title_owner').val(status_title_owner);

                $('div#modal_status_product').find('select.select_status').val(id_simple.trim());

                $('#modal_status_product').modal();//Показ модалки.



            });

            /*$('button.add_new_status_product').on('click', function () {
                $('form.url_modal').attr('action','/admin/status-product-create');
                $('#modal_status_product').modal();
            });*/

            $('.select_status').on('change', function () {
                $('div#modal_status_product').find('input.id_simple').val($(this).val());
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
