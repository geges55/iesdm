<!-- resources/views/layouts/partials/sidebar.blade.php -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">Izin Usaha</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @auth
                    @if(Auth::user()->role == 'pemohon')
                        <li class="nav-item">
                            <a href="{{ route('permit-works.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>Pengajuan Izin</p>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->role == 'verifikator')
                        <li class="nav-item">
                            <a href="{{ route('permit-works.verify') }}" class="nav-link">
                                <i class="nav-icon fas fa-check-circle"></i>
                                <p>Verifikasi Izin</p>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->role == 'supervisor')
                        <li class="nav-item">
                            <a href="{{ route('permit-works.report') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>Laporan Izin</p>
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
