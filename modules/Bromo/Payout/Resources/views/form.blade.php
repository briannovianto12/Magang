@extends('theme::layouts.master')

@section('css')
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
            /* height: 20px; */
            /* width: 160px; */
            color: black;
        }
    </style>
@endsection

@section('scripts')
    @include('payout::js')
    <script>
        $(document).ready(function () {
            $('div.show').fadeIn();
        })
    </script>
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "Payout"])
        @slot('body')
            @can('view_payout_form')

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert"></button> 
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="card mt-5">
                            <div class="card-body">
                                <h3 class="text-center">Create Payout</h3>
                                <br/>

                                <br/>

                                <form action="{{ route('payout.create')}}" method="POST" onSubmit="return confirm('Do you want to submit?')">
                                    {{ csrf_field() }}
                                    
                                        <div class="form-group bg-white">
                                            <h5><span> Amount </span></h5> 
                                            <div style="padding: 20px">
                                                <input type="text" min="0" class="amount number form-control" placeholder="Amount of Payout" style="padding: 10px" name="amount" id="amount" required/>
                                            </div>
                                        </div>
                                        
                                        <h5><span> Reason </span></h5> 
                                        <div class="form-group bg-white" style="padding: 20px">
                                            <select class="form-control" name="reason" id="reason" size="1" >
                                                @foreach($reason as $item)
                                                    <option value="{!!$item->id!!}">{!!$item->reason!!}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <h5><span> Additional Notes </span></h5> 
                                        <div class="form-group bg-white" style="padding: 20px">
                                            <textarea class="form-control" rows="5" id="additional_notes" name="additional_notes" placeholder="Enter Additional Reason" maxlength="148"></textarea>                            
                                            <span id="chars">148</span> characters remaining
                                        </div>

                                        <div class="form-group bg-white">
                                            <h5><span> Created For </span></h5> 
                                            <div style="padding: 20px">
                                                <select id="created_for" name="created_for" class="form-control"></select>
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
            News Notification
        @endslot
    @endcomponent

@endsection
