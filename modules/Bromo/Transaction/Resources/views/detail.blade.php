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
    <script src="{{ asset('js/order.js') }}"></script>
    <script src="{{ mix('js/reject-order.js') }}"></script>
    <script src="{{ mix('js/transaction.js') }}"></script>
    <script src="{{ asset('js/mustache.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    @include('transaction::js')
    @include('transaction::js-template')
@endsection

@section('content')

    @component('components._portlet', [
          'portlet_head' => true,
          'portlet_title' => __('transaction::messages.detail_title', ['title' => $title, 'name' => $data->order_no]),
          'url_manage' => true,
          'url_back' => route("order.index"),
          'postfix_back' => __('transaction::messages.back'),
          'body_class' => 'pt-0'])
        @slot('body')

            @component('components._widget-list')
                @slot('body')
                    <div class="row">
                        <div class="col-6">
                            <div class="m-widget28__tab-items">
                                <h3><b>{{ __('transaction::messages.order_info') }}</b></h3>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-3">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.order_status') }}</span>
                                            @if($data->status == 1 || $data->status == 3 || $data->status == 4)
                                                <span style="color:red">{{ __('transaction::messages.awaiting_payment') }}</span>
                                            @elseif($data->status == 5)
                                                <span style="color:#39b54a">{{ __('transaction::messages.awaiting_seller_confirmation') }}</span>
                                            @elseif($data->status == 2 || $data->status == 6 || $data->status == 7)
                                                <span style="color:#39b54a">{{ __('transaction::messages.awaiting_shipment') }}</span>
                                            @elseif($data->status == 8)
                                                <span style="color:#39b54a">{{ __('transaction::messages.on_delivery') }}</span>
                                            @elseif($data->status == 9)
                                                <span style="color:#39b54a">{{ __('transaction::messages.delivered') }}</span>
                                            @elseif($data->status == 10)
                                                <span style="color:#39b54a">{{ __('transaction::messages.success') }}</span>
                                            @elseif($data->status == 30 || $data->status == 31)
                                                <span style="color:red">{{ __('transaction::messages.canceled') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-5">
                                    @can('change_order_to_delivered')
                                        @if($data->status == \Bromo\Transaction\Models\OrderStatus::SHIPPED && $data->is_picked_up)
                                            <button class="btn btn-success" onclick="_changeStatus('{{ $data->id }}')">
                                                {{ __('transaction::messages.change_order_status_to_delivered') }}
                                            </button>
                                        @endif
                                    @endcan

                                    @can('do_success_order')
                                        @if($data->status == \Bromo\Transaction\Models\OrderStatus::DELIVERED)
                                            <button class="btn btn-success" onclick="_changeOrderSuccess('{{ $data->id }}')">
                                                {{ __('transaction::messages.change_order_status_to_success') }}
                                            </button>
                                        @endif
                                    @endcan
                                    </div>

                                    @can('reject_order')
                                        <div class="col-3 ml-4">
                                            @if($data->status == 8 || $data->status == 5 || $data->status == 2)
                                                <button class="btn btn-danger" onclick="_rejectOrder('{{ $data->id }}')">
                                                    {{ __('transaction::messages.reject_order') }}
                                                </button>
                                            @endif
                                        </div>
                                    @endcan

                                    @can('unreject_order')
                                        <div class="col-3 ml-4">
                                            @if($data->status == 31)
                                                <a href="{{ route('order.unRejectOrder', ['id' => $data->id]) }}" onclick="return confirm('Are you sure you want to unreject the order?')" class="btn btn-success">
                                                    {{ __('Unreject Order') }}
                                                </a>
                                                <br/><br/>
                                            @endif
                                        </div>
                                    @endcan
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('transaction::messages.ordered_date') }}</span>
                                    <span>{{ $data->created_at_formatted }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('transaction::messages.order_no') }}</span>
                                    <span>{{ $data->order_no }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('transaction::messages.order_notes') }}</span>
                                    <span>{{ $data->notes ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.seller_name') }}</span>
                                            <span>
                                                {{ $sellerData->full_name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.seller_shop') }}</span>
                                            <span>
                                                <a href="{{ url('/store/'.$data->shop_id) }}">
                                                    {{ $data->shop_snapshot['name'] }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.seller_phone') }}</span>
                                            <span>
                                                {{ $sellerData->msisdn }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.seller_email') }}</span>
                                            <span>
                                                {{ $data->seller->contact_email ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.buyer_name') }}</span>
                                            <span>
                                                <a href="{{ url('/buyer/'.$data->buyer->id) }}">
                                                    {{ $data->buyer_name }}
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.buyer_phone') }}</span>
                                            <span>
                                                {{ $data->buyer_phone_no }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.buyer_email') }}</span>
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
                                <h3><b>{{ __('transaction::messages.shipping') }}</b></h3>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.airwaybill_no') }}</span>
                                            @if(empty($data->shippingManifest()->first()->airwaybill))
                                                <span>-</span>
                                            @else
                                                <span>{{ $data->shippingManifest()->first()->airwaybill }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.pick_up_no') }}</span>
                                            <span>{{ $data->special_id ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="m-widget28__tab-item row">
                                    @can("update_airwaybill")
                                    <div class="col-4">
                                        <div class="m-widget28__tab-item">
                                            @if( empty($data->shippingManifest()->first()->airwaybill)
                                            && ($data->status == \Bromo\Transaction\Models\OrderStatus::SHIPPED 
                                                    || $data->status == \Bromo\Transaction\Models\OrderStatus::DELIVERED 
                                                    || $data->status == \Bromo\Transaction\Models\OrderStatus::SUCCESS)
                                            && $data->is_picked_up)
                                                <button class="btn btn-success" onclick="_updateAwbShippingManifest('{{ $data->id }}')">
                                                    Update Airwaybill
                                                </button>
                                                <br/>
                                                <br/>
                                            @endif
                                        </div>
                                    </div>
                                    @endcan

                                    @can("change_picked_up")
                                        <div class="col-4">
                                            <div class="m-widget28__tab-item">
                                                @if($data->status == \Bromo\Transaction\Models\OrderStatus::SHIPPED
                                                && !$data->is_picked_up)
                                                    <button class="btn btn-success" onclick="_changePickedUp('{{ $data->id }}')">
                                                        {{ __('transaction::messages.change_picked_up') }}
                                                    </button>
                                                    <br/>
                                                    <br/>
                                                @endif
                                            </div>
                                        </div>
                                    @endcan

                                    @can("recall_shipper")
                                    <div class="col-4">
                                        <div class="m-widget28__tab-item">
                                            @if( (empty($data->special_id) || $data->special_id == '')
                                            && $data->shippingCourier->provider_id == Bromo\Transaction\Models\ShippingCourier::SHIPPING_PROVIDER_SHIPPER
                                            && $data->status == \Bromo\Transaction\Models\OrderStatus::SHIPPED )
                                                <button class="btn btn-success" onclick="_callCourier(this, '{{ $data->id }}', {{ $shipping_weight }}); ">
                                                    Call Courier Shipper
                                                </button>
                                                <br/>
                                                <br/>
                                            @endif
                                        </div>
                                    </div>
                                    @endcan    
                                </div>

                                <div class="m-widget28__tab-item row">
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.courier') }}</span>
                                            <span>{!! $data->shipping_service_code !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                {{ __('transaction::messages.package_weight') }}
                                                @if(isset($shippingManifest))
                                                    @if(!isset($unsupportedShipper))
                                                        @can("edit_order_weight")
                                                        <button id="edit-weight-btn" class="btn btn-sm" style="background-color: white" onclick="_edit('{{ $data->id }}')">
                                                            <i class="fa fa-edit"></i>
                                                            {{ __('transaction::messages.edit') }}
                                                        </button>
                                                        @endcan
                                                    @endif
                                                @endif
                                            </span>
                                            <span>
                                                @if(isset($shippingManifest))
                                                    <span>{!! ceil($shippingManifest->weight/1000) ?? '-' !!} Kg</span>
                                                @else
                                                    <span>{!! ceil($data->shipping_weight/1000) ?? '-' !!} Kg</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    @isset($shippingManifest)
                                        @if($shippingManifest->weight_correction != 0 || !isset($shippingManifest))
                                            <div class="col-6">
                                                <div class="m-widget28__tab-item">
                                                    <span>
                                                        {{ __('transaction::messages.corrected_package_weight') }}
                                                    </span>
                                                    <span>{!! ceil($shippingManifest->weight_correction/1000) !!} Kg</span>
                                                </div>
                                            </div>
                                        @endif
                                    @endisset
                                </div>
                                <div class="m-widget28__tab-item row">
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                <h5><b>{{ __('transaction::messages.origin_address') }}</b></h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.building_name') }}</span>
                                            <span>{!! $data->orig_address_snapshot['building_name'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.notes') }}</span>
                                            <span>{!! $data->orig_address_snapshot['building_name'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                {{ __('transaction::messages.pick_up_address') }}
                                                <button id="origin-cpy-btn" class="btn btn-sm" style="background-color: white">
                                                    <i class="fa fa-clone"></i>
                                                    {{ __('transaction::messages.copy') }}
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
                                                <h5><b>{{ __('transaction::messages.destination_address') }}</b></h5>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.building_name') }}</span>
                                            <span>{!! $data->dest_address_snapshot['building_name'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.notes') }}</span>
                                            <span>{!! $data->dest_address_snapshot['notes'] !!}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>
                                                {{ __('transaction::messages.pick_up_address') }}
                                                <button id="dest-cpy-btn" class="btn btn-sm" style="background-color: white">
                                                    <i class="fa fa-clone"></i>
                                                    {{ __('transaction::messages.copy') }}
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
                                                    <h5><b>{{ __('transaction::messages.shipping_cost_details') }}</b></h5>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.total_gross_cost') }}</span>
                                                @if($shipingCostDetails['shipping_discount'] != 0)
                                                    <span><del>IDR {{ number_format($shipingCostDetails['shipping_gross_amount']) ?? '-' }}</del></span>
                                                @else
                                                    <span>IDR {{ number_format($shipingCostDetails['shipping_gross_amount']) ?? '-' }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.shipping_discount') }}</span>
                                                <span>IDR {{ number_format($data['shipping_service_snapshot']['shipper']['platform_discount']) ?? 0 }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.cost_after_discount') }}</span>
                                                <span>IDR {{ number_format(($shipingCostDetails['shipping_gross_amount']) - ($shipingCostDetails['shipping_discount'])) ?? '-' }}</span>
                                            </div>
                                        </div>
                                        @isset($shippingInsuranceRate)
                                            <div class="col-6">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.shipping_insurance') }}</span>
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
                                                <h5><b>{{ __('transaction::messages.payment_details') }}</b></h5>
                                            </span>
                                        </div>
                                    </div>

                                    @isset($data->payment_details['platform_discount'])
                                        <div class="col-4">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.platform_discount') }}</span>
                                                <span>IDR {{ number_format($data->payment_details['platform_discount']) ?? 0 }}</span>
                                            </div>
                                        </div>
                                    @endisset
                                    @isset($data->payment_details['total_discount'])
                                        <div class="col-4">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.seller_discount') }}</span>
                                                <span>IDR {{ number_format($data->payment_details['total_discount']) ?? 0 }}</span>
                                            </div>
                                        </div>
                                    @endisset
                                    <div class="col-4">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.shipping_cost') }}</span>
                                            <span>IDR {{ number_format($data['payment_details']['total_shipping_cost']) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.total_gross_amount') }}</span>
                                            <span>IDR {{ number_format($data['payment_details']['total_gross']) }}</span>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.grand_total') }}</span>
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
                    {{ __('transaction::messages.item_detail') }}
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#delivery_tracking" role="tab">
                    {{ __('transaction::messages.delivery_tracking') }}
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
                                                <span>{{ __('transaction::messages.variant') }}</span>
                                                <span>{{ $item->product_variant_name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.note') }}</span>
                                                <span>{{ $item->note ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.status') }}</span>
                                                <span>{{ $item->orderItemStatus->name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.product_image') }}</span>
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
                                                        <span>{{ __('transaction::messages.unit_price_and_gross_amount') }}</span>
                                                        <span>
                                                            IDR {{ number_format($item->payment_details->unit_price) }} <br>
                                                            IDR {{ number_format($item->payment_details->gross_amount) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.tax') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->tax_base ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.vat') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->vat ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.discount') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->discount_amount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.quantity') }}</span>
                                                        <span>{{ $item->qty ?? '' }} {{ $item->unit_type ?? '-'}}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.margin_rate') }}</span>
                                                        <span>{{ $item->payment_details->margin_rate }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item row">
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.amount') }}</span>
                                                        <span>IDR {{ number_format($item->payment_amount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('transaction::messages.settlement') }}</span>
                                                        <span>IDR {{ number_format($item->settlement_amount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('transaction::messages.shipping_weight') }}</span>
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
                                <div class="col-12">
                                    <div class="m-widget28__tab-items">
                                        <div class="h3">{{ __('transaction::messages.internal') }}</div>
                                        <div class="m-widget28__tab-item row">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th>{{ __('transaction::messages.status') }}</th>
                                                    <th>{{ __('transaction::messages.description') }}</th>
                                                    <th>{{ __('transaction::messages.date') }}</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($deliveryTrackings as $deliveryTracking)
                                                        <tr>
                                                            <td>
                                                                {{ $deliveryTracking->data_json->internal->name ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $deliveryTracking->data_json->internal->description ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $deliveryTracking->created_at ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="m-widget28__tab-items">
                                        <div class="h3">{{ __('transaction::messages.external') }}</div>
                                        <div class="m-widget28__tab-item row">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th>{{ __('transaction::messages.status') }}</th>
                                                    <th>{{ __('transaction::messages.description') }}</th>
                                                    <th>{{ __('transaction::messages.date') }}</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($deliveryTrackings as $deliveryTracking)
                                                        <tr>
                                                            <td>
                                                                {{ $deliveryTracking->data_json->external->name ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $deliveryTracking->data_json->external->description ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $deliveryTracking->created_at ?? '-' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
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
                            {{ __('transaction::messages.shipping_manifest_plan') }}
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
                                            <span>{{ __('transaction::messages.weight') }}</span>
                                            <span>{{ $manifest->weight ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.cost') }}</span>
                                            <span>IDR {{ number_format($manifest->cost ?? 0) ?? '-' }}</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.airwaybill') }}</span>
                                            <span>{{ $manifest->airwaybill ?? '-' }}</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.carrier') }}</span>
                                            <span>{{ '-' }}</span>
                                        </div>--}}

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.status') }}</span>
                                            <span>{{ $manifest->shippingStatus->name ?? '' }}</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.created_date') }}</span>
                                            <span>{{ $manifest->created_at_formatted }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.carrier') }}</span>
                                            <span>-</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.receiver') }}</span>
                                            <span>-</span>
                                        </div>

                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('transaction::messages.action_for_delivered') }}</span>
                                            <span>
                                                <button type="button" class="btn btn-success">
                                                    {{ __('transaction::messages.delivered') }}
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="mb-5">
                        @empty
                            {{ __('transaction::messages.shipping_manifest_alert') }}
                        @endforelse

                        @forelse($data->itemShipment()->get() as $itemShipment)
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="h4">{{__('transaction::messages.item_shipment_no', ['loop' => $loop->iteration]) }}</div>
                                        <div class="m-widget28__tab-item row">
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.product') }}</span>
                                                    <span>{{ $itemShipment->item_snapshot['product_name'] ?? '' }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.total_qty') }}</span>
                                                    <span>{{ $itemShipment->qty_total }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget28__tab-item row">
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.shipped') }}</span>
                                                    <span>{{ $itemShipment->qty_shipped }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.delivered') }}</span>
                                                    <span>{{ $itemShipment->qty_delivered }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.accepted') }}</span>
                                                    <span>{{ $itemShipment->qty_accepted }}</span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="m-widget28__tab-item">
                                                    <span>{{ __('transaction::messages.rejected') }}</span>
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