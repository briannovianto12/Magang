@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" href="{{ nbs_asset('css/logistic.css') }}">
    <link rel="stylesheet" href="{{ nbs_asset('css/fs-modal.min.css') }}">
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => __('logistic::messages.logistic_title', ['title' => $title])])

        @slot('postfix')
            {{ $title }}
        @endslot

        @slot('body')
            <nav class="d-none d-md-block">
            <ul class="nav nav-tabs  m-tabs-line m-tabs-line--info" role="tablist">
                
                <li class="nav-item m-tabs__item">
                    <a id="confirm_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#confirm"
                       role="tab">
                        <i class="la la-hourglass-2"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
                <li id="process_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#process" role="tab">
                        <i class="la la-file-text"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
                <li id="sent_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#sent" role="tab">
                        <i class="la la-taxi"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
                <li id="delivered_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#delivered" role="tab">
                        <i class="la la-inbox"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
                <li id="success_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#success" role="tab">
                        <i class="la la-smile-o"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
                <li id="cancel_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#cancel" role="tab">
                        <i class="la la-close"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
                <li id="transaction_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#transaction" role="tab">
                        <i class="la la-archive"></i> {{ __('logistic::messages.awaiting_confirmation') }} </a>
                </li>
            </ul>
            </nav>

            <div class="form-group">
            <select id="selectStatus" class="d-xs-block d-md-none form-control"> 
                
                <option value="#confirm" selected>{{ __('logistic::messages.awaiting_confirmation') }}</option> 
                <option value="#process">{{ __('logistic::messages.awaiting_delivery') }}</option> 
                <option value="#sent">{{ __('logistic::messages.on_delivery') }}</option> 
                <option value="#delivered">{{ __('logistic::messages.delivered') }}</option> 
                <option value="#success">{{ __('logistic::messages.success') }}</option> 
                <option value="#cancel">{{ __('logistic::messages.canceled') }}</option> 
                <option value="#transaction">{{ __('logistic::messages.transaction') }}</option> 
            </select> 
            </div>
            <div class="tab-content">

                <!--begin:: Confirm Page-->
                <div class="tab-pane active" id="confirm" role="tabpanel">
                    <div class="d-none d-md-block">
                        <table class="table table-striped table-bordered table-hover display nowrap compact stripe" id="order_confirm"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="d-md-none fixed-mobile-screen" >
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_confirm_mobile"
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
                    <div class="d-none d-md-block">
                        <table class="table table-striped table-bordered table-hover display nowrap" id="order_process"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="d-md-none">
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_process_mobile"
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
                    <div class="d-none d-md-block"> 
                        <table class="table table-striped table-bordered table-hover display nowrap" id="order_sent"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="d-md-none">
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_sent_mobile"
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

                <!--begin:: Success Page-->
                <div class="tab-pane" id="success" role="tabpanel">
                    <div class="d-none d-md-block">
                        <table class="table table-striped table-bordered table-hover display nowrap" id="order_success"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="d-md-none">
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_success_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Success Page-->

                <!--begin:: Delivered Page-->
                <div class="tab-pane" id="delivered" role="tabpanel">
                    <div class="d-none d-md-block">    
                        <table class="table table-striped table-bordered table-hover display nowrap" id="order_delivered"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="d-md-none">
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_delivered_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Delivered Page-->

                <!--begin:: Cancel Page-->
                <div class="tab-pane" id="cancel" role="tabpanel">
                    <div class="d-none d-md-block">
                        <table class="table table-striped table-bordered table-hover display nowrap" id="order_cancel"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>    
                    <div class="d-md-none">
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_cancel_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>{{ __('logistic::messages.all_info') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Cancel Page-->

                <!--begin:: Transaction Page-->
                <div class="tab-pane" id="transaction" role="tabpanel">
                    <div class="d-none d-md-block"> 
                        <table class="table table-striped table-bordered table-hover display nowrap" id="order_transaction"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ __('logistic::messages.order_no') }}</th>
                                <th>{{ __('logistic::messages.customer') }}</th>
                                <th>{{ __('logistic::messages.total_amount') }}</th>
                                <th>{{ __('logistic::messages.date') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>    
                    <div class="d-md-none">
                        <table class="table table-borderless table-responsive-sm display wrap compact" id="order_transaction_mobile"
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
        @endslot
    @endcomponent

@endsection

@section('scripts')
    @include('logistic::js-template')
    @include('logistic::js')
@endsection
