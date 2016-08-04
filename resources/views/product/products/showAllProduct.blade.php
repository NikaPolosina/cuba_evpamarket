<link rel="stylesheet" type="text/css" href="/css/show_product.css"/>
<div class="col-sm-12">
    <h3>Товары</h3>
    <hr/>
</div>
@include('product.products.modalAddProductCart')
@include('product.products.modalAddProductLike')
<div class="row row_row">
    <div class="item_class_3">
        <div class="item_product item_class_4">
            @foreach($productAll as $v)
                <div class="col-md-3 tom" style="padding-right: 2px; padding-left: 2px">
                    <div class="single_product_holder">
                        <div class="carentFindProduct carent_my_product">
                            <div class="item item_1">
                                <input style="display: none" data-name="product-id" type="text" value="{{$v->id}}"/>
                                <div class="product_img">
                                    <a href="/single-product/{{$v->id}}">
                                        @if(isset($v->firstFile))
                                            <img class="img-thumbnail show-product" src="{{$v->firstFile}}">
                                        @endif
                                    </a>
                                </div>
                                <div class="shop_name">
                                    <span class="span_title">  Магазин:</span>
                                    <span>{{$v->getCompany()->first()->company_name}}</span>
                                </div>
                                <div class="product_name">
                                    <a href="/single-product/{{$v->id}}">
                                        {{ Str::limit($v->product_name, 50) }}
                                    </a>
                                </div>
                                <div class="product_price">
                                    <span class="price">{{$v->product_price}} руб</span>
                                    <span class="stars"></span>
                                    <span class="testimonials">нет отзывов</span>

                                </div>
                                <div class="product_navigation">
                                    <button class="btn btn-success ">В корзину</button>
                                    @if(!Auth::guest())
                                        <span class="like"></span>
                                    @endif
                                </div>
                                <div class="product_description">
                                    <span class="span_title">Краткое описани:</span>
                                    <p>
                                        {{ Str::limit($v->product_description, 50) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
</div>

<script>
    var carentFindProduct = $('.carentFindProduct');
    carentFindProduct.on({
        mouseenter : function(){
            $(this).addClass('activ');
        },
        mouseleave : function(){
            $(this).removeClass('activ');
        }
    });
</script>

