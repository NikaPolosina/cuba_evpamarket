/*
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
*/
$(function(){
    var action;
    $(".number-spinner button").mousedown(function(){
        btn   = $(this);
        input = btn.closest('.number-spinner').find('input');
        btn.closest('.number-spinner').find('button').prop("disabled", false);
        var price     = $(this).parents('.product_item_cart').eq(0).find('span.product_price_one').text();
        var price_all = $(this).parents('.product_item_cart').eq(0).find('span.all_product_price');
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
        calculateAmount($(this));
    }).mouseup(function(){
        clearInterval(action);
    });
});
var parent;
$(document).ready(function(){
    $('.switch').on('change', function(){
        parent = $(this).parents('.product_item_cart').eq(0);
        parent.removeClass('off');
        parent.removeClass('on');
        if($(this).prop('checked')){
            parent.addClass('on');
        }else{
            parent.addClass('off');
        }
        calculateAmount($(this));
    });
});
function calculateAmount(check){
    var mainParent                 = check.parents('.company_block_cart').eq(0);
    var input_total_history_amount = mainParent.find('input.total_history_amount');
    var span_total_amount          = mainParent.find('span.total_amount');
    var span_total                 = mainParent.find('span.total');
    var span_percent               = mainParent.find('span.percent');
    var showTotal                  = parseInt(input_total_history_amount.val());
    var current                    = 0;
    mainParent.find('.product_item_cart.on').each(function(){
        current += parseInt($(this).find('.all_product_price').text());
    });
    showTotal         = showTotal + parseInt(current);
    var discountTable = mainParent.find('.discount_table');

    if(discountTable.length){
        var tr = discountTable.find('tr[data-from]');
        tr.removeClass('current_discount');
        var percent = 0;
        tr.each(function(){
            percent = ($(this).attr('data-from') <= showTotal ) ? $(this).attr('data-percent') : percent;
        });
        percent = parseInt(percent);
        discountTable.find('tr[data-percent="' + percent + '"]').addClass('current_discount');
        span_percent.html(percent);
    }
    span_total_amount.html(current);
    span_total.html(showTotal);
}



