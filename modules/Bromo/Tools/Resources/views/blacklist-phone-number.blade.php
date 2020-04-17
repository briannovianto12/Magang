@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('content')
    @can('blacklist-user')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Blacklist Phone Number
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
           <div class="row">
                <div class="col-6" id="result-container">
          
                    <form action="{{ route('blacklist-phone-number.post-table') }}" method="POST">
                            {{ csrf_field() }}
                        <div class="form-group">
                            <label for="banner-title">Phone Number</label>
                            <input id="postal-code" class="form-control" type="text" name="msisdn" placeholder="Ex : 628123456789" >
                        </div>
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 6px">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
@endsection

