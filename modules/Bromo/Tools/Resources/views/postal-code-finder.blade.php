@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ mix('js/postal-code-finder.js') }}"></script>
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
                        Postal Code Finder
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
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
                    <br>
                    <label for="postal-code">Postal Code</label>
                    <input id="postal-code" class="form-control" type="text" placeholder="Postal Code" readonly>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
