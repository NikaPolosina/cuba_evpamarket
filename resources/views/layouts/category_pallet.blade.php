<div class="category_pallet ">

    <div class="galleryCategoryMenu col-sm-12">
        <ul style="text-align: center;">
            @foreach($vip_category as $v)
                <li class="portraits">
                    <div class="col-sm-12" style="padding-right: 0px; padding-left: 0px;">
                        <a href="/category/{{$v->id}}">
                            <p class="col-sm-7">{{$v->title}}</p>

                            <?php
                              if(!empty($v->icon)){?>
                                <img class="col-sm-5" style=" float: right;padding: 0px; margin: 0px;" src="img/category_icon/{{$v->icon}}.png" alt=""/>
                              <?php }?>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

</div>