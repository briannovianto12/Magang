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
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
        
            <div class="container">    
               
                      <br />
                      <div class="row input-daterange">
                          <div class="col-md-4">
                              <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                          </div>
                          <div class="col-md-4">
                              <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                          </div>
                          <div class="col-md-4">
                              <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                              <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                          </div>
                      </div>
                      <br />
             <div class="table-responsive">
              <table class="table table-bordered table-striped" id="shop_log_mutation_table">
                     <thead>
                      <tr>
                        <th>Shop ID</th>
                        <th>Mutation</th>
                        <th>Remark</th>
                        <th>Transaction Type</th>
                      </tr>
                     </thead>
                 </table>
             </div>
            </div>
        </div>
@endsection