@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
@endsection

@section('scripts')
    @include('product::js')
    @include('product::js-template')
    @include('product::js-edit-category')
@endsection

@can('view_product')
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
            {{-- @can('view_popular_shops') --}}
                <a href="{{ route('popular-product.index') }}" class="btn btn-link">Go to Popular Product</a>
            {{-- @endcan --}}
            <ul class="nav nav-tabs  m-tabs-line m-tabs-line--info" role="tablist">

                <li class="nav-item m-tabs__item">
                    <a id="approved_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#approve"
                       role="tab">
                        <i class="la la-archive"></i> Listed Product</a>
                </li>
                <li id="rejected_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#reject" role="tab">
                        <i class="la la-warning"></i> Rejected Product</a>
                </li>
                <li id="submited_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#submit" role="tab">
                        <i class="la la-clone"></i> Submited Product</a>
                </li>
            </ul>
            <div class="tab-content">
                <!--begin:: Submited Page-->
                <div class="tab-pane" id="submit" role="tabpanel">
                    <table class="table table-striped table-bordered table-hover display nowrap" id="product_submit"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Shop</th>
                            {{-- TODO show this data--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Quantity</th>--}}
                            <th>Product Type</th>
                            <th>Submit Date</th>
                            <th>Weight (gr)</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--end:: Submited Page-->

                <!--begin:: Rejected Page-->
                <div class="tab-pane" id="reject" role="tabpanel">
                    <table class="table table-striped table-bordered table-hover display nowrap" id="product_reject"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>Action</th>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Shop</th>
                            {{-- TODO show this data--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Quantity</th>--}}
                            <th>Product Type</th>
                            <th>Rejected Date</th>
                            <th>Weight (gr)</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--end:: Rejected Page-->

                <!--begin:: Approved Page-->
                <div class="tab-pane active" id="approve" role="tabpanel">
                    <table class="table table-striped table-bordered table-hover display nowrap" id="product_approve"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>Action</th>                            
                            <th>Product ID</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Shop</th>
                            {{-- TODO show this data--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Quantity</th>--}}
                            <th>Product Type</th>
                            <th>Approve Date</th>
                            <th>Weight (gr)</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--end:: Approved Page-->
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 id="modalTitle"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@endcan