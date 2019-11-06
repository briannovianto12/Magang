@extends('theme::layouts.master')

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Shop with Active Status"])
        @slot('body')
            {{-- @can('view_shop_with_active_status') --}}
                <a href="{{ route('report.shop-with-active-status.export') }}" class="btn btn-success">Export to .xlsx</a>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="unverified-table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Shop Name</th>
                                        <th>Full Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Province</th>
                                        <th>City</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table as $row)
                                    <tr>
                                        <td> {{$row->shop_name }} </td>
                                        <td> {{$row->full_name }} </td>
                                        <td> {{$row->msisdn }} </td>
                                        <td> {{$row->address_line }} </td>
                                        <td> {{$row->province }} </td>
                                        <td> {{$row->city }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $table->links() }}
                        </div>
                    </div>
                </div>
            {{-- @endcan --}}
        @endslot
    @endcomponent

@endsection