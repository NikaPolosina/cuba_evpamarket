@extends('...layouts.app')
@section('content')
    @include('layouts.header_menu')
    <link href="/css/feedback/feedback.css" rel="stylesheet" type="text/css"/>

    <div class="row">
        <div class="col-sm-12">
            @include('layouts.breadcrumbs')

            <div class="row feed_row">
                <div class="col-sm-8 col-sm-offset-2 feed_body_css feed_body_css_info">

                    <h3>Информация о заказе</h3>
                    <div class="feed_box_css">
                        <ul class="feed_ul">
                            <li>
                                <span>Заказ №: </span>
                                <a href="/show-simple-order/{{$order->id}}">{{$order->id}}</a>

                            </li>
                            <li>
                                <span>Заказ завершён: </span>
                                <span style="color: #337ab7;">{{$order->updated_at}}</span>
                            </li>
                            <li>
                                <span>Магазин:</span>
                                <span style="color: #337ab7;">
                                    <a href="/show-company/{{$order->getCompany[0]->id}}">
                                    {{$order->getCompany[0]->company_name}}
                                    </a>
                                </span>
                            </li>
                        </ul>

                    </div>

                </div>

                <div class="col-sm-8 col-sm-offset-2 feed_body_css feed_body_css_info">


                    <h4>Оставьте отзыв по этому заказу</h4>

                    {!! Form::open(['class' => 'form-horizontal my_form', 'id'=> 'fileupload']) !!}

                    @foreach($order->getProductOrder as $item)

                        <div class="col-sm-12 feed_order_scc">

                            <div class="col-sm-2">
                                <div class="feed_img_css">
                                    <img src="{{$item->getProductId->firstFile}}" alt="">
                                </div>
                            </div>
                            <div class="col-sm-10 feed_order_info_css">
                                <p> Продукт: <span>{{$item->getProductId->product_name}}</span></p>
                                <p> Описание: <span> {{$item->getProductId->product_description}}</span></p>
                                <p> Стоимость: <span>{{$item->getProductId->product_price}}</span> руб.</p>
                            </div>


                        </div>
                        <div class="col-sm-12 par">
                            <p>Пожалуйста, оцените этот заказ</p>
                            <div class="feed_star_css">

                                <span class="span_star star_1" data-str="1"></span>
                                <span class="span_star star_2" data-str="2"></span>
                                <span class="span_star star_s" data-str="3"></span>
                                <span class="span_star star_4" data-str="4"></span>
                                <span class="span_star star_5" data-str="5"></span>

                            </div>
                            @if(Session::has('message') && array_key_exists($item->getProductId->id, Session::get('message')) && Session::get('message')[$item->getProductId->id]->has('rate'))
                                <div style="display: block"class="error" data-id="msg">
                                    <strong>Внимание!</strong> <span>{{Session::get('message')[$item->getProductId->id]->first('rate')}}</span>
                                </div>
                            @endif



                            <input class="input_rate" type="hidden" name="product[{{$item->getProductId->id}}][rate]"  @if(count(Request::old('product')[$item->getProductId->id]['rate'])) value="{{Request::old('product')[$item->getProductId->id]['rate']}}"  @endif />


                            <div class="feed_textarea">
                                <textarea autofocus maxlength="1000" placeholder="Максимальная длина - 1000 символов. По техническим причинам мы не поддерживаем коды HTML."name="product[{{$item->getProductId->id}}][msg]" id="" cols="80" rows="8">@if(count(Request::old('product')[$item->getProductId->id]['msg'])){{Request::old('product')[$item->getProductId->id]['msg']}}@endif</textarea>


                                @if(Session::has('message') &&  array_key_exists($item->getProductId->id, Session::get('message')) &&  Session::get('message')[$item->getProductId->id]->has('msg'))
                                    <div style="display: block"class="error" data-id="msg">
                                        <strong>Внимание!</strong> <span>{{Session::get('message')[$item->getProductId->id]->first('msg')}}</span>
                                    </div>
                                @endif
                            </div>

                            {{--<div class="row">
                                <div class="col-sm-4 col-sm-offset-4">
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Добавить картинку..</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                </div>

                                <div class="col-sm-12">
                                    <table>
                                        <tbody class="files"></tbody>
                                    </table>
                                </div>

                            </div>--}}

                        </div>


                    @endforeach
                    <button  style="float: right" type="submit" class="btn btn-default ">Оставить отзыв</button>

                    {!! Form::close() !!}

                </div>

            </div>
        </div>
    </div>
    {!! HTML::script('/js/feedback/star.js') !!}



    @include('file_upload')
   {{-- <script>
        var file_uploader = '{{route('file_uploader')}}';
        var nededPath, productId, mainImg, number;

        $(function () {

            $('#fileupload').fileupload({
                url: file_uploader,
                previewMaxWidth: 300,
                previewMaxHeight: 300,
                filesContainer: $('.files'),
                uploadTemplateId: null,
                downloadTemplateId: null,
                uploadTemplate: null,
                downloadTemplate: null,
                autoUpload: true,
            })
                    .on('fileuploadprocessalways', function (e, data) {
                    })
                    .on('fileuploadadd', function (e, data) {
                    })
                    .on('fileuploadsubmit', function (e, data) {
                        data.formData = {path: nededPath};
                    })
                    .on('fileuploaddone', function (e, data) {

                        var row = $('<tr class="template-upload">' +
                                '<td>' +
                                '<div>' +
                                '<button class="btn btn-danger delete" data-type="DELETE" data-url="' + data.result.files[0]["deleteUrl"] + '&path=' + nededPath + '"> Удалить </button>' +
                                '<div>Главная <input class="product_image" name="qe" type="radio" value="' + data.result.files[0].name + '"></div>' +
                                '</div>' +
                                '<span class="preview"></span></td>' +
                                '<div class="error"></div>' +
                                '</td>' +
                                '</tr>');
                        row.find('.preview').append(data.files[0].preview);
                        $('.files').append(row);

                    })
                    .on('fileuploaddestroy', function (e, data) {

                        if (productId) {
                            if (confirm('Вы уверены чт хотите удалить картинку ? Если Вы это сделаете, то она навсегда удалится с вашего альбома.')) {
                                $(data.context.context).parents('tr').eq(0).remove();
                            } else {
                                return false;
                            }
                        } else {
                            $(data.context.context).parents('tr').eq(0).remove();
                        }

                    })
                    .on('fileuploadfail', function (e, data) {
                    });
        });


    </script>--}}

@endsection