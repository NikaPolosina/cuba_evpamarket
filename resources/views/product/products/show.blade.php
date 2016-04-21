@extends('layouts.master')

@section('content')
    <h1>Product</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Product Id</th><th>Product Description</th><th>Product Image</th><th>Product Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $product->id }}</td> <td> {{ $product->product_id }} </td><td> {{ $product->product_description }} </td><td> {{ $product->product_image }} </td><td> {{ $product->product_price }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection