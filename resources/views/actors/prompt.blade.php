@extends('layouts.app')

@section('content')
<div class="card">
    <h1 class="card-title">AI Prompt Configuration</h1>

    <div class="form-group">
        <h2 class="prompt-section-title">Current AI Prompt</h2>
        <div class="prompt-display">{{ $prompt }}</div>
    </div>

    <div class="form-group">
        <h2 class="prompt-section-title">API Endpoint</h2>
        <p class="prompt-description">Get this prompt via API:</p>
        <div class="code-block">
            <div class="code-line">
                <span class="http-method">GET</span> <span class="http-url">{{ $apiUrl }}</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <h2 class="prompt-section-title">Example cURL Request</h2>
        <div class="code-block-pre">curl {{ $apiUrl }}</div>
    </div>

    <div class="form-group">
        <h2 class="prompt-section-title">Expected Response</h2>
        <div class="json-output">{
  "message": "{{ $prompt }}"
}</div>
    </div>

    <div class="form-group divider-section">
        <h2 class="prompt-section-title">Expected JSON Fields</h2>
        <ul class="field-list">
            <li><strong>firstName</strong> - Actor's first name (required)</li>
            <li><strong>lastName</strong> - Actor's last name (required)</li>
            <li><strong>address</strong> - Actor's address (required)</li>
            <li><strong>height</strong> - Actor's height (optional)</li>
            <li><strong>weight</strong> - Actor's weight (optional)</li>
            <li><strong>gender</strong> - Actor's gender (optional)</li>
            <li><strong>age</strong> - Actor's age (optional)</li>
        </ul>
    </div>
</div>
@endsection
