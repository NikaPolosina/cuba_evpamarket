@extends('layouts.app')

@section('content')

    @include('layouts.modalAscDelet')


<button type="button" class="btn btn-default tut" data-dismiss="modal">тут</button>


{!! HTML::script('/js/test.js') !!}


@endsection