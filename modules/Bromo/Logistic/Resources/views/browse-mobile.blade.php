@extends('logistic::layouts.master')
@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ mix('css/logistic.css') }}">
    <style>
    .content {
        background-color: white;
    }
    </style>
@endsection

@section('content')

        <div>
            <div class="row">
                <div class="mb-4 ml-4" >
                    @can('view_logistic_spreadsheet')
                    <a href="{{ route('logistic.logistic-spreadsheet')}}">
                        <button class="btn btn-primary" >Input Logistik Traditional</button>
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        @can('view_logistic_organizer')
            <nav class="d-none d-md-block">
            <ul class="nav nav-tabs  d-md-none m-tabs-line m-tabs-line--info" role="tablist">

                {{-- Status menunggu di pickup disini, seller sudah call pickup --}}
                <li class="nav-item m-tabs__item">
                    <a id="confirm_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#confirm"
                       role="tab">
                        <i class="la la-hourglass-2"></i> {{ __('logistic::messages.waiting_for_pick_up') }} </a>
                </li>

                {{-- Status menunggu di proses disini sudah diaccept oleh kurir organizer --}}
                <li id="process_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#process" role="tab">
                        <i class="la la-taxi"></i> {{ __('logistic::messages.in_process') }} </a>
                </li>

                {{-- Status sudah dijemput disini sudah dijemput oleh kurir --}}
                <li id="sent_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#sent" role="tab">
                        <i class="la la-taxi"></i> {{ __('logistic::messages.picked_up') }} </a>
                </li>

                <li id="transaction_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#transaction" role="tab">
                        <i class="la la-archive"></i> {{ __('logistic::messages.all_status') }} </a>
                </li>
            </ul>
            </nav>

            <div class="form-group">
            <select id="selectStatus" class="d-xs-block  form-control">

                <option value="#confirm" selected>{{ __('logistic::messages.waiting_for_pick_up') }}</option>
                <option value="#process">{{ __('logistic::messages.in_process') }}</option>
                <option value="#sent">{{ __('logistic::messages.picked_up') }}</option>
                <option value="#transaction">{{ __('logistic::messages.all_status') }}</option>
            </select>
            </div>
            <div class="tab-content">

                <!--begin:: Confirm Page-->
                <div class="tab-pane active" id="confirm" role="tabpanel">
                    <div class="" >
                        <table class="display wrap compact" id="order_confirm_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Confirm Page-->


                <!--begin:: Process Page-->
                <div class="tab-pane" id="process" role="tabpanel">
                    <div class="" >
                        <table class="display wrap compact" id="order_process_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Process Page-->

                <!--begin:: Sent Page-->
                <div class="tab-pane" id="sent" role="tabpanel">
                    <div class="" >
                        <table class="display wrap compact" id="order_sent_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Sent Page-->

                <!--begin:: Transaction Page-->
                <div class="tab-pane" id="transaction" role="tabpanel">
                    <div class="" >
                        <table class="display wrap compact" id="order_transaction_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Transaction Page-->

            </div>
        @endcan


@endsection

@section('scripts')
    @include('logistic::js-template')
    @include('logistic::js-order-mobile')
@endsection
