<tr data-number="{{ $x }}">
    <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td>
    <td>{{ $x }}</td>
    <td><a class="product_modal_show" href="">{{ Str::limit($item->product_name, 80) }}</a></td>
    <td>{{  Str::limit($item->product_description, 300) }}</td>
    <td> {!! Str::limit( $item->content, 350) !!} </td>

    <td style="text-align: center;">{{ $item->product_price }}</td>
    <td>
        <span class="open btn edit btn-primary btn-xs"><span class="glyphicon  glyphicon-pencil" aria-hidden="true"></span></span>
        <button type="submit" class="deleteCategoryButton btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
    </td>
</tr>
