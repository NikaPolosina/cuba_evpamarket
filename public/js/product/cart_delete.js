$('.button_delete').on('click', function(){
    var hash = $(this).attr('data-hash');
    var company = $(this).attr('data-company');
    var currentBlock = $(this).parents('.product_item_cart').eq(0);
    var button = $(this);


    $.ajax({
        type: "POST",
        url: "/cart/destroy-product",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            hash: hash,
            company: company
        },
        success: function(msg){
            window.location = '';
        }
    });
});
