{{-- При просмотре товара в этом окно учитываються дополнительные стоимости --}}

<style>
    .div_css_value{
        min-width: 60px;
        margin: 3px;
        float: left;
        border: 1px solid #e9e9e9;
        line-height: 28px;
        height: 30px;
        padding: 0 10px;
        color: #333;
        border-radius: 3px;
        background-color: #fff;
        text-align: center;
    }
    .div_css_value:hover{
        outline: 3px solid #f90;
        border-radius: 4px;
    }
</style>



<div class="row">
    <div class="col-sm-12 text-center">
        <h4>Дополнительные параметры</h4>
        <input type="hidden"  value="{{$base_price}}" name="" class="base_price"/>
        <hr>
    </div>

    <div class="col-sm-12">
        @foreach($addParam as $name => $item)
            {{--Системный блок--}}
            <?php $empty = true;
            if($item['type']=='input'){
                if(array_key_exists($item->key, $add_price)){
                    foreach($add_price[$item->key] as $name => $addParam){
                        if(($item->key == 'owner_field') && empty($addParam['val'])){
                            $empty = false;
                        }
                    }
                }
            }
            if($empty === false){
                continue;
            }

            if(!array_key_exists($item->key, $add_price)){
                continue;
            }
            ?>
            {{--Системный блок--}}




            <div class="row" style="margin-top: 5px;">
                <div class="div_container param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}" style="margin-bottom: 30px; ">
                    <div class="col-md-2 title">
                        {{$item['title']}}:
                    </div>
                    <div class="col-md-4 my_md_10">
                        <div class="row">
                            <?php
                            switch($item['type_for_by']){
                            case 'checkbox': ?>
                            <input data-type="checkbox" class="add_price_title" type="hidden" name="" value="{{$item['title']}}" />
                            <?php
                            foreach($item['value'] as $key => $val){ ?>
                            <?php
                            $class='disabled';
                            $enable=false;
                            $addPrice = 0;
                            $addPriceType = 'val';
                            ?>
                            @if(array_key_exists($item->key, $add_price))
                                @foreach($add_price[$item->key] as $addParam)
                                    @if($addParam['val'] == $key)
                                        <?php
                                        $class = '';
                                        $enable=true;
                                        $addPrice = $addParam['add_price'];
                                        $addPriceType = $addParam['add_price_type'];
                                        ?>
                                    @endif
                                @endforeach
                            @endif

                            @if($enable === true)
                                <div class="col-md-6" style="/*outline: solid 1px black*/">
                                    <div class="row {{$class}} add_param_holder">
                                        <div class="col-md-2 text-center" style="display: none">
                                            <input type="checkbox" name="{{$key}}" value="{{$key}}">
                                        </div>
                                        <div class="col-md-10">
                                            <div class="div_css_value checkbox">
                                                @if(isset($val['css']))
                                                    <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; margin-top: 3px; background-color: {{$val['css']}}"></div>
                                                    <input class="add_param_css" type="hidden" value="{{$val['css']}}"/>
                                                @else
                                                    <input class="add_param_css" type="hidden" value=""/>
                                                @endif
                                                <span>{{$val['name']}}</span>
                                            </div>
                                        </div>

                                        {{--<div class="col-md-2 text-center">
                                            @if(isset($val['css']))
                                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                            @endif
                                        </div>--}}
                                        <div class="col-md-10">
                                            @if($addPrice)
                                                @if($addPriceType == 'per')
                                                    <?php $addPrice = $base_price*$addPrice/100 ;?>
                                                @endif
                                                {{--<div> Доп. цена:  + {{round($addPrice, 2)}}</div>--}}
                                                <input class="add_param_price" type="hidden" value="{{round($addPrice, 2)}}"/>
                                            @else
                                                <input class="add_param_price" type="hidden" value="0"/>
                                            @endif
                                            <input class="add_param_name" type="hidden" value="{{$val['name']}}"/>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <?php }
                            break;
                            case 'radio':
                            $random = substr( md5(rand()), 0, 7); ?>
                            <input data-type="radio" class="add_price_title" type="hidden" name="" value="{{$item['title']}}" />
                            <?php
                            foreach($item['value'] as $key => $val){ ?>
                            <?php
                            $class='disabled';
                            $enable=false;
                            $addPrice = 0;
                            $addPriceType = 'val';
                            ?>
                            @if(array_key_exists($item->key, $add_price))
                                @foreach($add_price[$item->key] as $addParam)
                                    @if($addParam['val'] == $key)
                                        <?php
                                        $class = '';
                                        $enable=true;
                                        $addPrice = $addParam['add_price'];
                                        $addPriceType = $addParam['add_price_type'];
                                        ?>
                                    @endif
                                @endforeach
                            @endif

                            @if($enable === true)
                                <div class="col-md-4" style="/*outline: solid 1px black*/">
                                    <div class="row {{$class}} add_param_holder">
                                        <div class="col-md-2 text-center" style="display: none">
                                            <input type="radio" name="{{$random}}" value="{{$key}}">
                                        </div>
                                        <div class="col-md-10">
                                          <div class="div_css_value radio">
                                              @if(isset($val['css']))
                                                  <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; margin-top: 3px; background-color: {{$val['css']}}"></div>
                                                  <input class="add_param_css" type="hidden" value="{{$val['css']}}"/>
                                              @else
                                                  <input class="add_param_css" type="hidden" value=""/>
                                              @endif
                                             <span>{{$val['name']}}</span>
                                          </div>

                                        </div>




                                      {{--  <div class="col-md-2 text-center">
                                            @if(isset($val['css']))
                                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                            @endif
                                        </div>--}}
                                        <div class="col-md-10">
                                            @if($addPrice)
                                                @if($addPriceType == 'per')
                                                    <?php $addPrice = $base_price*$addPrice/100 ;?>
                                                @endif
                                                {{--<div> Доп. цена:  + {{round($addPrice, 2)}}</div>--}}
                                                <input class="add_param_price" type="hidden" value="{{round($addPrice, 2)}}"/>
                                            @else
                                                <input class="add_param_price" type="hidden" value="0"/>
                                            @endif
                                            <input class="add_param_name" type="hidden" value="{{$val['name']}}"/>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <?php } break;
                            case 'select': ?>
                            <div class="col-md-4">
                                <input data-type="select" class="add_price_title" type="hidden" name="" value="{{$item['title']}}" />

                                <?php
                                $class='disabled';
                                $enable='disabled';
                                $addPrice = 0;
                                $addPriceType = 'val';
                                ?>
                                @if(!array_key_exists($item->key, $add_price))
                                    <?php $class = ''; ?>
                                @endif

                                <div class="row add_param_holder">
                                    <div class="col-md-6" style="/*outline: solid black 1px;*/">
                                        <select name="{{$item['key']}}">
                                            <option value="">Выбирете значение</option>
                                            <?php foreach($item['value'] as $key => $val){ ?>

                                            @foreach($add_price[$item->key] as $addParam)
                                                <?php
                                                $class='disabled';
                                                $enable=false;
                                                $addPrice = 0;
                                                $addPriceType = 'val';
                                                ?>
                                                @if($addParam['val'] == $key)
                                                    <?php
                                                    $class = '';
                                                    $enable=true;
                                                    $addPrice = $addParam['add_price'];
                                                    $addPriceType = $addParam['add_price_type'];
                                                    ?>
                                                @endif
                                            @endforeach
                                            @if($enable)
                                                <option value="{{$key}}">{{$key}} <?php $key ?></option>
                                            @endif
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        @if($addPrice)
                                            @if($addPriceType == 'per')
                                                <?php $addPrice = $base_price*$addPrice/100 ;?>
                                            @endif
                                            {{--<div> Доп. цена:  + {{round($addPrice, 2)}}</div>--}}
                                            <input class="add_param_price" type="hidden" value="{{round($addPrice, 2)}}"/>
                                        @else
                                            <input class="add_param_price" type="hidden" value="0"/>
                                        @endif
                                        <input class="add_param_name" type="hidden" value="{{$val['name']}}"/>
                                    </div>

                                </div>
                            </div>
                            <?php break;
                            case 'input': ?>
                            <div class="col-md-6" style="/*outline: solid 1px black*/">
                                <input data-type="input" class="add_price_title form-control" type="hidden" name="" value="{{$item['title']}}" />
                                <div style="text-align: left;">
                                    @if(array_key_exists($item->key, $add_price))
                                        @foreach($add_price[$item->key] as $addParam)
                                            @if($item->key == 'owner_field')
                                                {{$addParam['val']}}
                                            @else
                                                <input class="jq_val_input form-control" type="text" />
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <?php break;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<style>
    .title{
        text-align: left;
        font-size: 16px;
    }
</style>



