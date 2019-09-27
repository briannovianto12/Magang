@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    @include('report::js')
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
                    <a id="product_published_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#published"
                       role="tab">
                        <i class="la la-archive"></i> report</a>
                </li>
            </ul>
            <div class="tab-content">
                <!--begin:: Submited Page-->
                <div class="tab-pane active" id="published" role="tabpanel">
                    <table class="table table-striped table-bordered table-hover display nowrap" id="product_report"
                           style="width: 100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Shop Name</th>
                            <th>Full Name</th>
                            <th>MSISDN</th>
                            <th>Address Line</th>
                            <th>Count</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--end:: Submited Page-->
            </div>
        </div>
    </div>

@endsection