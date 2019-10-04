@extends('theme::layouts.master')

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Shop has Product"])
        @slot('body')
            @can('view_shop_with_product')
                <a href="{{ route('report.shop_has_product.export') }}" class="btn btn-success">Export to .xlsx</a>
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
                                        <th>Total Published Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table as $row)
                                    <tr>
                                        <td> {{$row->shop_name }} </td>
                                        <td> {{$row->full_name }} </td>
                                        <td> {{$row->msisdn }} </td>
                                        <td> {{$row->address_line }} </td>
                                        <td> {{$row->count }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $table->links() }}
                        </div>
                    </div>
                </div>
            @endcan
        @endslot
    @endcomponent

@endsection