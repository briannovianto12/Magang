<meta charset="utf-8"/>
<title>
    {{ config('app.name') }}
</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!--begin::Web font -->
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
<script>
    WebFont.load({
        google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
        active: function () {
            sessionStorage.fonts = true;
        }
    });
</script>
<!--end::Web font -->
<!--begin::Global Theme Styles -->
<link href="{{ nbs_asset('vendors/base/vendors.bundle.css', env('APP_SECURE', false)) }}" rel="stylesheet">
<link href="{{ nbs_asset('demo/default/base/style.bundle.css', env('APP_SECURE', false)) }}" rel="stylesheet">
<!--end::Global Theme Styles -->
@yield('css')
<!-- end::Page Snippets -->

<style>
    .form-control-feedback {
        color: deeppink !important;
    }
</style>

<!--end::Page Vendors Styles -->
<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}"/>