@extends('theme::layouts.master')

@section('content')
    <!--begin:: Widgets/Stats-->
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Profit-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Profit
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Profit Value
				            </span>
                            <span class="m-widget24__stats m--font-brand">
				                180.000
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Profit-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Buyer-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Buyer
                            </h4><br>
                            <span class="m-widget24__desc">
				                Customer Review
				            </span>
                            <span class="m-widget24__stats m--font-info">
				                1349
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
                    <!--end::Total Buyer-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Order-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Order
                            </h4><br>
                            <span class="m-widget24__desc">
				                All Order Amount
				            </span>
                            <span class="m-widget24__stats m--font-danger">
				                567
				            </span>
                            <div class="m--space-10"></div>
                            <div class="progress m-progress--sm">
                                <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;"
                                     aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="m-widget24__change">
                            </span>
                            <span class="m-widget24__number">
                            </span>
                        </div>
                    </div>
                    <!--end::Total Order-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::Total Seller-->
                    <div class="m-widget24">
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
                    </div>
                    <!--end::Total Seller-->
                </div>
            </div>
        </div>
    </div>
    <!--end:: Widgets/Stats-->

    <div class="row">
        <div class="col-xl-4">
            <!--begin:: Widgets/Top Products-->
            <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Trends
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                m-dropdown-toggle="hover" aria-expanded="true">
                                <a href="#"
                                   class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                    All
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                          style="left: auto; right: 36.5px;"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav">
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">Activity</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                            <span class="m-nav__link-text">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-info"></i>
                                                            <span class="m-nav__link-text">FAQ</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                            <span class="m-nav__link-text">Support</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin::Widget5-->
                    <div class="m-widget4">
                        <div class="m-widget4__chart m-portlet-fit--sides m--margin-top-10 m--margin-top-20"
                             style="height:260px;">
                            <canvas id="m_chart_trends_stats"></canvas>
                        </div>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="./themes/app/media/img/client-logos/logo3.png" alt="">
                            </div>
                            <div class="m-widget4__info">
					<span class="m-widget4__title">
					    Phyton
					</span><br>
                                <span class="m-widget4__sub">
					    A Programming Language
					</span>
                            </div>
                            <span class="m-widget4__ext">
					    <span class="m-widget4__number m--font-danger">+$17</span>
				    </span>
                        </div>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="./themes/app/media/img/client-logos/logo1.png" alt="">
                            </div>
                            <div class="m-widget4__info">
					<span class="m-widget4__title">
					    FlyThemes
					</span><br>
                                <span class="m-widget4__sub">
					        A Let's Fly Fast Again Language
					</span>
                            </div>
                            <span class="m-widget4__ext">
					    <span class="m-widget4__number m--font-danger">+$300</span>
				    </span>
                        </div>
                        <div class="m-widget4__item">
                            <div class="m-widget4__img m-widget4__img--logo">
                                <img src="./themes/app/media/img/client-logos/logo2.png" alt="">
                            </div>
                            <div class="m-widget4__info">
					<span class="m-widget4__title">
					AirApp
					</span><br>
                                <span class="m-widget4__sub">
					Awesome App For Project Management
					</span>
                            </div>
                            <span class="m-widget4__ext">
					<span class="m-widget4__number m--font-danger">+$6700</span>
				</span>
                        </div>
                    </div>
                    <!--end::Widget 5-->
                </div>
            </div>
            <!--end:: Widgets/Top Products-->
        </div>
        <div class="col-xl-8">
            <!--begin:: Widgets/User Progress -->
            <div class="m-portlet m-portlet--full-height ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Request for Seller Approval
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_widget4_tab1_content">
                            <div class="m-widget4 m-widget4--progress">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--pic">
                                        <img src="./themes/app/media/img/users/100_4.jpg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
							<span class="m-widget4__title">
							Anna Strong
							</span><br>
                                        <span class="m-widget4__sub">
							Visual Designer,Google Inc
							</span>
                                    </div>
                                    <div class="m-widget4__progress">
                                        <div class="m-widget4__progress-wrapper">
                                            <span class="m-widget17__progress-number">63%</span>
                                            <span class="m-widget17__progress-label">London</span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 63%;" aria-valuenow="25" aria-valuemin="0"
                                                     aria-valuemax="63"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <div class="btn-group">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item" type="button">Approve</button>
                                                <button class="dropdown-item" type="button">Reject</button>
                                                <button class="dropdown-item" type="button">Others</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--pic">
                                        <img src="./themes/app/media/img/users/100_14.jpg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
							<span class="m-widget4__title">
							Milano Esco
							</span><br>
                                        <span class="m-widget4__sub">
							Product Designer, Apple Inc
							</span>
                                    </div>
                                    <div class="m-widget4__progress">
                                        <div class="m-widget4__progress-wrapper">
                                            <span class="m-widget17__progress-number">33%</span>
                                            <span class="m-widget17__progress-label">Paris</span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                     style="width: 33%;" aria-valuenow="45" aria-valuemin="0"
                                                     aria-valuemax="33"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <div class="btn-group">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item" type="button">Approve</button>
                                                <button class="dropdown-item" type="button">Reject</button>
                                                <button class="dropdown-item" type="button">Others</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--pic">
                                        <img src="./themes/app/media/img/users/100_11.jpg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
							<span class="m-widget4__title">
							Nick Bold
							</span><br>
                                        <span class="m-widget4__sub">
							Web Developer, Facebook Inc
							</span>
                                    </div>
                                    <div class="m-widget4__progress">
                                        <div class="m-widget4__progress-wrapper">
                                            <span class="m-widget17__progress-number">13%</span>
                                            <span class="m-widget17__progress-label">London</span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar bg-brand" role="progressbar"
                                                     style="width: 13%;" aria-valuenow="65" aria-valuemin="0"
                                                     aria-valuemax="13"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <div class="btn-group">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item" type="button">Approve</button>
                                                <button class="dropdown-item" type="button">Reject</button>
                                                <button class="dropdown-item" type="button">Others</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--pic">
                                        <img src="./themes/app/media/img/users/100_1.jpg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
							<span class="m-widget4__title">
							Wiltor Delton
							</span><br>
                                        <span class="m-widget4__sub">
							Project Manager, Amazon Inc
							</span>
                                    </div>
                                    <div class="m-widget4__progress">
                                        <div class="m-widget4__progress-wrapper">
                                            <span class="m-widget17__progress-number">93%</span>
                                            <span class="m-widget17__progress-label">New York</span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar bg-danger" role="progressbar"
                                                     style="width: 93%;" aria-valuenow="25" aria-valuemin="0"
                                                     aria-valuemax="93"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <div class="btn-group">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item" type="button">Approve</button>
                                                <button class="dropdown-item" type="button">Reject</button>
                                                <button class="dropdown-item" type="button">Others</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--pic">
                                        <img src="./themes/app/media/img/users/100_6.jpg" alt="">
                                    </div>
                                    <div class="m-widget4__info">
							<span class="m-widget4__title">
							Sam Stone
							</span><br>
                                        <span class="m-widget4__sub">
							Project Manager, Kilpo Inc
							</span>
                                    </div>
                                    <div class="m-widget4__progress">
                                        <div class="m-widget4__progress-wrapper">
                                            <span class="m-widget17__progress-number">50%</span>
                                            <span class="m-widget17__progress-label">New York</span>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                     style="width: 50%;" aria-valuenow="50" aria-valuemin="0"
                                                     aria-valuemax="50"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="m-widget4__ext">
                                        <div class="btn-group">
                                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <button class="dropdown-item" type="button">Approve</button>
                                                <button class="dropdown-item" type="button">Reject</button>
                                                <button class="dropdown-item" type="button">Others</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="m_widget4_tab2_content">
                        </div>
                        <div class="tab-pane" id="m_widget4_tab3_content">
                        </div>
                    </div>
                </div>
            </div>
            <!--end:: Widgets/User Progress -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="m-portlet">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-xl">
                        <div class="col-xl-4">
                            <!--begin:: Widgets/Daily Sales-->
                            <div class="m-widget14">
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
                            </div>
                            <!--end:: Widgets/Daily Sales-->            </div>
                        <div class="col-xl-4">
                            <!--begin:: Widgets/Profit Share-->
                            <div class="m-widget14">
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
                            </div>
                            <!--end:: Widgets/Profit Share-->            </div>
                        <div class="col-xl-4">
                            <!--begin:: Widgets/Revenue Change-->
                            <div class="m-widget14">
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
                            </div>
                            <!--end:: Widgets/Revenue Change-->            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('themes/app/js/dashboard.js') }}"></script>
@endsection