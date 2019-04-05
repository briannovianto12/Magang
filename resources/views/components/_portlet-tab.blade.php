<!--begin::Portlet-->
<div class="m-portlet m-portlet--tabs">
    @isset($tab_head)
    <div class="m-portlet__head">
        <div class="m-portlet__head-tools">
            <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--right m-tabs-line--primary" role="tablist">
                {!! $tab_head ?? '' !!}
            </ul>
        </div>
    </div>
    @endisset
    <div class="m-portlet__body @isset($body_class){{$body_class}}@endisset">
        <div class="tab-content">
            {!! $tab_body !!}
        </div>
    </div>
</div>
<!--end::Portlet-->