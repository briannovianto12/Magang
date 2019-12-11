@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ nbs_asset('js/mustache.min.js') }}"></script>
    @include('freqaskedquestion::js-show')
@endsection

@section('content')

    @component('components._portlet', [
          'portlet_head' => true,
          'portlet_title' => sprintf("Frequently Asked Questions "),
          'url_manage' => true,
          'url_back' => url()->previous(),
          'postfix_back' => 'Back',
          'body_class' => 'pt-0'])
        @slot('body')
            @component('components._widget-list')
                @slot('body')
                    @can('edit_faq')
                    <button id="edit-faq-btn" faq-id="{{ $faq->id }}" type="button" class="btn btn-primary mb-3" style="border-radius: 6px">Edit FAQ</button>
                    @endcan
                    <div class="m-widget28__tab-items">
                        <div class="row">
                            <div class="col-12">
                                <h4>Title - {{ $faq->title }}</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5 mt-3">
                                <div class="mt-4" id="faq-question">
                                    <h4>Question</h4>
                                    {{ $faq->question }}
                                </div>
                                <div class="mt-4" id="faq-category">
                                    <h4>FAQ Category</h4>
                                    {{ $faq->category->name }}
                                </div>
                                <div class="mt-4" id="faq-accessibility">
                                    <h4>Accessible By</h4>
                                    {{ $faq->accessibility->name }}
                                </div>
                                <div class="mt-4" id="faq-tags">
                                    <h4>Tags</h4>
                                        @foreach ($faq->tags as $tag)
                                            {{ $tag }}
                                        @endforeach
                                </div>
                                <div class="mt-4" id="faq-visibility">
                                    <h4>Is Visible</h4>
                                    @if($faq->is_visible == true)
                                            <strong class="text-success">True</strong>
                                        @else
                                            <strong class="text-danger">False</strong>
                                        @endif
                                </div>
                                <div class="mt-4" id="faq-sort-by">
                                    <h4>Sort By</h4>
                                    {{ $faq->sort_by }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-5">
                                    <h4>Answer</h4>
                                    <textarea class="form-control" id="faq-answer" placeholder="{{ $faq->answer }}" rows="5" readonly></textarea>
                                </div>
                                <div class="mt-5" id="faq-attachments">
                                    <h4>Attachments</h4>
                                    <div class="mt-4">
                                        <div id="attachments" class="carousel slide">
                                            <div class="" id="slider-thumbs">
                                                <ul class="list-inline carousel-thumbnail">
                                                    @foreach($images as $key => $image)
                                                        <a href="{{ $image }}" target="_blank" id="attachment-{{ $key }}" class="{{$key == 0 ? 'selected' : '' }}">
                                                            <img src="{{ $image }}" class="img-responsive" style="max-width:200px; max-height:200px;">
                                                        </a>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>          
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>        
                @endslot
            @endcomponent
        @endslot
    @endcomponent
@endsection
