<?php
if(isset($company)){
    if(isset($company) && !count($company->getCategoryCompany) || !count($company->getProducts)){
        if(!count($company->getCategoryCompany)){
            $hide = true;
            echo '<h1>У Вас нет пока категорий. Добавьте </h1>';
        }else{
            echo '<h1>У Вас нет пока товаров. Добавьте товары</h1>';
        }
    }
}

?>

<table class="table table-bordered table-striped table-hover" style="display: <?=(isset($hide)) ? 'none' : '' ?>; margin-bottom: 0px;">
    <thead>
    <tr>
        <th colspan="7">
            <?php
            if($category){
                $mainCategory = array_shift($category);
                echo $mainCategory[0]['title'];
                $categoryID = $mainCategory[0]['id'];
                $categoryTitle = $mainCategory[0]['title'];
            }else{
                echo 'Все товары магазина';
            }
            ?>
        </th>
    </tr>
    <?php
    if($category){ ?>
    <tr>
        <th colspan="7">
            <?php
            $bread = '';
            if(count($category) > 0){
                foreach($category as $value){
                    $bread = $bread . $value[0]['title'] . ' > ';
                    $categoryID = $value[0]['id'];
                    $categoryTitle = $value[0]['title'];
                }
            }
            echo $bread;
            ?>
        </th>
    </tr>
    <?php } ?>



    <div class="button_holder" style="display: <?=(isset($hide)) ? 'none' : 'block' ?>;">
        <a href="" id="destroycheck" class="destroycheck btn btn-danger  btn-sm">Удалить товар</a>
        <span class="open btn btn-success btn-sm pull-left">Добавить товар</span>
        <div style="float: right">
            @foreach($status as $singleSt)

                <div class=" @if($type == $singleSt->status_key) active_type @endif" style="display: inline-block; border: solid 1px grey; padding: 4px 15px 4px 15px;">
                    <a href="/product-editor/{{$company->id}}/0/{{$singleSt->status_key}}">
                       {{$singleSt->status_name}}
                        <span>
                            {{count($company->getProducts()->where('status_product', $singleSt->status_key)->get())}}
                        </span>

                    </a>
                </div>

            @endforeach
        </div>


    </div>
    <tr style="background-color: #e6f9eb">
        <th></th>
        <th>№</th>
        <th width="120">Товар</th>
        <th width="400">Описание товара</th>
        <th>Описание расширенное</th>
        <th width="80">Цена</th>
        <th>Действие</th>
    </tr>
    </thead>
    <tbody class="tBody">
    <input class="companyIdClass" style="display: none" name="companyId" value="{{$categoryID or ''}}"/>
    <input class="companyTitleClass" style="display: none" name="companyTitle" value="{{$categoryTitle or ''}}"/>
    {{-- */$x=0;/* --}}
    @foreach ($products as $item)
        {{-- */$x++;/* --}}
        @include('product.singleProductTr', array('item' => $item))
    @endforeach
    </tbody>
</table>
<div class="button_holder" style="display: <?=(isset($hide)) ? 'none' : 'block' ?>;">
    <a href="" id="destroycheck" class="destroycheck btn btn-danger  btn-sm">Удалить товар</a>
    <span class="open btn btn-success btn-sm pull-left">Добавить товар</span>
</div>
<div class="paginate">
    <?php echo $products->render(); ?>
</div>

<div class="product_info" style="display: none">
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-5">
                <div style="margin: 3px 0 0 0;">
                    {{-- <span>Наименование товара:</span>--}}
                    <p style="font-weight: bolder; font-size: 20px;" class="name"></p>
                </div>
                <div style=" margin: 3px 0 0 0;">
                    <img class="img_product img-thumbnail" src="" alt=""/>
                </div>
            </div>
            <div class="col-sm-7">
                <span style="font-size: 17px;">Краткое описание:</span>
                <div class="description_modal_product modal_product_desc">

                    <p class="product_description"></p>
                </div>

                <div class="price_modal_product modal_product_price">
                    <p style="float: right;">Цена: <span class="product_price"></span> руб.
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .active_type{
        background-color: #b6fab6;
    }
</style>

