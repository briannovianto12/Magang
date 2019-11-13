@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
@endsection

@section('scripts')
    @include('mutation::js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Seller Balance Log"])
        @slot('body')
            @can('view_seller_balance_log')
            <div class="m-portlet__body">
                <div class="container" style="width: 100%">    
                    <div class="row input-daterange">
                        <div class="col-md-3">
                            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="{{ date("Y-m-d", strtotime($start))}}" readonly />
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="{{ date("Y-m-d", strtotime($end))}}" readonly />
                        </div>
                        <div class="col-md-4">
                            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <br>
                        <table class="table table-bordered table-striped" id="shop_log_mutation_table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Shop Name</th>
                                <th>Owner Name</th>
                                <th>Mutation</th>
                                <th>Remark</th>
                                <th>Transaction Type</th>
                                <th>Created At</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endcan        
        @endslot

        @slot('postfix')
            Seller Balance Log
        @endslot
    @endcomponent
    
@endsection