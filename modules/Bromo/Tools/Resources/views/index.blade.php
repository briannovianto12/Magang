@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Tools
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="table table-striped table-bordered table-hover display nowrap" id="report_published" style="width: 100%">
                <thead>
                <tr>
                    <th>Tools</th>
                </tr>
                </thead>
                <tbody>
                    <td>
                        <a href="{{ route('postalCodeFinder.index') }}">
                            Postal Code Finder
                        </a>
                    </td>
                </tbody>
            </table>
        </div>
    </div>

@endsection
