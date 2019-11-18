@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')

@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Shipper List
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div>
                <h5>Regular Shipper - Waktu Pengiriman 1-3 Hari</h5><br>
                <h5 class="">{{ $regular_shippers[0]->options[0]->name }}</h5><br>
                <div class="row" id="regular-shipper">
                    <div class="col-1">
                        <img src="{{ $regular_shippers[0]->options[0]->logo_url }}" alt="Italian Trulli">
                    </div>
                    <div class="col-3 ml-5">
                        <h5>{{ $regular_shippers[0]->options[0]->name }}</h5>
                        <h5>{{ IDR $regular_shippers[0]->options[0]->finalRate - $regular_shippers[0]->options[0]->platform_discount}}
                            IDR <strike>{{ $regular_shippers[0]->options[0]->finalRate }}</strike></h5>
                        <h5></h5>
                    </div>
                </div>

                <h5 class="mt-5">Regular Express - Waktu Pengiriman 1-3 Hari</h5><br>
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
@endsection
