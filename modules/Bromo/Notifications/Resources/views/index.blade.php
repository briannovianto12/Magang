@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        #topic option { color: black; }
        .empty { color: gray; }
    </style>
@endsection

@section('scripts')
    @include('notifications::js')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "News Notification"])
        @slot('body')
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center">
                        <br>
                        @if(session()->has('successMsg'))
                            <div class="alert alert-success">
                                {{ session()->get('successMsg') }}
                            </div>
                            <br>
                        @elseif(session()->has('warningMsg'))
                            <div class="alert alert-warning">
                                {{ session()->get('warningMsg') }}
                            </div>
                            <br>
                        @endif
                        <form method="post" action="{{ route('news.send') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="topic">Topic</label>
                                <select class="form-control" id="topic"  name="topic">
                                    <option value="" disabled selected>Select your option</option>
                                    <option value="GEN002">BUYER ONLY</option>
                                    <option value="GEN001">SELLER ONLY</option>
                                    <option value="GEN003">ALL USERS</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="message-title">Title</label>
                                <input type="text" class="form-control" id="message-title" name="title" placeholder="Enter Message Title">
                            </div>
                            <div class="form-group">
                                <label for="message-body">Body</label>
                                <textarea class="form-control" rows="5" id="message-body" name="body" placeholder="Enter Message Body" maxlength="148">
                                </textarea>                            
                                <span id="chars">148</span> characters remaining
                            </div>

                            <button type="submit" class="btn btn-primary float-right" onclick="return confirm('Are you sure?')" style="border-radius: 6px">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endslot

        @slot('postfix')
            News Notification
        @endslot
    @endcomponent

@endsection
