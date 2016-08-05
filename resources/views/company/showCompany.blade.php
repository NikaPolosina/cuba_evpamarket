<link rel="stylesheet" type="text/css" href="/css/show_company.css" />
<div class="col-sm-12"><h3>Магазины</h3></div>

<div class="col-sm-12">

    @foreach($companyAll as $valueCompany)
        <div class="col-md-3 carentFindCompany">
            <div class="item_company">
                <div class="company_img">
                    <a href="/show-company/{{$valueCompany->id}}">
                        <img class="img-thumbnail show_company" src="{{$valueCompany->company_logo}}">
                    </a>
                </div>
                    <div class="shop_name">
                        <span class="span_title">  Магазин:</span> <span>{{$valueCompany->company_name}}</span>
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