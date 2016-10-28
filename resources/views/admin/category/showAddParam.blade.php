@extends('admin.header_footer_layout')

@section('content')


    <?php
    $s = 0;
    $b = 0;
    ?>


    <div class="row">
        <div class="col-sm-12">
            <h3>{{$category->title}}</h3>
            <div class="col-sm-6">
                @foreach($addParam as $item)
                        <div style="margin-bottom: 30px;  box-shadow: 0 1px 10px 0 rgba(50,50,50,.2); background: #fff; padding: 5px;">
                            <span data-id="{{$item->id}}"><input type="checkbox"/>{{$item->title}}</span>
                            <div data-id="{{$item->id}}" style="display: none">
                                @if(is_array($item['value']))
                                    @foreach($item['value'] as $key => $val)
                                        <div style="min-width: 90px; display: inline-block;">
                                            <input disabled type="checkbox" name={{$key}}" value="{{$key}}">
                                            {{$val['name']}}
                                            @if(isset($val['css']))
                                                <spam style="display: inline-block; width: 30px; min-height: 20px; border: solid 1px grey; background-color: {{$val['css']}}"></spam>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>


@if(false)
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
    @endif



@endsection

