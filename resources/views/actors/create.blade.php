@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-8">
    <h1 class="text-3xl font-bold mb-6">Submit Actor Information</h1>

    <form action="{{ route('actors.store') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('messages.email_label') }}
            </label>
            <input
                type="email"
                name="email"
                id="email"
                value="{{ old('email') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                required
            >
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('messages.description_label') }}
            </label>
            <textarea
                name="description"
                id="description"
                rows="6"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                required
            >{{ old('description') }}</textarea>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('messages.form_helper_text') }}
            </p>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-200 font-medium"
        >
            {{ __('messages.submit_button') }}
        </button>
    </form>
</div>
@endsection
