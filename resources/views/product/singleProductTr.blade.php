<tr data-number="{{ $x }}" class="my_tr">
    <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td>
    <td>{{ $x }}</td>
    <td><a href="/single-product-my-shop/{{ $item->id }}">{{ Str::limit($item->product_name, 80) }}</a></td>
    <td>{{  Str::limit($item->product_description, 300) }}</td>
    <td> {!! Str::limit( $item->content, 350) !!} </td>

    <td style="text-align: center;">{{ $item->product_price }}</td>
    <td>
        @if($type == 'archive')
            <a href="/restore-product/{{ $item->id }}">
                 <span  data-toggle="tooltip" data-placement="top" title="Восстановить"  class="btn edit btn-success btn-xs" >
                    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
                </span>
            </a>
        @else
            <span  data-toggle="tooltip" data-placement="top" title="Редактировать"  class="open btn edit btn-primary btn-xs" >
                 <span class="glyphicon  glyphicon-pencil" aria-hidden="true"></span>
            </span>
        @endif

        <button  data-toggle="tooltip" data-placement="top" title="Удалить" type="submit" class="deleteCategoryButton btn btn-danger btn-xs">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </button>
    </td>
</tr>



<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>

