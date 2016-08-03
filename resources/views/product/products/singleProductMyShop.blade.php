@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    <div class="row row_row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
            @include('product.products.showSingleProductInfo')
        </div>
    </div>
@endsection