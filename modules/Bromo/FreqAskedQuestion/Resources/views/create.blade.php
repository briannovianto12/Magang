@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('css/tagify.css') }}" rel="stylesheet">
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="//code.jquery.com/jquery.min.js"></script>
    <script src="{{ nbs_asset('js/jQuery.tagify.min.js') }}"></script>
    <script src="{{ nbs_asset('js/tagify.min.js') }}"></script>
    @include('freqaskedquestion::js-create')
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        New FAQ
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools float-right">
                <a href="{{route("faq.index")}}" class="btn btn-outline-primary btn-sm m-btn m-btn m-btn--icon m-btn--outline-2x">
                    <span>
                        <i class="fa fa-angle-double-left"></i>
                        <span>Back</span>
                    </span>
                </a>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center">
                        <form action="{{ route('faq.store') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="faq-title">Title</label>
                                <input name="title" type="text" class="form-control" id="faq-title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="faq-question">Question</label>
                                <input name="question" type="text" class="form-control" id="faq-question" placeholder="Enter question">
                            </div>
                            <div class="form-group">
                                <label for="faq-answer">Answer</label>
                                <textarea name="answer" class="form-control" id="faq-answer"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="faq-category">Category</label>
                                <select name="category" class="form-control" id="faq-category">
                                    @isset($categories)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>    
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="faq-accessibility">Accessible by</label>
                                <select name="accessibility" class="form-control" id="faq-accessibility">
                                    <option value=1>All</option>
                                    <option value=2>Buyer</option>
                                    <option value=3>Seller</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="faq-tags">Tags</label>
                                <br>
                                <input name='input-tags' id="faq-tags">
                            </div>
                            <div class="form-group">
                                <label for="attachments">Attachments</label>
                                <div class="increment">
                                    <div class="input-group">
                                        <input type="file" name="attachments[]" class="form-control">
                                        <div class="input-group-btn"> 
                                            <button class="btn btn-success btn-add" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                                        </div>
                                    </div>
                                    <div class="attachments-clone">
                                        <div class="clone hide">
                                            <div class="clone-child input-group" style="margin-top:10px">
                                                <input type="file" name="attachments[]" class="form-control">
                                                <div class="input-group-btn"> 
                                                    <button class="btn btn-danger btn-remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    <div>
                                </div>
                            </div>
                            <br>
                            <label for="is-visible">Is Visible</label>
                            <div class="form-group" id="is-visible">
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="visibility" id="faq-visibility1" value="true" checked>
                                    <label class="form-check-label" for="faq-visibility1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <input class="form-check-input" type="radio" name="visibility" id="faq-visibility2" value="false">
                                    <label class="form-check-label" for="faq-visibility2">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="faq-sort-by">Sort By</label>
                                <br>
                                <input name="sort-by" id="sort-by" id="faq-sort-by" type="number" min="1">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 6px">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection