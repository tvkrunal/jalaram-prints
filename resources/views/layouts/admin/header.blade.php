<nav class="navbar navbar-light position-lg-sticky top-lg-0 d-none d-lg-block overlap-10 flex-none bg-white border-bottom px-0 py-3" id="topbar">
    <div class="container-fluid gx-12">
        <div class="navbar-text text-capitalize">
            <div class="page-title d-flex">
                <h5>
                    <span class="font-weight-semibold">@yield('module_title')</span>
                    @if(isset($header) && isset($header['modelInfo']))
                        <span class="badge bg-info">{{ $header['modelInfo'] }}</span>
                    @endif
                </h5>
            </div>
        </div>
        <div class="navbar-user d-none d-sm-block ms-auto">
            <div class="hstack gap-3 ms-4">
                <div class="dropdown">
                    <a class="d-flex align-items-center" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="true">
                        <img class="avatar avatar-sm rounded-circle border" src="{{ !empty(Auth::user()->profile) && Storage::disk('public')->exists(Auth::user()->profile) ? asset('storage/' . Auth::user()->profile) : asset('images/logo.jpg') }}">
                        <div class="d-none d-sm-block ms-3">
                            <span class="h6 d-block">{{ Auth::user()->first_name .' '.Auth::user()->last_name }}</span>
                            <span class="text-xs text-muted d-block">{{ Auth::user()->getRoleNames()->first() }}</span>
                        </div>
                        <div class="d-none d-md-block ms-md-2"><i class="bi bi-chevron-down text-muted text-xs"></i></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                        <a class="dropdown-item" href=""><i class="bi bi-person-vcard me-3"></i>Profile</a>
                        @if (Auth::User()->hasRole('Marketing') || Auth::User()->hasRole('Administrator') || Auth::User()->hasRole('Admin'))
                            <a class="dropdown-item" href="{{ route('generate.sitemap') }}"><i class="bi bi-file-earmark-plus me-3"></i>Generate a New Sitemap</a>
                        @endif
                        <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-left me-3"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- /main navbar -->
