@extends('layouts.app')
@section('content')

    @include('layouts.header_menu')
    @include('layouts.breadcrumbs')

    <link rel="stylesheet" type="text/css" href="/css/show_cart_like.css"/>

    @include('product.modalAddProductCart')
    <div class="row_row">
        <div class="col-sm-8 col-sm-offset-2">
        </div>

        <div class="row item_class_4">
            @if(count($product) > 0 )
                @foreach($product as $v)
                    <div class="col-sm-8 col-sm-offset-2 product_item_like product_item_p tom" style="padding-right: 2px; padding-left: 2px">
                        @include('product.likeSingleView')
                    </div>

                @endforeach


                <div class="col-sm-9 col-sm-offset-1 product_item_like like_empty product_item_p" style="display: none">
                    <h1>В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</h1>
                </div>
            @else


                <div class="col-sm-6 col-sm-offset-3 product_item_like like_empty product_item_p">
                    <div class="col-sm-9">
                        <p class="empty_cart_p">В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</p>
                    </div>

                    <div class="col-sm-3">
                        <div class="hold_img_empty_cart">
                            <img src="/img/system/clip-art.png" alt="">
                        </div>
                    </div>
                </div>


            @endif
        </div>

    </div>

    {!! HTML::script('/js/product/like_delete.js') !!}
    <script>
        var getProductUrl = '{{route('ajax_single_product')}}';
        var addToCartUrl = '{{route('ajax_add_to_cart')}}';
        var cartUrl = '{{route('cart')}}';
    </script>

    {!! HTML::script('/js/like_and_cart_add.js') !!}


    <style>
        .empty_cart_p{
            font-size: 25px;
            padding: 40px;
        }


    </style>

@endsection
