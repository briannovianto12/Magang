@extends('theme::layouts.master')

@section('scripts')
    <script src="{{ asset('vendor/qiscus/js/lib/qiscus-sdk-core.min.js') }}"></script>

    @include('store::js')
@endsection

@section('content')

    @component('components._portlet', [
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->name),
          'url_manage' => true,
          'url_back' => url()->previous(),
          'postfix_back' => 'Back',
          'body_class' => 'pt-0'])
        @slot('body')

            <!--begin::Modal-->
            <div class="modal fade" id="verify" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route("{$module}.verify", $data->id) ?? '#' }}" method="POST">
                            {{ csrf_field() }}

                            <input name="jwt-route" type="text" value="{{ route('store.token') }}" hidden>
                            <div class="modal-header">
                                <h5 class="modal-title title">{{ __('Verify Seller') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">Are you sure??</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button name="submit" type="button" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Modal-->

            <!--begin::Modal-->
            <div class="modal fade" id="reject" tabindex="-1" role="dialog"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route("{$module}.reject", $data->id) ?? '#' }}" method="POST">
                            {{ csrf_field() }}
                            <div class="modal-header">
                                <h5 class="modal-title title">{{ __('Reject Seller') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea name="notes" id="" cols="30" rows="10" class="form-control"
                                          placeholder="Type here reason..."></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button name="submit" type="button" class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Modal-->

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
                                    <span>{{ __('Shop Contact Person') }}</span>
                                    <span>{{ $data->businessAddress->contact_person ?? '-'}}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Shop Email') }}</span>
                                    <span>{{ $data->contact_email ?? '-'}}</span>
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
                                    <span>{{ __('Tax Type') }}</span>
                                    <span>{{ $data->taxType->name ?? '-' }}</span>

                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Status') }}</span>
                                    @if($data->status_name == 'Verified')
                                        <span name="shop_status" style="color:#39b54a">
                                            {{ $data->status_name }}
                                        </span>
                                    @elseif($data->status_name == 'Rejected')
                                        <span name="shop_status" style="color:red">
                                            {{ $data->status_name }}
                                        </span>
                                    @elseif($data->status_name == 'Registration Submitted')
                                        <span name="shop_status" style="color:blue">
                                            {{ $data->status_name }}
                                        </span>
                                    @endif
                                    
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Created At') }}</span>
                                    <span>{{ $data->created_at_formatted }}</span>
                                </div>
                                @can('store_modify')
                                <div id="approval" class="m-widget28__tab-item">
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
                                @endcan
                            </div>
                        </div>
                        @isset($data->business)
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Bank Account') }}</span>
                                        <span>  
                                            @foreach($business_bank_account as $bank_account)
                                                    
                                                    {!! $bank_account->account_no
                                                    .' - '
                                                    .$bank_account->bank_name !!}
                                                    {{-- TODO Change to new screen to verify bank account --}}
                                                    {{-- 
                                                    @can('verify_bank_account')
                                                        @if($bank_account->is_verified == false)
                                                            <a href="#" onclick='_verifyBank("{{ route("{$module}.verify-bank-account", $bank_account->id) }}")'
                                                                class="badge badge-pill badge-primary verify-bank">
                                                                Verify
                                                            </a>
                                                        @elseif($bank_account->is_verified == true)
                                                            <span class="badge badge-pill badge-success">
                                                                Verified
                                                                <br/>
                                                            </span>
                                                        @endif
                                                    @endcan                                                     
                                                    --}}                                                  
                                                    {!!'<br>'
                                                    .$bank_account->account_owner_name.'<br><br>' ?? '-'!!} 
                                            @endforeach
                                        </span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Owner') }}</span>
                                        <span>{{ $owner->full_name ?? '-'}}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Owner Phone') }}</span>
                                        <span>{{ $owner->msisdn ?? '-'}}</span>
                                    </div>
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
                                        <span>
                                            {{ __('Business Address') }}
                                            <button id="cpy-btn" class="btn btn-sm" style="background-color: white">
                                                <i class="fa fa-clone"></i>
                                                Copy
                                            </button>
                                        </span>
                                        <span id="business-address">
                                                {!! nl2br($data->businessAddress->address_line
                                                ."\n"
                                                ."Kel. ".$data->businessAddress->subdistrict
                                                .", "
                                                ."Kec. ".$data->businessAddress->district 
                                                ."\n"
                                                .$data->businessAddress->city 
                                                .", "
                                                .$data->businessAddress->province 
                                                .", "
                                                .$data->businessAddress->postal_code)
                                                ?? '-'!!}
                                        </span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Tag') }}</span>
                                        <span>{{ $data->business->tag ?? '-'}}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Status') }}</span>
                                        <span>
                                                {{ $data->business->status_name ?? '-' }}
                                        </span>
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
                            <div class="col-6">
                                <div class="m-widget28__tab-items">
                                    <div class="m-widget28__tab-item">
                                        <span>{{ __('Business Address') }}</span>
                                        <span>{!! $data->businessAddress->building_name
                                                ."<br>"."<br>"
                                                .$data->businessAddress->address_line
                                                ."<br>"
                                                ."Kel. ".$data->businessAddress->subdistrict
                                                .", "
                                                ."Kec. ".$data->businessAddress->district 
                                                ."<br>"
                                                .$data->businessAddress->city 
                                                .", "
                                                .$data->businessAddress->province 
                                                .", Indonesia "
                                                ."<br>"
                                                .$data->businessAddress->postal_code
                                                ?? '-'!!}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                            <span>{{ $data->businessBankAccount->account_no }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Owner Name') }}</span>
                                            <span>{{ $data->businessBankAccount->account_owner_name }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Bank Name') }}</span>
                                            <span>{{ $bankAccount->bank_name ?? '-'}}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Created') }}</span>
                                            <span>{{ $data->businessBankAccount->created_at_formatted ?? '-' }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Updated') }}</span>
                                            <span>{{ $data->businessBankAccount->updated_at_formatted ?? '-' }}</span>
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