<?php

function sho($data, $parent, $none = 'none'){?>
<div class="category_parent_list" data-child="<?=$parent['id']?>" style="display: <?=$none?>">
    @foreach($data as $value)
        <div class="list {{(count($value['nodes'])) ? 'list_with_child' : 'list_non_child' }}" data-parent="{{$value['id']}}" data-img="{{$value['img']}}">
            <a href="/find/category/{{$value['id']}}">{{$value['title']}}</a>
        </div>
    @endforeach
</div>
<?php
}
?>

<link rel="stylesheet" type="text/css" href="/css/category_menu.css"/>


<div class="col-xs-3 col-md-2" style="  padding-right: 0px;">
    <div class="category_title"><span>Каталог товаров</span></div>
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
                        <div class="scroll_block scroll_up"><img class="img_scroll" src="/img/system/up.png" alt=""/>
                        </div>
                        <div class="box">
                            <div class="category_list_navigation " data-index="2">

                                <?php

                                foreach($category as $value){
                                    if(($value['nodes'])){
                                        sho($value['nodes'], $value);
                                    }
                                }

                                ?>

                            </div>
                        </div>
                        <div class="scroll_block scroll_down">
                            <img class="img_scroll" src="/img/system/down.png" alt=""/></div>
                    </div>

                    <div class="col-md-6 disable_left_padding categories_holder">
                        <div class="scroll_block scroll_up"><img class="img_scroll" src="/img/system/up.png" alt=""/>
                        </div>
                        <div class="box">
                            <div class="category_list_navigation " data-index="3">
                                <?php
                                foreach($category as $parent){


                                    if($parent['nodes']){
                                        foreach($parent['nodes'] as $value){
                                            if(($value['nodes'])){
                                                sho($value['nodes'], $value);
                                            }
                                        }
                                    }



                                } ?>
                            </div>
                        </div>
                        <div class="scroll_block scroll_down">
                            <img class="img_scroll" src="/img/system/down.png" alt=""/></div>
                    </div>

                </div>

            </div>

            <span class="im"><img src=""></span>





        </div>

    </div>


    {!! HTML::script('/js/category/list_navigation.js') !!}


</div>
