@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ mix('css/courier-business-mapping-form.css') }}">
@endsection

@section('scripts')
    <script src="{{ mix('js/courier-business-mapping-form.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('content')
    @can('view_postal_code_finder')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        New Courier Business Mapping
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <form id="cbm-form" class="form-inline" method="POST">
                    {{ csrf_field() }}
                    <div class="col-3">
                        <input type="text" id="selected-seller" name="selected-seller" placeholder="Select Seller" disabled/>
                    </div>
                    <div class="col-3">
                        <input type="text" id="selected-buyer" name="selected-buyer" placeholder="Select Buyer" disabled/>
                    </div>
                    <div class="col-3">
                        <select class="form-control" id="courier-selection" name="courier-selection">
                            <option value="" selected>Select Courier</option>
                        </select> 
                    </div>
                    <div class="col-3 pl-4">
                        <button id="btn-submit-form" type="button" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
            <div id="search-area" class="row mt-5">
                <div id="seller-list" class="col-7">
                    <form id="seller-search-form" class="form-inline" method="GET">
                        <input id="seller-searchbar" name="search-seller-name" class="form-control" type="text" placeholder="Search Shop">
                        <button id="btn-search-seller" type="button" class="btn btn-dark">Search</button>
                    </form>
                    <div class="mt-3" id="list-seller">
                        <table id="table-seller" class="table table-responsive table-striped display">
                            <thead class="text-center">
                                <tr>
                                    <th>Shop ID</th>
                                    <th>Shop Name</th>
                                    <th>Status</th>
                                    <th>Contact Person</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>        
                </div>
                <div id="buyer-list" class="col-5">
                        <form id="buyer-search-form" class="form-inline" method="GET">
                            <input id="buyer-searchbar" name="search-buyer-name" class="form-control" type="text" placeholder="Search Buyer">
                            <button id="btn-search-buyer" type="button" class="btn btn-dark">Search</button>
                        </form>
                        <div class="mt-3" id="list-buyer">
                            <table id="table-buyer" class="table table-responsive table-striped display">
                                <thead class="text-center">
                                    <tr>
                                        <th>Buyer Name</th>
                                        <th>Owner Name</th>
                                        <th>Phone Number</th>
                                        <th>Add</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
