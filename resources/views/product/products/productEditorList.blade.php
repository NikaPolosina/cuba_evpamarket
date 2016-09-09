<link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css"/>
<link href="../assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css"/>
<div class="row">
    <div class="col-sm-12">

        <div class="col-md-4">
            <div class="portlet sale-summary">
                <div class="portlet-title">
                    <div class="caption font-red sbold"> Продано Товаров</div>
                    {{--   <div class="tools">
                           <a class="reload" href="javascript:;"> </a>
                       </div>--}}
                </div>
                <div class="portlet-body">
                    <ul class="list-unstyled">
                        <li>
                            <span class="sale-info"> ЗA СЕГОДНЯ
                                <i class="fa fa-img-up"></i>
                            </span>
                            <span class="sale-num"> @if(isset($company)){{$company->perDayAmount}}@endif </span>
                        </li>
                        <li>
                            <span class="sale-info"> ЗА НЕДЕЛЮ
                                <i class="fa fa-img-down"></i>
                            </span>
                            <span class="sale-num">  @if(isset($company)){{$company->perWeekAmount}} @endif </span>
                        </li>
                        <li>
                            <span class="sale-info"> ВСЕГО </span>
                            <span class="sale-num"> @if(isset($company)){{$company->totalAmount}}@endif </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>


<?php
if(isset($company)){
    if(isset($company) && !count($company->getCategoryCompany) || !count($company->getProducts)){
        if(!count($company->getCategoryCompany)){
            $hide = true;
            echo '<h1>У Вас нет пока категорий. Добавьте </h1>';
        }else{
            echo '<h1>У Вас нет пока продуктоов. Добавте продукты</h1>';
        }
    }
}

?>


<table class="table table-bordered table-striped table-hover" style="display: <?=(isset($hide)) ? 'none' : '' ?>;">
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
                echo 'Все продукты магазина';
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
        <span class="open btn btn-success btn-sm">Добавить продукт</span>
        <a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">Удалить продукт</a>
    </div>
    <tr style="background-color: #e6f9eb">
        <th></th>
        <th>№</th>
        <th width="120">Товар</th>
        <th width="400">Описание товара</th>
        <th>Описание расширеное</th>
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
        @include('product.products.singleProductTr', array('item' => $item))
    @endforeach
    </tbody>
</table>
<div class="button_holder" style="display: <?=(isset($hide)) ? 'none' : 'block' ?>;">
    <span class="open btn btn-success btn-sm">Добавить продукт</span>
    <a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">Удалить продукт</a>
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




