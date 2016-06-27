@extends('layouts.app')

@section('content')

    @include('layouts.header_menu')

    <link rel="stylesheet" type="text/css" href="css/welcome.css"/>

    <div class="row">


        @include('layouts.category_menu', $category)

        <div class="col-md-8 ">
            <div class="panel panel-default">
                <div class="panel-body">

                    @include('slide')


                    @include('layouts.category_pallet', ['vip_category', $vip_category])



                    <div class="col-sm-12"><h3>Магазины</h3></div>

                    <div class="col-sm-12">
                        @foreach($companyAll as $valueCompanw)
                            <div class="col-md-3 carentFindCompany">
                                <div class="shop_show" style="border: solid 1px grey; margin: 3px;">
                                    <a class="">{{$valueCompanw->company_name}}</a>
                                    <input id="input_id" value="{{$valueCompanw->id}}" type="hidden"/>

                                    <?php  if(!empty($valueCompanw->company_logo) && file_exists(public_path() . '/img/custom/companies/thumbnail/' . $valueCompanw->company_logo)){
                                        $logo = '/img/custom/companies/thumbnail/' . $valueCompanw->company_logo;
                                    }else{
                                        $logo = '/img/custom/files/thumbnail/plase.jpg';
                                    } ?>

                                    <img class="img-thumbnail" style="display: block; width: 100%;" src="{{$logo}}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <hr/>

                    @include('product.products.showAllProduct', ['productAll', $productAll])

                </div>
            </div>
        </div>

        <div class="col-md-2" style="border: solid 1px red;">
            Новости о акциях
        </div>
    </div>

    {!! HTML::script('/js/welcome.js') !!}

@endsection


