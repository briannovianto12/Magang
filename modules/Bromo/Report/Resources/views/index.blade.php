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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Shop With Few Product</td>
                        <td>List of shop that has less than ten published product.</td>
                        <td><a href="{{ route('report.shop_with_few_product') }}">Open</a></td>
                    </tr>
                    <tr>
                        <td>Shop With Product</td>
                        <td>List of shop that has at least one product.</td>
                        <td><a href="{{ route('report.shop_has_product') }}">Open</a></td>
                    </tr>
                    <tr>
                        <td>Seller With Balance</td>
                        <td>List of seller with account balance.</td>
                        <td><a href="{{ route('seller.balance') }}">Open</a></td>
                    </tr>
                    <tr>
                        <td>Product Over Half Kilo</td>
                        <td>List of product that weight more than 500gr.</td>
                        <td><a href="{{ route('report.product_over_half_kilo') }}">Open</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection