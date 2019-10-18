@extends('theme::layouts.master')

@section('css')
@endsection

@section('scripts')
@endsection

@section('content')

    @component('components._portlet',[
          'portlet_head' => true,
          'portlet_title' => "List {$title}"])
        @slot('body')
          <div class="col-6">
            <form action="{{ route('messages.search') }}" method="get">
                {{ method_field('GET') }}
                {{ csrf_field() }}
                <div class="input-group input-group-sm mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Name or Phone Number">
                    <div class="input-group-append">
                      <button id="filter-search-btn" class="btn btn-dark" type="submit">Search</button>
                    </div>
                </div>
            </form>
          </div>
          <br>
            @can('view_messages')
              {{ $results->links() }}
              <table class="table">
                  <thead>
                      <th>Sender</th>
                      <th>Receiver</th>
                      <th>Message</th>
                      <th>Created At</th>
                  </thead>
                  <tbody>
                      @foreach($results as $item)
                          <tr>
                              <td>
                                <strong>{{ $item->sender }}</strong><br/>
                                {{ $item->sender_name }} <br/>
                                @isset($item->sender_shop_name)
                                  <a>shop name: <strong>{{$item->sender_shop_name}}</strong> </a><br/>
                                @endisset
                                {{ $item->sender_phone }}
                              </td>
                              <td>
                                <strong>{{ $item->receiver }}</strong><br/>
                                {{ $item->receiver_name }} <br/>
                                @isset($item->receiver_shop_name)
                                  <a>shop name: <strong>{{$item->receiver_shop_name}}</strong> </a><br/>
                                @endisset
                                {{ $item->receiver_phone }}
                              </td>
                              <td>
                              {!! $item->message !!}
                              </td>
                              <td>
                              {!! $item->time !!}
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
            @endcan
        @endslot

        @slot('postfix')
            {{ $title }}
        @endslot
    @endcomponent

@endsection