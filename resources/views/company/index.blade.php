@extends('...layouts.master')

@section('content')

    <h1>Company <a href="{{ url('company/create') }}" class="btn btn-primary pull-right btn-sm">Add New Company</a></h1>
    <div class="table">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>S.No</th><th>Company Name</th><th>Company Description</th><th>Company Logo</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
            {{-- */$x=0;/* --}}
            @foreach($company as $item)
                {{-- */$x++;/* --}}
                <tr>
                    <td>{{ $x }}</td>
                    <td><a href="{{ url('company', $item->id) }}">{{ $item->company_name }}</a></td><td>{{ $item->company_description }}</td><td>{{ $item->company_logo }}</td>
                    <td>
                        <a href="{{ url('company/' . $item->id . '/edit') }}">
                            <button type="submit" class="btn btn-primary btn-xs">Update</button>
                        </a> /
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['company', $item->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {!! $company->render() !!} </div>
    </div>

@endsection
