
@extends('layouts.app')

@section('content')
    <div class="col-sm-10 col-md-offset-1">
        <h1>Товар</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                <tr>
                    <th>Фото</th><th>Товар</th><th>Описание товара</th><th>Цена</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td> {{ $singleProduct['product_image'] }} </td><td>{{ $singleProduct['product_name'] }}</td><td> {{ $singleProduct['product_description'] }} </td><td> {{ $singleProduct['product_price'] }} </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection


