@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    @include("{$module}::js")
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        List of {{ $title }}
                    </h3>
                </div>
            </div>
        </div>
        @can('view_order')
            <div class="m-portlet__body">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--info" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a id="new_order_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#new_order"
                        role="tab">
                            <i class="la la-shopping-cart"></i> {{ __('Pesanan Dibuat') }}
                        </a>
                    </li>
                    <li id="process_order_tab" class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#process_order" role="tab">
                            <i class="la la-hourglass-2"></i> {{ __('Pesanan Diproses') }}</a>
                    </li>
                    <li id="delivery_order_tab" class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#delivery_order" role="tab">
                            <i class="la la-truck"></i> {{ __('Pesanan Dikirim') }}</a>
                    </li>
                    <li id="delivered_order_tab" class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#delivered_order" role="tab">
                            <i class="la la-home"></i> {{ __('Sampai Tujuan') }}</a>
                    </li>
                    <li id="success_order_tab" class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#success_order" role="tab">
                            <i class="la la-check"></i> {{ __('Pesanan Sukses') }}</a>
                    </li>
                    <li id="cancel_order_tab" class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#cancel_order" role="tab">
                            <i class="la la-times"></i> {{ __('Pesanan Dibatalkan') }}</a>
                    </li>
                    <li id="list_order_tab" class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#list_order" role="tab">
                            <i class="la la-history"></i> {{ __('Transaksi') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!--begin:: New Order Page-->
                    <div class="tab-pane active" id="new_order" role="tabpanel">
                        <div class="table-responsive">
                            <table id="table_new_order"
                                class="table table-striped table-bordered table-hover display nowrap"
                                style="width: 100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code</th>
                                    <th>Buyer</th>
                                    <th>Seller</th>
                                    <th>Payment Method</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--end:: New Order Page-->

                    <!--begin:: Process Order Page-->
                    <div class="tab-pane" id="process_order" role="tabpanel">
                        <table id="table_process_order"
                            class="table table-striped table-bordered table-hover display nowrap"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end:: Process Order Page-->

                    <!--begin:: Delivery Order Page-->
                    <div class="tab-pane" id="delivery_order" role="tabpanel">
                        <table id="table_delivery_order"
                            class="table table-striped table-bordered table-hover display nowrap"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end:: Delivery Order Page-->

                    <!--begin:: Delivered Order Page-->
                    <div class="tab-pane" id="delivered_order" role="tabpanel">
                        <table id="table_delivered_order"
                            class="table table-striped table-bordered table-hover display nowrap"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end:: Delivered Order Page-->

                    <!--begin:: Success Order Page-->
                    <div class="tab-pane" id="success_order" role="tabpanel">
                        <table id="table_success_order"
                            class="table table-striped table-bordered table-hover display nowrap"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end:: Success Order Page-->

                    <!--begin:: Cancel Order Page-->
                    <div class="tab-pane" id="cancel_order" role="tabpanel">
                        <table id="table_cancel_order"
                            class="table table-striped table-bordered table-hover display nowrap"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end:: Cancel Order Page-->

                    <!--begin:: List Order Page-->
                    <div class="tab-pane" id="list_order" role="tabpanel">
                        <table id="table_list_order"
                            class="table table-striped table-bordered table-hover display nowrap"
                            style="width: 100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Code</th>
                                <th>Buyer</th>
                                <th>Seller</th>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <!--end:: List Order Page-->
                </div>
            </div>
        @endcan
    </div>

@endsection