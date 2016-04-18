@extends('layouts.master')

@section('content')

    <h1>Company</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>ID.</th> <th>Company Name</th><th>Company Description</th><th>Company Logo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $company->id }}</td> <td> {{ $company->company_name }} </td><td> {{ $company->company_description }} </td><td> {{ $company->company_logo }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection