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
    @include('freqaskedquestion::js-edit')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Edit FAQ"])
        @slot('body')
            <div class="row">
                <div class="col-3">
                </div>
                <div class="col-6">
                    <div class="d-flex flex-column justify-content-center">
                        <form action="{{ route('faq.update', $faq->id) }}" method="POST" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="faq-title">Title</label>
                            <input name="title" type="text" class="form-control" id="faq-title" placeholder="Enter title" value="{{ $faq->title }}">
                            </div>
                            <div class="form-group">
                                <label for="faq-question">Question</label>
                                <input name="question" type="text" class="form-control" id="faq-question" placeholder="Enter question" value="{{ $faq->question }}"">
                            </div>
                            <div class="form-group">
                                <label for="faq-answer">Answer</label>
                                <textarea name="answer" class="form-control" id="faq-answer">{{ $faq->answer }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="faq-category">Category</label>
                                <select name="category" class="form-control" id="faq-category">
                                    @isset($categories)
                                        @foreach($categories as $category)
                                            @if($category->id == $faq->faq_category)
                                                <option value="{{ $category->id }}" selected="true">{{ $category->name }}</option>    
                                            @else
                                                <option value="{{ $category->id }}" selected="false">{{ $category->name }}</option>
                                            @endif
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="faq-accessibility">Accessible by</label>
                                <select name="accessibility" class="form-control" id="faq-accessibility">
                                    @if($faq->accessible_by == 1)
                                        <option value=1 selected="true">All</option>
                                    @else
                                        <option value=1 selected="false">All</option>
                                    @endif

                                    @if($faq->accessible_by == 2)
                                        <option value=2 selected="true">Buyer</option>
                                    @else
                                        <option value=2 selected="false">Buyer</option>
                                    @endif

                                    @if($faq->accessible_by == 3)
                                        <option value=3 selected="true">Seller</option>
                                    @else
                                        <option value=3 selected="false">Seller</option>
                                    @endif 
                                </select>
                            </div>
                            <div class="form-group">
                                {!! 
                                    $defaultTags = "";
                                    foreach($faq->tags as $tag){
                                        if($defaultTags == ""){
                                            $defaultTags = $tag;
                                        }
                                        else{
                                            $defaultTags = $defaultTags.', '.$tag;
                                        }
                                    }
                                !!}
                                <label for="faq-tags">Tags</label>
                                <br>
                                <input name='input-tags' id="faq-tags" value="{{ $defaultTags }}">
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
                                @if($faq->is_visible == true)   
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
                                @elseif($faq->is_visible == false)  
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="visibility" id="faq-visibility1" value="true">
                                        <label class="form-check-label" for="faq-visibility1">
                                            Yes
                                        </label>
                                    </div> 
                                    <div class="form-check-inline">
                                        <input class="form-check-input" type="radio" name="visibility" id="faq-visibility2" value="false" checked>
                                        <label class="form-check-label" for="faq-visibility2">
                                            No
                                        </label>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="faq-sort-by">Sort By</label>
                                <br>
                            <input name="sort-by" id="sort-by" id="faq-sort-by" type="number" min="1" value="{{ $faq->sort_by }}">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" style="border-radius: 6px">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        @endslot

        @slot('postfix')
            Frequently Asked Question
        @endslot
    @endcomponent

@endsection