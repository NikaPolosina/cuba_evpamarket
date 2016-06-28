
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
    <div class="col-md-3" style="padding-right: 2px; padding-left: 2px">
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
                                Магазин: <span>{{$v->getCompany()->first()->company_name}}</span>
                            </div>
                            <div class="product_name">
                                <a href="/single-product/{{$v->id}}">
                                    {{$v->product_name}}
                                </a>
                            </div>
                            <div class="product_price">
                                <span class="price">{{$v->product_price}} руб</span>
                                <span class="stars"></span>
                                <span style="float: right;" class="testimonials">24 отзыва</span>

                            </div>
                            <div class="product_navigation">
                                <button class="btn btn-success">В корзину</button>

                                <span class="like"></span>
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

    .item{

    }
    .item:hover{
        /*transform: scale(1.3, 1.3);*/
    }
    .shop_name{
        font-size: 16px;
    }
    .shop_name span:hover{
        color: red;
    }
    .product_name a{
        color: #3e77aa!important;
        font-size: 16px;
    }
    .product_name:hover{
        color: red;
    }
    .price{
        background: #fff3b5;
        border-radius: 4px;
        display: inline-block;
        padding: 7px 7px 5px;
        vertical-align: middle;
        margin-bottom: 5px;
        white-space: nowrap;
        border: 1px solid transparent;
        font-size: 1.38462em;
    }
    .stars{
        background-image: url(/img/system/star.png);
        background-repeat: repeat-x;     width: 45%;
        height: 20px;
        display: inline-block;
    }
    .like{
        background-image: url(/img/system/like.png);
        width: 50%;
        background-repeat: no-repeat;
        height: 31px;
        float: right;
        margin: 2px;
        display: block;
    }
    .like:hover{
        background-image: url(/img/system/like1.png);
    }
    .single_product_holder{
        height: 350px;
    }

    /*.carentFindProduct:hover .product_description{*/
        /*display: block;*/
        /*max-height: 300px;*/
        /*overflow: hidden;*/
    /*}*/

    /*.product_description{*/
        /*display: none;*/
    /*}*/

    /*.artem div{*/
        /*outline: solid black 1px;*/
    /*}*/
</style>