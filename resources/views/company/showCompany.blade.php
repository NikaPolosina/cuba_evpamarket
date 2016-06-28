<link rel="stylesheet" type="text/css" href="/css/show_company.css" />
<div class="col-sm-12"><h3>Магазины</h3></div>

<div class="col-sm-12">
    @foreach($companyAll as $valueCompanw)
        <div class="col-md-3 carentFindCompany">
            <div class="item">
                <div class="shop_show" style="border: solid 1px grey; margin: 3px;">
                    <a class="">{{$valueCompanw->company_name}}</a>
                    <input id="input_id" value="{{$valueCompanw->id}}" type="hidden"/>

                    <?php  if(!empty($valueCompanw->company_logo) && file_exists(public_path() . '/img/custom/companies/thumbnail/' . $valueCompanw->company_logo)){
                        $logo = '/img/custom/companies/thumbnail/' . $valueCompanw->company_logo;
                    }else{
                        $logo = '/img/custom/files/thumbnail/plase.jpg';
                    } ?>
                    <div class="product_img">
                        <img class="img-thumbnail" style="display: block; width: 100%;" src="{{$logo}}">
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<hr/>