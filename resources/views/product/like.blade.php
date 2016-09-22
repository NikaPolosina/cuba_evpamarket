@extends('layouts.app')
@section('content')

    @include('layouts.header_menu')
    <link rel="stylesheet" type="text/css" href="/css/show_cart_like.css"/>

    @include('product.modalAddProductCart')
    <div class="row_row">
        <div class="col-sm-8 col-sm-offset-2">
        @include('layouts.breadcrumbs')
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
                <div class="col-sm-9 col-sm-offset-1 product_item_like like_empty product_item_p">
                    <h1>В избранных нет ни одного товара. Вернитесь к сайту, что бы добавить товар в избранное.</h1>
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

@endsection
