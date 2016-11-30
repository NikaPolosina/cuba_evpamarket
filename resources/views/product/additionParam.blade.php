<?php

$ar = array();
for($i = 1; $i < 29; $i++){
    $ar[] = $i;
}

$s = 0;
$b = 0;
?>

@if(count($addParam))

    <div class="row" style="text-align: center">
        <h4>Дополнительные параметры</h4>
        @foreach($addParam as $item)
            <div class="div_container col-sm-12 param_holder" data-key="{{$item['key']}}" data-type="{{$item['type']}}"
                 style="margin-bottom: 10px; ">
                <div class="col-sm-3" style="text-align: right;">
                    {{$item['title']}}:
                </div>
                <div class="col-sm-9">
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
                                    @if($b==1)
                                        <div class="col-sm-4"> @endif
                                            <div style="text-align: left;">
                                                <div style="min-width: 90px; display: inline-block;">
                                                    <input type="checkbox" name="{{$key}}"
                                                           value="{{$key}}" <?=(in_array($key, $value[$item['key']])) ? 'checked' : '' ?>>
                                                    {{$val['name']}}
                                                </div>
                                                @if(isset($val['css']))
                                                    <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                @endif
                                            </div>
                                            @if($b==4)</div> <?php $b = 0; ?>@endif
                                    <?php } ?>
                                    @if($b!=0) </div> @endif
                                                <?php $b = 0; ?>

                                    <?php break;
                                case 'radio':
                                    $random = substr( md5(rand()), 0, 7);
                                    ?>

                                    @if(array_key_exists($item['key'], $value))
                                        @if(is_array($value[$item['key']]))
                                            {{$value[$item['key']] = $value[$item['key']][0]}}
                                        @endif
                                    @else
                                        {{ $value[$item['key']] = ''}}
                                    @endif
                                    @foreach($item['value'] as $key => $val)
                                        {{-- */$b++;/* --}}
                                        @if($b==1)
                                            <div class="col-sm-4"> @endif
                                                <div style="text-align: left;">
                                                    <div style="min-width: 90px; display: inline-block;">
                                                        <input type="radio" name="{{$item['key']}}{{$random}}"
                                                               value="{{$key}}" <?=($key == $value[$item['key']]) ? 'checked' : '' ?>>
                                                        {{$val['name']}}
                                                    </div>
                                                    @if(isset($val['css']))
                                                        <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                                                    @endif
                                                </div>
                                                @if($b==4)</div> <?php $b = 0; ?>@endif
                                    @endforeach
                                    @if($b!=0) </div> @endif
                                    <?php $b = 0; ?>

                                    <?php break;
                                case 'input':?>

                                        @if(array_key_exists($item['key'], $value))
                                            @if(is_array($value[$item['key']]))
                                                {{-- */$value[$item['key']] = $value[$item['key']][0];/* --}}
                                            @endif
                                        @else
                                            {{-- */$value[$item['key']] = '';/* --}}
                                        @endif

                                        @if($item->request_buyer)
                                            <input name="{{$item['key']}}" class="form-control" placeholder="{{$item['placeholder']}}" data-name="{{$item['key']}}" type="text" value="{{$value[$item['key']]}}" readonly/>
                                        @else
                                            <input name="{{$item['key']}}" class="form-control" placeholder="{{$item['placeholder']}}" data-name="{{$item['key']}}" type="text" value="{{$value[$item['key']]}}"/>
                                        @endif

                                    <?php break;
                                case 'select':?>
                                    {{-- */ /* --}}
                                    @if(array_key_exists($item['key'], $value))
                                        @if(is_array($value[$item['key']]))
                                            {{-- */$value[$item['key']] = $value[$item['key']][0];/* --}}
                                        @endif
                                    @else
                                        {{-- */ $value[$item['key']] = ''; /* --}}
                                    @endif
                                    <select name="{{$item['key']}}">
                                        <option value="">Выбирете значение</option>
                                        <?php foreach($item['value'] as $key => $val){ ?>
                                        <option value="{{$key}}" <?=($key == $value[$item['key']]) ? 'selected' : '' ?>>{{$key}} <?php $key ?></option>
                                        <?php } ?>
                                    </select>
                                    <?php break;
                            }
                        ?>

                </div>
            </div>
        @endforeach
    </div>
@else
   <p class="bg-warning" style="padding: 15px;">*В данной категории нет дополнительных параметров для отображения</p>
@endif









