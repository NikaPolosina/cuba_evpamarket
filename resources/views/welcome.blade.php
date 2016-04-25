<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                   <p style="display: inline-block"> Добро пожаловать!</p>


                    <form method="POST" action="find" style="display: inline-block; float: right">
                        {{ csrf_field() }}
                        <input name="find" type="text" placeholder="Введите текст для поиска"/>
                        <p style="display: inline-block"><input type="submit" value="Искать">
                    </form>

                </div>

                <div class="panel-body">
                    <img style="width: 100%; height: 70%" src="\img\bg.jpg" alt="альтернативный текст">
                </div>

            </div>




            <div>
                <?php
                    if(isset($data)){
                        echo'Искомое слово - '.$search.'<br>';
                        echo 'Время выполнения - '.(time() - $time).'секунд. <br>';
                        echo 'Найдено записей - '.count($data);

                    ?>
                        <div>
                            <?php
                                foreach ($data as $value) {?>
                                    <div>
                                        ID - <?=$value->id?>
                                        Искомая строка - <?=$value->product_description?>
                                    </div>
                                    </div>
                                <?php }
                                ?>
                        </div>
                        <hr>
                    <?php }

                    ?>

            </div>
            
            
        </div>

    </div>
</div>

    
    
@endsection
<style>
    a:hover {
        text-decoration: none!important; /* Отменяем подчеркивание у ссылки */
    }
</style>