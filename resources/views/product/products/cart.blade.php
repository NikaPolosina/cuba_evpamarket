@extends('layouts.app')
@section('content')

        @include('layouts.header_menu')

        <div class="row">

                @forelse($product as $val)

                <div class="col-sm-8">

                        <div class="col-sm-3">
                                <div style="max-width: 100%;">
                                        <img class="img_product img-thumbnail" src="{{$val['firstFile']}}" alt=""/>
                                </div>
                        </div>

                        <div class="col-sm-9">
                                <table class="table_product" border="1" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                                <td width="35%"><span>Товар:</span></td>
                                                <td width="65%" valign="top"><p  class="name" style=" font-size: 20px;">{{$val['product_name']}}</p></td>
                                        </tr>
                                        <tr>
                                                <td width="35%"><span>Краткое описание:</span></td>
                                                <td width="65%" valign="top"><p style="font-size: 20px;" class="product_description"> {{$val['product_description']}}</p></td>
                                        </tr>

                                        <tr>
                                                <td width="35%" valign="top"><span>Цена:</span></td>
                                                <td width="65%" valign="top"><p class="product_price" style="" > {{$val['product_price']}}</p></td>
                                        </tr>
                                </table>

                        </div>
                </div>


             @endforeach

                        </div>
<style>
p.product_price{
        background: #fff3b5;
        border-radius: 4px;
        display: inline-block;
        padding: 7px 7px 5px;
        vertical-align: middle;
        margin-bottom: 5px;
        white-space: nowrap;
        border: 1px solid transparent;

        font-size: 20px;

}

.table_product span{
        font-size: 20px;
        font-weight: bolder;
}

</style>

@endsection