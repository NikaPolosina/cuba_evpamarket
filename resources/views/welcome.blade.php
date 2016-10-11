@extends('layouts.app')
@section('content')
    @include('layouts.header_menu')

    <div class="row row_row">

        @include('layouts.category_menu', $category)

        <div class="col-xs-7 col-md-8 item_class">
            <div class="panel panel-default item_class_2">
                <div class="panel-body item_class_3">

                    @include('slide')

                    @include('layouts.category_pallet', ['vip_category', $vip_category])

                    @include('company.showCompany', ['companyAll', $companyAll])

                    @include('product.showAllProduct', ['productAll', $productAll])
                    {{$productAll->render()}}

                </div>
            </div>
        </div>

        <div class="col-xs-2 col-md-2" style="border: solid 1px red;">
            Новости о акциях
        </div>
    </div>




@endsection


