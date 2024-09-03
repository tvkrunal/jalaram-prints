<!-- Main sidebar -->
<nav class="navbar show navbar-vertical h-lg-screen navbar-expand-lg px-0 py-3 navbar-light bg-white border-bottom border-bottom-lg-0 border-end-lg scrollbar mb-0" id="sidebar">
    <div class="container-fluid gx-12">
        <button class="navbar-toggler ms-n2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button> 
        <a class="navbar-brand d-inline-block py-lg-2 py-0 mb-lg-5 px-lg-6 me-0" href="{{ route('admin')  }}">
            <img width="204" class="w-lg-auto w-sm-40 w-32" alt="logo" srcset="{{ asset('images/logo.jpg') }}">
        </a>
        <div class="navbar-user d-lg-none">
            <div class="dropdown">
                <a href="#" id="sidebarAvatar" class="d-flex align-items-center gap-2" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img width="38" src="{{ !empty(Auth::user()->profile) ? asset('storage/' . Auth::user()->profile) : asset('frontend/images/user-temp-img.svg') }}" class="avatar w-8 h-8 rounded-circle shadow-2">
                    <div class="d-sm-block d-none">
                        <span class="h6 d-block">{{ Auth::user()->first_name .' '.Auth::user()->last_name }}</span>
                        <span class="text-xs text-muted d-block">{{ Auth::user()->getRoleNames()->first() }}</span>
                    </div>
                    <i class="bi bi-chevron-down text-muted text-xs"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarAvatar">welcome
                <a class="dropdown-item" href=""><i class="bi bi-person-vcard me-3"></i>Edit profile</a>
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
        <div class="collapse navbar-collapse" id="sidebarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin')  }}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(auth::check())
                    @foreach($menuArr as $menuItem)
                        @can($menuItem['permission'])
                            @if($menuItem['url'] != "#" || !empty($menuItem['subItems']))
                                @if(!empty($menuItem['subItems']))
                                    <li class="nav-item nav-item-submenu siderbar-submodule">
                                @else
                                    <li class="nav-item">
                                @endif
                                    {{--check if menu item has sub menu --}}
                                    @if(!empty($menuItem['subItems']))
                                        <a class="nav-link {{ isSubMenuActive($menuItem['subItems']) ? 'active' : '' }}" href="#{{ $menuItem['label'] }}" data-bs-toggle="collapse" role="button" aria-expanded="{{ isSubMenuActive($menuItem['subItems']) ? 'true' : '' }}" aria-controls="{{ $menuItem['label'] }}">
                                    @else
                                        <a href="{{ URL::to($menuItem['url']) }}" class="nav-link  {{ ($currentMenuRoute == $menuItem['url']) ? 'active':'' }}">
                                    @endif
                                    <i class="{{ $menuItem['icon'] }}"></i>
                                    {{ $menuItem['label'] }}</a>
                                @if(!empty($menuItem['subItems']))
                                    <div class="collapse {{isSubMenuActive($menuItem['subItems']) ? 'show' : ''}}" id="{{ $menuItem['label'] }}">
                                        <ul class="nav nav-sm flex-column">
                                            {{--create section of sub menu items--}}
                                            @foreach($menuItem['subItems'] as $subItem)
                                                @can($subItem['permission'])
                                                    <li class="nav-item {{ Str::startsWith($currentMenuRoute, $subItem['url']) ? 'active' : '' }}">
                                                        {{--add the icon and name to the menu item--}}
                                                        <a href="{{ URL::to($subItem['url']) }}" class="nav-link {{ ($currentMenuRoute == $subItem['url']) ? 'active':'' }}">{{ $subItem['label'] }}</a>
                                                    </li>
                                                @endcan
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        @endcan
                    @endforeach
                @endif
                </li>
            </ul>
        </div>
    </div>
</nav>