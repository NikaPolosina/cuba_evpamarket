var url = $('.singleMenu').find('.singleUtl');
url.on('click', function() {
    event.preventDefault();
    var userInfo =  '<?=$userInfo?>';
    var url = $(this).attr('href');

    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            userInfo: userInfo
        },
        success: function(msg){
          
            $('.myPageContent').find('.contentInfo').html(msg);
        }
    });
});


