<!-- Main sidebar -->
<div class="sidebar sidebar-light sidebar-main sidebar-expand-md">

    <!-- Sidebar mobile toggler -->
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-main-toggle">
            <i class="icon-arrow-left8"></i>
        </a>
        Navigation
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
    </div>
    <!-- /sidebar mobile toggler -->

    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- User menu -->
        <div class="sidebar-user-material">
            <div class="sidebar-user-material-body">
                <div class="card-body text-center">
                    <a href="{{ url('admin')  }}">
                        <img src="{{ asset('images/logo.jpg') }}" class="img-fluid mb-2" alt="" srcset="{{ asset('images/logo.jpg') }}">
                    </a>

                </div>

                <div class="sidebar-user-material-footer">
                    <a href="#user-nav" class="d-flex justify-content-between align-items-center text-shadow-dark dropdown-toggle" data-toggle="collapse"><span>{{ isset(Auth::user()->first_name) ? Auth::user()->first_name: ''}}({{ isset(Auth::user()->email) ? Auth::user()->email: ''}})</span></a>
                </div>
            </div>

            <div class="collapse" id="user-nav">
                <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            <i class="icon-switch2"></i>
                            <span>Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /user menu -->
        <!-- Main navigation -->
        <div class="card card-sidebar-mobile">
            <ul class="nav nav-sidebar edge-sidebar" data-nav-type="accordion">
                <!-- Main -->
                <li class="nav-item">
                    <a href="{{ url('home')  }}" class="nav-link {{ Request::is('home') || Request::is('/') ? 'active' : '' }}">
                        <i class="fa fa-tachometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @if(auth::check())
                    @foreach($menuArr as $menuItem)
                        {{--show item only if it has url or a sub menu--}}
                        @if(!empty($menuItem['subItems']))
                            @if(!empty($menuItem['subItems']))
                                <li class="nav-item nav-item-submenu">
                            @else
                                <li class="nav-item">
                            @endif
                                @if(!empty($menuItem['subItems']))
                                    <li class="nav-item-header">
                                @else
                                    <li class="nav-item-header">
                                @endif
                                        <span class="main-menu-label">{{ $menuItem['label'] }}</span>
                                    </li>
                                    @if(!empty($menuItem['subItems']))
                                        @foreach($menuItem['subItems'] as $subItem)
                                            <li class="nav-item {{ ($currentMenuRoute == $subItem['url']) ? 'active':'' }}">
                                                {{--add the icon and name to the menu item--}}
                                                <a href="{{ URL::to($subItem['url']) }}" class="nav-link {{ ($currentMenuRoute == $subItem['url']) ? 'active':'' }}">
                                                    <i class="{{ $subItem['icon'] }}"></i>
                                                    <span>{{ $subItem['label'] }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
        <!-- /main navigation -->
    </div>
    <!-- /sidebar content -->
</div>
<!-- /main sidebar -->
