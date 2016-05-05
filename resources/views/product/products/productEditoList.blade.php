<table class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th colspan="6">
            <?php

            $mainCategory = array_shift($category);
            echo $mainCategory[0]['title'];
            ?>

        </th>
    </tr>
    <tr>
        <th colspan="6">

            <?php
            $bread = '';
            foreach ($category as $value) {
                $bread = $bread.$value[0]['title'].' > ';
            }

            echo $bread;
            ?>

        </th>



    </tr>
    <tr>
        <th>№</th><th>Товар</th><th>Описание товара</th><th>Фото</th><th>Цена</th><th>Действие</th>
    </tr>
    </thead>
    <tbody class="tBody">


    @foreach ($products as $item)

        <tr>

            <td><input class="option" type="checkbox" name="option" value="{{ $item->id }}"></td><td><a href="{{ url('products', $item->id) }}">{{ $item->product_name }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->product_image }}</td><td>{{ $item->product_price }}</td>
            <td>



                <a href="{{ url('products/' . $item->id . '/edit') }}">
                    <button type="submit" class="btn btn-primary btn-xs">Изменить</button>
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





    @endforeach

    </tbody>

</table>
<a href="{{ url('products/create/'.$company) }}" class="btn btn-primary pull-left btn-sm">+</a>
<a href="{{--{{ url('products/destroy-check') }}--}}" id="destroycheck" class="destroycheck btn btn-danger pull-left btn-sm">x</a>
<script>
    $('#destroycheck').on('click', function() {
        event.preventDefault();
        var selected = [];
        var inputs = $('.tBody').find('input:checked');
        inputs.each(function() {
            selected.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "/products/destroy-check",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: '<?=$company?>',
                checkId: selected
            },
            success: function(msg){
                inputs.each(function() {
                    $(this).parents('tr').eq(0).remove();
                });

                

            }
        });

    });








</script>