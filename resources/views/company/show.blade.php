@extends('...layouts.master')

@section('content')

    <h1>Company</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Company Name</th><th>Company Description</th><th>Company Logo</th><th>Описание</th><th>Адрес</th><th>Контактная информация</th><th>Дополнительная информация</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                     <td> {{ $company->company_name }} </td><td> {{ $company->company_description }} </td><td> {{ $company->company_logo }} </td>
                    <td> {{ $company->company_content }} </td> <td> {{ $company->company_address }} </td> <td> {{ $company->company_contact_info }} </td> <td> {{ $company->company_additional_info }} </td>
                </tr>
            </tbody>    
        </table>
    </div>

@endsection