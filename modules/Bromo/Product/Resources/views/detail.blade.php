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
    @include('product::js')
@endsection

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
                                    @if($data->price_min != $data->price_max)
                                        <span>IDR {{ number_format($data->price_min) ?? '-' }} - IDR {{ number_format($data->price_max) ?? '-' }}</span>
                                    @else
                                        <span>IDR {{ number_format($data->price_min) ?? '-' }}</span>
                                    @endif
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
                                    <span>{{ __('Published') }}</span>
                                    @if(
                                    ($data->status === \Bromo\Product\Models\ProductStatus::PUBLISH ) ||
                                    ($data->status === \Bromo\Product\Models\ProductStatus::UNPUBLISH ))
                                        <span class="m-switch m-switch--icon mt-3">
                                            <label>
                                                <input id="status" type="checkbox"
                                                       @if($data->status === \Bromo\Product\Models\ProductStatus::PUBLISH) checked="checked" @endif>
                                                <span></span>
                                            </label>
                                        </span>
                                    @else
                                        <span>{{ $data->productStatus->name ?? '-' }}</span>
                                    @endif
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
            'portlet_title' => sprintf("Images"),
            'body_class' => 'pt-0'])
                @slot('body')

                    @component('components._widget-list')
                        @slot('body')
                            @forelse($data->image_files_url as $image)
                                <a data-fancybox data-type="image"
                                   href="{{ $image  }}">
                                    <img class="img-thumbnail mb-2 mr-2"
                                         src="{{ $image  }}"
                                         alt=""
                                         width="128">
                                </a>
                            @empty
                                <img class="img-thumbnail mb-2 mr-2"
                                     src="{{ 'https://via.placeholder.com/480x480?text=No+Image' }}"
                                     alt=""
                                     width="128">
                            @endforelse
                        @endslot
                    @endcomponent

                @endslot

            @endcomponent

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

        <div class="col-12">
            @component('components._portlet', [
            'portlet_head' => true,
            'portlet_title' => sprintf("Variants"),
            'body_class' => 'pt-0'])
                @slot('body')

                    @component('components._widget-list')
                        @slot('body')
                            <div class="m-widget28__tab-items">

                                @isset($data->productVariants)
                                    @foreach($data->productVariants->sortBy('sort') ?? [] as $variant)
                                        <div class="m-widget28__tab-item pb-3">
                                            <div class="row">
                                                <div class="col-3" style="border-right: 1px solid #dddddd">
                                                    <ul class="m-nav">
                                                        <li class="m-nav__section m-nav__section--first">
                                                            <span class="m-nav__section-text">Variant</span>
                                                        </li>
                                                        <li class="m-nav__item mb-2">
                                                            <b class="m-nav__link-text">{{ $variant->name ?? '-' }}</b>
                                                        </li>
                                                        <li class="m-nav__section m-nav__section--first">
                                                            <span class="m-nav__section-text">SKU</span>
                                                        </li>
                                                        <li class="m-nav__item mb-2">
                                                            <b class="m-nav__link-text">{{ $variant->sku ?? '-' }}</b>
                                                        </li>
                                                        <li class="m-nav__section m-nav__section--first">
                                                            <span class="m-nav__section-text">SKU Seller</span>
                                                        </li>
                                                        <li class="m-nav__item mb-2">
                                                            <b class="m-nav__link-text">{{ $variant->seller_sku ?? '-' }}</b>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="col-9">
                                                    <div class="m-widget5">
                                                        @isset($variant->productBuyingOptions)
                                                            @foreach($variant->productBuyingOptions->sortBy('sort') as $key => $option)
                                                                <div class="m-widget5__item">
                                                                    <div class="m-widget5__content">
                                                                        <div class="m-widget5__section">
                                                                            <h4 class="m-widget5__title">
                                                                                Option-{{ $key + 1 }}</h4>
                                                                            <span class="m-widget5__desc">Margin: 0%</span>
                                                                            <div class="m-widget5__info">
                                                                                <ul class="list-inline">
                                                                                    <li class="list-inline-item">
                                                                                        <span class="m-widget5__author">Base Price : </span>
                                                                                        <span class="m-widget5__info-date m--font-info">IDR {{ number_format($option->price_comp_base) ?? 0 }}</span>
                                                                                        </br>
                                                                                        <span class="m-widget5__author">Display Price : </span>
                                                                                        <span class="m-widget5__info-date m--font-info">IDR {{ number_format($option->price) ?? 0 }}</span>
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <span class="m-widget5__author">Quantity Product : </span>
                                                                                        <span class="m-widget5__info-date m--font-info">{{ $option->unit_qty ?? 0 }} {{ $option->unit_type ?? '' }}</span>
                                                                                    </li>
                                                                                    <li class="list-inline-item">
                                                                                        <span class="m-widget5__author">Minimum : </span>
                                                                                        <span class="m-widget5__info-date m--font-info">{{ $option->qty_min ?? 0 }} {{ $option->unit_type ?? '' }}</span>
                                                                                        </br>
                                                                                        <span class="m-widget5__author">Maximum : </span>
                                                                                        <span class="m-widget5__info-date m--font-info">{{ $option->qty_max ?? 0 }} {{ $option->unit_type ?? '' }}</span>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endisset
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @endisset

                            </div>
                        @endslot
                    @endcomponent

                @endslot

            @endcomponent
        </div>

    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog"
    aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content">
           <form action="{{ route('product.status', $data->id) }}" method="POST">
               {{ csrf_field() }}
               {{ method_field('PUT') }}
               <div class="modal-header">
                   <h5 class="modal-title title">Change Status</h5>
               </div>
               <div class="modal-body">
                   <p>Are you sure change status of data?</p>
               </div>
               <div class="modal-footer">
                   <button id="cancel" type="button" class="btn btn-secondary">Cancel</button>
                   <button type="submit" class="btn btn-primary">Yes</button>
               </div>
           </form>
           </div>
       </div>
    </div>
    <!--end::Modal-->


@endsection