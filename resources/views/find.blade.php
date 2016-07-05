@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')

    {{--<link rel="stylesheet" type="text/css" href="css/welcome.css"/>--}}

    <div class="row  row_row">

        @include('layouts.category_menu', $category)

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">


                    @include('product.products.showAllProduct', ['productAll', $productAll])

                </div>
            </div>
        </div>

    </div>

    {!! HTML::script('/js/like_and_cart_add.js') !!}
@endsection


