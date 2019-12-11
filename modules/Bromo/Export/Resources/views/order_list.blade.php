@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
@endsection

@section('scripts')
    @include('export::js-datepicker')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Export Order List"])
        @slot('body')
            <div class="ml-2 row">
                <form method="GET" action="{{ route('export.order_list_export') }}">
                    <div class="row input-daterange">
                        <div class="col-md-6">
                            <b>Start Date</b>
                            <input type="text" name="from_date" id="from_date" class="form-control" placeholder="{{ date("Y-m-d", strtotime($start)) }}" readonly />
                        </div>
                        <div class="col-md-6">
                            <b>End Date</b>
                            <input type="text" name="to_date" id="to_date" class="form-control" placeholder="{{ date("Y-m-d", strtotime($end)) }}" readonly />
                        </div>
                    </div>
                    <hr>
                    <div class="row order-status-checkbox">
                        <div class="col-md-6">
                            <b>Order Status</b><br>
                            <input type="checkbox" id="order_status_checkAll"> <b>Select All</b> <br>
                            <div class="ml-3">
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="1"> Placed <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="2"> Accepted <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="5"> Payment OK <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="8"> Shipped <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="9"> Delivered <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="10"> Success <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="30"> Canceled <br>
                                <input type="checkbox" class="order_status_checkbox" name="order_status[]" value="31"> Rejected <br>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <b>Payment Status</b><br>
                            <input type="checkbox" id="payment_status_checkAll"> <b>Select All</b> <br>
                            <div class="ml-3">
                                <input type="checkbox" class="payment_status_checkbox" name="payment_status[]" value="1"> Created <br>
                                <input type="checkbox" class="payment_status_checkbox" name="payment_status[]" value="2"> Payment Requested <br>
                                <input type="checkbox" class="payment_status_checkbox" name="payment_status[]" value="3"> Pending <br>
                                <input type="checkbox" class="payment_status_checkbox" name="payment_status[]" value="10"> Success <br>
                                <input type="checkbox" class="payment_status_checkbox" name="payment_status[]" value="20"> Failed <br>
                                <input type="checkbox" class="payment_status_checkbox" name="payment_status[]" value="21"> Canceled <br>
                            </div>
                            <button id="exportOrderListBtn" class="mt-5 btn btn-success">Export to .xlsx</button>
                        </div>
                    </div>
                    <br>
                    
                </form>
            </div>
        @endslot
    @endcomponent

@endsection