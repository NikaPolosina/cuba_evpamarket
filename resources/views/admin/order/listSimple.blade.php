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
                            <th> id_simple</th>
                            <th> Статус (для покупателя)</th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>

                        {{-- */$x=0;/* --}}
                        @foreach($statusSimple as $item)
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

                                <td class="status_title_owner"><a href="">{{$item->title}}</a></td>


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



    <script src="/assets/global/plugins/jquery.min.js" type="text/javascript"></script>



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
