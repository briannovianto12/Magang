<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item m-aside-left m-aside-left--skin-light">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-light m-aside-menu--submenu-skin-dark"
         m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">
        <ul class="m-menu__nav m-menu__nav--dropdown-submenu-arrow">
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('dashboard') }}" aria-haspopup="true">
                <a href="{{ route('dashboard') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Dashboard</span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('seller') }}" aria-haspopup="true">
                <a href="{{ route('seller') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Seller</span>
                </a>
            </li>
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('buyer') }}" aria-haspopup="true">
                <a href="{{ route('buyer') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Buyer</span>
                </a>
            </li>
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('product-category') }}" aria-haspopup="true">
                <a href="{{ route('product-category') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Product Category</span>
                </a>
            </li>
            {{--<li class="m-menu__item m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Base</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link"><span class="m-menu__link-text">Base</span></span>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                            <a href="javascript:;" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                <span class="m-menu__link-text">Tabs</span><i
                                        class="m-menu__ver-arrow la la-angle-right"></i></a>
                            <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true">
                                        <a href="?page=components/base/tabs/bootstrap&demo=default" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                                            <span class="m-menu__link-text">Bootstrap Tabs</span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true">
                                        <a href="?page=components/base/tabs/line&demo=default" class="m-menu__link ">
                                            <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                                <span></span></i>
                                            <span class="m-menu__link-text">Line Tabs</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="m-menu__item " aria-haspopup="true"><a
                                    href="?page=components/base/accordions&demo=default" class="m-menu__link "><i
                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                        class="m-menu__link-text">Accordions</span></a></li>
                        <li class="m-menu__item " aria-haspopup="true">
                            <a href="?page=components/base/sweetalert2&demo=default" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">SweetAlert2</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>--}}
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
<!-- END: Left Aside -->