@extends('theme::layouts.master')

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => sprintf("Detail %s: %s", $title, $data->name),
          'url_manage' => true,
          'url_back' => route($module),
          'postfix_back' => __('Back'),
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
                                            <span>ID</span>
                                            <span>{{ $data->id }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>Name</span>
                                            <span>{{ $data->name }}</span>
                                        </div>
                                        <div class="m-widget28__tab-item">
                                            <span>Updated At</span>
                                            <span>{{ $data->updated_at_formatted }}</span>
                                        </div>
                                    </div>
                                </div>
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