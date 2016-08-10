$('.button_delete').on('click', function(){
    var id = $(this).parents('.my_my').find('input.input_id_del').val()
    var currentBlock = $(this).parents('.product_item_cart').eq(0);
    var button = $(this);
    
    $.ajax({
        type: "POST",
        url: "/cart/destroy-product",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id
        },
        success: function(msg){
            window.location = '';
            return;
            if(msg.product_cnt == 0){
                button.parents('.product_item_cart').parents('.row').eq(0).find('.cart_empty').show();
            }
            if(msg.in_current_company == 0){
                currentBlock.parents('.company_block_cart').hide();
            }

            $('.cart_count').text(msg.product_cnt);
            currentBlock.remove();
        }
    });
});
