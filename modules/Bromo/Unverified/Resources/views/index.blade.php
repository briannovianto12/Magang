@extends('theme::layouts.master')

@section('css')
    <link href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('scripts')
    <script src="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.js') }}"></script>

@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "List of Unverified Seller"])
        @slot('body')
            <a href="{{ url('/') }}/export/xlsx/" class="btn btn-success">Export to .xlsx</a>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="unverified-table">
                        <table class="table table-striped table-bordered table-responsive" style>
                            <thead>
                                <tr>
                                    <th>Shop Name</th>
                                    <th>Description</th>
                                    <th>Building Name</th>
                                    <th>Address Line</th>
                                    <th>MSISDN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td> {{$row->shop_name}} </td>
                                    <td> {{$row->description}} </td>
                                    <td> {{$row->building_name}} </td>
                                    <td> {{$row->address_line}} </td>
                                    <td> {{$row->msisdn}} </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        @endslot

        @slot('postfix')
            Unverified Seller
        @endslot
    @endcomponent

@endsection