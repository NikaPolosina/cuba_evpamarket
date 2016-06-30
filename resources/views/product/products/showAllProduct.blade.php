
<link rel="stylesheet" type="text/css" href="/css/show_product.css" />

<div class="col-sm-12"><h3>Товары</h3></div>


{{-----------------------------------------------------------}}
<!-- Modal -->
<div style="z-index: 100000000000000" class="modal fade" id="modal_add_product_cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content col-md-10 col-sm-offset-1">
            <div class="modal-header">
                <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><img style="display: inline-block;" src="/img/system/check-mark.png" alt=""/> Товар был добавлен в корзину. Товаров в Вашей корзине: </h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal"><img class="img_button_icon"src="/img/system/back-arrow.png" alt=""/>Продолжить покупки</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><img class="img_button_icon" src="/img/system/shopping-cart-button.png" alt=""/> Перейти в корзину</button>
            </div>
        </div>
    </div>
</div>
{{-----------------------------------------------------------------}}


<div class="row item_product">

    @foreach($productAll as $v)

        <div class="col-md-3 tom" style="padding-right: 2px; padding-left: 2px">
            <div class="single_product_holder">
                <div class="carentFindProduct">
                        <div class="item">
                            <input  style="display: none" data-name="product-id" type="text" value="{{$v->id}}"/>
                            <div class="product_img">

                                <a href="/single-product/{{$v->id}}">

                                    @if(isset($v->firstFile))
                                        <img class="img-thumbnail show-product" src="{{$v->firstFile}}">
                                    @endif
                                </a>
                            </div>
                            <div class="shop_name">
                              <span class="span_title">  Магазин:</span> <span>{{$v->getCompany()->first()->company_name}}</span>
                            </div>
                            <div class="product_name">
                                <a href="/single-product/{{$v->id}}">
                                    {{$v->product_name}}
                                </a>
                            </div>
                            <div class="product_price">
                                <span class="price">{{$v->product_price}} руб</span>
                                <span class="stars"></span>
                                <span class="testimonials">24 отзыва</span>

                            </div>
                            <div class="product_navigation">
                                <button class="btn btn-success">В корзину</button>
                                <span class="like"></span>
                            </div>
                            <div class="product_description">
                                <span class="span_title">Краткое описани:</span>
                                <p>
                                    {{ Str::limit($v->product_description, 50) }}
                                </p>
                            </div>
                            <div class="product_content">
                                <span class="span_title">Полное описание:</span>
                                <p>
                                    {{ Str::limit($v->content, 50) }}
                                </p>
                            </div>
                        </div>
                </div>
        </div>
        </div>

 @endforeach
</div>
<style>



</style>
<script>
    var carentFindProduct = $('.carentFindProduct');
    carentFindProduct.on({
        mouseenter : function() {
            $(this).addClass('activ');
        },
        mouseleave : function() {
            $(this).removeClass('activ');
        }
    });
</script>



