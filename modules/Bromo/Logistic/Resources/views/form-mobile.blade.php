@extends('logistic::layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ nbs_asset('vendors/custom/datatables/datatables.bundle.css') }}">
        <link rel="stylesheet" href="{{ nbs_asset('vendor/fancybox/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ mix('css/logistic.css') }}">
    <style>
        .content, .bg-white {
            background-color: white;
        }
        .field2 {
           display: none;
        }
        .show-review {
            background-color: transparent;
            border: 0px solid;
            height: 20px;
            width: 160px;
            color: black;
        }
    </style>
@endsection


@section('scripts')
    @include('logistic::js-template')
    @include('logistic::js-order-mobile')
    <script src="{{ nbs_asset('js/jasny-bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('div.show').fadeIn();
        })

        function chooseFile() {
           $("#fileInput").click();
        }

        $("input[type='image']").click(function() {
            $("input[id='my_file']").click();
        });
    </script>

    <script type="text/javascript">
        $('.fileupload').fileupload({uploadtype: 'image'});
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="content">
                    <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Rangkuman Order # {{ $order_no }} </span></h5> 
                    <div class="show" style="padding: 10px"> 
                        <address style="padding: 10px">
                            <h5><b> {{ $shop_name }}</h5></b>
                            <span>
                                Ekspedisi: <b style="color:blue">{{ $Ekspedisi }}</b><br/>
                            </span>
                            <span>
                                Nama Penerima: {{ $penerima }}<br/>
                            </span>
                            <span>
                                Alamat Pengiriman: {{ $address_line }}<br/>
                            </span>
                            <span>
                                Gedung: {{ $building_name }}
                            </span>
                        </address>    
                        <br/>
                    </div>
                </div>
                <br/>

                <form action="{{ route('logistic.store', ['id' => $order_id]) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <fieldset class="field1 current">
                        <div class="form-group bg-white">
                            <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Input Berat Paket (Wajib Diisi) </span></h5> 
                            <div style="padding: 20px">
                                <input type="number" min="0" class="form-control" placeholder="Kg" style="padding: 10px" name="weight" id="weight" required/>
                            </div>
                        </div>

                        <div class="form-group bg-white">
                            <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Input Total Harga Pengiriman Paket (Wajib Diisi) </span></h5> 
                            <div style="padding: 20px">
                                <input type="text" min="0" class="number form-control" placeholder="Harga total" style="padding: 10px" name="total_price" id="total_price" required/>
                            </div>
                        </div>

                        <div class="form-group bg-white">
                            <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Input Airwaybill (Opsional) </span></h5> 
                            <div style="padding: 20px">
                                <input type="text" class="form-control" placeholder="No. Resi" style="padding: 10px" name="airwaybill" id="airwaybill"/>
                            </div>
                        </div>

                        <div class="form-group bg-white">
                            <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Upload Foto Paket dan AWB (Wajib Diisi) </span></h5> 
                            <br/>
                            
                            <div style="padding: 20px">
                                Upload Foto Paket:
                                <input type="file" class="form-control" id="file" name="paket_image" required />                        
                            </div>

                            <div style="padding: 20px">
                                Upload Foto Airwaybill:
                                <input type="file" class="form-control" id="file" name="awb_image" required />                        
                            </div>
                        </div>
                        <br/>
                        <div class="form-group d-flex justify-content-center">
                            <div class="pull-down" style="padding: 5px 10px">
                                <button type="button" class="review btn btn-success" value="Review">Lanjutkan</button>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="field2">
                        <div class="content">
                            <h5><span class="badge badge-info" style="display:block; padding: 10px 10px; text-align: left;"> Rangkuman Order # {{ $order_no }} </span></h5> 
                            <div class="show" style="padding: 10px"> 
                                <span>
                                    Berat in <b>Kilogram</b>: <input type="text" class="show-review review-weight" id="weight-review" readonly>
                                </span>
                                <br/>
                                <span>
                                    Harga total: <b>Rp. <input type="text" class="show-review" readonly></b>
                                </span>
                                <br/>
                                <span>
                                    Airwaybill: <input type="text" class="show_airwaybill show-review" readonly>
                                </span>
                                <br/>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group d-flex justify-content-center">
                            <div class="pull-down" style="padding: 5px 10px">
                                <button type="button" name="previous" class="previous btn btn-secondary" >Previous</button>
                            </div>
                            <div class="pull-down" style="padding: 5px 10px">
                                <button type="submit" class="btn btn-success" >Submit</button>
                            </div>
                        </div>

                        <label for="Previous">
                        </label>
                    </fieldset>    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
