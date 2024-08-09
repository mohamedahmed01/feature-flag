@extends('feature-flag::layouts.app')

@section('content')
    <h1>Create Feature Flag</h1>
    <form action="{{ route('feature-flags-web.store') }}" method="POST">
        @csrf
        @include('feature-flag::feature-flags.form')
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
