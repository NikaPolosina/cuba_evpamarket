<?php

$ar = array();
for($i = 1; $i < 29; $i++){
    $ar[] = $i;
}

$s = 0;
$b = 0;
?>

@if(count($addParam))

    <div class="row" style=" border: 1px solid rgba(0, 0, 0, 0.09);; text-align: center">
        <h4>Дополнительные параметры</h4>
        @foreach($addParam as $item)
            <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}"
                 style="margin-bottom: 10px; ">
                <div class="col-sm-2">
                    {{$item['title']}}:
                </div>
                <div class="col-sm-10">
                        <?php
                            switch($item['type']){
                                case 'checkbox':?>

                                    @if(array_key_exists($item['key'], $value))
                                        @if(!is_array($value[$item['key']]))
                                            {{--*/$value[$item['key']][0]['val'] = ''; /*--}}
                                            {{--*/$value[$item['key']][0]['add_price'] = ''; /*--}}
                                            {{--*/$value[$item['key']][0]['add_price_type'] = ''; /*--}}
                                        @endif
                                    @else
                                        {{--*/$value[$item['key']][0]['val'] = ''; /*--}}
                                        {{--*/$value[$item['key']][0]['add_price'] = ''; /*--}}
                                        {{--*/$value[$item['key']][0]['add_price_type'] = ''; /*--}}
                                    @endif

                                    @foreach($item['value'] as $key => $val)
                                        <?php    $b++; ?>
                                        @if($b==1)
                                        <div class="col-sm-4"> @endif
                                                <div style="text-align: left;">
                                                    <div style="min-width: 90px; display: inline-block;">

                                                            <?php foreach($value[$item['key']] as $v){
                                                                    if($v['val'] == $key){
                                                                        $valu = 'checked';
                                                                        $add_price = $v['add_price'];
                                                                        $add_price_type = $v['add_price_type'];
                                                                        break;
                                                                    }else{
                                                                        $valu = '';
                                                                        $add_price = '';
                                                                        $add_price_type = '';
                                                                    }
                                                            }?>

                                                            <input type="checkbox" name="{{$key}}" value="{{$key}}" <?=$valu?> >{{$val['name']}}
                                                            <div class="add_price_holder_demo">
                                                                <input type="text" name="add_price" class="add_price" value="<?=$add_price ?> ">
                                                                <select name="add_price_type" class="add_price_type">
                                                                    <option value="val" <?=($v['add_price_type'] == 'val') ? 'selected' : ''?>>ru</option>
                                                                    <option value="per"  <?=($v['add_price_type'] == 'per') ? 'selected' : ''?>>%</option>
                                                                </select>
                                                            </div>

                                                    </div>
                                                    @if(isset($val['css']))
                                                        <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                    @endif
                                                </div>
                                            @if($b==4)</div> <?php $b = 0; ?>@endif
                                    @endforeach
                                    @if($b!=0) </div> @endif
                                                <?php $b = 0; ?>

                                    <?php
                                    break;
                                case 'radio':

                                    $random = substr( md5(rand()), 0, 7);

                                    ?>

                                    @if(array_key_exists($item['key'], $value))
                                        @if(!is_array($value[$item['key']]))
                                            {{--*/$value[$item['key']][0]['val'] = ''; /*--}}
                                            {{--*/$value[$item['key']][0]['add_price'] = ''; /*--}}
                                            {{--*/$value[$item['key']][0]['add_price_type'] = ''; /*--}}
                                        @endif
                                    @else
                                        {{--*/$value[$item['key']][0]['val'] = ''; /*--}}
                                        {{--*/$value[$item['key']][0]['add_price'] = ''; /*--}}
                                        {{--*/$value[$item['key']][0]['add_price_type'] = ''; /*--}}
                                    @endif



                                    @foreach($item['value'] as $key => $val)
                                        {{-- */$b++;/* --}}
                                        @if($b==1)
                                            <div class="col-sm-4"> @endif
                                                <div style="text-align: left;">


                                                    <?php foreach($value[$item['key']] as $v){
                                                        if($v['val'] == $key){
                                                            $valu = 'checked';
                                                            $add_price = $v['add_price'];
                                                            $add_price_type = $v['add_price_type'];
                                                            break;
                                                        }else{
                                                            $valu = '';
                                                            $add_price = '';
                                                            $add_price_type = '';
                                                        }
                                                    }?>


                                                    <input type="radio" name="{{$random}}" value="{{$key}}" <?=$valu?> >{{$val['name']}}
                                                    <div class="add_price_holder_demo">
                                                        <input type="text" name="add_price" class="add_price" value="<?=$add_price ?> ">
                                                        <select name="add_price_type" class="add_price_type">
                                                            <option value="val" <?=($v['add_price_type'] == 'val') ? 'selected' : ''?>>ru</option>
                                                            <option value="per"  <?=($v['add_price_type'] == 'per') ? 'selected' : ''?>>%</option>
                                                        </select>
                                                    </div>

                                                    @if(isset($val['css']))
                                                        <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                    @endif
                                                </div>
                                                @if($b==4)</div> <?php $b = 0; ?>@endif
                                    @endforeach
                                    @if($b!=0) </div> @endif
                                    <?php $b = 0; ?>

                                    <?php

                                    break;
                                case 'input':

                                    ?>

                                        @if(array_key_exists($item['key'], $value))
                                            @if(is_array($value[$item['key']]))
                                                {{-- */$value[$item['key']] = $value[$item['key']][0];/* --}}
                                            @else
                                                {{--*/$value[$item['key']]['val'] = ''; /*--}}
                                                {{--*/$value[$item['key']]['add_price'] = ''; /*--}}
                                                {{--*/$value[$item['key']]['add_price_type'] = ''; /*--}}
                                            @endif
                                        @else
                                            {{--*/$value[$item['key']]['val'] = ''; /*--}}
                                            {{--*/$value[$item['key']]['add_price'] = ''; /*--}}
                                            {{--*/$value[$item['key']]['add_price_type'] = ''; /*--}}
                                        @endif


                                        @if($item->request_buyer)
                                            <input name="{{$item['key']}}" class="form-control" placeholder="{{$item['placeholder']}}" data-name="{{$item['key']}}" type="text" value="{{$value[$item['key']]['val']}}" readonly/>
                                        @else
                                            <input name="{{$item['key']}}" class="form-control" placeholder="{{$item['placeholder']}}" data-name="{{$item['key']}}" type="text" value="{{$value[$item['key']]['val']}}"/>
                                        @endif

                                    <?php break;
                                case 'select':
                                    ?>

                                    @if(array_key_exists($item['key'], $value))
                                        @if(is_array($value[$item['key']]))
                                            {{--*/$value[$item['key']] = $value[$item['key']][0]; /*--}}
                                        @else
                                            {{--*/$value[$item['key']]['val'] = ''; /*--}}
                                            {{--*/$value[$item['key']]['add_price'] = ''; /*--}}
                                            {{--*/$value[$item['key']]['add_price_type'] = ''; /*--}}
                                        @endif
                                    @else
                                        {{--*/$value[$item['key']]['val'] = ''; /*--}}
                                        {{--*/$value[$item['key']]['add_price'] = ''; /*--}}
                                        {{--*/$value[$item['key']]['add_price_type'] = ''; /*--}}
                                    @endif


                                    <select name="{{$item['key']}}">
                                        <option value="">Выбирете значение</option>
                                        <?php foreach($item['value'] as $key => $val){ ?>
                                        <option value="{{$key}}" <?=($key == $value[$item['key']]['val']) ? 'selected' : '' ?>>{{$key}} <?php $key ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="add_price_holder_demo">
                                        <input type="text" name="add_price" class="add_price" value="{{$value[$item['key']]['add_price']}}">

                                        <select name="add_price_type" class="add_price_type">
                                            <option value="val" <?=($value[$item['key']]['add_price_type'] == 'val') ? 'selected' : ''?>>ru</option>
                                            <option value="per"  <?=($value[$item['key']]['add_price_type'] == 'per') ? 'selected' : ''?>>%</option>
                                        </select>
                                    </div>

                                    <?php

            break;
                            }
                        ?>

                </div>
            </div>
        @endforeach
    </div>
@else
    *В данной категории нет дополнительных параметров для отображения
@endif









