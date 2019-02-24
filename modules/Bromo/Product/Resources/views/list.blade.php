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
                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#submit" role="tab">
                        <i class="la la-archive"></i> Submited Product</a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#reject" role="tab">
                        <i class="la la-warning"></i> Rejected Product</a>
                </li>
                <li class="nav-item m-tabs__item">
                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#approve" role="tab">
                        <i class="la la-clone"></i> Listed Product</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="submit" role="tabpanel">
                    <p>Submited page</p>
                </div>
                <div class="tab-pane" id="reject" role="tabpanel">
                    <p>Rejected page</p>
                </div>
                <div class="tab-pane" id="approve" role="tabpanel">
                    <p>Approved Page</p>
                </div>
            </div>
        </div>
    </div>

@endsection