@extends('admin.header_footer_layout')

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
        <div class="col-sm-12">
            <h3>{{$category[0]->title}}</h3>

                <div class="col-sm-6">
@foreach($addParam as $param)

    <div style="margin-bottom: 30px;  box-shadow: 0 1px 10px 0 rgba(50,50,50,.2);
            background: #fff; padding: 5px;">
        {{$param->title}}
    </div>

         @endforeach       </div>


                <div class="col-sm-6">
                    @foreach($category[0]->getAddParam as $item)

                        <div class="div_container col-sm-12" style="margin-bottom: 30px;  box-shadow: 0 1px 10px 0 rgba(50,50,50,.2);
            background: #fff; padding: 5px;">
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





        </div>

    </div>






@endsection

