@extends('theme::layouts.master')

@section('content')
    <!--begin:: Widgets/Stats-->
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Registrated Seller-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Registered Seller
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Registered Seller
				            </span>
                            <span class="m-widget24__stats m--font-info">
				                {{$summary['total_registered_seller']}}
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Registrated Seller-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Total Seller With Product-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Seller With Product
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Seller with Product
				            </span>
                            <span class="m-widget24__stats m--font-info">
                            {{$summary['total_registered_seller_with_product']}}
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Seller With Product-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Total User-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total User
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Buyers and Sellers
				            </span>
                            <span class="m-widget24__stats m--font-info">
                            {{$summary['total_registered_user']}}   
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total User-->
                </div>
            </div>
        </div>
    </div>

    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Registered SKU-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Registered SKU
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Registered SKU
				            </span>
                            <span class="m-widget24__stats m--font-info">
                            {{$summary['total_registered_sku']}}   
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Registered SKU-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Published SKU-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Published SKU
                            </h4><br>
                            <span class="m-widget24__desc">
                                All Published SKU
				            </span>
                            <span class="m-widget24__stats m--font-info">
                            {{$summary['total_published_sku']}}   
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Published SKU-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Unpublished SKU-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Unpublished SKU
                            </h4><br>
                            <span class="m-widget24__desc">
                                All Unpublished SKU
				            </span>
                            <span class="m-widget24__stats m--font-info">
                            {{$summary['total_unpublished_sku']}}   
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Unpublished SKU-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('themes/app/js/dashboard.js') }}"></script>
@endsection