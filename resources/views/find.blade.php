@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')

    <link rel="stylesheet" type="text/css" href="css/welcome.css"/>

    <div class="row">


        {{--@include('layouts.category_menu', $category)--}}
        <div class="col-md-2"></div>

        <div class="col-md-9 ">
            <div class="panel panel-default">
                <div class="panel-body">


                    @include('product.products.showAllProduct', ['productAll', $productAll])

                </div>
            </div>
        </div>

    </div>

    {!! HTML::script('/js/welcome.js') !!}

@endsection


