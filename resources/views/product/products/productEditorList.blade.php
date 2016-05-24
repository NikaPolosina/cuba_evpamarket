
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
            <div style=" margin: 3px 0 0 0;">

                <p class="product_description"></p>
            </div>
            <span style="font-size: 17px;">Детальное описание:</span>
            <div style=" margin: 3px 0 0 0;">

                <p class="product_content "></p>
            </div>
            <div style=" float: right; margin: 3px 0 0 0;">
                <p style="float: right;">Цена:  <span class="product_price"></span>
                </p>
            </div>

        </div>
    </div>
    </div>


</div>

{{-----------------------------------------------------------}}
<!-- Modal -->
<div class="modal fade" id="modalProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content col-md-10 col-sm-offset-1">
            <div class="modal-header">
                <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Описание товара</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>

            </div>
        </div>
    </div>
</div>
{{-----------------------------------------------------------------}}


<script>

$('.tBody').find('.product_modal_show').on('click', function(){
    event.preventDefault();


    var parent = $(this).parents('tr');
    var id = parent.find('.option').val();

    $('#modalProduct').modal('show');
    $('#modalProduct').find('.modal-body').html($('.product_info').show());

    $.ajax({
        type:"POST",
        url:"/products/show",
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        data:{id : id},
        success:function(msg){

            $('.product_info').find('p.name').text(msg.product.product_name);
            $('.product_info').find('p.product_description').text(msg.product.product_description);
            $('.product_info').find('img.img_product').attr('src', msg.product.product_image);
            $('.product_info').find('p.product_content').text(msg.product.content);
            $('.product_info').find('span.product_price').text(msg.product.product_price);




        }
    });


});



</script>



