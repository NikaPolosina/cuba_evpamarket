@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')

    <div class="row row_row">

        @include('layouts.category_menu', $category)

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">

                    @include('slide')

                    @include('layouts.category_pallet', ['vip_category', $vip_category])

                    @include('company.showCompany', ['companyAll', $companyAll])

                    @include('product.products.showAllProduct', ['productAll', $productAll])
                    {{$productAll->render()}}

                </div>
            </div>
        </div>

        <div class="col-md-2" style="border: solid 1px red;">
            Новости о акциях
        </div>
    </div>

    {!! HTML::script('/js/like_and_cart_add.js') !!}


@endsection


