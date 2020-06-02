<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Laravel') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ ! Route::is('dashboard.folders.*') ?: 'active' }}">
        <a class="nav-link" href="{{ route('dashboard.folders.index') }}">
            <i class="far fa-folder-open"></i>
            <span>Folders</span>
        </a>
    </li>
    <li class="nav-item {{ ! Route::is('dashboard.categories.*') ?: 'active' }}">
        <a class="nav-link" href="{{ route('dashboard.categories.index') }}">
            <i class="fas fa-list-ul"></i>
            <span>Categories</span>
        </a>
    </li>
    <li class="nav-item {{ ! Route::is('dashboard.albums.*') ?: 'active' }}">
        <a class="nav-link" href="{{ route('dashboard.albums.index') }}">
            <i class="fas fa-images"></i>
            <span>Albums</span>
        </a>
    </li>
    <li class="nav-item {{ ! Route::is('dashboard.regenerate.*') ?: 'active' }}">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-sync"></i>
            <span>Regenerate</span>
        </a>
        <div id="collapseTwo" class="collapse {{ ! Route::is('dashboard.regenerate.*') ?: 'show' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="#">All</a>
                <a class="collapse-item {{ ! Route::is('dashboard.regenerate.category') ?: 'active' }}" href="{{ route('dashboard.regenerate.category') }}">By Category</a>
                <a class="collapse-item" href="#">By Album</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>