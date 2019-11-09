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


        @can('view_logistic_organizer')
            <nav class="d-none d-md-block">
            <ul class="nav nav-tabs  m-tabs-line m-tabs-line--info" role="tablist">
                
                {{-- Status menunggu di pickup disini, seller sudah call pickup --}}
                <li class="nav-item m-tabs__item">
                    <a id="confirm_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#confirm"
                       role="tab">
                        <i class="la la-hourglass-2"></i> Menunggu Pickup</a>
                </li>
                
                {{-- Status menunggu di proses disini sudah diaccept oleh kurir organizer --}}
                <li id="process_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#process" role="tab">
                        <i class="la la-taxi"></i> Dalam Proses</a>
                </li>

                {{-- Status sudah dijemput disini sudah dijemput oleh kurir --}}
                <li id="sent_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#sent" role="tab">
                        <i class="la la-taxi"></i> Sudah Dijemput</a>
                </li>

                <li id="transaction_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#transaction" role="tab">
                        <i class="la la-archive"></i> Semua Status</a>
                </li>
            </ul>
            </nav>

            <div class="form-group">
            <select id="selectStatus" class="d-xs-block d-md-none form-control"> 
                
                <option value="#confirm" selected>Menunggu Di Pickup</option>  
                <option value="#process">Dalam Proses</option>  
                <option value="#sent">Sudah Dijemput</option> 
                <option value="#transaction">Semua Status</option> 
            </select> 
            </div>
            <div class="tab-content">

                <!--begin:: Confirm Page-->
                <div class="tab-pane active" id="confirm" role="tabpanel">
                    <div class="d-md-none fixed-mobile-screen" >
                        <table class="display wrap compact" id="order_confirm_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>All Info</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Confirm Page-->

                
                <!--begin:: Process Page-->
                <div class="tab-pane" id="process" role="tabpanel">
                    <div class="d-md-none" >
                        <table class="display wrap compact" id="order_process_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>All Info</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Process Page-->

                <!--begin:: Sent Page-->
                <div class="tab-pane" id="sent" role="tabpanel">
                    <div class="d-md-none" >
                        <table class="display wrap compact" id="order_sent_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>All Info</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!--end:: Sent Page-->

                <!--begin:: Transaction Page-->
                <div class="tab-pane" id="transaction" role="tabpanel">
                    <div class="d-md-none" >
                        <table class="display wrap compact" id="order_transaction_mobile"
                            style="width: 100%">
                            <thead class="d-none">
                            <tr>
                                <th>All Info</th>
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
