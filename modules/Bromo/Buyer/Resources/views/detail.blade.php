@extends('theme::layouts.master')

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->full_name),
          'url_manage' => true,
          'url_back' => route($module),
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
                                            <span>{{ $data->status_name }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>{{ __('Joined At') }}</span>
                                            <span>{{ $data->created_at_formatted }}</span>
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