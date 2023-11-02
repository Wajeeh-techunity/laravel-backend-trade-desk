<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{asset('admin/images/cms-logo.png')}}" alt="CMS Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">CMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('admin/adminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{Request::is('admin/dashboard') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview @if(Request::is('admin/page') || Request::is('admin/page/create')) menu-open @endif">
                    <a href="{{route('page')}}" class="nav-link {{Request::is('admin/page') || Request::is('admin/page/create')  ? 'active' : ''}}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Pages
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('page')}}" class="nav-link {{Request::is('admin/page') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Pages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('create.page')}}" class="nav-link {{Request::is('admin/page/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Page</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview @if(Request::is('admin/role') || Request::is('admin/role/create')) menu-open @endif">
                    <a href="{{route('role')}}" class="nav-link {{Request::is('admin/role') || Request::is('admin/role/create') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Roles
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('role')}}" class="nav-link {{Request::is('admin/role') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('create.role')}}" class="nav-link {{Request::is('admin/role/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Role</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview @if(Request::is('admin/users') || Request::is('admin/users/create')) menu-open @endif">
                    <a href="{{route('users')}}" class="nav-link {{Request::is('admin/users') || Request::is('admin/users/create') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-user-tag"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users')}}" class="nav-link {{Request::is('admin/users') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('create.user')}}" class="nav-link {{Request::is('admin/users/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview @if(Request::is('admin/news') || Request::is('admin/news/create')) menu-open @endif">
                    <a href="{{route('news')}}" class="nav-link {{Request::is('admin/news') || Request::is('admin/news/create') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-rss-square"></i>
                        <p>
                            News Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('news')}}" class="nav-link {{Request::is('admin/news') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>News List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('create.news')}}" class="nav-link {{Request::is('admin/news/create') ? 'active' : ''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add News</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a href="{{route('menus')}}" class="nav-link {{Request::is('admin/menus') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-bars"></i>
                        <p>
                            Menu Management

                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{route('contact.queries')}}" class="nav-link {{Request::is('admin/contactus') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Contact Us

                        </p>
                    </a>
                </li>
                @if($site_settings->messenger == 1)
                <li class="nav-item">
                    <a href="{{route('message')}}" class="nav-link {{Request::is('admin/message') ? 'active' : ''}}">
                        <i class="far fa-comments nav-icon"></i>
                        <p>
                            Messenger
                        </p>
                    </a>
                </li>
                @endif

                <li class="nav-item ">
                    <a href="{{route('sitesettings')}}" class="nav-link {{Request::is('admin/sitesettings') ? 'active' : ''}}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Site Settings

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a data-target="#fileManager" href="javascript:;" data-toggle="modal" class="nav-link">
                        <i class="far fa-image nav-icon"></i>
                        <p>
                            File Manager
                        </p>
                    </a>
                </li>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
