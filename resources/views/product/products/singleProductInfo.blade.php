
@extends('layouts.app')

@section('content')
    <div class="col-sm-10 col-md-offset-1">
        <h1>Товар</h1>
        <div class="table-responsive">


            <?php
            if(strlen($singleProduct['product_image'] )){
                $img = json_decode($singleProduct['product_image'] );
            foreach ($img as $v){

                if($img){
                    $img = '/img/custom/files/'.$v->name;
                    if(!is_file(public_path().$img)) unset($img);
                }else{
                    unset($img);
                }
            }
}else{
                $img = '/img/custom/files/thumbnail/plase.jpg';
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
                <td> <img class="img-thumbnail" style="display: block; width: 200px;" src="<?=$img?>"> </td><td>{{ $singleProduct['product_name'] }}</td><td> {{ $singleProduct['product_description'] }} </td><td> {{ $singleProduct['product_price'] }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection


