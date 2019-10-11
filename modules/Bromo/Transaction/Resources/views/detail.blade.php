@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendor/fancybox/jquery.fancybox.css') }}">
    <style>
        #bromo .m-widget5 .m-widget5__item .m-widget5__content:last-child {
            float: none;
        }

        #bromo .list-inline-item:not(:last-child) {
            margin-right: 5rem;
            vertical-align: top;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendor/fancybox/jquery.fancybox.js') }}"></script>
    @include('transaction::js')
@endsection

@section('content')

    @component('components._portlet', [
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->order_no),
          'url_manage' => true,
          'url_back' => route("order.index"),
          'postfix_back' => 'Back',
          'body_class' => 'pt-0'])
        @slot('body')

            @component('components._widget-list')
                @slot('body')
                    <div class="row">
                        <div class="col-6">
                            <div class="m-widget28__tab-items">
                                <h3><b>ORDER INFO</b></h3>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Order Status') }}</span>
                                            @if($data->status == 1 || $data->status == 3 || $data->status == 4)
                                                <span style="color:red">{{ 'Awaiting Payment' }}</span>
                                            @elseif($data->status == 5)
                                                <span style="color:#39b54a">{{ 'Awaiting Seller Confirmation' }}</span>
                                            @elseif($data->status == 2 || $data->status == 6 || $data->status == 7)
                                                <span style="color:#39b54a">{{ 'Awaiting Shipment' }}</span>
                                            @elseif($data->status == 8)
                                                <span style="color:#39b54a">{{ 'On Delivery' }}</span>
                                            @elseif($data->status == 9)
                                                <span style="color:#39b54a">{{ 'Delivered' }}</span>
                                            @elseif($data->status == 10)
                                                <span style="color:#39b54a">{{ 'Success' }}</span>
                                            @elseif($data->status == 30 || $data->status == 31)
                                                <span style="color:red">{{ 'Canceled' }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{--
                                    @if($data->status == 8)
                                    <div class ="col-6">
                                        <form action="{{ url('/order/'.$data->id) ?? '#' }}" method="POST">
                                            {{csrf_field()}}
                                            <button class="btn btn-success">
                                                Delivered
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                    --}}
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Ordered Date') }}</span>
                                    <span>{{ $data->created_at_formatted }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Order No.') }}</span>
                                    <span>{{ $data->order_no }}</span>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Seller Name') }}</span>
                                            <span>
                                                {{ $sellerData->full_name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Seller Shop') }}</span>
                                            <span>
                                                <a href="{{ url('/store/'.$data->shop_id) }}">
                                                    {{ $data->shop_snapshot['name'] }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Seller Phone') }}</span>
                                            <span>
                                                {{ $sellerData->msisdn }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Seller Email') }}</span>
                                            <span>
                                                {{ $data->seller->contact_email ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Buyer Name') }}</span>
                                            <span>
                                                <a href="{{ url('/buyer/'.$data->buyer->id) }}">
                                                    {{ $data->buyer_name }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Buyer Phone') }}</span>
                                            <span>
                                                {{ $data->buyer_phone_no }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Buyer Email') }}</span>
                                            <span>
                                                {{ $data->buyer_email ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="m-widget28__tab-items">
                                <h3><b>SHIPPING</b></h3>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Airwaybill No.') }}</span>
                                    <span>{{ $data->shippingManifest()->get()[0]->airwaybill ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Courier') }}</span>
                                            <span>{!! $data->shipping_service_code !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Package Weight') }}</span>
                                            <span>{!! ($data->shipping_weight/1000) !!} Kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                <h5><b>Origin Address</b></h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Building Name') }}</span>
                                            <span>{!! $data->orig_address_snapshot['building_name'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Notes') }}</span>
                                            <span>{!! $data->orig_address_snapshot['building_name'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                {{ __('Pick Up Address') }}
                                                <button id="origin-cpy-btn" class="btn btn-sm" style="background-color: white">
                                                    <i class="fa fa-clone"></i>
                                                    Copy
                                                </button>
                                            </span>
                                            <span id="origin-address">{!! nl2br($data->origin_address) !!}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-10">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                <h5><b>Destination Address</b></h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Building Name') }}</span>
                                            <span>{!! $data->dest_address_snapshot['building_name'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Notes') }}</span>
                                            <span>{!! $data->dest_address_snapshot['notes'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                {{ __('Pick Up Address') }}
                                                <button id="dest-cpy-btn" class="btn btn-sm" style="background-color: white">
                                                    <i class="fa fa-clone"></i>
                                                    Copy
                                                </button>
                                            </span>
                                            <span id="destination-address">{!! nl2br($data->destination_address) !!}</span>
                                        </div>
                                    </div>
                                </div>
                                @isset($shipingCostDetails)
                                    <div class="m-widget28__tab-item row">
                                        <div class="col-12">
                                            <div class="m-widget28__tab-item">
                                                <span>
                                                    <h5><b>Shipping Cost Details</b></h5>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Total Gross Cost') }}</span>
                                                @if($shipingCostDetails['shipping_discount'] != 0)
                                                    <span><del>IDR {{ number_format($shipingCostDetails['shipping_gross_amount']) ?? '-' }}</del></span>
                                                @else
                                                    <span>IDR {{ number_format($shipingCostDetails['shipping_gross_amount']) ?? '-' }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Cost After Discount') }}</span>
                                                <span>IDR {{ number_format(($shipingCostDetails['shipping_gross_amount']) - ($shipingCostDetails['shipping_discount'])) ?? '-' }}</span>
                                            </div>
                                        </div>
                                        @isset($shippingInsuranceRate)
                                            <div class="col-4">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Shipping Insurance') }}</span>
                                                    <span>IDR {{ number_format($shippingInsuranceRate) ?? '0' }}</span>
                                                </div>
                                            </div>
                                        @endisset
                                    </div>
                                @endisset
                                <div class="m-widget28__tab-items row">
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                <h5><b>Payment Details</b></h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Total Gross Amount') }}</span>
                                            <span>IDR {{ number_format($data['payment_details']['total_gross']) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Shipping Cost') }}</span>
                                            <span>IDR {{ number_format($data['payment_details']['total_shipping_cost']) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Grand Total') }}</span>
                                            <h3 class="h4">IDR {{ number_format($data->payment_amount ?? 0) }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcomponent

        @endslot

    @endcomponent

    @component('components._portlet-tab', ['body_class' => 'pt-0'])

        @slot('tab_head')
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#item_detail" role="tab">
                Item Detail
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#delivery_tracking" role="tab">
                Delivery Tracking
                </a>
            </li>
        @endslot

        @slot('tab_body')
            <div class="tab-pane active" id="item_detail">
                @component('components._widget-list')
                    @slot('body')
                        @isset($data->orderItems)
                            @foreach($data->orderItems as $item)
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-items">
                                            <div class="h4">{{ $item->product_name ?? '-' }}</div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Variant') }}</span>
                                                <span>{{ $item->product_variant_name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Note') }}</span>
                                                <span>{{ $item->note ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Status') }}</span>
                                                <span>{{ $item->orderItemStatus->name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Product Image') }}</span>
                                                <span>
                                                    <a data-fancybox data-type="image"
                                                       href="{{ ($item->product_image_file) ? Storage::url(config('product.path.product') . $item->product_image_file) : 'https://via.placeholder.com/480x480?text=No+Image' }}">
                                                        <img src="{{ ($item->product_image_file) ? Storage::url(config('product.path.product') . $item->product_image_file) : 'https://via.placeholder.com/480x480?text=No+Image' }}"
                                                             alt="" width="128">
                                                    </a>
                                            </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="m-widget28__tab-items">
                                            <div class="h4">##</div>
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>Unit Price and Gross Amount</span>
                                                        <span>
                                                            IDR {{ number_format($item->payment_details->unit_price) }} <br>
                                                            IDR {{ number_format($item->payment_details->gross_amount) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Tax') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->tax_base ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('VAT') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->vat ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Discount') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->discount_amount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Quantity') }}</span>
                                                        <span>{{ $item->qty ?? '' }} {{ $item->unit_type ?? '-'}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Margin Rate') }}</span>
                                                        <span>{{ $item->payment_details->margin_rate }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Amount') }}</span>
                                                        <span>IDR {{ number_format($item->payment_amount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Settlement') }}</span>
                                                        <span>IDR {{ number_format($item->settlement_amount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Shipping Weight') }}</span>
                                                <span>{{ ($item->shipping_weight) ?? '0' }} gr</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-5">
                            @endforeach
                        @endisset
                    @endslot
                @endcomponent
            </div>
            <div class="tab-pane" id="delivery_tracking">
                @component('components._widget-list')
                    @slot('body')
                        @isset($deliveryTrackings)
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="h3">Internal</div>
                                        @foreach($deliveryTrackings as $deliveryTracking)
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-6">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Status') }}</span>
                                                        <span>{{ $deliveryTracking->internal->name ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Description') }}</span>
                                                        <span>{{ $deliveryTracking->internal->description ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="h3">External</div>
                                        @foreach($deliveryTrackings as $deliveryTracking)
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-6">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Status') }}</span>
                                                        <span>{{ $deliveryTracking->external->name ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Description') }}</span>
                                                        <span>{{ $deliveryTracking->external->description ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endisset
                    @endslot
                @endcomponent
            </div>
        @endslot

    @endcomponent

    @if($data->status >= \Bromo\Transaction\Models\OrderStatus::PAYMENT_OK)
        <!--begin::Portlet-->
        <div class="m-portlet m-portlet--collapsed m-portlet--head-sm" m-portlet="true">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon">
                        <i class="flaticon-notes"></i>
                    </span>
                        <h3 class="m-portlet__head-text">
                            Shipping Manifest Plan
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="" m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
                                <i class="la la-angle-down"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">

                @component('components._widget-list')
                    @slot('body')
                        @forelse($data->shippingManifest()->get() as $iManifest => $manifest)
                            <div class="h4">#{{ $loop->iteration }}</div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Weight') }}</span>
                                            <span>{{ $manifest->weight ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Cost') }}</span>
                                            <span>IDR {{ number_format($manifest->cost ?? 0) ?? '-' }}</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Airwaybill') }}</span>
                                            <span>{{ $manifest->airwaybill ?? '-' }}</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Carrier') }}</span>
                                            <span>{{ '-' }}</span>
                                        </div>--}}

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Status') }}</span>
                                            <span>{{ $manifest->shippingStatus->name ?? '' }}</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Created Date') }}</span>
                                            <span>{{ $manifest->created_at_formatted }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Carrier') }}</span>
                                            <span>-</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Receiver') }}</span>
                                            <span>-</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Action for Delivered') }}</span>
                                            <span>
                                                <button type="button" class="btn btn-success">
                                                    Delivered
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-5">
                        @empty
                            Shipping Manifest not yet created
                        @endforelse

                        @forelse($data->itemShipment()->get() as $itemShipment)
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="h4">Item Shipment of #{{ $loop->iteration }}</div>
                                        <div class="m-widget28__tab-item row">
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Product') }}</span>
                                                    <span>{{ $itemShipment->item_snapshot['product_name'] ?? '' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Total Qty') }}</span>
                                                    <span>{{ $itemShipment->qty_total }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget28__tab-item row">
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Shipped') }}</span>
                                                    <span>{{ $itemShipment->qty_shipped }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Delivered') }}</span>
                                                    <span>{{ $itemShipment->qty_delivered }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Accepted') }}</span>
                                                    <span>{{ $itemShipment->qty_accepted }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('Rejected') }}</span>
                                                    <span>{{ $itemShipment->qty_rejected }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    @endslot
                @endcomponent
            </div>
        </div>
        <!--end::Portlet-->
    @endif
@endsection