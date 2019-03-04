@extends('theme::layouts.master')

@section('content')
    @component('components.modals.basic', [
        'modalId' => 'verify',
        'method' => 'PATCH',
        'route' => route("{$module}.verified", $data->id),
        'title' => __('Verify Product'),
        'body' => 'Are you sure ?'
    ])
    @endcomponent

    @component('components.modals.basic', [
        'modalId' => 'reject',
        'method' => 'PATCH',
        'route' => route("{$module}.unverified", $data->id),
        'title' => __('Reject Product'),
        'body' => ['textarea' => ['name' => 'notes']],
    ])
    @endcomponent
    @component('components._portlet', [
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->name),
          'url_manage' => true,
          'url_back' => route("$module.index"),
          'postfix_back' => 'Back',
          'body_class' => 'pt-0'])
        @slot('body')

            @component('components._widget-list')
                @slot('body')
                    <div class="row">
                        <div class="col-4">
                            <div class="m-widget28__tab-items">
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Product ID') }}</span>
                                    <span>{{ $data->id }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Category') }}</span>
                                    <span>{{ $data->category ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Brand') }}</span>
                                    <span>{{ $data->brand ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Tags') }}</span>
                                    <div>
                                        @foreach($data->tags as $tag)
                                            <span class="m-badge  m-badge--default m-badge--wide mt-2">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="m-widget28__tab-items">
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('SKU') }}</span>
                                    <span>{{ $data->sku ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Unit') }}</span>
                                    <span>{{ $data->unit_type ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Condition') }}</span>
                                    <span>{{ $data->condition_type ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Price') }}</span>
                                    <span>IDR {{ number_format($data->price_min) ?? '-' }} - IDR {{ number_format($data->price_max) ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="m-widget28__tab-items">
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Store') }}</span>
                                    <span>{{ $data->shop->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Status') }}</span>
                                    <span>{{ $data->productStatus->name ?? '-' }}</span>
                                </div>
                                @if($data->status === \Bromo\Product\Models\ProductStatus::SUBMIT)
                                    <div class="m-widget28__tab-item text-center">
                                        <button type="button" class="btn btn-danger m-btn m-btn--custom"
                                                data-toggle="modal" data-target="#reject"
                                                data-route="{{ route("{$module}.unverified", $data->id) }}">
                                            Reject
                                        </button>
                                        <button type="button" class="btn btn-success m-btn m-btn--custom"
                                                data-toggle="modal" data-target="#verify"
                                                data-route="{{ route("{$module}.verified", $data->id) }}">
                                            Verify
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endslot
            @endcomponent

        @endslot

    @endcomponent

    <div class="row">
        <div class="col-6">
            @component('components._portlet', [
            'portlet_head' => true,
            'portlet_title' => sprintf("Descriptions"),
            'body_class' => 'pt-0'])
                @slot('body')

                    @component('components._widget-list')
                        @slot('body')
                            <section class="text-justify">
                                <p>{!! $data->description !!}</p>
                            </section>
                        @endslot
                    @endcomponent

                @endslot

            @endcomponent
        </div>

        <div class="col-6">
            @component('components._portlet', [
            'portlet_head' => true,
            'portlet_title' => sprintf("Product Attribute"),
            'body_class' => 'pt-0'])
                @slot('body')

                    @component('components._widget-list')
                        @slot('body')
                            <div class="row">
                                @isset($data->attributes)
                                    <div class="col-6">
                                        <h6>Product Attributes</h6>
                                        <ul class="m-nav">
                                            @foreach($data->attributes ?? [] as $key => $attribute)
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">{{ ucwords(str_replace('_',' ',$key)) }}</span>
                                                </li>
                                                <li class="m-nav__item">
                                                    <b class="m-nav__link-text">{{ $attribute }}</b>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endisset

                                @isset($data->dimensions)
                                    <div class="col-6">
                                        <h6>Dimensions</h6>
                                        <ul class="m-nav">
                                            @foreach($data->dimensions ?? [] as $key => $dimension)
                                                <li class="m-nav__section m-nav__section--first">
                                                    <span class="m-nav__section-text">{{ ucwords(str_replace('_',' ',$key)) }}</span>
                                                </li>
                                                <ul class="m-nav__sub mb-3 pl-0">
                                                    @foreach($dimension as $sub_key => $value)
                                                        <li class="m-nav__item">
                                                            <span class="m-nav__link-bullet m-nav__link-bullet--line"><span></span></span>
                                                            <span class="m-nav__link-text">{{ ucwords(str_replace('_',' ',$sub_key)) }} : </span>
                                                            <b class="m-nav__link-text">{{ $value }} {{ ($sub_key == 'weight') ? ' gr' : ' cm' }}</b>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endisset
                            </div>
                        @endslot
                    @endcomponent

                @endslot

            @endcomponent
        </div>

    </div>

@endsection