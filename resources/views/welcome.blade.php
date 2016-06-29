@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')

    <link rel="stylesheet" type="text/css" href="css/welcome.css"/>

    <div class="row">

        @include('layouts.category_menu', $category)

        <div class="col-md-8 ">
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
    <script>




        $('.panel-body').find('.item_product').find('.product_navigation').delegate('.btn-success', 'click', function(){
            var product_id = $(this).parents('.item').find("input[data-name='product-id']").val();

            $.ajax({
                type:"POST",
                url:"/products/cart",
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                data:{id : product_id},
                success:function(msg) {
                        console.log('gksgkjn');
                }
                });


                });


    </script>
@endsection


