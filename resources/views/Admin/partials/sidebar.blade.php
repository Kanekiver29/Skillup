<aside class="hidden md:flex md:flex-col w-72 bg-gradient-to-b from-blue-900 via-blue-800 to-blue-900 min-h-screen fixed left-0 top-[var(--admin-header-h)] bottom-0 border-r border-blue-700 shadow-lg overflow-y-auto z-[90]">
    <div class="flex-1 py-6 overflow-y-auto">
        <!-- Quick Stats Card -->
        <div class="px-4 mb-8">
            <div class="p-4 bg-blue-800/50 border border-blue-700 rounded-lg glass-card">
                <p class="text-blue-200 text-xs uppercase tracking-wider mb-2">System Status</p>
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-white text-sm font-medium">Online &amp; Active</span>
                </div>
            </div>
        </div>

        <!-- Main Menu -->
        <div class="px-6 mb-4">
            <p class="text-blue-300 text-xs uppercase tracking-widest font-bold mb-4">Main Menu</p>
        </div>

        <nav class="px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-th-large w-5 mr-3"></i>
                <span>Dashboard</span>
            </a>

                <a href="{{ route('admin.users.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.users*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-users w-5 mr-3"></i>
                    <span>User Management</span>
                </a>

                <a href="{{ route('admin.admins') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.admins*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-user-shield w-5 mr-3"></i>
                    <span>Admin Accounts</span>
                </a>

                <a href="{{ route('admin.staff.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.staff*') && !request()->routeIs('admin.staff.dashboard') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-user-tie w-5 mr-3"></i>
                    <span>Staff Management</span>
                </a>

                <a href="{{ route('admin.reports') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.reports') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-chart-line w-5 mr-3"></i>
                    <span>Staff Reports</span>
                </a>


            <!-- Divider -->
            <div class="my-4 border-t border-blue-700"></div>

            <a href="{{ route('admin.courses.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.courses*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-book-open w-5 mr-3"></i>
                <span>Courses</span>
            </a>

            <a href="{{ route('admin.modules.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.modules*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-cubes w-5 mr-3"></i>
                <span>Modules</span>
            </a>

            <a href="{{ route('admin.enrollments.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.enrollments*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-graduation-cap w-5 mr-3"></i>
                <span>Enrollments</span>
            </a>

            <a href="{{ route('admin.chats.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.chats*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                <i class="fas fa-comment-dots w-5 mr-3"></i>
                <span>Messages</span>
            </a>

            @if(auth()->user()->is_admin)
                <div class="my-4 border-t border-blue-700"></div>

                <a href="{{ route('admin.reports') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.reports') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    <span>Platform Reports</span>
                </a>

                <a href="{{ route('admin.excel.index') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.excel*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-file-excel w-5 mr-3"></i>
                    <span>Excel Reports</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.settings*') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    <span>Settings</span>
                </a>

                <a href="{{ route('admin.archive') }}" class="admin-sidebar-link flex items-center px-4 py-3 text-sm font-medium text-blue-100 hover:text-white hover:bg-blue-700 rounded-lg transition {{ request()->routeIs('admin.archive') ? 'bg-blue-700 text-white border-l-4 border-cyan-400' : '' }}">
                    <i class="fas fa-box-archive w-5 mr-3"></i>
                    <span>Archive</span>
                </a>

            @endif
        </nav>
    </div>

    <!-- Sidebar Footer -->
    <div class="px-4 py-6 border-t border-blue-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-3 text-sm font-medium text-red-300 hover:text-red-100 hover:bg-red-900/30 rounded-lg transition">
                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>
