@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ mix('css/popular-product.css') }}">
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ mix('js/popular-product.js') }}"></script>
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ __('product::messages.popular_product') }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div id="regular-product-list" class="col-6">
                    <form id="product-search-form" class="form-inline" method="GET">
                        <input id="product-searchbar" name="search-product-name" class="form-control" type="text" placeholder="Search Product">
                        <button id="btn-search-product" type="button" class="btn btn-dark">{{ __('product::messages.search') }}</button>
                    </form>
                    <h6 class="mt-2">
                        {{ __('product::messages.reminder') }}
                    </h6>
                    <div class="mt-3" id="list-regular-product">
                        <table id="table-regular-product" class="table table-responsive table-striped table-bordered display">
                            <thead class="text-center">
                            <tr>
                                <th>{{ __('product::messages.regular_product') }}</th>
                                <th>{{ __('product::messages.seller') }}</th>
                                <th>{{ __('product::messages.action') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>        
                </div>
                <div class="col-6" id="popular-product-list">
                    <button id="btn-update-index" type="button" class="btn btn-dark">{{ __('product::messages.update_index') }}</button>
                    <div id="list-popular-product" class="mt-3">
                        <table id="table-popular-product" class="table table-responsive table-striped table-bordered display">
                            <thead class="text-center">
                            <tr>
                                <th>{{ __('product::messages.popular_product') }}</th>
                                <th>{{ __('product::messages.seller') }}</th>
                                <th>{{ __('product::messages.action') }}</th>
                            </tr>
                        </table>
                    </div>        
                </div>
            </div>
        </div>
    </div>
@endsection
