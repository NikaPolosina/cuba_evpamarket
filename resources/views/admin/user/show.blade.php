
@extends('..admin.header_footer_layout')

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet light ">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Список Пользователей</span>
                            </div>
                      {{--      <div class="actions">
                                <div class="btn-group btn-group-devided" data-toggle="buttons">
                                    <label class="btn btn-transparent dark btn-outline btn-circle btn-sm active">
                                        <input type="radio" name="options" class="toggle" id="option1">Действия</label>
                                    <label class="btn btn-transparent dark btn-outline btn-circle btn-sm">
                                        <input type="radio" name="options" class="toggle" id="option2">Настройки</label>
                                </div>
                            </div>--}}
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
                                    <th> Email </th>
                                    <th> Статус </th>
                                    <th> Дата рождения </th>
                                    <th> Действия </th>
                                </tr>
                                </thead>

                                <tbody>
                                {{-- */$x=0;/* --}}
                                @foreach($user as $item)
                                    {{-- */$x++;/* --}}
                                <tr class="odd gradeX">
                                    <td>
                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                            <input type="checkbox" class="checkboxes" value="1" />
                                            <span></span>
                                        </label>
                                    </td>
                                    <td data-attr="{{$item->id}}"> {{ $x }}</td>
                                    <td> {{$item->getUserInformation->name}}</td>
                                    <td>
                                        <a href="mailto:shuxer@gmail.com"> {{$item->email}} </a>
                                    </td>

                                    @if($item->block == 1)
                                        <td>
                                            <span class="label label-sm label-danger"> забл. </span>
                                        </td>

                                     @else
                                        <td>
                                            <span class="label label-sm label-success"> подтв. </span>
                                        </td>
                                    @endif
                                    <td class="center">
                                        @if($item->getUserInformation)
                                            {{$item->getUserInformation->date_birth}}
                                        @endif
                                    </td>
                                    <td>

                                        <div class="btn-group">
                                            <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Действия
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                             {{--   <li>
                                                    <a href="javascript:;">
                                                        <i class="icon-docs"></i> Профиль </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <i class="icon-tag"></i> Коментарий </a>
                                                </li>--}}

                                                @if($item->block == 1)
                                                <li class="block">
                                                    <a href="javascript:;">
                                                        <i class="icon-user"></i> Разблокировать </a>
                                                </li>
                                                @else
                                                    <li class="block">
                                                        <a href="javascript:;">
                                                            <i class="icon-user"></i> Заблокировать </a>
                                                    </li>
                                                @endif
                                                <li class="divider"> </li>
                                             {{--   <li>
                                                    <a href="javascript:;">
                                                        <i class="icon-flag"></i> Коментариев
                                                        <span class="badge badge-success">4</span>
                                                    </a>
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

            <script>

                $('li.block').on('click', function(){
                    var a = $(this).parents('.gradeX').find('li.block').find('a');
                    var label = $(this).parents('.gradeX').find('span.label');
                    var id = $(this).parents('.gradeX').find('td[data-attr]').attr('data-attr');

                    $.ajax({
                        type: "POST",
                        url: "/admin/user-block",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id
                        },
                        success: function (msg) {
                            if(msg.block == 1){
                                label.removeClass('label-success')
                                label.addClass('label-danger')
                                label.text('забл.');
                                a.text('Разблокировать');
                            }else{
                                label.removeClass('label-danger')
                                label.addClass('label-success')
                                label.text('подтв.');
                                a.text('Заблокировать');
                            }
                        }
                    });


                });


            </script>
@endsection
