
$(document).ready(function() {
    $('input.input_rate').each(function(index){
        var input = $('input.input_rate').eq(index);
        if(input.val().length > 0){
            var rateHolder = input.parent().find('.feed_star_css');
           rateHolder.find('span:lt(' + input.val() + ')').addClass('feed_star_hover');
            rateHolder.find('span[data-str="'+input.val()+'"]').trigger('click');
        }
    });

});



$('.feed_star_css').find('span.span_star').on('mouseover', function () {
    var parent = $(this).parents('.feed_star_css');
    parent.find('span').removeClass('feed_star_hover');
    parent.find('span:lt(' + $(this).attr('data-str') + ')').addClass('feed_star_hover');
})
$('.feed_star_css').on('mouseleave', function () {
    if($(this).hasClass('clicked')){
        var active = $(this).find('span.active').attr('data-str');
        $(this).find('span').removeClass('feed_star_hover');
        $(this).find('span:lt(' + active + ')').addClass('feed_star_hover');
    }else{
        $(this).find('span').removeClass('feed_star_hover');
    }
})
$('.feed_star_css').find('span.span_star').on('click', function () {
    $(this).parent().find('span').removeClass('active');
    $(this).parent().addClass('clicked');
    $(this).addClass('active');
   /* console.log($(this).parent().parents('.par').eq(0).find('input.input_rate'));
    console.log($(this).attr('data-str'));
    return false;*/
    
    $(this).parent().parents('.par').eq(0).find('input.input_rate').val($(this).attr('data-str'));






    
});
