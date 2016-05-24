@extends('layouts.app')

@section('content')

    <h1>Products <a href="{{ url('products/create') }}" class="btn btn-primary pull-right btn-sm">Add New Product</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th>Product Id</th><th>Product Description</th><th>Product Image</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>


            {{-- */$x=0;/* --}}
            @foreach($products as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('products', $item->id) }}">{{ $item->product_id }}</a></td><td>{{ $item->product_description }}</td><td>{{ $item->product_image }}</td>
                    <td>
                        <a href="{{ url('products/' . $item->id . '/edit') }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['products', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $products->render() !!} </div>
    </div>

@endsection
