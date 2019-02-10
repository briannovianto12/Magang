@if(session()->has('flash_notification'))
    <div class="m-alert m-alert--square alert alert-{{ session()->get('flash_notification.type') }} alert-dismissible fade show"
         role="alert" id="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        </button>
        <strong>{{session()->get('flash_notification.title')}}</strong>
        {!!session()->get('flash_notification.text')!!}
    </div>
@endif
@if(count($errors) > 0)
    <div class="m-alert m-alert--square alert alert-danger alert-dismissible fade show" role="alert" id="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
        <h3 class="m--font-bold">Oh Snap!</h3>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </div>
@endif