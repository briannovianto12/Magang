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
            <ul class="nav nav-tabs  m-tabs-line m-tabs-line--info" role="tablist">
                <li class="nav-item m-tabs__item">
                    <a id="submited_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#submit"
                       role="tab">
                        <i class="la la-archive"></i> Submited Product</a>
                </li>
                <li id="rejected_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#reject" role="tab">
                        <i class="la la-warning"></i> Rejected Product</a>
                </li>
                <li id="approved_tab" class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#approve" role="tab">
                        <i class="la la-clone"></i> Listed Product</a>
                </li>
            </ul>
            <div class="tab-content">
                <!--begin:: Submited Page-->
                <div class="tab-pane active" id="submit" role="tabpanel">
                    <table class="table table-striped table-bordered table-hover display nowrap" id="product_submit"
                           style="width: 100%">
                        <thead>
                        <tr>
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
                            <th>Status</th>
                            <th>Action</th>
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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--end:: Rejected Page-->

                <!--begin:: Approved Page-->
                <div class="tab-pane" id="approve" role="tabpanel">
                    <table class="table table-striped table-bordered table-hover display nowrap" id="product_approve"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Product ID</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Shop</th>
                            {{-- TODO show this data--}}
                            {{--<th>Price</th>--}}
                            {{--<th>Quantity</th>--}}
                            <th>Product Type</th>
                            <th>Approve Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--end:: Approved Page-->
            </div>
        </div>
    </div>

@endsection