
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

                                <span style=" top: 0px!important; display:table-cell;" class="input-group-addon  glyphicon glyphicon-search" aria-hidden="true"></span>
                                 <input class="form-control" name="find" type="text" placeholder="Введите текст для поиска"/>
                                  <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Поиск</button>
                                    </span>
                    </form>
                </div>

            </div>

            <ul class="nav navbar-nav navbar-right nav_li_menu">
                @if(!Auth::guest())
                <li><a href="/like">
                        <img class="header_icon" src="/img/system/like1.png" alt=""/><div class="count_product_like count_product_cart_css" > <span class="like_count"> @if(isset($product_cnt_like)){{$product_cnt_like}}@endif</span></div>
                        <span>Желания</span>
                    </a>
                </li>
                @endif
                <li><a  style="position: relative;" href="/cart">
                        <img class="header_icon" src="/img/system/shopping-cart.png" alt=""/> <div class="count_product_cart count_product_cart_css" > <span class="cart_count"> @if(isset($product_cnt)){{$product_cnt}}@endif</span></div>
                        <span>Корзина</span>
                    </a>
                </li>

                @if (Auth::guest())
                    <li><a  href="{{ url('/register-c') }}">
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

                        <li><a href="{{ url('/login-user') }}">
                                <img class="header_icon" src="/img/system/home.png" alt=""/>
                                <span>Домой</span>
                            </a>
                        </li>


                    <li class="dropdown">

                        <?php if(Auth::user()->getUserInformation){?>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img class="header_icon" src="/img/system/exit.png" alt=""/>
                            {{ Auth::user()->getUserInformation->name }}
                            <span class="caret"></span>
                        </a>
                        <?php  }  ?>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/login-user/#tab_1_2"> Настройки аккаунта </a>
                            </li>
                            <li>
                                <a href="/login-user/#tab_1_3"> Помощь </a>
                            </li>
                            <li>
                                <a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Выйти</a>
                            </li>

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
    .navbar{
        margin-bottom: 0px!important;

    }
    .input-group-addon {
        border-radius: 4px 0px 0px 4px!Important;
    }

    .nav_li_menu>li>a{
        padding: 10px 10px;

    }
    .count_product_cart_css{
        position: absolute!important;
        top: 30px!important;
        background-color: red!important;
        border: solid 2px white!important;
        width:20px!important;
        height: 20px!important;
        border-radius: 50%!important;
        text-align: center!important;
        line-height: 18px!important;
    }
.count_product_cart_css span{
    color: white!important;


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


     .required_css{
         color: red;
     }


</style>
