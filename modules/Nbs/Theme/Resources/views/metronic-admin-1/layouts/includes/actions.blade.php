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
    @endisset
    @isset($internal_notes)
        <a href="#" onclick="_internalNotes('{{$internal_notes}}' )" title="Internal Notes">Internal Notes</a>
    @endisset

    @isset($approve)
        <a href="#" onclick="_send('{{$approve}}' )" 
        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
        title="Approve">
        <i class="la la-check"></i>
        </a>
    @endisset
    @isset($void)
        <a href="#" onclick="_send('{{$void}}' )" 
        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
        title="Void">
        <i class="la la-ban"></i>
        </a> 
    @endisset
    @isset($send_link)
        <a href="#" onclick="_send('{{$send_link}}' )" 
        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
        title="Send Link">
        <i class="la la-send"></i>
        </a>
    @endisset
    @isset($waiting_approval)
        <a title="Waiting Approval">{{ $waiting_approval }}</a>
    @endisset
    
    @isset($change_ekspedisi)
        <a href="#" onclick="_editLogistic('{{$change_ekspedisi}}' )"
        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
        title="Change Master Ekspedisi"><i class="la la-edit"></i>
        </a>
    @endisset
    @isset($enable_disable_courier)
        @if($enable_disable_courier_status)
            <span class="badge badge-success">Enabled</span>
        @else
            <span class="badge badge-danger">Disabled</span>
        @endif
        <a href="#" onclick="_editStatusCourier('{{$enable_disable_courier}}' )"
        class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill d-md-inline-block"
        title="Enable/Disable Courier"><i class="la la-edit"></i>
        </a>
    @endisset

</div>