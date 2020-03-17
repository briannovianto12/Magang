@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Shipping Courier City List
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <a href="{{ route('shippingmapping.form-city') }}" class="btn btn-secondary">
                <i class="la la-plus"></i>
                Register New Mapping
            </a>
            <br><br>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert"></button> 
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert"></button> 
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table id="table-shipping-courier-city" class="table table-striped table-bordered display" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Courier Name</th>
                            <th>City Name</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $item)
                        <tr>
                            <td>{{ $item->courier_name }}</td>
                            <td>{{ $item->city_name }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
