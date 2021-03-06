@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{ mix('css/shipping-simulation.css') }}">
@endsection

@section('scripts')
    <script src="{{ mix('js/shipping-simulation.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('content')
    @can('view_shipping_simulation')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Shipping Simulation
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-6" id="simulation-form-container">
                    <form role="form" action="" id="simulation-form" name="simulation-form" method="GET" class="form-group" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <h5>Origin Address</h5>
                        <div class="row" id="origin-address">
                            <div class="col-6">
                            <label for="origin-province">Province</label>
                                <select class="form-control" id="origin-province"">
                                    <option value="" selected></option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach    
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="origin-city">City</label>
                                <select class="form-control" id="origin-city" name="origin-city">
                                    <option value="" selected></option>
                                </select> 
                            </div>
                            <div class="col-6">
                                <label for="origin-district">District</label>
                                <select class="form-control" id="origin-district" name="origin-district">
                                    <option value="" selected></option>
                                </select> 
                            </div>
                            <div class="col-6">
                                <label for="origin-subdistrict">Subdistrict</label>
                                <select class="form-control" id="origin-subdistrict" name="origin-subdistrict">
                                    <option value="" selected></option>
                                </select> 
                            </div>
                            <div class="col-6">
                                <label for="origin-postal-code">Postal Code</label>
                                <input id="origin-postal-code" name="origin-postal-code" class="form-control" type="text" placeholder="Postal Code" readonly>
                            </div>
                        </div> 
                        <h5 class="mt-5">Destination Address</h5><br>
                        <div class="row" id="destination-address">
                            <div class="col-6">
                            <label for="destination-province">Province</label>
                                <select class="form-control" id="destination-province">
                                    <option value="" selected></option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                                    @endforeach    
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="destination-city">City</label>
                                <select class="form-control" id="destination-city" name="destination-city">
                                    <option value="" selected></option>    
                                </select> 
                            </div>
                            <div class="col-6">
                                <label for="destination-district">District</label>
                                <select class="form-control" id="destination-district" name="destination-district">
                                    <option value="" selected></option>
                                </select> 
                            </div>
                            <div class="col-6">
                                <label for="destination-subdistrict">Subdistrict</label>
                                <select class="form-control" id="destination-subdistrict" name="destination-subdistrict">
                                    <option value="" selected></option>
                                </select> 
                            </div>
                            <div class="col-6">
                                <label for="destination-postal-code">Postal Code</label>
                                <input id="destination-postal-code" name="destination-postal-code" class="form-control" type="text" placeholder="Postal Code" readonly>
                            </div>
                        </div>
                        <h5 class="mt-5">Package Info</h5><br>
                        <div class="row">
                            <div class="col-5">
                                <label for="package-weight">Package Weight (Kg) </label><br>
                                <input id="package-weight" name="package-weight" type="number" min=1>
                                <input type="text" id="package-weight-static" value="Kg" disabled/>
                            </div>
                            <div class="col-6">
                                <label for="package-value">Package Value (Rp) </label><br>
                                <input type="text" id="package-value-static" value="IDR " disabled/>
                                <input type="number" id="package-value" name="package-value" min=0/>
                            </div>
                            <div class="col-5 mt-3">
                                <label for="package-size">Package Size </label><br>
                                <select class="form-control" id="package-size" name="package-size">
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                </select>
                            </div>
                            <div class="col-3 mt-5">
                                <button class="btn btn-primary" id="btn-simulate" type="submit">
                                    Simulate Shipping
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
                <div id="shipper-list" class="col-6">
                    <div id="regular-shipper-tab">
                        <h5 id="regular-shipper-list-header" class="mt-5">Regular Shipper - Delivery Time 1-3 Day</h5><br>
                        <div id="regular-shipper-list"></div>
                    </div>
                    <div id="express-shipper-tab">
                        <h5 id="express-shipper-list-header" class="mt-5">Express Shipper - Delivery Time 1-2 Day</h5><br>
                        <div id="express-shipper-list"></div>
                    </div>
                    <div id="trucking-shipper-tab">
                        <h5 id="trucking-shipper-list-header" class="mt-5">Trucking Shipper - Delivery Time 3-4 Day</h5><br>
                        <div id="trucking-shipper-list"></div>
                    </div>
                </div>
                <div class="mt-5" id="shipper-list-error">
                    <h5>No Data</h5><br>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection
