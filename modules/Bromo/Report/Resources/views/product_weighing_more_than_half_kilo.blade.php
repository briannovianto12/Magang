@extends('theme::layouts.master')

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Product Weighing more than Half Kilo"])
        @slot('body')
            @can('view_product_over_half_kilo')
                <a href="{{ route('report.product-over-half-kilo.export') }}" class="btn btn-success">Export to .xlsx</a>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="unverified-table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Product Name</th>
                                        <th>Weight</th>
                                        <th>Shop ID</th>
                                        <th>Shop Name</th>
                                        <th>Address</th>
                                        <th>Owner Name</th>
                                        <th>Owner Phone Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table as $row)
                                    <tr>
                                        <td> {{$row->product_id }} </td>
                                        <td> {{$row->product_name }} </td>
                                        <td> {{$row->weight }} </td>
                                        <td> {{$row->shop_id }} </td>
                                        <td> {{$row->shop_name }} </td>
                                        <td> {{$row->address }} </td>
                                        <td> {{$row->owner_name }} </td>
                                        <td> {{$row->owner_phone_number }} </td>
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