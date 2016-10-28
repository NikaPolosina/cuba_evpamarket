@extends('..admin.header_footer_layout')

@section('content')



    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase"> Список Дополнительных параметров</span>
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
                            <th> Имя </th>
                            <th> Описание </th>
                            <th> Тип </th>
                            <th> Обязателное для заполнения </th>
                            <th> Сортировка</th>
                            <th> Действия </th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- */$x=0;/* --}}
                        @foreach($param as $item)
                            {{-- */$x++;/* --}}
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td> {{ $x }} </td>

                                <td><a href="/admin/show-add-param/{{$item->id}}">{{$item->title}}</a></td>

                                <td class="center"> {{$item->description}} </td>
                                <td class="center"> {{$item->type}}</td>
                                <td class="center"> @if($item->required == 1) Да @else Нет @endif </td>
                                <td class="center"> {{$item->sort}} </td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Действия
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="javascript:;">
                                                    <i class="icon-docs"></i> Редактировать </a>
                                            </li>
                                            <li>
                                                <a href="/admin/add-param-destroy/{{$item->id}}">
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
@endsection
