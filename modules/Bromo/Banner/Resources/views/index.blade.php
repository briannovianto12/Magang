@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    @include('banner::js')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Banner Parts"])
        @slot('body')
            <div class="m-portlet__body">
                <button id="new-banner-btn" type="button" class="btn btn-primary mb-3" style="border-radius: 6px">+Add new Banner</button>
                {{-- <button id="new-faq-cat-btn" type="button" class="btn btn-primary mb-3" style="border-radius: 6px">+Add new FAQ Category</button> --}}
            </div>
        @endslot

        @slot('postfix')
            Banner
        @endslot
    @endcomponent

@endsection