<div class="row">
    <div class="col-sm-12">


            <div class="portlet sale-summary">
                <div class="portlet-title">
                    <div class="caption font-red sbold"> Продано товаров</div>
                </div>
                <div class="portlet-body">
                    <ul class="list-unstyled">
                        <li>
                            <span class="sale-info"> ЗA СЕГОДНЯ
                                <i class="fa fa-img-up"></i>
                            </span>
                            <span class="sale-num"> @if(isset($company)){{$company->perDayAmount}}@endif </span>
                        </li>
                        <li>
                            <span class="sale-info"> ЗА НЕДЕЛЮ
                                <i class="fa fa-img-down"></i>
                            </span>
                            <span class="sale-num">  @if(isset($company)){{$company->perWeekAmount}} @endif </span>
                        </li>
                        <li>
                            <span class="sale-info"> ВСЕГО </span>
                            <span class="sale-num"> @if(isset($company)){{$company->totalAmount}}@endif </span>
                        </li>
                    </ul>
                </div>
            </div>


    </div>
</div>