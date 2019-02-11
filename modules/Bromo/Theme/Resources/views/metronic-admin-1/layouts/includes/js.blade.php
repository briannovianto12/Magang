<!--begin::Global Theme Bundle -->
<script src="{{ nbs_asset('vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
<script src="{{ nbs_asset('demo/default/base/scripts.bundle.js') }}" type="text/javascript"></script>
<!--end::Global Theme Bundle -->
@yield('scripts')
<script type="text/javascript">
    function imageNotFound(image) {
        $(image).attr('src', '{{ config('image.no_image') }}');
    }

    function before(e) {
        e.addClass('m-loader m-loader--light m-loader--right disabled');
    }

    function after(e) {
        e.removeClass('m-loader m-loader--light m-loader--right disabled');
    }

    function errorResponseHandler(xhr) {

        if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;

            $.each(errors, function (key, value) {
                e = $('<div id="' + key + '-error" class="form-control-feedback">' + value[0] + '</div>');
                e.insertBefore($('#' + key + '_help'));
            });
        }

        if (xhr.status === 500) {
            alert("Internal Server Error");
        }
    }

    function _delete(route) {
        swal({
            title: "Are you sure?",
            type: "question",
            showCancelButton: true,
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: route,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {_method: 'DELETE'},
                    success: function () {
                        window.LaravelDataTables["dataTableBuilder"].table().ajax.reload(null, false);
                        swal(
                            'Deleted!',
                            'Data has been deleted.',
                            'success'
                        )
                    },
                    error: function () {
                        swal(
                            'Oh Snap!',
                            'Look like something wen\'t wrong.',
                            'error'
                        )
                    }
                });
            }
        });
    }

    $(document).ready(function () {
        @if(session()->has('flash_notification.time'))
        $("#alert")
            .fadeTo(parseInt("{{ session()->get('flash_notification.time') }}"), 500)
            .slideUp(500, function () {
                $("#alert").slideUp(500);
            });
        @else
        $("#alert")
            .fadeTo(2000, 500)
            .slideUp(500, function () {
                $("#alert").slideUp(500);
            });
        @endif

        if (window.LaravelDataTables) {
            window.LaravelDataTables["dataTableBuilder"].on('error.dt', function (e, settings, techNote, message) {
                settings.jqXHR.statusText === 'Unauthorized' ? window.location = '{{ url('login') }}' : alert(message);
                return true;
            });
        }

        @if(env('APP_ENV') === 'production')
            $.fn.dataTable.ext.errMode = 'none';
        @endif
    });
</script>