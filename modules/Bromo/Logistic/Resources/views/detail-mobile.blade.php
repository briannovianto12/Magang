@extends('logistic::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}">
        <link rel="stylesheet" href="{{ nbs_asset('vendor/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ mix('css/logistic.css') }}">
    
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

    <div id="logistic-detail">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="content">
                    <h5><span class="badge badge-info badge-title"> Informasi Order </span></h5> 
                    
                    <div class="detail">
                        <div>Nomor Order: </div>
                        <div><b><h3>{{ $order->order_no }}</h3></b></div>
                        <div>Nama Penjual: </div>
                        <div class="subtitle-name"><b><h5>{{ $shop_info->name }}</h5></b></div>
                        <address>
                            Telpon Penjual:
                            <b><h3>{{  $shop_info->msisdn }}</h3></b><br/>
                            Alamat Penjual:
                            <b><h4>{{  $shop_info->building_name }} /
                            {{ $shop_info->address_line }} </h4></b>

                            <br/>
                            Catatan dari Pembeli:
                            <b><h4>{{  $shop_info->notes }}</h4></b>
                        </address>    
                        <br/>
                    </div>
                </div>
                

                <div class="content">
                    <h5><span class="badge badge-warning badge-title"> Informasi Ekspedisi</span></h5> 

                    <div class="detail">
                        <div class="subtitle-name"><b><h5>{{ $courier_info['courier_name'] }}</h5></b></div>
                        <address>
                            Permintaan dipickup: 
                            <b><h3>{{  $courier_info['expected_date'] }}</h3></b><br/>
                            Catatan pickup:
                            <b><h4>{{  $courier_info['pickup_instruction'] }}</h4></b>
                        </address>   
                        <br/> 
                    </div>
                </div>
                

                <div class="content">
                    <h5><span class="badge badge-danger badge-title"> Informasi Isi Paket </span></h5> 

                    <div class="detail">
                        <div class="subtitle-name"><b><h5>{{ $order_info['description'] }} </h5></b></div>
                        <address>
                            Berat menurut sistem:
                            <b><h3>{{ $order_info['system_weight'] }} KG</h3></b>
                        </address>    
                        <br/>
                    </div>
                </div>
                

                <div class="content">
                    <h5><span class="badge badge-success badge-title"> Informasi Tujuan / Penerima</span></h5> 

                    <div class="detail">
                        <div><b><h5>{{$destination_info['full_name']}} </h5></b></div> 
                        <address>
                            Telpon:<br/>
                            <b></h4>{{  $destination_info['msisdn'] }}</h4></b>
                            <br/>
                            Alamat:<br/>
                            <b></h4>{{   $destination_info['building_name'] }} /
                            {{ $destination_info['address_line'] }}</h4></b>
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
            <button onclick="location.href='{{ route('logistic.mobile-index') }}';" id="btnProses" type="button" class="btn btn-secondary"> Kembali Ke Home</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="_performCancelPickup('{{ $order->id }}')" id="btnBatalJemput" type="button" class="btn btn-danger"> Batal Jemput</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="location.href='{{ route('logistic.pickup', ['id' => $order->id]) }}';" id="btnProses" type="button" class="btn btn-success"> Proses Kirim</button>
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
