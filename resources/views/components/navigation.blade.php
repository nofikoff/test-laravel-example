<nav class="nav">
    <div class="nav-container">
        <div class="nav-items">
            <a href="{{ route('actors.create') }}"
               class="nav-link {{ request()->routeIs('actors.create') ? 'nav-link-active' : 'nav-link-inactive' }}">
                Submission Form
            </a>
            <a href="{{ route('actors.index') }}"
               class="nav-link {{ request()->routeIs('actors.index') ? 'nav-link-active' : 'nav-link-inactive' }}">
                All Submissions
            </a>
            <a href="{{ route('actors.prompt') }}"
               class="nav-link {{ request()->routeIs('actors.prompt') ? 'nav-link-active' : 'nav-link-inactive' }}">
                Prompt AI
            </a>
        </div>
    </div>
</nav>
