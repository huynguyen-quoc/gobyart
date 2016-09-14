<aside class="yaybar yay-shrink  yay-gestures">

    <div class="top">
        <div>
            <!-- Sidebar toggle -->
            <a href="#" class="yay-toggle">
                <div class="burg1"></div>
                <div class="burg2"></div>
                <div class="burg3"></div>
            </a>
            <!-- Sidebar toggle -->

            <!-- Logo -->
            <a href="#!" class="brand-logo">
                <img src="/assets/admin/assets/_con/images/logo-white.png" alt="Con">
            </a>
            <!-- /Logo -->
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">

            <ul>
                <li class="yay-user-info">
                    <a href="page-profile.html">
                        <img src="/assets/admin/assets/_con/images/user.jpg" alt="John Doe" class="circle">
                        <h3 class="yay-user-info-name"> {{  (Auth::check() && isset(Auth::user()->name)) ? Auth::user()->name : ''  }}</h3>
                        <div class="yay-user-location">
                            {{ Auth::user()->email }}
                        </div>
                    </a>
                </li>

                <li>
                    <a href="{{ URL::route('dashboard') }}" class=" waves-effect waves-blue"> <i class="ion ion-social-angular"></i> Dashboard </a>
                </li>
                <li class="open">
                    <a class="yay-sub-toggle waves-effect waves-blue"> <i class="fa fa-css3"></i> Cấu Hình
                        <span class="yay-collapse-icon mdi-navigation-expand-more"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ URL::route('config.index') }}" class=" waves-effect waves-blue"> <i class="mdi-alert-warning"></i> Cấu Hình Chung </a>

                        </li>
                        <li>
                            <a href="{{ URL::route('config.company') }}" class=" waves-effect waves-blue"> <i class="mdi-image-palette"></i> Thông Tin Công Ty </a>

                        </li>
                        <li>
                            <a href="{{ URL::route('config.location') }}" class=" waves-effect waves-blue"> <i class="mdi-action-stars"></i> Vị trí </a>

                        </li>


                    </ul>
                </li>
                <li >
                    <a href="{{ URL::route('gallery') }}"  class=" waves-effect waves-blue"> <i class="fa fa-css3"></i> Sự kiện
                    </a>
                </li>
                <li >
                    <a href="{{ URL::route('team') }}"  class=" waves-effect waves-blue"> <i class="fa fa-css3"></i> Goby Team
                    </a>
                </li>
                <li >
                    <a href="{{ URL::route('artist') }}"  class=" waves-effect waves-blue"> <i class="fa fa-css3"></i> Nghệ sĩ
                    </a>
                </li>
            </ul>

        </div>
    </div>
</aside>