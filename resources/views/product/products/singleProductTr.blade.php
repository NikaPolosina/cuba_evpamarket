<tr>



    <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td><td><a class="product_modal_show" href="">{{ $item->product_name }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->content }}</td><td>{{ $item->product_price }}</td>
    <td>
        <span class="open btn edit btn-primary btn-xs">Изменить</span>

        {{--<button type="submit" class="chang-product btn btn-primary btn-xs">Изменить</button>--}}

            <button type="submit" class="deleteCategoryButton btn btn-danger btn-xs">Удалить</button>
    </td>
</tr>
