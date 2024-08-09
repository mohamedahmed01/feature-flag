@extends('feature-flag::layouts.app')

@section('content')
    <h1>Feature Flag: {{ $featureFlag->name }}</h1>
    <p>Description: {{ $featureFlag->description }}</p>
    <p>Enabled: {{ $featureFlag->enabled ? 'Yes' : 'No' }}</p>
    <p>Audience: {{ json_encode($featureFlag->audience) }}</p>
    <p>Percentage: {{ $featureFlag->percentage }}%</p>
    <p>Finish Date: {{ $featureFlag->finish_date }}</p>
    <a href="{{ route('feature-flags-web.index') }}" class="btn btn-secondary">Back</a>
@endsection
