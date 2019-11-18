<div style="overflow: visible;">
    @isset($brand_url)
        {!! $brand_url !!}
    @endisset
    @isset($attribute_url)
        {!! $attribute_url !!}
    @endisset
    @isset($show_url)
        <a href="{{ $show_url }}"
           class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
           title="Detail"><i class="la la-eye"></i>
        </a>
    @endisset
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
    @isset($edit_datatable)
        <a href="#" onclick="_edit('{{ $edit_datatable }}')"
           class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
           title="Edit"><i class="la la-edit"></i>
        </a>
    @endisset
    @isset($edit_weight)
        <a href="#" onclick="_editWeight('{{$edit_weight}}' )" title="Edit">{{ $weight }}</a>
    @endisset
    @isset($change_refund_status)
        <a href="#" onclick="_refundOrder('{{$change_refund_status}}' )"
        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
        title="Change Status Refund"><i class="la la-edit"></i>
        </a>
    @isset($internal_notes)
        <a href="#" onclick="_internalNotes('{{$internal_notes}}' )" title="Internal Notes">Internal Notes</a>
    @endisset
</div>