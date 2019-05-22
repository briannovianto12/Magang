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
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Order ID') }}</span>
                                    <span>{{ $data->order_no }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Ordered Date') }}</span>
                                    <span>{{ $data->created_at_formatted }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Payment Method') }}</span>
                                    <span>{{ $data->payment_method_name }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Payment Amount') }}</span>
                                    <span>{{ $data->payment_amount_formatted }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="m-widget28__tab-items">
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Order Status') }}</span>
                                    <span>{{ $data->orderStatus->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Payment Status') }}</span>
                                    <span>{{ $data->paymentStatus->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Shipping Status') }}</span>
                                    <span>{{ $data->shippingStatus->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Updated Date') }}</span>
                                    <span>{{ $data->created_at_formatted == $data->updated_at_formatted ? '-' : $data->updated_at_formatted }}</span>
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
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#shipping_detail" role="tab">
                    Shipping Detail
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#buyer_detail" role="tab">
                    Buyer Detail
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#seller_detail" role="tab">
                    Seller Detail
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#item_detail" role="tab">
                    Item Detail
                </a>
            </li>
        @endslot

        @slot('tab_body')
            <div class="tab-pane active" id="shipping_detail">
                @component('components._widget-list')
                    @slot('body')
                        <div class="row">
                            <div class="col-12">
                                <div class="m-widget28__tab-items">
                                    <div class="h2">Shipping</div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Shipping Service Code') }}</span>
                                        <span>{{ $data->shipping_service_code }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Shipping Estimated') }}</span>
                                        <span>{{ $data->shipping_estimated }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Shipping Cost') }}</span>
                                        <span>{{ $data->shipping_cost }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="h2">Origin Address</div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Building Name') }}</span>
                                        <span>{{ $data->origin_building }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Address Line') }}</span>
                                        <span>{!! $data->origin_address !!}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Notes') }}</span>
                                        <span>{{ $data->origin_notes }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="h2">Destination Address</div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Building Name') }}</span>
                                        <span>{{ $data->destination_building }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Address Line') }}</span>
                                        <span>{!! $data->destination_address !!}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Notes') }}</span>
                                        <span>{{ $data->destination_notes }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endslot
                @endcomponent
            </div>

            <div class="tab-pane" id="buyer_detail">
                @component('components._widget-list')
                    @slot('body')
                        <div class="row">
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="h2">Buyer Information</div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Avatar') }}</span>
                                        <span>
                                            <a data-fancybox data-type="image" href="{{ $data->buyer_avatar }}">
                                                <img src="{{ $data->buyer_avatar }}" alt="" width="128">
                                            </a>
                                        </span>

                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Full Name') }}</span>
                                        <span>{!! $data->buyer_name !!}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Phone') }}</span>
                                        <span>{{ $data->buyer_phone_no }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Status') }}</span>
                                        <span>{{ $data->buyer_status }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="h2">Business Information</div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Logo') }}</span>
                                        <span>
                                            <a data-fancybox data-type="image" href="{{ $data->business_logo }}">
                                                <img src="{{ $data->business_logo }}" alt="" width="128">
                                            </a>
                                        </span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Name') }}</span>
                                        <span>{{ $data->business_name }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Tag') }}</span>
                                        <span>{{ $data->business_tag }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Tax No') }}</span>
                                        <span>{{ $data->business_tax_no }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endslot
                @endcomponent
            </div>

            <div class="tab-pane" id="seller_detail">
                @component('components._widget-list')
                    @slot('body')
                        <div class="row">
                            <div class="col-12">
                                <div class="m-widget28__tab-items">
                                    <div class="h2">Seller Information</div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Logo') }}</span>
                                        <span>
                                            <a data-fancybox data-type="image" href="{{ $data->seller_logo }}">
                                                <img src="{{ $data->seller_logo }}" alt="" width="128">
                                            </a>
                                        </span>

                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Name') }}</span>
                                        <span>{!! $data->seller_name !!}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Description') }}</span>
                                        <span>{!! $data->seller_description !!}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Product Category') }}</span>
                                        <span>{{ $data->seller_product_category }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Tax No') }}</span>
                                        <span>{{ $data->seller_tax_no }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Status') }}</span>
                                        <span>{{ $data->buyer_status }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endslot
                @endcomponent
            </div>

            <div class="tab-pane" id="item_detail">
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
                                                        <span>{{ __('Base') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->base_price ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Margin') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->margin ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Bargain') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->bargain ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="m-widget28__tab-item">
                                                        <span>{{ __('Shop Discount') }}</span>
                                                        <span>IDR {{ number_format($item->payment_details->shop_discount ?? 0) ?? '-' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Quantity') }}</span>
                                                <span>{{ $item->qty ?? '' }} {{ $item->unit_type ?? '-'}}</span>
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
                                                <span>{{ $item->shipping_weight ?? '0' }} gr</span>
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

                                        {{--<div class="m-widget28__tab-item">
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