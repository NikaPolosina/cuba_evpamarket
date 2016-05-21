@foreach ($products as $item)

    @include('product.products.singleProductTr', array('item' => $item))

@endforeach