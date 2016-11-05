

<?php

$ar = array();
        for($i = 1; $i<29; $i++){
            $ar[] = $i;
        }

        $s = 0;
        $b = 0;
?>
{{--{{dd($singleProduct)}}
{{--{{dd($addParam)}}--}}

<div class="row" style="text-align: center">
    <h4>Дополнительные параметры</h4>
    <hr>
    @foreach($addParam as $item)
        <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}" style="margin-bottom: 30px; ">
            <div class="col-sm-2 title">
                {{$item['title']}}:
            </div>
            <div class="col-sm-10">
                @if(is_array($item['value']))
                    <?php

                    switch($item['type']){
                            case 'checkbox':?>

                                <?php

                                if(!array_key_exists($item['key'], $singleProduct->value)){
                                    $value[$item['key']] = array();
                                }
                                ?>

                                <?php foreach($item['value'] as $key => $val){ ?>
                                    <?php $b++; ?>
                                    @if($b==1)<div class="col-sm-4"> @endif
                                        <div style="text-align: left;">
                                            <div style="min-width: 90px; display: inline-block;" class="<?=(in_array($key, $singleProduct->value[$item['key']]))?'':'disabled' ?>">
                                                <input onclick="return false;" type="checkbox" name="{{$key}}" value="{{$key}}" <?=(in_array($key, $singleProduct->value[$item['key']]))?'checked':'disabled' ?>>
                                                {{$val['name']}}
                                            </div>
                                            @if(isset($val['css']))
                                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                            @endif
                                        </div>
                                        @if($b==4)</div> <?php $b=0; ?>@endif
                                <?php } ?>
                                @if($b!=0) </div> @endif
                                <?php $b = 0; ?>

                                <?php break;
                            case 'radio':?>

                                <?php
                                    if(array_key_exists($item['key'], $value)){
                                        if(is_array($singleProduct->value[$item['key']])){
                                            $value[$item['key']] = $value[$item['key']][0];
                                        }
                                    }else{
                                        $singleProduct->value[$item['key']] = '';
                                    }
                                ?>
                                <?php foreach($item['value'] as $key => $val){
                                        if($key == $singleProduct->value[$item['key']]){

                                        }
                                        ?>
                                        <?php $b++; ?>
                                        @if($b==1)<div class="col-sm-4"> @endif
                                            <div>
                                                <div style="min-width: 90px; display: inline-block;" class="<?=(in_array($key, $singleProduct->value[$item['key']]))?'':'disabled' ?>">
                                                    <input type="radio" name="{{$item['key']}}" value="{{$key}}" <?=($key == $singleProduct->value[$item['key']])?'checked':'disabled' ?>>
                                                    {{$val['name']}}
                                                </div>
                                                @if(isset($val['css']))
                                                    <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                @endif
                                            </div>
                                            @if($b==4)</div> <?php $b=0; ?>@endif
                                <?php } ?>
                                @if($b!=0) </div> @endif
                                <?php $b = 0; ?>

                                <?php break;
                            case 'select':?>
                                <?php
                                    if(array_key_exists($item['key'], $value)){
                                        if(is_array($singleProduct->value[$item['key']])){
                                            $singleProduct->value[$item['key']] = $singleProduct->value[$item['key']][0];
                                        }
                                    }else{
                                        $singleProduct->value[$item['key']] = '';
                                    }
                                ?>
                                <div class="<?=(in_array($key, $singleProduct->value[$item['key']]))?'':'disabled' ?>">
                                        <select name="{{$item['key']}}">
                                            <option value="">Выбирете значение</option>
                                            <?php foreach($item['value'] as $key => $val){ ?>
                                                <option value="{{$key}}" <?=($key == $singleProduct->value[$item['key']])?'selected':'disabled' ?>>{{$key}} <?php $key ?></option>
                                            <?php } ?>
                                        </select>
                                </div>
                            <?php break;
                    } ?>
                @endif
            </div>
        </div>
    @endforeach
</div>

<style>
    .disabled{
        color: #bfbfbf;
    }
    .title{
        font-size: 16px;
    }



</style>





