@extends('layouts.app')

@section('content')

    <h1>Товар</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Категория товара</th><th>Товар</th><th>Описание товара</th><th>Фото</th><th>Цена</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$product->getCategory['title']}}</td> <td>{{ $product->product_name }}</td><td> {{ $product->product_description }} </td><td> {{ $product->product_image }} </td><td> {{ $product->product_price }} </td>
                </tr>
            </tbody>    
        </table>
    </div>


@endsection