<form id="form" class="m-form m-form--state" method="POST"
      action="{{ $action }}"{!! isset($isUpload) && $isUpload == true ? ' enctype="multipart/form-data"' : ''!!}>
    {{ isset($method) && $method !== '' ? method_field($method) : '' }}
    {{ csrf_field() }}
    {!! $forms ?? '' !!}

    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-7">
                    {!! $buttons ?? '' !!}
                </div>
            </div>
        </div>
    </div>
</form>