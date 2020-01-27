@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <style>
        #topic option { color: black; }
        .empty { color: gray; }
    </style>
@endsection

@section('scripts')
    @include('payout::js')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Payout"])
        @slot('body')
        @can('view_payout')
            <div class="m-portlet__body">
                @if(!isset($exclude_flash))
                    @include('components._flash')
                @endif
                <div class="tab-content">

                    <div role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>Action</th>      
                                        <th>Payout #</th>
                                        <th>Payout for User</th>
                                        <th>Amount</th>
                                        <th>Reason</th>
                                        <th>Additional Notes</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                        <th>Expired At</th>                                               
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endcan
        @endslot

        @can('view_payout_form')
            @slot('url')
                {{ route("payout.form") }}
            @endslot
        @endcan

        @slot('postfix')
            News Notification
        @endslot
    @endcomponent

@endsection