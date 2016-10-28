@extends('admin.header_footer_layout')

@section('content')
    {{ Form::open(array('method' => 'POST')) }}
        {{Form::hidden('category_id', $category->id)}}
        <div class="row">
            <div class="col-sm-12">
                <h3>{{$category->title}}</h3>
                <div class="col-sm-6">
                    @foreach($addParam as $item)
                        <div style="margin-bottom: 10px;  box-shadow: 0 1px 10px 0 rgba(50,50,50,.2); background: #fff; padding: 5px;">
                            <div>
                                <input type="checkbox" name="param_id[]" value="{{$item->id}}" {{ (in_array($item->id, $category->getAddParam)) ? 'checked' : '' }} />
                                {{$item->title}}
                                <span data-id="{{$item->id}}" class="glyphicon glyphicon-triangle-bottom show_more" aria-hidden="true" style="cursor: pointer"></span>
                            </div>
                            <div id="{{$item->id}}" style="display: none">
                                <hr />
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
    {{Form::submit('Сохранить')}}
    {{ Form::close() }}


@endsection

<script>
    window.onload = function(){
        $('.show_more').on('click', function(){
            $('#' + $(this).attr('data-id')).toggle();
        });
    };
</script>
