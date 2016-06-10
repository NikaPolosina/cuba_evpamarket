
<div class="col-sm-12">

    <ul class="nav nav-tabs">
        @foreach($menu_setting as $item)
            <li class="singleMenu"><a class="singleUtl settingUrl" href="{{$item['url']}}">{{$item['title']}}</a></li>
        @endforeach
    </ul>
    <div class="col-sm-12 setting_body">

    </div>
</div>

<script>
    var url = $('.singleMenu').find('.settingUrl');
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
                $('.setting_body').html(msg);
            }
        });
    });


</script>
<style>
    .nav-tabs>li>a {
        border-radius: 4px;
    }
    .nav-tabs>li>a {
         margin-right: 0px;
    }
    .setting_body{

    }

</style>
