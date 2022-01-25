<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav navbar-no-expand ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <img src="{{ asset('/images/profile.png') }}" class="img-circle elevation-2" alt="User Image" width="40px">
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <div class="dropdown-divider"></div>
            <a href="{{ route('profile.setting') }}" class="dropdown-item">
              <i class="fas fa-cog mr-2"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item">
              <i class="fa fa-sign-out-alt mr-2"></i> Logout
            </a>
          </div>
        </li>
    </ul>

    <!-- <div class="collapse navbar-collapse" id="navbarCollapse">
        
      <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="{{ route('users') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->is('users*') ? 'active' : '' }}">Users</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="{{ route('users') }}" class="dropdown-item {{ request()->is('users') ? 'active' : '' }}">User List</a></li>
            <li><a href="{{ route('users.create') }}" class="dropdown-item {{ request()->is('users/create*') ? 'active' : '' }}">Add New User
                </a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="{{ route('roles') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->is('roles*') ? 'active' : '' }}">Roles</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="{{ route('roles') }}" class="dropdown-item {{ request()->is('roles') ? 'active' : '' }}">Role List</a></li>
            <li><a href="{{ route('roles.create') }}" class="dropdown-item {{ request()->is('roles/create*') ? 'active' : '' }}">Add New Role
                </a></li>
          </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('orderList') }}" class="nav-link {{ request()->is('orderList') ? 'active' : '' }}">Orders</a>
        </li>
      </ul>
    </div> -->
</nav>