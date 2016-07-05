@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')



    <div class="row row_row">

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
            $('.btn-success').attr('disabled', true);
            var holder = $(this).parents('.carentFindProduct').eq(0);
            var parent = $(this).parents('.item');
            var product_id = parent.find("input[data-name='product-id']").val();
            var product_img = parent.find('.product_img').find('img').attr('src');
            var product_name = parent.find('.product_name').find('a').text();
            var product_price = parent.find('.product_price').find('span.price').text();
            var product_description = parent.find('.product_description').find('p').text();
            var body_modal_add_cart = $('#modal_add_product_cart');

            body_modal_add_cart.find('img.img_product').attr('src', '');
            body_modal_add_cart.find('p.product_price').text('');
            body_modal_add_cart.find('p.product_description').text('');
            body_modal_add_cart.find('p.name').text('');
            body_modal_add_cart.find('.modal-title').find('span').text('');


            $.ajax({
                type:"POST",
                url:"/products/cart",
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                data:{id : product_id},
                success:function(msg) {



                    var product = msg.product;
                    $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.cart_count').text(msg.product_cnt);
                    body_modal_add_cart.find('p.product_description').text(msg.product.product_description).show();
                    body_modal_add_cart.find('.modal-title').find('span').text(msg.product_cnt);
                    body_modal_add_cart.find('img.img_product').attr('src', product_img);
                    body_modal_add_cart.find('span.all_product_price').text(msg.product.product_price);
                    body_modal_add_cart.find('span.product_price_one').html(msg.product.product_price);


                    body_modal_add_cart.find('span.total_in_shop').html(msg.total_in_shop);
                    body_modal_add_cart.find('span.total_in_shop_one').html(msg.total_in_shop);
                    body_modal_add_cart.find('input.product_id').val(msg.product.id);

                    $('#modal_add_product_cart').find('input.my_b').val(1)

                    body_modal_add_cart.find('p.name').text(msg.product.product_name);
                    $('#modal_add_product_cart').modal('show');
                    holder.removeClass('activ');
                    $('.btn-success').attr('disabled', false);

                    
                }
                });


                });

        $('.panel-body').find('.item_product').find('.product_navigation').delegate('span.like', 'click', function(){


            var parent = $(this).parents('.item');
            var product_id = parent.find("input[data-name='product-id']").val();
            var body_modal_add_cart = $('#modal_add_product_like');
            body_modal_add_cart.find('.modal-title').find('span').text('');
            var holder = $(this).parents('.carentFindProduct').eq(0);

            $.ajax({
                type:"POST",
                url:"/products/like",
                headers:{
                    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                },
                data:{id : product_id},
                success:function(msg) {
                    var product = msg.product;

                    body_modal_add_cart.find('.modal-title').find('span').text(msg.product_cnt);
                    holder.removeClass('activ');
                    $('#modal_add_product_like').modal('show');



                }
            });

        });

                $('#modal_add_product_cart').on('hide.bs.modal', function (e) {
                    var cnt = $('#modal_add_product_cart').find('input.my_b').val();
                    var pId = $('#modal_add_product_cart').find('input.product_id').val();
                    if(cnt.length > 0 && cnt > 1){
                        $.ajax({
                            type:"POST",
                            url:"/products/cart-update-cnt",
                            headers:{
                                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                            },
                            data:{
                                cnt : cnt,
                                id: pId
                            },
                            success:function(msg) {
                                var product = msg.product;
                                $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.cart_count').text(msg.product_cnt);
                            }
                        });
                    }
                })


    </script>
@endsection


