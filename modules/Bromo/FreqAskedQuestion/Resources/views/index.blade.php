@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    @include('freqaskedquestion::js')
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Frequently Asked Questions
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            @can('create_faq')
            <button id="new-faq-btn" type="button" class="btn btn-primary mb-3" style="border-radius: 6px">+Add new FAQ</button>
            <button id="new-faq-cat-btn" type="button" class="btn btn-primary mb-3" style="border-radius: 6px">+Add new FAQ Category</button>
            @endcan
            <button id="faq-cat-list-btn" type="button" class="btn btn-primary mb-3" style="border-radius: 6px">FAQ Category List</button>
            <table class="table table-striped table-bordered table-hover display nowrap" id="report_published" style="width: 100%">
                <thead>
                <tr>
                    <th>FAQ - Title</th>
                    <th>Category</th>
                    <th>Accessible By</th>
                    <th>Is Visible</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @isset($faq_list)
                        @foreach($faq_list as $faq)
                            <tr>
                                <td><a href="{{ route('faq.show', $faq->id) }}">{{ $faq->title }}</a></td>
                                <td>{{ $faq->category->name }}</td>
                                <td>{{ $faq->accessibility->name }}</td>
                                <td>
                                    @if($faq->is_visible == true)
                                        <strong class="text-success">True</strong>
                                    @else
                                        <strong class="text-danger">False</strong>
                                    @endif
                                </td>
                                @can('edit_faq')
                                <td>
                                    <form action="{{ url('/faq', ['id' => $faq->id]) }}" method="post">
                                        <input class="btn btn-danger" type="submit" value="Delete" />
                                        {!! method_field('delete') !!}
                                        {!! csrf_field() !!}
                                    </form>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </div>
    </div>

@endsection
