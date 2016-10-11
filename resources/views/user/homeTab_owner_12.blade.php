<div class="row profile-account">
    <div class="col-md-3">
        <ul class="ver-inline-menu tabbable margin-bottom-10">
            <li class="active">
                <a data-toggle="tab" href="#tab_1-1">
                    <i class="fa fa-cog"></i> Персональная информация </a>
                <span class="after"> </span>
            </li>
            <li>
                <a data-toggle="tab" href="#tab_2-2">
                    <i class="fa fa-picture-o"></i> Сменить Аватар </a>
            </li>
            <li>
                <a data-toggle="tab" href="#tab_3-3">
                    <i class="fa fa-lock"></i> Сменить Пароль </a>
            </li>
            <li>
                <a data-toggle="tab" href="#tab_4-4">
                    <i class="fa fa-eye"></i> Приватность</a>
            </li>
        </ul>
    </div>

    <div class="col-md-9">
        <div class="tab-content">
            <div id="tab_1-1" class="tab-pane active">
                <form role="form" action="/user/simple_user/setting/security/edit-owner" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label">Имя</label>
                        <input type="text" value="{{$userInfo->name}}" class="form-control" name="name" required /> </div>
                    <div class="form-group">
                        <label class="control-label">Фамилия</label>
                        <input type="text" value="{{$userInfo->surname}}" class="form-control"  name="surname" required /> </div>
                    <div class="form-group">
                        <label class="control-label">Номер Телефона</label>
                        <input type="text" value="{{$userInfo->getUser->phone}}" class="form-control" name="phone" required/> </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input type="text" value="{{$userInfo->getUser->email}}" class="form-control" name="email" required  /> </div>
                    <div class="form-group">
                        <label class="control-label">Обо мне</label>
                        <textarea  class="form-control" rows="3" name="about_me">{{$userInfo->about_me}}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Веб. сайт</label>
                        <input type="text" value="{{$userInfo->my_site}}" class="form-control" name="my_site" /> </div>
                    <div class="form-group">
                        <label class="control-label">Улица</label>
                        <input type="text" value="{{$userInfo->street}}" class="form-control" name="street"/> </div>
                    <div class="form-group">
                        <label class="control-label">Номер дома</label>
                        <input type="text" value="{{$userInfo->address}}" class="form-control" name="address"/> </div>
                    <div class="margiv-top-10">
                        <button type="submit" class="btn green">Сохранить изменения</button>
                        <button type="reset" class="btn default">Отменить</button>
                    </div>
                </form>
            </div>

            <div id="tab_2-2" class="tab-pane">
                <p> Для загрузки аватара нажмите кнопку "Загрузить фото".
                </p>
                <form action="/avatar-uploader" role="form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                @if(!empty($userInfo->avatar) && file_exists(public_path().$userInfo->avatar))
                                    <img src="{{$userInfo->avatar}}" alt="avatar">
                                @else
                                    <img src="/img/placeholder/avatar.jpg" alt="avatar" />
                                @endif </div>
                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                            <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> Выбрать фото </span>
                                                                            <span class="fileinput-exists"> Изменить </span>
                                                                            <input type="file" name="avatar"> </span>
                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Отменить </a>
                            </div>
                        </div>

                    </div>
                    <div class="margin-top-10">
                        <button type="submit" class="btn green">Сохранить</button>
                    </div>
                </form>
            </div>



            <div id="tab_3-3" class="tab-pane">
                <form action="#">
                    <div class="form-group">
                        <label class="control-label">Старый Пароль</label>
                        <input type="password" class="form-control" /> </div>
                    <div class="form-group">
                        <label class="control-label">Новый Пароль</label>
                        <input type="password" class="form-control" /> </div>
                    <div class="form-group">
                        <label class="control-label">Повторите Новый пароль</label>
                        <input type="password" class="form-control" /> </div>
                    <div class="margin-top-10">
                        <a href="javascript:;" class="btn green"> Изменить Пароль </a>
                        <a href="javascript:;" class="btn default"> Отменить </a>
                    </div>
                </form>
            </div>
            <div id="tab_4-4" class="tab-pane">
                <form action="#">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td> Возможность отправлять мне собщения от других пользователей. </td>
                            <td>
                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        <input type="radio" name="optionsRadios31" value="option1" /> Да
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        <input type="radio" name="optionsRadios31" value="option2" checked/> Нет
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td> Возможность просматривать мой профиль другими пользователями. </td>
                            <td>
                                <div class="mt-radio-inline">
                                    <label class="mt-radio">
                                        <input type="radio" name="optionsRadios41" value="option1" /> Да
                                        <span></span>
                                    </label>
                                    <label class="mt-radio">
                                        <input type="radio" name="optionsRadios41" value="option2" checked/> Нет
                                        <span></span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <!--end profile-settings-->
                    <div class="margin-top-10">
                        <a href="javascript:;" class="btn green"> Сохранить изменения </a>
                        <a href="javascript:;" class="btn default"> Отменить </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end col-md-9-->
</div>