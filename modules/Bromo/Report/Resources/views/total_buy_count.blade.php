@extends('theme::layouts.master')

@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"> --}}
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css"> --}}
@endsection

@section('scripts')
@include('report::js-datepicker')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Total Buy Count"])
        @slot('body')
            {{-- @can('view_total_buy_count') --}}
                <div>
                    <a href="#" id="exportTotalBuy" class="btn btn-success">Export to .xlsx</a>
                    <br/><br/>
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
                </div>
                <div class="container-fluid">
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" data-page-length='50' id="total-count-table">
                                <thead>
                                    <tr>
                                        <th>Buyer Business Name</th>
                                        <th>Total Order Paid</th>
                                        <th>Total Gross</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            {{-- @endcan --}}
  
        @endslot
    @endcomponent

@endsection