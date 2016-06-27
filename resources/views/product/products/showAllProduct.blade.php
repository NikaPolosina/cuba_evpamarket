
<div class="col-sm-12"><h3>Товары</h3></div>

<div class="row">
    <?php foreach($productAll as $v){
    $idProduct = $v['id'];
    $idCompany = $v->getCompany[0]['id'];
    $directory = public_path() . '/img/custom/companies/' . $idCompany . '/products/' . $idProduct;
    $directoryMy = '/img/custom/companies/' . $idCompany . '/products/' . $idProduct . '/';
    if(!empty($v['product_image']) && File::exists($directory . '/' . $v['product_image'])){
        $firstFile = $directoryMy . $v['product_image'];
    }else{
        if(is_dir($directory)){
            $files = scandir($directory);
            $firstFile = $directoryMy . $files[2];// because [0] = "." [1] = ".."
            if(is_dir(public_path() . $firstFile)){
                if(isset($files[3]))
                    $firstFile = $directoryMy . $files[3];else
                    $firstFile = '/img/custom/files/thumbnail/plase.jpg';
            }
        }else{
            $firstFile = '/img/custom/files/thumbnail/plase.jpg';
        }
    }
    ?>
    <div class="col-md-3">
        <div class="single_product_holder">
                <div class="carentFindProduct">
                        <div class="item">
                            <div class="product_img">
                                <a href="/single-product/{{$v->id}}">
                                    @if(isset($firstFile))
                                        <img class="img-thumbnail show-product" src="{{$firstFile}}">
                                    @endif
                                </a>
                            </div>
                            <div class="shop_name">
                                Магазин: {{$v->getCompany()->first()->company_name}}
                            </div>
                            <div class="product_name">
                                <a href="/single-product/{{$v->id}}">
                                    {{$v->product_name}}
                                </a>
                            </div>
                            <div class="product_price">
                                <span class="price">{{$v->product_price}} руб</span>
                                <span class="stars">4 звезды</span>
                                <span class="testimonials">24 отзыва</span>
                            </div>
                            <div class="product_navigation">
                                <button>В карзину</button>
                                <button>В избранное</button>
                            </div>
                            <div class="product_description">
                                <span>Краткое описани:</span>
                                <p>
                                    {{ Str::limit($v->product_description, 50) }}
                                </p>
                            </div>
                        </div>
                </div>
        </div>
    </div>

    <?php } ?>
</div>

<style>

</style>