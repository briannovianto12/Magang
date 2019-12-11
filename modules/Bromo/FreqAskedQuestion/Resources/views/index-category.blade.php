@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
    @include('freqaskedquestion::js-index-category')
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Frequently Asked Questions Category
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
            <table class="table table-striped table-bordered table-hover display nowrap" id="report_published" style="width: 100%">
                <thead>
                <tr>
                    <th>FAQ - Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($faq_category_list as $faq_category)
                        <tr>
                            <td>{{ $faq_category->name }}</td>
                            <td>
                                <form action="{{ url('/faq-category', ['id' => $faq_category->id]) }}" method="post">
                                    <input class="btn btn-danger" type="submit" value="Delete" />
                                    {!! method_field('delete') !!}
                                    {!! csrf_field() !!}
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
