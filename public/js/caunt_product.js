$(function () {
    var action;
    $(".number-spinner button").mousedown(function () {
        btn = $(this);
        input = btn.closest('.number-spinner').find('input');
        btn.closest('.number-spinner').find('button').prop("disabled", false);
        var price = $(this).parents('.product_item_cart').eq(0).find('span.product_price_one').text();
        var price_all = $(this).parents('.product_item_cart').eq(0).find('span.all_product_price');
        if (btn.attr('data-dir') == 'up') {

                if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
                    input.val(parseInt(input.val()) + 1);
                    price_all.text(parseInt(parseInt(input.val()) * price));
                } else {
                    btn.prop("disabled", true);
                    clearInterval(action);
                }

        } else {
                if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
                    input.val(parseInt(input.val()) - 1);
                    price_all.text(parseInt(parseInt(input.val()) * price));
                } else {
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
        }
    }).mouseup(function () {
        clearInterval(action);
    });
});
