@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('css/tagify.css') }}" rel="stylesheet">
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="{{ nbs_asset('js/jQuery.tagify.min.js') }}"></script>
    <script src="{{ nbs_asset('js/tagify.min.js') }}"></script>
    @include('freqaskedquestion::js-create')
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        New FAQ
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools float-right">
                <a href="{{route("faq.index")}}" class="btn btn-outline-primary btn-sm m-btn m-btn m-btn--icon m-btn--outline-2x">
                    <span>
                        <i class="fa fa-angle-double-left"></i>
                        <span>Back</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center">
                        <form action="{{ route('faq-category.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="h6" for="faq-cat-name">Category Name</label>
                                <input name="name" type="text" class="form-control" id="faq-cat-name" placeholder="Enter category name">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 6px">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection