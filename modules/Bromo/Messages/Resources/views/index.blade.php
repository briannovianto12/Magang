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
                              {{ $item->sender_phone }}
                            </td>
                            <td>
                              <strong>{{ $item->receiver }}</strong><br/>
                              {{ $item->receiver_name }} <br/>
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

        @endslot

        @slot('postfix')
            {{ $title }}
        @endslot
    @endcomponent

@endsection