@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "List {$title}"])
        @slot('body')
            @can('view_buyer')
                {!! $dataTable->table() !!}
            @endcan
        @endslot

        @slot('postfix')
            {{ $title }}
        @endslot
    @endcomponent

@endsection