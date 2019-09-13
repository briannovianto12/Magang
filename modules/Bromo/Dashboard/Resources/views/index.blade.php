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
                    
                <!-- </div>
                <div class="col-md-12 col-lg-6 col-xl-3"> -->
                    <!--begin::Total Seller-->
                    <!-- <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Seller
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Seller
				            </span>
                            <span class="m-widget24__stats m--font-success">
				                276
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-success" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                            </span>
                        </div>
                    </div> -->
                    <!--end::Total Seller-->
                <!-- </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-xl">
                        <div class="col-xl-4"> -->
                            <!--begin:: Widgets/Daily Sales-->
                            <!-- <div class="m-widget14">
                                <div class="m-widget14__header m--margin-bottom-30">
                                    <h3 class="m-widget14__title">
                                        Daily Sales
                                    </h3>
                                    <span class="m-widget14__desc">
		Check out each collumn for more details
		</span>
                                </div>
                                <div class="m-widget14__chart" style="height:120px;">
                                    <canvas id="m_chart_daily_sales"></canvas>
                                </div>
                            </div> -->
                            <!-- end:: Widgets/Daily Sales            </div> -->
                        <!-- <div class="col-xl-4"> -->
                            <!--begin:: Widgets/Profit Share-->
                            <!-- <div class="m-widget14">
                                <div class="m-widget14__header">
                                    <h3 class="m-widget14__title">
                                        Profit Share
                                    </h3>
                                    <span class="m-widget14__desc">
		Profit Share between customers
		</span>
                                </div>
                                <div class="row  align-items-center">
                                    <div class="col">
                                        <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">
                                            <div class="m-widget14__stat">45</div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="m-widget14__legends">
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-accent"></span>
                                                <span class="m-widget14__legend-text">37% Sport Tickets</span>
                                            </div>
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-warning"></span>
                                                <span class="m-widget14__legend-text">47% Business Events</span>
                                            </div>
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-brand"></span>
                                                <span class="m-widget14__legend-text">19% Others</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end:: Widgets/Profit Share            </div> -->
                        <!-- <div class="col-xl-4"> -->
                            <!--begin:: Widgets/Revenue Change-->
                            <!-- <div class="m-widget14">
                                <div class="m-widget14__header">
                                    <h3 class="m-widget14__title">
                                        Revenue Change
                                    </h3>
                                    <span class="m-widget14__desc">
			Revenue change breakdown by cities
		</span>
                                </div>
                                <div class="row  align-items-center">
                                    <div class="col">
                                        <div id="m_chart_revenue_change" class="m-widget14__chart1"
                                             style="height: 180px">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="m-widget14__legends">
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-accent"></span>
                                                <span class="m-widget14__legend-text">+10% New York</span>
                                            </div>
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-warning"></span>
                                                <span class="m-widget14__legend-text">-7% London</span>
                                            </div>
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-brand"></span>
                                                <span class="m-widget14__legend-text">+20% California</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <!-- end:: Widgets/Revenue Change            </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('themes/app/js/dashboard.js') }}"></script>
@endsection