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
                <a href="/" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">Dashboard</span>
                        </span>
                    </span>
                </a>
            </li>
            @can('view_store')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('store') }}" aria-haspopup="true">
                    <a href="{{ route('store') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-truck"></i>
                        <span class="m-menu__link-text">Store</span>
                    </a>
                </li>
            @endcan
            @can('view_buyer')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('buyer') }}" aria-haspopup="true">
                    <a href="{{ route('buyer') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-avatar"></i>
                        <span class="m-menu__link-text">Buyer</span>
                    </a>
                </li>
            @endcan
            @can('view_product_category')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('product-category') }}" aria-haspopup="true">
                    <a href="{{ route('product-category') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-squares"></i>
                        <span class="m-menu__link-text">Product Category</span>
                    </a>
                </li>
            @endcan
            @can('view_brand')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('product-brand') }}" aria-haspopup="true">
                    <a href="{{ route('product-brand') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-grid-menu-v2"></i>
                        <span class="m-menu__link-text">Brand</span>
                    </a>
                </li>
            @endcan
            @can('view_product')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('product') }}" aria-haspopup="true">
                    <a href="{{ route('product.index') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-business"></i>
                        <span class="m-menu__link-text">Product</span>
                    </a>
                </li>
            @endcan
            @can('view_attribute_key')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('attribute-key') }}" aria-haspopup="true">
                    <a href="{{ route('attribute-key') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-app"></i>
                        <span class="m-menu__link-text">Attribute Key</span>
                    </a>
                </li>
            @endcan
            @can('view_unit_type')
                <li class="m-menu__item{{ nbs_helper()->isMenuActive('unit-type') }}" aria-haspopup="true">
                    <a href="{{ route('unit-type') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-network"></i>
                        <span class="m-menu__link-text">Unit Type</span>
                    </a>
                </li>
            @endcan
            @can('view_order')
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('order.index') }}" aria-haspopup="true">
                <a href="{{ route('order.index') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-open-box"></i>
                    <span class="m-menu__link-text">Order</span>
                </a>
            </li>
            @endcan
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('messages.index') }}" aria-haspopup="true">
                <a href="{{ route('messages.index') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-open-box"></i>
                    <span class="m-menu__link-text">Messages</span>
                </a>
            </li>
            @can('view_unverified_seller')
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('unverified.index') }}" aria-haspopup="true">
                <a href="{{ route('unverified.index') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-avatar"></i>
                    <span class="m-menu__link-text">Unverified Seller</span>
                </a>
            </li>
            @endcan
            <li class="m-menu__item{{ nbs_helper()->isMenuActive('seller.balance') }}" aria-haspopup="true">
                    <a href="{{ route('seller.balance') }}" class="m-menu__link">
                        <i class="m-menu__link-icon flaticon-layers"></i>
                        <span class="m-menu__link-text">Seller With Balance</span>
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