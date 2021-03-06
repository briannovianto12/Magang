@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ mix('css/popular-shop.css') }}">
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ mix('js/popular-shop.js') }}"></script>
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Popular Shop
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div id="regular-shop-list" class="col-6">
                    <form id="shop-search-form" class="form-inline" method="GET">
                        <input id="shop-searchbar" name="search-shop-name" class="form-control" type="text" placeholder="Search Shop">
                        <button id="btn-search-shop" type="button" class="btn btn-dark">Search</button>
                    </form>
                    <h6 class="mt-2">
                        Please click on Update Index once you have finished updating the list of popular shop.    
                    </h6>
                    <div class="mt-3" id="list-regular-shop">
                        <table id="table-regular-shop" class="table table-responsive table-striped table-bordered display">
                            <thead class="text-center">
                            <tr>
                                <th>Regular Shop</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>        
                </div>
                <div class="col-6" id="popular-shop-list">
                    <button id="btn-update-index" type="button" class="btn btn-dark">Update Index</button>
                    <div id="list-popular-shop" class="mt-3">
                        <table id="table-popular-shop" class="table table-responsive table-striped table-bordered display">
                            <thead class="text-center">
                            <tr>
                                <th>Popular Shop</th>
                                <th>Action</th>
                            </tr>
                        </table>
                    </div>        
                </div>
            </div>
        </div>
    </div>
@endsection
