

<div class="col-sm-12 setting_overall_body">
    <div class="col-sm-6">
        <div class="div_overall"><span class="span_overall">Ваше имя: </span><input value="{{$userInfo->name}}" name="name" type="text"/></div>
        <div class="div_overall"><span class="span_overall">Ваша фамилия: </span><input value="{{$userInfo->surname}}" name="surname" type="text"/></div>
        <div class="div_overall"><span class="span_overall">Улица: </span><input value="{{$userInfo->street}}" name="street" type="text"/></div>
        <div class="div_overall"><span class="span_overall">Номер дома</span><input value="{{$userInfo->address}}" name="address" type="text"/></div>

        <button type="button" class="btn btn-default button_setting_overall">Изменить</button>
    </div>
    <div class="col-sm-6">
        <div data-id ="message" class="alert alert-success" role="alert" style="display: none"> </div>
    </div>

</div>
<script>
    $('.button_setting_overall').on('click', function(){
       var name = $('[name="name"]').val();
       var surname = $('[name="surname"]').val();
       var street = $('[name="street"]').val();
       var address = $('[name="address"]').val();

        
        $.ajax({
            type: "POST",
            url: 'user/simple_user/setting/security/edit',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                surname: surname,
                street: street,
                address: address
            },
            success: function(msg){

                $('div[data-id ="message"]').text('Инфрмация успешно сохранена.').toggle('slow');
                setTimeout(function(){
                    $('div[data-id ="message"]').text('').toggle('slow');
                }, 4000);


            }
        });

    });
    
</script>

<style>
    .span_overall{
        display: inline-block;
        width: 100px;
    }
    .div_overall{
        margin: 1px;
    }
    .setting_overall_body{

    }
    .button_setting_overall{
        float: right;
    }

</style>