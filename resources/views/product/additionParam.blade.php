

<?php

$ar = array();
        for($i = 1; $i<29; $i++){
            $ar[] = $i;
        }

        $s = 0;
        $b = 0;
?>


<div class="row" style=" border: 1px solid rgba(0, 0, 0, 0.09);; text-align: center">
    <h4>Дополнительные параметры</h4>
    @foreach($addParam as $item)
        <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}" style="margin-bottom: 30px; ">
            <div class="col-sm-2">
                {{$item['title']}}:
            </div>
            <div class="col-sm-10">
                @if(is_array($item['value']))
                    <?php
                    switch($item['type']){
                            case 'checkbox':?>

                                <?php
                                if(!array_key_exists($item['key'], $value)){
                                    $value[$item['key']] = array();
                                }
                                ?>

                                <?php foreach($item['value'] as $key => $val){ ?>
                                    <?php $b++; ?>
                                    @if($b==1)<div class="col-sm-4"> @endif
                                        <div style="text-align: left;">
                                            <div style="min-width: 90px; display: inline-block;">
                                                <input type="checkbox" name="{{$key}}" value="{{$key}}" <?=(in_array($key, $value[$item['key']]))?'checked':'' ?>>
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
                                        if(is_array($value[$item['key']])){
                                            $value[$item['key']] = $value[$item['key']][0];
                                        }
                                    }else{
                                        $value[$item['key']] = '';
                                    }
                                ?>
                                <?php foreach($item['value'] as $key => $val){ ?>
                                <?php $b++; ?>
                                @if($b==1)<div class="col-sm-4"> @endif
                                    <div>
                                        <div style="min-width: 90px; display: inline-block;">
                                            <input type="radio" name="{{$item['key']}}" value="{{$key}}" <?=($key == $value[$item['key']])?'checked':'' ?>>
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
                                        if(is_array($value[$item['key']])){
                                            $value[$item['key']] = $value[$item['key']][0];
                                        }
                                    }else{
                                        $value[$item['key']] = '';
                                    }
                                ?>
                                <select name="{{$item['key']}}">
                                    <option value="">Выбирете значение</option>
                                    <?php foreach($item['value'] as $key => $val){ ?>
                                        <option value="{{$key}}" <?=($key == $value[$item['key']])?'selected':'' ?>>{{$key}} <?php $key ?></option>
                                    <?php } ?>
                                </select>
                            <?php break;
                    } ?>
                @endif
            </div>
        </div>
    @endforeach
</div>







