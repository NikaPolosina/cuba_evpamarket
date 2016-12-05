{{-- При просмотре товара в этом окно учитываються дополнительные стоимости --}}

<?php $b = 0; ?>

<div class="row" style="text-align: center">
    <h4>Дополнительные параметры</h4>
    <hr>
    <input type="hidden"  value="{{$base_price}}" name="" class="base_price"/>
    @foreach($addParam as $item)
        {{--Системный блок--}}
        <div>
            <?php $empty = true;
            if($item['type']=='input'){
                if(array_key_exists($item->key, $add_price)){
                    foreach($add_price[$item->key] as $addParam){
                        if(!empty($addParam['val'])){
                            $empty = false;
                        }
                    }
                }
            }
            if($empty === false){
                continue;
            }
            ?>
        </div>

        <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}" style="margin-bottom: 30px; ">
            <div class="col-sm-2 title">
                {{$item['title']}}:
            </div>
            <div class="col-sm-10">
                <?php
                    switch($item['type_for_by']){

                            case 'checkbox':?>
                                <div>
                                    <input data-type="checkbox" class="add_price_title" type="hidden" name="" value="{{$item['title']}}" />
                                    <?php
                                    foreach($item['value'] as $key => $val){ ?>
                                        <?php $b++; ?>
                                        @if($b==1)<div class="col-sm-4"> @endif
                                            <div style="text-align: left;">
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



                                                        <div style="min-width: 90px; display: inline-block;" class="{{$class}} add_param_holder">
                                                            <input type="checkbox" name="{{$key}}" value="{{$key}}">
                                                            {{$val['name']}}
                                                            @if($addPrice)
                                                                @if($addPriceType == 'per')
                                                                    <?php $addPrice = $base_price*$addPrice/100 ;?>
                                                                @endif
                                                                <div> + {{round($addPrice, 2)}}</div>
                                                                <input class="add_param_price" type="hidden" value="{{round($addPrice, 2)}}"/>
                                                            @endif
                                                            <input class="add_param_name" type="hidden" value="{{$val['name']}}"/>
                                                        </div>



                                                        @if(isset($val['css']))
                                                            <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                        @endif
                                                    @endif

                                            </div>
                                            @if($b==4)</div> <?php $b=0; ?>@endif
                                    <?php } ?>
                                    @if($b!=0) </div> @endif
                                    <?php $b = 0; ?>

                                </div>
                                <?php
                                break;

                            case 'radio':?>
                                <div>
                                    <input data-type="radio" class="add_price_title" type="hidden" name="" value="{{$item['title']}}" />

                                <?php
                                    $random = substr( md5(rand()), 0, 7);

                                    foreach($item['value'] as $key => $val){ ?>
                                        <?php $b++; ?>
                                        @if($b==1)<div class="col-sm-4"> @endif
                                            <div style="text-align: left;">
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

                                                        <div style="min-width: 90px; display: inline-block;" class="{{$class}} add_param_holder">
                                                            <input type="radio" name="{{$key}}{{$random}}" value="{{$key}}">
                                                            {{$val['name']}}
                                                            @if($addPrice)
                                                                @if($addPriceType == 'per')
                                                                    <?php $addPrice = $base_price*$addPrice/100 ;?>
                                                                @endif
                                                                <div> + {{round($addPrice, 2)}}</div>
                                                                <input class="add_param_price" type="hidden" value="{{round($addPrice, 2)}}"/>
                                                            @endif
                                                            <input class="add_param_name" type="hidden" value="{{$val['name']}}"/>
                                                        </div>

                                                        @if(isset($val['css']))
                                                            <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                        @endif
                                                @endif

                                            </div>
                                            @if($b==4)</div> <?php $b=0; ?>@endif
                                    <?php } ?>

                                    @if($b!=0) </div> @endif
                                <?php $b = 0; ?>
                            </div>

                            <?php
                            break;

                            case 'select': ?>
                                <div>
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


                                        <div style="min-width: 90px; display: inline-block;" class="add_param_holder">

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

                                        <?php if(is_array($add_price[$item->key])){
                                            $addPrice = $add_price[$item->key][0]['add_price'];
                                            $addPriceType = $add_price[$item->key][0]['add_price_type'];
                                        }?>

                                        @if($addPrice)
                                            @if($addPriceType == 'per')
                                                <?php $addPrice = $base_price*$addPrice/100 ;?>
                                            @endif
                                            <input class="add_param_price" type="hidden" value="{{round($addPrice, 2)}}"/>
                                            @endif
                                        <input class="add_param_name" type="hidden" value=""/>
                                    </div>
                                </div>

                                <?php
                            break;

                            case 'input':?>
                                <div>
                                    <input data-type="input" class="add_price_title" type="hidden" name="" value="{{$item['title']}}" />
                                    <div style="text-align: left;">
                                        @if(array_key_exists($item->key, $add_price))
                                            @foreach($add_price[$item->key] as $addParam)
                                                    <input type="text" name="" />
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                            <?php break;
                    }
                ?>
        @if(count($singleProduct->value) == 1)
                </div>
        @endif

        </div>
    @endforeach
</div>

<style>
    .disabled{
        color: #bfbfbf;
    }
    .title{
        text-align: left;
        font-size: 16px;
    }
</style>





