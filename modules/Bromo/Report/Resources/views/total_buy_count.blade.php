@extends('theme::layouts.master')

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Total Buy Count"])
        @slot('body')
            {{-- @can('view_total_buy_count') --}}
                <a href="{{ route('report.total-buy-count.export') }}" class="btn btn-success">Export to .xlsx</a>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12" id="unverified-table">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Buyer Business Name</th>
                                        <th>Total Bought Product</th>
                                        <th>Full Name</th>
                                        <th>Province</th>
                                        <th>City</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($table as $row)
                                    <tr>
                                        <td> {{$row->name }} </td>
                                        <td> {{$row->count }} </td>
                                        <td> {{$row->full_name }} </td>
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