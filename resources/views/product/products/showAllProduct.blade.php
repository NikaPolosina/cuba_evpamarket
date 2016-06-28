<link rel="stylesheet" type="text/css" href="/css/show_product.css" />
<div class="col-sm-12"><h3>Товары</h3></div>

<div class="row">

    <?php foreach($productAll as $v){

    ?>

    <div class="col-md-3 tom" style="padding-right: 2px; padding-left: 2px">
        <div class="single_product_holder">
                <div class="carentFindProduct">
                        <div class="item">
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

    <?php } ?>
</div>
<script>

    var carentFindProduct = $('.carentFindProduct');

    carentFindProduct.on({

        mouseenter : function() {
            $(this).addClass('portfolioActiv');
        },

        mouseleave : function() {
            $(this).removeClass('portfolioActiv');

        }
    });
</script>



