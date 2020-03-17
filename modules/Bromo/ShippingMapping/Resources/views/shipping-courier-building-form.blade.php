@extends('theme::layouts.master')

@section('scripts')
    @include('shippingmapping::js')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Shipping Mapping Building"])
        @slot('body')
            @can('view_shipping_courier_to_building')
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert"></button> 
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h3 class="text-center">Shipping Mapping Building</h3>
                                <br/>

                                <br/>

                                <form action="{{ route('shippingmapping.create-building')}}" method="POST" onSubmit="return confirm('Do you want to submit?')">
                                    {{ csrf_field() }}

                                    <div class="row">
                                        <div class="col-6 form-group bg-white">
                                            <h5><span> Choose Logistic Provider </span></h5> 
                                            <div style="padding: 20px">
                                                <select id="logistic_provider_building" name="logistic_provider_building" class="form-control"></select>
                                            </div>
                                        </div>

                                        <div class="col-6 form-group bg-white">
                                            <h5><span> Choose Building </span></h5> 
                                            <div style="padding: 20px">
                                                <select id="building" name="building" class="form-control"></select>
                                            </div>
                                        </div>
                                    </div>
                                        

                                        <br/>

                                        <div class="form-group d-flex justify-content-center">
                                            <div class="pull-down" style="padding: 5px 10px">
                                                <button type="submit" class="btn btn-success submit" >Submit</button>
                                            </div>
                                        </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        @endslot

        @slot('postfix')
            Shipping Mapping
        @endslot
    @endcomponent

@endsection
