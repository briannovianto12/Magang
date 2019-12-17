@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    @include('product::js')
@endsection

@section('content')
    @can('view_exports')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        List of Exports
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="table table-striped table-bordered table-hover display nowrap" style="width: 100%">
                <thead>
                <tr>
                    <th>Export Report for</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><a href="{{ route('export.order_list') }}">Export Order List</a></td>
                        <td>Export order list by specific date and order status.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endcan

@endsection
