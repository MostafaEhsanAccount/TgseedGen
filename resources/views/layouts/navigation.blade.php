<header class="navbar navbar-expand-md navbar-light d-print-none border-bottom">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="{{ route('dashboard') }}" class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            {{ config('app.name', 'TgseedGen') }}
        </a>

        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 p-0 px-2" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="avatar avatar-sm">{{ Str::substr(Auth::user()->name ?? '?', 0, 1) }}</span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">{{ __('Profile') }}</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="navbar navbar-light">
                <div class="container-xl">
                    <ul class="navbar-nav">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
