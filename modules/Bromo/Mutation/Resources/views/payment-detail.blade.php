@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
@endsection

@section('scripts')
    @include('mutation::payment-detail-js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Seller Payment Detail"])
        @slot('body')
            @can('view_payment_detail')
            <div class="m-portlet__body">
                <div class="container" style="width: 100%">    
                    <div class="table-responsive">
                        <br>
                        <table class="table table-bordered table-striped" id="shop_list_table" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Shop Name</th>
                                <th>Seller Name</th>
                                <th>Phone No.</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            @endcan        
        @endslot

        @slot('postfix')
            Seller Payment Detail
        @endslot
    @endcomponent
    
@endsection