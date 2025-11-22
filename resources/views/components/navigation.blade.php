<nav class="nav">
    <div class="nav-container">
        <div class="nav-items">
            <a href="{{ route('actors.create') }}"
               class="nav-link {{ request()->routeIs('actors.create') ? 'nav-link-active' : 'nav-link-inactive' }}">
                {{ __('messages.nav_submission_form') }}
            </a>
            <a href="{{ route('actors.index') }}"
               class="nav-link {{ request()->routeIs('actors.index') ? 'nav-link-active' : 'nav-link-inactive' }}">
                {{ __('messages.nav_all_submissions') }}
            </a>
            <a href="{{ route('actors.prompt') }}"
               class="nav-link {{ request()->routeIs('actors.prompt') ? 'nav-link-active' : 'nav-link-inactive' }}">
                {{ __('messages.nav_prompt_ai') }}
            </a>
        </div>
    </div>
</nav>
