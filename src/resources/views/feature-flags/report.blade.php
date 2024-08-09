@extends('feature-flag::layouts.app')

@section('content')
    <h1>Feature Flag Report</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Total Flags</th>
                <th>Enabled Flags</th>
                <th>Disabled Flags</th>
                <th>Targeted Flags</th>
                <th>Untargeted Flags</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $statistics['total_flags'] }}</td>
                <td>{{ $statistics['enabled_flags'] }}</td>
                <td>{{ $statistics['disabled_flags'] }}</td>
                <td>{{ $statistics['targeted_flags'] }}</td>
                <td>{{ $statistics['untargeted_flags'] }}</td>
            </tr>
        </tbody>
    </table>
    <a href="{{ route('feature-flags-web.index') }}" class="btn btn-secondary">Back</a>
@endsection
