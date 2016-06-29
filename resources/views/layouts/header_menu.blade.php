
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" style="padding: 0px 15px;" href="{{ url('/') }}"> <img class="logo" src="/img/system/logo.png" style="width: 50px; "></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="col-md-6 col-md-offset-3">

                <div class="input-group col-sm-12">
                    <form style=" margin: 7px 0px 0px 0px;" class="input-group" method="POST" action="/find">
                        {{ csrf_field() }}

                                <span style=" top: 0px;" class="input-group-addon  glyphicon glyphicon-search" aria-hidden="true"></span>
                                 <input class="form-control" name="find" type="text" placeholder="Введите текст для поиска"/>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Поиск</button>
                                    </span>
                    </form>
                </div>

            </div>

            <ul class="nav navbar-nav navbar-right nav_li_menu">
                <li><a style="float: left" href="">
                        <img class="header_icon" src="/img/system/like1.png" alt=""/>
                        <span>Желания</span>
                    </a>
                </li>
                <li><a style="float: left" href="">
                        <img class="header_icon" src="/img/system/shopping-cart.png" alt=""/>
                        <span>Корзина</span>
                    </a>
                </li>

                @if (Auth::guest())
                    <li><a style="float: left" href="{{ url('/register-c') }}">
                            <img class="header_icon" src="/img/system/clipboard-with-pencil.png" alt=""/>
                            <span>Регистрация</span>
                        </a>
                    </li>
                    <li><a href="{{ url('/login') }}">
                            <img class="header_icon" src="/img/system/login.png" alt=""/>
                            <span>Вход</span>
                        </a>
                    </li>
               @else
                    <li><a href="{{ url('/home') }}">Домой</a></li>
                    <li class="dropdown">
                        <?php if(Auth::user()->getUserInformation){?>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->getUserInformation->name }}
                            <span class="caret"></span>
                        </a>
                        <?php  }  ?>

                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выйти</a></li>
                        </ul>
                    </li>
                @endif

            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
{{-----------------------------------------------------------}}

<script>

    $('.input-group').on('submit', function(){
    var input = $('.form-control');
    if(input.val().length < 1){
        input.focus();
        return false;
    }
    });

</script>

<style>

    .nav_li_menu>li{
        border: 1px solid #dedbdb;
        width: 70px;
        border-radius: 6px;
        height: 70px;
        text-align: center;
        box-shadow: 2px 0 0 1px rgba(0, 0, 0, 0.38);
        margin: 2px;
    }

    .logo {

        animation: turn 5s infinite;
    }

    @-webkit-keyframes turn {
        to {
            -webkit-transform: rotateY(360deg);
        }
    }
    @keyframes turn {
        to {
            transform: rotateY(360deg);
        }
    }
</style>
