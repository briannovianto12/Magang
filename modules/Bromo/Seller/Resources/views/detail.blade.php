@extends('theme::layouts.master')

@section('scripts')
    <script src="{{ asset('vendor/qiscus/js/lib/qiscus-sdk-core.min.js') }}"></script>

    @include('store::js')
    @include('store::js-template')
    <script src="{{ mix('js/shop.js') }}"></script>
    <script src="{{ asset('js/mustache.min.js') }}"></script>
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

            <!--begin::Modal Temporary Closed-->
            <form action="{{ route("{$module}.temporary-closed", $data->id) }}" method="POST">
                {{ csrf_field() }}
                <div class="modal fade" id="modalTemporaryClosed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Temporary Closed</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="md-form">
                                    <i class="fas fa-pencil prefix grey-text"></i>
                                    <textarea type="text" name="temporary_closed_message" id="form8" class="md-textarea form-control" rows="4" required></textarea>
                                    <label data-error="wrong" data-success="right" for="form8">Temporary Closed Message</label>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button class="btn btn-unique" onclick="return confirm('Are you sure you want to temporary closed the shop?')">Submit <i class="fas fa-paper-plane-o ml-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                                    <span>{{ __('Status') }}</span>
                                    @if($data->status_name == 'Verified')
                                        @if($data->is_temporary_closed == 1)
                                            <span name="shop_status">
                                                <i class="fa fa-exclamation-triangle" style="color:#FFCC00"></i> Shop is temporarily closed
                                                <br/>
                                                    Message: {{ $data->temporary_closed_message }}
                                            </span>
                                        @else
                                            <span name="shop_status" style="color:#39b54a">
                                                {{ $data->status_name }}
                                            </span>
                                        @endif
                                    @elseif($data->status_name == '@michaelRejected')
                                        <span name="shop_status" style="color:red">
                                            {{ $data->status_name }}
                                        </span>
                                    @elseif($data->status_name == 'Registration Submitted')
                                        <span name="shop_status" style="color:blue">
                                            {{ $data->status_name }}
                                        </span>
                                    @endif
                                </div>

                                @can('store_modify')
                                    @if(in_array($data->status, [
                                            \Bromo\Seller\Models\ShopStatus::REG_SUBMITTED,
                                            \Bromo\Seller\Models\ShopStatus::SURVEY_SUBMITTED
                                        ]))
                                    <div id="approval" class="m-widget28__tab-item">
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
                                        <br/><br/>
                                    </div>
                                    @endif
                                @endcan

                                @if ($data->status === \Bromo\Seller\Models\ShopStatus::VERIFIED )
                                <div class="m-widget28__tab-item">
                                    <span>Shop Action</span>
                                    {{-- @can('view_suspend_seller')
                                    @if(
                                    ($data->status === \Bromo\Seller\Models\ShopStatus::VERIFIED ) ||
                                    ($data->status === \Bromo\Seller\Models\ShopStatus::SUSPENDED ))
                                        <span class="m-switch m-switch--icon mt-3">
                                            <label>
                                                <input id="status" type="checkbox"
                                                    @if($data->status === \Bromo\Seller\Models\ShopStatus::SUSPENDED) checked="checked" @endif>
                                                <span></span>
                                            </label>
                                        </span>
                                    @endif
                                    @endcan --}}


                                    @can('temporary_closed')
                                    @if($data->is_temporary_closed == 0 && $data->status !== \Bromo\Seller\Models\ShopStatus::SUSPENDED)
                                        <div class="m-widget28__tab-item">
                                            <button type="button" class="btn btn-warning m-btn m-btn--custom"
                                                    data-toggle="modal" data-target="#modalTemporaryClosed">
                                                    Temporary Closed
                                            </button>
                                            <br/><br/>
                                        </div>
                                    @else
                                        <div class="m-widget28__tab-item">
                                            <form method="POST" action="{{ route('store.re-open-shop', ['id' => $data->id]) }}">
                                                {!! csrf_field() !!}
                                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to re-open the shop?')">
                                                    <span> Re-open Shop</span>
                                                </button>
                                            </form>
                                            <br/><br/>
                                        </div>
                                    @endif
                                    @endcan
                                </div>
                                @endif

                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Store Name') }}</span>
                                    <span>{{ $data->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Product Category') }}</span>
                                    <span>{{ $data->product_category ?? '-' }}</span>
                                </div>


                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Account Type') }}
                                        @can('change_commission')
                                        <button onclick="_changeCommission(this, '{{ $data->id }}'); " class="btn btn-sm" style="background-color: white" >
                                            <i class="fa fa-edit"></i>
                                            Edit
                                        </button>
                                        @endcan
                                    </span>
                                    <span>{{ $data->commissionType->name ?? '-' }}</span>

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
                                    <span><img src="{{ $data->tax_image_private_url }}" alt="" width="128"></span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Tax Type') }}</span>
                                    <span>{{ $data->taxType->name ?? '-' }}</span>
                                </div>
                                <div class="m-widget28__tab-item">
                                    <span>{{ __('Created At') }}</span>
                                    <span>{{ $data->created_at_formatted }}</span>
                                </div>

                            <form action="{{ route('description.post-table', $data->id) }}" method="POST">
                                {{ csrf_field() }}
                                <div class="modal fade" id="modalDescriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h4 class="modal-title w-100 font-weight-bold">Shop Description</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mx-3">
                                                <div class="md-form">
                                                    <i class="fas fa-pencil prefix grey-text"></i>
                                                    <textarea type="text" name="description" id="message-body" class="md-textarea form-control"
                                                    placeholder="Enter Message Body" maxlength="124" rows="4"></textarea>
                                                    <span id="chars">124</span> characters remaining
                                                    <label data-error="wrong" data-success="right" for="form8">New Shop Description</label>
                                                </div>
                                                <div class="modal-footer d-flex justify-content-center">
                                                    <button class="btn btn-unique" >Submit <i class="fas fa-paper-plane-o ml-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @can('change_shop_description')
                            <div class="m-widget28__tab-item">
                                <span>{{ __('Shop Description') }}
                                    <a href="" method="post"  class="la la-edit" data-toggle="modal" data-target="#modalDescriptionForm"></a>
                                </span>
                                <span style='white-space: pre-wrap;'>{{ $data->description ?? '-' }}</span>
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
                                        <span style='white-space: pre-wrap;'>{{ $data->business->description ?? '-' }}</span>
                                    </div>
                                    <div class="m-widget28__tab-item">
                                        <span>
                                            {{ __('Business Address') }}
                                            <button id="cpy-btn" class="btn btn-sm" style="background-color: white">
                                                <i class="fa fa-clone"></i>
                                                Copy
                                            </button>
                                            @can('change_address')
                                                <button onclick="_changeAddress(this, '{{ $data->id }}'); " class="btn btn-sm" style="background-color: white" >
                                                    <i class="fa fa-edit"></i>
                                                    Edit
                                                </button>
                                            @endcan
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
                                            <img src="{{ $data->tax_image_private_url }}" alt="" width="128">
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
            @can('view_seller_courier_mapping')
            <li class="nav-item m-tabs__item">
                <a class="nav-link m-tabs__link" data-toggle="tab" href="#courier_mapping" role="tab">
                    Courier Mappings
                </a>
            </li>
            @endcan
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

            <div class="tab-pane" id="courier_mapping">
                @component('components._widget-list')
                @can('view_seller_courier_mapping')
                    @slot('body')
                        @if($data->business->custom_courier_mapping)
                            <div class="row">
                                <div class="col-12 text-left">
                                    <button onclick="_sellerCourierMapping(this, '{{ $data->id }}'); " class="btn btn-primary">
                                        Edit
                                    </button>&nbsp;&nbsp;
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12 text-left">
                                    <span>
                                        <i class="fa fa-exclamation-triangle" style="color:#FFCC00"></i> Custom Shipping Courier For This Seller is disabled
                                    </span>
                                    <br/><br/>
                                </div>
                            </div>
                        @endif

                        @isset($data->courier_list)
                        <br/>
                        @foreach($data->courier_list->chunk(3) as $couriers)
                            <div class="row course-set courses__row">
                                @foreach($couriers as $courier)
                                    <article class="col-md-4 course-block course-block-lessons">
                                        {{-- {{ $courier->shippingCourier->name }} --}}
                                        {{-- <div class="m-widget28__tab-items"> --}}
                                        <label class="badge label-primary" style ="font-size:15px" for="{{ $courier->shippingCourier->id }}"> {{ $courier->shippingCourier->name }}</label><br>
                                        {{-- </div> --}}
                                    </article>
                                @endforeach
                            </div>
                        @endforeach
                        @endisset
                    @endslot
                    @endcan
                @endcomponent
            </div>


        @endslot
    @endcomponent

    <div class="modal fade" id="modal" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog">
       <div class="modal-content">
           <form action="{{ route('store.status', $data->id) }}" method="POST">
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

    {{-- <div class="modal fade" role="dialog" id="comment-modal-{{ $posts->id }}"> --}}
    <div class="modal fade" id="modalAddressForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>

                <div class="modal-body">

                </div>


            </div>
        </div>
    </div>
@endsection
