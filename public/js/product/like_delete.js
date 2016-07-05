$('.button_delete').on('click', function(){
    var id = $(this).siblings('input').val();
    var currentBlock = $(this).parents('.product_item_like').eq(0);
    var button = $(this);



    $.ajax({
        type: "POST",
        url: "/like/destroy-product",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: id
        },
        success: function(msg){


            if(msg.product_cnt == 0){
                button.parents('.product_item_like').parents('.row').eq(0).find('.like_empty').show();

            }

            $('.like_count').text(msg.product_cnt);
            currentBlock.remove();
        }
    });


});
