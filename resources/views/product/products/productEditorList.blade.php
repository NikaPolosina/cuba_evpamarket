<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th colspan="7">
            <?php
                if($category){
                    $mainCategory = array_shift($category);
                    echo $mainCategory[0]['title'];
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
                        foreach ($category as $value) {
                            $bread = $bread.$value[0]['title'].' > ';



                            $categoryID = $value[0]['id'];
                            $categoryTitle = $value[0]['title'];
                        }
                    }
                    echo $bread;

                ?>
                    <input class="companyIdClass" style="display: none"  name="companyId" value="{{$categoryID}}"/>
                    <input class="companyTitleClass" style="display: none"  name="companyTitle" value="{{$categoryTitle}}"/>

            </th>
        </tr>
    <?php } ?>



    <th></th><th>Товар</th><th>Описание товара</th><th>Описание расширеное</th><th>Фото</th><th>Цена</th><th>Действие</th>
    </tr>
    </thead>
    <tbody class="tBody">

    @foreach ($products as $item)

        @include('product.products.singleProductTr', array('item' => $item))
    @endforeach
    </tbody>
</table>

<a class="addCategoryProduct btn btn-primary pull-left btn-sm">+</a>
<a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">x</a>

<div class="paginate">
    <?php echo $products->render(); ?>
</div>


