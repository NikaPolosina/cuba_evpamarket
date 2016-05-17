<tr>



    <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td><td><a href="{{ url('products', $item->id) }}">{{ $item->product_name }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->content }}</td><td>{{ $item->product_image }}</td><td>{{ $item->product_price }}</td>
    <td>
            <button type="submit" class="editCategoryButton btn btn-primary btn-xs"  data-toggle="modal" data-target="#myModal">Изменить</button>
            <button type="submit" class="deleteCategoryButton btn btn-danger btn-xs">Удалить</button>
    </td>
</tr>
