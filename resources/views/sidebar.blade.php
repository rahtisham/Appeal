<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('users') }}" class="brand-link">
       <img src="/images/apealLogo.png" width="170px" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8; margin-top: 8px !important;">
      <span class="brand-text font-weight-light"><img src="/images/appealLogo.png" width="180px"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

{{-- Start sidebare --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if(Auth::user()->isAdmin())
                    <li class="nav-item">
                        <a href="{{ route('users') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subscribers') }}" class="nav-link {{ request()->is('subscribers') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Subscribers
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subscription_plan.index') }}" class="nav-link {{ request()->is('subscription_plan') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                Subscription Plan
                            </p>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('amazon/productList') ? 'active' : '' }}">
                            <i class="nav-icon fab fa-amazon"></i>
                            <p>
                                Amazon Items
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('amazon/orderList') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Amazon Orders
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.walmart_email_alert') }}" class="nav-link {{ request()->is('walmart') ? 'active' : '' }}">
                            <i class="nav-icon fab fa-weebly"></i>
                            <p>
                                Walmart Email Alert
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('walmartOrders') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Walmart Orders
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ request()->is('subscription') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-columns"></i>
                            <p>
                                Subscription
                            </p>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('profile.setting') }}" class="nav-link {{ request()->is('profile/setting') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Settings

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('authorization') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Authorize
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.testing') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Testing API Walmart
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
{{-- End sidebare --}}

    </div>
    <!-- /.sidebar -->
  </aside>
