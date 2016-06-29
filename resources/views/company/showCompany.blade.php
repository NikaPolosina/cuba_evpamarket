<link rel="stylesheet" type="text/css" href="/css/show_company.css" />
<div class="col-sm-12"><h3>Магазины</h3></div>

<div class="col-sm-12">

    @foreach($companyAll as $valueCompanw)
        <div class="col-md-3 carentFindCompany">
            <div class="item_company">

                <?php


                if(!empty($valueCompanw->company_logo) && file_exists(public_path() . '/img/custom/companies/' . $valueCompanw->company_logo)){
                    $logo = '/img/custom/companies/' . $valueCompanw->company_logo;
                }else{
                    $logo = '/img/custom/files/thumbnail/plase.jpg';
                } ?>

                <div class="company_img">
                    <a href="/show-company/{{$valueCompanw->id}}">
                        <img class="img-thumbnail show_company" src="{{$logo}}">
                    </a>
                </div>

                    <div class="shop_name">
                        <span class="span_title">  Магазин:</span> <span>{{$valueCompanw->company_name}}</span>
                    </div>

            </div>
        </div>
    @endforeach
</div>
<hr/>

<script>
    var carentFindProduct = $('.carentFindCompany');
    carentFindProduct.on({
        mouseenter : function() {
            $(this).addClass('activ');
        },
        mouseleave : function() {
            $(this).removeClass('activ');
        }
    });
</script>