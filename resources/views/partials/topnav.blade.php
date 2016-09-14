<nav class="navbar-top navbar-under">
    <div class="nav-wrapper">

        <!-- Sidebar toggle -->
        <a href="#" class="yay-toggle">
            <div class="burg1"></div>
            <div class="burg2"></div>
            <div class="burg3"></div>
        </a>
        <!-- Sidebar toggle -->

        <!-- Logo -->
        <a href="{{ URL::route('dashboard') }}" class="brand-logo">
            <img src="/assets/admin/assets/_con/images/logo.png" alt="Con">
        </a>
        <!-- /Logo -->

        <!-- Menu -->
        <ul>
            <li class="user">
                <a class="dropdown-button" data-activates="user-dropdown" href="#!">
                    <img src="/assets/admin/assets/_con/images/user.jpg" alt="John Doe" class="circle">
                    {{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}
                    <i class="mdi-navigation-expand-more right"></i>
                </a>

                <ul id="user-dropdown" class="dropdown-content">
                    <li>
                        <a href="page-profile.html">
                            <i class="fa fa-user"></i> Thông Tin Cá Nhân
                        </a>
                    </li>

                    <li class="divider"></li>
                    <li>
                        <a href="{{ URL::route('auth.logout') }}">
                            <i class="fa fa-sign-out"></i> Đăng Xuất
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- /Menu -->

    </div>
</nav>