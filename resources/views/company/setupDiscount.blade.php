@extends('layouts.app')
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

                    <h3>Добавить новую :</h3>
                @include('company.singleDiscountForm', array('max_value'=>$max))

                </div>
            </div>


        </div>
    </div>


<style>
    .ara{
        padding: 20px!important;
    }


</style>

<script>
    $('div.ara').find('button.tut').on('click', function (e) {

        var c_modal = new CModal({
            title: 'Подтвердите Ваше действие',
            body:'<h3>Вы уверены, что хотите удалить?</h3>',
            confirmBtn:'Удалить',
            cancelBtn:'Отменить',
            action: function(){
                var button = $(e.currentTarget);

                $.ajax({
                    type    : "POST",
                    url     :       '/company-destroy-discount/'+button.data('id-company')+'/'+button.data('id-item'),
                    headers : {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    data    : {

                    },
                    success : function(response){
                        $('form[data-id='+button.data('id-item')+']').remove();

                    },
                    error   : function(response){
                        console.log('ajax went wrong');
                    }
                });


            }
        });
        c_modal.show();
    })

</script>

@endsection