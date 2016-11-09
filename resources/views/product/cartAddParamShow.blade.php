
{{--<div class="row" style="text-align: center">--}}
   {{-- <tr><td with=100% class="option_table">Дополнительные параметры</td></tr>--}}

    @foreach($addParam as $item)
        <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}">
            <tr>
                <td width="40%" class="right option_table">
                    {{--<div class="col-sm-2 title">--}}
                                {{$item['title']}}:
{{--
                    </div>--}}
                </td>
                <td width="60%" class="product_description left">
            <div class="col-sm-10">

                @if(is_array($item['value']) && array_key_exists($item['key'], $singleProduct->value))
                    <?php
                    foreach($item['value'] as $key => $val){
                                if(is_array($singleProduct->value[$item['key']])){
                                    foreach ($singleProduct->value[$item['key']] as $value) {
                                        if($key == $value){
                                            echo '<div>';
                                                echo $val['name'];
                                                if(isset($val['css'])){?>
                                                    <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}; margin-left: 5px;"></div>
                                                <?php }
                                            echo '<input type="hidden" name="product['.$singleProduct->id.'][add_param]['.$item['key'].'][key][]" value="'.$key.'">';
                                            echo '<input type="hidden" name="product['.$singleProduct->id.'][add_param]['.$item['key'].'][name][]" value="'.$val['name'].'">';
                                            echo '</div>';
                                        }
                                    }
                                }else{
                                    if($key == $singleProduct->value[$item['key']]){
                                        echo '<div>';
                                            echo $val['name'];
                                            if(isset($val['css'])){?>
                                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                            <?php }
                                        echo '<input type="hidden" name="product['.$singleProduct->id.'][add_param]['.$item['key'].'][key][]" value="'.$key.'">';
                                        echo '<input type="hidden" name="product['.$singleProduct->id.'][add_param]['.$item['key'].'][name][]" value="'.$val['name'].'">';
                                        echo '</div>';
                                    }
                                }
                    } ?>
                @else

                    @if(array_key_exists($item['key'], $singleProduct['value']))
                        <div class="">{{$singleProduct['value'][$item['key']]}}</div>
                        <input type="hidden" name="product[{{$singleProduct->id}}][add_param][{{$item['key']}}][key][]" value="{{$singleProduct['value'][$item['key']]}}">
                    @endif
                @endif
            </div>
                </td>
            </tr>
        </div>
    @endforeach
</div>







