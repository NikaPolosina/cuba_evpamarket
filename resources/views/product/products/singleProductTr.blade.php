<tr>



    <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td><td><a href="{{ url('products', $item->id) }}">{{ $item->product_name }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->product_image }}</td><td>{{ $item->product_price }}</td>
    <td>
        <a href="{{ url('products/' . $item->id . '/edit-categoty') }}">
            <button type="submit" class="editCategoryButton btn btn-primary btn-xs">Изменить</button>
        </a>
        {!! Form::open([
        'method'=>'DELETE',
        'url' => ['products', $item->id],
        'style' => 'display:inline'
        ]) !!}
        {!! Form::submit('Удалить', ['class' => 'btn btn-danger btn-xs']) !!}
        {!! Form::close() !!}

    </td>
</tr>
