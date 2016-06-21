<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="css/welcome.css" />

<div class="row">
    <div class="col-md-2" style="position: relative;    padding-right: 0px;     ">
        <div class="category_title"><span>Категории товаров</span></div>
        {{----------------------------------------------------------------------------}}

        <?php
        function sho($data, $parent, $none = 'none'){?>
        <div class="category_parent_list" data-child="<?=$parent['id']?>" style="display: <?=$none?>">
            @foreach($data as $value)
                <div class="list" data-parent="{{$value['id']}}"><a href="/category/{{$value['id']}}">{{$value['title']}}</a><div class="span_category"><span class="icon"> &#62 </span></div> </div>
            @endforeach
        </div>
        <?php
        }
        ?>

        <script>
            $(document).ready(function(){
                $('[data-parent]').on('mouseover', function(){
                    var id = $(this).attr('data-parent');
                    
                    var parentDiv = $(this).parents('.category_list_navigation').eq(0);
                    var mainParent = parentDiv.parent();
                    var index = parentDiv.attr('data-index');

                    switch (index) {
                        case '1':
                            mainParent.find('[data-index="3"]').find('[data-child]').each(function(index, value){
                                $(value).hide();

                            });
                            mainParent.find('[data-index="2"]').find('[data-child]').each(function(index, value){
                                $(value).hide();


                            });
                            break
                        case '2':
                            mainParent.find('[data-index="3"]').find('[data-child]').each(function(index, value){
                                $(value).hide();


                            });
                            break
                    }

                    $('[data-child='+id+']').show();


                    var getLeftPos = function (elems){


                        var leftPos = 0;

                        $.each(elems, function (i, val) {
                            leftPos =+ $(this).width();

                        });

                        return leftPos;
                    };

                    var uls = $(this).parents('.category_list_navigation').eq(0).prev('.category_list_navigation');
                    var next = $(this).parents('.category_list_navigation').eq(0).next('.category_list_navigation');



                    var leftPos = getLeftPos(uls) + $(this).parents('.category_list_navigation').eq(0).width();


                    next.css({
                        'position' : 'absolute',
                        'left' :  leftPos + 'px'
                    });


                });
            /*    $('.menu_holder').on('mouseout', function(){
                    $('[data-index="2"]').hide();
                    $('[data-index="3"]').hide();

                });*/




            });




        </script>

        <div class="col-md-12">
            <div class="row menu_holder">
                <div class="col-md-12 category_list_navigation" data-index="1"><?php sho($category, array('id'=>'', 'title'=>'No'), 'block'); ?></div>
                <div class="col-md-12 category_list_navigation" data-index="2">
                    <?php
                    foreach ($category as $value) {
                        sho($value['nodes'], $value);
                    }
                    ?>
                </div>
                <div class="col-md-12 category_list_navigation" data-index="3">
                    <?php
                    foreach ($category as $parent) {
                        foreach ($parent['nodes'] as $value) {
                            sho($value['nodes'], $value);
                        }
                    }
                    ?>
                </div>
            </div>
        </div>


        {{----------------------------------------------------------------------------}}
    </div>
    <div class="col-md-8 ">
        <div class="panel panel-default">
            <div class="panel-body">

                @include('slide')



                <div class="category_pallet ">

                    <div class="galleryCategoryMenu col-sm-12">
                        <ul style="text-align: center;">
                            <li class="portraits"><a href="/care">ОДЕЖДА И ОБУВЬ<span></span></a></li>
                            <li class="sports"><a href="/sports">СПОРТ<span></span></a></li>
                            <li class="weddings"><a href="/weddings">КОМПЬЮТЕРЫ<span></span></a></li>
                            <li class="celebrations"><a href="/celebrations">АВТОТОВАРЫ<span></span></a></li>
                            <li class="animals"><a href="/animals">ЖИВОТНЫЕ<span></span></a></li>
                            <li class="personal"><a href="/entertainment">ЗООТОВАРЫ<span></span></a></li>
                            <li class="personal"><a href="/entertainment">ЕДА<span></span></a></li>
                            <li class="personal"><a href="/entertainment">БЫТОВАЯ ТЕХНИКА<span></span></a></li>
                            <li class="personal"><a href="/entertainment">ТЕЛЕФОНИ<span></span></a></li>
                            <li class="personal"><a href="/entertainment">ДЕТСКИЙ МИР<span></span></a></li>
                        </ul>
                    </div>

                </div>

                <div class="col-sm-12" ><h3>Магазины</h3></div>

                    <div class="col-sm-12" >
                        @foreach($companyAll as $valueCompanw)
                            <div class="col-md-3 carentFindCompany">
                                <div class="shop_show" style="border: solid 1px grey; margin: 3px;">
                                    <a class="">{{$valueCompanw->company_name}}</a>
                                    <input id="input_id" value="{{$valueCompanw->id}}" type="hidden"/>

                                    <?php  if(!empty($valueCompanw->company_logo)&& file_exists(public_path().'/img/custom/companies/thumbnail/'.$valueCompanw->company_logo)) {
                                        $logo = '/img/custom/companies/thumbnail/'.$valueCompanw->company_logo;
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
                            $directory = public_path().'/img/custom/companies/'.$idCompany.'/products/'.$idProduct;
                            $directoryMy = '/img/custom/companies/'.$idCompany.'/products/'.$idProduct.'/';
                            if(!empty($v['product_image']) && File::exists($directory.'/'.$v['product_image'])){
                                $firstFile = $directoryMy.$v['product_image'];
                            }else{
                                if(is_dir($directory)){
                                    $files = scandir($directory);
                                    $firstFile = $directoryMy.$files[2];// because [0] = "." [1] = ".."
                                    if(is_dir(public_path().$firstFile)){
                                        if(isset($files[3]))
                                            $firstFile = $directoryMy.$files[3];
                                        else
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
                                        <br>   <p style="font-size: 14px;">{{$v->content}}</p>
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


