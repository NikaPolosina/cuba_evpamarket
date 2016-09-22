
                <div class="single_product_holder">
                    <div class="carentFindProduct carent_my_product" style="    height: 100%!important;">
                        <div class="item item_1">
                            <input style="display: none" data-name="product-id" type="text" value="{{$v->id}}"/>
                            <div class="col-sm-3">
                                <div class="product_img" style="height: 250px;
    width: 250px;
    margin: auto;
    position: relative;">

                                    <a style="    display: block;

    position: absolute;
    top: 0;
    bottom: 0;
    margin: auto;
    left: 0;
    right: 0;" href="/single-product/{{$v->id}}">
                                        @if(isset($v->firstFile))
                                            <img style="    position: absolute;
    top: -50%;
    bottom: -50%;
    height: 100%;
    left: 0;
    right: 0;
    margin: auto;" class="img-thumbnail show-product" src="{{$v->firstFile}}">
                                        @endif
                                    </a>

                                </div>
                            </div>
                            <div class="col-sm-9">
                                <table class="table_product" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="35%" class="right shop_name" style="color: darkblue;">
                                            <span class="span_title option_table">Магазин:</span>
                                        </td>
                                        <td width="65%" class="left">
                                            <span class="option_table"> {{$v->getCompany()->first()->company_name}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="right"><span class="option_table">Товар:</span></td>
                                        <td width="65%" class="left">
                                            <div class="product_name"><p class="name"
                                                                         style=" font-size: 20px;">{{$v['product_name']}}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%" class="right"><span
                                                    class="option_table">Краткое описание:</span></td>
                                        <td width="65%" class="left"><p style="font-size: 20px;"
                                                                        class="product_description"> {{$v['product_description']}}</p>
                                        </td>
                                    </tr>
                                    {{--  <tr>
                                          <td width="35%"><span class="option_table">В наличии: </span></td>
                                          <td width="65%" valign="top"><p style="font-size: 20px;" class=""> 40шт</p>

                                      </tr>--}}
                                    <tr>
                                        <td width="35%" class="right"><span class="option_table">Цена:</span></td>
                                        <td width="65%" class="left">
                                            <div class="product_price yelloy"><span class="product_price_one price"
                                                                                    style=""> {{$v['product_price']}}</span>
                                                <span>руб.</span></div>
                                        </td>
                                    </tr>

                                </table>

                                <div class="product_navigation" style="float: right;">

                                    <input style="display: none" value="{{$v['id']}}" type="text"/>
                                    <button type="button" class="btn btn-default button_delete">Удалить из избранного
                                    </button>
                                    <button class="btn btn-success to_cart" data-product-id="{{$v['id']}}">В корзину
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
