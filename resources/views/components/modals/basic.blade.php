<!--begin::Modal-->
<div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ $route ?? '#' }}" method="POST">
                {{ csrf_field() }}
                {{ isset($method) ? method_field($method)  : '' }}
                <div class="modal-header">
                    <h5 class="modal-title title">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(is_array($body))
                        @if(isset($body['textarea']))
                            <textarea name="{{ $body['textarea']['name'] }}" id="" cols="30" rows="10" class="form-control"
                                      placeholder="Type here reason..."></textarea>
                        @endif
                    @else
                    {!! $body !!}
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal-->