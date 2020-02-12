@extends('theme::layouts.master')

@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
    <link rel="stylesheet" href="{{ mix('css/mutation.css') }}">
@endsection

@section('scripts')
    @include('mutation::payment-detail-js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
@endsection

@section('content')
    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Uang Masuk"])
        @slot('body')
            @can('view_payment_detail')
            <div class="m-portlet__body">
                <div class="container" style="width: 100%">    

                    <div class="row">
                        <div class="col-6">
                            <form action="{{ route('mutation.payment-detail-view', $shop_id) }}" method="GET" class="form-group" id="formFilter">
                                {{ csrf_field() }}
                                <select style="cursor:pointer;margin-top:1.5em;margin-bottom:1.5em;" class="form-control filter-date" id="month-select" name="month">
                                    <option value={{ $current_month->month }} selected > {{ $current_month->format('F') }} </option>
                                    <option value="01"> Januari</option>
                                    <option value="02"> Februari</option>
                                    <option value="03"> Maret</option>
                                    <option value="04"> April</option>
                                    <option value="05"> Mei</option>
                                    <option value="06"> Juni</option>
                                    <option value="07"> Juli</option>
                                    <option value="08"> Agustus</option>
                                    <option value="09"> September</option>
                                    <option value="10"> Oktober</option>
                                    <option value="11"> November</option>
                                    <option value="12"> Desember</option>
                                </select>
                                
                                <select style="cursor:pointer;" class="form-control filter-date" id="year-select" name="year">
                                    <option value="{{ $end }}" selected >{{ $end }}</option>
                                    @foreach(range($end, $begin) as $y)
                                        <option value={{ $y }}>{{ $y }}</option>
                                    @endforeach
                                </select>
                            </form>
                            <button class="btn btn-default btn-block" type="submit" form="formFilter" value="Submit">Filter</button>
                        </div>
                    </div>

                    <br/><br/>
                    <div>
                        @if(count($response))
                        <table class="fold-table">
                            <thead>
                                <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Catatan</th>
                                <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($response as $index => $data)
                                <tr class="view">
                                <td> {{\Carbon\Carbon::createFromTimestamp($data['datetime'])}} </td>
                                <td>{{ $data['remark']}}</td>
                                <td class="cur">{{ number_format($data['amount'] , 0, ',', '.' ) }}</td>
                                </tr>

                                <tr class="fold">
                                <td colspan="7">
                                    <div class="fold-content">
                                        <table class="color-striped">
                                            @if(count($data['detail_payment']))
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Nama Pembeli</th>
                                                    <th>No. Order</th>
                                                    <th>Kota</th>
                                                    <th>Total Order</th>
                                                </tr>
                                            </thead>
                                            @endif

                                            <tbody>
                                                @forelse($data['detail_payment'] as $index => $data)    
                                                <tr>
                                                    <td> {{\Carbon\Carbon::createFromTimestamp($data['datetime'])}} </td>
                                                    <td>{{ $data['buyer_name'] }}</td>
                                                    <td>{{ $data['order_no'] }}</td>
                                                    <td>{{ $data['city'] }}</td>
                                                    <td class="cur">{{ number_format($data['total_order'] , 0, ',', '.' ) }}</td>
                                                </tr>
                                                @empty
                                                <div>
                                                    <span>Tidak ada detail pembayaran.</span>
                                                </div>
                                                @endforelse
                                            </tbody>
                                        </table>          
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @else
                            <span>Tidak ada data pembayaran pada bulan ini.</span>
                        @endif

                    </div>
                </div>
            </div> 
            @endcan     
        @endslot

        @slot('postfix')
            Uang Masuk
        @endslot
    @endcomponent
    
@endsection
