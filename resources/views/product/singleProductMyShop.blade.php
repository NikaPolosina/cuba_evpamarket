@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')

    <div class="row row_row">
        <div class="col-xs-12">
            <div class="col-xs-1">
                <div class="table" id="product_list">
                    <span  class="open btn edit btn-primary btn-xs">Редактировать</span></span>
                </div>

            </div>
            @include('layouts.breadcrumbs')

            <div class="col-xs-11 col-sm-11">
                @include('product.showSingleProductInfo')
            </div>
        </div>
    </div>

    @include('product.productModalEdit')
    @include('file_upload')

    <script>
        {{--var categoryId ='{{$singleProduct['category_id']}}';--}}
        var categoryTitle ='zskfgndh';
        var file_uploader = '{{route('file_uploader')}}';
        var company_id = '{{$companyId}}';
        var productId = '{{$singleProduct['id']}}';
        var id = '{{$singleProduct['id']}}';
        var mainImg = '';
        var number = '';


    </script>



    {!! HTML::script('/js/product_create_edit.js') !!}
    {!! HTML::script('/plugins/tinymce/tinymce_init.js') !!}

    <style>

@endsection