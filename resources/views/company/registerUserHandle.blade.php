<div class="row">
    <div class="col-sm-12">
        <h4>Регистрация в ручном режиме</h4>
        <div class="row">
            <div class="input-group col-sm-12">


                <span style="right: 0px!important; top: 0px!important; display:table-cell;" class="input-group-addon  glyphicon glyphicon-search" aria-hidden="true"></span>
                <input class="form-control input_find_user" name="find-number" type="number" placeholder="Введите номер телефона..."/>
                                  <span class="input-group-btn find_user_number">
                                        <button class="btn btn-default" type="button">Поиск</button>
                                    </span>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 user_holder">
                <div class="col-sm-4">
                    <div class="user_photo">
                        <img src="/img/placeholder/avatar.jpg" alt="">
                    </div>
                </div>
                <div class="col-sm-8" style="margin-top: 10%;">
                    <div class="user_name">

                    </div>
                </div>
            </div>
        </div>



    </div>

</div>

<script>
$('.find_user_number').on('click', function () {
    var number = $('.input_find_user').val();
    $.ajax({
        type    : "POST",
        url     : "/find-user-by-number",
        headers : {
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        data    : {
            number : number
        },
        success : function(msg){


            if(msg.user != null){
                $('.user_holder').find('.user_name').html(msg.user.get_user_information.name+ '   ' + msg.user.get_user_information.surname);


                if(!msg.user.get_user_information.avatar.length){
                    $('.user_photo').find('img').attr('src', '/img/placeholder/avatar.jpg');
                }else{
                    $('.user_photo').find('img').attr('src', msg.user.get_user_information.avatar);
                }

            }


           /* $('.user_holder').show();*/

            
        }
    });
});


  
</script>
<style>

    .user_holder{
        border: solid 1px #dddddd;
        background-color: whitesmoke;
    }
</style>