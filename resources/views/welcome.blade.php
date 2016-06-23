<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="css/welcome.css"/>



    <?php
    function sho($data, $parent, $none = 'none'){?>
    <div class="category_parent_list" data-child="<?=$parent['id']?>" style="display: <?=$none?>">
        @foreach($data as $value)
            <div class="list" data-parent="{{$value['id']}}" data-img="{{$value['img']}}">
                <a href="/category/{{$value['id']}}">{{$value['title']}}</a>
            </div>
        @endforeach
    </div>
    <?php
    }
    ?>


    <div class="row">

        <style>

            .menu_holder {
                /*  display: inline-block;*/
                position: relative;
            }

            .menu_holder .category_list_navigation {
                list-style-type: none;
                /* width: 205px;*/
            }

            .second_level_holder {
                position: absolute;
                left: 100%;
                top: 0;
                width: 600px;
                height: 544px;
                z-index: 80;
                background-color: #fcfcee;
                background-size: contain;
                background-position: center;
                box-shadow: 3px 3px 7px 0 rgba(200, 200, 200, .5);
                cursor: pointer;
                display: none;
            }

            .menu_holder:hover .second_level_holder {
                display: block;
                /*background-image: '';*/
            }

            .category_list_navigation {
                transform: translateY(0);
            }
            .category_list_navigation div {
                /*outline: solid #000000 1px;*/
            }

            .disable_right_padding {
                padding-right: 0px;
            }

            .disable_left_padding {
                padding-left: 0px;
            }

            .box {
                max-height: 544px;
                overflow: hidden;
            }

            .scroll_block {
                text-align: center;
                width: 100%;
                cursor: pointer;
                display: none;
            }

            .scroll_block:hover{
                background: transparent;
            }

            .scroll_up{
                background: linear-gradient(to top, rgba(254, 252, 234, 0.72), #a6a6a6);
                position: absolute;
                top: 0;
                z-index: 100;
                /*display: none;*/
            }
            .scroll_down{
                background: linear-gradient(to bottom, rgba(254, 252, 234, 0.72), #a6a6a6);
                position: absolute;
                bottom: 0;
                z-index: 100;
               /* display: none;*/
            }
            .img_scroll{
                margin: auto;
            }

            .im{
                position: absolute;
                top: 0;
                right: 0;
                z-index: -1;

            }
            .im img{
                height: 100%;
            }
        </style>

        <div class="col-md-2" style="  padding-right: 0px;  ">
            <div class="category_title"><span>Категории товаров</span></div>

            <div class="menu_holder">

                <div class="category_list_navigation" data-index="1">
                    <?php sho($category, array(
                            'id'    => '',
                            'title' => 'No'
                    ), 'block'); ?>
                </div>


                <div class="second_level_holder">

                    <div class="menu_holder">

                        <div class="row">


                            <div class="col-md-6  disable_right_padding categories_holder">
                                <div class="scroll_block scroll_up"><img class="img_scroll" src="/img/system/up.png" alt=""/></div>
                                <div class="box">
                                    <div class="category_list_navigation " data-index="2">
                                        <?php
                                        foreach($category as $value){
                                            sho($value['nodes'], $value);
                                        } ?>
                                    </div>
                                </div>
                                <div class="scroll_block scroll_down"><img class="img_scroll" src="/img/system/down.png" alt=""/></div>
                            </div>

                            <div class="col-md-6 disable_left_padding categories_holder">
                                <div class="scroll_block scroll_up"><img class="img_scroll" src="/img/system/up.png" alt=""/></div>
                                <div class="box">
                                    <div class="category_list_navigation " data-index="3">
                                        <?php
                                        foreach($category as $parent){
                                            foreach($parent['nodes'] as $value){
                                                sho($value['nodes'], $value);
                                            }
                                        } ?>
                                    </div>
                                </div>
                                <div class="scroll_block scroll_down"><img class="img_scroll" src="/img/system/down.png" alt=""/></div>
                            </div>

                        </div>

                    </div>

                    <span class="im"><img src=""></span>

                </div>


            </div>

            <script>
                $(document).ready(function () {

                    var secondLevelHolderHeight  = $('.category_list_navigation').height();
                    var secondLevelHolderWidth  = $('.category_list_navigation[data-index="1"]').width()*2;

                    $('.second_level_holder').height(secondLevelHolderHeight);
                    $('.second_level_holder').width(secondLevelHolderWidth);

                    $('.scroll_up').on('click', function () {
                        var box = $(this).parent().find('.box');

                        var btop = $(this).offset().top;
                        var sctop = $(this).parent().find('.category_list_navigation ').offset().top;

                        if(sctop < btop){
                            var h = parseInt( box.find('.category_list_navigation').css('transform').split(',')[5] )+32;
                            box.find('.category_list_navigation ').css({transform: 'translateY('+h+'px)'});
                            $(this).parents('.categories_holder').eq(0).find('.scroll_down').show();

                        }else{
                            $(this).parents('.categories_holder').eq(0).find('.scroll_up').hide();
                        }
                    });

                    $('.scroll_down').on('click', function () {
                        var box = $(this).parent().find('.box');

                        var btop = $(this).offset().top;
                        var sctop = $(this).parent().find('.category_list_navigation ').offset().top;
                        var blockH = $(this).parent().find('.category_list_navigation ').height();
                        var s = sctop + blockH;

                        if((s > btop) && ((s - btop - 32) >= 1)){
                            var h = parseInt( box.find('.category_list_navigation').css('transform').split(',')[5] )-32;
                            box.find('.category_list_navigation ').css({transform: 'translateY('+h+'px)'});
                            $(this).parents('.categories_holder').eq(0).find('.scroll_up').show();
                        }else{
                            $(this).parents('.categories_holder').eq(0).find('.scroll_down').hide();
                        }




                    });


                    $('[data-parent]').on('mouseover', function () {
                        var id = $(this).attr('data-parent');
                        var parentDiv = $(this).parents('.category_list_navigation').eq(0);
                        var mainParent = parentDiv.parents('.menu_holder').eq(0);
                        var index = parentDiv.attr('data-index');

                        switch (index) {
                            case '1':
                                mainParent.find('[data-index="3"]').find('[data-child]').each(function (index, value) {

                                    $(value).hide();
                                });
                                mainParent.find('[data-index="3"]').parents('.categories_holder').eq(0).find('.scroll_block').hide();

                                mainParent.find('[data-index="2"]').find('[data-child]').each(function (index, value) {
                                    $(value).hide();
                                });
                                mainParent.find('[data-index="2"]').parents('.categories_holder').eq(0).find('.scroll_block').hide();

                                break
                            case '2':
                                mainParent.find('[data-index="3"]').find('[data-child]').each(function (index, value) {
                                    $(value).hide();
                                });
                                mainParent.find('[data-index="3"]').parents('.categories_holder').eq(0).find('.scroll_block').hide();



                                break
                        }

                        $('[data-index]').css({'transform': 'translateY(0)'});

                        if(index == '1'){
                            if($(this).attr('data-img').length > 0)
                                $('.im').find('img').attr('src', '/img/category_img/'+$(this).attr('data-img')+'.png');
                        }


                        var child = $('[data-child=' + id + ']');

                        child.show();
                        if((child.height()) > secondLevelHolderHeight){
                            var categoriesHolder = child.parents('.categories_holder').eq(0);
                            categoriesHolder.find('.scroll_block').eq(1).show();

                        }



                        var getLeftPos = function (elems) {
                            var leftPos = 0;
                            $.each(elems, function (i, val) {
                                leftPos = +$(this).width();
                            });
                            return leftPos;
                        };
                        var uls = $(this).parents('.category_list_navigation').eq(0).prev('.category_list_navigation');
                        var next = $(this).parents('.category_list_navigation').eq(0).next('.category_list_navigation');
                        var leftPos = getLeftPos(uls) + $(this).parents('.category_list_navigation').eq(0).width();
                        next.css({
                            'position': 'absolute',
                            'left': leftPos + 'px'
                        });
                    });
                });
            </script>


        </div>
        <div class="col-md-8 ">
            <div class="panel panel-default">
                <div class="panel-body">

                    @include('slide')


                    <div class="category_pallet ">

                        <div class="galleryCategoryMenu col-sm-12">
                            <ul style="text-align: center;">
                                @foreach($vip_category as $v)
                                    <li class="portraits">
                                        <div class="col-sm-12" style="padding-right: 0px; padding-left: 0px;">
                                            <a href="/category/{{$v->id}}">
                                                <p class="col-sm-7">{{$v->title}}</p>
                                                <img class="col-sm-5" style=" float: right;padding: 0px; margin: 0px;"
                                                     src="img/category_icon/{{$v->icon}}.png" alt=""/>
                                            </a>


                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    <div class="col-sm-12"><h3>Магазины</h3></div>

                    <div class="col-sm-12">
                        @foreach($companyAll as $valueCompanw)
                            <div class="col-md-3 carentFindCompany">
                                <div class="shop_show" style="border: solid 1px grey; margin: 3px;">
                                    <a class="">{{$valueCompanw->company_name}}</a>
                                    <input id="input_id" value="{{$valueCompanw->id}}" type="hidden"/>

                                    <?php  if(!empty($valueCompanw->company_logo) && file_exists(public_path() . '/img/custom/companies/thumbnail/' . $valueCompanw->company_logo)){
                                        $logo = '/img/custom/companies/thumbnail/' . $valueCompanw->company_logo;
                                    }else{
                                        $logo = '/img/custom/files/thumbnail/plase.jpg';
                                    } ?>

                                    <img class="img-thumbnail" style="display: block; width: 100%;" src="{{$logo}}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr/>
                    <div class="col-sm-12"><h3>Товары</h3></div>
                    <div class="col-sm-12">
                        <?php foreach($productAll as $v){
                        $idProduct = $v['id'];
                        $idCompany = $v->getCompany[0]['id'];
                        $directory = public_path() . '/img/custom/companies/' . $idCompany . '/products/' . $idProduct;
                        $directoryMy = '/img/custom/companies/' . $idCompany . '/products/' . $idProduct . '/';
                        if(!empty($v['product_image']) && File::exists($directory . '/' . $v['product_image'])){
                            $firstFile = $directoryMy . $v['product_image'];
                        }else{
                            if(is_dir($directory)){
                                $files = scandir($directory);
                                $firstFile = $directoryMy . $files[2];// because [0] = "." [1] = ".."
                                if(is_dir(public_path() . $firstFile)){
                                    if(isset($files[3]))
                                        $firstFile = $directoryMy . $files[3];else
                                        $firstFile = '/img/custom/files/thumbnail/plase.jpg';
                                }
                            }else{
                                $firstFile = '/img/custom/files/thumbnail/plase.jpg';
                            }
                        }
                        ?>
                        <div class="col-md-3">
                            <div class="carentFindProduct">
                                <div class="item">
                                    <p><h4 class="show-product">{{$v->product_name}}</h4></p>
                                    @if(isset($firstFile))
                                        <img class="img-thumbnail show-product" src="{{$firstFile}}">
                                    @endif
                                    <input class="input_id_product" value="{{$v->id}}" type="hidden"/>
                                    <br>

                                    <p style="font-size: 14px;">{{$v->content}}</p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2" style="border: solid 1px red;">
            Новости о акциях
        </div>
    </div>
    {!! HTML::script('/js/welcome.js') !!}
@endsection


