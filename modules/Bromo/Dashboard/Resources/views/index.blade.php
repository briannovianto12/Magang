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

    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr style="text-align: right">
                                <th scope="col" style="text-align: left">Order Status</th>
                                <th scope="col">Total Last Month</th>
                                <th scope="col">Total Gross Last Month</th>
                                <th scope="col">Total This Month</th>
                                <th scope="col">Total Gross This Month</th>
                                <th scope="col">Total D-1 until D-8</th>
                                <th scope="col">Total Gross D-1 until D-8</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order_statistics as $order_statistic)
                                <tr style="text-align: right">
                                    @if($order_statistic->status == 1)
                                        <td style="text-align: left">Placed</td>
                                    @elseif($order_statistic->status == 2)
                                        <td style="text-align: left">Accepted</td>
                                    @elseif($order_statistic->status == 5)
                                        <td style="text-align: left">Payment OK</td>
                                    @elseif($order_statistic->status == 8)
                                        <td style="text-align: left">Shipped</td>
                                    @elseif($order_statistic->status == 9)
                                        <td style="text-align: left">Delivered</td>
                                    @elseif($order_statistic->status == 10)
                                        <td style="text-align: left">Success</td>
                                    @elseif($order_statistic->status == 30)
                                        <td style="text-align: left">Canceled</td>
                                    @elseif($order_statistic->status == 31)
                                        <td style="text-align: left">Rejected</td>
                                    @elseif($order_statistic->status == 99)
                                        <td style="text-align: left"><b>Accepted + Payment OK +<br/> 
                                          Shipped + Delivered + Success</b></td>
                                    @else
                                        <td style="text-align: left">{{ $order_statistic->status ?? '-' }}</td>
                                    @endif
                                    @if($order_statistic->status == 99)
                                    <td><b>{{ $order_statistic->count_last_month }}</b></td>
                                    <td><b>IDR {{ number_format($order_statistic->amount_last_month, 0, 0, '.') }}</b></td>
                                    <td><b>{{ $order_statistic->this_month }}</b></td>
                                    <td><b>IDR {{ number_format($order_statistic->amount_this_month, 0, 0, '.') }}</b></td>
                                    <td><b>{{ $order_statistic->last_seven_days }}</b></td>
                                    <td><b>IDR {{ number_format($order_statistic->amount_last_seven_days, 0, 0, '.') }}</b></td>
                                    @else
                                    <td>{{ $order_statistic->count_last_month }}</td>
                                    <td>IDR {{ number_format($order_statistic->amount_last_month, 0, 0, '.') }}</td>
                                    <td>{{ $order_statistic->this_month }}</td>
                                    <td>IDR {{ number_format($order_statistic->amount_this_month, 0, 0, '.') }}</td>
                                    <td>{{ $order_statistic->last_seven_days }}</td>
                                    <td>IDR {{ number_format($order_statistic->amount_last_seven_days, 0, 0, '.') }}</td>
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('themes/app/js/dashboard.js') }}"></script>
@endsection