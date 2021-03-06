@extends('theme::layouts.master')


@section('content')
    @canany(['view_brand','view_attribute_key','view_unit_type'])
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "List {$title}"])
        @slot('body')
            {!! $dataTable->table() !!}
        @endslot

        @slot('url')
            {{ route("{$module}.create") }}
        @endslot

        @slot('postfix')
            {{ $title }}
        @endslot
    @endcomponent
    @endcanany
@endsection

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}">
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    {!! $dataTable->scripts() !!}
@endsection
