@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    @include('product::js')
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
        <div class="m-portlet__body">
            <table class="table table-striped table-bordered table-hover display nowrap" id="report_published" style="width: 100%">
                <thead>
                <tr>
                    <th>Report Name</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                    @can('view_shop_with_few_product')
                        <tr>
                            <td><a href="{{ route('report.shop_with_few_product') }}">Shop With Few Product</a></td>
                            <td>List of shop that has less than ten published product.</td>
                        </tr>
                    @endcan
                    @can('view_shop_with_product')
                        <tr>
                            <td><a href="{{ route('report.shop_has_product') }}">Shop With Product</a></td>
                            <td>List of shop that has at least one product.</td>
                        </tr>
                    @endcan
                    @can('view_seller_with_balance')
                        <tr>
                            <td><a href="{{ route('seller.balance') }}">Seller With Balance</a></td>
                            <td>List of seller with account balance.</td>
                        </tr>
                    @endcan
                    @can('view_product_over_half_kilo')
                        <tr>
                            <td><a href="{{ route('report.product_over_half_kilo') }}">Product Over Half Kilo</a></td>
                            <td>List of product that weight more than 500gr.</td>
                        </tr>
                    @endcan
                </tbody>
            </table>
        </div>
    </div>

@endsection