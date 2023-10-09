<aside class="sidebar-wrapper">
    <div class="sidebar sidebar-collapse" id="sidebar">
        <div class="sidebar__menu-group">
            <ul class="sidebar_nav">
                <li class="menu-title">
                    <span>Main menu</span>
                </li>
                <li class=" ">
                    <a href="{{ route('dashboard') }}" class="{{ areActiveRoutes(['dashboard']) }}">
                        <span data-feather="home" class="nav-icon"></span>
                        <span class="menu-text">Dashboard</span>
                        
                    </a>
                </li>

                @canany(['sopc-list', 'sopc-create', 'sopc-edit', 'sopc-view'])
                <li class="has-child {{ openActiveRoutes(['sopc.index','sopc.create','sopc.show','sopc.notification','sopc.timeline','sopc.edit','sopc.status']) }}">
                    <a href="#" class="{{ areActiveRoutes(['sopc.index','sopc.create','sopc.show','sopc.notification','sopc.timeline','sopc.edit','sopc.status']) }}">
                        <span data-feather="shopping-bag" class="nav-icon"></span>
                        <span class="menu-text">SOPC Repots</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        @can('sopc-create')
                        <li>
                            <a href="{{ route('sopc.create') }}" class="{{ areActiveRoutes(['sopc.create']) }}">Create SOPC Report</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('sopc.index') }}" class="{{ areActiveRoutes(['sopc.index','sopc.show','sopc.notification','sopc.timeline','sopc.edit','sopc.status']) }}">All SOPC Reports</a>
                        </li>

                    </ul>
                </li>
                @endcanany

                @canany(['order-list', 'order-create', 'order-edit', 'order-delete', 'order-view','jobcard-view'])
                <!-- <li class="has-child {{ openActiveRoutes(['order.index','order.create','order.show','job-cards']) }}">
                    <a href="#" class="{{ areActiveRoutes(['order.index','order.create','order.show','job-cards']) }}">
                        <span data-feather="shopping-bag" class="nav-icon"></span>
                        <span class="menu-text">Sales Orders</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        @can('order-create')
                        <li>
                            <a href="{{ route('order.create') }}" class="">Create Sales Order</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('order.index') }}" class="{{ areActiveRoutes(['order.index','order.show','job-cards']) }}">All Sales Orders</a>
                        </li>

                    </ul>
                </li> -->
                @endcanany

                @canany(['customer-list', 'customer-create', 'customer-edit', 'customer-delete', 'customer-view','user-list', 'user-create', 'user-edit', 'user-delete', 'user-view','role-list', 'role-create', 'role-edit', 'role-delete', 'role-view'])
                <li class="menu-title m-top-30">
                    <span>Settings</span>
                </li>
                @endcanany
                @canany(['customer-list', 'customer-create', 'customer-edit', 'customer-delete', 'customer-view','customer.bulk-create'])
                <li class="has-child {{ openActiveRoutes(['customer.index','customer.create','customer.show','customer.bulk-create']) }}">
                    <a href="#" class="{{ areActiveRoutes(['customer.index','customer.create','customer.show','customer.bulk-create']) }}">
                        <span data-feather="users" class="nav-icon"></span>
                        <span class="menu-text">Customers</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        @can('customer-create')
                        <li>
                            <a href="{{ route('customer.create') }}" class="{{ areActiveRoutes(['customer.create']) }}">Add Customer</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('customer.index') }}" class="{{ areActiveRoutes(['customer.index','customer.show','customer.bulk-create']) }}">All Customers</a>
                        </li>

                    </ul>
                </li>
                @endcanany

                @canany(['parts-list', 'parts-create', 'parts-edit', 'parts-delete'])
                <!-- <li class="has-child {{ openActiveRoutes(['parts.index','parts.create']) }}">
                    <a href="#" class="{{ areActiveRoutes(['parts.index','parts.create']) }}">
                        <span data-feather="grid" class="nav-icon"></span>
                        <span class="menu-text">Parts</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('parts.create') }}" class="">Create Parts</a>
                        </li>
                        <li>
                            <a href="{{ route('parts.index') }}" class="{{ areActiveRoutes(['parts.index']) }}">All Parts</a>
                        </li>

                    </ul>
                </li> -->
                @endcanany

                <!-- sliders -->
                @canany(['operation-list', 'operation-create', 'operation-edit', 'operation-delete'])
                <!-- <li class="has-child {{ openActiveRoutes(['operations.index','operations.create']) }}">
                    <a href="#" class="{{ areActiveRoutes(['operations.index','operations.create']) }}">
                        <span data-feather="sliders" class="nav-icon"></span>
                        <span class="menu-text">Operations</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('operations.create') }}" class="">Add Operation</a>
                        </li>
                        <li>
                            <a href="{{ route('operations.index') }}" class="{{ areActiveRoutes(['operations.index']) }}">All Operations</a>
                        </li>

                    </ul>
                </li> -->
                @endcanany

                @canany(['user-list', 'user-create', 'user-edit', 'user-delete', 'user-view'])
                <li class="has-child {{ openActiveRoutes(['users.index','users.create','users.edit']) }}">
                    <a href="#" class="{{ areActiveRoutes(['users.index','users.create','users.edit']) }}">
                        <span data-feather="user" class="nav-icon"></span>
                        <span class="menu-text">Users</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        @can('user-create')
                        <li>
                            <a href="{{ route('users.create') }}" class="{{ areActiveRoutes(['users.create']) }}">Add User</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('users.index') }}" class="{{ areActiveRoutes(['users.index','users.edit']) }}">All Users</a>
                        </li>

                    </ul>
                </li>
                @endcanany
                
                @canany(['role-list', 'role-create', 'role-edit', 'role-delete', 'role-view'])
                <li class="has-child {{ openActiveRoutes(['roles.index','roles.create','roles.show']) }}">
                    <a href="#" class="{{ areActiveRoutes(['roles.index','roles.create','roles.show']) }}">
                        <span data-feather="target" class="nav-icon"></span>
                        <span class="menu-text">Roles</span>
                        <span class="toggle-icon"></span>
                    </a>
                    <ul>
                        @can('role-create')
                        <li>
                            <a href="{{ route('roles.create') }}" class="{{ areActiveRoutes(['roles.create']) }}">Add New Role</a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('roles.index') }}" class="{{ areActiveRoutes(['roles.index','roles.show']) }}">Manage Roles</a>
                        </li>

                    </ul>
                </li>
                @endcanany
            </ul>
        </div>
    </div>
</aside>