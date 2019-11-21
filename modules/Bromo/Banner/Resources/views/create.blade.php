@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    @include('banner::js-create')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Add New Banner"])
        @slot('body')
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center">
                        <form action="{{ route('banner.store') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="banner-title">Title</label>
                                <input name="title" type="text" class="form-control" id="banner-title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="banner-image">Image</label>
                                <input name="image" type="file" class="form-control-file" id="banner-image">
                            </div>
                            <div class="form-group">
                                <label for="banner-location">Location</label>
                                <select name="location" class="form-control" id="banner-location">
                                    @isset($locations)
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>    
                                        @endforeach
                                    @endisset  
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="banner-sort-by">Sort By</label>
                                <br>
                                <input name="banner-sort-by" id="sort-by" id="banner-sort-by" type="number" min="1">
                            </div>
                            <label for="is-visible">Is Visible</label>
                            <div class="form-group" id="is-visible">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="visibility" id="banner-visibility1" value="true" checked>
                                    <label class="form-check-label" for="banner-visibility1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="visibility" id="banner-visibility2" value="false">
                                    <label class="form-check-label" for="banner-visibility2">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="banner-type">Type</label>
                                <select name="type" class="form-control" id="banner-type">
                                    @isset($types)
                                        @foreach($types as $types)
                                            <option value="{{ $types->id }}">{{ $types->name }}</option>    
                                        @endforeach
                                    @endisset  
                                </select>
                            </div>
                            <label for="seller-only">Seller Only</label>
                            <div class="form-group" id="seller-only">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="for-seller" id="banner-for-seller1" value="true" checked>
                                    <label class="form-check-label" for="banner-for-seller1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="for-seller" id="banner-for-seller2" value="false">
                                    <label class="form-check-label" for="banner-for-seller2">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="banner-start-period" class="col-2 col-form-label">Start Period</label>
                                <div class="col">
                                    <input class="form-control" type="date"  id="banner-start-period">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="banner-end-period" class="col-2 col-form-label">End Period</label>
                                <div class="col">
                                    <input class="form-control" type="date"  id="banner-end-period">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 6px">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endslot

        @slot('postfix')
            Banner
        @endslot
    @endcomponent

@endsection