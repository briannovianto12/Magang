@extends('theme::layouts.master')

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "List of Seller With Balance"])
        @slot('body')
            <a href="{{ route('seller.export') }}" class="btn btn-success">Export to .xlsx</a>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="unverified-table">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Shop Name</th>
                                    <th>Amount</th>
                                    <th>Bank Code</th>
                                    <th>Bank Account Name</th>
                                    <th>Bank Account Number</th>
                                    <th>Description</th>

                                    <th>Email</th>
                                    <th>Email CC</th>
                                    <th>Email BCC</th>
                                    <th>External Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                <tr>
                                    <td> {{$row->shop_name }} </td>
                                    <td > {{ number_format( $row->amount, 0, 0, '.') }} </td>
                                    <td> {{$row->bank_code }} </td>
                                    <td> {{$row->bank_account_name }} </td>
                                    <td> {{$row->bank_account_number }} </td>
                                    <td> {{$row->description }} </td>
                                    <td> {{$row->email }} </td>
                                    <td> {{$row->email_cc }} </td>
                                    <td> {{$row->email_bcc }} </td>
                                    <td> {{$row->external_id }} </td>
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
            Seller Balance
        @endslot
    @endcomponent

@endsection