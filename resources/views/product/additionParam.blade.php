

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

        <div class="div_container col-sm-12" style="margin-bottom: 30px; ">
            <div class="col-sm-2">
                {{$item['title']}}:
            </div>

            <div class="col-sm-10">
                @if(is_array($item['value']))
                    @foreach($item['value'] as $key => $val)
                        <?php $b++; ?>
                        @if($b==1)<div class="col-sm-4"> @endif
                        <div>
                            <div style="min-width: 90px; display: inline-block;">
                                <input type="checkbox" name={{$key}}" value="{{$key}}">
                                {{$val['name']}}
                            </div>

                            @if(isset($val['css']))
                                <div style="display:inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></div>
                            @endif
                        </div>
                        @if($b==4)</div> <?php $b=0; ?>@endif

                    @endforeach

                    @if($b!=0) </div> @endif
                    <?php $b = 0; ?>
                @endif


            </div>


        </div>

    @endforeach


</div>







