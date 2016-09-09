@foreach ($products as $item)

    @include('product.singleProductTr', array('item' => $item))

@endforeach