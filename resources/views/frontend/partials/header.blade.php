<header id="header" class="fixed">
    <div class="header clear-fix">
        <div class="header-bg"></div>
        <div class="logo gobyArtIcon">
            <a href="/" class="un-decoration">
                <span class="gobyIcon goby-GB"></span>
            </a>
        </div>
        <div class="m_hidden l_hidden show-if-mobile-menu">
                    <span class="gobyArtIcon">
                        <a href="#" class="navigation-toggle">=</a>
                    </span>
        </div>
        <div class="m_hidden l_hidden show-if-mobile-menu navigation-mobile">
            <a href="/quan-tam" class="m_hidden l_hidden show-if-mobile-menu shopping-cart wishlist-link">
                <i class="material-icons">&#xE87E;</i>
            </a>
            <span class="wishlist-counter">{{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() > 0 ? \Gloudemans\Shoppingcart\Facades\Cart::content()->count() : '' }}</span>
        </div>

        <div class="navi_mobile clearfix">
            <div class="m_hidden l_hidden show-if-mobile-menu">
                <div class="logo gobyArtIcon">
                    <a href="/" class="un-decoration">
                        <span class="gobyIcon goby-GB"></span>
                    </a>
                </div>
                <div class="clear-fix navigation-mobile">
                    <a href="/quan-tam" class="clear-fix shopping-cart wishlist-link">
                        <i class="material-icons">&#xE87E;</i>
                    </a>
                    <span class="wishlist-counter">{{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() > 0 ? \Gloudemans\Shoppingcart\Facades\Cart::content()->count() : '' }}</span>
                </div>
                <div class="clear-fix">
				  		<span class="gobyArtIcon">
			  				<a href="#" class="navi-toggle">=</a>
			  			</span>
                </div>


                <li><a href="/danh-sach-nghe-si/tat-ca/tat-ca">Nghệ Sĩ</a></li>
                <li><a href="/gioi-thieu">Giới Thiệu</a></li>
                <li><a href="/lien-he">Liên Hệ</a></li>
            </div>
        </div>

        <div class="navigation s_hidden hide-if-mobile-menu">
            <ul>
                <!-- 					<li class="selected">Models</li> -->
                <li><a href="/danh-sach-nghe-si/tat-ca/tat-ca">Nghệ Sĩ</a></li>
                {{--<li><a href="/tin-tuc">Tin Tức</a></li>--}}
                <li><a href="/gioi-thieu">Giới Thiệu</a></li>
                <li><a href="/lien-he">Liên Hệ</a></li>
                <li>
                    <a href="/quan-tam" class="shopping-cart wishlist-link">
                        <i class="material-icons">&#xE87E;</i>
                    </a>
                    <span class="wishlist-counter">{{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() > 0 ? \Gloudemans\Shoppingcart\Facades\Cart::content()->count() : '' }}</span>
                </li>
            </ul>
        </div>
    </div>

</header>
<div id="dummyheader"> <!-- spacer to  -->
    <div class="header clear-fix" style="width:100%;">
        <div class="header-bg"></div>
        <div class="logo gobyArtIcon">
            <a href="/" class="un-decoration">
                <span class="logo-img"></span>
                <span class="logo-dot">x</span>
            </a>
        </div>
    </div>
</div>