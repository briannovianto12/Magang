@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ mix('css/potal-code-finder.css') }}">
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    @include("tools::js-postal-code-finder")
    @include("tools::js-template")
    <script src="{{ asset('js/mustache.min.js') }}"></script>
    <script src="{{ mix('js/postal-code-finder.js') }}"></script>
@endsection

@section('content')
    @can('view_postal_code_finder')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Postal Code Finder
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <ul class="nav nav-tabs m-tabs-line m-tabs-line--info" role="tabList">
                <li class="nav-item m-tabs__item">
                    <a id="search_tab" class="nav-link m-tabs__link active" data-toggle="tab" href="#search"
                    role="tab">
                        <i class="la la-search"></i> Search
                    </a>
                </li>
                @can('edit_postal_code_finder')
                <li class="nav-item m-tabs__item">
                    <a id="editor_tab" class="nav-link m-tabs__link" data-toggle="tab" href="#editor"
                    role="tab">
                        <i class="la la-search"></i> Editor
                    </a>
                </li>
                @endcan
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="search" role="tabpanel">
                    <div class="table-responsive">
                        <table id="table_postal_code_finder"
                            class="table table-striped table-bordered table-hover display"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Province</th>
                                    <th>City</th>
                                    <th>District</th>
                                    <th>Subdistrict</th>
                                    <th>Postal Code</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                @can('edit_postal_code_finder')
                <div class="tab-pane" id="editor" role="tabpanel">
                    <div class="row">
                        <div class="col-6" id="form-container"> 
                            <label for="province">Province</label>
                            <select class="form-control" id="province" name="province">
                                <option value="" selected></option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach    
                            </select>
                            <br>
                            <label for="city">City</label>
                            <select class="form-control" id="city" name="city"></select> 
                            <br>
                            <label for="district">District</label>
                            <select class="form-control" id="district" name="district"></select> 
                            <br>
                            <label for="subdistrict">Subdistrict</label>
                            <select class="form-control" id="subdistrict" name="subdistrict"></select>
                        </div>
                        <div class="col-6" id="result-container">
                            <form id="thisForm" action="{{ route('postalCodeFinder.index') }}" method="get">
                                <h5>Postal Code</h5>
                                <input id="postal-code" class="form-control" type="text" placeholder="Postal Code" readonly>
                            </form>
                            <br>
                            <button id="btnEditPostalCode" class="btn btn-primary" disabled="disabled">
                                Edit Postal Code
                            </button>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>
    @endcan
@endsection
