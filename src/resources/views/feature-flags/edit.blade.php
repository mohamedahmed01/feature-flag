@extends('feature-flag::layouts.app')

@section('content')
    <h1>Edit Feature Flag</h1>
    <form action="{{ route('feature-flags-web.update', $featureFlag->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('feature-flag::feature-flags.form')
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
