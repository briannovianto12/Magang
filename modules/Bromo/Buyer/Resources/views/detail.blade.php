@extends('theme::layouts.master')

@section('scripts')
    @include('buyer::js')
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->full_name),
          'url_manage' => true,
          'url_back' => url()->previous(),
          'postfix_back' => 'Back',
          'body_class' => 'pt-0'])
        @slot('body')
            <div class="m-widget28">
                <div class="m-widget28__container">
                    <div class="m-widget28__tab tab-content">
                        <div class="m-widget28__tab-container tab-pane active">
                            <div class="row">
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Avatar') }}</span>
                                            <span><img src="{{ $data->avatar_url }}" alt="" width="128"></span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('ID') }}</span>
                                            <span>{{ $data->id }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Full Name') }}</span>
                                            <span>{{ $data->full_name }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Phone number') }}</span>
                                            <span>{{ $data->msisdn }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Status') }}</span>
                                            @if($data->status == Bromo\Buyer\Entities\UserStatus::BLOCKED)
                                                <span style="color:#e54444">
                                                    <i class="fa fa-exclamation-triangle"></i>&nbsp; {{ $data->status_name }} 
                                                </span>
                                                {{-- <span class="badge badge-danger"> <a style="color: white;">{{ $data->status_name }} </a></span> --}}
                                            @else
                                                <span>{{ $data->status_name }}</span>
                                            @endif
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Joined At') }}</span>
                                            <span>{{ $data->created_at_formatted }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Total Spending') }}</span>
                                            <span>IDR {{ number_format($total_spending, 0, 0, '.') ?? 0}}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Last 10 Orders') }}</span>
                                            <span>
                                                @foreach($last_ten_orders as $order)
                                                    <a href="{{ url('/order/'.$order->id) }}">
                                                        {!! $order->order_no."<br>" !!}
                                                    </a>
                                                @endforeach
                                                </a>
                                            </span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Business Bank Account') }}</span>
                                            <span>
                                                @foreach($business_bank_accounts as $business_bank_account)
                                                    @if($business_bank_account->is_default == true)
                                                        <h5>Default Bank Account:</h5>
                                                    @endif
                                                    {!! $business_bank_account->account_no
                                                    ." - "
                                                    .$business_bank_account->account_owner_name
                                                    ."<br>"
                                                    .$business_bank_account->bank_name."<br>"."<br>"!!}
                                                @endforeach
                                            </span>
                                        </div>
                                        <br>
                                       
                                        @can('view_blacklist_user')
                                            <div class="d-flex flex-column justify-content-center">
                                            <div class="row">
                                                <div class ="col-6">
                                                    @if($blacklist_status == false)
                                                        <a href="{{ route('buyer.blacklist',['id' => $data->id]) }}" onclick="return confirm('Are you sure you want to blacklist this user?')" class="btn btn-danger" role="alert">
                                                            BLACKLIST!
                                                        </a>
                                                        <br/><br/>
                                                    @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                                @isset($data->business)
                                    <div class="col-6">
                                        <div class="m-widget28__tab-items">
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Name') }}</span>
                                                <span>{{ $data->business->name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Description') }}</span>
                                                <span>{{ $data->business->description ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>
                                                    {{ __('Default Business Address') }}
                                                    <button id="cpy-btn" class="btn btn-sm" style="background-color: white">
                                                        <i class="fa fa-clone"></i>
                                                        Copy
                                                    </button>
                                                </span>
                                                @if($business_addresses)
                                                    <span id="business-address">
                                                        @foreach($business_addresses as $business_address)
                                                            @if($business_address->is_default == true)
                                                                {!! nl2br($business_address->address_line 
                                                                ."\n"
                                                                .$business_address->subdistrict
                                                                .', '.$business_address->district
                                                                ."\n"
                                                                .$business_address->city
                                                                .', '.$business_address->province
                                                                .' '.$business_address->postal_code) !!}
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>
                                                    {{ __('Business Address') }}
                                                </span>
                                                @if($business_addresses)
                                                    <span id="business-address">
                                                        @foreach($business_addresses as $business_address)
                                                            @if($business_address->is_default == false)
                                                                {!! nl2br($business_address->address_line 
                                                                ."\n"
                                                                .$business_address->subdistrict
                                                                .', '.$business_address->district
                                                                ."\n"
                                                                .$business_address->city
                                                                .', '.$business_address->province
                                                                .' '.$business_address->postal_code) !!}
                                                                <br>
                                                                <br>
                                                            @endif
                                                        @endforeach
                                                    </span>
                                                @else
                                                    <span>
                                                        -
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Tag') }}</span>
                                                <span>{{ $data->business->tag ?? '-'}}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Logo') }}</span>
                                                <span><img src="{{ $data->business->logo_url }}" alt=""
                                                           width="128"></span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Tax No') }}</span>
                                                <span>{{ $data->business->tax_no ?? '-'}}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Tax Image') }}</span>
                                                <span>
                                                    <img src="{{ $data->business->tax_image_url }}" alt="" width="128">
                                                </span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Status') }}</span>
                                                <span>{{ $data->business->status_name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Member Status') }}</span>
                                                <span>{{ $data->business->pivot->status_name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Member Role') }}</span>
                                                <span>{{ $data->business->pivot->role_name ?? '-' }}</span>
                                            </div>
                                            <div class="m-widget28__tab-item">
                                                <span>{{ __('Business Member Joined At') }}</span>
                                                <span>{{ $data->business->pivot->joined_at_formatted ?? '-' }}</span>
                                            </div>
                                   
                                        </div>
                                    </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endslot

        @slot('postfix')
            {{ $title }}
        @endslot
    @endcomponent

@endsection