$(document).ready(function(){
    var cart_modal = $('#cart_modal');
    //При закрытии модального окна нужно убрать все li класс active.
        $('#cart_modal').on('hidden.bs.modal', function () {
            $('ul.sku-attr-list').find('li').removeClass('active');
        });
    //При выборе дополнительного параметра даетмя li класс active.
    $("a[data-role='sku']").on('click', function () {
        $(this).parents('ul').find('li').removeClass('active');
        $(this).parents('li').addClass('active');

    });

    /**
    * Show modal window with current product
    * */
    if(cart_modal){
        $('.to_cart').on('click', function(){
            $('.btn-success').attr('disabled', true);
            clearModal(cart_modal);
            event.preventDefault();
            var productId = $(this).attr('data-product-id');
            var extraPrice = calculatePrice();

            $.ajax({
                type    : "POST",
                url     : getProductUrl,
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data : {id : productId, extra : extraPrice},
                success : function(response){

                    $.ajax({
                        type    : "GET",
                        url     : '/product/ajax-to-cart-add-param/'+response.product.id,
                        success : function(response){
                            if(response.length){
                                cart_modal.find('.add_param_chosen').after(response);
                            }
                        }
                    });
                    
                    cart_modal.find('.m_car_cnt').text(response.cart_cnt);
                    cart_modal.find('.m_product_title').text(response.product.product_name);
                    cart_modal.find('.m_product_description').text(response.product.product_description);
                    cart_modal.find('.my_counter').val(1);
                    cart_modal.find('.m_single_product_price').text(response.product.product_price);
                    cart_modal.find('.m_all_product_price').text(response.product.product_price);
                    cart_modal.find('.m_img_product').attr('src', response.product.firstFile);
                    cart_modal.find('.m_total_in_shop').html(parseFloat(response.total_in_shop)+parseFloat(response.product.product_price));
                    cart_modal.find('.m_h_product_price_one').val(response.product.product_price);
                    cart_modal.find('.m_h_product_id').val(response.product.id);
                    cart_modal.find('.m_h_total_in_shop').val(parseFloat(response.total_in_shop)+parseFloat(response.product.product_price));
                    $('.carent_my_product').removeClass('activ');
                    cart_modal.modal('show');
                    $('.btn-success').attr('disabled', false);
                },
                error   : function(response){
                    console.log('ajax went wrong');
                }
            });
        });

        $('.m_close_modal').on('click', function(){
            $('ul.sku-attr-list').find('li').removeClass('active');
            cart_modal.modal('hide');
        });

    }else{
        console.error('Modal window was not wound');
    }


    $('.buy_button').on('click', function(){

        event.preventDefault();
        var button = $(this);

        $.ajax({
            type    : "POST",
            url     : addToCartUrl,
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                product_id : cart_modal.find('.m_h_product_id').val(),
                cnt : cart_modal.find('.my_counter').val(),
                add_param: JSON.stringify(calculatePrice())
            },
            success : function(response){
                $('.cart_count').html(response.total_count);

                if(button.hasClass('go_cart')){
                    window.location = cartUrl;
                }
                $('ul.sku-attr-list').find('li').removeClass('active');
                cart_modal.modal('hide');
            },
            error   : function(response){
                console.log('ajax went wrong');
            }
        });

    });

    $('.item_class_3').find('.item_class_4').find('.product_navigation').delegate('span.like', 'click', function(){
        var parent              = $(this).parents('.item_1');
        var product_id          = parent.find("input[data-name='product-id']").val();
        var body_modal_add_cart = $('#modal_add_product_like');
        body_modal_add_cart.find('.modal-title').find('span').text('');
        var holder = $(this).parents('.carentFindProduct').eq(0);
        $.ajax({
            type    : "POST",
            url     : "/products/like",
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data    : {id : product_id},
            success : function(msg){
                var product = msg.product;
                $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.like_count').text(msg.product_cnt);
                body_modal_add_cart.find('.modal-title').find('span').text(msg.product_cnt);
                holder.removeClass('activ');
                $('#modal_add_product_like').modal('show');
            }
        });
    });

});


/**
 * Clear modal window
 * */
function clearModal(cart_modal){
    cart_modal.find('.m_car_cnt').text('');
    cart_modal.find('.m_product_title').text('');
    cart_modal.find('.m_product_description').text('');
    cart_modal.find('.my_counter').val(1);
    cart_modal.find('.m_single_product_price').text('');
    cart_modal.find('.m_all_product_price').text('');
    cart_modal.find('.m_img_product').attr('src', '');
    cart_modal.find('.m_total_in_shop').html('');
    cart_modal.find('.m_h_product_price_one').val('');
    cart_modal.find('.m_h_product_id').val('');
    cart_modal.find('.m_h_total_in_shop').val('');
    cart_modal.find('.temp').remove();
}
/*

$('#app-layout').find('.row_row').find('.item_class_4').find('.product_navigation').delegate('.btn-success', 'click', function(){
    $('.btn-success').attr('disabled', true);
    var holder              = $(this).parents('.carent_my_product').eq(0);
    var parent              = $(this).parents('.item_1');
    var product_id          = parent.find("input[data-name='product-id']").val();
    var product_img         = parent.find('.product_img').find('img').attr('src');
    var product_name        = parent.find('.product_name').find('a').text();
    var product_price       = parent.find('.product_price').find('span.price').text();
    var product_description = parent.find('.product_description').find('p').text();
    var body_modal_add_cart = $('#modal_add_product_cart');
    body_modal_add_cart.find('img.img_product').attr('src', '');
    body_modal_add_cart.find('p.product_price').text('');
    body_modal_add_cart.find('p.product_description').text('');
    body_modal_add_cart.find('p.name').text('');
    body_modal_add_cart.find('.modal-title').find('span').text('');
    $.ajax({
        type    : "POST",
        url     : "/products/cart",
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        data    : {id : product_id},
        success : function(msg){
            var product = msg.product;
            $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.cart_count').text(msg.product_cnt);
            body_modal_add_cart.find('p.product_description').text(msg.product.product_description).show();
            body_modal_add_cart.find('.modal-title').find('span').text(msg.product_cnt);
            body_modal_add_cart.find('img.img_product').attr('src', product_img);
            body_modal_add_cart.find('span.single_product_price').text(msg.product.product_price);
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
$('.item_class_3').find('.item_class_4').find('.product_navigation').delegate('span.like', 'click', function(){
    var parent              = $(this).parents('.item_1');
    var product_id          = parent.find("input[data-name='product-id']").val();
    var body_modal_add_cart = $('#modal_add_product_like');
    body_modal_add_cart.find('.modal-title').find('span').text('');
    var holder = $(this).parents('.carentFindProduct').eq(0);
    $.ajax({
        type    : "POST",
        url     : "/products/like",
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        data    : {id : product_id},
        success : function(msg){
            var product = msg.product;
            $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.like_count').text(msg.product_cnt);
            body_modal_add_cart.find('.modal-title').find('span').text(msg.product_cnt);
            holder.removeClass('activ');
            $('#modal_add_product_like').modal('show');
        }
    });
});
$('#modal_add_product_cart').delegate('.go_cart', 'click', function(e){
    e.preventDefault();
    var cnt = $('#modal_add_product_cart').find('input.my_b').val();
    var pId = $('#modal_add_product_cart').find('input.product_id').val();
    if(cnt.length > 0 && cnt > 1){
        $.ajax({
            type    : "POST",
            url     : "/products/cart-update-cnt",
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                cnt : cnt,
                id  : pId
            },
            success : function(msg){
                window.location = '/cart';
                var product     = msg.product;
                $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.cart_count').text(msg.product_cnt);
            },
            error   : function(){
                window.location = '/cart';
            }
        });
    }else{
        window.location = '/cart';
    }
});
$('#modal_add_product_cart').on('hide.bs.modal', function(e){
    var cnt = $('#modal_add_product_cart').find('input.my_b').val();
    var pId = $('#modal_add_product_cart').find('input.product_id').val();
    if(cnt.length > 0 && cnt > 1){
        $.ajax({
            type    : "POST",
            url     : "/products/cart-update-cnt",
            headers : {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            data    : {
                cnt : cnt,
                id  : pId
            },
            success : function(msg){
                var product = msg.product;
                $('.row_row').siblings('.navbar-default').find('.nav_li_menu').find('span.cart_count').text(msg.product_cnt);
            }
        });
    }
})
*/
