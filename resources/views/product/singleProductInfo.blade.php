@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')
    <div class="row row_row">
        @include('layouts.category_menu', $category)
        @include('product.showSingleProductInfo')
    </div>
@endsection

