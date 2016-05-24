@extends('layouts.app')

@section('content')
<!-- Контейнер с адаптиными блоками -->
<div class="masonry">
    <!-- Адаптивные блоки с содержанием -->
    <div class="item">
        <img src="/img/custom/companies/5.jpg">
        <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>

    <div class="item">
        <img src="http://placehold.it/250x250">
        <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>

    <div class="item">
        <img src="http://placehold.it/470x320">
        <br>Здесь размещаете краткий анонс статьи, описание товара, картинки или видео... <a href="ссылка на полную запись">Подробнее »</a>
    </div>

    <!-- Конец адаптивных блоков с содержанием -->

</div>
<!-- Конец контейнера с адаптивными блоками -->
<style>
    /* ------------- Контейнер с адаптивными блоками------------- */
    .masonry {
        margin: 1.5em 0;
        padding: 0;
        column-gap: 1.5em; /* Общее расстояние между колонками */
        font-size: .85em;
        -moz-column-gap: 1.5em; /* Расстояние между колонками для Firefox */
        -webkit-column-gap: 1.5em; /* Расстояние между колонками  для Safari, Chrome и iOS */
    }

    /* Элементы в виде плиток с содержанием */
    .item {
        display: inline-block;
        background: #fff;
        padding: 1em;
        margin: 0 0 1.5em;
        width: 100%;
        box-sizing: border-box; /* Изменения алгоритма расчета ширины и высоты элемента.*/
        -moz-box-sizing: border-box; /* Для Firefox */
        -webkit-box-sizing: border-box; /* Для Safari, Chrome, iOS иAndroid */
        box-shadow: 2px 2px 4px 0 #ccc; /* Внешняя тень плиток */
    }

    /* Стили картинок, видое и фреймов внутри адаптивных плиток */
    img, iframe {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* Стили ссылок внутри плиток */
    .item a {
        text-decoration: none;
        color: #359CC6;
        margin: 0 10px;
    }

    /* Стили ссылок при наведении */
    .item a:hover {
        color: #E88F00;
        border-bottom: 1px dotted #9F1D35;
    }

    /* Медиа-запросы для различных размеров адаптивного макета */
    @media only screen and (min-width: 400px) {
        .masonry {
            -moz-column-count: 2;
            -webkit-column-count: 2;
            column-count: 2;
        }
    }

    @media only screen and (min-width: 700px) {
        .masonry {
            -moz-column-count: 3;
            -webkit-column-count: 3;
            column-count: 3;
        }
    }

    @media only screen and (min-width: 900px) {
        .masonry {
            -moz-column-count: 4;
            -webkit-column-count: 4;
            column-count: 4;
        }
    }

    @media only screen and (min-width: 1100px) {
        .masonry {
            -moz-column-count: 5;
            -webkit-column-count: 5;
            column-count: 5;
        }
    }

    @media only screen and (min-width: 1280px) {
        .wrapper {
            width: 1260px;
        }
    }

</style>
@endsection