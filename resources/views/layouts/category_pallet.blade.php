<div class="category_pallet ">

    <div class="galleryCategoryMenu col-xs-12 col-sm-12" style="text-align: center; display: block">
        <div class="row">
            <ul style="">

                @foreach($vip_category as $v)


                    <li class="portraits col-xs-2" style="">
                        <div class="col-sm-12" style="padding-right: 0px; padding-left: 0px; height: 100%;">
                            <div class="row">
                            <a href="/find/category/{{$v->id}}">

                                <p class="col-sm-7">{{$v->title}}</p>

                                <?php
                                if(!empty($v->icon)){?>
                                <img class="col-sm-5" style=" float: right;padding: 0px; margin: 0px;" src="/img/category_icon/{{$v->icon}}.png" alt=""/>
                                <?php }?>
                            </a>
                            </div>
                        </div>
                    </li>

                @endforeach

            </ul>
        </div>


    </div>

</div>
<style>

   ul>li{
       text-align: left;
    }
</style>

