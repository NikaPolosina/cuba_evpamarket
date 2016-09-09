<!-- Modal -->
<div style="z-index: 100000000000000" class="modal fade" id="cart_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content col-md-10 col-sm-offset-1">
            <div class="modal-header">
                <button type="button" class="close myClose" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <img style="display: inline-block;" src="/img/system/check-mark.png" alt="" /> Товар был добавлен в корзину. Товаров в Вашей корзине:
                    <span style="color:blue" class="m_car_cnt"></span>
                </h4>
            </div>
            <div class="modal-body">
                <div class="product_info_add_cart product_item_cart">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <div style="max-width: 100%;">
                                    <img class="m_img_product img-thumbnail" src="" alt="" />
                                </div>
                                <div class="gal">
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <table class="table_mod" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td width="45%" class="right">
                                            <span class="title_span_css">Товар:</span>
                                            <input type="hidden" class="m_h_product_id" />
                                            <input type="hidden" class="m_h_product_price_one" />
                                            <input type="hidden" class="m_h_total_in_shop" />

                                        </td>
                                        <td width="55%" class="left">
                                            <p class="name m_product_title"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="right">
                                            <span class="title_span_css">Краткое описание:</span>
                                        </td>
                                        <td width="55%" class="left">
                                            <p style="font-size: 14px;" class="m_product_description"></p></td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="right">
                                            <span class="option_table title_span_css">
                                                Количество:
                                            </span>
                                        </td>
                                        <td width="55%" class="left">

                                            {{-------------------------------Количество товара----------------------------------}}
                                            <div class="my_b">
                                                <div class="input-group number-spinner">
                                                    <span class="input-group-btn data-dwn">
                                                        <button class="btn btn-default btn-info left_b" data-dir="dwn" style="height: 30px; width: 30px;">
                                                            <span class="glyphicon glyphicon-minus"></span>
                                                        </button>
                                                    </span>

                                                    <input type="text" class="form-control text-center my_b my_counter" value="1" min="1" max="40" readonly style="height: 30px;">

                                                    <span class="input-group-btn data-up">
                                                        <button class="btn btn-default btn-info right_b" data-dir="up" style="height: 30px; width: 30px;">
                                                            <span style="width: 2px;" class="glyphicon glyphicon-plus"></span>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="right">
                                            <span class="title_span_css">
                                                Цена за единицу товара:
                                            </span>
                                        </td>
                                        <td width="55%" class="left">
                                            <p class="price_single">
                                                <span class="m_single_product_price">0</span> <span>руб.</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="right">
                                            <span class="title_span_css">Цена с учётом количества:</span></td>
                                        <td width="55%" class="left">
                                            <p class="price_b">
                                                <span class="m_all_product_price">0</span> <span>руб.</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="45%" class="right">
                                            <span class="title_span_css">Сумма по этому магазину:</span></td>
                                        <td width="55%" class="left">
                                            <p class="price_all_b">
                                                <span class="m_total_in_shop">0</span> <span>руб.</span>
                                            </p>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-success buy_button" data-dismiss="modal">
                    <img class="img_button_icon" src="/img/system/back-arrow.png" alt="" />Добавить и продолжить покупки
                </button>

                <button type="button" class="btn btn-danger buy_button go_cart">
                    <img class="img_button_icon" src="/img/system/shopping-cart-button.png" alt="" /> Добавить и перейти в корзину
                </button>

                <button type="button" class="btn btn-default right_bt_css m_close_modal">
                    Отменить
                </button>


            </div>
        </div>
    </div>
</div>


{!! HTML::script('/js/modal_cart_counter.js') !!}
{{HTML::style('/css/cart_modal.css')}}
