<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">@auth
                    {{Auth::user()->name . ' ' . Auth::user()->last_name}}
                @endauth</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            Responsables
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rifas.index') }}" class="nav-link">
                        <i class="nav-icon far fa-id-card"></i>
                        
                        <p>
                            Rifas
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('assignaciones.index') }}" class="nav-link">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                            Asignación
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
