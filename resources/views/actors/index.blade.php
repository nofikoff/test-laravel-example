@extends('layouts.fullwidth')

@section('content')
<div class="card">
    <div class="card-header">
        <h1 class="card-title">{{ __('messages.actors_table_title') }}</h1>
        <a href="{{ route('actors.create') }}" class="btn btn-primary">
            {{ __('messages.new_submission_button') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($actors->isEmpty())
        <p class="empty-state">{{ __('messages.no_actors') }}</p>
    @else
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('messages.first_name') }}</th>
                        <th>{{ __('messages.last_name') }}</th>
                        <th>{{ __('messages.email') }}</th>
                        <th>{{ __('messages.address') }}</th>
                        <th>{{ __('messages.gender') }}</th>
                        <th>{{ __('messages.height') }}</th>
                        <th>{{ __('messages.weight') }}</th>
                        <th>{{ __('messages.age') }}</th>
                        <th>{{ __('messages.submitted') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actors as $actor)
                        <tr>
                            <td>{{ $actor->first_name }}</td>
                            <td>{{ $actor->last_name }}</td>
                            <td>{{ $actor->email }}</td>
                            <td class="text-wrap">{{ $actor->address }}</td>
                            <td class="text-secondary">{{ $actor->gender ?? '-' }}</td>
                            <td class="text-secondary">{{ $actor->height ?? '-' }}</td>
                            <td class="text-secondary">{{ $actor->weight ?? '-' }}</td>
                            <td class="text-secondary">{{ $actor->age ?? '-' }}</td>
                            <td class="text-secondary">{{ $actor->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $actors->links() }}
        </div>
    @endif
</div>
@endsection
