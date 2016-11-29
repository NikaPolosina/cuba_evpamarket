@extends('..admin.header_footer_layout')

@section('content')

    <?php

    $ar = array();
    for($i = 1; $i<29; $i++){
        $ar[] = $i;
    }

    $s = 0;
    $b = 0;
    ?>


    <div class="row">


            <div class="div_container col-sm-8 col-sm-offset-2" style="margin-bottom: 30px;">
                <div class="col-sm-2">
                    {{$param['title']}}:
                </div>

                <div class="col-sm-10">
                    @if(is_array($param['value']))
                        @foreach($param['value'] as $key => $val)
                            <?php $b++; ?>
                            @if($b==1)<div class="col-sm-4"> @endif
                                <div>

                                    <div style="min-width: 90px; display: inline-block;">
                                        <input type="checkbox" name={{$key}}" value="{{$key}}">
                                        {{$val['name']}}
                                    </div>

                                    @if(isset($val['css']) && $val['css'] != '')
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







    </div>
@endsection