@extends('layouts.app')

@section('content')


    <?php
    function sho($data, $parent, $none = 'none'){?>
    <div class="tt" data-child="<?=$parent['id']?>" style="display: <?=$none?>">
        <?php
        foreach ($data as $value) { ?>
        <div style="border: solid 1px yellow;" data-parent="<?=$value['id']?>"><?=$value['title']?></div> <?php
        }
        ?>
    </div>
    <?php
    }
    ?>

    <style>
        .t{
            outline: solid #000000 1px;
        }
        .tt{
            outline: solid #ff0000 2px;
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

    <br>
    <br>
    <br>
    <br>


    <div class="col-sm-2">

        <ul class="list-unstyled">


            <?php




            ?>

        </ul>
    </div>

@endsection
<style>



</style>