@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendor/fancybox/jquery.fancybox.css') }}">
    <style>
        #bromo .m-widget5 .m-widget5__item .m-widget5__content:last-child {
            float: none;
        }

        #bromo .list-inline-item:not(:last-child) {
            margin-right: 5rem;
            vertical-align: top;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendor/fancybox/jquery.fancybox.js') }}"></script>
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Blacklist Phone Number"])
        @slot('body')
            @can('blacklist-user')
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <form action="{{ route('blacklist-phone-number.post-table') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="banner-title">Phone Number</label>
                            <input id="postal-code" class="form-control" type="text" name="msisdn" placeholder="Ex : +628123456789" >
                        </div>
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 6px">Submit</button>
                    </form>
                </div>
            </div>
            @endcan
        @endslot

        @slot('postfix')
            Blacklist Phone Number
        @endslot
    @endcomponent

@endsection

