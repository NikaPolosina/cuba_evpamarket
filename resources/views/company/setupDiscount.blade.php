@extends('...layouts.app')

@section('content')
    @include('layouts.header_menu')

    <div class="row">

        <div class="col-sm-8 col-sm-offset-2">
            <div class="alert alert-info fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">&times;</a>
                <strong><h3>Редактор накопительной скидки</h3></strong> <h4>При покупке товаров покупателем в вашем магазине на определенную сумму, Вы можете предоставить накопительную скидку для покупателя.
                    Вы можете самостоятельно задать интервал данной скидку по Вашему усмотрению или не предоставлять скидки вовсе.
                </h4>
            </div>

            <hr>
            <div class="col-sm-8 col-sm-offset-2">
                <div class="body_discount well well-sm ara">
                @if(count($discount) > 0)
                    @foreach($discount as $value)
                        @include('company.singleDiscountForm', array('item' => $value, 'company' => $company))
                    @endforeach
                @endif

                @include('company.singleDiscountForm')

                </div>
            </div>


        </div>
    </div>

@endsection
<style>
    .ara{
        padding: 20px!important;
    }


</style>