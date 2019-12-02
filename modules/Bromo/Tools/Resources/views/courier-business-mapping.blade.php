@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ mix('js/courier-business-mapping.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Manage Courier Business Mapping
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="btn-group">
                <strong class="mt-2 mr-2">
                    Filter by Courier:
                </strong>
                <div>
                    <select id="courier-filter" class="custom-select custom-select-sm form-control form-control-sm">
                        <option value="All" selected="true">All</option>
                    </select> 
                </div>
            </div>
            <a href="{{ route('courier-business-mapping.create') }}" class="btn btn-link">Go to Popular Shops</a>
            <div class="table-responsive">
                <table id="table-courier-business-mapping" class="table table-striped table-bordered display" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Buyer Phone Number</th>
                        <th>Courier</th>
                        <th>Remark</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
