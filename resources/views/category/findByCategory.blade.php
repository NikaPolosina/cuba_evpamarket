@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')

    <div class="row row_row">

        @include('layouts.category_menu', $category)

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                @if(isset($vip_category) && count($vip_category)>=1 || isset($productAll) && count($productAll)>= 1)

                        @include('layouts.category_pallet', ['vip_category', $vip_category])

                        @if(isset($productAll) && count($productAll)>= 1)
                            <h3>Товары по данной категории.</h3>
                            @include('product.showAllProduct', ['productAll' => $productAll])
                            {!! $productAll->render() !!}</div>
                        @endif

                @else
                    <h3>В данном разделе нет товаров</h3>
                @endif


            </div>
        </div>
    </div>

    {!! HTML::script('/js/like_and_cart_add.js') !!}

@endsection