@extends('theme::layouts.master')

@section('content')

    @component('components.modals.basic', [
        'modalId' => 'verify',
        'method' => 'POST',
        'route' => route("{$module}.verify", $data->id),
        'title' => __('Verify Seller'),
        'body' => 'Are you sure ?'
    ])
    @endcomponent

    @component('components.modals.basic', [
        'modalId' => 'reject',
        'method' => 'POST',
        'route' => route("{$module}.reject", $data->id),
        'title' => __('Reject Seller'),
        'body' => ['textarea' => ['name' => 'notes']],
    ])
    @endcomponent

    @component('components._portlet', [
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->name),
          'url_manage' => true,
          'url_back' => route($module),
          'postfix_back' => 'Back',
          'body_class' => 'pt-0'])
        @slot('body')

            @component('components._widget-list')
                @slot('body')
                    <div class="row">
                        <div class="col-6">
                            <div class="m-widget28__tab-items">
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Store ID') }}</span>
                                    <span>{{ $data->id }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Store Name') }}</span>
                                    <span>{{ $data->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Product Category') }}</span>
                                    <span>{{ $data->product_category ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Tax No') }}</span>
                                    <span>{{ $data->tax_no ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Tax Image') }}</span>
                                    <span><img src="{{ $data->tax_image_url }}" alt="" width="128"></span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Status') }}</span>
                                    <span>{{ $data->status_name }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Created At') }}</span>
                                    <span>{{ $data->created_at_formatted }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    @if(in_array($data->status, [
                                        \Bromo\Seller\Models\ShopStatus::REG_SUBMITTED,
                                        \Bromo\Seller\Models\ShopStatus::SURVEY_SUBMITTED
                                    ]))
                                        <button type="button" class="btn btn-success m-btn m-btn--custom"
                                                data-toggle="modal" data-target="#verify"
                                                data-route="{{ route("{$module}.verify", $data->id) }}">
                                            Verify
                                        </button>
                                        <button type="button" class="btn btn-danger m-btn m-btn--custom"
                                                data-toggle="modal" data-target="#reject"
                                                data-route="{{ route("{$module}.reject", $data->id) }}">
                                            Reject
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @isset($data->business)
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Logo') }}</span>
                                        <span><img src="{{ $data->business->logo_url }}" alt=""
                                                   width="128"></span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Name') }}</span>
                                        <span>{{ $data->business->name ?? '-' }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Description') }}</span>
                                        <span>{{ $data->business->description ?? '-' }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Tag') }}</span>
                                        <span>{{ $data->business->tag ?? '-'}}</span>
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
                                        <span>{{ __('Postal Code') }}</span>
                                        <span>{{ $data->business->postal_code ?? '-'}}</span>
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
                @endslot
            @endcomponent

        @endslot

        @slot('postfix')
            {{ $title }}
        @endslot
    @endcomponent

    @component('components._portlet-tab', ['body_class' => 'pt-0'])
        @slot('tab_head')
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link active" data-toggle="tab" href="#address" role="tab">
                    Address
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#bank_account" role="tab">
                    Bank Account
                </a>
            </li>
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#survey" role="tab">
                    Survey
                </a>
            </li>
        @endslot

        @slot('tab_body')
            <div class="tab-pane active" id="address">
                @component('components._widget-list')
                    @slot('body')
                        <div class="row">
                            @isset($data->businessAddress)
                                @php
                                    $address = $data->businessAddress;
                                @endphp
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Building Name') }}</span>
                                            <span>{{ $address->building_name }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Address Line') }}</span>
                                            <span>{{ $address->address_line }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Address Notes') }}</span>
                                            <span>{{ $address->notes ?? '-'}}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Province Name') }}</span>
                                            <span>{{ $address->province ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('City') }}</span>
                                            <span> {{ $address->city_type }} {{ $address->city }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('District Name') }}</span>
                                            <span>{{ $address->district ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Subdistrict Name') }}</span>
                                            <span>{{ $address->subdistrict ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Postal Code') }}</span>
                                            <span>{{ $address->postal_code ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    @endslot
                @endcomponent
            </div>
            <div class="tab-pane" id="bank_account">
                @component('components._widget-list')
                    @slot('body')
                        <div class="row">
                            @isset($data->businessBankAccount)
                                @php
                                    $bankAccount = $data->businessBankAccount;
                                @endphp
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Account No') }}</span>
                                            <span>{{ $bankAccount->account_no }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Owner Name') }}</span>
                                            <span>{{ $bankAccount->account_owner_name }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Bank Name') }}</span>
                                            <span>{{ $bankAccount->bank_name ?? '-'}}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Created') }}</span>
                                            <span>{{ $bankAccount->created_at_formatted ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Updated') }}</span>
                                            <span>{{ $bankAccount->updated_at_formatted ?? '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endisset
                        </div>
                    @endslot
                @endcomponent
            </div>

            <div class="tab-pane" id="survey">
                @component('components._widget-list')
                    @slot('body')
                        <div class="row">
                            @isset($data->survey)
                                @php
                                    $surveys = $data->survey->result['questions'] ?? null;
                                @endphp
                                <div class="col-6">
                                    <div class="m-widget28__tab-items">
                                        @isset($surveys)
                                            @foreach($surveys as $survey)
                                                <div class="m-widget28__tab-item">
                                                    <span>Question : {{ $survey['title'] }}</span>
                                                    <span>Answer :  {{ $survey['answer'] }}</span>
                                                </div>
                                            @endforeach
                                        @endisset
                                    </div>
                                </div>
                            @endisset
                        </div>
                    @endslot
                @endcomponent
            </div>
        @endslot
    @endcomponent

@endsection