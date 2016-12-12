
<div>
    @foreach($add_param as $item)

        <div class="div_container col-sm-12 param_holder">
            <tr>
                <td width="40%" class="right option_table">
                        {{$item['title']}}:
                </td>
                <td width="60%" class="product_description left">
            <div class="col-sm-10">
                @foreach($item['add_param'] as $key => $val)
                            {{$val['name']}}
                            {{--Price: +{{$val['price']}}--}}
                @endforeach
            </div>
                </td>
            </tr>
        </div>
    @endforeach
</div>







