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
                <div class="col-sm-12" style="padding: 10px">
                    Под таким номером пользователь не найден.
                    <div>
                        <button type="button" class="btn btn-info handle_reg_new">Зарегестрировать</button>
                    </div>

                </div>
            </div>

{{-----------------------------------------------------------------------------------------------------}}
            <div class="col-sm-12 user_new_registr" {{--style="display: none"--}}>
                <div class="panel panel-default">
                    <div class="panel-heading">Регистрация</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register-handle') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail <span class="required_css">*</span></label>

                                <div class="col-md-8">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Телефон <span class="required_css">*</span></label>

                                <div class="col-md-8">
                                    <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Имя <span class="required_css">*</span></label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Фамилия <span class="required_css">*</span></label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="surname" value="{{ old('surname') }}">

                                    @if ($errors->has('surname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('date_birth') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Дата рождения <span class="required_css">*</span></label>
                                <div class="col-md-8">
                                    <input type="text" id="datepicker" class="form-control" name="date_birth" value="{{ old('date_birth') }}">
                                    @if ($errors->has('date_birth'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('date_birth') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Пол <span class="required_css">*</span></label>
                                <div class="col-md-8">
                                    <label class="checkbox-inline"><input name="gender" type="radio" value="1" {{ old('gender')=="1" ? 'checked='.'"'.'checked'.'"' : '' }}>Мужчина</label>
                                    <label class="checkbox-inline"><input name="gender" type="radio" value="0" {{ old('gender')=="0" ? 'checked='.'"'.'checked'.'"' : '' }}>Женщина</label>
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @include('layouts.regionCityForRegister')

                            <div class="form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Улица</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="street" value="{{ old('street') }}">
                                    @if ($errors->has('street'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Дом</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="address" value="{{ old('address') }}">

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i><span style="margin-left: 5px">Начать регистрацию</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
{{-----------------------------------------------------------------------------------------------------}}



        </div>



    </div>

</div>
{!! HTML::script('/js/registerList.js') !!}
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
    $('.user_none').find('button.handle_reg_new').on('click', function () {

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