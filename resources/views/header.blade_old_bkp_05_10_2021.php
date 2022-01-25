<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container header_responsive">
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="background-image: url({{ asset('/storage/images/navicon.png') }});"></span>
    </button>

    <a href="{{ route('home') }}" class="navbar-brand">
      <!-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> -->
      <span class="brand-text font-weight-light">AMZOne</span>
    </a>

    <ul class="order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <img src="{{ asset('/storage/images/profile.png') }}" class="img-circle elevation-2" alt="User Image" width="40px">
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

    <div class="collapse navbar-collapse" id="navbarCollapse">
        
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
            <a href="{{ route('batch') }}" class="nav-link {{ request()->is('batch') ? 'active' : '' }}">Batch</a>
        </li>
        <!-- <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="{{ route('batch') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->is('batch*') ? 'active' : '' }}">Batches</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="{{ route('list') }}" class="dropdown-item {{ request()->is('roles') ? 'active' : '' }}">List</a></li>
          </ul>
        </li> -->
        <!-- <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="{{ route('walmartScrap') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->is('walmartScrap*') ? 'active': request()->is('walmartproductlist') ? 'active':'' }}">Walmart Scraping</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="{{ route('walmartScrap') }}" class="dropdown-item {{ request()->is('walmartScrap') ? 'active' : '' }}">Scrap New Category</a></li>
            <li><a href="{{ route('walmartproductlist') }}" class="dropdown-item {{ request()->is('walmartproductlist') ? 'active' : '' }}">Walmart Product List
                </a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a id="dropdownSubMenu1" href="{{ route('amazonExportedList') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle {{ request()->is('amazonExportedList*') ? 'active':request()->is('productImportedList*') ? 'active':request()->is('file_import_export*') ? 'active':'' }}">Amazon MWS</a>
          <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
            <li><a href="{{ route('productImportedList') }}" class="dropdown-item {{ request()->is('productImportedList') ? 'active' : '' }}">Exported List</a></li>
            <li><a href="{{ route('file_import_export') }}" class="dropdown-item {{ request()->is('file_import_export') ? 'active' : '' }}">Import Export CSV
                </a></li>
            <li><a href="{{ route('amazon.productList') }}" class="dropdown-item {{ request()->is('*productList') ? 'active' : '' }}">Amazon Listed Product
                </a></li>
          </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('orderList') }}" class="nav-link {{ request()->is('orderList') ? 'active' : '' }}">Orders</a>
        </li> -->
        <!-- <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">Logout</a>
        </li> -->
      </ul>
    </div>
  </div>
</nav>