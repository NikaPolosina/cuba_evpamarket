@extends('layouts.app')

@section('content')


    <?php
    function sho($data, $parent, $none = 'none'){?>
    <div class="tt" data-child="<?=$parent['id']?>" style="display: <?=$none?>">
        <?php
        foreach ($data as $value) { ?>
        <div class="list" data-parent="<?=$value['id']?>"><?=$value['title']?> <div class="span_category"><span class="icon"> &#62 </span></div> </div> <?php
        }
        ?>
    </div>
    <?php
    }
    ?>

    <style>
      .t{
           padding-right: 0px!important;
           padding-left: 0px!important;
        }
      .span_category{
          float: right;
          color: #b9b8b8;
      }
        .tt{
            cursor: pointer;
        }
       .list{
           outline: solid 1px black;
           padding: 3px;
           font-size: initial;
           background: #ededed;
       }

    </style>

    <script>
        $(document).ready(function(){
            $('[data-parent]').on('mouseover', function(){
                var id = $(this).attr('data-parent');




                var parentDiv = $(this).parents('.t').eq(0);
                var mainParent = parentDiv.parent();
                var index = parentDiv.attr('data-index');

                switch (index) {
                    case '1':
                        mainParent.find('[data-index="3"]').find('[data-child]').each(function(index, value){
                            $(value).hide();
                            console.log('eq');

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
            });




        });
    </script>

    <div class="col-md-6">
        <div class="row menu_holder">
            <div class="col-md-4 t" data-index="1"><?php sho($category, array('id'=>'', 'title'=>'No'), 'block'); ?></div>
            <div class="col-md-4 t" data-index="2">
                <?php
                foreach ($category as $value) {
                    sho($value['nodes'], $value);
                }
                ?>
            </div>
            <div class="col-md-4 t" data-index="3">
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


@endsection
<style>



</style>