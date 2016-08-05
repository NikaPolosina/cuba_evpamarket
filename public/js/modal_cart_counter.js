$(document).ready(function(){
    var action, btn, input, price, price_all, total_in_shop, total_in_shop_origin;
    $(".number-spinner button").mousedown(function(){
        cart_modal = $(cart_modal);
        btn   = $(this);
        input = cart_modal.find('.my_counter');

        btn.closest('.number-spinner').find('button').prop("disabled", false);

        price                = cart_modal.find('.m_h_product_price_one').val();
        price_all            = cart_modal.find('.m_all_product_price');
        total_in_shop        = cart_modal.find('.m_total_in_shop');
        total_in_shop_origin = cart_modal.find('.m_h_total_in_shop').val();


        if(btn.attr('data-dir') == 'up'){
            if(input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))){
                input.val(parseInt(input.val()) + 1);
                price_all.text(parseInt(parseInt(input.val()) * price));
            }else{
                btn.prop("disabled", true);
                clearInterval(action);
            }
        }else{
            if(input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))){
                input.val(parseInt(input.val()) - 1);
                price_all.text(parseInt(parseInt(input.val()) * price));
            }else{
                btn.prop("disabled", true);
                clearInterval(action);
            }
        }

        total_in_shop.html(parseInt(total_in_shop_origin) + parseInt(price) * (parseInt(input.val()) - 1));

    }).mouseup(function(){
        clearInterval(action);
    });
});    
    