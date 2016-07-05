$(document).ready(function(){
    var secondLevelHolderHeight = $('.category_list_navigation').height();
    var secondLevelHolderWidth  = $('.category_list_navigation[data-index="1"]').width() * 2;
    $('.second_level_holder').height(secondLevelHolderHeight);
    $('.second_level_holder').width(secondLevelHolderWidth);
    $('.scroll_up').on('click', function(){
        var box = $(this).parent().find('.box');
        var btop  = $(this).offset().top;
        var sctop = $(this).parent().find('.category_list_navigation ').offset().top;
        if(sctop < btop){
            var h = parseInt(box.find('.category_list_navigation').css('transform').split(',')[5]) + 32;
            box.find('.category_list_navigation ').css({transform : 'translateY(' + h + 'px)'});
            $(this).parents('.categories_holder').eq(0).find('.scroll_down').show();
        }else{
            $(this).parents('.categories_holder').eq(0).find('.scroll_up').hide();
        }
    });
    $('.scroll_down').on('click', function(){
        var box = $(this).parent().find('.box');
        var btop   = $(this).offset().top;
        var sctop  = $(this).parent().find('.category_list_navigation ').offset().top;
        var blockH = $(this).parent().find('.category_list_navigation ').height();
        var s      = sctop + blockH;
        if((s > btop) && ((s - btop - 32) >= 1)){
            var h = parseInt(box.find('.category_list_navigation').css('transform').split(',')[5]) - 32;
            box.find('.category_list_navigation ').css({transform : 'translateY(' + h + 'px)'});
            $(this).parents('.categories_holder').eq(0).find('.scroll_up').show();
        }else{
            $(this).parents('.categories_holder').eq(0).find('.scroll_down').hide();
        }
    });
    $('[data-parent]').on('mouseover', function(){
        var id         = $(this).attr('data-parent');
        var parentDiv  = $(this).parents('.category_list_navigation').eq(0);
        var mainParent = parentDiv.parents('.menu_holder').eq(0);
        var index      = parentDiv.attr('data-index');
        switch(index){
            case '1':
                mainParent.find('[data-index="3"]').find('[data-child]').each(function(index, value){
                    $(value).hide();
                });
                mainParent.find('[data-index="3"]').parents('.categories_holder').eq(0).find('.scroll_block').hide();
                mainParent.find('[data-index="2"]').find('[data-child]').each(function(index, value){
                    $(value).hide();
                });
                mainParent.find('[data-index="2"]').parents('.categories_holder').eq(0).find('.scroll_block').hide();
                break
            case '2':
                mainParent.find('[data-index="3"]').find('[data-child]').each(function(index, value){
                    $(value).hide();
                });
                mainParent.find('[data-index="3"]').parents('.categories_holder').eq(0).find('.scroll_block').hide();
                break
        }
        $('[data-index]').css({'transform' : 'translateY(0)'});
        if(index == '1'){
            if($(this).attr('data-img').length > 0){
                $('.im').find('img').attr('src', '/img/category_img/' + $(this).attr('data-img') + '.png');
                //$(this).find('a').eq(0).attr('href');
            }
        }
        var child = $('[data-child=' + id + ']');
        child.show();
        if((child.height()) > secondLevelHolderHeight){
            var categoriesHolder = child.parents('.categories_holder').eq(0);
            categoriesHolder.find('.scroll_block').eq(1).show();
        }
        var getLeftPos = function(elems){
            var leftPos = 0;
            $.each(elems, function(i, val){
                leftPos = +$(this).width();
            });
            return leftPos;
        };
        var uls        = $(this).parents('.category_list_navigation').eq(0).prev('.category_list_navigation');
        var next       = $(this).parents('.category_list_navigation').eq(0).next('.category_list_navigation');
        var leftPos    = getLeftPos(uls) + $(this).parents('.category_list_navigation').eq(0).width();
        next.css({
            'position' : 'absolute',
            'left'     : leftPos + 'px'
        });
    });
});
