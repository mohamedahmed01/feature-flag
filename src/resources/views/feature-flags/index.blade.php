@extends('feature-flag::layouts.app')

@section('content')
    <h1>Feature Flags</h1>
    <a href="{{ route('feature-flags-web.create') }}" class="btn btn-primary">Create Feature Flag</a>
    <a href="{{ route('feature-flags-web.report') }}" class="btn btn-info">Report</a>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Enabled</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($featureFlags as $featureFlag)
                <tr>
                    <td>{{ $featureFlag->name }}</td>
                    <td>{{ $featureFlag->description }}</td>
                    <td>{{ $featureFlag->enabled ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('feature-flags-web.show', $featureFlag->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('feature-flags-web.edit', $featureFlag->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('feature-flags-web.destroy', $featureFlag->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
