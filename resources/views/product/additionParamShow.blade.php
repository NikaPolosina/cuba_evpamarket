

<?php

$ar = array();
        for($i = 1; $i<29; $i++){
            $ar[] = $i;
        }

        $s = 0;
        $b = 0;
?>
{{--{dd($singleProduct)}--}}
{{--{{dd($addParam)}}--}}
{{--{{dd($add_price)}}--}}

<div class="row" style="text-align: center">
    <h4>Дополнительные параметры</h4>
    <hr>
    @foreach($addParam as $item)
        <?php $empty = false; ?>

        @if($item['type']=='input')
            @if(array_key_exists($item->key, $add_price))
                @foreach($add_price[$item->key] as $addParam)
                    @if(empty($addParam['val']))
                        <?php $empty = true; ?>
                    @endif
                @endforeach
            @endif
        @endif


        <?php
            if($empty === true){
                continue;
            }
        ?>


        <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}" style="margin-bottom: 30px; ">
            <div class="col-sm-2 title">
                {{$item['title']}}:
            </div>
            <div class="col-sm-10">
                    <?php
                    switch($item['type']){
                            case 'checkbox':

                                foreach($item['value'] as $key => $val){ ?>
                                    <?php $b++; ?>
                                    @if($b==1)<div class="col-sm-4"> @endif
                                        <div style="text-align: left;">
                                            <?php
                                                $class='disabled';
                                                $enable='disabled';
                                                $addPrice = 0;
                                                $addPriceType = 'val';
                                            ?>
                                            @if(array_key_exists($item->key, $add_price))
                                                    @foreach($add_price[$item->key] as $addParam)
                                                        @if($addParam['val'] == $key)
                                                            <?php
                                                            $class = '';
                                                            $enable='checked';
                                                            $addPrice = $addParam['add_price'];
                                                            $addPriceType = $addParam['add_price_type'];
                                                            ?>
                                                        @endif
                                                    @endforeach
                                            @endif
                                            <div style="min-width: 90px; display: inline-block;" class="{{$class}}">
                                                <input onclick="return false;" type="checkbox" name="{{$key}}" value="{{$key}}" {{$enable}}>
                                                {{$val['name']}}
                                                {{--addPrice - {{$addPrice}}--}}
                                                {{--addPriceType - {{$addPriceType}}--}}
                                            </div>
                                            @if(isset($val['css']))
                                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                            @endif
                                        </div>
                                        @if($b==4)</div> <?php $b=0; ?>@endif
                                <?php } ?>

                                @if($b!=0) </div> @endif
                                <?php $b = 0; ?>

                                <?php
                                break;

                            case 'radio':
                                $random = substr( md5(rand()), 0, 7);

                                foreach($item['value'] as $key => $val){ ?>
                                    <?php $b++; ?>
                                    @if($b==1)<div class="col-sm-4"> @endif
                                        <div style="text-align: left;">
                                            <?php
                                            $class='disabled';
                                            $enable='disabled';
                                            $addPrice = 0;
                                            $addPriceType = 'val';
                                            ?>
                                            @if(array_key_exists($item->key, $add_price))
                                                @foreach($add_price[$item->key] as $addParam)
                                                    @if($addParam['val'] == $key)
                                                        <?php
                                                        $class = '';
                                                        $enable='checked';
                                                        $addPrice = $addParam['add_price'];
                                                        $addPriceType = $addParam['add_price_type'];
                                                        ?>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <div style="min-width: 90px; display: inline-block;" class="{{$class}}">
                                                <input onclick="return false;" type="radio" name="{{$key}}{{$random}}" value="{{$key}}" {{$enable}}>
                                                {{$val['name']}}
                                                {{--addPrice - {{$addPrice}}--}}
                                                {{--addPriceType - {{$addPriceType}}--}}
                                            </div>
                                            @if(isset($val['css']))
                                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                            @endif
                                        </div>
                                        @if($b==4)</div> <?php $b=0; ?>@endif
                                <?php } ?>

                                @if($b!=0) </div> @endif
                            <?php $b = 0; ?>

                            <?php
                            break;

                            case 'select': ?>

                                <?php
                                $class='disabled';
                                $enable='disabled';
                                $addPrice = 0;
                                $addPriceType = 'val';
                                ?>

                                @if(!array_key_exists($item->key, $add_price))
                                    <?php $class = ''; ?>
                                @endif

                                <div class="">
                                    <select name="{{$item['key']}}">
                                        <?php foreach($item['value'] as $key => $val){ ?>

                                            @foreach($add_price[$item->key] as $addParam)
                                            <?php
                                            $class='disabled';
                                            $enable='disabled';
                                            $addPrice = 0;
                                            $addPriceType = 'val';
                                            ?>
                                                @if($addParam['val'] == $key)
                                                    <?php
                                                    $class = '';
                                                    $enable='checked';
                                                    $addPrice = $addParam['add_price'];
                                                    $addPriceType = $addParam['add_price_type'];
                                                    ?>
                                                @endif
                                            @endforeach
                                        <option value="{{$key}}" {{$enable}}>{{$key}} <?php $key ?></option>
                                        <?php } ?>
                                    </select>
{{--                                    addPrice - {{$addPrice}}--}}
{{--                                    addPriceType - {{$addPriceType}}--}}
                                </div>

                                <?php
                            break;

                            case 'input':?>
                                <div style="text-align: left;">
                                    @if(array_key_exists($item->key, $add_price))
                                        @foreach($add_price[$item->key] as $addParam)
                                            @if($addParam['val'])
                                                    {{$addParam['val']}}
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <?php break;
                    }
                    ?>
            </div>
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





