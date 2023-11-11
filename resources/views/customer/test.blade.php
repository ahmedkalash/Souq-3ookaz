@extends('customer.layouts.app')

@section('head')
    <title>test</title>

@endsection

<form method="post" action="{{route('test.store')}}" enctype="multipart/form-data">
@csrf
    <input type="file" name="image">
    <button type="submit">submit</button>
</form>


@section('content')


@endsection


@push('scripts')

@endpush

