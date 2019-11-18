@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    @include("{$module}::js")
    @include("{$module}::js-template")
    <script src="{{ nbs_asset('js/refund-order.js') }}"></script>
    <script src="{{ nbs_asset('js/mustache.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

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
                        <a id="refund_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#refund"
                        role="tab">
                            <i class="la la-shopping-cart"></i> {{ __('Order Refund') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!--begin:: New Order Page-->
                    <div class="tab-pane active" id="refund" role="tabpanel">
                        <div class="table-responsive">
                            <table id="order_refund"
                                class="table table-striped table-bordered table-hover display"
                                style="width: 100%">
                                <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>Seller Name</th>
                                    <th>Buyer Name</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                    <th>Refund Date</th>
                                    <th>Updated At</th>
                                    <th>Order Refunded</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <!--end:: New Order Page-->
                </div>
            </div>
        @endcan
    </div>

@endsection