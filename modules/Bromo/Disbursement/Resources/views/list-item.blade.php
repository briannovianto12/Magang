@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
@endsection

@section('scripts')
    @include('disbursement::js-item')
    <script src="{{ asset('js/mustache.min.js') }}"></script>
    <script src="{{ mix('js/disbursement.js') }}"></script>
@endsection

@can('view_batch_disbursement')
@section('content')
    @section('content')
        @component('components._portlet',[
            'portlet_head' => true,
            'url_manage' => true,
            'url_back' => route('disbursement.header'),
            'postfix_back' => __('Back'),
            'body_class' => 'pt-0'])
            @slot('body')
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{ $title }} No. #{{ $header_no }} 
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">

                    @if($status == Bromo\Disbursement\Entities\DisbursementStatus::WAITING_TO_BE_PROCESSED)
                    <button class="btn btn-success" id="processDisbursement" onclick="_processDisbursement({{$header_id}})">
                        Process Disbursement
                    </button>
                    @endif
                    <div class="tab-content">

                        <div class="tab-pane active" id="item" role="tabpanel">
                            <table class="table table-striped table-bordered table-hover display nowrap" id="disb_item"
                                style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Amount</th>
                                    <th>Bank Code</th>
                                    <th>Bank Account Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Description</th>
                                    <th>Email</th>
                                    <th>Email Cc</th>
                                    <th>Email Bcc</th>
                                    <th>External Id</th>
                                    <th>Shop Name</th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        @endslot
    @endcomponent
@endsection
@endcan