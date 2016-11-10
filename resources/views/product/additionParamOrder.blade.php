
@if(count($addParam))
    <tr class="temp">
        <td colspan="2" style="text-align: center;"><h4><b>Дополнительные параметры</b></h4></td>
    </tr>

    @foreach($addParam as $item)
        <tr class="temp param_holder" data-key="{{$item['key']}}" data-type="{{$item['type_for_by']}}">
            <td width="45%" class="right"><b>{{$item['title']}}</b></td>
            <td width="55%" class="left rad">
                <?php

                    switch($item['type_for_by']){
                        case 'checkbox':

                            foreach($item['value'] as $key => $val){
                                if(in_array($key, $singleProduct->value[$item['key']])){
                                    if(count($singleProduct->value[$item['key']]) == 1){?>
                                        <input style="display: none" type="checkbox" name="{{$item['key']}}[]" value="{{$key}}" checked> {{$val['name']}}
                                    <?php }else{ ?>
                                        <input type="checkbox" name="{{$item['key']}}[]" value="{{$key}}"> {{$val['name']}}
                                    <?php }?>
                                    <?php if(isset($val['css'])){?>
                                        <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                    <?php }
                                }
                            }

                            break;
                        case 'radio':
                            if(is_array($item['value'])){
                                foreach($item['value'] as $key => $val){
                                    if(in_array($key, $singleProduct->value[$item['key']])){ ?>
                                        {{-- <br>--}}<input type="radio" name="{{$item['key']}}" value="{{$key}}"> {{$val['name']}}
                                        <?php if(isset($val['css'])){?>
                                            <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                        <?php }
                                    }
                                }
                            }
                            break;
                        case 'select': ?>
                            <select name="{{$item['key']}}">
                                <?php
                                    if(is_array($item['value'])){
                                        foreach($item['value'] as $key => $val){
                                            if(in_array($key, $singleProduct->value[$item['key']])){ ?>
                                                <option value="{{$key}}">{{$key}} <?php $key ?></option>
                                            <?php }
                                        }
                                    }else{?>
                                            <option value="">Пусто</option>
                                    <?php } ?>


                            </select> <?php
                            break;
                    case 'input':?>
                        <div class=""><?=$singleProduct->value[$item['key']]?></div>
                        <input type="hidden" name="<?=$item['key']?>" value="<?=$singleProduct->value[$item['key']]?>">
                        <?php
                    break;
                    }
                 ?>
            </td>
        </tr>
    @endforeach
@endif
<style>
    .rad>input{
        width: 50%;
    }

</style>