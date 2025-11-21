@extends('layouts.app')

@section('content')
<div class="card">
    <h1 class="card-title">Submit Actor Information</h1>

    <form action="{{ route('actors.store') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">
                {{ __('messages.email_label') }}
            </label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="form-input @error('email') error @enderror"
                required
            >
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="form-label">
                {{ __('messages.description_label') }}
            </label>
            <textarea
                name="description"
                id="description"
                rows="6"
                class="form-textarea @error('description') error @enderror"
                required
            >{{ old('description') }}</textarea>
            <p class="form-helper">
                {{ __('messages.form_helper_text') }}
            </p>
            @error('description')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            {{ __('messages.submit_button') }}
        </button>
    </form>
</div>
@endsection
