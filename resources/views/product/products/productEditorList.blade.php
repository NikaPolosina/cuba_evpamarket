
<table class="table table-bordered table-striped table-hover">
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
                        foreach ($category as $value) {
                            $bread = $bread.$value[0]['title'].' > ';
                            $categoryID = $value[0]['id'];
                            $categoryTitle = $value[0]['title'];
                        }
                    }
                    echo $bread;

                ?>


            </th>
        </tr>
    <?php } ?>



    <th></th><th>Товар</th><th>Описание товара</th><th>Описание расширеное</th><th>Цена</th><th>Действие</th>
    </tr>
    </thead>
    <tbody class="tBody">

            <input class="companyIdClass" style="display: none"  name="companyId" value="{{$categoryID or ''}}"/>
            <input class="companyTitleClass" style="display: none"  name="companyTitle" value="{{$categoryTitle or ''}}"/>


    @foreach ($products as $item)

        @include('product.products.singleProductTr', array('item' => $item))
    @endforeach
    </tbody>
</table>

<button type="button" class="add-new-product btn btn-primary pull-left btn-sm">
    +
</button>
<a href="" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">x</a>

<div class="paginate">
    <?php echo $products->render(); ?>
</div>


