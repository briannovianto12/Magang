<div style="overflow: visible;">
    @isset($edit_url)
        <a href="{{ $edit_url }}"
           class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
           title="Edit"><i class="la la-edit"></i>
        </a>
    @endisset
    @isset($delete_url)
        <a href="#" onclick="_delete('{{ $delete_url }}')"
           class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
           title="Delete"> <i class="la la-trash"></i>
        </a>
    @endisset
</div>