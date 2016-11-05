
@if(count($addParam))
    <tr class="temp">
        <td colspan="2" style="text-align: center;"><h4><b>Дополнительные параметры</b></h4></td>
    </tr>

    @foreach($addParam as $item)
        <tr class="temp param_holder" data-key="{{$item['key']}}" data-type="{{$item['type_for_by']}}">
            <td width="45%" class="right"><b>{{$item['title']}}</b></td>
            <td width="55%" class="left">
                <?php if(is_array($item['value'])){
                    switch($item['type_for_by']){
                        case 'checkbox':
                            ?> <hr/> <?php
                            foreach($item['value'] as $key => $val){
                                if(in_array($key, $singleProduct->value[$item['key']])){ ?>
                                    <br><input type="checkbox" name="{{$item['key']}}[]" value="{{$key}}"> {{$val['name']}}
                                    <?php if(isset($val['css'])){?>
                                        <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                    <?php }
                                }
                            }
                            break;
                        case 'radio':
                            ?> <hr/> <?php
                            foreach($item['value'] as $key => $val){
                                if(in_array($key, $singleProduct->value[$item['key']])){ ?>
                                    <br><input type="radio" name="{{$item['key']}}" value="{{$key}}"> {{$val['name']}}
                                    <?php if(isset($val['css'])){?>
                                    <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                    <?php }
                                }
                            }
                            break;

                        case 'select': ?>
                            <hr/>
                            <select name="{{$item['key']}}">
                                <?php foreach($item['value'] as $key => $val){
                                    if(in_array($key, $singleProduct->value[$item['key']])){ ?>
                                        <option value="{{$key}}">{{$key}} <?php $key ?></option>
                                    <?php }
                                } ?>
                            </select> <?php
                            break;
                    }
                } ?>
            </td>
        </tr>
    @endforeach
@endif
