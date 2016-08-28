$(document).ready(function(){
    var group_holder   = $('.group_holder');
    var selector       = group_holder.find('.group_selector');
    var invite_button  = group_holder.find('.invite_to_group');
    var currnetUserId;
    var currnetGroupId = invite_button.attr('data-group');
    var progress       = group_holder.find('.progress');
    var success        = group_holder.find('.invite_sent');
    var error          = group_holder.find('.invite_error');
    invite_button.on('click', function(){
        currnetUserId = selector.val();
        if(currnetUserId){
            progress.show();
            $.ajax({
                type    : "POST",
                url     : groupInviteUrl,
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {
                    user  : currnetUserId,
                    group : currnetGroupId
                },
                success : function(response){
                    progress.hide();
                    success.show();
                    setTimeout(function(){
                        success.hide(1000);
                    }, 2000);
                },
                error   : function(response){
                    progress.hide();
                    error.show();
                    setTimeout(function(){
                        error.hide(1000);
                    }, 2000);
                }
            });
        }
    });
    $('.advanced_search_result_data').delegate('.invite_to_group_search', 'click', function(){
        var current = $(this);
        var currnetUserId  = current.attr('data-user');
        var currnetGroupId = current.attr('data-group');
        var progress       = $('.advanced_search_result').find('progress');
        var success        = $('.advanced_search_result').find('.invite_sent');
        var error          = $('.advanced_search_result').find('.invite_error');
        if(currnetUserId.length && currnetGroupId.length){
            $.ajax({
                type    : "POST",
                url     : groupInviteUrl,
                headers : {
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data    : {
                    user  : currnetUserId,
                    group : currnetGroupId
                },
                success : function(response){
                    progress.hide();
                    success.show();
                    setTimeout(function(){
                        success.hide(1000);
                    }, 2000);
                    current.parents('.single_person_holder').eq(0).remove();
                },
                error   : function(response){
                    progress.hide();
                    error.show();
                    setTimeout(function(){
                        error.hide(1000);
                    }, 2000);
                }
            });
        }
    });
});