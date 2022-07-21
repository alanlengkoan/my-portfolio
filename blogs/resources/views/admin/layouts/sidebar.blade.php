<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset_admin('images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset_admin('images/logo-dark.png') }}" alt="" height="50">
            </span>
        </a>
        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset_admin('images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset_admin('images/logo-light.png') }}" alt="" height="50">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Dashboards</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.dashboard') }}">
                        <i data-feather="home" class="icon-dual"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>
                </li>
                <li class="menu-title"><span data-key="t-menu">Project</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.stack') }}">
                        <i data-feather="list" class="icon-dual"></i> <span data-key="t-dashboards">Stack</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.category') }}">
                        <i data-feather="list" class="icon-dual"></i> <span data-key="t-dashboards">Kategori</span>
                    </a>
                </li>
                <li class="menu-title"><span data-key="t-menu">Blog</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i data-feather="list" class="icon-dual"></i> <span data-key="t-dashboards">Tag</span>
                    </a>
                </li>
                <li class="menu-title"><span data-key="t-menu">Pustaka</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('admin.project') }}">
                        <i data-feather="code" class="icon-dual"></i> <span data-key="t-dashboards">Project</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i data-feather="file-plus" class="icon-dual"></i> <span data-key="t-dashboards">Blog</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>