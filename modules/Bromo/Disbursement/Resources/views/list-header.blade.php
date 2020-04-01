@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
    <link rel="stylesheet" href="{{ nbs_asset('vendor/fancybox/jquery.fancybox.css') }}">
@endsection

@section('scripts')
    @include('disbursement::js-header')
    <script src="{{ nbs_asset('js/mustache.min.js') }}"></script>
    <script src="{{ mix('js/disbursement.js') }}"></script>
@endsection

@can('view_batch_disbursement')
@section('content')
    @component('components._portlet',[
        'portlet_head' => true,
        'url_manage' => true,
        'url_back' => 'balance',
        'postfix_back' => __('Back'),
        'body_class' => 'pt-0'])
        @slot('body')
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            List Disbursement
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                {{-- <ul class="nav nav-tabs  m-tabs-line m-tabs-line--info" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a id="header_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#header"
                        role="tab">
                            <i class="la la-archive"></i> List Disbursement Process </a>
                    </li>
                </ul> --}}
                <button class="btn btn-success" id="processDisbursement" onclick="_createBatchDisbursement()">
                    Create Disbursement
                </button>
                
                <div class="tab-content">

                    <div class="tab-pane active" id="header" role="tabpanel">
                        <table class="table table-striped table-bordered table-hover display nowrap" id="disb_header"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>Disbursement No.</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Total Item</th>
                                <th>Remark</th>
                                <th>Created By</th>
                            </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
            
        @endslot
    @endcomponent
@endsection
@endcan