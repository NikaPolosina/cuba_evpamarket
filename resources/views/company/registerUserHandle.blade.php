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
            <div class="user_holder col-sm-12" style="display: none">
                <a class="add_hendle_order" href="">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <div class="user_photo">
                                <img src="/img/placeholder/avatar.jpg" alt="">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="user_name">

                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="user_none col-sm-12" style="display: none">
                <div class="col-sm-12">
                    Под таким номером пользователь не найден.
                </div>
            </div>

        </div>



    </div>

</div>

<script>
$('.find_user_number').on('click', function () {

    $('a.add_hendle_order').attr('href','');
    $('.user_holder').find('.user_name').html('');
    $('.user_photo').find('img').attr('src', '/img/placeholder/avatar.jpg');

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
                $('a.add_hendle_order').attr('href','/add-handle-order/'+msg.user.id+'/'+ company_id);
                $('.user_holder').find('.user_name').html(msg.user.get_user_information.name+ '   ' + msg.user.get_user_information.surname);

                if(!msg.user.get_user_information.avatar.length){
                    $('.user_photo').find('img').attr('src', '/img/placeholder/avatar.jpg');
                }else{
                    $('.user_photo').find('img').attr('src', msg.user.get_user_information.avatar);
                }
                $('.user_none').hide();
                $('.user_holder').show();

            }else{
                $('.user_holder').hide();
                $('.user_none').show();
            }

        }
    });
});

</script>
<style>

    .user_holder{
        border: solid 1px #dddddd;
        background-color: whitesmoke;
    }
    .user_none{
        border: solid 1px #dddddd;
        background-color: whitesmoke;
        margin: 5px;
    }
</style>