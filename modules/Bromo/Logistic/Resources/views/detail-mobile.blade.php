@extends('logistic::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}">
        <link rel="stylesheet" href="{{ nbs_asset('vendor/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ nbs_asset('css/logistic.css') }}">
    <link rel="stylesheet" href="{{ nbs_asset('css/fs-modal.min.css') }}">
    <style>
        .content {
            background-color: white;
        }
    </style>
@endsection


@section('scripts')
    @include('logistic::js-template')
    @include('logistic::js-order-mobile')
    <script>
        $(document).ready(function () {
            $('div.show').fadeIn();
        })
    </script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="content">
                    <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Informasi Order </span></h5> 
                    
                    <a href="#" onclick="$(this).next().fadeToggle()" style="padding: 10px; display:block;"><b> <h5>{{ $shop_info->name }}</h5> <i class="fa fa-chevron-down icon-align-right" style="align: right"></i></b></a>
                    <div style="display: none; padding: 10px">
                        <address class="font-weight-bold" style="padding: 10px">
                            Catatan: {{  $shop_info->notes }} <br/>
                            Telpon: {{  $shop_info->msisdn }} <br/>
                            Alamat: {{  $shop_info->building_name }} /
                            {{ $shop_info->address_line }} 
                        </address>    
                        <br/>
                    </div>
                </div>
                <br/>

                <div class="content">
                    <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Informasi Ekspedisi</span></h5> 

                    <a href="#" onclick="$(this).next().fadeToggle()" style="padding: 10px; display:block;"><b><h5>{{ $courier_info['courier_name'] }} </h5><i class="fa fa-chevron-down"></i></b></a>
                    <div style="display: none; padding: 10px">
                        <address class="font-weight-bold" style="padding: 10px">
                            Siap dipickup: {{  $courier_info['expected_date'] }} <br/>
                            Catatan pickup: {{  $courier_info['pickup_instruction'] }}
                        </address>   
                        <br/> 
                    </div>
                </div>
                <br/>

                <div class="content">
                    <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Informasi Isi Paket </span></h5> 

                    <a href="#" onclick="$(this).next().fadeToggle()" style="padding: 10px; display:block;"><b><h5>{{ $order_info['description'] }} </h5><i class="fa fa-chevron-down"></i></b></a>
                    <div style="display: none; padding: 10px">
                        <address class="font-weight-bold" style="padding: 10px">
                            Berat menurut sistem: {{ $order_info['system_weight'] }} Kg
                        </address>    
                        <br/>
                    </div>
                </div>
                <br/>

                <div class="content">
                    <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Informasi Tujuan </span></h5> 

                    <a href="#" onclick="$(this).next().fadeToggle()" style="padding: 10px; display:block;"><b><h5>{{$destination_info['full_name']}} </h5><i class="fa fa-chevron-down"></i></b></a> 
                    <div class="show" style="display: none; padding: 10px">
                        <address class="font-weight-bold" style="padding: 10px">
                            Telpon: {{  $destination_info['msisdn'] }}<br/>
                            Alamant: {{   $destination_info['building_name'] }} /
                            {{ $destination_info['address_line'] }}
                        </address>    
                        <br/>
                    </div>
                </div>
                <br/>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{-- if status is waiting confirmation --}}
        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::WAITING_PICKUP)
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="window.history.go(-1); return false;" id="btnTolak" type="button" class="btn btn-secondary"> Kembali</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="_performAcceptPickup('{{ $order->id }}')" id="btnTerima" type="button" class="btn btn-success"> OK, Saya Jemput</button>
        </div>
        @endif

        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::IN_PROCESS_PICKUP)
        {{-- if status is in process --}}
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="location.href='/logistic-mobile';" id="btnProses" type="button" class="btn btn-secondary"> Kembali Ke Home</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="_performCancelPickup('{{ $order->id }}')" id="btnBatalJemput" type="button" class="btn btn-danger"> Batal Jemput</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="location.href='/pickup/{{$order->id}}';" id="btnProses" type="button" class="btn btn-success"> Proses Kirim</button>
        </div>
        @endif

        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::PICKED_UP)
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="window.history.go(-1); return false;" id="btnTolak" type="button" class="btn btn-secondary"> Kembali</button>
        </div>
        @endif
    </div>

</div>
@endsection
