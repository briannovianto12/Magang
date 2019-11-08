<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<!-- begin::Head -->
@include('theme::layouts.includes.head')
<!-- end::Head -->

<!-- begin::Body -->
<body id="bromo"
      class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <!-- BEGIN: Header -->
@include('logistic::layouts.header')
<!-- END: Header -->
    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
        <!-- BEGIN: Left Aside -->`
    @include('theme::layouts.includes.leftaside')
    <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
            <!-- BEGIN: Subheader -->
        <!-- END: Subheader -->
            <div class="m-content">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- begin::Footer -->
@include('theme::layouts.includes.footer')
<!-- end::Footer -->
</div>

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
</body>
@include('theme::layouts.includes.js')
</html>