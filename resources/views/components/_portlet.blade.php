<!-- TODO FIND BEST PLACE TO STYLE REQUIRED LABEL -->
<style>
    .form-group.required .col-form-label:after {
        content: "*";
        color: red;
    }
</style>

<div class="m-portlet m-portlet--mobile">
    @include('components._flash')
    @isset($tabs)
        {!! $tabs !!}
    @endisset
    @isset($portlet_head)
        <div class="m-portlet__head">
            @isset($portlet_title)
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ $portlet_title }} {!! isset($sub) ? "<small>$sub</small>" :'' !!}
                        </h3>
                    </div>
                </div>
            @endisset

            @isset($tabs_title)
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ $tabs_title }} {!! isset($sub) ? "<small>$sub</small>" :'' !!}
                        </h3>
                    </div>
                </div>
            @endisset

            @isset($url)
                <div class="m-portlet__head-tools">
                    <a href="#" onclick="window.location.href=' {{ $url }}'"
                       class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                            <i class="la la-plus"></i>
                            <!-- <span>@isset($postfix) {{$postfix}} @endisset</span> -->
                            <span>Tambah</span>
                        </span>
                    </a>
                </div>
            @endisset

            @isset($url_manage)
                <div class="m-portlet__head-tools">
                    @isset($postfix_delete)
                        <form method="POST" action="{{ $url_manage_delete }}">
                            <button type="submit"
                                    class="btn btn-danger m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                            <span>
                                <i class="la la-trash"></i>
                                <span>@isset($postfix_delete) {{$postfix_delete}} @endisset</span>
                            </span>
                            </button>
                        </form>
                    @endisset
                    @isset($postfix_edit)
                        <a href="#" onclick="window.location.href=' {{ $url_manage_edit }}'"
                           class="btn btn-info m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                            <i class="la la-edit"></i>
                            <span>@isset($postfix_edit) {{$postfix_edit}} @endisset</span>
                        </span>
                        </a>
                    @endisset
                    <a href="#" onclick="window.location.href=' {{ $url_manage }}'"
                       class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                        <span>
                            <i class="la la-plus"></i>
                            <span>@isset($postfix) {{$postfix}} @endisset</span>
                        </span>
                    </a>
                    @isset($url_back)
                        <a href="#" onclick="window.location.href=' {{ $url_back }}'"
                           class="btn btn-default m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                            <span>
                                <span>@isset($postfix_back) {{$postfix_back}} @endisset</span>
                            </span>
                        </a>
                    @endisset
                </div>
            @endisset
        </div>
    @endisset
    <div class="m-portlet__body">
        {!! $body !!}
    </div>
</div>