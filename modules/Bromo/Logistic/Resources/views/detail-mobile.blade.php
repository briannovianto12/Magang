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
                    <h5><span class="badge badge-info badge-title"> <th>{{ __('logistic::messages.order_information') }}</th> </span></h5> 
                    
                    <div class="detail">
                        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::PICKED_UP)
                            <div class="status-name"><b><h4><th>{{ __('logistic::messages.package_shipped') }}</th></h4></b></div>                            
                        @endif
                        <div>{{ __('logistic::messages.order_number') }}</div>
                        <div><b><h3>{{ $order->order_no }}</h3></b></div>
                        <div>{{ __('logistic::messages.seller_name') }}</div>
                        <div class="subtitle-name"><b><h5>{{ $shop_info->name }}</h5></b></div>
                        <address>
                            {{ __('logistic::messages.seller_phone') }}
                            <b><h3>{{  $shop_info->msisdn }}</h3></b><br/>
                            {{ __('logistic::messages.seller_address') }}
                            <b><h4>{{  $shop_info->building_name }} /
                            {{ $shop_info->address_line }} </h4></b>

                            <br/>
                            {{ __('logistic::messages.buyer_name') }}
                            <div class="subtitle-name"><b><h5>{{ $destination_info['full_name'] }}</h5></b></div>
                            <br/>
                            {{ __('logistic::messages.buyer_notes') }}
                            <b><h4>{{  $shop_info->notes }}</h4></b>
                        </address>    
                        <br/>
                    </div>
                </div>
                

                <div class="content">
                    <h5><span class="badge badge-warning badge-title">{{ __('logistic::messages.expedition_info') }}</span></h5> 

                    <div class="detail">
                        <div class="subtitle-name"><b><h5>{{ $courier_info['courier_name'] }}</h5></b></div>
                        <address>
                            {{ __('logistic::messages.pick_up_request') }}
                            <b><h3>{{  $courier_info['expected_date'] }}</h3></b><br/>
                            {{ __('logistic::messages.pick_up_notes') }}
                            <b><h4>{{  $courier_info['pickup_instruction'] }}</h4></b>
                        </address>   
                        <br/> 
                    </div>
                </div>
                

                <div class="content">
                    <h5><span class="badge badge-danger badge-title">{{ __('logistic::messages.package_info') }}</span></h5> 

                    <div class="detail">
                        <div class="subtitle-name"><b><h5>{{ $order_info['description'] }} </h5></b></div>
                        <address>
                            {{ __('logistic::messages.weight_by_system') }}
                            <b><h3>{{ $order_info['system_weight'] }} KG</h3></b>
                        </address>    
                        <br/>
                    </div>
                </div>
                

                <div class="content">
                    <h5><span class="badge badge-success badge-title">{{ __('logistic::messages.destination_info') }}</span></h5> 

                    <div class="detail">
                        <div><b><h5>{{$destination_info['full_name']}} </h5></b></div> 
                        <address>
                            {{ __('logistic::messages.phone') }}<br/>
                            <b></h4>{{  $destination_info['msisdn'] }}</h4></b>
                            <br/>
                            {{ __('logistic::messages.address') }}<br/>
                            <b></h4>{{   $destination_info['building_name'] }} /
                            {{ $destination_info['address_line'] }}</h4></b>
                        </address>    
                        <br/>
                    </div>
                </div>

                <div class="content">
                    <h5><span class="badge badge-primary badge-title">{{ __('logistic::messages.photo_attachment') }}</span></h5> 

                    <div class="detail">
                        @if(count($images) > 0)
                            @foreach ( $images as $key => $value )
                                <img class="img-fluid img-item" src="{{ $value }}" width="80%" />
                            @endforeach
                        @else
                            <span>{{ __('logistic::messages.photo_not_exist') }}</span>
                        @endif
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        {{-- if status is waiting confirmation --}}
        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::WAITING_PICKUP)
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="window.history.go(-1); return false;" id="btnTolak" type="button" class="btn btn-secondary">{{ __('logistic::messages.go_back') }}</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="_performAcceptPickup('{{ $order->id }}')" id="btnTerima" type="button" class="btn btn-success">{{ __('logistic::messages.accept_pick_up') }}</button>
        </div>
        @endif

        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::IN_PROCESS_PICKUP)
        {{-- if status is in process --}}
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="location.href='{{ route('logistic.mobile-index') }}';" id="btnProses" type="button" class="btn btn-secondary">{{ __('logistic::messages.go_back_to_home') }}</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="_performCancelPickup('{{ $order->id }}')" id="btnBatalJemput" type="button" class="btn btn-danger">{{ __('logistic::messages.cancel_pick_up') }}</button>
        </div>
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="location.href='{{ route('logistic.pickup', ['id' => $order->id]) }}';" id="btnProses" type="button" class="btn btn-success">{{ __('logistic::messages.proceed') }}</button>
        </div>
        @endif

        @if($pickup_status == Bromo\Logistic\Entities\TraditionalLogisticStatus::PICKED_UP)
        <div class="pull-down" style="padding: 5px 10px">
            <button onclick="window.history.go(-1); return false;" id="btnTolak" type="button" class="btn btn-secondary">{{ __('logistic::messages.expedition_info') }}</button>
        </div>
        @endif
    </div>

</div>
@endsection
