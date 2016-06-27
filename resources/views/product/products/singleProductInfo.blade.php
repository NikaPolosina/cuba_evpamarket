
@extends('layouts.app')

@section('content')
    @include('layouts.header_menu')

    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- blueimp Gallery script -->
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
    <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>





    <div class="col-sm-10 col-md-offset-1">
        <h1>Товар</h1>
        <div class="table-responsive">
            <?php

            $idProduct = $singleProduct['id'];

            $directory = public_path().'/img/custom/companies/'.$companyId.'/products/'.$idProduct;
            $directoryMy = '/img/custom/companies/'.$companyId.'/products/'.$idProduct.'/';


            if(is_dir($directory)){
                $allFile = array_diff(scandir($directory), array('.', '..'));
                $singleFile = array();
                foreach($allFile as $value){
                    if(file_exists($directory.'/'.$value) && !is_dir($directory.'/'.$value)){
                        $singleFile[] = $directoryMy.$value;
                    }
                }
            }

            if(!empty($singleProduct['product_image']) && File::exists($directory.'/'.$singleProduct['product_image'])){

                $firstFile = $directoryMy.$singleProduct['product_image'];
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

            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Фото</th><th>Товар</th><th>Описание товара</th><th>Цена</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="width: 550px;"> <img class="img-thumbnail" style="display: block; width: 200px; float: left;" src="<?=$firstFile?>">


                        <?php
                        if(isset($singleFile) && count($singleFile)){
                            foreach($singleFile as $val){
                                $all = explode("/", $val);
                                $single = array_pop($all); ?>
                            <a href="<?=$val?>" title="<?=$single?>" download="<?=$single?>" data-gallery=""><img class="img-thumbnail" style="display: block; width: 100px; float: right" src="<?=$val?>"></a>
                            <a style="display: none" href="<?=$val?>" title="<?=$single?>" title="<?=$single?>" download="<?=$single?>" data-gallery=""><?=$single?></a>
                        <?php }
                        }?>


                    </td><td>{{ $singleProduct['product_name'] }}</td><td> {{ $singleProduct['product_description'] }} </td><td> {{ $singleProduct['product_price'] }} </td>
                </tr>
                </tbody>
            </table>



















        </div>
    </div>

@endsection


